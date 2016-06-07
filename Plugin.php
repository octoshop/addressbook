<?php namespace Octoshop\AddressBook;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['Octoshop.Core'];

    public function pluginDetails()
    {
        return [
            'name' => 'octoshop.addressbook::lang.plugin.name',
            'icon' => 'icon-book',
            'author' => 'Dave Shoreman',
            'homepage' => 'http://octoshop.co/',
            'description' => 'octoshop.addressbook::lang.plugin.description',
        ];
    }
}
