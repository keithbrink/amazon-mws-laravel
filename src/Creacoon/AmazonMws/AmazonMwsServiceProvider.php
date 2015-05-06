<?php namespace Creacoon\AmazonMws;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AmazonMwsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	public function boot()
	{
		$this->package('creacoon/amazon-mws');
		AliasLoader::getInstance()->alias('AmazonFeed', 'Creacoon\AmazonMws\AmazonFeed');
		AliasLoader::getInstance()->alias('AmazonFeedList', 'Creacoon\AmazonMws\AmazonFeedList');
		AliasLoader::getInstance()->alias('AmazonFeedResult', 'Creacoon\AmazonMws\AmazonFeedResult');
		AliasLoader::getInstance()->alias('AmazonFulfillmentOrder', 'Creacoon\AmazonMws\AmazonFulfillmentOrder');
		AliasLoader::getInstance()->alias('AmazonFulfillmentOrderCreator', 'Creacoon\AmazonMws\AmazonFulfillmentOrderCreator');
		AliasLoader::getInstance()->alias('AmazonFulfillmentOrderList', 'Creacoon\AmazonMws\AmazonFulfillmentOrderList');
		AliasLoader::getInstance()->alias('AmazonFulfillmentPreview', 'Creacoon\AmazonMws\AmazonFulfillmentPreview');
		AliasLoader::getInstance()->alias('AmazonInventoryList', 'Creacoon\AmazonMws\AmazonInventoryList');
		AliasLoader::getInstance()->alias('AmazonOrder', 'Creacoon\AmazonMws\AmazonOrder');
		AliasLoader::getInstance()->alias('AmazonOrderItemList', 'Creacoon\AmazonMws\AmazonOrderItemList');
		AliasLoader::getInstance()->alias('AmazonOrderList', 'Creacoon\AmazonMws\AmazonOrderList');
		AliasLoader::getInstance()->alias('AmazonOrderSet', 'Creacoon\AmazonMws\AmazonOrderSet');
		AliasLoader::getInstance()->alias('AmazonPackageTracker', 'Creacoon\AmazonMws\AmazonPackageTracker');
		AliasLoader::getInstance()->alias('AmazonParticipationList', 'Creacoon\AmazonMws\AmazonParticipationList');
		AliasLoader::getInstance()->alias('AmazonProduct', 'Creacoon\AmazonMws\AmazonProduct');
		AliasLoader::getInstance()->alias('AmazonProductInfo', 'Creacoon\AmazonMws\AmazonProductInfo');
		AliasLoader::getInstance()->alias('AmazonProductList', 'Creacoon\AmazonMws\AmazonProductList');
		AliasLoader::getInstance()->alias('AmazonProductSearch', 'Creacoon\AmazonMws\AmazonProductSearch');
		AliasLoader::getInstance()->alias('AmazonReport', 'Creacoon\AmazonMws\AmazonReport');
		AliasLoader::getInstance()->alias('AmazonReportAcknowledger', 'Creacoon\AmazonMws\AmazonReportAcknowledger');
		AliasLoader::getInstance()->alias('AmazonReportList', 'Creacoon\AmazonMws\AmazonReportList');
		AliasLoader::getInstance()->alias('AmazonReportRequest', 'Creacoon\AmazonMws\AmazonReportRequest');
		AliasLoader::getInstance()->alias('AmazonReportRequestList', 'Creacoon\AmazonMws\AmazonReportRequestList');
		AliasLoader::getInstance()->alias('AmazonReportScheduleList', 'Creacoon\AmazonMws\AmazonReportScheduleList');
		AliasLoader::getInstance()->alias('AmazonReportScheduleManager', 'Creacoon\AmazonMws\AmazonReportScheduleManager');
		AliasLoader::getInstance()->alias('AmazonServiceStatus', 'Creacoon\AmazonMws\AmazonServiceStatus');
		AliasLoader::getInstance()->alias('AmazonShipment', 'Creacoon\AmazonMws\AmazonShipment');
		AliasLoader::getInstance()->alias('AmazonShipmentItemList', 'Creacoon\AmazonMws\AmazonShipmentItemList');
		AliasLoader::getInstance()->alias('AmazonShipmentList', 'Creacoon\AmazonMws\AmazonShipmentList');
		AliasLoader::getInstance()->alias('AmazonShipmentPlanner', 'Creacoon\AmazonMws\AmazonShipmentPlanner');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
