<?php declare(strict_types=1);
namespace InteractivePlus\PDK2021CoreTest;

use InteractivePlus\PDK2021Core\Base\DataOperations\MultipleResult;
use InteractivePlus\PDK2021Core\Base\Formats\IPFormat;
use PHPUnit\Framework\TestCase;

final class OverallTest extends TestCase{
    public function testCanConstructMultipleResult() : void{
        $Result = new MultipleResult(1,array('Test'),1,0);
        $this->assertEquals(1,$Result->getNumResultsStored(),MultipleResult::class . ' class returns a wrong total result number');
        $this->assertEquals('Test',$Result->getResultArray()[0],MultipleResult::class . ' class returns a wrong result array');
    }
    public function testIPV4AddressMatch() : void{
        $IP = '203.137.194.36';
        $this->assertTrue(IPFormat::isIP($IP));
        $this->assertTrue(IPFormat::isIPV4($IP));
        $this->assertFalse(IPFormat::isIPV6($IP));
    }
    public function testIPV6AdressMatch() : void{
        $IP = '2001:db8:130F:0000:0000:09C0:876A:130B';
        $compressedIP = '2001:db8:130F:0:0:9C0:876A:130B';
        $this->assertTrue(IPFormat::isIP($IP));
        $this->assertTrue(IPFormat::isIPV6($IP));
        $this->assertFalse(IPFormat::isIPV4($IP));
        $this->assertTrue(IPFormat::isIP($compressedIP));
        $this->assertTrue(IPFormat::isIPV6($compressedIP));
        $this->assertFalse(IPFormat::isIPV4($compressedIP));
    }
}