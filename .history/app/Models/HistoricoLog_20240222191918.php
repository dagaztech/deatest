<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico_Log extends Model
{
    public $table = 'historic_logs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'user_id',
        'first_login',
        'last_login',
        'ip'
    ];
}