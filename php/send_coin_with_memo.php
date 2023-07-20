<?php

require_once "vendor/autoload.php";
require_once "helper.php";
use SWeb3\SWeb3;
use SWeb3\Utils;

// VARS
const NODE_RPC = "https://rpc.ankr.com/polygon"; // RPC Endpoint, we use ankr
const RECIEVER = "0x000000000000000000000000000000000000"; // coin reciever
const AMOUNT = "0.01"; // amount to send (STRING!!)
const MEMO = "MY MEMO DEMO"; // memo to send

// Import .env file
if (!importEnv()) {
    print("Error importing .env file");
    exit(1);
}

//initialize SWeb3 main object
$web3 = new SWeb3(NODE_RPC);
$web3->chainId = 0x89;     // polygon mainnet

// set sender
$fromAccount = $_ENV['SENDER_ADDRESS'];
$fromPrivKey = $_ENV['SENDER_PRIVKEY'];
;
$web3->setPersonalData($fromAccount, $fromPrivKey);

// create tx
$txData = [
    'from' =>       $web3->personal->address,
    'to' =>         RECIEVER,
    'value' =>         Utils::toWei(AMOUNT, 'ether'),
    'nonce' =>         $web3->personal->getNonce(),
    'data' =>          makeMemo(MEMO)
];

// memo requires more gas
$gasEstimate = $web3->call('eth_estimateGas', [$txData]);
if (isset($gasEstimate->error)) {
    die("Error getting gas: " . $gasEstimate->error->message);
}
$txData['gasLimit'] = $gasEstimate->result;

// sign and broadcast
$tx = $web3->send($txData);

// print result
print("Txid: " . $tx->result);
