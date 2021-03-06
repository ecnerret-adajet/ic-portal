<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','disclaimer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Associated User to company

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship Model

    public function labors() {
        return $this->hasMany(Labor::class);
    }

    public function relievers() {
        return $this->hasMany(Reliver::class);
    }


    // Custom casting to json

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'role' =>  $this->roles()->first()->name,
            'created_at' => $this->created_at
        ];
    }


}
