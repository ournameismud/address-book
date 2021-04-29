<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Plugin to manage customer addresses independently of Craft Commerce 
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbook\assetbundles\addressescpsection;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 */
class AddressesCPSectionAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@ournameismud/addressbook/assetbundles/addressescpsection/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Addresses.js',
        ];

        $this->css = [
            'css/Addresses.css',
        ];

        parent::init();
    }
}
