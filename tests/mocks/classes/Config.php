<?php

/**
 * Simple Laravel Config mock class
 *
 */

class Config
{
    static function get($name)
    {
        if($name == 'no') {
            return [];
        }
        $fakeConfig = [
            'amazon-mws.muteLog' => false,
            'amazon-mws.store' => [
                'testStore' => [
                    'merchantId' => 'ABC_MARKET_1234',
                    'marketplaceId' => 'ABC3456789456',
                    'keyId' => 'key',
                    'secretKey' => 'secret',
                    'amazonServiceUrl' => 'http://foo.bar',
                ],
                'bad' => [
                    'merchantId' => '',
                    'marketplaceId' => '',
                    'keyId' => '',
                    'secretKey' => '',
                    'amazonServiceUrl' => '',
                ],
            ],
        ];

        return (isset($fakeConfig[$name])) ? $fakeConfig[$name] : null;
    }
}