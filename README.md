[![Build Status](https://travis-ci.org/keithbrink/amazon-mws-laravel.svg?branch=master)](https://travis-ci.org/keithbrink/amazon-mws-laravel) [![StyleCI](https://styleci.io/repos/133599197/shield?branch=master)](https://styleci.io/repos/133599197)

# Amazon MWS for Laravel
============

A Laravel package to connect to Amazon's Merchant Web Services (MWS).

If you are using Laravel 6 or lower, use version 5.0. On Laravel 7, use version 7.0+.

This is __NOT__ for Amazon Web Services (AWS) - Cloud Computing Services.

## Installation

Install the package using `composer require keithbrink/amazon-mws-laravel`.

For Laravel 5.5 and up, the package will be automatically discovered. For other versions, you can add `KeithBrink\AmazonMws\MwsServiceProvider` to your `config/app.php` file.

Run `php artisan vendor:publish keithbrink/amazon-mws-laravel` to add the `amazon-mws.php` config file to your config directory.

## Usage

The general work flow for using one of the objects is this:

1. Create an object for the task you need to perform.
2. Load it up with parameters, depending on the object, using *set____* methods.
3. Submit the request to Amazon. The methods to do this are usually named *fetch____* or *submit____* and have no parameters.
4. Reference the returned data, whether as single values or in bulk, using *get____* methods.
5. Monitor the performance of the library using the built-in logging system.

Note that if you want to act on more than one Amazon store, you will need a separate object for each store.

Also note that the objects perform best when they are not treated as reusable. Otherwise, you may end up grabbing old response data if a new request fails.

If you want to learn how to use a specific function, the best way is to read the comments above the function; they are detailed and helpful.

## Dynamic Config

If you would like to change the configuration info used in an Amazon call to something other than the info in the config file, you can add the `setConfig($config)` function to any call. The `$config` parameter should be an array following this template:

```php
$config = [
    'merchantId' => '',
    'marketplaceId' => '',
    'keyId' => '',
    'secretKey' => '',
    'amazonServiceUrl' => '',
];
```

## Example Usage

Here are a couple of examples of the library in use.

Here is an example of a function used to get all warehouse-fulfilled orders from Amazon updated in the past 24 hours:
```php
use KeithBrink\AmazonMws\AmazonOrderList;

function getAmazonOrders() {
    $amz = new AmazonOrderList("myStore"); //store name matches the array key in the config file
    $amz->setLimits('Modified', "- 24 hours");
    $amz->setFulfillmentChannelFilter("MFN"); //no Amazon-fulfilled orders
    $amz->setOrderStatusFilter(
        array("Unshipped", "PartiallyShipped", "Canceled", "Unfulfillable")
        ); //no shipped or pending
    $amz->setUseToken(); //Amazon sends orders 100 at a time, but we want them all
    $amz->fetchOrders();
    return $amz->getList();
}
```
This example shows a function used to send a previously-created XML feed to Amazon to update Inventory numbers, and includes an example of a dynamic config:
```php
use KeithBrink\AmazonMws\AmazonFeed;

function sendInventoryFeed($feed) {
    $config = [
        'merchantId' => '',
        'marketplaceId' => '',
        'keyId' => '',
        'secretKey' => '',
        'amazonServiceUrl' => '',
    ];

    $amz = new AmazonFeed("myStore"); //store name matches the array key in the config file
    $amz->setConfig($config);
    $amz->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
    $amz->setFeedContent($feed);
    $amz->submitFeed();
    return $amz->getResponse();
}
```

## Credits
This package was forked from:
https://github.com/sonnenglas/amazon-mws-laravel

which was forked from:
https://github.com/creacoon/amazon-mws-laravel

which was forked from:
https://github.com/CPIGroup/phpAmazonMWS

who is the original creator of this package.
