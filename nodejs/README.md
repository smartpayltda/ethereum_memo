# Requirements

- [NPM](https://www.npmjs.com/ "NPM")

# Install (*NIX cli)

- Clone the repro
`git clone https://github.com/smartpayltda/ethereum_memo`
- Enter nodejs directory
`cd ethereum_memo/nodejs`
- Install dependencies
`npm install`

# Send coins with memo (MATIC, ETH, BNB, etc ...)
- Edit send_coin_with_memo.js
```javascript
  // unify
  let from = "0xFROMADDRESS".toLowerCase(); // from address
  let to = "0xTOADDRESS".toLowerCase(); // to address
  let privkey = "0xPRIVATEKEY_FROM_FROMADDRESS"; // from address privkey
  let amount = "1"; // amount
  let memo = "memo demo"; // my memo
```
- run the script
`node send_coin_with_memo.js`

# Send token (ERC20) with memo (USDT in this example)
- Edit send_token_with_memo.js
```javascript
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
```
- run the script
`node send_token_with_memo.js`
