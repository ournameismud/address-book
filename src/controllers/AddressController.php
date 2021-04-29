<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Plugin to manage customer addresses independently of Craft Commerce
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbook\controllers;

use ournameismud\addressbook\AddressBook;

use Craft;
use craft\web\Controller;

use craft\commerce\Plugin AS Commerce;
use craft\commerce\models\Customer;
use craft\commerce\models\Address;
use craft\commerce\records\Address as AddressRecord;
use craft\commerce\records\CustomerAddress;

/**
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 */
class AddressController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    // protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    public function arraySearch($array, $field, $search){
        foreach($array as $key => $value){
            if ($value[$field] === $search)
                return $key;
        }
        return false;
    }
    public function actionSaveAddress() {

        $this->requirePostRequest();
        // To do: ensure admin
        $request = Craft::$app->getRequest();

        $customerId = $request->post('customerId');
        $address = $request->post('address');

        $fieldsSrc = AddressBook::$plugin->addresses->getFields();
        $settings = AddressBook::$plugin->getSettings();
        $fields = $settings->fields;

        if (!$customerId) {
            Craft::$app->getSession()->setError(Craft::t('address-book', 'No Customer Id was specified!'));
            Craft::$app->getUrlManager()->setRouteParams([
                'variables' => ['address' => $address]
            ]);
            return null;
        }

        $customerService = Commerce::getInstance()->getCustomers();
        $customer = $customerService->getCustomerById($customerId);

        if (!$customer) {
            Craft::$app->getSession()->setError(Craft::t('address-book', 'No Customer found!'));
            Craft::$app->getUrlManager()->setRouteParams([
                'variables' => ['address' => $address]
            ]);
            return null;
        }

        // To do: check required fields against plugin settings

        $newAddress = new Address();
        $errors = [];
        foreach ($address AS $key => $value) {
            if (array_key_exists($key, $fields)) {
                if ($fields[$key]['requireField'] == '1' && $value == '') {
                    $src = $this->arraySearch($fieldsSrc, 'name', $key);
                    $label = $fieldsSrc[$src]['label'];
                    $errors[$key] = $label;
                }
            }
            $newAddress->$key = $value;
        }
        if ($errors) {
            Craft::$app->getSession()->setError(Craft::t('address-book', 'Following fields are required: ' . implode(',', $errors)));
            Craft::$app->getUrlManager()->setRouteParams([
                'variables' => ['address' => $address, 'errors' => $errors ]
            ]);
            return null;
        }

        $customerService->saveAddress($newAddress, $customer, false);

        $primaryBillingAddressId = $request->post('primaryBillingAddressId');
        $primaryShippingAddressId = $request->post('primaryShippingAddressId');

        $saveCustomer = false;
        if ($primaryBillingAddressId == '1') {
            $customer->primaryBillingAddressId = $newAddress->id;
            $saveCustomer = true;
        }
        if ($primaryShippingAddressId == '1') {
            $customer->primaryShippingAddressId = $newAddress->id;
            $saveCustomer = true;
        }

        if ($saveCustomer == true) {
            $customerService->saveCustomer($customer);
        }

        Craft::$app->getSession()->setNotice( 'Customer Address added' );
        $this->redirectToPostedUrl();
    }
    public function actionAdd($customerId) {
        $variables = [];
        $customer = Commerce::getInstance()->getCustomers()->getCustomerById((int)$customerId);
        $variables['customer'] = $customer;

        $settings = AddressBook::$plugin->getSettings();

        $fields = AddressBook::$plugin->addresses->getFields();

        $variables['fields'] = $fields;
        $variables['settings'] = $settings->fields;

        return $this->renderTemplate('address-book/addresses', $variables);
    }
}
