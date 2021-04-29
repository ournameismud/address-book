<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Plugin to manage customer addresses independently of Craft Commerce
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbook\services;

use ournameismud\addressbook\AddressBook;

use Craft;
use craft\base\Component;

use craft\commerce\Plugin AS Commerce;
use craft\commerce\models\Customer;

/**
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 */
class Addresses extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */

    public function getFields()
    {
        $states = Commerce::getInstance()->getStates()->getAllEnabledStatesAsList();
        $countries = Commerce::getInstance()->getCountries()->getAllEnabledCountriesAsList();
        // to do check model for names
        // use translate in settings field
        // use tranlsate in address field
        $fields = array(
            array('name'=>'attention','label'=>'Attention','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'title','label'=>'Title','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'firstName','label'=>'First Name','type'=>'text','limit'=>null,'required'=>true),
            array('name'=>'lastName','label'=>'Last Name','type'=>'text','limit'=>null,'required'=>true),
            array('name'=>'fullName','label'=>'Full Name','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'address1','label'=>'Street Address','type'=>'text','limit'=>null,'required'=>true),
            array('name'=>'address2','label'=>'Street Address 2','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'city','label'=>'City','type'=>'text','limit'=>null,'required'=>true),
            array('name'=>'stateId','label'=>'County/Region','type'=>'dropdown','limit'=>null,'required'=>true,'options'=>$states),
            array('name'=>'zipCode','label'=>'Postcode','type'=>'text','limit'=>null,'required'=>true),
            array('name'=>'countryId','label'=>'Country','type'=>'dropdown','limit'=>null,'required'=>true,'options'=>$countries),
            array('name'=>'phone','label'=>'Contact Phone','type'=>'text','limit'=>null,'required'=>true),
            array('name'=>'alternativePhone','label'=>'Alternative Phone','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'label','label'=>'Label','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'notes','label'=>'Notes','type'=>'textarea','limit'=>null,'required'=>false),
            array('name'=>'businessName','label'=>'Business Name','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'businessTaxId','label'=>'Business Tax ID','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'businessId','label'=>'Business ID','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'custom1','label'=>'Custom 1','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'custom2','label'=>'Custom 2','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'custom3','label'=>'Custom 3','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'custom4','label'=>'Custom 4','type'=>'text','limit'=>null,'required'=>false),
            array('name'=>'primaryBillingAddressId','label'=>'Primary Billing Address','type'=>'checkbox','limit'=>null,'required'=>false),
            array('name'=>'primaryShippingAddressId','label'=>'Primary Shipping Address','type'=>'checkbox','limit'=>null,'required'=>false),

        );

        return $fields;
    }
}
