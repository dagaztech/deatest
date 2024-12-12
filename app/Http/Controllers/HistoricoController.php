<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use App\DataTables\LogDataTable;
use App\Models\HistoricoLog;
use Carbon\Carbon;


class HistoricoController extends Controller
{
    /**
     * Display a listing of the Activity log.
     *
     * @param LogDataTable $vinDataTable
     * @return Response
     */
    //public function indexhistorico(LogDataTable $logDataTable)
    public function indexhistorico(Request $request)
    {   

        if(isset($request->rango)){

            $fechas = explode(' to ', $request->rango);

            if(sizeof($fechas) < 2){
                // Solo una fecha
                $listaHistoricos = HistoricoLog::join('tbl_users', 'tbl_users.id', '=', 'id_usuario')
                                ->whereDAte('tbl_historic_logs.created_at', Carbon::parse($fechas[0]))
                                    ->select('tbl_historic_logs.id', 'tbl_historic_logs.created_at', 'tbl_users.name', 'tbl_users.email', 'tbl_historic_logs.description', 'tbl_historic_logs.ip')->get();
            }else{

                // Rango de fechas
                $listaHistoricos = HistoricoLog::join('tbl_users', 'tbl_users.id', '=', 'id_usuario')
                                ->whereBetween('tbl_historic_logs.created_at', [Carbon::parse($fechas[0]), Carbon::parse($fechas[1])])
                                    ->select('tbl_historic_logs.id', 'tbl_historic_logs.created_at', 'tbl_users.name', 'tbl_users.email', 'tbl_historic_logs.description', 'tbl_historic_logs.ip')->get();

            
            }

        }else{
            // Sin fechas
            $listaHistoricos = HistoricoLog::join('tbl_users', 'tbl_users.id', '=', 'id_usuario')
                            // ->whereDate('tbl_historic_logs.created_at', Carbon::today())
                            ->select('tbl_historic_logs.id', 'tbl_historic_logs.created_at', 'tbl_users.name', 'tbl_users.email', 'tbl_historic_logs.description', 'tbl_historic_logs.ip')->get();
        }

        //return $logDataTable->render('user-operativo.historico-usuarios');
        return view('user-operativo/historico-usuarios', compact('listaHistoricos'));
    }
}
