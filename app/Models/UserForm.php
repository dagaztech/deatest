<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserForm extends Model
{
    use HasFactory;
    protected $table = 'tbl_user_forms';

    public $fillable = [
        'form_id', 'role_id'
    ];
}
