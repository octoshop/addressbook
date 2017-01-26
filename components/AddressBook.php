<?php namespace Octoshop\AddressBook\Components;

use Auth;
use Exception;
use Lang;
use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Octoshop\AddressBook\Models\Address;
use October\Rain\Exception\ApplicationException;

class AddressBook extends ComponentBase
{
    protected $user;

    public function init()
    {
        if (!$this->user = Auth::getUser()) {
            throw new ApplicationException(Lang::get('octoshop.addressbook::lang.error.not_logged_in'));
        }
    }

    public function componentDetails()
    {
        return [
            'name'        => Lang::get('octoshop.addressbook::lang.components.book.name'),
            'description' => Lang::get('octoshop.addressbook::lang.components.book.description'),
        ];
    }

    public function onRun()
    {
        $this->addresses = $this->page['addresses'] = $this->user->addresses;
    }

    public function onLoadEditor()
    {
        if ($id = post('id')) {
            $address = Address::findOrFail($id);
            $address->ensureOwnerIs($this->user->id);

            $this->page['address'] = $address;
        } else {
            $this->page['address'] = null;
        }
    }

    public function onCreate()
    {
        $address = new Address(post());
        $address->alias = post('alias');

        $this->user->addresses()->add($address);
    }

    public function onUpdate()
    {
        try {
            $address = Address::findOrFail(post('id'));
            $address->ensureOwnerIs($this->user->id);
            $address->fill(post());
            $address->save();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function onDelete()
    {
        $address = Address::findOrFail(post('id'));
        $address->ensureOwnerIs($this->user->id);
        $address->delete();
    }
}
