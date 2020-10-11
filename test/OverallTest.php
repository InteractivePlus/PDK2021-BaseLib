<?php declare(strict_types=1);

use InteractivePlus\PDK2021Base\DataOperations\MultipleResult;
use PHPUnit\Framework\TestCase;

final class OverallTest extends TestCase{
    public function testCanConstructMultipleResult() : void{
        $Result = new MultipleResult(1,array('Test'));
        $this->assertEquals(1,$Result->getNumResults(),MultipleResult::class . ' class returns a wrong total result number');
        $this->assertEquals('Test',$Result->getResultArray()[0],MultipleResult::class . ' class returns a wrong result array');
    }
}