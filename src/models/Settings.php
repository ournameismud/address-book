<?php
/**
 * Address Book plugin for Craft CMS 3.x
 *
 * Address book tool (Craft Commerce)
 *
 * @link      ournameismud.co.uk
 * @copyright Copyright (c) 2021 @cole007
 */

namespace ournameismud\addressbook\models;

use ournameismud\addressbook\AddressBook;

use Craft;
use craft\base\Model;
use craft\validators\ArrayValidator;

/**
 * @author    @cole007
 * @package   AddressBook
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $fields;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'fields'
                ],
                ArrayValidator::class
            ],
        ];
    }
}
