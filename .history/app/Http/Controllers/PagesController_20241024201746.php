<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormValue;
use Carbon\Carbon;
// use Excel;
// use Maatwebsite\Excel;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;



class RegistroOperadorEntidad implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([


            "Lugar asignado" => $row[0],
            "Nombre completo del operador" => $row[1],
            "Correo electr�nico" => $row[2],
            "Contrase�a" => $row[3],
            "Tipo de documento" => $row[4],
            "N�mero de documento" => $row[5],
            "Rol/Cargo" => $row[6],
            "Edad" => $row[7]
        ]);
    }
}

class RegistroOperadorSSM implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([
            "Nombre completo del operador" => $row[0],
            "Correo electr�nico" => $row[1],
            "Contrase�a" => $row[2],
            "Tipo de documento" => $row[3],
            "N�mero de documento" => $row[4],
            "Rol/Cargo" => $row[5],
            "Edad" => $row[6]
        ]);
    }
}


class RegistroEspacios implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([


            "Nombre del lugar" => $row[0],
            "V�a" => $row[1],
            "N�mero" => $row[2],
            "#" => $row[3],
            "Letra" => $row[4],
            "Bis" => $row[5],
            "Letra2" => $row[6],
            "Punto cardinal" => $row[7],
            "Letra o N�mero" => $row[8],
            "Punto cardinal2" => $row[9],
            "Informaci�n complementaria" => $row[10],
            "C�digo Postal" => $row[11],
            "Carga imagen" => $row[12],
        ]);
    }
}

                          
class RegistroRepresentanteLegal implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([
            "Nombre del representante legal" => $row[0],
            "Tipo de documento" => $row[1],
            "N�mero de documento" => $row[2],
            "Fecha (dd/mm/yyyy)" => $row[3]
        ]);
    }
}


class RegistroDea implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([
            "Representante legal" => $row[0],
            "Nombre del lugar" => $row[1],
            "V�a" => $row[2],
            "N�mero" => $row[3],
            "#" => $row[4],
            "Letra" => $row[5],
            "Bis" => $row[6],
            "Letra" => $row[7],
            "Punto cardinal" => $row[8],
            "Letra o N�mero" => $row[9],
            "Punto cardinal" => $row[10],
            "Informaci�n complementaria" => $row[11],
            "C�digo postal" => $row[12],
            "Coordenada: Longitud" => $row[13],
            "Coordenada: Latitud" => $row[14],
            "Tipo de declaraci�n" => $row[15],
            "Tipo de instalaci�n" => $row[16],
            "Tipo de espacio" => $row[17],
            "Otros datos" => $row[18],
            "Fecha de registro" => $row[19],
            "N�mero de serie" => $row[20],
            "Modelo" => $row[21],
            "Marca" => $row[22],
            "Importador autorizado" => $row[23],
            "Lugar de ubicaci�n" => $row[24]
        ]);
    }
}

class RegistroActaVisita implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([
            'Fecha del acta' => $row[0],
            'Ti�tulo del acta' => $row[1],
            'Lugar-DEA visitado' => $row[2],
            'Estado del DEA' => $row[3],
            '�Cuenta con personal al interior de su entidad u Organizaci�n con certificaci�n vigente en RCP (menor a 2 a�os)?' => $row[4],
            '�Conoce cuanto es la vida �til de un DEA?' => $row[5],
            '�Cuenta con personal capacitado para el uso del DEA? Minimo dos personas' => $row[6],
            '�Cada cuanto realiza entrenamiento al personal definido para el uso del DEA?' => $row[7],
            '�En qu� entidad el personal realiza el entrenamiento para el uso del DEA?' => $row[8],
            '�La entidad u Organizaci�n cuenta con un protocolo de atenci�n y respuesta ante un paro cardio respiratorio?' => $row[9],
            '�Cu�l es el centro asistencial que tienen establecido, como ruta para el traslado en caso de presentarse un evento de paro cardiorrespiratorio?' => $row[10],
            '�Cu�nto es el tiempo m�ximo en el que se encuentra en centro asistencial?' => $row[11],
            '�Cu�ntos DEA considera que deben estar instalados teniendo en cuenta la afluencia de este lugar?' => $row[12],
            '�Los DEA est�n ubicados en sitios de mayor circulaci�n tales como, auditorios, recepci�n, salones sociales o de eventos, oficinas, salas de espera, primeros auxilios, cafeter�a, entre otros?' => $row[13],
            '�Cuenta con la hoja de vida de cada equipo, la cual deber� contener la marca, modelo, n�mero de serie, n�mero del permiso de comercializaci�n, nombre del fabricante, nombre del importador, cronograma y soportes del mantenimiento preventivo o correctivo?' => $row[14],
            'Observaciones del acta' => $row[15],
        ]);
    }
}

