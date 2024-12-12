<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignFormsUsers extends Model
{
    use HasFactory;
    protected $table = 'tbl_assign_forms_users';
    public $fillable = [
        'form_id', 'user_id'
    ];
}
