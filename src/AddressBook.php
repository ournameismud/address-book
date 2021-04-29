<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Plugin to manage customer addresses independently of Craft Commerce
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbook;

use ournameismud\addressbook\models\Settings;
use ournameismud\addressbook\services\Addresses as AddressesService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class AddressBook
 *
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 *
 * @property  AddressesService $addresses
 */
class AddressBook extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var AddressBook
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );


        \yii\base\Event::on(
            \craft\web\View::class,
            \craft\web\View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(\craft\events\RegisterTemplateRootsEvent $event) {
                $event->roots['address-book'] = __DIR__ . '/templates';
            }
        );
        // /vendor/craftcms/commerce/src/templates/customers/_edit.html
        // cp.commerce.customers.edit
        Craft::$app->getView()->hook('cp.commerce.customers.edit.details', function(array &$context) {
            $templatePath = 'address-book/_components/hooks/customer';
            $html = Craft::$app->view->renderTemplate(
                $templatePath, $context, Craft::$app->view::TEMPLATE_MODE_SITE
            );
            return $html;
        });


        // custom add customer address template
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['commerce/address/add/<customerId:\d+>'] = 'address-book/address/add';
            }
        );

        Craft::info(
            Craft::t(
                'address-book',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {

        $fields = AddressBook::$plugin->addresses->getFields();

        return Craft::$app->view->renderTemplate(
            'address-book/settings',
            [
                'settings' => $this->getSettings(),
                // MudModule::$instance->MudModuleService->_log
                'fields' => $fields
            ]
        );
    }
}
