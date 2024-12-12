<?php

namespace App\Http\Controllers;

use App\DataTables\FormValuesDataTable;
use App\Exports\FormValuesExport;
use App\Exports\ChartDataExport;
use App\Exports\MultiSheetExport;
use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\UserForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;


class FormValueController extends Controller
{
    public function index(FormValuesDataTable $dataTable)
    {
        if (\Auth::guard('api')->user()->rol == 'Administrador' || "Operativo SSM" || "Usuario consulta E" || "Usuario operador 1" || "Usuario operador 2") {
            $forms = Form::all();
            return $dataTable->render('form-value.index', compact('forms'));
        } else {
            return redirect()->back()->with('error', __('Acceso denegado.'));
        }
    }

    public function showSubmitedForms($form_id, FormValuesDataTable $dataTable)
    {
            $forms          = Form::all();
            $chartData      = UtilityFacades::dataChart($form_id);
            
            // print_r($chartData);
            // return;

            $formsDetails  = Form::find($form_id);
            return $dataTable->with('form_id', $form_id)->render('form-value.view-submited-form', compact('forms', 'chartData', 'formsDetails'));
    }

    public function generateCharts()
{
    // Consultar todos los formularios desde la tabla tbl_forms
    $forms = Form::all();

    // Inicializar las estructuras para gráficos
    $charts = [];
    $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $chartTypes = ['bar', 'line', 'pie', 'scatter']; // Tipos de gráficas disponibles

    // Iterar sobre cada formulario para generar su gráfico
    foreach ($forms as $form) {
        // Simular datos de ejemplo para cada formulario (puedes reemplazar esto con datos reales de la BD)
        $data = array_map(function () {
            return rand(10, 100); // Generar valores aleatorios para cada mes
        }, range(1, count($months)));

        $charts[] = [
            'form_id' => $form->id,
            'type' => $chartTypes[array_rand($chartTypes)], // Selección aleatoria del tipo de gráfico
            'labels' => $months,
            'data' => $data,
        ];
    }

    // Retornar la vista con los datos para los gráficos
    return view('user-administrador.graficasbi', compact('charts'));
}

public function downloadChartData($formId)
{
    $form = Form::find($formId);

    if (!$form) {
        abort(404, 'Formulario no encontrado');
    }

    // Datos simulados o reales
    $data = [
        ['Mes', 'Valor'],
        ['Enero', rand(10, 100)],
        ['Febrero', rand(10, 100)],
        ['Marzo', rand(10, 100)],
        ['Abril', rand(10, 100)],
        ['Mayo', rand(10, 100)],
        ['Junio', rand(10, 100)],
        ['Julio', rand(10, 100)],
        ['Agosto', rand(10, 100)],
        ['Septiembre', rand(10, 100)],
        ['Octubre', rand(10, 100)],
        ['Noviembre', rand(10, 100)],
        ['Diciembre', rand(10, 100)],
    ];

    return Excel::download(new ChartDataExport($data), "graficobiformulario_id{$formId}.xlsx");
}

public function downloadGlobalCharts()
{
    $forms = Form::all();

    // Creamos una hoja por cada formulario
    $sheets = $forms->map(function ($form) {
        $data = [
            ['Mes', 'Valor'],
            ['Enero', rand(10, 100)],
            ['Febrero', rand(10, 100)],
            ['Marzo', rand(10, 100)],
            ['Abril', rand(10, 100)],
            ['Mayo', rand(10, 100)],
            ['Junio', rand(10, 100)],
            ['Julio', rand(10, 100)],
            ['Agosto', rand(10, 100)],
            ['Septiembre', rand(10, 100)],
            ['Octubre', rand(10, 100)],
            ['Noviembre', rand(10, 100)],
            ['Diciembre', rand(10, 100)],
        ];

        return new ChartDataExport($data);
    })->toArray();

    return Excel::download(new MultiSheetExport($sheets), 'todos_los_graficosbi.xlsx');
}




