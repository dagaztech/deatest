<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\LogDataTable;

class HistoricoController extends AppBaseController
{
    /**
     * Display a listing of the Activity log.
     *
     * @param LogDataTable $vinDataTable
     * @return Response
     */
    public function indexhistorico(LogDataTable $logDataTable)
    {   
        return $logDataTable->render('user-operativo.historico-usuarios');
    }
}
