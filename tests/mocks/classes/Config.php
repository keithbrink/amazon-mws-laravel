<?php

/**
 * Simple Laravel Config mock class.
 */
class Config
{
    public static function get($name)
    {
        if ($name == 'no') {
            return [];
        }
        $fakeConfig = [
            'amazon-mws.store'   => [
                'testStore' => [
                    'merchantId'       => 'ABC_MARKET_1234',
                    'marketplaceId'    => 'ABC3456789456',
                    'keyId'            => 'key',
                    'secretKey'        => 'secret',
                    'amazonServiceUrl' => 'http://foo.bar',
                    'muteLog'          => false,
                ],
                'bad' => [
                    'merchantId'       => '',
                    'marketplaceId'    => '',
                    'keyId'            => '',
                    'secretKey'        => '',
                    'amazonServiceUrl' => '',
                    'muteLog'          => false,
                ],
            ],
        ];

        return (isset($fakeConfig[$name])) ? $fakeConfig[$name] : null;
    }
}