    public function show($id)
    {

        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM" || "Usuario consulta E" || "Usuario operador 1" || "Usuario operador 2") {
            try {
                $formValue = FormValue::find($id);
                $array      = json_decode($formValue->json);


                if($formValue->form_id == 13){
                    

                    $arr = json_decode($formValue->json,true);
                    $identificacionCampo = array_filter($arr[0], function($campo) {
                    if($campo['label'] == "Número de documento de identificación del paciente"){
                        return $campo;
                      }
                      return null;
                    });
                    if(isset($identificacionCampo[5])){

                    $numeroDocumento = $identificacionCampo[5]["value"];


                    $formValue2 = FormValue::where("form_id", 14)
                                                ->where("json", 'LIKE', '%'.'"value":"'.$numeroDocumento.'"}'.'%', )
                                                ->whereDate('created_at', '=', $formValue->created_at)
                                                ->first();

                    // print_r($formValue->created_at);
                    // echo "/////";
                    // print_r($formValue2->created_at);

                    // return;


                    if($formValue2 != null){
                        $listas = array_merge(json_decode($formValue->json), json_decode($formValue2->json));

                        $formValue->json = json_encode($listas);

                        $array = $listas;
                    }
                    //return "";
                    }
                    

                }

                if($formValue->form_id == 14){
                    

                    $arr = json_decode($formValue->json,true);
                    $identificacionCampo = array_filter($arr[0], function($campo) {

                      if($campo['label'] == "Número de documento de identidad"){
                        return $campo;
                      }
                      return null;
                    });

                    $numeroDocumento = $identificacionCampo[5]["value"];

                    $formValue2 = FormValue::where("form_id", 13)
                                            ->where("json", 'LIKE', '%'.'"value":"'.$numeroDocumento.'"}'.'%', )
                                            ->whereDate('created_at', '=', $formValue->created_at)
                                            ->first();
                    
                    if($formValue2 != null){


                        
                        $listas = array_merge(json_decode($formValue2->json), json_decode($formValue->json));

                        $formValue->json = json_encode($listas);

                        $array = $listas;
                    }
                    

                }

                if($formValue->form_id == 33){

                    $formValue = $this->concatenarDireccion($formValue);
                    // return "";
                    $array = json_decode($formValue->json);

                }



            } catch (\Throwable $th) {
                return redirect()->back()->with('errors', $th->getMessage());
            }
            return view('form-value.view', compact('formValue', 'array'));
        } else {
            return redirect()->back()->with('error', __('Acceso denegado.'));
        }
    }

    public function concatenarDireccion($formValue){

        // echo $formValue->json;

        $arr = json_decode($formValue->json,true);
        $via = array_filter($arr[0], function($campo) {
          if($campo['label'] == "Vía"){
            return $campo;
          }
          return null;
        });


        $viaString = "";
        foreach($via as $j => $item2) {

            foreach($item2["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $viaString = $item3["value"];
                }
            }

        }


        // $numero = array_filter($arr[0], function($campo) {
        //   if($campo['label'] == "Número"){
        //     return $campo;
        //   }
        //   return null;
        // });

        // print_r($numero[0][9]); 

        $numeroString = $arr[0][9]["value"];

        $letra = array_filter($arr[0], function($campo) {
          if($campo['label'] == "Letra"){
            return $campo;
          }
          return null;
        });


        $letra = $arr[0][10];
        $letraString = "";
        foreach($via as $j => $item2) {

            foreach($letra["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $letraString = $item3["value"];
                }
            }

        }

        $bis = $arr[0][11];
        $bisString = "";
        foreach($via as $j => $item2) {

            foreach($bis["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $bisString = $item3["value"];
                }
            }

        }

        $letra2 = $arr[0][12];
        $letra2String = "";
        foreach($via as $j => $item2) {

            foreach($letra2["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $letra2String = $item3["value"];
                }
            }

        }

        $puntoCardinal = $arr[0][13];
        $puntoCardinalString = "";
        foreach($via as $j => $item2) {

            foreach($puntoCardinal["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $puntoCardinalString = $item3["value"];
                }
            }

        }

        $letraNumero = $arr[0][14]["value"];


        $puntoCardinal2 = $arr[0][15];
        $puntoCardinal2String = "";
        foreach($via as $j => $item2) {

            foreach($puntoCardinal2["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $puntoCardinal2String = $item3["value"];
                }
            }

        }


        $adicional = $arr[0][16]["value"];
        // $adicionalString = "";
        // foreach($via as $j => $item2) {

        //     foreach($adicional["values"] as $k => $item3) {

        //         if(isset($item3["selected"])){
        //             $adicionalString = $item3["value"];
        //         }
        //     }

        // }

        $direccion = "<italic>". $viaString . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $numeroString . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "  . $letraString . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "  . $bisString . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "  . $letra2String  . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $puntoCardinalString . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "  . $letraNumero . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "  . $puntoCardinal2String  . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $adicional ."</italic>";

        $arr[0][4] = array(
            "type" => "text",
            "required" => "",
            "label" => "Dirección",
            "className" => "form-control dea-input",
            "name" => "",
            "subtype" => "text",
            "value" => $direccion,
        );

        array_splice($arr[0], 7, 10);

        
        $formValue->json = json_encode($arr);


        return $formValue;
    }

    public function concatenarDireccionForm7($formValue){

        // echo $formValue->json;

        $arr = json_decode($formValue->json,true);
        $via = array_filter($arr[0], function($campo) {
          if($campo['label'] == "Vía"){
            return $campo;
          }
          return null;
        });


        $viaString = "";
        foreach($via as $j => $item2) {

            foreach($item2["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $viaString = $item3["value"];
                }
            }

        }


        $numero = array_filter($arr[0], function($campo) {
          if($campo['label'] == "Número"){
            return $campo;
          }
          return null;
        });

        
        if(isset($numero[6])){
            $numeroString = $numero[6]["value"];
        }else{
            $numeroString = "";
        }


        $letra = array_filter($arr[0], function($campo) {
          if($campo['label'] == "Letra"){
            return $campo;
          }
          return null;
        });


        $letra = $arr[0][8];
        $letraString = "";
        foreach($via as $j => $item2) {

            foreach($letra["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $letraString = $item3["value"];
                }
            }

        }

        $bis = $arr[0][9];
        $bisString = "";
        foreach($via as $j => $item2) {

            foreach($bis["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $bisString = $item3["value"];
                }
            }

        }

        $letra2 = $arr[0][10];
        $letra2String = "";
        foreach($via as $j => $item2) {

            foreach($letra2["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $letra2String = $item3["value"];
                }
            }

        }

        $puntoCardinal = $arr[0][10];
        $puntoCardinalString = "";
        foreach($via as $j => $item2) {

            foreach($puntoCardinal["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $puntoCardinalString = $item3["value"];
                }
            }

        }

        $letraNumero = $arr[0][11]["value"];


        $puntoCardinal2 = $arr[0][12];
        $puntoCardinal2String = "";
        foreach($via as $j => $item2) {

            foreach($puntoCardinal2["values"] as $k => $item3) {

                if(isset($item3["selected"])){
                    $puntoCardinal2String = $item3["value"];
                }
            }

        }


        $adicional = $arr[0][13]["value"];
        // $adicionalString = "";
        // foreach($via as $j => $item2) {

        //     foreach($adicional["values"] as $k => $item3) {

        //         if(isset($item3["selected"])){
        //             $adicionalString = $item3["value"];
        //         }
        //     }

        // }

        $direccion = "<italic>". $viaString . "&nbsp;" . $numeroString . "&nbsp;"  . $letraString . "&nbsp;"  . $bisString . "&nbsp;"  . $letra2String  . "&nbsp;" . $puntoCardinalString . "&nbsp;"  . $letraNumero . "&nbsp;"  . $puntoCardinal2String  . "&nbsp;" . $adicional ."</italic>";

        $arr[0][4] = array(
            "type" => "text",
            "required" => "",
            "label" => "Dirección",
            "className" => "form-control dea-input",
            "name" => "",
            "subtype" => "text",
            "value" => $direccion,
        );

        array_splice($arr[0], 5, 9);

        
        $formValue->json = json_encode($arr);


        return $formValue;
    }


    public function download($id)
    {


            $formularios = FormValue::where("form_id", $id)->get();
            #$formValue =

            $resultado = array();
               // try {
                foreach ($formularios as $key => $value) {
                    //echo $key;


                    $formValue = FormValue::find($value->id);
                    //print_r($formValue);
                    $array      = json_decode($formValue->json);


                    if($formValue->form_id == 13){
                        

                        $arr = json_decode($formValue->json,true);
                        $identificacionCampo = array_filter($arr[0], function($campo) {

                        if($campo['label'] == "Número de documento de identificación del paciente"){
                            return $campo;
                          }
                          return null;
                        });
                        if(isset($identificacionCampo[8])){

                        $numeroDocumento = $identificacionCampo[8]["value"];


                        $formValue2 = FormValue::where("form_id", 14)
                                                ->where("json", 'LIKE', '%'.'"value":"'.$numeroDocumento.'"}'.'%', )
                                                ->whereDate('created_at', '=', $formValue->created_at)
                                                ->first();

                        if($formValue2 != null){
                            $listas = array_merge(json_decode($formValue->json), json_decode($formValue2->json));

                            $formValue->json = json_encode($listas);

                            $array = $listas;
                        }

                        }
                        

                    }

                    if($formValue->form_id == 14){
                        

                        $arr = json_decode($formValue->json,true);
                        $identificacionCampo = array_filter($arr[0], function($campo) {

                          if($campo['label'] == "Número de documento de identidad"){
                            return $campo;
                          }
                          return null;
                        });

                        $numeroDocumento = $identificacionCampo[5]["value"];

                        $formValue2 = FormValue::where("form_id", 13)
                                                ->where("json", 'LIKE', '%'.'"value":"'.$numeroDocumento.'"}'.'%', )
                                                ->whereDate('created_at', '=', $formValue->created_at)
                                                ->first();
                        
                        if($formValue2 != null){
                            $listas = array_merge(json_decode($formValue2->json), json_decode($formValue->json));

                            $formValue->json = json_encode($listas);

                            $array = $listas;
                        }else{
                            continue;
                        }
                        

                    }


                    if($formValue->form_id == 33){

                        $formValue = $this->concatenarDireccion($formValue);
                        $array = json_decode($formValue->json);
                    }

                    if($formValue->form_id == 7){

                        $formValue = $this->concatenarDireccionForm7($formValue);
                        $array = json_decode($formValue->json);
                    }


                    array_push($resultado, $array);
                }


            return view('form-value.download', compact('formValue', 'resultado'));
    }

    public function edit($id)
    {
        $usr             = \Auth::guard('api')->user();
        //$userRole       = $usr->roles->first()->id;
        $userRole       = $usr->rol == "Administrador" || "Operativo SSM" || "Usuario consulta E" || "Usuario operador 1" || "Usuario operador 2";
        $formValue      = FormValue::find($id);
        $formallowededit = UserForm::where('role_id', $userRole)->where('form_id', $formValue->form_id)->count();
        if (\Auth::guard('api')->user()->rol == 'Administrador' || 'Operativo SSM' || 'Usuario consulta E') {

            $array  = json_decode($formValue->json);
            $form   = $formValue->Form;
            $frm    = Form::find($formValue->form_id);
                $form_value = $formValue;
            return view('form.fill', compact('form', 'formValue', 'array', 'form_value'));


            
        } else {
            if (\Auth::guard('api')->user()->can('edit-submitted-form') && $formallowededit > 0) {
                $formValue = FormValue::find($id);
                $userRole  = $usr->rol == "Administrador" || "Operativo SSM" || "Usuario consulta E" || "Usuario operador 1" || "Usuario operador 2";
                $array      = json_decode($formValue->json);
                $form       = $formValue->Form;
                $frm        = Form::find($formValue->form_id);
                return view('form.fill', compact('form', 'formValue', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Acceso denegado.'));
            }
        }
    }

    public function destroy($id)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM" || "Usuario consulta E" || "Usuario operador 1" || "Usuario operador 2") {
            FormValue::find($id)->delete();
            return redirect()->back()->with('success',  __('Formulario eliminado exitosamente.'));
        } else {
            return redirect()->back()->with('error', __('Acceso denegado.'));
        }
    }

    public function downloadPdf($id)
    {
        $formValue = FormValue::where('id', $id)->first();
        if ($formValue) {
            $formValue->createPDF();
        } else {
            $formValue = FormValue::where('id', '=', $id)->first();
            if (!$formValue) {
                $id         = Crypt::decryptString($id);
                $formValue = FormValue::find($id);
            }
            if ($formValue) {
                $formValue->createPDF();
            } else {
                return redirect()->route('home')->with('error', __('Archivo inexistente.'));
            }
        }
    }

    public function export(Request $request)
    {
        $form = Form::find($request->form_id);
        return Excel::download(new FormValuesExport($request), $form->title . '.csv');
    }

    public function downloadCsv2($id)
    {
        $formValue = FormValue::where('id', '=', $id)->first();
        if (!$formValue) {
            $id         = Crypt::decryptString($id);
            $formValue = FormValue::find($id);
        }
        if ($formValue) {
            $formValue->createCSV2();
            return response()->download(storage_path('app/public/csv/Survey_' . $formValue->id . '.xlsx'))->deleteFileAfterSend(true);
        } else {
            return redirect()->route('home')->with('error', __('Archivo inexistente.'));
        }
    }

    public function exportXlsx(Request $request)
    {
        if($request->select_date != ''){

            $form           = Form::find($request->form_id);
            $dateRange  = $request->select_date;
            list($startDate, $endDate) = array_map('trim', explode('to', $dateRange));
        }
        else{
            $form  = Form::find($request->form_id);
            $startDate = '';
            $endDate = '';
        }
        return Excel::download(new FormValuesExport($request , $startDate , $endDate), $form->title . '.xlsx');
    }

    public function getGraphData(Request $request, $id)
    {
        $form       = Form::find($id);
        $chartData  = UtilityFacades::dataChart($id);
        return view('form-value.chart', compact('chartData', 'id', 'form'));
    }

    public function VideoStore(Request $request)
    {
        $file      = $request->file('media');
        $extension = $file->getClientOriginalExtension();
        $filename  = $file->store('form_video');
        $values    = $filename;
        return response()->json(['success' => 'Video subido exitosamente.', 'filename' => $values]);
    }


    public function SelfieDownload($id)
    {

        $data           = FormValue::find($id);
        $json           = $data->json;
        $jsonData       = json_decode($json, true);
        $selfieValue    = null;
        foreach ($jsonData[0] as $field) {
            if ($field['type'] === 'selfie') {
                $selfieValue = $field['value'];
                break;
            } elseif ($field['type'] === 'video') {
                $selfieValue = $field['value'];
                break;
            }
        }
        if ($selfieValue === null) {
            return redirect()->back()->with('errors', __('Valor de imagen no encontrado'));
        }
        $filePath = storage_path('app/' . $selfieValue);
        return response()->download($filePath);
    }



    public function matchAndShow() {
        // Obtener envíos de ID de formulario 9
        $form9Submissions = Form::where('form_id', 9)->get();
        // Obtener envíos de ID de formulario 33
        $form33Submissions = Form::where('form_id', 33)->get();
    
        // Iterar a través de cada envío de ID de formulario 9
        foreach ($form9Submissions as $form9Submission) {
            // Obtener la opción seleccionada del formulario id 9 en el label "Nombre del lugar asignado"
            $selectedOptionForm9 = $form9Submission->$campo['label'] == "Nombre del lugar asignado";

            // Luego iterar a través de cada formulario id 33 
              foreach ($form33Submissions as $form33Submission) {
               // Obtener la opción seleccionada del formulario id 33 en el label "Nombre del lugar"
                $selectedOptionForm33 = $form33Submission->$campo['label'] == "Nombre del lugar";
                //Comprueba si las opciones seleccionadas coinciden
                if ($selectedOptionForm9 === $selectedOptionForm33) {
                    // Encuentra los usuarios de rol "Usuario consulta E"
                    $usuariosEntidad = (\Auth::guard('api')->user()->rol == 'Administrador' || "Usuario consulta E")->get();
                    //$usuariosEntidad = User::where('role', 'Usuario consulta E')->get();
                    foreach ($usuariosEntidad as $usuarioEntidad) {
                        // Aquí puedes visualizar la información dentro de la ruta /form-value/33/view según el usuario
                        echo "Información coincidente del formulario ID 33: ";
                        echo json_encode($form33Submission->data) . "<br>";
                    }
                }
            }
        }
    }


    

}