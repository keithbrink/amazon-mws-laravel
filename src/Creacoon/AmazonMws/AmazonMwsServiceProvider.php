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
		$configPath = __DIR__ . '/../../config/amazon-mws.php';
		$this->mergeConfigFrom($configPath, 'amazon-mws');
        
		$this->app->alias('AmazonOrderList', 'Creacoon\AmazonMws\AmazonOrderList');
		$this->app->alias('AmazonOrderItemList', 'Creacoon\AmazonMws\AmazonOrderItemList');
	}

	public function boot()
	{
		$configPath = __DIR__ . '/../../config/amazon-mws.php';
       	$this->publishes([$configPath => config_path('amazon-mws.php')], 'config');
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
