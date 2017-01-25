<?php namespace Octoshop\AddressBook\Components;

use Auth;
use Event;
use Lang;
use Octoshop\AddressBook\Models\Address;
use Octoshop\Core\Components\ComponentBase;

class AddressPicker extends ComponentBase
{
    protected $address;

    public function init()
    {
        if (!$user = Auth::getUser()) {
            return;
        }

        $this->address = Address::whereUserId($user->id);
    }

    public function componentDetails()
    {
        return [
            'name'        => Lang::get('octoshop.addressbook::lang.components.picker.name'),
            'description' => Lang::get('octoshop.addressbook::lang.components.picker.description'),
        ];
    }

    public function defineProperties()
    {
        return [
            'fieldName' => [
                'title'       => Lang::get('octoshop.addressbook::lang.components.picker.fieldName'),
                'description' => Lang::get('octoshop.addressbook::lang.components.picker.fieldName_description'),
                'default'     => 'address',
            ],
        ];
    }

    public function prepareVars()
    {
        $this->setPageProp('fieldName');

        if ($this->address) {
            $this->setPageProp('available', $this->address->get());
            $this->setPageProp('selected', $this->address->first());
        }
    }

    public function onRun()
    {

        $this->prepareVars();
    }

    public function onRender()
    {
        $this->prepareVars();
    }

    public function onChangeAddress()
    {
        $this->prepareVars();

        $field = post('fieldName');

        if ($alias = post($field.'_address')) {
            $address = $this->address->whereAlias($alias)->first();
        }

        $this->setPageProp('selected', isset($address) ? $address : null);

        Event::fire('octoshop.addressUpdated', [$field, $address]);
    }
}
