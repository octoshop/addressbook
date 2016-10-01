<?php namespace Octoshop\AddressBook\Models;

use Exception;
use Model;

class Address extends Model
{
    /**
     * @var string The database table used by the model
     */
    public $table = 'octoshop_addresses';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'line_1',
        'line_2',
        'town',
        'region',
        'postcode',
        'country',
    ];

    public $belongsTo = [
        'user' => 'RainLab\User\Models\User',
    ];

    /**
     * Make sure the address belongs to the logged in user.
     * @throws Exception
     * @return bool
     */
    public function ensureOwnerIs($userId)
    {
        if ($this->user->id !== $userId) {
            throw new Exception("User does not have permission to update address");
        }

        return true;
    }
}