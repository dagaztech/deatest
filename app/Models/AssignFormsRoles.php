<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignFormsRoles extends Model
{
    use HasFactory;
    protected $table = 'tbl_assign_forms_roles';
    public $fillable = [
        'form_id', 'role_id'
    ];
}
