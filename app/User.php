<?php

namespace App;

use Laravel\Spark\CanJoinTeams;
use Laravel\Spark\User as SparkUser;

class User extends SparkUser
{
    use CanJoinTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    /**
     * checks if the user belongs to a particular group
     * @param string|array $role
     * @return bool
     */
    public function hasRole($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }

    /**
     * The company that the user belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * The uploads the person has posted
     */
    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

}
