<h3>INTEGRATING Flutterwave v3 with CODEIGNITER 4</h3>

From Flutterwave's v3 PHP SDK on https://github.com/Flutterwave/PHP, you can start by installing library using composer.

$ composer require flutterwavedev/flutterwave-v3


Then go ahead to configure extra fields  (PUBLIC_KEY, SECRET_KEY, ENV) in your .env file as below.

PUBLIC_KEY="****YOUR**PUBLIC**KEY****" // can be gotten from the dashboard<br />
SECRET_KEY="****YOUR**SECRET**KEY****" // can be gotten from the dashboard<br />
ENCRYPTION_KEY="Encryption key" <br />
ENV="development/production" <br />


Then go ahead to place the files below in their respective directories as per CodeIgniter4 file structure

- .env
- Payments.php
- TransactionsModel.php
- Views (index.php and success_page.php)

NOTE: 

* Ensure you have setup your flutterwave account from www.flutterwave.com
* You can modify the function(s) as much as you can or even make it better for usage for others.

