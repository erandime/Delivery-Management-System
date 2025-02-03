<?php
require __DIR__ . '/../../vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\NoSuchAlertException;

class DriverAssignmentTest {
    private $driver;

    public function setUp(): void {
        $this->driver = RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()
        );

        // Step 1: Log in to the system
        $this->driver->get('http://localhost/PhpProject1/01_src/view/login.php');
        $this->driver->findElement(WebDriverBy::id('username'))->sendKeys('oliver@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('oliver123');
        $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'))->click();

        // Wait for homepage to load after login
        sleep(2);

        // Step 2: Navigate to the delivery page through the navbar
        $navDeliveryLink = $this->driver->findElement(WebDriverBy::cssSelector('a.nav-link[href="../view/delivery.php"]'));
        $navDeliveryLink->click();

        // Wait for the delivery page to load
        sleep(3);
    }

    public function testDriverAssignmentWorkflow(): void {
        // Step 3: Locate the row with "Ready to Dispatch" status
        $deliveryRow = $this->driver->findElement(
            WebDriverBy::xpath('//tr[td[contains(text(), "Ready to Dispatch")]]')
        );

        // Step 4: Retrieve all available options in the dropdown
        $driverDropdown = $deliveryRow->findElement(WebDriverBy::cssSelector('.driver-dropdown'));
        $options = $driverDropdown->findElements(WebDriverBy::tagName('option'));

        if (count($options) <= 1) {
            throw new Exception("No available drivers found in the dropdown.");
        }

        // Step 5: Randomly select a driver from the options (excluding the first empty/default option)
        $randomIndex = rand(1, count($options) - 1);
        $randomDriverOption = $options[$randomIndex];
        $randomDriverId = $randomDriverOption->getAttribute('value');
        echo "Selected random driver ID: " . $randomDriverId . "\n";

        // Step 6: Select the random driver option
        $randomDriverOption->click();

        // Step 7: Click the "Save" button
        $saveButton = $deliveryRow->findElement(WebDriverBy::cssSelector('.save-driver'));
        $saveButton->click();

        // Step 8: Wait for the alert and handle it
        try {
            $this->driver->wait(5)->until(WebDriverExpectedCondition::alertIsPresent());

            $alert = $this->driver->switchTo()->alert();
            $alertText = $alert->getText();
            echo "Alert text: " . $alertText . "\n";
            $alert->accept();  // Accept the alert to continue
        } catch (NoSuchAlertException $e) {
            echo "No alert found.\n";
        }

        // Step 9: Verify that the status has been updated to "Driver Assigned"
        sleep(2);  // Give time for AJAX to complete and update the status
        $updatedStatus = $deliveryRow->findElement(WebDriverBy::cssSelector('.status-column'))->getText();
        assert($updatedStatus === 'Driver Assigned', "Expected status 'Driver Assigned', but found '$updatedStatus'");

        echo "Test Passed: Driver assignment workflow completed successfully with updated status.\n";
    }

    public function tearDown(): void {
        $this->driver->quit();
    }
}

// Run the test
$test = new DriverAssignmentTest();
$test->setUp();
$test->testDriverAssignmentWorkflow();
$test->tearDown();
