<?php
// References:
// https://github.com/facebook/php-webdriver/
// https://github.com/facebook/php-webdriver/wiki/Example-command-reference
// https://seleniumhq.github.io/selenium/docs/api/java/org/openqa/selenium/remote/RemoteWebDriver.html
class basic_test extends PHPUnit_Framework_TestCase {

    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

    /**
    * url of the web app
    */
    protected $url = 'http://localhost:8888/Pantry/index.php';

    /**
    * Sets up the fixture by setting the host and web driver.
    * This method is called before a test is executed.
    */
    public function setUp() {
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::firefox());
        $this->webDriver->get($this->url);
        $this->webDriver->manage()->window()->maximize();
    }

    /**
    * Test login functionality for unregistered users.
    * Verify that the user is still on the landing page.
    */
    public function testUnsuccessfulLogIn() {
        // checking that page title contains word 'Pantry'
        $this->assertEquals('Pantry', $this->webDriver->getTitle());
        // find log in button by its id
        $loginDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log In'));
        $loginDropdown->click();
        // fill in test usernamea and password
        $loginUsername = $this->webDriver->findElement(WebDriverBy::id('logInUsername'));
        $loginPassword = $this->webDriver->findElement(WebDriverBy::id('logInPassword'));
        $loginUsername->sendKeys('thisUsernameDoesNotExist');
        $loginPassword->sendKeys('thisPasswordDoesNotExist');
        // press login button
        $loginButton = $this->webDriver->findElement(WebDriverBy::id('log-in-button'));
        $loginButton->click();
        // checking to make sure we see the invalid credentials warning
        $this->assertContains('Invalid login credentials!', $this->webDriver->getPageSource());
        // checking url to make sure we are still on the landing page
        $this->assertContains('index.php', $this->webDriver->getCurrentURL());
    }

    /**
    * Test login functionality for registered users.
    * Verify that the user sees the pantry page.
    */
    public function testSuccessfulLogIn() {
        // checking that page title contains word 'Pantry'
        $this->assertEquals('Pantry', $this->webDriver->getTitle());
        // find log in button by its id
        $loginDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log In'));
        $loginDropdown->click();
        // fill in test usernamea and password
        $loginUsername = $this->webDriver->findElement(WebDriverBy::id('logInUsername'));
        $loginPassword = $this->webDriver->findElement(WebDriverBy::id('logInPassword'));
        $loginUsername->sendKeys('test');
        $loginPassword->sendKeys('test');
        // press login button
        $loginButton = $this->webDriver->findElement(WebDriverBy::id('log-in-button'));
        $loginButton->click();
        $this->webDriver->manage()->timeouts()->implicitlyWait(4);
        // checking url to make sure we are on the pantry page
        $this->assertContains('pantry.php', $this->webDriver->getCurrentURL());
        // checking that page contains 'Recently Expired' and 'In Pantry'
        $this->assertContains('Recently Expired', $this->webDriver->getPageSource());
        $this->assertContains('In Pantry', $this->webDriver->getPageSource());
    }

    /**
    * Test logout functionality.
    * First log in, then log out. Verify user is redirected back to the landing page.
    */
    public function testLogOut() {
        // find log in button by its id
        $loginDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log In'));
        $loginDropdown->click();
        // fill in test usernamea and password
        $loginUsername = $this->webDriver->findElement(WebDriverBy::id('logInUsername'));
        $loginPassword = $this->webDriver->findElement(WebDriverBy::id('logInPassword'));
        $loginUsername->sendKeys('test');
        $loginPassword->sendKeys('test');
        // press login button
        $loginButton = $this->webDriver->findElement(WebDriverBy::id('log-in-button'));
        $loginButton->click();
        // checking that the Log Out link is displayed
        $this->assertContains('Log Out', $this->webDriver->getPageSource());
        // find log in button by its id
        $logoutDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log Out'));
        $logoutDropdown->click();
        // checking that we are on the landing page
        $this->assertContains('index.php', $this->webDriver->getCurrentURL());
        $this->assertContains('About Pantry', $this->webDriver->getPageSource());
    }

    /**
    * Test account registration functionality.
    * Verify user is redirected back to the landing page.
    * Verify that user can login with new credentials.
    */
    public function testAccountRegistration() {
        // find sign up button by its id
        $signupDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Sign Up'));
        $signupDropdown->click();
        // checking that we are on the registration page
        $this->assertContains('sign_up.php', $this->webDriver->getCurrentURL());
        $this->assertContains('Create a new account', $this->webDriver->getPageSource());
        // fill in user info
        $signupEmail = $this->webDriver->findElement(WebDriverBy::id('sign-up-email'));
        $signupUsername = $this->webDriver->findElement(WebDriverBy::id('sign-up-username'));
        $signupPassword = $this->webDriver->findElement(WebDriverBy::id('sign-up-password'));
        $signupEmail->sendKeys('user1@test.com');
        $signupUsername->sendKeys('user1');
        $signupPassword->sendKeys('password1');
        // press register button
        $signupButton = $this->webDriver->findElement(WebDriverBy::id('sign-up-button'));
        $signupButton->click();
        // checking that registration was successful
        $this->assertContains('Your account was created successfully!', $this->webDriver->getPageSource());
        // wait for at most 10 seconds until the URL is 'http://.../Pantry/index.php'.
        // check again 500ms after the previous attempt.
        $this->webDriver->wait(10, 500)->until(function () {
            return (strpos($this->webDriver->getCurrentURL(),'index.php') !== false);
        });
        // checking that we have been redirected to the landing page
        $this->assertContains('index.php', $this->webDriver->getCurrentURL());
        $this->assertContains('About Pantry', $this->webDriver->getPageSource());
        // try to log in with new credentials
        // find log in button by its id
        $loginDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log In'));
        $loginDropdown->click();
        // fill in test usernamea and password
        $loginUsername = $this->webDriver->findElement(WebDriverBy::id('logInUsername'));
        $loginPassword = $this->webDriver->findElement(WebDriverBy::id('logInPassword'));
        $loginUsername->sendKeys('user1');
        $loginPassword->sendKeys('password1');
        // press login button
        $loginButton = $this->webDriver->findElement(WebDriverBy::id('log-in-button'));
        $loginButton->click();
        // checking url to make sure we are on the pantry page
        $this->assertContains('pantry.php', $this->webDriver->getCurrentURL());
        // checking that page contains 'Recently Expired' and 'In Pantry'
        $this->assertContains('Recently Expired', $this->webDriver->getPageSource());
        $this->assertContains('In Pantry', $this->webDriver->getPageSource());
    }

    /**
    * Test functionality for adding a new food item.
    * Verify that the user can see the item info when clicked.
    */
    public function testAddItem() {
        // find log in button by its id
        $loginDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log In'));
        $loginDropdown->click();
        // fill in test usernamea and password
        $loginUsername = $this->webDriver->findElement(WebDriverBy::id('logInUsername'));
        $loginPassword = $this->webDriver->findElement(WebDriverBy::id('logInPassword'));
        $loginUsername->sendKeys('test');
        $loginPassword->sendKeys('test');
        // press login button
        $loginButton = $this->webDriver->findElement(WebDriverBy::id('log-in-button'));
        $loginButton->click();
        // press add item button
        $addItemButton = $this->webDriver->findElement(WebDriverBy::id('add-item'));
        $addItemButton->click();
        // checking modal window shows up
        $itemAddModal = $this->webDriver->findElement(WebDriverBy::id('add-item-modal'));
        $this->assertNotEquals($itemAddModal->getCSSValue('display'), 'none');
        $this->assertContains('Add an item', $this->webDriver->getPageSource());
        // press enter manually button
        $this->webDriver->findElement(WebDriverBy::id('btn-enter-common'))->click();
        // fill in item info
        $egg = $this->webDriver->findElement(WebDriverBy::xpath('//button[@title="Egg Whites"]'));
        $egg->click();
        $milk = $this->webDriver->findElement(WebDriverBy::xpath('//label[contains(., "Milk")]/..'));
        $milk->click();
        // press continue button
        $continueButton = $this->webDriver->findElement(WebDriverBy::xpath('//button[contains(.,"Continue")]'));
        $continueButton->click();
        $quantity = $this->webDriver->findElement(WebDriverBy::id('quantity-input'));
        $quantity->clear();
        $quantity->sendKeys('3');
        $expirationDate = $this->webDriver->findElement(WebDriverBy::id('bs-datepicker'));
        $expirationDate->sendKeys('06/01/2015');
        // press submit button
        $submitButton = $this->webDriver->findElement(WebDriverBy::id('btn-submit'));
        $submitButton->click();
        // checking that new item circle is created
        $this->webDriver->manage()->timeouts()->implicitlyWait(4);
        // click on new item and verify info
        $newItem = $this->webDriver->findElement(WebDriverBy::xpath('//div[contains(@class, "egg-whites")]'));
        $newItem->click();
        $this->webDriver->manage()->timeouts()->implicitlyWait(4);
        // checking modal window appeared with input values
        $itemModal = $this->webDriver->findElement(WebDriverBy::id('view-item-modal'));
        $this->assertNotEquals($itemModal->getCSSValue('display'), 'none');
        $itemExpirationDateView = $this->webDriver->findElement(WebDriverBy::id('item-expiration-date-view'));
        $this->assertEquals($itemExpirationDateView->getText(), '2015-06-01');
        $itemQuantityView = $this->webDriver->findElement(WebDriverBy::id('item-quantity-view'));
        $this->assertEquals($itemQuantityView->getText(), '3');
        $itemCategoriesView = $this->webDriver->findElement(WebDriverBy::id('item-categories-view'));
        $this->assertEquals($itemCategoriesView->getText(), 'Dairy');
        $itemStorageEnvView = $this->webDriver->findElement(WebDriverBy::id('item-storage-env-view'));
        $this->assertEquals($itemStorageEnvView->getText(), 'test_env');
    }

    /**
    * Test functionality for adding a new storage environment.
    * Verify that the user can see the new environment info when clicked.
    */
    public function testAddEnvironment() {
        // find log in button by its id
        $loginDropdown = $this->webDriver->findElement(WebDriverBy::linkText('Log In'));
        $loginDropdown->click();
        // fill in test usernamea and password
        $loginUsername = $this->webDriver->findElement(WebDriverBy::id('logInUsername'));
        $loginPassword = $this->webDriver->findElement(WebDriverBy::id('logInPassword'));
        $loginUsername->sendKeys('test');
        $loginPassword->sendKeys('test');
        // press login button
        $loginButton = $this->webDriver->findElement(WebDriverBy::id('log-in-button'));
        $loginButton->click();
        // checking that the storage environments link is displayed
        $this->assertContains('Storage Environments', $this->webDriver->getPageSource());
        // navigate to the storage environments page
        $storageEnvironments = $this->webDriver->findElement(WebDriverBy::linkText('Storage Environments'));
        $storageEnvironments->click();
        // checking url to make sure we are on the storage environments page
        $this->assertContains('environment.php', $this->webDriver->getCurrentURL());
        // add a new storage environment
        // click add storage button
        $addStorageButton = $this->webDriver->findElement(WebDriverBy::id('add-item'));
        $addStorageButton->click();
        // checking modal window shows up
        $envAddModal = $this->webDriver->findElement(WebDriverBy::id('add-storage-modal'));
        $this->assertNotEquals($envAddModal->getCSSValue('display'), 'none');
        $this->assertContains('Add Storage Environment', $this->webDriver->getPageSource());
        // fill in storage environment info
        $storageName = $this->webDriver->findElement(WebDriverBy::id('storage-name'));
        $storageTemp = $this->webDriver->findElement(WebDriverBy::id('storage-temp'));
        $storageTemp->clear();
        $storageName->sendKeys('new_test_environment');
        $storageTemp->sendKeys('30');
        // press submit button
        $submitButton = $this->webDriver->findElement(WebDriverBy::id('btn-submit'));
        $submitButton->click();
        // checking that new environment circle is created
        $this->webDriver->manage()->timeouts()->implicitlyWait(4);
        $this->assertContains('new_test_environment', $this->webDriver->getPageSource());
        // refresh page
        $this->webDriver->navigate()->refresh();
        // click on new environment and verify info
        $newEnv = $this->webDriver->findElement(WebDriverBy::xpath('//span[contains(., "new_test_environment")]/..'));
        $newEnv->click();
        // checking modal window appeared with temperature value
        $envInfoModal = $this->webDriver->findElement(WebDriverBy::id('view-storage-modal'));
        $this->assertNotEquals($envInfoModal->getCSSValue('display'), 'none');
        $storageTempView = $this->webDriver->findElement(WebDriverBy::id('storage-temp-view'));
        $this->assertEquals($storageTempView->getText(), '30');
    }

    /**
    * Tears down the fixture by closing the browser.
    * This method is called after a test is executed.
    */
    public function tearDown() {
        $this->webDriver->close();
    }

}
?>