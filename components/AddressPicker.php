<?php namespace Octoshop\AddressBook\Components;

use Auth;
use Event;
use Lang;
use Octoshop\AddressBook\Models\Address;
use Octoshop\Core\Components\ComponentBase;

class AddressPicker extends ComponentBase
{
    protected $address;

    protected $user;

    public function init()
    {
        if (!$this->user = Auth::getUser()) {
            return;
        }
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

        if ($this->user->addresses) {
            $this->setPageProp('available', $this->user->addresses);
            $this->setPageProp('selected', $this->user->addresses()->first());
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
            $address = $this->user->addresses()->whereAlias($alias)->first();
        }

        $this->setPageProp('selected', isset($address) ? $address : null);

        Event::fire('octoshop.addressUpdated', [$field, $address]);
    }
}
