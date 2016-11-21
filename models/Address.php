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

    /**
     * @var array Relations
     */
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

    /**
     * Get the validation rules with a prefix applied
     * @param string $prefix
     * @return array
     */
    public static function getValidationRules($prefix)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => '',
            'line1' => 'required',
            'line2' => '',
            'town' => 'required',
            'region' => 'required',
            'postcode' => 'required',
            'country' => 'required',
        ];

        foreach (array_keys($rules) as $field) {
            $rules[$prefix.'_'.$field] = $rules[$field];
            unset($rules[$field]);
        }

        return $rules;
    }
}