class RegistroPlanMejora implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return array([
            'Titulo plan' => $row[0],
            'DEA en revisi�n' => $row[1],
            'Descripci�n detallada del plan de mejora' => $row[2],
            'Carga de imagen 1' => $row[3],
            'Carga de imagen 2' => $row[4],
            'Carga de imagen 3' => $row[5],
            'Carga de imagen 4' => $row[6],
            'Carga de imagen 5' => $row[7],
        ]);
    }
}



class PagesController extends Controller
{
    //USUARIO ADMINISTRADOR
    
    public function index(){
        return view('user-administrador/index');
    }
    public function creacionusuario(){
        return view('user-administrador/creacion-usuario');
    }
    public function detalleinstalacion(){
        return view('user-administrador/detalle-instalacion');
    }
    public function detalleusuarios(){
        return view('user-administrador/detalle-usuarios');
    }
    public function formulariocampodea(){
        return view('user-administrador/formulario-campo-dea');
    }
    public function formulariocampopersona(){
        return view('user-administrador/formulario-campo-persona');
    }
    public function formulariocampouso(){
        return view('user-administrador/formulario-campo-uso');
    }
    public function gestioninformacion(){
        return view('user-administrador/gestion-informacion');
    }
    public function informacionespacios(){
        return view('user-administrador/informacion-espacios');
    }
    public function informacioninstalacion(){
        return view('user-administrador/informacion-instalacion');
    }
    public function informacionusuarios(){
        return view('user-administrador/informacion-usuarios');
    }
    public function informacionreporteuso(){
        return view('user-administrador/informacion-reporteuso');
    }
    public function registroespacios(){
        return view('user-administrador/registro-espacios');
    }
    public function registrousuarios(){
        return view('user-administrador/registro-usuarios');
    }

/*
    public function tablerosuseradmin(Request $request) {
        // Obtener todas las respuestas si no se ha aplicado ningún filtro de fecha
        $respuestas = FormValue::where("form_id", 14);
        $respuestas2 = FormValue::where("form_id", 11);
    
        // Filtrado por una fecha específica
        if ($request->filled('single')) {
            $fecha = Carbon::parse($request->single);
            $respuestas->whereDate('created_at', $fecha);
            $respuestas2->whereDate('created_at', $fecha);
        }
    
        // Filtrado por un rango de fechas
        if ($request->filled('rango')) {
            $rango = explode(" to ", $request->rango);
            if (count($rango) == 2) {
                $start = Carbon::parse($rango[0]);
                $end = Carbon::parse($rango[1]);
                $respuestas->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
                $respuestas2->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
            }
        }
    
        // Ejecutar las consultas filtradas
        $respuestas = $respuestas->get();
        $respuestas2 = $respuestas2->get();
    
        // Construir lista de uso del DEA
        $lista = array();
        foreach ($respuestas as $value) {
            array_push($lista, [
                'mes' => date("m", strtotime($value->updated_at)),
            ]);
        }
    
        // Construir lista de edades promedio
        $lista3 = array();
        foreach ($respuestas as $value) {
            $arr = json_decode($value->json, true);
            $nombre = array_filter($arr[0], function ($campo) {
                return $campo['label'] == "Edad";
            });
    
            array_push($lista3, [
                "edad" => $nombre[6]["value"]
            ]);
        }
    
        // Construir lista de instalaciones del DEA
        $lista2 = array();
        foreach ($respuestas2 as $value) {
            $arr = json_decode($value->json, true);
            $nombre = array_filter($arr[0], function ($campo) {
                return $campo['label'] == "Cantidad de DEAs";
            });
    
            array_push($lista2, [
                'mes' => date("m", strtotime($value->updated_at)),
                "cantidad" => $nombre[7]["value"]
            ]);
        }
    
        return view('user-administrador/tableros-useradmin', compact('lista', 'lista2', 'lista3'));
    }*/
    
