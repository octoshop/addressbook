<?php namespace Octoshop\AddressBook\Components;

use Auth;
use Octoshop\AddressBook\Models\Address;
use Octoshop\Core\Components\ComponentBase;

class AddressPicker extends ComponentBase
{
    protected $address;

    public function init()
    {
        $this->address = Address::whereUserId(Auth::getUser()->id);
    }

    public function componentDetails()
    {
        return [
            'name'        => "Address picker",
            'description' => "Shows the current address with an option to switch it or add a new one.",
        ];
    }

    public function defineProperties()
    {
        return [
            'fieldName' => [
                'title'       => 'Identifier',
                'description' => 'Unique identifier to prepend to address form fields.',
                'default'     => 'address',
            ],
        ];
    }

    public function prepareVars()
    {
        $this->setPageProp('available', $this->address->get());

        $this->setPageProp('fieldName');
        $this->setPageProp('selected', $this->address->first());
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

        if ($alias = post(post('fieldName'))) {
            $address = $this->address->whereAlias($alias)->first();
        }

        $this->setPageProp('selected', isset($address) ? $address : null);

        return $this->page;
    }
}