<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Plugin to manage customer addresses independently of Craft Commerce 
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbooktests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use ournameismud\addressbook\AddressBook;

/**
 * ExampleUnitTest
 *
 *
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            AddressBook::class,
            AddressBook::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