    public function tablerosuseradmin(Request $request)
    {
        // Obtener todas las respuestas si no se ha aplicado ningún filtro de fecha
        $respuestas = FormValue::where("form_id", 14);
        $respuestas2 = FormValue::where("form_id", 11);
    
        // Filtrado por una fecha específica (campo 'single')
        if ($request->filled('single')) {
            $fecha = Carbon::parse($request->single);
            $respuestas->whereDate('created_at', $fecha);
            $respuestas2->whereDate('created_at', $fecha);
        }
    
        // Filtrado por un rango de fechas (campo 'rango')
        if ($request->filled('rango')) {
            $rango = explode(" to ", $request->rango);
            if (count($rango) == 2) {
                $start = Carbon::parse($rango[0]);
                $end = Carbon::parse($rango[1]);
                $respuestas->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
                $respuestas2->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
            }
        }
    
        // Ejecutar las consultas filtradas
        $respuestas = $respuestas->get();
        $respuestas2 = $respuestas2->get();
    
        // Construir lista de uso del DEA
        $lista = array();
        foreach ($respuestas as $value) {
            array_push($lista, [
                'mes' => date("m", strtotime($value->created_at)),  // Se usa created_at para coherencia con el filtro
            ]);
        }
    
        // Construir lista de edades promedio
        $lista3 = array();
        foreach ($respuestas as $value) {
            $arr = json_decode($value->json, true);
           
            // Revisamos que exista el índice antes de usarlo
            if (isset($arr[0]) && is_array($arr[0])) {
                $nombre = array_filter($arr[0], function ($campo) {
                    return isset($campo['label']) && $campo['label'] == "Edad";  // Verificar que 'label' esté definido
                });
    
                // Verificar si la edad está en la posición esperada (índice 6)
                if (isset($nombre[6]["value"])) {
                    array_push($lista3, [
                        "edad" => $nombre[6]["value"]
                    ]);
                }
            }
        }
    
        // Construir lista de instalaciones del DEA
        $lista2 = array();
        foreach ($respuestas2 as $value) {
            $arr = json_decode($value->json, true);
           
            // Revisamos que exista el índice antes de usarlo
            if (isset($arr[0]) && is_array($arr[0])) {
                $nombre = array_filter($arr[0], function ($campo) {
                    return isset($campo['label']) && $campo['label'] == "Cantidad de DEAs";  // Verificar que 'label' esté definido
                });
    
                // Verificar si la cantidad de DEAs está en la posición esperada (índice 7)
                if (isset($nombre[7]["value"])) {
                    array_push($lista2, [
                        'mes' => date("m", strtotime($value->created_at)),  // Se usa created_at para coherencia con el filtro
                        "cantidad" => $nombre[7]["value"]
                    ]);
                }
            }
        }
    
        // Enviar las listas a la vista
        return view('user-administrador/tableros-useradmin', compact('lista', 'lista2', 'lista3'));


    }

    public function reportesuseradmin(){
        return view('user-administrador/reportes-useradmin');
    }
    
 
    //USUARIO OPERADOR 1
    public function index2(){
        return view('user-operador1/index');
    }
    public function formularioanexo2(){
        return view('user-operador1/formulario-anexo2');
    }
    public function formularioanexo25(){
        return view('user-operador1/formulario-anexo25');
    }
    public function formularioanexo3(){
        return view('user-operador1/formulario-anexo3');
    }
    public function formularioeventoencurso(){
        return view('user-operador1/formulario-eventoencurso');
    }
    public function menuanexo3(){
        return view('user-operador1/menu-anexo3');
    }
    public function opcionesformulario(){
        return view('user-operador1/opciones-formulario');
    }
    public function formularioinfoevento(){
        return view('user-operador1/formulario-infoevento');
    }

     //USUARIO OPERADOR 2
     public function indexoperador2(){
        return view('user-operador2/index');
    }

    //USUARIO CONSULTA ENTIDAD
    public function indexconsultaentidad(){
        return view('user-consultaentidad/index');
    }

     //USUARIO OPERATIVO
     public function indexoperativo(){
        return view('user-operativo/index');
    }

   /*public function historicousuarios(){
    return view('user-operativo/historico-usuarios');
    }*/

     //USUARIO CONSULTA SSM
     public function indexconsultassm(){
        return view('user-consultassm/index');
    }

    public function agendamientoplanesrepo(){
        return view('user-consultassm/agendamiento-planesrepo');
    }

    public function consssmagendamiento(){
        return view('user-consultassm/consssm-agendamiento');
    }

    public function consssmplaneacion(){
        return view('user-consultassm/consssm-planeacion');
    }

    public function consssmseguimiento(){
        return view('user-consultassm/consssm-seguimiento');
    }

    public function consultausodea(){
        return view('user-consultassm/consultauso-dea');
    }

