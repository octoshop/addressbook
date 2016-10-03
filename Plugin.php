<?php namespace Octoshop\AddressBook;

use Backend;
use Event;
use Backend\Classes\FormTabs;
use RainLab\User\Controllers\Users;
use RainLab\User\Models\User;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = [
        'Octoshop.Core',
        'RainLab.User',
    ];

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

    public function boot()
    {
        $this->extendBackendForms();
        $this->extendBackendLists();

        $this->extendControllers();
        $this->extendModels();
    }

    public function extendBackendForms()
    {
        Event::listen('backend.form.extendFields', function($form) {
            if (!$form->getController() instanceof Users
             || !$form->model instanceof User) {
                return;
            }

            $form->addTabFields([
                'addresses' => [
                    'tab' => 'Address Book',
                    'type' => 'partial',
                    'path' => '$/octoshop/addressbook/controllers/users/_field_addresses.htm',
                ],
            ], FormTabs::SECTION_SECONDARY);
        });
    }

    public function extendBackendLists()
    {
        Event::listen('backend.list.extendColumns', function($list) {
            if (!($list->getController() instanceof Users)
             || !($list->model instanceof User)) {
                return;
            }

            $list->addColumns([
                'addresses' => [
                    'label'    => 'Addresses',
                    'relation' => 'addresses',
                    'select'   => 'alias',
                    'searchable' => true,
                    'sortable'   => false,
                    'invisible'  => true,
                ],
            ]);
        });
    }

    public function extendControllers()
    {
        Users::extend(function($controller) {
            $controller->addDynamicProperty('relationConfig', '$/octoshop/addressbook/controllers/users/config_relation.yaml');
            $controller->implement[] = 'Backend.Behaviors.RelationController';
        });
    }

    public function extendModels()
    {
        User::extend(function($model) {
            $model->hasMany['addresses'] = 'Octoshop\AddressBook\Models\Address';
        });
    }

    /**
     * Register components provided by this plugin
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Octoshop\AddressBook\Components\AddressPicker' => 'addressPicker',
        ];
    }
}
