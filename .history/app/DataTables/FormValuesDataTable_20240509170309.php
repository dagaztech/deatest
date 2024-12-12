<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\Form;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use App\Models\FormValue;
use App\Models\User;
use Carbon\Carbon;

class FormValuesDataTable extends DataTable
{
    public function dataTable($query)
    {

            $data = datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('user', function (FormValue $formValue) {
                $tu = '';
                if ($formValue->User) {
                    $tu = $formValue->User->name;
                }
                return $tu;
            })
            ->editColumn('amount', function (FormValue $formValue) {
                return $formValue->currency_symbol . $formValue->amount;
            })
            ->editColumn('status', function (FormValue $formValue) {
                if ($formValue->status == "free") {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-primary">' . __('Free') . '</span>';
                    return $out;
                } else if ($formValue->status == "pending") {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-warning">' . __('Pending') . '</span>';
                    return $out;
                } else if ($formValue->status == "successfull") {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-success">' . __('Successfull') . '</span>';
                    return $out;
                } else {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-danger">' . __('Failed') . '</span>';
                    return $out;
                }
            })
            ->editColumn('created_at', function (FormValue $formValue) {
                return $formValue->created_at;
            })
            ->editColumn('user', function (FormValue $formValue) {
                //echo $formValue->json;
                $arr = json_decode($formValue->json,true);

                if($formValue->form_id == 33){
                    $valor = $arr[0][3]["values"];
                    foreach ($valor as $key => $value) {
                        if(isset($value["selected"])){
                            return $value["label"];
                        }
                    }
                }

                if($formValue->form_id == 12){
                    $valor = $arr[0][4]["values"];
                    foreach ($valor as $key => $value) {
                        if(isset($value["selected"])){
                            return $value["label"];
                        }
                    }
                }
                if($formValue->form_id == 17){
                    $valor = $arr[0][2]["values"];
                    foreach ($valor as $key => $value) {
                        if(isset($value["selected"])){
                            return $value["label"];
                        }
                    }
                }
                if($formValue->form_id == 37){
                    $valor = $arr[0][2]["values"];
                    foreach ($valor as $key => $value) {
                        if(isset($value["selected"])){
                            return $value["label"];
                        }
                    }
                }

                if($formValue->form_id == 19){
                    $valor = $arr[0][1]["values"];
                    foreach ($valor as $key => $value) {
                        if(isset($value["selected"])){
                            return $value["label"];
                        }
                    }
                }


                $nombre = array_filter($arr[0], function($campo) {


                  if(isset($campo['label']) && ($campo['label'] == "Nombre completo" || $campo['label'] == "Nombre" || $campo['label'] == "Nombre de la persona que utilizó el DEA" || $campo['label'] == "Nombre Completo" || $campo['label'] == "Nombre del lugar" || $campo['label']  == "Tí­tulo del Acta" || $campo['label']  == "Nombre completo del Operador" || $campo['label']  ==  "Nombre del Representante Legal" || $campo['label']  ==  "Nombres y apellidos")){

                    return $campo['value'];

                  }

                  return null;
                });

                $n = array_shift($nombre);

                if($n != null){
                return $n['value'];

                }
                return "";
                
            })
            ->addColumn('action', function (FormValue $formValue) {
                return view('form-value.action', compact('formValue'));
            });

        if($this->form_id == 18){
            $data = datatables()
                ->eloquent($query)
               // ->addIndexColumn()

            ->addColumn('DT_RowIndex', function (FormValue $formValue) {

                $arr = json_decode($formValue->json,true);


                $nombre = array_filter($arr[0], function($campo) {
                  if($campo['label'] == "Estado del DEA visitado"){
                    return $campo;
                  }
                  return null;
                });

                foreach($nombre as $j => $item2) {

                    foreach($item2["values"] as $k => $item3) {

                        if(isset($item3["selected"])){
                            // print_r($item3);
                                // return  '<div class="color-box" style="background-color: #FF850A;">'.$item3["value"].'</div>';
                            if($item3["value"] == "No autorizado"){
                                    return '<span class="p-2 px-3 badge rounded-pill bg-danger">' . $item3["value"]. '</span>';
                            }

                            if($item3["value"] == "Pendiente por modificar"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-warning">' . $item3["value"]. '</span>';
                            }

                            if($item3["value"] == "Por autenticar"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-info" style="background-color:#fff200 !important; color:#000;">' . $item3["value"]. '</span>';
                            }

                            if($item3["value"] == "Verificado"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-success">' . $item3["value"]. '</span>';
                            }

                           

                        }
                    }

                }

                return "";
            })
            ->escapeColumns('active')
            ->addColumn('user', function (FormValue $formValue) {
                $tu = '';
                if ($formValue->User) {
                    $tu = $formValue->User->name;
                }
                return $tu;
            })
                
                ->editColumn('amount', function (FormValue $formValue) {
                    return $formValue->currency_symbol . $formValue->amount;
                })
                ->editColumn('status', function (FormValue $formValue) {
                    if ($formValue->status == "free") {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-primary">' . __('Free') . '</span>';
                        return $out;
                    } else if ($formValue->status == "pending") {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-warning">' . __('Pending') . '</span>';
                        return $out;
                    } else if ($formValue->status == "successfull") {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-success">' . __('Successfull') . '</span>';
                        return $out;
                    } else {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-danger">' . __('Failed') . '</span>';
                        return $out;
                    }
                })
                
                ->editColumn('created_at', function (FormValue $formValue) {
                    return $formValue->created_at;
                })
                ->editColumn('user', function (FormValue $formValue) {
                    //echo $formValue->json;

                    $arr = json_decode($formValue->json,true);

                    $nombre = array_filter($arr[0], function($campo) {

 
                      if($campo['label'] == "Nombre completo" || $campo['label'] == "Nombre" || $campo['label'] == "Nombre de la persona que utilizó el DEA" || $campo['label'] == "Nombre Completo" || $campo['label'] == "Nombre del lugar" || $campo['label']  == "Título del Acta" ){

                    return $campo['value'];

                  }


                      return null;
                    });

                    $n = array_shift($nombre);

                    if($n != null){
                    return $n['value'];

                    }
                    return "";
                    
                })
                ->addColumn('estado-dea-visitado', function (FormValue $formValue) {
                    return "aaaa";
                })
                ->addColumn('action', function (FormValue $formValue) {
                    return view('form-value.action', compact('formValue'));
                })
                ;

        }

        if($this->form_id == 34){
            $data = datatables()
                ->eloquent($query)
               // ->addIndexColumn()

            ->addColumn('DT_RowIndex', function (FormValue $formValue) {

                $arr = json_decode($formValue->json,true);


                $nombre = array_filter($arr[0], function($campo) {
                  if($campo['label'] == "Estado del Lugar de Instalación del DEA"){
                    return $campo;
                  }
                  return null;
                });

                foreach($nombre as $j => $item2) {

                    foreach($item2["values"] as $k => $item3) {

                        if(isset($item3["selected"])){
                            // print_r($item3);
                                // return  '<div class="color-box" style="background-color: #FF850A;">'.$item3["value"].'</div>';

                            // return $item3["value"];

                            if($item3["value"] == "No autorizado"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-danger">' . $item3["value"]. '</span>';
                            }

                            if($item3["value"] == "Pendiente de modificar información"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-warning">' . $item3["value"]. '</span>';
                            }

                            if($item3["value"] == "Por autenticar"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-primary">' . $item3["value"]. '</span>';
                            }

                            if($item3["value"] == "Verificado y autenticado"){
                                return '<span class="p-2 px-3 badge rounded-pill bg-success">' . $item3["value"]. '</span>';
                            }

                            

                        }
                    }

                }

                return "";
            })
            ->escapeColumns('active')
                ->addColumn('user', function (FormValue $formValue) {
                    $tu = '';
                    if ($formValue->User) {
                        $tu = $formValue->User->name;
                    }
                    return $tu;
                })
                
                ->editColumn('amount', function (FormValue $formValue) {
                    return $formValue->currency_symbol . $formValue->amount;
                })
                ->editColumn('status', function (FormValue $formValue) {
                    if ($formValue->status == "free") {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-primary">' . __('Free') . '</span>';
                        return $out;
                    } else if ($formValue->status == "pending") {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-warning">' . __('Pending') . '</span>';
                        return $out;
                    } else if ($formValue->status == "successfull") {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-success">' . __('Successfull') . '</span>';
                        return $out;
                    } else {
                        $out = '<span class="p-2 px-3 badge rounded-pill bg-danger">' . __('Failed') . '</span>';
                        return $out;
                    }
                })
                
                ->editColumn('created_at', function (FormValue $formValue) {
                    return $formValue->created_at;
                })
                ->editColumn('user', function (FormValue $formValue) {
                    //echo $formValue->json;

                    $arr = json_decode($formValue->json,true);

                    $nombre = array_filter($arr[0], function($campo) {


                      if($campo['label'] == "Nombre completo" || $campo['label'] == "Nombre" || $campo['label'] == "Nombre de la persona que utilizó el DEA" || $campo['label'] == "Nombre Completo" || $campo['label'] == "Nombre del lugar" || $campo['label']  == "Nombre del espacio o lugar"){

                            return $campo;

                          }


                      return null;
                    });

                    foreach($nombre as $j => $item2) {

                        foreach($item2["values"] as $k => $item3) {

                            if(isset($item3["selected"])){
                                return $item3["label"];

                            }
                        }

                    }
                    return "";
                    
                })
                ->addColumn('estado-dea-visitado', function (FormValue $formValue) {
                    return "aaaa";
                })
                ->addColumn('action', function (FormValue $formValue) {
                    return view('form-value.action', compact('formValue'));
                })
                ;

        }


        $labels = $this->labels();
        if ($labels != null) {
            foreach ($labels as $key => $label) {
                $data->editColumn($key, function (FormValue $formValue) use ($key) {
                    $jsonData = $formValue->json;
                    $jsonArray = json_decode($jsonData, true);
                    $value = "-";
                    foreach ($jsonArray as $items) {
                        foreach ($items as $item) {
                            if (isset($item['show_datatable']) && $item['show_datatable']) {
                                if ($item['name'] === $key) {
                                    if ($item['type'] === 'starRating') {
                                        $value = '';
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($item['value'] < $i) {
                                                if (is_float($item['value']) && (round($item['value']) == $i)) {
                                                    $value .= '<i class="text-warning fas fa-star-half-alt"></i>';
                                                } else {
                                                    $value .= '<i class="fas fa-star"></i>';
                                                }
                                            } else {
                                                $value .= '<i class="text-warning fas fa-star"></i>';
                                            }
                                        }
                                    } elseif ($item['type'] === 'radio-group' || $item['type'] === 'select' || $item['type'] === 'checkbox-group') {
                                        $selectedValues = [];
                                        foreach ($item['values'] as $option) {
                                            if (isset($option['selected']) && $option['selected'] == 1) {
                                                $selectedValues[] = $option['label'];
                                            }
                                        }
                                        $value = implode(', ', $selectedValues);
                                    } elseif ($item['type'] === 'date') {
                                        $value = '';
                                        if ($item['value']) {
                                            $date = Carbon::createFromFormat('Y-m-d', $item['value']);
                                            $formattedDate = $date->format('jS M Y');
                                            $value = $formattedDate;
                                        }
                                    } else {
                                        $value = $item['value'];
                                    }
                                }
                            }
                        }
                    }
                    return $value;
                });
            }
            $arr = array_merge(['status', 'action', 'user', 'type', 'created_at', 'estado-dea-visitado'], array_keys($labels));
        } else {
            $arr = array_merge(['status', 'action', 'user', 'type', 'created_at', 'estado-dea-visitado']);
        }
        $data->rawColumns($arr);
        return $data;
    }

    public function query(FormValue $model, Request $request)
    {
        $usr = \Auth::guard('api')->user();
        $roleId = 1;
        $userId = $usr->id;

        

        $formValues =  $model->newQuery()
            ->select(['tbl_form_values.*', 'tbl_forms.title'])
            ->join('tbl_forms', 'tbl_forms.id', '=', 'tbl_form_values.form_id')
            ->where(function ($query1) use ($roleId, $userId) {
                $query1->whereIn('tbl_form_values.form_id', function ($query) use ($roleId) {
                    $query->select('form_id')->from('tbl_assign_forms_roles')->where('role_id', $roleId);
                })
                    ->orWhereIn('tbl_form_values.form_id', function ($query) use ($userId) {
                        $query->select('form_id')->from('tbl_assign_forms_users')->where('user_id', $userId);
                    })
                    ->OrWhere('assign_type', 'public');
            });

        // if (($usr->rol == 'Usuario operador 1' || $usr->rol == 'Usuario consulta E') && ($this->form_id == 33)) {
        //     $formValues =  $model->newQuery()
        //     ->select(['tbl_form_values.*', 'tbl_forms.title'])
        //     ->join('tbl_forms', 'tbl_forms.id', '=', 'tbl_form_values.form_id')
        //     ->where('tbl_form_values.user_id', '=', $usr->id)
        //     ;
        // }

        if (($usr->rol == 'Usuario consulta E') && ($this->form_id == 7)) {
            $formValues =  $model->newQuery()
            ->select(['tbl_form_values.*', 'tbl_forms.title'])
            ->join('tbl_forms', 'tbl_forms.id', '=', 'tbl_form_values.form_id')
            ->where('tbl_form_values.user_id', '=', $usr->id)
            ;
        }

        



        // Mostrar todos los formularios que coinciden con el lugar asignado 
        if (($usr->rol == 'Usuario operador 1' || $usr->rol == 'Usuario consulta E' )&& ($this->form_id == 33)) {
            $formValues =  $model->newQuery()
            ->select(['tbl_form_values.*', 'tbl_forms.title'])
            ->join('tbl_forms', 'tbl_forms.id', '=', 'tbl_form_values.form_id')
            // ->where('tbl_form_values.user_id', '=', $usr->id)
            ->where('tbl_form_values.form_id', '=', $this->form_id)
            ;


            $id_lugar = $this->buscar_lugar_por_formulario_usuario();

            $ids_mostrar = $this->buscar_lugar_dea_permitido($formValues, $id_lugar);
            

            $formValues =  $formValues
            ->whereIn('tbl_form_values.id', $ids_mostrar)
            ;

        }





      

        if ($request->start_date && $request->end_date) {
            $formValues->whereBetween('tbl_form_values.created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);

        }

        if ($this->form_id) {
            $formValues->where('tbl_form_values.form_id', '=', $this->form_id);
        }


        if (($usr->rol == 'Usuario operador 1' || $usr->rol == 'Usuario consulta E' )&& ($this->form_id == 13))
        {

            $formulario_deas =  $model->newQuery()
                ->select(['tbl_form_values.*', 'tbl_forms.title'])
                ->join('tbl_forms', 'tbl_forms.id', '=', 'tbl_form_values.form_id')
                ->where('tbl_form_values.form_id', '=', 33)
                ;


            $id_lugar = $this->buscar_lugar_por_formulario_usuario();
            // echo $id_lugar;
            // return;

            $ids_mostrar = $this->buscar_lugar_dea_permitido($formulario_deas, $id_lugar);


            $formValues =  $model->newQuery()
            ->select(['tbl_form_values.*', 'tbl_forms.title'])
            ->join('tbl_forms', 'tbl_forms.id', '=', 'tbl_form_values.form_id')
            ->where('tbl_form_values.form_id', '=', 13)
            ;


            // print_r($ids_mostrar);
            // echo "----";
            $ids_form_mostrar = array();
            foreach ($formValues->get() as $key => $formulario) {

                $arr = json_decode($formulario->json,true);

                $lista_lugares = $arr[0][4]["values"];

                foreach ($lista_lugares as $key => $valore_lugares) {
                    // print_r($valore_lugares);

                    if(isset($valore_lugares["selected"])){
                        // echo $valore_lugares["value"];
                        // echo "</br>";

                        if(in_array($valore_lugares["value"], $ids_mostrar)){

                            array_push($ids_form_mostrar, $formulario->id);

                        }


                    }
                }
            }
            // print_r($ids_form_mostrar);


            $formValues =  $formValues
            ->whereIn('tbl_form_values.id', $ids_form_mostrar)
            ;


        }




        if ($request->user_name) {
            
            $formValues->where('tbl_form_values.json', 'iLIKE', '%' . strtolower($request->user_name) . '%');
        }
        return $formValues;
    }


    public function buscar_lugar_dea_permitido($formValues, $id_lugar)
    {
        $ids_mostrar = array();
        foreach ($formValues->get() as $key => $formulario) {

            $arr = json_decode($formulario->json,true);

            $lista_lugares = $arr[0][3]["values"];


            foreach ($lista_lugares as $key => $valore_lugares) {

                if(isset($valore_lugares["selected"])){

                    if($valore_lugares["value"] == $id_lugar){

                        array_push($ids_mostrar, $formulario->id);

                    }


                }
            }
        }


        return $ids_mostrar;

    }

    public function buscar_lugar_por_formulario_usuario()
    {

        $respuestaOperardor = FormValue::where("form_id", 9)
                                        ->where("json", 'LIKE', '%'.'"value":"'. \Auth::guard('api')->user()->email .'"}'.'%', )
                                        ->first();

        $arregloUsuario = json_decode($respuestaOperardor->json,true);
        $lugares_form_usuario = $arregloUsuario[0][1]["values"];

        $id_lugar = 0;
        foreach ($lugares_form_usuario as $key => $valore_lugares) {

            if(isset($valore_lugares["selected"])){
                $id_lugar = $valore_lugares["value"];
            }
        }

        return $id_lugar;
    }

    public function labels()
    {
        $recordId = $this->form_id;
        $formValue = Form::find($recordId);
        if ($formValue->json != '') {
            $jsonData = $formValue->json;
            $jsonArray = json_decode($jsonData, true);
            $filteredData = [];
            foreach ($jsonArray as $jArray) {
                foreach ($jArray as $item) {
                    if (isset($item['show_datatable']) && $item['show_datatable'] == true) {
                        $filteredData[$item['name']] =  $item['label'];
                    }
                }
            }
            $label = $filteredData;
            // print_r($label);
            return $label;
        }
    }

    public function html()
    {
        $dataTable = $this->builder()
            ->setTableId('forms-table')
            ->addIndex()
            ->columns($this->getColumns($this->labels()))
            ->ajax([
                'data' => 'function(d) {
                            var filter = $(".created_at").val();
                            

                            var user_filter = $("input[name=user]").val();
                            d.user_name = user_filter;

                            if(filter != ""){
                                const fechas = filter.split("to");
                                d.start_date = fechas[0];
                                d.end_date = fechas[1];
                            }

                        }'
            ])
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
                "searchPlaceholder" => __('Search...'), "search" => "",
                "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')

            ])->initComplete('function() {
                var table = this;
                $("body").on("click", ".add_filter", function() {
                    $("#forms-table").DataTable().draw();
                });
                $("body").on("click", ".clear_filter", function() {
                    $(".created_at").val("");
                    $("input[name=user]").val("");
                    $("#forms-table").DataTable().draw();
                });
                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
            }');

            $canExportSubmittedForm = \Auth::guard('api')->user()->rol == "Administrador";

            $canExportSubmittedForm = true;
            $exportButtonConfig = [];
            //if ($canExportSubmittedForm) {
                $exportButtonConfig = [
                    'extend' => 'collection',
                    'className' => 'w-inherit btn btn-light-secondary me-1 dropdown-toggle',
                    'text' => '<i class="ti ti-download"></i> ' . __('Export'),
                    "buttons" => [
                        ["extend" => "print", "text" => '<i class="fas fa-print"></i> ' . __('Print'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        ["extend" => "csv", "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        ["extend" => "excel", "text" => '<i class="fas fa-file-excel"></i> ' . __('Excel'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        //["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i> ' . __('PDF'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        ["extend" => "copy", "text" => '<i class="fas fa-copy"></i> ' . __('Copy'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                    ],
                ];
            //}


            $buttonsConfig = [
                $exportButtonConfig,
                ['extend' => 'reset', 'className' => 'w-inherit btn btn-light-danger me-1'],
                ['extend' => 'reload', 'className' => 'w-inherit btn btn-light-warning'],
            ];


            $dataTable->parameters([
                "dom" =>  "
            <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B>>
            <'dataTable-container'<'col-sm-12'tr>>
            <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
            ",
                'buttons' => $buttonsConfig,
                "drawCallback" => 'function( settings ) {
                    var tooltipTriggerList = [].slice.call(
                        document.querySelectorAll("[data-bs-toggle=tooltip]")
                      );
                      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                      });
                      var popoverTriggerList = [].slice.call(
                        document.querySelectorAll("[data-bs-toggle=popover]")
                      );
                      var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl);
                      });
                      var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                      var toastList = toastElList.map(function (toastEl) {
                        return new bootstrap.Toast(toastEl);
                      });
                }'
            ]);


            $dataTable->language([
                'buttons' => [
                    'create' => __('Create'),
                    'export' => __('Export'),
                    'print' => __('Print'),
                    'reset' => __('Reset'),
                    'reload' => __('Reload'),
                    'excel' => __('Excel'),
                    'csv' => __('CSV'),
                ]
            ]);
            return $dataTable;
    }

    protected function getColumns($label)
    {

        $columns = [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('user')->title(__('User')),
            Column::make('amount')->title(__('Amount')),
            // Other fixed columns...
        ];
        if ($label != null) {
            foreach ($label as $key => $value) {
                //$columns[] = Column::make($key)->title($value)->searchable(false)->orderable(false);
            }
        }
        if($this->form_id == 18){

           // $columns[] = Column::make('estado')->title(__('estado'))->data('estado-dea-visitado')->name('estado-dea-visitado')->searchable(false);      
             }

        $columns[] = Column::make('transaction_id')->title(__('Transaction Id'));
        $columns[] = Column::make('status')->title(__('Payment Status'));
        
        $columns[] = Column::make('payment_type')->title(__('Payment Type'));
        $columns[] = Column::make('created_at')->title(__('Created At'));
        $columns[] = Column::computed('action')->title(__('Action'))
            ->exportable(false)
            ->printable(false)
            ->addClass('text-end');

        return $columns;
    }


    protected function filename(): string
    {
        return 'FormValues_' . date('YmdHis');
    }
}
