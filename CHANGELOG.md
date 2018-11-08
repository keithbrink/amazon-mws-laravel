# CHANGELOG

### 2018-07-25 - Version 3.0.4

- added `setMarketPlaceId()` to AmazonFulfillmentOrderCreator class

### 2018-07-24 - Version 3.0.3

- [[PR #11](https://github.com/sonnenglas/amazon-mws-laravel/pull/11/)] added all missing order / orderitem fields that were declared in the API spec
- [[PR #8](https://github.com/sonnenglas/amazon-mws-laravel/pull/8/)] added `authToken` to configuration file. MWSAuthToken is used to make requests on behalf of other amazon users
- [[PR #7](https://github.com/sonnenglas/amazon-mws-laravel/pull/7/)] Backported Financial APIs from https://github.com/CPIGroup/phpAmazonMWS