    public function informeubicaciondeas(){

        $formValue2 = FormValue::where("form_id", 12)->get();


        $coordenadas = array();
        foreach ($formValue2 as $i => $formulario) {
            $arr = json_decode($formulario->json,true);

            $dea = $arr[0][4];

            $nombreDea = "";

            foreach ($dea["values"] as $key => $value) {
                if(isset($value["selected"]) && $value["selected"] == 1){
                    // echo $value["label"];

                    $nombreDea = $value["label"];
                }
            }

            array_push($coordenadas, ["longitud" => $arr[0][8]["value"], "latitud" => $arr[0][9]["value"], "dea" =>  $nombreDea]);
        }

        return view('user-consultassm/informe-ubicaciondeas', compact('coordenadas'));
    }

    public function regequiposdea(){
            return view('user-consultassm/regequipos-dea');
    }

    public function eventoscriticosactivos(){

        $formValue2 = FormValue::where("form_id", 33)->get();


        $coordenadas = array();
        foreach ($formValue2 as $i => $formulario) {
            $arr = json_decode($formulario->json,true);

            $dea = $arr[0][3];

            $nombreDea = "";

            foreach ($dea["values"] as $key => $value) {
                if(isset($value["selected"]) && $value["selected"] == 1){
                    // echo $value["label"];

                    $nombreDea = $value["label"];
                }
            }

            array_push($coordenadas, ["longitud" => $arr[0][19]["value"], "latitud" => $arr[0][20]["value"], "dea" =>  $nombreDea]);
        }


        return view('user-consultassm/eventos-criticosactivos', compact('coordenadas'));
    
   }

   /**PARA CARGA MASIVA */

   public function cargamasiva(){

    // print_r();


    return view('user-administrador/carga-masiva');
   }

