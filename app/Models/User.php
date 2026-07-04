<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */


    public function routeNotificationForTwilio(): string
    {
        return $this->phone; // Assuming the User model has a 'phone' attribute
    }

    public function driver (){
        return $this->hasOne(Driver::class); //one to one relationship (a usercan only have one driver)

    }

    public function trips(){
        return $this->hasMany(Trip::class); //one to many relationship (a user can have many trips)
    }
}
