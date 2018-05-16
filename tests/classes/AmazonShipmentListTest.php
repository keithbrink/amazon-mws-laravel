<?php

use KeithBrink\AmazonMws\AmazonShipmentList;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonShipmentListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AmazonShipmentList
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        resetLog();
        $this->object = new AmazonShipmentList('testStore', true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testSetUseToken()
    {
        $this->assertNull($this->object->setUseToken());
        $this->assertNull($this->object->setUseToken(true));
        $this->assertNull($this->object->setUseToken(false));
        $this->assertFalse($this->object->setUseToken('wrong'));
    }

    public function testSetStatusFilter()
    {
        $this->assertNull($this->object->setStatusFilter(['404', '808']));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ShipmentStatusList.member.1', $o);
        $this->assertEquals('404', $o['ShipmentStatusList.member.1']);
        $this->assertArrayHasKey('ShipmentStatusList.member.2', $o);
        $this->assertEquals('808', $o['ShipmentStatusList.member.2']);

        $this->assertNull($this->object->setStatusFilter('808')); //causes reset
        $o2 = $this->object->getOptions();
        $this->assertArrayNotHasKey('ShipmentStatusList.member.2', $o2);

        $this->assertFalse($this->object->setStatusFilter(null));
        $this->assertFalse($this->object->setStatusFilter(707));
    }

    public function testSetIdFilter()
    {
        $this->assertNull($this->object->setIdFilter(['404', '808']));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ShipmentIdList.member.1', $o);
        $this->assertEquals('404', $o['ShipmentIdList.member.1']);
        $this->assertArrayHasKey('ShipmentIdList.member.2', $o);
        $this->assertEquals('808', $o['ShipmentIdList.member.2']);

        $this->assertNull($this->object->setIdFilter('808')); //causes reset
        $o2 = $this->object->getOptions();
        $this->assertArrayNotHasKey('ShipmentIdList.member.2', $o2);

        $this->assertFalse($this->object->setIdFilter(null));
        $this->assertFalse($this->object->setIdFilter(707));
    }

    /**
     * @return array
     */
    public function timeProvider()
    {
        return [
            [null, null], //nothing given, so no change
            [true, true], //not strings or numbers
            ['', ''], //strings, but empty
            ['-1 min', null], //one set
            [null, '-1 min'], //other set
            ['-1 min', '-1 min'], //both set
        ];
    }

    /**
     * @dataProvider timeProvider
     */
    public function testSetTimeLimits($a, $b)
    {
        $this->object->setTimeLimits($a, $b);
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('LastUpdatedAfter', $o);
        $this->assertStringMatchesFormat('%d-%d-%dT%d:%d:%d%i', $o['LastUpdatedAfter']);
        $this->assertArrayHasKey('LastUpdatedBefore', $o);
        $this->assertStringMatchesFormat('%d-%d-%dT%d:%d:%d%i', $o['LastUpdatedBefore']);
    }

    public function testResetTimeLimit()
    {
        $this->object->setTimeLimits('-1 min', '-1 min');
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('LastUpdatedAfter', $o);
        $this->assertArrayHasKey('LastUpdatedBefore', $o);

        $this->object->resetTimeLimits();
        $check = $this->object->getOptions();
        $this->assertArrayNotHasKey('LastUpdatedAfter', $check);
        $this->assertArrayNotHasKey('LastUpdatedBefore', $check);
    }

    public function testFetchShipments()
    {
        resetLog();
        $this->object->setMock(true, 'fetchShipments.xml'); //no token
        $this->assertFalse($this->object->fetchShipments()); //no filter yet

        $this->object->setStatusFilter('status');
        $this->assertNull($this->object->fetchShipments());

        $o = $this->object->getOptions();
        $this->assertEquals('ListInboundShipments', $o['Action']);

        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchShipments.xml', $check[1]);
        $this->assertEquals('Either status filter or ID filter must be set before requesting a list!', $check[2]);

        $this->assertFalse($this->object->hasToken());

        return $this->object;
    }

    public function testFetchShipmentsToken1()
    {
        resetLog();
        $this->object->setMock(true, 'fetchShipmentsToken.xml'); //no token

        //without using token
        $this->object->setStatusFilter('status');
        $this->assertNull($this->object->fetchShipments());
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchShipmentsToken.xml', $check[1]);

        $this->assertTrue($this->object->hasToken());
        $o = $this->object->getOptions();
        $this->assertEquals('ListInboundShipments', $o['Action']);
        $r = $this->object->getShipment();
        $this->assertArrayHasKey(0, $r);
        $this->assertEquals(1, count($r));
        $this->assertInternalType('array', $r[0]);
        $this->assertArrayNotHasKey(1, $r);
    }

    public function testFetchShipmentsToken2()
    {
        resetLog();
        $this->object->setMock(true, ['fetchShipmentsToken.xml', 'fetchShipmentsToken2.xml']);

        //with using token
        $this->object->setUseToken();
        $this->object->setStatusFilter('status');
        $this->assertNull($this->object->fetchShipments());
        $check = parseLog();
        $this->assertEquals('Mock files array set.', $check[1]);
        $this->assertEquals('Recursively fetching more shipments', $check[3]);
        $this->assertFalse($this->object->hasToken());
        $o = $this->object->getOptions();
        $this->assertEquals('ListInboundShipmentsByNextToken', $o['Action']);
        $r = $this->object->getShipment();
        $this->assertArrayHasKey(0, $r);
        $this->assertArrayHasKey(1, $r);
        $this->assertEquals(2, count($r));
        $this->assertInternalType('array', $r[0]);
        $this->assertInternalType('array', $r[1]);
        $this->assertNotEquals($r[0], $r[1]);
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetShipmentId($o)
    {
        $this->assertEquals('FBA44JV8R', $o->getShipmentId(0));

        $this->assertFalse($o->getShipmentId('wrong')); //not number
        $this->assertFalse($o->getShipmentId(1.5)); //no decimals
        $this->assertFalse($this->object->getShipmentId()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetShipmentName($o)
    {
        $this->assertEquals('FBA (11/8/10 5:34 PM)', $o->getShipmentName(0));

        $this->assertFalse($o->getShipmentName('wrong')); //not number
        $this->assertFalse($o->getShipmentName(1.5)); //no decimals
        $this->assertFalse($this->object->getShipmentName()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetAddress($o)
    {
        $a = [];
        $a['Name'] = 'John Smith';
        $a['AddressLine1'] = '2345 3rd Ave';
        $a['AddressLine2'] = null;
        $a['City'] = 'Seattle';
        $a['DistrictOrCounty'] = null;
        $a['StateOrProvinceCode'] = 'WA';
        $a['CountryCode'] = 'US';
        $a['PostalCode'] = '98109';
        $this->assertEquals($a, $o->getAddress(0));

        $this->assertFalse($o->getAddress('wrong')); //not number
        $this->assertFalse($o->getAddress(1.5)); //no decimals
        $this->assertFalse($this->object->getAddress()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetDestinationFulfillmentCenterId($o)
    {
        $this->assertEquals('PHX3', $o->getDestinationFulfillmentCenterId(0));

        $this->assertFalse($o->getDestinationFulfillmentCenterId('wrong')); //not number
        $this->assertFalse($o->getDestinationFulfillmentCenterId(1.5)); //no decimals
        $this->assertFalse($this->object->getDestinationFulfillmentCenterId()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetLabelPrepType($o)
    {
        $this->assertEquals('AMAZON_LABEL', $o->getLabelPrepType(0));

        $this->assertFalse($o->getLabelPrepType('wrong')); //not number
        $this->assertFalse($o->getLabelPrepType(1.5)); //no decimals
        $this->assertFalse($this->object->getLabelPrepType()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetShipmentStatus($o)
    {
        $this->assertEquals('CLOSED', $o->getShipmentStatus(0));

        $this->assertFalse($o->getShipmentStatus('wrong')); //not number
        $this->assertFalse($o->getShipmentStatus(1.5)); //no decimals
        $this->assertFalse($this->object->getShipmentStatus()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetIfCasesRequired($o)
    {
        $this->assertEquals('false', $o->getIfCasesRequired(0));

        $this->assertFalse($o->getIfCasesRequired('wrong')); //not number
        $this->assertFalse($o->getIfCasesRequired(1.5)); //no decimals
        $this->assertFalse($this->object->getIfCasesRequired()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testGetShipment($o)
    {
        $shipment = $o->getShipment(0);
        $this->assertInternalType('array', $shipment);

        $list = $o->getShipment(null);
        $this->assertInternalType('array', $list);
        $this->assertArrayHasKey(0, $list);
        $this->assertArrayHasKey(1, $list);
        $this->assertEquals($shipment, $list[0]);

        $default = $o->getShipment();
        $this->assertEquals($list, $default);

        $x = [];
        $x1 = [];
        $x1['ShipmentId'] = 'FBA44JV8R';
        $x1['ShipmentName'] = 'FBA (11/8/10 5:34 PM)';
        $a1 = [];
        $a1['Name'] = 'John Smith';
        $a1['AddressLine1'] = '2345 3rd Ave';
        $a1['AddressLine2'] = null;
        $a1['City'] = 'Seattle';
        $a1['DistrictOrCounty'] = null;
        $a1['StateOrProvinceCode'] = 'WA';
        $a1['CountryCode'] = 'US';
        $a1['PostalCode'] = '98109';
        $x1['ShipFromAddress'] = $a1;
        $x1['DestinationFulfillmentCenterId'] = 'PHX3';
        $x1['LabelPrepType'] = 'AMAZON_LABEL';
        $x1['ShipmentStatus'] = 'CLOSED';
        $x1['AreCasesRequired'] = 'false';
        $x[0] = $x1;
        $x2 = [];
        $x2['ShipmentId'] = 'FBA4X8YLS';
        $x2['ShipmentName'] = 'FBA (1/19/11 4:08 PM)';
        $a2 = $a1;
        $a2['AddressLine2'] = 'Apt 401';
        $a2['DistrictOrCounty'] = 'Box';
        $x2['ShipFromAddress'] = $a2;
        $x2['DestinationFulfillmentCenterId'] = 'PHX6';
        $x2['LabelPrepType'] = 'AMAZON_LABEL';
        $x2['ShipmentStatus'] = 'WORKING';
        $x2['AreCasesRequired'] = 'true';
        $x[1] = $x2;

        $this->assertEquals($x, $list);

        $this->assertFalse($this->object->getShipment()); //not fetched yet for this object
    }

    /**
     * @depends testFetchShipments
     */
    public function testFetchItems($o)
    {
        $o->setMock(true, ['fetchShipmentItems.xml']);

        $x = [];
        $x1 = [];
        $x1['ShipmentId'] = 'SSF85DGIZZ3OF1';
        $x1['SellerSKU'] = 'SampleSKU1';
        $x1['QuantityShipped'] = '3';
        $x1['QuantityInCase'] = '0';
        $x1['QuantityReceived'] = '0';
        $x1['FulfillmentNetworkSKU'] = 'B000FADVPQ';
        $x[0] = $x1;
        $x2 = [];
        $x2['ShipmentId'] = 'SSF85DGIZZ3OF1';
        $x2['SellerSKU'] = 'SampleSKU2';
        $x2['QuantityShipped'] = '10';
        $x2['QuantityInCase'] = '0';
        $x2['QuantityReceived'] = '0';
        $x2['FulfillmentNetworkSKU'] = 'B0011VECH4';
        $x[1] = $x2;

        $getAll = $o->fetchItems();
        $getOne = $o->fetchItems(0);

        $this->assertEquals($x, $getAll[0]->getItems());
        $this->assertEquals($getAll[0], $getOne);

        $this->assertFalse($o->fetchItems('banana')); //not valid index
        $this->assertFalse($o->fetchItems(1.5)); //not valid index
        $this->assertFalse($this->object->fetchItems()); //not fetched yet for this object
    }
}

require_once __DIR__.'/../helperFunctions.php';
