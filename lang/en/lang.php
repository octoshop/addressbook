<?php

return [
    'plugin' => [
        'name' => 'Address Book',
        'description' => 'Extends the User plugin to provide a convenient way of managing customer addresses.',
    ],
    'components' => [
        'book' => [
            'name' => 'Address Book',
            'description' => 'Present a list of addresses for editing.',
        ],
        'picker' => [
            'name' => 'Address picker',
            'description' => 'Shows the current address with an option to switch it or add a new one.',
            'fieldName' => 'Identifier',
            'fieldName_description' => 'Unique identifier to prepend to address form fields.',
        ],
    ],
    'address' => [
        'id' => 'ID',
        'alias' => 'Alias',
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'company' => 'Company',
        'line1' => 'Address line 1',
        'line2' => 'Address line 2',
        'town' => 'Town',
        'region' => 'County',
        'postcode' => 'Post code',
        'country' => 'Country',
    ],
    'error' => [
        'not_logged_in' => 'Failed to fetch addresses. User not logged in.',
    ],
];
