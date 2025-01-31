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

        // Mock the database connection
        $this->mockDb = $this->createMock(mysqli::class);
        $GLOBALS['con'] = $this->mockDb;

        // Initialize the DeliveryController
        $this->deliveryController = new DeliveryController();
    }

    public function testAssignDriverSuccess(): void {
        // Create a mock statement object
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Mock a valid result object with no currently assigned driver
        $resultMock = $this->createMock(mysqli_result::class);
        $resultMock->method('fetch_assoc')->willReturn(['delivery_driver_id' => null]);

        // Simulate successful statement execution and return of results
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('get_result')->willReturn($resultMock);

        // Mock the database to return the prepared statement
        $this->mockDb->method('prepare')->willReturn($stmtMock);

        // Act: Call the method under test
        $result = $this->deliveryController->assignDriver(1, 2);

        // Assert: Verify the expected success response
        $this->assertTrue($result['success']);
        $this->assertEquals("Driver assigned successfully, and driver's daily quota updated.", $result['message']);
    }

    protected function tearDown(): void {
        unset($this->deliveryController);
        unset($GLOBALS['con']);
    }
}
