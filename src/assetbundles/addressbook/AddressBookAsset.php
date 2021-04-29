<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Address book tool (Craft Commerce)
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbook\assetbundles\addressbook;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 */
class AddressBookAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@ournameismud/addressbook/assetbundles/addressbook/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/AddressBook.js',
        ];

        $this->css = [
            'css/AddressBook.css',
        ];

        parent::init();
    }
}
