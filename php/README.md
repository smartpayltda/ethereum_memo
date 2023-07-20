# Requirements

- [Composer](https://getcomposer.org/ "Composer")
- php-gmp extention
- php-mbstring extention
- php-bcmath extention
- php-curl extention

# Install (*NIX cli)

- Clone the repro
`git clone https://github.com/smartpayltda/ethereum_memo`
- Enter php directory
`cd ethereum_memo/php`
- Install dependencies
`composer install`

# Setup
- Copy .env.example to .env
`cp .env.example .env`
- Edit .env and set senders address and privatekey
```bash
SENDER_PRIVKEY=00000000000000000000000000000000000000000000000000
SENDER_ADDRESS=0x0000000000000000000000000000000000000
```

# Send coins with memo (MATIC, ETH, BNB, etc ...)
- Edit send_coin_with_memo.php
```php
// VARS
const NODE_RPC = "https://rpc.ankr.com/polygon"; // RPC Endpoint, we use ankr
const RECIEVER = "0x00000000000000000000000000000000000000"; // coin reciever
const AMOUNT = "1.23"; // amount to send
const MEMO = "MY MEMO DEMO"; // memo to send
```
- run the script
`php send_coin_with_memo.php`

# Send token (ERC20) with memo (USDT in this example)
- Edit send_token_with_memo.php
```php
// VARS
const NODE_RPC = "https://rpc.ankr.com/polygon"; // RPC Endpoint, we use ankr
const CHAIN_ID = 0x89; // polygon mainnet
const RECIEVER = "0x000000000000000000000000000000000000"; // coin reciever
const CONTRACT = "0xc2132d05d31c914a87c6611c10748aeb04b58e8f"; // token contract, usdt in this case
const AMOUNT = "1"; // amount to send (STRING!!)
const DECIMALS = "6"; // Decimals of the token, usdt has 6
const MEMO = "MY MEMO DEMO"; // memo to send
```
- run the script
`php send_token_with_memo.php`
