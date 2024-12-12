<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
date_default_timezone_set('UTC');

class HistoricoLog extends Model
{
    public $table = 'tbl_historic_logs';
    
    public $fillable = [
        'id_usuario',
        'description',
        'ip',
    ];


    public function crear($id_usuario, $description, $ip)
    {
        $this->id_usuario = $id_usuario;
        $this->description = $description;
        $this->ip = $ip;
        $this->created_at = date("Y-m-d H:i:s");
    }

}