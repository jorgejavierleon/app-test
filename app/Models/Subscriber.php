<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Subscriber extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static $rules = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:subscribers',
        'city' => 'required|string',
        'country' => 'required|string',
    ];

    /**
     * Get the subscriber's full name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
    }

    public function hasVerifiedEmail() : bool
    {
        return !!$this->email_verified_at;
    }

    public function signedVerificationEmailUrl() : string 
    {
        return URL::temporarySignedRoute('verify', now()->addDay(), [
            'subscriber' => $this->id,
            'email' => $this->email,
        ]);
    }
}
