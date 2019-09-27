<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Authenticatable implements AuthenticatableContract
{
    protected $table = 'users';
    public $timestamps = false;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sname','name', 'right', 'id', 'password', 'lastSeen_at'
    ];
    protected $hidden = [
        'password', 'remember_token', 'right',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function name()
    {
        return 'name';
    }

    public function slbs()
    {
        return $this->hasMany(Slb::class);
    }

    public function services()
    {
        return $this->hasOne(Service::class);
    }

    public function brah()
    {
        return $this->hasOne(Brah::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}