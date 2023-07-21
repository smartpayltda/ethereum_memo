#!/usr/bin/env -S /usr/bin/node
const { Web3 } = require("web3");
const fs = require("fs");
const decimal = require("decimal.js");

const RPCUrl = "https://rpc.ankr.com/polygon";
const httpProvider = new Web3.providers.HttpProvider(RPCUrl);
const web3 = new Web3(httpProvider);

decimal.precision = 50;
decimal.toExpNeg = -20;

main(); //wrapper cuz async

async function main() {
  // unify
  let from = "0xFROMADDRESS".toLowerCase(); // from address
  let tokencontract = "0xc2132d05d31c914a87c6611c10748aeb04b58e8f"; // contract address (usdt)
  let to = "0xTOADDRESS".toLowerCase(); // token contract address
  let privkey = "0xFROMADDRESS_PRIVATEKEY"; // from address privkey
  let decimals = "6"; // decimals of the token (usdt has 6)
  let gas = "80000"; // gas limit, 80k for usdt
  let amount = "1"; // amount
  let memo = "memo demo"; // my memo
  let abifile = "abi_erc20.json"; // file with contract abi in json format

  // send to self?
  if (from == to) {
    console.log("Can't send to self.");
    process.exit(1);
  }

  // address valid?
  if (!web3.utils.isAddress(from) || !web3.utils.isAddress(to)) {
    console.log("Sender or target address invalid!");
    process.exit(1);
  }

  // set private key
  web3.eth.accounts.wallet.add(privkey);

  // prepare the package
  decimal.set({ toExpPos: 50 });
  let sendamount = decimal.mul(amount, "1e" + decimals).toString();

  // gas price
  const gasprice = await web3.eth.getGasPrice();
  let gasamount = "21000";
  if (memo != "") {
    gasamount = decimal.add(
      gasamount,
      decimal.add("128", decimal.mul("20", memo.length + 5)),
    ).toString();
  }

  // prepare memo
  if (memo != "") memo = makeMemo(memo);

  // prepare contract and ABI
  var abi;
  try {
    const jabi = fs.readFileSync(abifile, { encoding: "utf8", flag: "r" });
    abi = JSON.parse(jabi);
  } catch (e) {
    console.log(e);
    process.exit(1);
  }
  const contract = new web3.eth.Contract(abi, tokencontract, {
    from,
    gas: Number(gas),
  });

  // prepare txdata
  const encoded = contract.methods.transfer(to, sendamount).encodeABI() + memo;
  txData = {
    from,
    to: tokencontract,
    value: "0x0",
    gas: Number(gas),
    gasPrice: gasprice,
    data: encoded,
  };
  console.log(txData);

  // send tx
  try {
    var TX = await web3.eth.sendTransaction(txData);
  } catch (e) {
    console.log(e);
    console.log(e.message.replace(/(\r\n|\n|\r)/gm, ""));
    process.exit(1);
  }
  if (!TX) {
    console.log("No txid, no idea.");
    process.exit(1);
  }
  console.log(TX.transactionHash);
}

function makeMemo(memo) {
  memo = web3.utils.utf8ToHex("MEMO:" + memo).slice(2);
  const pad = 64 - memo.length % 64;
  memo += "0".repeat(pad);
  return memo;
}
