<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormIntegrationSetting extends Model
{
    use HasFactory;
    protected $table = 'tbl_form_integration_settings';

    protected $fillable = ['form_id','key','status', 'json','field_json'];
    public $timestamps = false;
}
