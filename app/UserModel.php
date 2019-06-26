<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'nama',
        'tgl_lahir',
        'alamat',
        'email'
    ];
}
