<?php

require_once "vendor/autoload.php";
require_once "helper.php";
use SWeb3\SWeb3;
use SWeb3\Utils;
use SWeb3\ABI;

// VARS
const NODE_RPC = "https://rpc.ankr.com/polygon"; // RPC Endpoint, we use ankr
const CHAIN_ID = 0x89; // polygon mainnet
const RECIEVER = "0x000000000000000000000000000000000000"; // coin reciever
const CONTRACT = "0xc2132d05d31c914a87c6611c10748aeb04b58e8f"; // token contract, usdt in this case
const AMOUNT = "1"; // amount to send (STRING!!)
const DECIMALS = "6"; // Decimals of the token, usdt has 6
const MEMO = "MY MEMO DEMO"; // memo to send

// Import .env file
if (!importEnv()) {
    print("Error importing .env file");
    exit(1);
}

// get ABI from file
$jabi = getAbi();
if($jabi===false){
	print("Error reading abi file");
	exit(1);
}

// create abi object
$ABI = new ABI();
$ABI->Init($jabi);

//initialize SWeb3 main object
$web3 = new SWeb3(NODE_RPC);
$web3->chainId = CHAIN_ID;

// set sender
$fromAccount = $_ENV['SENDER_ADDRESS'];
$fromPrivKey = $_ENV['SENDER_PRIVKEY'];
;
$web3->setPersonalData($fromAccount, $fromPrivKey);

// convert amount
$amount = bcmul(AMOUNT,bcpow(10,DECIMALS));

// create payload
$edata = $ABI->EncodeData('transfer', [RECIEVER, $amount]);

// create tx
$txData = [
    'from' =>       $web3->personal->address,
    'to' =>         CONTRACT,
    'value' =>         "0x0",
    'nonce' =>         $web3->personal->getNonce(),
    'data' =>          $edata . makeMemo(MEMO)
];

// calculate gas
$gasEstimate = $web3->call('eth_estimateGas', [$txData]);
if (isset($gasEstimate->error)) {
    die("Error getting gas: " . $gasEstimate->error->message);
}
$txData['gasLimit'] = $gasEstimate->result;

// sign and broadcast
$tx = $web3->send($txData);

// print result
print("Txid: " . $tx->result);
