<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model
{
    use HasFactory;
    protected $table = 'tbl_multiple_choices';

    protected $fillable = [
        'vote',
        'poll_id','location','name','session_id'
    ];
}