   public function cargamasivaExcel(Request $request){

    if(!$request->files->get('archivos')){
        $resultado = "Recuerde cargar un archivo";
        return view('user-administrador/carga-masiva', compact('resultado'));
    }

    

    $resultado = "";
    $error = "";

    if($request->formulario == 9){
        $archivo = Excel::toArray(new RegistroOperadorEntidad, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        $result = $this->cargamasivaRegstroOperadorEntidad($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }

    if($request->formulario == 39){
        $archivo = Excel::toArray(new RegistroOperadorSSM, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        $result = $this->cargamasivaRegstroOperadorSSM($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }

    if($request->formulario == 7){
        $archivo = Excel::toArray(new RegistroEspacios, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        // print_r($archivo);
        // return "";

        $result = $this->cargamasivaRegstroLugar($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }

    if($request->formulario == 31){
        $archivo = Excel::toArray(new RegistroRepresentanteLegal, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        $result = $this->cargamasivaRepresentanteLegal($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }


    if($request->formulario == 33){
        $archivo = Excel::toArray(new RegistroDea, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        $result = $this->cargamasivaRegistroDea($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }

    if($request->formulario == 18){
        $archivo = Excel::toArray(new RegistroActaVisita, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        $result = $this->cargamasivaActaVisita($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }

    if($request->formulario == 19){
        $archivo = Excel::toArray(new RegistroPlanMejora, $request->files->get('archivos'), \Maatwebsite\Excel\Excel::XLSX);

        $result = $this->cargamasivaPlanMejora($archivo);

        if($result != ""){
            $error = $result;
        }else{
             $resultado = "¡Los datos se cargaron con éxito!";
        }
    }


    return view('user-administrador/carga-masiva', compact('resultado', 'error'));
   }

   public function cargamasivaPlanMejora($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $TituloPlan = $value[0];
                $DEARevision = $value[1];
                $Descripcion = $value[2];
                $Imagen1 = $value[3];
                $Imagen2 = $value[4];
                $Imagen3 = $value[5];
                $Imagen4 = $value[6];
                $Imagen5 = $value[7];



                $form = Form::find(19);
                $array = $form->getFormArray();


                $array[0][0]->value = $TituloPlan;
                $array[0][2]->value = $Descripcion;
                
                //$array[0][3]->value = ["form-values/19/fF6SpOj04S9MlNXyvSVumIpfSZzoBvV3jP1ldZNk.png", "form-values/19/fF6SpOj04S9MlNXyvSVumIpfSZzoBvV3jP1ldZNk.png"];
                
                $listaImagenes = [];

                if($Imagen1 != ""){
                    array_push($listaImagenes, $Imagen1);
                }

                if($Imagen2 != ""){
                    array_push($listaImagenes, $Imagen2);
                }
                if($Imagen3 != ""){
                    array_push($listaImagenes, $Imagen3);
                }
                if($Imagen4 != ""){
                    array_push($listaImagenes, $Imagen4);
                }
                if($Imagen5 != ""){
                    array_push($listaImagenes, $Imagen5);
                }

                $array[0][3]->value = $listaImagenes;


                // Lugar Visitado
                foreach ($array[0][1]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $DEARevision, $sim) && $sim > 90){
                        $array[0][1]->values[$key]->selected = 1;
                        $array[0][1]->values[0]->selected = null;
                    }else{
                        $array[0][1]->values[$key]->selected = null;
                    }
                }


                


                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }


   public function cargamasivaActaVisita($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $FechaActa = $value[0];
                $TituloActa = $value[1];
                $LugarVisitado = $value[2];
                $EstadoDEA = $value[3];
                $Pregunta1 = $value[4];
                $Pregunta2 = $value[5];
                $Pregunta3 = $value[6];
                $Pregunta4 = $value[7];
                $Pregunta5 = $value[8];
                $Pregunta6 = $value[9];
                $Pregunta7 = $value[10];
                $Pregunta8 = $value[11];
                $Pregunta9 = $value[12];
                $Pregunta10 = $value[13];
                $Pregunta11 = $value[14];
                $ObservacionesActa = $value[15];



                $form = Form::find(18);
                $array = $form->getFormArray();


                $array[0][0]->value = $FechaActa;
                $array[0][1]->value = $TituloActa;
                
                $array[0][4]->value = $Pregunta1;
                $array[0][5]->value = $Pregunta2;
                $array[0][6]->value = $Pregunta3;
                $array[0][7]->value = $Pregunta4;
                $array[0][8]->value = $Pregunta5;
                $array[0][9]->value = $Pregunta6;
                $array[0][10]->value = $Pregunta7;
                $array[0][11]->value = $Pregunta8;
                $array[0][12]->value = $Pregunta9;
                $array[0][13]->value = $Pregunta10;
                $array[0][14]->value = $Pregunta11;
                $array[0][15]->value = $ObservacionesActa;
                



                // Lugar Visitado
                foreach ($array[0][2]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $LugarVisitado, $sim) && $sim > 90){
                        $array[0][2]->values[$key]->selected = 1;
                        $array[0][2]->values[0]->selected = null;
                    }else{
                        $array[0][2]->values[$key]->selected = null;
                    }
                }

                // Estado Dea
                foreach ($array[0][3]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $EstadoDEA, $sim) && $sim > 90){
                        $array[0][3]->values[$key]->selected = 1;
                        $array[0][3]->values[0]->selected = null;
                    }else{
                        $array[0][3]->values[$key]->selected = null;
                    }
                }

                


                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }


   public function cargamasivaRegistroDea($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $RepresentanteLegal = $value[0];
                $NombreLugar = $value[1];
                $Via = $value[2];
                $Numero = $value[3];
                $Num = $value[4];
                $Letra = $value[5];
                $Bis = $value[6];
                $Letra2 = $value[7];
                $PuntoCardinal = $value[8];
                $LetraNumero = $value[9];
                $PuntoCardinal2 = $value[10];
                $InformacionComplementaria = $value[11];
                $Codigopostal = $value[12];
                $Longitud = $value[13];
                $Latitud = $value[14];
                $TipoDeclaracion = $value[15];
                $TipoInstalacion = $value[16];
                $TipoEespacio = $value[17];
                $OtrosDatos = $value[18];
                $FechaRegistro = $value[19];
                $NumeroSerie = $value[20];
                $Modelo = $value[21];
                $Marca = $value[22];
                $ImportadorAutorizado = $value[23];
                $LugarUbicacion = $value[24];



                $form = Form::find(33);
                $array = $form->getFormArray();


                $array[0][8]->value = $Numero;
                $array[0][9]->value = $Num;
                $array[0][14]->value = $LetraNumero;
                $array[0][16]->value = $InformacionComplementaria;
                $array[0][18]->value = (int)$Codigopostal;
                $array[0][19]->value = (int)$Longitud;
                $array[0][20]->value = (int)$Latitud;
                $array[0][23]->value = $TipoEespacio;
                $array[0][24]->value = $OtrosDatos;


                $array[1][1]->value = $FechaRegistro;
                $array[1][3]->value = $NumeroSerie;
                $array[1][4]->value = $Modelo;
                $array[1][5]->value = $Marca;
                $array[1][6]->value = $ImportadorAutorizado;
                $array[1][7]->value = $LugarUbicacion;


                // Representante Legal
                foreach ($array[0][2]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $RepresentanteLegal, $sim) && $sim > 90){
                        $array[0][2]->values[$key]->selected = 1;
                        $array[0][2]->values[0]->selected = null;
                    }else{
                        $array[0][2]->values[$key]->selected = null;
                    }
                }

                // Lugar
                foreach ($array[0][3]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $NombreLugar, $sim) && $sim > 90){
                        $array[0][3]->values[$key]->selected = 1;
                        $array[0][3]->values[0]->selected = null;
                    }else{
                        $array[0][3]->values[$key]->selected = null;
                    }
                }

                // V�a
                foreach ($array[0][7]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $Via, $sim) && $sim > 90){
                        $array[0][7]->values[$key]->selected = 1;
                        $array[0][7]->values[0]->selected = null;
                    }else{
                        $array[0][7]->values[$key]->selected = null;
                    }
                }

                // Letra
                foreach ($array[0][10]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $Letra, $sim) && $sim > 90){
                        $array[0][10]->values[$key]->selected = 1;
                        $array[0][10]->values[0]->selected = null;
                    }else{
                        $array[0][10]->values[$key]->selected = null;
                    }
                }

                // Bis
                foreach ($array[0][11]->values as $key => $value) {
                    
                    if($Bis != ""){
                        $array[0][11]->values[$key]->selected = 1;
                    }
                }

                // Letra
                foreach ($array[0][12]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $Letra2, $sim) && $sim > 90){
                        $array[0][12]->values[$key]->selected = 1;
                        $array[0][12]->values[0]->selected = null;
                    }else{
                        $array[0][12]->values[$key]->selected = null;
                    }
                }


                // Punto Cardinal
                foreach ($array[0][13]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $PuntoCardinal, $sim) && $sim > 90){
                        $array[0][13]->values[$key]->selected = 1;
                        $array[0][13]->values[0]->selected = null;
                    }else{
                        $array[0][13]->values[$key]->selected = null;
                    }
                }

                // Punto Cardinal
                foreach ($array[0][15]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $PuntoCardinal2, $sim) && $sim > 90){
                        $array[0][15]->values[$key]->selected = 1;
                        $array[0][15]->values[0]->selected = null;
                    }else{
                        $array[0][15]->values[$key]->selected = null;
                    }
                }

                // Tipo Declaraci�n
                foreach ($array[0][21]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $TipoDeclaracion, $sim) && $sim > 90){
                        $array[0][21]->values[$key]->selected = 1;
                        $array[0][21]->values[0]->selected = null;
                    }else{
                        $array[0][21]->values[$key]->selected = null;
                    }
                }

                // Tipo Instalaci�n
                foreach ($array[0][22]->values as $key => $value) {
                    $sim = 0;
                    if(similar_text($value->label, $TipoInstalacion, $sim) && $sim > 90){
                        $array[0][22]->values[$key]->selected = 1;
                        $array[0][22]->values[0]->selected = null;
                    }else{
                        $array[0][22]->values[$key]->selected = null;
                    }
                }


                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }


   public function cargamasivaRepresentanteLegal($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $NombrRepresentante = $value[0];
                $TipDocumento = $value[1];
                $NumeroDocumento = $value[2];
                $Fecha = $value[3];



                $form = Form::find(31);
                $array = $form->getFormArray();


                $array[0][0]->value = $NombrRepresentante;
                $array[0][2]->value = (int)$NumeroDocumento;
                $array[0][8]->value = $Fecha;


                // Tipo documento
                foreach ($array[0][1]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $TipDocumento, $sim) && $sim > 90){
                        $array[0][1]->values[$key]->selected = 1;
                        $array[0][1]->values[0]->selected = null;
                    }else{
                        $array[0][1]->values[$key]->selected = null;
                    }

                }


                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }



   public function cargamasivaRegstroLugar($archivo){


        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){


                $NombreLugar = $value[0];
                $Via = $value[1];
                $Numero = $value[2];
                $SignoNumero = $value[3];
                $Letra = $value[4];
                $Bis = $value[5];
                $Letra2 = $value[6];
                $PuntoCardinal = $value[7];
                $LetraNumero = $value[8];
                $PuntoCardinal2 = $value[9];
                $InformacionComplementaria = $value[10];
                $CodigoPostal = $value[11];
                $CargaImagen = $value[12];



                $form = Form::find(7);
                $array = $form->getFormArray();


                $array[0][0]->value = $NombreLugar;
                $array[0][5]->value = $Numero;
                $array[0][6]->value = $SignoNumero;
                $array[0][11]->value =  $LetraNumero;
                $array[0][13]->value = $InformacionComplementaria;
                $array[0][15]->value = $CodigoPostal;
                $array[0][16]->value = $CargaImagen;


                if($NombreLugar == ""){
                    continue;
                }


                // Via
                foreach ($array[0][4]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $Via, $sim) && $sim > 90){
                        $array[0][4]->values[$key]->selected = 1;
                        $array[0][4]->values[0]->selected = null;
                    }else{
                        $array[0][4]->values[$key]->selected = null;
                    }

                }

                // Letra
                foreach ($array[0][7]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $Letra, $sim) && $sim > 90){
                        $array[0][7]->values[$key]->selected = 1;
                        $array[0][7]->values[0]->selected = null;
                    }else{
                        $array[0][7]->values[$key]->selected = null;
                    }

                }


                // Bis
                foreach ($array[0][8]->values as $key => $value) {
                    
                    if($Bis != ""){
                        $array[0][8]->values[$key]->selected = 1;
                    }
                }


                 // Letra 2
                foreach ($array[0][9]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $Letra2, $sim) && $sim > 90){
                        $array[0][9]->values[$key]->selected = 1;
                        $array[0][9]->values[0]->selected = null;
                    }else{
                        $array[0][9]->values[$key]->selected = null;
                    }

                }

                // Punto cardinal
                foreach ($array[0][10]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $PuntoCardinal, $sim) && $sim > 90){
                        $array[0][10]->values[$key]->selected = 1;
                        $array[0][10]->values[0]->selected = null;
                    }else{
                        $array[0][10]->values[$key]->selected = null;
                    }

                }


                // Punto cardinal
                foreach ($array[0][12]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $PuntoCardinal2, $sim) && $sim > 90){
                        $array[0][12]->values[$key]->selected = 1;
                        $array[0][12]->values[0]->selected = null;
                    }else{
                        $array[0][12]->values[$key]->selected = null;
                    }

                }




                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;



                $tempForm = Form::find(9);
                $arr = json_decode($tempForm->json,true);
                foreach($arr[0] as $i => $item) { //foreach element in $arr

                    if($item["label"] == "Nombre del lugar asignado"){
                       
                        array_push($item["values"], 
                            [
                            'label' => strtoupper($NombreLugar),
                            'value' => $formValue->id,
                            'selected' => false
                            ]);

                        $arr[0][$i]["values"] = $item["values"];

                    }

                }

                $tempForm->json = json_encode($arr);
                $tempForm->save();


                $tempForm = Form::find(33);
                $arr = json_decode($tempForm->json,true);
                foreach($arr[0] as $i => $item) { //foreach element in $arr

                    if($item["label"] == "Nombre del lugar"){
                       
                        array_push($item["values"], 
                            [
                            'label' => strtoupper($NombreLugar),
                            'value' => $formValue->id,
                            'selected' => false
                            ]);

                        $arr[0][$i]["values"] = $item["values"];

                    }

                }

                $tempForm->json = json_encode($arr);
                $tempForm->save();


            }
            
        }
        
        return $resultado;
   }


   public function cargamasivaRegstroOperadorEntidad($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $LugarAsignado = $value[0];
                $NombrOperador = $value[1];
                $CorreoElectr�nico = $value[2];
                $Contrasena = $value[3];
                $TipDocumento = $value[4];
                $NumeroDocumento = $value[5];
                $Rol = $value[6];
                $Edad = $value[7];



                $form = Form::find(9);
                $array = $form->getFormArray();


                $array[0][2]->value = $NombrOperador;
                $array[0][3]->value = $CorreoElectr�nico;

                $array[0][4]->value =  (int)$NumeroDocumento;
                $array[0][5]->value = $Contrasena;
                $array[0][7]->value = (int)$NumeroDocumento;
                //$array[0][9]->value = (int)$Edad;

                if($CorreoElectr�nico == ""){
                    continue;
                }

                $formValue2 = FormValue::where("form_id", 9)->where("json", 'LIKE', '%'.'"value":"'.$CorreoElectr�nico.'"}'.'%', )->first();
                if($formValue2){
                    $resultado = $resultado . "</hr> El correo " . $CorreoElectr�nico . " ya existe";
                    continue;
                }


                // Lugar asiganado
                foreach ($array[0][1]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $LugarAsignado, $sim) && $sim > 90){
                        $array[0][1]->values[$key]->selected = 1;
                        $array[0][1]->values[0]->selected = null;
                    }else{
                        $array[0][1]->values[$key]->selected = null;
                    }

                }


                // Tipo documento
                foreach ($array[0][6]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $TipDocumento, $sim) && $sim > 90){
                        $array[0][6]->values[$key]->selected = 1;
                        $array[0][6]->values[0]->selected = null;
                    }else{
                        $array[0][6]->values[$key]->selected = null;
                    }

                }


                // Rol
                foreach ($array[0][8]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $Rol, $sim) && $sim > 98){
                        $array[0][8]->values[$key]->selected = 1;
                        $array[0][8]->values[0]->selected = null;
                    }else{
                        $array[0][8]->values[$key]->selected = null;
                    }

                }



                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }

   public function cargamasivaRegstroOperadorSSM($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $LugarAsignado = "No Aplica";
                $NombrOperador = $value[0];
                $CorreoElectronico = $value[1];
                $Contrasena = $value[2];
                $TipDocumento = $value[3];
                $NumeroDocumento = $value[4];
                $Rol = "Usuario consulta SSM";
                $Edad = $value[6];



                $form = Form::find(9);
                $array = $form->getFormArray();


                $array[0][2]->value = $NombrOperador;
                $array[0][3]->value = $CorreoElectronico;

                $array[0][4]->value =  (int)$NumeroDocumento;
                $array[0][5]->value = $Contrasena;
                $array[0][7]->value = (int)$NumeroDocumento;

                //$array[0][9]->value = (int)$Edad;

                if($CorreoElectronico == ""){
                    continue;
                }

                $formValue2 = FormValue::where("form_id", 9)->where("json", 'LIKE', '%'.'"value":"'.$CorreoElectronico.'"}'.'%', )->first();
                if($formValue2){
                    $resultado = $resultado . "</hr> El correo " . $CorreoElectronico . " ya existe";
                    continue;
                }


                // Lugar asiganado
                foreach ($array[0][1]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $LugarAsignado, $sim) && $sim > 90){
                        $array[0][1]->values[$key]->selected = 1;
                        $array[0][1]->values[0]->selected = null;
                    }else{
                        $array[0][1]->values[$key]->selected = null;
                    }

                }


                // Tipo documento
                foreach ($array[0][6]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $TipDocumento, $sim) && $sim > 90){
                        $array[0][6]->values[$key]->selected = 1;
                        $array[0][6]->values[0]->selected = null;
                    }else{
                        $array[0][6]->values[$key]->selected = null;
                    }

                }


                // Rol
                foreach ($array[0][8]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $Rol, $sim) && $sim > 98){
                        $array[0][8]->values[$key]->selected = 1;
                        $array[0][8]->values[0]->selected = null;
                    }else{
                        $array[0][8]->values[$key]->selected = null;
                    }

                }



                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }

   public function cargamasivaRegstroOperadorSSM1($archivo){

        $usr = \Auth::guard('api')->user();
        
        $resultado = "";
        foreach ($archivo[0] as $key => $value) {

            if($key > 0){

                $NombrOperador = $value[0];
                $CorreoElectronico = $value[1];
                $Contrasena = $value[2];
                $TipDocumento = $value[3];
                $NumeroDocumento = $value[4];
                $Rol = $value[5];
                $Edad = $value[6];



                $form = Form::find(39);
                $array = $form->getFormArray();


                $array[0][1]->value = $NombrOperador;
                $array[0][2]->value = $CorreoElectr�nico;

                $array[0][4]->value = $Contrasena;
                $array[0][3]->value = 12345;
                $array[0][6]->value = (int)$NumeroDocumento;
                $array[0][8]->value = (int)$Edad;

                if($CorreoElectr�nico == ""){
                    continue;
                }

                $formValue2 = FormValue::where("form_id", 39)->where("json", 'LIKE', '%'.'"value":"'.$CorreoElectronico.'"}'.'%', )->first();
                if($formValue2){
                    $resultado = $resultado . "</hr> El correo " . $CorreoElectr�nico . " ya existe";
                    continue;
                }



                // Tipo documento
                foreach ($array[0][5]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $TipDocumento, $sim) && $sim > 90){
                        $array[0][5]->values[$key]->selected = 1;
                        $array[0][5]->values[0]->selected = null;
                    }else{
                        $array[0][5]->values[$key]->selected = null;
                    }

                }


                // Rol
                foreach ($array[0][7]->values as $key => $value) {
                    
                    $sim = 0;
                    if(similar_text($value->label, $Rol, $sim) && $sim > 98){
                        $array[0][7]->values[$key]->selected = 1;
                        $array[0][7]->values[0]->selected = null;
                    }else{
                        $array[0][7]->values[$key]->selected = null;
                    }

                }



                $data = [];
                $data['form_id'] = $form->id;
                $data['user_id'] = $usr->id;
                $data['json']    = json_encode($array);
                $formValue = FormValue::create($data);

                // break;

            }
            
        }
        
        return $resultado;
   }
   
    
}