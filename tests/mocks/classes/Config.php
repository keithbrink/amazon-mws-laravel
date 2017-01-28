<?php

/**
 * Simple Laravel Config mock class
 *
 */

class Config
{
    static function get($name)
    {
        $fakeConfig = [
            'amazon-mws.muteLog' => 'Info',
            'amazon-mws.AMAZON_SERVICE_URL' => 'http://foo.bar',
            'amazon-mws.store' => [
                'testStore' => [
                    'merchantId' => 'ABC_MARKET_1234',
                    'marketplaceId' => 'ABC3456789456',
                    'keyId' => 'key',
                    'secretkey' => 'secret',
                ],
            ],
        ];

        return (isset($fakeConfig[$name])) ? $fakeConfig[$name] : null;
    }
}