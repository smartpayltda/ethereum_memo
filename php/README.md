# Requirements

- [Composer](https://getcomposer.org/ "Composer")
- php-gmp extention
- php-mbstring extention
- php-bcmath extention

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


