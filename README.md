# Printcart Design for Magento 2

## How to install & upgrade Printcart_Design

### 1. Install via composer (recommend)

We recommend you to install Printcart_Design module via composer. It is easy to install, update and maintaince.

Run the following command in Magento 2 root folder.

#### 1.1 Install

```
composer require printcart/magento-connect
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

#### 1.2 Upgrade

```
composer update printcart/magento-connect
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

Run compile if your store in Product mode:

```
php bin/magento setup:di:compile
```

### 2. Copy and paste

If you don't want to install via composer, you can use this way. 

- Download [the latest version here](https://github.com/Printcart/magento-connect/archive/main.zip) 
- Extract `main.zip` file to `app/code/Printcart/Design` ; You should create a folder path `app/code/Printcart/Design` if not exist.
- Go to Magento root folder and run upgrade command line to install `Printcart_Design`:

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```
