<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use DeliveryController;
use mysqli;
use mysqli_stmt;
use mysqli_result;

class DeliveryControllerTest extends TestCase {
    private $deliveryController;
    private $mockDb;

    protected function setUp(): void {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->mockDb = $this->createMock(mysqli::class);
        $GLOBALS['con'] = $this->mockDb;

        $this->deliveryController = new DeliveryController();
    }

    public function testAssignDriverSuccess(): void {
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Mock valid result object and successful execution
        $resultMock = $this->createMock(mysqli_result::class);
        $resultMock->method('fetch_assoc')->willReturn(['delivery_driver_id' => null]);

        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('get_result')->willReturn($resultMock);

        $this->mockDb->method('prepare')->willReturn($stmtMock);

        $result = $this->deliveryController->assignDriver(1, 2);

        $this->assertTrue($result['success']);
        $this->assertEquals("Driver assigned successfully, and driver's daily quota updated.", $result['message']);
    }

    public function testAssignDriverDriverUnavailable(): void {
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Simulate `get_result()` returning false (database error)
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('get_result')->willReturn(false);

        $this->mockDb->method('prepare')->willReturn($stmtMock);

        $result = $this->deliveryController->assignDriver(1, 3);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString("Failed to fetch delivery details.", $result['message']);
    }

    public function testAssignDriverDeliveryIdNotFound(): void {
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Simulate `fetch_assoc()` returning null (delivery ID not found)
        $resultMock = $this->createMock(mysqli_result::class);
        $resultMock->method('fetch_assoc')->willReturn(null);

        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('get_result')->willReturn($resultMock);

        $this->mockDb->method('prepare')->willReturn($stmtMock);

        $result = $this->deliveryController->assignDriver(9999, 2);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString("Delivery not found", $result['message']);
    }

    protected function tearDown(): void {
        unset($this->deliveryController);
        unset($GLOBALS['con']);
    }
}
