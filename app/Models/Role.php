<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_roles';

    protected $fillable = [
        'name', 'guard_name'
    ];
}