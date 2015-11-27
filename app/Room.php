<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['name', 'email', 'password'];
}
