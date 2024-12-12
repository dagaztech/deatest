<?php

namespace App\Http\Controllers;

use App\DataTables\FormsDataTable;
use App\Facades\UtilityFacades;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\AssignFormsRoles;
use App\Models\AssignFormsUsers;
use App\Models\DashboardWidget;
use App\Models\Form;
use App\Models\FormComments;
use App\Models\FormCommentsReply;
use App\Models\FormIntegrationSetting;
use App\Models\formRule;
use App\Models\FormTemplate;
use App\Models\FormValue;
use App\Models\NotificationsSetting;
use App\Models\User;
use App\Models\UserForm;
use App\Notifications\CreateForm;
use App\Notifications\NewSurveyDetails;
use App\Rules\CommaSeparatedEmails;
use Carbon\Carbon;
use Exception;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Stripe\Charge;
use Stripe\Stripe as StripeStripe;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;
use DB;
use Illuminate\Support\Facades\Http;
use App\Mail\ConatctMail;
use App\Mail\BienvenidaSistema;
use App\Mail\RestauracionContrasena;
use App\Mail\RegistroECVCurso;
use App\Mail\RegistroLugarInstalacion;
use App\Mail\ProgramacionVisita;
use App\Mail\CreacionActaVisita;
use App\Mail\RegistroPersonaCertificada;
use App\Mail\RegistroDea;
use App\Models\HistoricoLog;
use HTTP_Request2;

class FormController extends Controller 
{
    public function index(FormsDataTable $dataTable)
    {
        if (\Auth::guard('api')->user()->rol = "Administrador" || "Operativo SSM")  {
            if (\Auth::guard('api')->user()->forms_grid_view == 1) {
                return redirect()->route('grid.form.view', 'view');
            }
            return $dataTable->render('form.index');
        } else {
            return redirect()->back()->with('failed', __('Permiso denegado.'));
        }
    }

    public function addForm()
    {
        $formTemplates = FormTemplate::where('created_by', \Auth::guard('api')->user()->id)->where('json', '!=', null)->where('status', 1)->get();
        return view('form.add', compact('formTemplates'));
    }

    public function create()
    {
        if (\Auth::guard('api')->user()->rol = "Administrador" || "Operativo SSM") {
            $users = User::where('id', '!=', 1)->pluck('name', 'id');
            $roles = DB::table('tbl_roles')->where('name', '!=', 'Super Admin')
                //->orwhere('name', Auth::guard('api')->user()->type)
                ->pluck('name', 'id');
            //$roles = 
            return view('form.create', compact('roles', 'users'));
        } else {
            return response()->json(['failed' => __('Permiso denegado.')], 401);
        }
    }

    public function useFormtemplate($id)
    {
        $formtemplate = FormTemplate::find($id);
        $form = Form::create([
            'title'     => $formtemplate->title,
            'json'      => $formtemplate->json,
        ]);
        return redirect()->route('forms.edit', $form->id)->with('success', __('Form created successfully.'));
    }


    public function store(Request $request)
    {
        if (\Auth::guard('api')->user()->rol = 'Administrador') {
            request()->validate([
                //'title'     => 'required|max:191',
                //'form_logo' => 'required|mimes:png,jpg,svg,jpeg'
            ]);

            if (isset($request->set_end_date) && $request->set_end_date == 'on') {
                request()->validate([
                    'set_end_date' => 'required',
                    'set_end_date_time' => 'required'
                ]);
            }
            $ccemails = implode(',', $request->ccemail);
            $bccemails = implode(',', $request->bccemail);
            if ($ccemails) {
                request()->validate([
                    'ccemail' => ['nullable', new CommaSeparatedEmails],
                ]);
            }
            if ($bccemails) {
                request()->validate([
                    'bccemail' => ['nullable', new CommaSeparatedEmails],
                ]);
            }
            request()->validate([
                'email' => ['nullable', new CommaSeparatedEmails],
            ]);

            $userSchema = User::where('id', '=', 4)->first();
            $filename = '';
            if (request()->file('form_logo')) {
                $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                $file = $request->file('form_logo');
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->store('form-logo');
                } else {
                    return redirect()->route('forms.index')->with('failed', __('File type not valid.'));
                }
            }
            if (isset($request->email) and !empty($request->email)) {
                $emails = implode(',', $request->email);
            }
            if (isset($request->ccemail) and !empty($request->ccemail)) {
                $ccemails = implode(',', $request->ccemail);
            }
            if (isset($request->bccemail) and !empty($request->bccemail)) {
                $bccemails = implode(',', $request->bccemail);
            }
            if (isset($request->set_end_date) && $request->set_end_date == 1) {
                $setEndDate = 1;
            } else {
                $setEndDate = 0;
            }
            if (isset($request->set_end_date_time)) {
                $setEndDateTime = Carbon::parse($request->set_end_date_time)->toDateTimeString();
            } else {
                $setEndDateTime = null;
            }

            $form = new Form();
            $form->title                = $request->title;
            $form->logo                 = $filename;
            $form->description          = $request->form_description;
            $form->email                = $emails;
            $form->bccemail             = $bccemails;
            $form->ccemail              = $bccemails;
            $form->allow_comments       = ($request->allow_comments == 'on') ? '1' : '0';
            $form->allow_share_section  = ($request->allow_share_section == 'on') ? '1' : '0';
            $form->json                 = '';
            $form->success_msg          = $request->success_msg;
            $form->thanks_msg           = $request->thanks_msg;
            $form->set_end_date         = $setEndDate;
            $form->set_end_date_time    = $setEndDateTime;
            $form->created_by           = Auth::guard('api')->user()->id;
            $form->assign_type          = $request->assign_type;
            $form->save();
            if ($request->assign_type == 'role') {
                $form->assignRole($request->roles);
            }
            if ($request->assign_type == 'user') {
                $form->assignUser($request->users);
            }
            $form->assignFormRoles($request->roles);

            $notify = NotificationsSetting::where('title', 'From Create')->first();
            if (isset($notify)) {
                if ($notify->notify == 1) {
                    if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                        if (isset($notify)) {
                            if ($notify &&  $notify->notify == '1') {
                                $userSchema->notify(new CreateForm($form));
                            }
                        }
                    }
                }
            }
            return redirect()->route('forms.index')->with('success', __('Form created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permiso denegado.'));
        }
    }

    public function edit($id)
    {
        $usr                = \Auth::guard('api')->user();
        //$roles = DB::table('tbl_roles')->where('name', '!=', 'Super Admin')
        $userRole          = 1;
        $formallowededit    = UserForm::where('role_id', $userRole)->where('form_id', $id)->count();
        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM") {
            $form           = Form::find($id);
            $next           = Form::where('id', '>', $form->id)->first();
            $previous       = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
            $roles          =  DB::table('tbl_roles')->where('name', '!=', 'Administrador')->pluck('name', 'id');
            $formRole       = DB::table('tbl_roles')->where('name', '!=', 'Administrador')->pluck('id')->toArray();
            $getFormRole      = DB::table('tbl_roles')->pluck('name', 'id');
            $formUser       =  DB::table('tbl_assign_forms_users')->pluck('id')->toArray();
            $GetformUser      = User::where('id', '!=', 1)->pluck('name', 'id');

            return view('form.edit', compact('form', 'roles', 'GetformUser', 'formUser', 'formRole', 'getFormRole', 'next', 'previous'));
        } else {
            if (\Auth::guard('api')->user()->can('edit-form') && $formallowededit > 0) {
                $form       = Form::find($id);
                $next       = Form::where('id', '>', $form->id)->first();
                $previous   = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
                $roles      = Role::pluck('name', 'id');
                $formRole   = $form->assignedroles->pluck('id')->toArray();
                $getFormRole  = Role::pluck('name', 'id');
                $formUser   =  $form->assignedusers->pluck('id')->toArray();
                $GetformUser  = User::where('id', '!=', 1)->pluck('name', 'id');

                return view('form.edit', compact('form', 'getFormRole', 'GetformUser', 'formUser', 'formRole', 'next', 'previous'));
            } else {
                return redirect()->back()->with('failed', __('Permiso denegado.'));
            }
        }
    }

    public function update(Request $request, Form $form)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM") {
            request()->validate([
                'title'       => 'required|max:191',
            ]);

            $ccemails = implode(',', $request->ccemail);
            $bccemails = implode(',', $request->bccemail);
            if ($ccemails) {
                $request->validate([
                    'ccemail' => ['nullable', new CommaSeparatedEmails],
                ]);
            }
            if ($bccemails) {
                $request->validate([
                    'bccemail' => ['nullable', new CommaSeparatedEmails],
                ]);
            }
            request()->validate([
                'email' => ['nullable', new CommaSeparatedEmails],
            ]);

            $filename = $form->logo;
            $emails = $form->logo;
            if (request()->file('form_logo')) {
                $allowedfileExtension   = ['jpeg', 'jpg', 'png'];
                $file                   = $request->file('form_logo');
                $extension              = $file->getClientOriginalExtension();
                $check                  = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->store('form-logo');
                    $form->logo                 = $filename;
                } else {
                    return redirect()->route('forms.index')->with('failed', __('File type not valid.'));
                }
            }
            if (isset($request->email) and !empty($request->email)) {
                $emails = implode(',', $request->email);
            }
            if (isset($request->ccemail) and !empty($request->ccemail)) {
                $ccemails = implode(',', $request->ccemail);
            }
            if (isset($request->bccemail) and !empty($request->bccemail)) {
                $bccemails = implode(',', $request->bccemail);
            }

            if ($request->set_end_date == 'on') {
                $setEndDate = 1;
            } else {
                $setEndDate = 0;
            }
            if (isset($request->set_end_date_time)) {
                $setEndDateTime = Carbon::parse($request->set_end_date_time)->toDateTimeString();;
            } else {
                $setEndDateTime = null;
            }

            $form->title                = $request->title;
            $form->success_msg          = $request->success_msg;
            $form->thanks_msg           = $request->thanks_msg;
            $form->description          = $request->form_description;
            $form->email                = $emails;
            $form->ccemail              = $ccemails;
            $form->bccemail             = $bccemails;
            $form->allow_comments       = ($request->allow_comments == 'on') ? '1' : '0';
            $form->allow_share_section  = ($request->allow_share_section == 'on') ? '1' : '0';
            $form->set_end_date         = $setEndDate;
            $form->set_end_date_time    = $setEndDateTime;
            $form->created_by           = Auth::guard('api')->user()->id;
            $form->assign_type          = $request->assign_type;
            $form->save();



            $log = new HistoricoLog();
            $log->crear(Auth::guard('api')->user()->id, "Actualiza: " . $form->title, join(",", $request->ips()));
            $log->save();

            if ($request->assign_type == 'role') {
                $id = $form->id;
                AssignFormsUsers::where('form_id', $id)->delete();
                $form->assignRole($request->roles);
            }
            if ($request->assign_type == 'user') {
                $id = $form->id;
                AssignFormsRoles::where('form_id', $id)->delete();
                $form->assignUser($request->users);
            }
            if ($request->assign_type == 'public') {
                $id = $form->id;
                AssignFormsRoles::where('form_id', $id)->delete();
                AssignFormsUsers::where('form_id', $id)->delete();
            }
            $form->assignFormRoles($request->roles);
            return redirect()->route('forms.index')->with('success', __('Form updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permiso denegado.'));
        }
    }

    public function destroy(Form $form)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM") {
            $id             = $form->id;
            $comments       = FormComments::where('form_id', $id)->get();
            $commentsReply = FormCommentsReply::where('form_id', $id)->get();
            DashboardWidget::where('form_id', $id)->delete();
            AssignFormsRoles::where('form_id', $id)->delete();
            AssignFormsUsers::where('form_id', $id)->delete();
            foreach ($comments as $allcomments) {
                $commentsids = $allcomments->id;
                $commentsall = FormComments::find($commentsids);
                if ($commentsall) {
                    $commentsall->delete();
                }
            }
            foreach ($commentsReply as $commentsReplyAll) {
                $commentsReplyIds = $commentsReplyAll->id;
                $reply =  FormCommentsReply::find($commentsReplyIds);
                if ($reply) {
                    $reply->delete();
                }
            }
            $form->delete();
            return redirect()->back()->with('success', __('Form deleted successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permiso denegado.'));
        }
    }

    public function gridView($slug = '')
    {
        $usr                  = \Auth::guard('api')->user();
        $usr->forms_grid_view = ($slug) ? 1 : 0;
        $usr->save();
        if ($usr->forms_grid_view == 0) {
            return redirect()->route('forms.index');
        }

        $roleId    = $usr->roles->first()->id;
        $userId    = $usr->id;
        if ($usr->type == 'Admin') {
            $forms = Form::all();
        } else {
            $forms = Form::where(function ($query) use ($roleId, $userId) {
                $query->whereIn('id', function ($query1) use ($roleId) {
                    $query1->select('form_id')->from('assign_forms_roles')->where('role_id', $roleId);
                })->OrWhereIn('id', function ($query1) use ($userId) {
                    $query1->select('form_id')->from('assign_forms_users')->where('userId', $userId);
                });
            })->get();
        }

        return view('form.grid-view', compact('forms'));
    }

    public function design($id)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM"){
            $form = Form::find($id);
            if ($form) {
                return view('form.design', compact('form'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permiso denegado.'));
        }
    }


    public function designUpdate(Request $request, $id)
    {
        if (\Auth::guard('api')->user()->rol == "Administrador" || "Operativo SSM") {
            $form           = Form::find($id);
            if ($form) {
                $form->json = $request->json;
                $fieldName = json_decode($request->json);
                $arr        = [];
                foreach ($fieldName[0] as $k => $fields) {
                    if ($fields->type == "header" || $fields->type == "paragraph") {
                        $arr[$k] = $fields->type;
                    } else {
                        $arr[$k] = $fields->name;
                    }
                }
                $value = DashboardWidget::where('form_id', $form->id)->pluck('field_name', 'id');
                foreach ($value  as $key => $v) {
                    if (!in_array($v, $arr)) {
                        DashboardWidget::find($key)->delete();
                    }
                }
                $form->save();

                $log = new HistoricoLog();
                $log->crear(Auth::guard('api')->user()->id, "Modifica: " . $form->title, join(",", $request->ips()));
                $log->save();
                return redirect()->route('forms.index')->with('success', __('Form updated successfully.'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permiso denegado.'));
        }
    }

    public function fill($id)
    {
            $form       = Form::find($id);
            if ($form) {
                $array = $form->getFormArray();
                return view('form.fill', compact('form', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
    }

    /*** PARA SINCRONIZAR LISTA DE REPRESENTANTES LEGALES ***/
    public function sincronizarlistarepresentantes($id)
    {

        $form = Form::find($id);

        $respuestas = json_decode(FormValue::where("form_id", 31)->get(),true);

        $nombres = array();
        foreach($respuestas as $i => $item) { //foreach element in $arr

            $arr = json_decode($item["json"],true);
            $nombre = array_filter($arr[0], function($campo) {
              if($campo['label'] == "Nombre del Representante Legal"){
                return $campo;
              }
              return null;
            });

            $tempNombre = strtoupper($nombre[0]["value"]);
            if (!in_array($tempNombre, $nombres) && $tempNombre != ""){
                // array_push($nombres, $tempNombre);
                array_push($nombres, ["id" => $item["user_id"], "nombre" => $tempNombre ]);
            }

        }

        // print_r($nombres);
        // return "";


        $arr = json_decode($form->json,true);
        foreach($arr[0] as $i => $item) { //foreach element in $arr

            if($item["label"] == "Representante Legal"){
                $item["values"] = array();

                foreach($nombres as $nom) {
               
                    array_push($item["values"], 
                        [
                        'label' => $nom["nombre"],
                        'value' => $nom["id"],
                        'selected' => false
                        ]);

                 }
                $arr[0][$i]["values"] = $item["values"];

            }

        }

        $form->json = json_encode($arr);
        $form->save();

        return response()->json(['message' => __("Alertas")], 200);

    }

     /*** PARA SINCRONIZAR TITULOS DE PLANES DE MEJORA ***/
     public function sincronizartitulosplanes($id)
     {
 
         $form = Form::find($id);
 
         $respuestas = json_decode(FormValue::where("form_id", 19)->get(),true);
 
         $nombres = array();
         foreach($respuestas as $i => $item) { //foreach element in $arr
 
             $arr = json_decode($item["json"],true);
             $nombre = array_filter($arr[0], function($campo) {
               if($campo['label'] == "T�tulo del plan"){
                 return $campo;
               }
               return null;
             });
 
             $tempNombre = strtoupper($nombre[0]["value"]);
             if (!in_array($tempNombre, $nombres) && $tempNombre != "")
                 array_push($nombres, $tempNombre);
 
         }
 
 
         $arr = json_decode($form->json,true);
         foreach($arr[0] as $i => $item) { //foreach element in $arr
 
             if($item["label"] == "T�tulo del plan de mejora registrado"){
                 $item["values"] = array();
 
                 foreach($nombres as $nom) {
                
                     array_push($item["values"], 
                         [
                         'label' => $nom,
                         'value' => $nom,
                         'selected' => false
                         ]);
 
                  }
                 $arr[0][$i]["values"] = $item["values"];
 
             }
 
         }
 
         $form->json = json_encode($arr);
         $form->save();
 
         return response()->json(['message' => __("Alertas")], 200);
 
     }

    /*** SINCRONIZACIONES DE LISTAS DE DEAS ***/

    /*PARA FORMS 12 Y 33*/
    public function sincronizarlistadeas($id)
    {
        $respuestaFormularioPaciente = FormValue::where("form_id", 12)->get();
        echo $respuestaFormularioPaciente->json;
        return "";
        $form = Form::find($id);
        $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
        $nombres = array();
        foreach($respuestas as $i => $item) { //foreach element in $arr
            $arr = json_decode($item["json"],true);
            $nombre = array_filter($arr[0], function($campo) {
              if($campo['label'] == "Nombre del lugar"){
                return $campo;
              }
              return null;
            });
            $serial = array_filter($arr[1], function($campo) {
              if($campo['label'] == "Número de serie"){
                return $campo;
              }
              return null;
            });
            $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
            array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
        }
        $arr = json_decode($form->json,true);
        foreach($arr[0] as $i => $item) { //foreach element in $arr
            if($item["label"] == "DEA's disponibles en el lugar"){
                $item["values"] = array();
                foreach($nombres as $nom) {
                    array_push($item["values"], 
                        [
                        'label' => $nom["label"],
                        'value' => $nom["value"],
                        'selected' => false
                        ]);
                 }
                $arr[0][$i]["values"] = $item["values"];
            }
        }
        $form->json = json_encode($arr);
        $form->save();
        return response()->json(['message' => __("Alertas")], 200);
    }

    /*PARA FORMS 13 Y 33*/
    public function sincronizarlistadeas2($id)
    {
        $respuestaFormularioPaciente = FormValue::where("form_id", 13)->get();
        echo $respuestaFormularioPaciente->json;
        return "";
        $form = Form::find($id);
        $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
        $nombres = array();
        foreach($respuestas as $i => $item) { //foreach element in $arr
            $arr = json_decode($item["json"],true);
            $nombre = array_filter($arr[0], function($campo) {
              if($campo['label'] == "Nombre del lugar"){
                return $campo;
              }
              return null;
            });
            $serial = array_filter($arr[1], function($campo) {
              if($campo['label'] == "Número de serie"){
                return $campo;
              }
              return null;
            });
            $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
            array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
        }
        $arr = json_decode($form->json,true);
        foreach($arr[0] as $i => $item) { //foreach element in $arr
            if($item["label"] == "DEA's disponibles en el lugar"){
                $item["values"] = array();
                foreach($nombres as $nom) {
                    array_push($item["values"], 
                        [
                        'label' => $nom["label"],
                        'value' => $nom["value"],
                        'selected' => false
                        ]);
                 }
                $arr[0][$i]["values"] = $item["values"];
            }
        }
        $form->json = json_encode($arr);
        $form->save();
        return response()->json(['message' => __("Alertas")], 200);
    }
    /*PARA FORMS 17 Y 33*/
    public function sincronizarlistadeas3($id)
    {
        $respuestaFormularioPaciente = FormValue::where("form_id", 17)->get();
        echo $respuestaFormularioPaciente->json;
        return "";
        $form = Form::find($id);
        $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
        $nombres = array();
        foreach($respuestas as $i => $item) { //foreach element in $arr
            $arr = json_decode($item["json"],true);
            $nombre = array_filter($arr[0], function($campo) {
              if($campo['label'] == "Nombre del lugar"){
                return $campo;
              }
              return null;
            });
            $serial = array_filter($arr[1], function($campo) {
              if($campo['label'] == "Número de serie"){
                return $campo;
              }
              return null;
            });
            $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
            array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
        }
        $arr = json_decode($form->json,true);
        foreach($arr[0] as $i => $item) { //foreach element in $arr
            if($item["label"] == "Lugar"){
                $item["values"] = array();
                foreach($nombres as $nom) {
                    array_push($item["values"], 
                        [
                        'label' => $nom["label"],
                        'value' => $nom["value"],
                        'selected' => false
                        ]);
                 }
                $arr[0][$i]["values"] = $item["values"];
            }
        }
        $form->json = json_encode($arr);
        $form->save();
        return response()->json(['message' => __("Alertas")], 200);
    }

    /*PARA FORMS 18 Y 33*/
    public function sincronizarlistadeas4($id)
    {
        $respuestaFormularioPaciente = FormValue::where("form_id", 18)->get();
        echo $respuestaFormularioPaciente->json;
        return "";
        $form = Form::find($id);
        $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
        $nombres = array();
        foreach($respuestas as $i => $item) { //foreach element in $arr
            $arr = json_decode($item["json"],true);
            $nombre = array_filter($arr[0], function($campo) {
              if($campo['label'] == "Nombre del lugar"){
                return $campo;
              }
              return null;
            });
            $serial = array_filter($arr[1], function($campo) {
              if($campo['label'] == "Número de serie"){
                return $campo;
              }
              return null;
            });
            $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
            array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
        }
        $arr = json_decode($form->json,true);
        foreach($arr[0] as $i => $item) { //foreach element in $arr
            if($item["label"] == "DEA Visitado"){
                $item["values"] = array();
                foreach($nombres as $nom) {
                    array_push($item["values"], 
                        [
                        'label' => $nom["label"],
                        'value' => $nom["value"],
                        'selected' => false
                        ]);
                 }
                $arr[0][$i]["values"] = $item["values"];
            }
        }
        $form->json = json_encode($arr);
        $form->save();
        return response()->json(['message' => __("Alertas")], 200);
    }

        /*PARA FORMS 34 Y 33*/
        public function sincronizarlistadeas5($id)
        {
            $respuestaFormularioPaciente = FormValue::where("form_id", 34)->get();
            echo $respuestaFormularioPaciente->json;
            return "";
            $form = Form::find($id);
            $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
            $nombres = array();
            foreach($respuestas as $i => $item) { //foreach element in $arr
                $arr = json_decode($item["json"],true);
                $nombre = array_filter($arr[0], function($campo) {
                  if($campo['label'] == "Nombre del espacio o lugar"){
                    return $campo;
                  }
                  return null;
                });
                $serial = array_filter($arr[1], function($campo) {
                  if($campo['label'] == "Número de serie"){
                    return $campo;
                  }
                  return null;
                });
                $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
                array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
            }
            $arr = json_decode($form->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr
                if($item["label"] == "Nombre del espacio o lugar"){
                    $item["values"] = array();
                    foreach($nombres as $nom) {
                        array_push($item["values"], 
                            [
                            'label' => $nom["label"],
                            'value' => $nom["value"],
                            'selected' => false
                            ]);
                     }
                    $arr[0][$i]["values"] = $item["values"];
                }
            }
            $form->json = json_encode($arr);
            $form->save();
            return response()->json(['message' => __("Alertas")], 200);
        }


        /*PARA FORMS 19 Y 33*/
        public function sincronizarlistadeas6($id)
        {
            $respuestaFormularioPaciente = FormValue::where("form_id", 19)->get();
            echo $respuestaFormularioPaciente->json;
            return "";
            $form = Form::find($id);
            $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
            $nombres = array();
            foreach($respuestas as $i => $item) { //foreach element in $arr
                $arr = json_decode($item["json"],true);
                $nombre = array_filter($arr[0], function($campo) {
                  if($campo['label'] == "Nombre del espacio o lugar"){
                    return $campo;
                  }
                  return null;
                });
                $serial = array_filter($arr[1], function($campo) {
                  if($campo['label'] == "Número de serie"){
                    return $campo;
                  }
                  return null;
                });
                $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
                array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
            }
            $arr = json_decode($form->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr
                if($item["label"] == "DEA en revisión"){
                    $item["values"] = array();
                    foreach($nombres as $nom) {
                        array_push($item["values"], 
                            [
                            'label' => $nom["label"],
                            'value' => $nom["value"],
                            'selected' => false
                            ]);
                     }
                    $arr[0][$i]["values"] = $item["values"];
                }
            }
            $form->json = json_encode($arr);
            $form->save();
            return response()->json(['message' => __("Alertas")], 200);
        }

        
        /*PARA FORMS 37 Y 33*/
        public function sincronizarlistadeas7($id)
        {
            $respuestaFormularioPaciente = FormValue::where("form_id", 37)->get();
            echo $respuestaFormularioPaciente->json;
            return "";
            $form = Form::find($id);
            $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
            $nombres = array();
            foreach($respuestas as $i => $item) { //foreach element in $arr
                $arr = json_decode($item["json"],true);
                $nombre = array_filter($arr[0], function($campo) {
                  if($campo['label'] == "Nombre del espacio o lugar"){
                    return $campo;
                  }
                  return null;
                });
                $serial = array_filter($arr[1], function($campo) {
                  if($campo['label'] == "Número de serie"){
                    return $campo;
                  }
                  return null;
                });
                $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
                array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
            }
            $arr = json_decode($form->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr
                if($item["label"] == "DEA revisado"){
                    $item["values"] = array();
                    foreach($nombres as $nom) {
                        array_push($item["values"], 
                            [
                            'label' => $nom["label"],
                            'value' => $nom["value"],
                            'selected' => false
                            ]);
                     }
                    $arr[0][$i]["values"] = $item["values"];
                }
            }
            $form->json = json_encode($arr);
            $form->save();
            return response()->json(['message' => __("Alertas")], 200);
        }

        /*PARA FORMS 9 Y 33*/
        public function sincronizarlistadeas8($id)
        {
            $respuestaFormularioPaciente = FormValue::where("form_id", 9)->get();
            echo $respuestaFormularioPaciente->json;
            return "";
            $form = Form::find($id);
            $respuestas = json_decode(FormValue::where("form_id", 33)->get(),true);
            $nombres = array();
            foreach($respuestas as $i => $item) { //foreach element in $arr
                $arr = json_decode($item["json"],true);
                $nombre = array_filter($arr[0], function($campo) {
                  if($campo['label'] == "Nombre del lugar"){
                    return $campo;
                  }
                  return null;
                });
                $serial = array_filter($arr[1], function($campo) {
                  if($campo['label'] == "Número de serie"){
                    return $campo;
                  }
                  return null;
                });
                $tempNombre = strtoupper($nombre[2]["value"]) . " - " . $serial[3]["value"];
                array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
            }
            $arr = json_decode($form->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr
                if($item["label"] == "Nombre del lugar asignado"){
                    $item["values"] = array();
                    foreach($nombres as $nom) {
                        array_push($item["values"], 
                            [
                            'label' => $nom["label"],
                            'value' => $nom["value"],
                            'selected' => false
                            ]);
                     }
                    $arr[0][$i]["values"] = $item["values"];
                }
            }
            $form->json = json_encode($arr);
            $form->save();
            return response()->json(['message' => __("Alertas")], 200);
        }

/*PARA FORMS 9 Y 7*/
public function sincronizarlistadeas9($id)
{
    $respuestaFormularioPaciente = FormValue::where("form_id", 9)->get();
    echo $respuestaFormularioPaciente->json;
    return "";
    $form = Form::find($id);
    $respuestas = json_decode(FormValue::where("form_id", 7)->get(),true);
    $nombres = array();
    foreach($respuestas as $i => $item) { //foreach element in $arr
        $arr = json_decode($item["json"],true);
        $nombre = array_filter($arr[0], function($campo) {
          if($campo['label'] == "Nombre del lugar"){
            return $campo;
          }
          return null;
        });
        $serial = array_filter($arr[1], function($campo) {
          if($campo['label'] == "Número de serie"){
            return $campo;
          }
          return null;
        });
        $tempNombre = strtoupper($nombre[2]["value"]) . "  " . $serial[3]["value"];
        array_push($nombres, ["label" => $tempNombre, "value" => $item["id"]]);
    }
    $arr = json_decode($form->json,true);
    foreach($arr[0] as $i => $item) { //foreach element in $arr
        if($item["label"] == "Nombre del lugar asignado"){
            $item["values"] = array();
            foreach($nombres as $nom) {
                array_push($item["values"], 
                    [
                    'label' => $nom["label"],
                    'value' => $nom["value"],
                    'selected' => false
                    ]);
             }
            $arr[0][$i]["values"] = $item["values"];
        }
    }
    $form->json = json_encode($arr);
    $form->save();
    return response()->json(['message' => __("Alertas")], 200);
}


    /*** DEPARTAMENTOS ***/

    public function llenardepartamentos($id)
    {
        //if (\Auth::guard('api')->user()->rol == "Administrador") {
            $form       = Form::find($id);
            #echo $formValue->json;

            $departamentos = DB::table('tbl_departamentos')->get();
            $ciudades = DB::table('tbl_ciudades')->get();

            //print_r($form->json);

            


            $arr = json_decode($form->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr
                if($item["label"] == "Departamento"){
                    $item["values"] = array();

                    foreach($departamentos as $dep) {
               
                        array_push($item["values"], 
                            [
                            'label' => $dep->nombre,
                            'value' => $dep->nombre,
                            'selected' => false
                            ]);

                         //echo $dep->nombre;
                     }

                    $arr[0][$i]["values"] = $item["values"];
                }



                if($item["label"] == "Ciudad/Municipio"){
                    $item["values"] = array();

                    foreach($ciudades as $dep) {
               
                        array_push($item["values"], 
                            [
                            'label' => $dep->nombre,
                            'value' => $dep->nombre,
                            'selected' => false
                            ]);

                         //echo $dep->nombre;
                     }

                    $arr[0][$i]["values"] = $item["values"];
                }
            }

                    print_r($arr);

                    $form->json = json_encode($arr);
                    $form->save();

        return response()->json(['message' => __("Alertas")], 200);
            
        //} else {
            //return redirect()->back()->with('failed', __('Permiso denegado.'));
        //}
    }

    public function municipios($id)
    {
        $dep = DB::table('tbl_departamentos')->where("nombre", $id)->first();

        $ciudades = DB::table('tbl_ciudades')->where("id_departamento", $dep->id)->get();
        
        $respuesta = array();

        foreach($ciudades as $ciudad) {
            //echo $ciudad->nombre;
            array_push($respuesta, 
                    
                    $ciudad->nombre
                    );

                         //echo $dep->nombre;
        }

        return response()->json($respuesta, 200);
            
    }

    public function publicFill($id)
    {

        $hashids    = new Hashids('', 20);
        $id         = $hashids->decodeHex($id);
        if ($id) {
            $form       = Form::find($id);
            $todayDate = Carbon::now()->toDateTimeString();
            if ($form) {
                if ($form->set_end_date != '0') {
                    if ($form->set_end_date_time && $form->set_end_date_time < $todayDate) {
                        abort('404');
                    }
                }

                if($form->id == 33 && (\Auth::guard('api')->user()->rol == "Usuario consulta E" || \Auth::guard('api')->user()->rol == "Usuario operador 1" || \Auth::guard('api')->user()->rol == "Usuario operador 2")){

                    // return "";
                    
                    $optiones = json_decode($form->json);
                    // print_r($optiones[0][2]->values);

                    $valores = array();
                    foreach ($optiones[0][2]->values as $key => $value) {
                        if((int)$value->value == (int)\Auth::guard('api')->user()->id){
                            $value->value = $value->label;
                            array_push($valores, $value);
                        }
                    }

                    $optiones[0][2]->values = $valores;




                    $valoresdea = array();
                    foreach ($optiones[0][3]->values as $key => $value) {

                        $id_lugar = $this->buscar_lugar_por_formulario_usuario();


                        if((int)$id_lugar == (int)$value->value){
                            array_push($valoresdea, $value);
                        }

                    }

                    $optiones[0][3]->values = $valoresdea;


                    $form->json = json_encode($optiones);

                    // return "";                    
                }


                if($form->id == 13 && (\Auth::guard('api')->user()->rol == "Usuario consulta E" || \Auth::guard('api')->user()->rol == "Usuario operador 1" || \Auth::guard('api')->user()->rol == "Usuario operador 2")){
                    
                    $optiones = json_decode($form->json);
                    // print_r($optiones[0][2]->values);

                    $valores = array();
                    foreach ($optiones[0][4]->values as $key => $value) {

                        if(FormValue::where("id", "=", (int)$value->value)->where("user_id", "=", \Auth::guard('api')->user()->id)->count()){
                            array_push($valores, $value);
                        }

                    }

                    $optiones[0][4]->values = $valores;
                    $form->json = json_encode($optiones);

                }
 

                if($form->id == 12 && (\Auth::guard('api')->user()->rol == "Usuario consulta E" || \Auth::guard('api')->user()->rol == "Usuario operador 1")){
                    
                    $optiones = json_decode($form->json);
                    // print_r($optiones[0][2]->values);

                    $valores = array();
                    foreach ($optiones[0][4]->values as $key => $value) {

                        // if($value->value == \Auth::guard('api')->user()->id){

                        //     array_push($valores, $value);
                        // } 

                        if(FormValue::where("id", "=", (int)$value->value)->where("user_id", "=", \Auth::guard('api')->user()->id)->count()){
                            array_push($valores, $value);
                        }

                    }

                    $optiones[0][4]->values = $valores;
                    $form->json = json_encode($optiones);

                }

                if($form->id == 9)
                {
                     $optiones = json_decode($form->json);
                    // print_r($optiones[0][2]->values);

                    $valores = array();
                    $valoresVerificar = array();
                    foreach ($optiones[0][1]->values as $key => $value) {

                        $texto = trim($value->label);
                        
                        if (in_array($texto, $valoresVerificar)){
                            
                            // $nuevoValor = $this->validarDuplicado($texto, 1, $valoresVerificar);
                            // $value->label = $nuevoValor;
                            
                            // array_push($valoresVerificar, $nuevoValor);
                            // array_push($valores, $value);

                        }else{

                            array_push($valoresVerificar, $texto);
                            array_push($valores, $value);
                        }

                    }
                    

                    $optiones[0][1]->values = $valores;
                    $form->json = json_encode($optiones);
                }


                $array = $form->getFormArray();
                return view('form.public-fill', compact('form', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function validarDuplicado($original, $numeroActual, $lista){

        if (!in_array($original.$numeroActual, $lista)){
            return $original.$numeroActual;
        }

        return $this->validarDuplicado($original, $numeroActual+ 1, $lista);
    }

    public function qrCode($id)
    {
        $hashids  = new Hashids('', 20);
        $id       = $hashids->decodeHex($id);
        $form     = Form::find($id);
        $view     =  view('form.public-fill-qr', compact('form'));
        return ['html' => $view->render()];
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

    public function fillStore(Request $request, $id)
    {


        $form = Form::find($id);

            




        if($id == 9 && !isset($request->form_value_id)){


            try {

            $r = Http::acceptJson()->post('http://3.14.220.114:8001/api/register', [
                'name' => $request->{"namefield"},
                'email' => $request->{"text-1704422367157-0"},
                'password' => $request->{"dea-usuario-contrasena"},
                'telefono' => "",
                'rol' => $request->{"select-1703808435904-0"},
            ]);

            #try {
            $token = $r->json()['token'];


                
            $to = [
                [
                    'email' => $request->{"text-1704422367157-0"}, 
                    'name' => $request->{"namefield"},
                ]
            ];

            $detallesEmail = array();
            $detallesEmail["name"] = $request->{"namefield"};
            $detallesEmail["password"] = $request->{"dea-usuario-contrasena"};

            //\Mail::mailer('smtp')->to($to)
                //->send(new BienvenidaSistema($detallesEmail));
            

            } catch (\Exception $e) {
                    //return back()->with('failed', __($r->json()['message']));
                    return response()->json(['is_success' => false, 'message' => __($r->json()['message'])]);
            }
        }


        if($id == 39 && !isset($request->form_value_id)){



            try {

            $r = Http::acceptJson()->post('http://3.14.220.114:8001/api/register', [
                'name' => $request->{"namefield"},
                'email' => $request->{"text-1704422367157-0"},
                'password' => $request->{"dea-usuario-contrasena"},
                'telefono' => "",
                'rol' => $request->{"select-1703808435904-0"},
            ]);


            $token = $r->json()['token'];


                
            $to = [
                [
                    'email' => $request->{"text-1704422367157-0"}, 
                    'name' => $request->{"namefield"},
                ]
            ];

            

            try {
                $detallesEmail = array();
                $detallesEmail["name"] = $request->{"namefield"};
                $detallesEmail["password"] = $request->{"dea-usuario-contrasena"};

                // \Mail::mailer('smtp')->to($to)
                // ->send(new BienvenidaSistema($detallesEmail));

            } catch (Exception $e) {
                
            }

            
            

            } catch (\Exception $e) {
                    //return back()->with('failed', __($r->json()['message']));
                    return response()->json(['is_success' => false, 'message' => __($r->json()['message'])]);
            }
        }



        if($id == 31 && !isset($request->form_value_id)){
            $tempForm = Form::find(33);
            $arr = json_decode($tempForm->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr

                if($item["label"] == "Representante Legal"){
                   
                    array_push($item["values"], 
                        [
                        'label' => strtoupper($request->{"namefield"}),
                        'value' => \Auth::guard('api')->user()->id,
                        'selected' => false
                        ]);

                    $arr[0][$i]["values"] = $item["values"];

                }

            }
            $tempForm->json = json_encode($arr);
            $tempForm->save();
        }

        if($id == 19 && !isset($request->form_value_id)){
            $tempForm = Form::find(37);
            $arr = json_decode($tempForm->json,true);
            foreach($arr[0] as $i => $item) { //foreach element in $arr

                if($item["label"] == "Título del plan de mejora"){
                   
                    array_push($item["values"], 
                        [
                        'label' => strtoupper($request->{"namefield"}),
                        'selected' => false
                        ]);

                    $arr[0][$i]["values"] = $item["values"];

                }

            }

            $tempForm->json = json_encode($arr);
            $tempForm->save();
        }

    




        if($id == 33 && !isset($request->form_value_id)){


            $formValue = FormValue::where("form_id", 33)
                                                ->where("json", 'LIKE', '%'.'"value":"'.$request->{"dea-marca"}.'"}'.'%', )
                                                ->where("json", 'LIKE', '%'.'"value":"'.$request->{"serial-number"}.'"}'.'%', )
                                                ->first();
           

            if($formValue != null){
                return response()->json(['is_success' => false, 'message' => __('La marca '.$request->{"dea-marca"}.' y el serial '. $request->{"serial-number"} .' ya han sido registrados.')]);
                
            }

        }

       
        if (UtilityFacades::getsettings('captcha_enable') == 'on') {
            if (UtilityFacades::getsettings('captcha') == 'hcaptcha') {
                if (empty($_POST['h-captcha-response'])) {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Please check hcaptcha.')]);
                    } else {
                        return back()->with('failed', __('Please check hcaptcha.'));
                    }
                }
            }
            if (UtilityFacades::getsettings('captcha') == 'recaptcha') {
                if (empty($_POST['g-recaptcha-response'])) {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Please check recaptcha.')]);
                    } else {
                        return back()->with('failed', __('Please check recaptcha.'));
                    }
                }
            }
        }
        if ($form) {
            $clientEmails = [];
            if ($request->form_value_id) {
                $formValue = FormValue::find($request->form_value_id);
                $array = json_decode($formValue->json);
            } else {
                $array = $form->getFormArray();
            }
            foreach ($array as  &$rows) {
                foreach ($rows as &$row) {
                    if ($row->type == 'checkbox-group') {
                        foreach ($row->values as &$checkboxvalue) {
                            if (is_array($request->{$row->name}) && in_array($checkboxvalue->value, $request->{$row->name})) {
                                $checkboxvalue->selected = 1;
                            } else {
                                if (isset($checkboxvalue->selected)) {
                                    unset($checkboxvalue->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'file') {
                        if ($row->subtype == "fineuploader") {
                            $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                            $fileLimit = $row->max_file_size_mb / 1024;
                            if ($fileSize < $fileLimit) {
                                $values = [];
                                $value = explode(',', $request->input($row->name));
                                foreach ($value as $file) {
                                    $values[] = $file;
                                }
                                $row->value = $values;
                            } else {
                                return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                            }
                        } else {
                            if ($row->file_extention == 'pdf') {
                                $allowedFileExtension = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox'];
                            } else if ($row->file_extention == 'image') {
                                $allowedFileExtension = ['jpeg', 'jpg', 'png'];
                            } else if ($row->file_extention == 'excel') {
                                $allowedFileExtension = ['xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                            }
                            $requiredextention = implode(',', $allowedFileExtension);
                            $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                            $fileLimit = $row->max_file_size_mb / 1024;
                            if ($fileSize < $fileLimit) {
                                if ($row->multiple) {
                                    if ($request->hasFile($row->name)) {
                                        $values = [];
                                        $files = $request->file($row->name);
                                        foreach ($files as $file) {
                                            $extension = $file->getClientOriginalExtension();
                                            $check = in_array($extension, $allowedFileExtension);
                                            if ($check) {
                                                if ($extension == 'csv') {
                                                    $name = \Str::random(40) . '.' . $extension;
                                                    $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                    $values[] = 'form-values/' . $form->id . '/' . $name;
                                                } else {
                                                    $path = Storage::path("form-values/$form->id");
                                                    $fileName = $file->store('form-values/' . $form->id);
                                                    if (!file_exists($path)) {
                                                        mkdir($path, 0777, true);
                                                        chmod($path, 0777);
                                                    }
                                                    if (!file_exists(Storage::path($fileName))) {
                                                        mkdir(Storage::path($fileName), 0777, true);
                                                        chmod(Storage::path($fileName), 0777);
                                                    }
                                                    $values[] = $fileName;
                                                }
                                            } else {
                                                if (isset($request->ajax)) {
                                                    return response()->json(['is_success' => false, 'message' => __("Tipo de archivo no v�lido. Cargue �nicamente archivos con extensiones $requiredextention")], 200);
                                                } else {
                                                    return redirect()->back()->with('failed', __("Tipo de archivo no v�lido. Cargue �nicamente archivos con extensiones $requiredextention"));
                                                }
                                            }
                                        }
                                        $row->value = $values;
                                    }
                                } else {
                                    if ($request->hasFile($row->name)) {
                                        $values = '';
                                        $file = $request->file($row->name);
                                        $extension = $file->getClientOriginalExtension();
                                        $check = in_array($extension, $allowedFileExtension);
                                        if ($check) {
                                            if ($extension == 'csv') {
                                                $name = \Str::random(40) . '.' . $extension;
                                                $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                $values = 'form-values/' . $form->id . '/' . $name;
                                                chmod("$values", 0777);
                                            } else {
                                                $path = Storage::path("form-values/$form->id");
                                                $fileName = $file->store('form-values/' . $form->id);
                                                if (!file_exists($path)) {
                                                    mkdir($path, 0777, true);
                                                    chmod($path, 0777);
                                                }
                                                if (!file_exists(Storage::path($fileName))) {
                                                    mkdir(Storage::path($fileName), 0777, true);
                                                    chmod(Storage::path($fileName), 0777);
                                                }
                                                $values = $fileName;
                                            }
                                        } else {
                                            if (isset($request->ajax)) {
                                                return response()->json(['is_success' => false, 'message' => __("Tipo de archivo no v�lido. Cargue �nicamente archivos con extensiones $requiredextention")], 200);
                                            } else {
                                                return redirect()->back()->with('failed', __("Tipo de archivo no v�lido. Cargue �nicamente archivos con extensiones $requiredextention "));
                                            }
                                        }
                                        $row->value = $values;
                                    }
                                }
                            } else {
                                return response()->json(['is_success' => false, 'message' => __("Por favor cargue archivos con m�ximo $row->max_file_size_mb MB.")], 200);
                            }
                        }
                    } elseif ($row->type == 'radio-group') {
                        foreach ($row->values as &$radiovalue) {
                            if ($radiovalue->value == $request->{$row->name}) {
                                $radiovalue->selected = 1;
                            } else {
                                if (isset($radiovalue->selected)) {
                                    unset($radiovalue->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'autocomplete') {
                        if (isset($row->multiple)) {
                            foreach ($row->values as &$autocompletevalue) {
                                if (is_array($request->{$row->name}) && in_array($autocompletevalue->value, $request->{$row->name})) {
                                    $autocompletevalue->selected = 1;
                                } else {
                                    if (isset($autocompletevalue->selected)) {
                                        unset($autocompletevalue->selected);
                                    }
                                }
                            }
                        } else {
                            foreach ($row->values as &$autocompletevalue) {
                                if ($autocompletevalue->value == $request->autocomplete) {
                                    $autocompletevalue->selected = 1;
                                } else {
                                    if (isset($autocompletevalue->selected)) {
                                        unset($autocompletevalue->selected);
                                    }
                                    $row->value = $request->autocomplete;
                                }
                            }
                        }
                    } elseif ($row->type == 'select') {
                        if ($row->multiple) {
                            foreach ($row->values as &$selectvalue) {
                                if (is_array($request->{$row->name}) && in_array($selectvalue->value, $request->{$row->name})) {
                                    $selectvalue->selected = 1;
                                } else {
                                    if (isset($selectvalue->selected)) {
                                        unset($selectvalue->selected);
                                    }
                                }
                            }
                        } else {

        
/*
                            echo $row->label;
                            echo $row->label;
                            if ($row->label == "Ciudad/Municipio"){
                            print_r($row->values);
                                $row->values = [];
                                array_push($row->values, 
                                [
                                'label' => $request->{$row->name},
                                'value' => $request->{$row->name},
                                'selected' => true
                                ]);
                            print_r($row->values);
                            }

*/

                            foreach ($row->values as &$selectvalue) {
                                if ($selectvalue->value == $request->{$row->name}) {
                                    $selectvalue->selected = 1;
                                } else {
                                    if (isset($selectvalue->selected)) {
                                        unset($selectvalue->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'date') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'number') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'textarea') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'text') {
                        $clientEmail = '';
                        if ($row->subtype == 'email') {
                            if (isset($row->is_client_email) && $row->is_client_email) {

                                $clientEmails[] = $request->{$row->name};
                            }
                        }
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'starRating') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'SignaturePad') {
                        if (property_exists($row, 'value')) {
                            $filepath = $row->value;
                            if ($request->{$row->name} == null) {
                                $url = $row->value;
                            } else {
                                if (file_exists(Storage::path($request->{$row->name}))) {
                                    $url = $request->{$row->name};
                                    $path = $url;
                                    $imgUrl = Storage::path($url);
                                    $filePath = $imgUrl;
                                } else {
                                    $imgUrl = $request->{$row->name};
                                    $path = "form-values/$form->id/" . rand(1, 1000) . '.png';
                                    $filePath = Storage::path($path);
                                }
                                $imageContent = file_get_contents($imgUrl);
                                $file = file_put_contents($filePath, $imageContent);
                            }
                            $row->value = $path;
                        } else {
                            if ($request->{$row->name} != null) {
                                if (!file_exists(Storage::path("form-values/$form->id"))) {
                                    mkdir(Storage::path("form-values/$form->id"), 0777, true);
                                    chmod(Storage::path("form-values/$form->id"), 0777);
                                }
                                $filepath     = "form-values/$form->id/" . rand(1, 1000) . '.png';
                                $url          = $request->{$row->name};
                                $imageContent = file_get_contents($url);
                                $filePath     = Storage::path($filepath);
                                $file         = file_put_contents($filePath, $imageContent);
                                $row->value   = $filepath;
                            }
                        }
                    } elseif ($row->type == 'location') {
                        $row->value = $request->location;
                    } elseif ($row->type == 'video') {
                        $validator = \Validator::make($request->all(),  [
                            'media' => 'required',
                        ]);
                        if ($validator->fails()) {
                            $messages = $validator->errors();
                        }

                        $row->value = $request->media;
                    } elseif ($row->type == 'selfie') {
                        $file = '';
                        $img = $request->image;
                        $folderPath = "form_selfie/";

                        $imageParts = explode(";base64,", $img);

                        if ($imageParts[0]) {

                            $imageBase64 = base64_decode($imageParts[1]);
                            $fileName = uniqid() . '.png';

                            $file = $folderPath . $fileName;
                            Storage::put($file, $imageBase64);
                        }
                        $row->value  = $file;
                    }

                }
            }

            if ($request->form_value_id) {
                $formValue->json = json_encode($array);
                $formValue->save();
                $userId = \Auth::guard('api')->user()->id;
                
            } else {
                if (\Auth::guard('api')->user()) {
                    $userId = \Auth::guard('api')->user()->id;
                } else {
                    $userId = NULL;
                }
                $data = [];
                if ($form->payment_status == 1) {
                    if ($form->payment_type == 'stripe') {
                        StripeStripe::setApiKey(UtilityFacades::getsettings('STRIPE_SECRET', $form->created_by));
                        try {
                            $charge = Charge::create([
                                "amount"      => $form->amount * 100,
                                "currency"    => $form->currency_name,
                                "description" => "Payment from " . config('app.name'),
                                "source"      => $request->input('stripeToken')
                            ]);
                        } catch (Exception $e) {
                            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
                        }
                        if ($charge) {
                            $data['transaction_id']  = $charge->id;
                            $data['currency_symbol'] = $form->currency_symbol;
                            $data['currency_name']   = $form->currency_name;
                            $data['amount']          = $form->amount;
                            $data['status']          = 'successfull';
                            $data['payment_type']    = 'Stripe';
                        }
                    } else if ($form->payment_type == 'razorpay') {
                        $data['transaction_id']  = $request->payment_id;
                        $data['currency_symbol'] = $form->currency_symbol;
                        $data['currency_name']   = $form->currency_name;
                        $data['amount']          = $form->amount;
                        $data['status']          = 'successfull';
                        $data['payment_type']    = 'Razorpay';
                    } else if ($form->payment_type == 'paypal') {
                        $data['transaction_id']  = $request->payment_id;
                        $data['currency_symbol'] = $form->currency_symbol;
                        $data['currency_name']   = $form->currency_name;
                        $data['amount']          = $form->amount;
                        $data['status']          = 'successfull';
                        $data['payment_type']    = 'Paypal';
                    } else if ($form->payment_type == 'flutterwave') {
                        $data['transaction_id']  = $request->payment_id;
                        $data['currency_symbol'] = $form->currency_symbol;
                        $data['currency_name']   = $form->currency_name;
                        $data['amount']          = $form->amount;
                        $data['status']          = 'successfull';
                        $data['payment_type'] = 'Flutterwave';
                    } else if ($form->payment_type == 'paytm') {
                        $data['transaction_id']  = $request->payment_id;
                        $data['currency_symbol'] = $form->currency_symbol;
                        $data['currency_name']   = $form->currency_name;
                        $data['amount']          = $form->amount;
                        $data['status']          = 'pending';
                        $data['payment_type']    = 'Paytm';
                    } else if ($form->payment_type == 'paystack') {
                        $data['transaction_id']   = $request->payment_id;
                        $data['currency_symbol']  = $form->currency_symbol;
                        $data['currency_name']    = $form->currency_name;
                        $data['amount']           = $form->amount;
                        $data['status']           = 'successfull';
                        $data['payment_type'] = 'Paystack';
                    } else if ($form->payment_type == 'payumoney') {
                        $data['transaction_id']   = $request->payment_id;
                        $data['currency_symbol']  = $form->currency_symbol;
                        $data['currency_name']    = $form->currency_name;
                        $data['amount']           = $form->amount;
                        $data['status']           = 'successfull';
                        $data['payment_type'] = 'PayuMoney';
                    } else if ($form->payment_type == 'mollie') {
                        $data['transaction_id']   = $request->payment_id;
                        $data['currency_symbol']  = $form->currency_symbol;
                        $data['currency_name']    = $form->currency_name;
                        $data['amount']           = $form->amount;
                        $data['status']           = 'successfull';
                        $data['payment_type'] = 'Mollie';
                    } else if ($form->payment_type == 'coingate') {
                        $data['status'] = 'pending';
                    } else if ($form->payment_type == 'mercado') {
                        $data['status'] = 'pending';
                    }
                } else {
                    $data['status'] = 'free';
                }

                $data['form_id'] = $form->id;
                $data['user_id'] = $userId;
                $data['json']    = json_encode($array);
                $formValue      = FormValue::create($data);
            }
            $formValueArray = json_decode($formValue->json);
            $emails = explode(',', $form->email);
            $ccemails = explode(',', $form->ccemail);
            $bccemails = explode(',', $form->bccemail);
            if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                if ($form->ccemail && $form->bccemail) {
                    try {
                        Mail::to($form->email)
                            ->cc($form->ccemail)
                            ->bcc($form->bccemail)
                            ->send(new FormSubmitEmail($formValue, $formValueArray));
                    } catch (\Exception $e) {
                    }
                } else if ($form->ccemail) {
                    try {
                        Mail::to($emails)
                            ->cc($ccemails)
                            ->send(new FormSubmitEmail($formValue, $formValueArray));
                    } catch (\Exception $e) {
                    }
                } else if ($form->bccemail) {
                    try {
                        Mail::to($emails)
                            ->bcc($bccemails)
                            ->send(new FormSubmitEmail($formValue, $formValueArray));
                    } catch (\Exception $e) {
                    }
                } else {
                    try {
                        Mail::to($emails)->send(new FormSubmitEmail($formValue, $formValueArray));
                    } catch (\Exception $e) {
                    }
                }
                foreach ($clientEmails as $clientEmail) {
                    try {
                        Mail::to($clientEmail)->send(new Thanksmail($formValue));
                    } catch (\Exception $e) {
                    }
                }
            }

            $user = User::where('rol', 'Administrador')->first();
            $notificationsSetting = NotificationsSetting::where('title', 'new survey details')->first();
            if (isset($notificationsSetting)) {
                if ($notificationsSetting->notify == '1') {
                    $user->notify(new NewSurveyDetails($form));
                } elseif ($notificationsSetting->email_notification == '1') {
                    if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                        if (MailTemplate::where('mailable', FormSubmitEmail::class)->first()) {
                            try {
                                Mail::to($formValue->email)->send(new FormSubmitEmail($formValue, $formValueArray));
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
            }
            /*if ($form->payment_type != 'coingate' && $form->payment_type != 'mercado') {
                $successMsg = strip_tags($form->success_msg);
            }*/
            if ($request->form_value_id) {
                $successMsg = strip_tags($form->success_msg);
            }
                $successMsg = strip_tags($form->success_msg);

            Form::integrationFormData($form, $formValue);

            /** PARA INTEGRACIONES DE LISTADO DE DEAS **/
            if (isset($request->ajax)) {


                if($id == 7 && !isset($request->form_value_id)){
                    $tempForm = Form::find(9);
                    $arr = json_decode($tempForm->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                        if($item["label"] == "Nombre del lugar asignado"){
                           
                            array_push($item["values"], 
                                [
                                'label' => strtoupper($request->{"nombredelugar"}),
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
                                'label' => strtoupper($request->{"nombredelugar"}),
                                'value' => $formValue->id,
                                'selected' => false
                                ]);

                            $arr[0][$i]["values"] = $item["values"];

                        }

                    }

                    $tempForm->json = json_encode($arr);
                    $tempForm->save();
                }



                
                /**CASO 12 Y 33**/
                if($id == 33 && !isset($request->form_value_id)){

                    $arregloActual = json_decode($form->json,true);

                    $optionesLugar = $arregloActual[0][3]["values"];

                    $nombreDeaSeleccionado = "";
                    foreach ($optionesLugar as $key => $value) {
                        if($value["value"] == $request->{"nombredelugar"}){
                        // print_r($value["label"]);
                            $nombreDeaSeleccionado = $value["label"];
                        }
                    }


                    $tempForm1 = Form::find(12);
                    $arr = json_decode($tempForm1->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                        if(isset($item["label"]) && $item["label"] == "DEA's disponibles en el lugar"){

                            array_push($item["values"], 
                                [
                                'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                                'value' => $formValue->id,
                                'selected' => false
                                ]);

                            $arr[0][$i]["values"] = $item["values"];

                        }

                    }

                    $tempForm1->json = json_encode($arr);
                    $tempForm1->save();
                
                    /**CASO 13 Y 33**/
                    $tempForm = Form::find(13);
                    $arr = json_decode($tempForm->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                        if($item["label"] == "DEA's disponibles en el lugar"){

                            array_push($item["values"], 
                                [
                                'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                                'value' => $formValue->id,
                                'selected' => false
                                ]);

                            $arr[0][$i]["values"] = $item["values"];

                        }

                    }

                    $tempForm->json = json_encode($arr);
                    $tempForm->save();

                    /**CASO 17 Y 33**/
                    $tempForm = Form::find(17);
                    $arr = json_decode($tempForm->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                        if($item["label"] == "Lugar"){

                            array_push($item["values"], 
                                [
                                'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                                'value' => $formValue->id,
                                'selected' => false
                                ]);

                            $arr[0][$i]["values"] = $item["values"];

                        }

                    }

                    $tempForm->json = json_encode($arr);
                    $tempForm->save();

                    /**CASO 18 Y 33**/
                    $tempForm = Form::find(18);
                    $arr = json_decode($tempForm->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                        if($item["label"] == "DEA Visitado"){

                            array_push($item["values"], 
                                [
                                'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                                'value' => $formValue->id,
                                'selected' => false
                                ]);

                            $arr[0][$i]["values"] = $item["values"];

                        }

                    }

                    $tempForm->json = json_encode($arr);
                    $tempForm->save();
                    
                
                    /**CASO 34 Y 33**/
                    $tempForm = Form::find(34);
                    $arr = json_decode($tempForm->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                        if($item["label"] == "Nombre del espacio o lugar"){

                            array_push($item["values"], 
                                [
                                'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                                'value' => $formValue->id,
                                'selected' => false
                                ]);

                            $arr[0][$i]["values"] = $item["values"];

                        }

                    }
                    $tempForm->json = json_encode($arr);
                    $tempForm->save();

                    /**CASO 19 Y 33**/
                    $tempForm = Form::find(19);
                    $arr = json_decode($tempForm->json,true);
                    foreach($arr[0] as $i => $item) { //foreach element in $arr

                      if($item["label"] == "DEA en revisión"){

                          array_push($item["values"], 
                              [
                              'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                              'value' => $formValue->id,
                              'selected' => false
                              ]);

                          $arr[0][$i]["values"] = $item["values"];

                      }

                    }
                    $tempForm->json = json_encode($arr);
                    $tempForm->save();

                   /**CASO 37 Y 33**/
                   $tempForm = Form::find(37);
                   $arr = json_decode($tempForm->json,true);
                   foreach($arr[0] as $i => $item) { //foreach element in $arr

                       if($item["label"] == "DEA revisado"){

                           array_push($item["values"], 
                               [
                               'label' => strtoupper($nombreDeaSeleccionado) . " - " . $request->{"serial-number"},
                               'value' => $formValue->id,
                               'selected' => false
                               ]);

                           $arr[0][$i]["values"] = $item["values"];

                       }

                   }
                   $tempForm->json = json_encode($arr);
                   $tempForm->save();

                   /**CASO 9 Y 7**/
                   $tempForm = Form::find(9);
                   $arr = json_decode($tempForm->json,true);
                   foreach($arr[0] as $i => $item) { //foreach element in $arr

                       if($item["label"] == "Nombre del lugar asignado"){

                           array_push($item["values"], 
                               [
                               'label' => strtoupper($nombreDeaSeleccionado),
                               'value' => $formValue->id,
                               'selected' => false
                               ]);

                           $arr[0][$i]["values"] = $item["values"];

                       }

                   }
                   $tempForm->json = json_encode($arr);
                   $tempForm->save();

                }




                if($id == 12 && !isset($request->form_value_id)){
                    $resultado = $this->enviarInformacionApis($request->{"deas-disponibles-lugar"}, $request);
                    if($resultado == -1){
                        return response()->json(['is_success' => false, 'message' => $resultado], 200);
                    }

                    $arr = json_decode($formValue->json,true);
                    $arr[0][16]["value"] = $resultado;
                    $formValue->json = json_encode($arr);
                    $formValue->save();

                }



                $log = new HistoricoLog();
                $log->crear($userId, "Diligencia: " . $form->title, join(",", $request->ips()));
                $log->save();


                $this->enviarCorreoConfirmacion($id);

                return response()->json(['is_success' => true, 'message' => $successMsg, 'redirect' => route('edit.form.values', $formValue->id)], 200);
            } else {
                return redirect()->back()->with('success', $successMsg);
            }
        } else {
            if (isset($request->ajax)) {
                return response()->json(['is_success' => false, 'message' => __('Formulario no encontrado')], 200);
            } else {
                return redirect()->back()->with('failed', __('Formulario no encontrado.'));
            }
        }
    }

    public function enviarCorreoConfirmacion($formId)
    {

        $usuarios = User::where("rol", "Administrador")->get();


        $destinatarios = array();

        foreach ($usuarios as $key => $value) {

            array_push($destinatarios, [
                    'email' => $value->email, 
                    'name' => $value->email,
                ]);

        }

        if($formId == 7){

            $detallesEmail = array();
            $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new RegistroLugarInstalacion($detallesEmail));
        }


        if($formId == 33){

            $detallesEmail = array();
            $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new RegistroDea($detallesEmail));
        }

        if($formId == 17){

            $detallesEmail = array();
            $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new ProgramacionVisita($detallesEmail));
        }

        if($formId == 18){

            $detallesEmail = array();
            $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new CreacionActaVisita($detallesEmail));
        }

        if($formId == 10){

            $detallesEmail = array();
            $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new RegistroPersonaCertificada($detallesEmail));
        }

        if($formId == 12){

            $detallesEmail = array();
            $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new RegistroECVCurso($detallesEmail));



            // $detallesEmail = array();
            // $detallesEmail["name"] = "";

            // \Mail::mailer('smtp')->to($destinatarios)
            //     ->send(new RegistroECVCurso($detallesEmail));
        }

        

    }

    public function buscarInformacionEvento($formValueId)
    {
        $respuestaFormularioPaciente = FormValue::where("form_id", 13)->get();

        $nombres = array();
        foreach($respuestaFormularioPaciente as $i => $item) { //foreach element in $arr

            $arr = json_decode($item["json"],true);
            $nombre = array_filter($arr[0], function($campo) {
              if($campo['label'] == "DEA's disponibles en el lugar"){
                return $campo;
              }
              return null;
            });


            foreach($nombre as $j => $item2) {

                foreach($item2["values"] as $k => $item3) {

                    if(isset($item3["selected"])){
                        // print_r($item3);
                        // echo "</br>";
                        if($item3["value"] == $formValueId){
                            return $item["id"];
                        }
                    }
                }

            }


        }

        return null;
    }

    public function buscarUsoDesfibrilador($documentoIdentidadPaciente)
    {
        $respuestaFormularioPaciente = FormValue::where("form_id", 14)->get();

        // echo $documentoIdentidadPaciente;

        $nombres = array();
        foreach($respuestaFormularioPaciente as $i => $item) { //foreach element in $arr

            $arr = json_decode($item["json"],true);
            $documento = array_filter($arr[0], function($campo) {
              if($campo['label'] == "Número de documento de identidad"){
                return $campo;
              }
              return null;
            });

            if ($documento[5]["value"] == $documentoIdentidadPaciente){

                return $item["id"];
            }


            // echo "<br />";

            // foreach($nombre as $j => $item2) {

            //     foreach($item2["values"] as $k => $item3) {

            //         if(isset($item3["selected"])){
            //             if($item3["value"] == $formValueId){
            //                 return $item["id"];
            //             }
            //         }
            //     }

            // }


        }

        return null;
    }


    public function enviarInformacionNetux($datosEnvio)
    {

        $request = new HTTP_Request2();
        $request->setUrl('http://api.semdev.netuxcloud.com/api/client/events');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ZXZlbnRzQ2xpZW50MkAyMzpFdmVudHNDbGllbnQyQDIz'
        ));
        $request->setBody('{ "healthArrivalDate": '. $datosEnvio["healthArrivalDate"] .',    "lat": "'. $datosEnvio["lat"] .'",    "lng": "'. $datosEnvio["lng"] .'",    "address": "'. $datosEnvio["address"] .'",    "callerPhone": "'. $datosEnvio["callerPhone"] .'",    "callerName": "'. $datosEnvio["callerName"] .'",    "observations": "'. $datosEnvio["observations"] .'",    "arrivedBy": "AMB_MED",    "createdBy": "CIGA"}');

        try 
        {
            $response = $request->send();
            // echo  $response->getBody();

            if ($response->getStatus() == 200) {
                return $response->getBody();
            }
            else {
                $response->getReasonPhrase();
                return -1;
            }
        }
        catch(HTTP_Request2_Exception $e) {
            // echo 'Error: ' . $e->getMessage();
            return -1;
        }

    }



    public function enviarInformacionApis($formValueId, $request)
    {
        $datosEnvio = $this->obtenerInformacionInformacionApis($formValueId, $request);

        $resultado = $this->enviarInformacionNetux($datosEnvio);

        return $resultado;
    }


    public function buscarInformacionInstalacion($deaSeleccionado)
    {
        $arr2 = explode(" - ", $deaSeleccionado);
        //print_r($arr2);

        // echo $arr2[1];

        print_r($arr2);


        $formInstalcionDea = FormValue::where("form_id", 33)
                                                ->where("json", 'LIKE', '%'.'value":"'.strtolower($arr2[0]).'"}'.'%', )
                                               // ->where("json", 'LIKE', '%'.'"value":"'.$arr2[1].'"}'.'%', )
                                                ->first();

        print_r($formInstalcionDea);


        $respuestasUinstalacion = json_decode($formInstalcionDea->json,true);
        

        $fechaInstalacionObjeto = array_filter($respuestasUinstalacion[1], function($campo) {
          if((str_contains(strtoupper($campo['label']), strtoupper("Fecha de registro del DEA")))){

            return $campo;
          }
          return null;
        });
        $fechaInstalacion = $fechaInstalacionObjeto[1]["value"];



        $latitud = array_filter($respuestasUinstalacion[0], function($campo) {
          if((str_contains(strtoupper($campo['label']), strtoupper("Coordenada: Latitud")))){

            return $campo;
          }
          return null;
        });
        $latitud = $latitud[6]["value"];



        $longitud = array_filter($respuestasUinstalacion[0], function($campo) {
          if((str_contains(strtoupper($campo['label']), strtoupper("Coordenada: Longitud")))){

            return $campo;
          }
          return null;
        });
        $longitud = $longitud[5]["value"];



        $direccion = array_filter($respuestasUinstalacion[0], function($campo) {
          if((str_contains(strtoupper($campo['label']), strtoupper("Dirección del lugar")))){

            return $campo;
          }
          return null;
        });
        $direccion = $direccion[3]["value"];

        // print_r($direccion);

        $resultado = [
            "fechaInstalacion" => $fechaInstalacion,
            "latitud" => $latitud,
            "longitud" => $longitud,
            "direccion" => $direccion,
        ];

        return $resultado;

        
    }


    public function concatenarDireccionEvento($formValue)
    {

        $arr = json_decode($formValue->json,true);

        $via = $arr[0][7];
        $viaString = "";
        foreach($via["values"] as $k => $item3) {

            if(isset($item3["selected"])){
                $viaString = $item3["value"];
            }
        }


        $numero1String = $arr[0][8]["value"];
        $numero2String = $arr[0][9]["value"];
        

        $letra = $arr[0][10];
        $letraString = "";
        foreach($letra["values"] as $k => $item3) {

            if(isset($item3["selected"])){
                $letraString = $item3["value"];
            }
        }


        $bis = $arr[0][11];
        $bisString = "";
        foreach($bis["values"] as $k => $item3) {

            if(isset($item3["selected"])){
                $bisString = $item3["value"];
            }
        }


        $letra2 = $arr[0][12];
        $letra2String = "";
        foreach($letra2["values"] as $k => $item3) {

            if(isset($item3["selected"])){
                $letra2String = $item3["value"];
            }
        }

        $puntoCardinal = $arr[0][13];
        $puntoCardinalString = "";
        foreach($puntoCardinal["values"] as $k => $item3) {

            if(isset($item3["selected"])){
                $puntoCardinalString = $item3["value"];
            }

        }

        $letraNumero = $arr[0][14]["value"];


        $puntoCardinal2 = $arr[0][15];
        $puntoCardinal2String = "";
        foreach($puntoCardinal2["values"] as $k => $item3) {

            if(isset($item3["selected"])){
                $puntoCardinal2String = $item3["value"];
            }
        }


        $adicional = $arr[0][16]["value"];

        $direccion = "". $viaString . " # " . $numero1String . "-". $numero2String. " " . $letraString . "  "  . $bisString . "  "  . $letra2String  . "  " . $puntoCardinalString . "  "  . $letraNumero . "  "  . $puntoCardinal2String  . "  " . $adicional ."";

        return $direccion;
    }

    public function obtenerInformacionInformacionApis($formValueId, $request)
    {
        $respuestasEvento = FormValue::where("id", $formValueId)->first();
        $direccion = $this->concatenarDireccionEvento($respuestasEvento);

        

        $respuestaOperardor = FormValue::where("form_id", 39)
                                        ->where("json", 'LIKE', '%'.'"value":"'. \Auth::guard('api')->user()->email .'"}'.'%', )
                                        ->first();

        if(!$respuestaOperardor){
            $respuestaOperardor = FormValue::where("form_id", 9)
                                        ->where("json", 'LIKE', '%'.'"value":"'. \Auth::guard('api')->user()->email .'"}'.'%', )
                                        ->first();
        }


        // print_r($direccion);
        $latitud = $request->{"coord-lat"};
        $longitud = $request->{"coord-long"};
        $observaciones = $request->{"observations"};
        $healtArrival = $request->{"healthArrivalDate"};

        $arr = json_decode($respuestaOperardor->json,true);
        
        $telefonoObjeto = array_filter($arr[0], function($campo) {

            if($campo['label'] == "N�mero de tel�fono"){
                return $campo;
            }

            return null;
        });
        if(isset($telefonoObjeto[3])){
            $telefono = $telefonoObjeto[3]["value"];
        }else{
            $telefono = $telefonoObjeto[4]["value"];
        }


        $nombreObjeto = array_filter($arr[0], function($campo) {

            if($campo['label'] == "Nombre completo del Operador"){
                return $campo;
            }

            return null;
        });
        if(isset($nombreObjeto[1])){
            $nombre = $nombreObjeto[1]["value"];
        }else{
            $nombre = $nombreObjeto[2]["value"];
        }

        $resultado = 
        [
            "healthArrivalDate"=> $healtArrival,
            "lat"=> $latitud,
            "lng"=> $longitud,
            "address"=> $direccion,
            "callerPhone"=> $telefono,
            "callerName"=> $nombre,
            "observations"=> $observaciones,
            "arrivedBy"=> "AMB_MED",
            "createdBy"=> "CIGA"
        ];

        return $resultado;

    }


    public function obtenerInformacionInformacionApis1($formValueId)
    {
        //echo $formValueId;


        $idFormularioInformacionEvento = $this->buscarInformacionEvento($formValueId);


        if($idFormularioInformacionEvento == null){
            return "Recuerde que debe diligenciar el Formulario de INFORMACIÓN DEL EVENTO";
        }

        $respuestaFormularioInformacionEvento = FormValue::where("id", $idFormularioInformacionEvento)->first();

        

        $listaRespuetasInformacionEvento = json_decode($respuestaFormularioInformacionEvento->json,true);

        $deaSeleccionadaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("DEA's disponibles en el lugar"))){
            return $campo;
          }
          return null;
          
        });
        $deaSeleccionada = "";
        foreach($deaSeleccionadaObjeto as $j => $item2) {
            foreach($item2["values"] as $k => $item3) {
                if(isset($item3["selected"])){
                    $deaSeleccionada = $item3["label"];
                }
            }
        }

        // $deaSeleccionadaObjeto = $deaSeleccionadaObjeto[5]["value"];


        // print_r($deaSeleccionada);

        $informacionInstalacion = $this->buscarInformacionInstalacion($deaSeleccionada);

        // print_r($informacionInstalacion);

        // // echo $respuestaFormularioInformacionEvento->form_id;
        // return; 


        
        $documentoPacienteObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Número de documento de identificación del paciente"))){
            return $campo;
          }
          return null;
        });

        $numeroDoumentoPaciente = $documentoPacienteObjeto[5]["value"];

        // print_r($documentoPacienteObjeto[5]["value"]);

        $idFormUsoDesfribrilador = $this->buscarUsoDesfibrilador($numeroDoumentoPaciente);

        if($idFormUsoDesfribrilador == null){
            return "Recuerde que debe diligenciar el Formulario de reporte uso de Desfibrilador Externo Automático - DEA en ambiente extrahospitalario";
        }

        $respuestaFormularioUsoDesfibrilador = FormValue::where("id", $idFormUsoDesfribrilador)->first();
        // echo $respuestaFormularioUsoDesfibrilador->json;

        $respuestasUsoDesfebrilador = json_decode($respuestaFormularioUsoDesfibrilador->json,true);
        $nombreLugar = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
          if($campo['label'] == "Nombre del lugar del evento"){
            return $campo;
          }
          return null;
        });
        $nombreLugarEvento = $nombreLugar[1]["value"];


        $fechaRegistroObjeto = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Fecha del evento"))){
            return $campo;
          }
          return null;
        });
        $fechaRegistro = $fechaRegistroObjeto[0]["value"];




        $nombreAtendidoObjeto = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Nombre completo"))){
            return $campo;
          }
          return null;
        });
        $nombreAtendido = $nombreAtendidoObjeto[3]["value"];


        $tipoDocumentoObjeto = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Tipo de documento de identificación"))){
            return $campo;
          }
          return null;
        });

        $tipoDocumento = "";
        foreach($tipoDocumentoObjeto as $j => $item2) {
            foreach($item2["values"] as $k => $item3) {
                if(isset($item3["selected"])){
                    $tipoDocumento = $item3["value"];
                }
            }
        }



        $edadPacienteEvento = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Edad"))){
            return $campo;
          }
          return null;
        });
        $edadPaciente = $edadPacienteEvento[6]["value"];


        $sexoObjeto = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Sexo"))){
            return $campo;
          }
          return null;
        });

        $sexo = "";
        foreach($sexoObjeto as $j => $item2) {
            foreach($item2["values"] as $k => $item3) {
                if(isset($item3["selected"])){
                    $sexo = $item3["value"];
                }
            }
        }
        // $sexo = $sexoObjeto[7]["value"];



        $telefonoObjeto = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Teléfono"))){
            return $campo;
          }
          return null;
        });
        // $telefono = $telefonoObjeto[21]["value"];
        $telefono = "";

        $aseguradoraSaludObjeto = array_filter($respuestasUsoDesfebrilador[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Aseguradora de salud"))){
            return $campo;
          }
          return null;
        });
        $aseguradoraSalud = $aseguradoraSaludObjeto[21]["value"];



        $nombrepersonaUsaDeaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Nombre de la persona que utilizó el DEA"))){
            return $campo;
          }
          return null;
        });
        $nombrepersonaUsaDea = $nombrepersonaUsaDeaObjeto[7]["value"];


        $tipoDocumentopersonaUsaDeaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if(str_contains(strtoupper($campo['label']), strtoupper("Tipo de documento de identificación"))){
            return $campo;
          }
          return null;
        });
        $tipoDocumentoPersonaAtiende = "";
        foreach($tipoDocumentopersonaUsaDeaObjeto as $j => $item2) {
            foreach($item2["values"] as $k => $item3) {
                if(isset($item3["selected"])){
                    $tipoDocumentoPersonaAtiende = $item3["value"];
                }
            }
        }
        // $tipoDocumentopersonaUsaDea = $tipoDocumentopersonaUsaDeaObjeto[7]["value"];


        $documentoPersonaUsaDeaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if($campo['label'] == "Número de documento de identificación"){
            return $campo;
          }
          return null;
        });
        $documentoPersonaUsaDea = $documentoPersonaUsaDeaObjeto[9]["value"];


        $horaInicioEventoObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          if($campo['label'] == "Hora Del Inicio Del Evento"){
            return $campo;
          }
          return null;
        });
        $horaInicioEvento = $horaInicioEventoObjeto[10]["value"];



        $horaActivacionCadenaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          
          if($campo['label'] == "Hora de activación cadena de supervivencia"){
            return $campo;
          }
          return null;
        });
        $horaActivacionCadena = $horaActivacionCadenaObjeto[11]["value"];



        $horaActivacionCadenaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          
          if($campo['label'] == "Hora de activación cadena de supervivencia"){
            return $campo;
          }
          return null;
        });
        $horaActivacionCadena = $horaActivacionCadenaObjeto[11]["value"];


        $horaUtilizacionDeaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          
          if($campo['label'] == "Hora De utilización del DEA"){
            return $campo;
          }
          return null;
        });
        $horaUtilizacionDea = $horaUtilizacionDeaObjeto[12]["value"];



        $horaTrasladoDeaObjeto = array_filter($listaRespuetasInformacionEvento[0], function($campo) {
            // echo $campo['label'];
            // echo "<br />";
          
          if($campo['label'] == "Hora De traslado de la persona atendida a la institución de salud"){
            return $campo;
          }
          return null;
        });
        $horaTrasladoDea = $horaTrasladoDeaObjeto[13]["value"];


        $nombreTransporteObjeto = array_filter($listaRespuetasInformacionEvento[1], function($campo) {
          if($campo['label'] == "Nombre de la persona encargada del traslado"){
            return $campo;
          }
          return null;
        });
        $nombreTransporteEncargado = $nombreTransporteObjeto[1]["value"];


        $medioTransporteObjeto = array_filter($listaRespuetasInformacionEvento[1], function($campo) {
          
          if($campo['label'] == "Medio de transporte utilizado para el traslado:"){
            return $campo;
          }
          return null;
        });
        $medioTransporte = "";
        foreach($medioTransporteObjeto as $j => $item2) {
            foreach($item2["values"] as $k => $item3) {
                if(isset($item3["selected"])){
                    $medioTransporte = $item3["value"];
                }
            }
        }



        $empresaAmbulanciaObjeto = array_filter($listaRespuetasInformacionEvento[1], function($campo) {
          if($campo['label'] == "Nombre de la empresa de la ambulancia"){
            return $campo;
          }
          return null;
        });
        $empresaAmbulancia = $empresaAmbulanciaObjeto[4]["value"];


        $observacionesObjeto = array_filter($listaRespuetasInformacionEvento[1], function($campo) {
          if($campo['label'] == "Observaciones"){
            return $campo;
          }
          return null;
        });
        $observaciones = $observacionesObjeto[5]["value"];



        $resultado = [
            "FECHAEVENTO"=> $fechaRegistro,
            "NOMBRELUGAREVENTO"=> $nombreLugarEvento,
            "PERSONAATENDIDAEVENTONOMBRE"=> $nombreAtendido,
            "PERSONAATENDIDAEVENTOTIPODOCUMENTO"=> $tipoDocumento,
            "PERSONAATENDIDAEVENTONUMERODOCUMENTO"=> $numeroDoumentoPaciente,
            "PERSONAATENDIDAEVENTOEDAD"=> $edadPaciente,
            "PERSONAATENDIDAEVENTOSEXO"=> $sexo,
            "PERSONAATENDIDAEVENTOASEGURADORSALUD"=> $aseguradoraSalud,
            "DATOSEVENTONOMBREPERSONAUTILIZODEA"=> $nombrepersonaUsaDea,
            "DATOSEVENTOTIPODOCUMENTO"=> $tipoDocumentoPersonaAtiende,
            "DATOSEVENTONUMERODOCUMENTO"=> $documentoPersonaUsaDea,
            "DATOSEVENTOTELEFONO"=> $telefono,
            "DATOSEVENTOHORAINICIOEVENTO"=> $horaInicioEvento,
            "DATOSEVENTOHORAACTIVACIONCADENASUPERVIVENCIA"=> $horaActivacionCadena,
            "DATOSEVENTOHORAUTILIZACIONDEA"=> $horaUtilizacionDea,
            "DATOSEVENTOHORATRASLADOPERSONAATENDIDA"=> $horaTrasladoDea,
            "DATOSMEDIOTRANSPORTENOMBREENCARGADO"=> $nombreTransporteEncargado,
            "DATOSMEDIOTRANSPORTEMEDIOTRANSPORTE"=> $medioTransporte,
            "DATOSMEDIOTRANSPORTEEMPRESAAMBULANCIA"=> $empresaAmbulancia,
            "DATOSMEDIOTRANSPORTEOBSERVACIONES"=> $observaciones,
            "INFORMACIONINSTALACION" => $informacionInstalacion
        ];


        return $resultado;

    }



    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName           = $request->upload->store('editor');
            $CKEditorFuncNum    = $request->input('CKEditorFuncNum');
            $url                = Storage::url($fileName);
            $msg                = 'Image uploaded successfully';
            $response           = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
@header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function duplicate(Request $request)
    {
        if (\Auth::guard('api')->user()->rol == 'Administrador') {
            $form = Form::find($request->form_id);
            if ($form) {
                Form::create([
                    'title'           => $form->title . ' (copy)',
                    'logo'            => $form->logo,
                    'email'           => $form->email,
                    'success_msg'     => $form->success_msg,
                    'thanks_msg'      => $form->thanks_msg,
                    'json'            => $form->json,
                    'payment_status'  => $form->payment_status,
                    'amount'          => $form->amount,
                    'currency_symbol' => $form->currency_symbol,
                    'currency_name'   => $form->currency_name,
                    'payment_type'    => $form->payment_type,
                    'created_by'      => Auth::guard('api')->user()->id,
                    'is_active'       => $form->is_active,
                    'assign_type'     => $form->assign_type,
                ]);
                return redirect()->back()->with('success', __('Formulario duplicado exitosamente.'));
            } else {
                return redirect()->back()->with('errors', __('Formulario no encontrado.'));
            }
        } else {
            return redirect()->back()->with('errors', __('Permiso denegado.'));
        }
    }

    public function ckupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName         = $request->file('upload')->getClientOriginalName();
            $fileName           = pathinfo($originName, PATHINFO_FILENAME);
            $extension          = $request->file('upload')->getClientOriginalExtension();
            $fileName           = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum    = $request->input('CKEditorFuncNum');
            $url                = asset('images/' . $fileName);
            $msg                = __('Image uploaded successfully');
            $response           = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
@header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function dropzone(Request $request, $id)
    {
        $allowedfileExtension   = [];
        $values                 = '';
        if ($request->file_extention == 'pdf') {
            $allowedfileExtension = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox'];
        } else if ($request->file_extention == 'image') {
            $allowedfileExtension = ['jpeg', 'jpg', 'png'];
        } else if ($request->file_extention == 'excel') {
            $allowedfileExtension = ['xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
        }
        if ($request->hasFile('file')) {
            $file         = $request->file('file');
            $extension    = $file->getClientOriginalExtension();
            if (in_array($extension, $allowedfileExtension)) {
                $filename = $file->store('form-values/' . $id);
                $values   = $filename;
            } else {
                return response()->json(['errors' => 'Solo ' . implode(',', $allowedfileExtension) . ' archivo permitido']);
            }
            return response()->json(['success' => 'Archivo cargado exitosamente.', 'filename' => $values]);
        } else {
            return response()->json(['errors' => 'Archivo no encontrado.']);
        }
    }

    public function formStatus(Request $request, $id)
    {
        $form   = Form::find($id);
        $input  = ($request->value == "true") ? 1 : 0;
        if ($form) {
            $form->is_active = $input;
            $form->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Estado del formularioo cambiado exitosamente.')]);
    }

    public function formIntegration($id)
    {
        $form           = Form::find($id);
        $formJsons      = json_decode($form->json);
        $slackSettings  = FormIntegrationSetting::where('key', 'slack_integration')->where('form_id', $form->id)->first();
        $slackJsons     = [];
        $slackFieldJsons = [];
        if ($slackSettings) {
            $slackFieldJsons = json_decode($slackSettings->field_json, true);
            $slackJsons      = json_decode($slackSettings->json, true);
        }
        $telegramSettings   = FormIntegrationSetting::where('key', 'telegram_integration')->where('form_id', $form->id)->first();
        $telegramJsons      = [];
        $telegramFieldJsons = [];
        if ($telegramSettings) {
            $telegramFieldJsons = json_decode($telegramSettings->field_json, true);
            $telegramJsons      = json_decode($telegramSettings->json, true);
        }
        $mailgunSettings    = FormIntegrationSetting::where('key', 'mailgun_integration')->where('form_id', $form->id)->first();
        $mailgunJsons       = [];
        $mailgunFieldJsons  = [];
        if ($mailgunSettings) {
            $mailgunFieldJsons = json_decode($mailgunSettings->field_json, true);
            $mailgunJsons      = json_decode($mailgunSettings->json, true);
        }
        $bulkgateSettings   = FormIntegrationSetting::where('key', 'bulkgate_integration')->where('form_id', $form->id)->first();
        $bulkgateJsons      = [];
        $bulkgateFieldJsons = [];
        if ($bulkgateSettings) {
            $bulkgateFieldJsons = json_decode($bulkgateSettings->field_json, true);
            $bulkgateJsons      = json_decode($bulkgateSettings->json, true);
        }
        $nexmoSettings      = FormIntegrationSetting::where('key', 'nexmo_integration')->where('form_id', $form->id)->first();
        $nexmoJsons         = [];
        $nexmoFieldJsons    = [];
        if ($nexmoSettings) {
            $nexmoFieldJsons = json_decode($nexmoSettings->field_json, true);
            $nexmoJsons      = json_decode($nexmoSettings->json, true);
        }
        $fast2smsSettings   = FormIntegrationSetting::where('key', 'fast2sms_integration')->where('form_id', $form->id)->first();
        $fast2smsJsons      = [];
        $fast2smsFieldJsons = [];
        if ($fast2smsSettings) {
            $fast2smsFieldJsons = json_decode($fast2smsSettings->field_json, true);
            $fast2smsJsons      = json_decode($fast2smsSettings->json, true);
        }
        $vonageSettings     = FormIntegrationSetting::where('key', 'vonage_integration')->where('form_id', $form->id)->first();
        $vonageJsons        = [];
        $vonageFieldJsons   = [];
        if ($vonageSettings) {
            $vonageFieldJsons = json_decode($vonageSettings->field_json, true);
            $vonageJsons      = json_decode($vonageSettings->json, true);
        }
        $sendgridSettings   = FormIntegrationSetting::where('key', 'sendgrid_integration')->where('form_id', $form->id)->first();
        $sendgridJsons      = [];
        $sendgridFieldJsons = [];
        if ($sendgridSettings) {
            $sendgridFieldJsons = json_decode($sendgridSettings->field_json, true);
            $sendgridJsons      = json_decode($sendgridSettings->json, true);
        }
        $twilioSettings     = FormIntegrationSetting::where('key', 'twilio_integration')->where('form_id', $form->id)->first();
        $twilioJsons        = [];
        $twilioFieldJsons   = [];
        if ($twilioSettings) {
            $twilioFieldJsons = json_decode($twilioSettings->field_json, true);
            $twilioJsons      = json_decode($twilioSettings->json, true);
        }
        $textlocalSettings      = FormIntegrationSetting::where('key', 'textlocal_integration')->where('form_id', $form->id)->first();
        $textlocalJsons         = [];
        $textlocalFieldJsons    = [];
        if ($textlocalSettings) {
            $textlocalFieldJsons = json_decode($textlocalSettings->field_json, true);
            $textlocalJsons      = json_decode($textlocalSettings->json, true);
        }
        $messenteSettings   = FormIntegrationSetting::where('key', 'messente_integration')->where('form_id', $form->id)->first();
        $messenteJsons      = [];
        $messenteFieldJsons = [];
        if ($messenteSettings) {
            $messenteFieldJsons = json_decode($messenteSettings->field_json, true);
            $messenteJsons      = json_decode($messenteSettings->json, true);
        }
        $smsgatewaySettings = FormIntegrationSetting::where('key', 'smsgateway_integration')->where('form_id', $form->id)->first();
        $smsgatewayJsons = [];
        $smsgatewayFieldJsons = [];
        if ($smsgatewaySettings) {
            $smsgatewayFieldJsons = json_decode($smsgatewaySettings->field_json, true);
            $smsgatewayJsons = json_decode($smsgatewaySettings->json, true);
        }
        $clicktellSettings = FormIntegrationSetting::where('key', 'clicktell_integration')->where('form_id', $form->id)->first();
        $clicktellJsons = [];
        $clicktellFieldJsons = [];
        if ($clicktellSettings) {
            $clicktellFieldJsons = json_decode($clicktellSettings->field_json, true);
            $clicktellJsons = json_decode($clicktellSettings->json, true);
        }
        $clockworkSettings = FormIntegrationSetting::where('key', 'clockwork_integration')->where('form_id', $form->id)->first();
        $clockworkJsons = [];
        $clockworkFieldJsons = [];
        if ($clockworkSettings) {
            $clockworkFieldJsons = json_decode($clockworkSettings->field_json, true);
            $clockworkJsons = json_decode($clockworkSettings->json, true);
        }
        return view('form.integration.index', compact('form', 'slackJsons', 'telegramJsons', 'mailgunJsons', 'bulkgateJsons', 'nexmoJsons', 'fast2smsJsons', 'vonageJsons', 'sendgridJsons', 'twilioJsons', 'textlocalJsons', 'messenteJsons', 'smsgatewayJsons', 'clicktellJsons', 'clockworkJsons', 'formJsons', 'slackFieldJsons', 'telegramFieldJsons', 'mailgunFieldJsons', 'bulkgateFieldJsons', 'nexmoFieldJsons', 'fast2smsFieldJsons', 'vonageFieldJsons', 'sendgridFieldJsons', 'twilioFieldJsons', 'textlocalFieldJsons', 'messenteFieldJsons', 'smsgatewayFieldJsons', 'clicktellFieldJsons', 'clockworkFieldJsons'));
    }

    public function slackIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.slack', compact('form', 'formJsons'));
    }

    public function telegramIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.telegram', compact('form', 'formJsons'));
    }

    public function mailgunIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.mailgun', compact('form', 'formJsons'));
    }

    public function bulkgateIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.bulkgate', compact('form', 'formJsons'));
    }

    public function nexmoIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.nexmo', compact('form', 'formJsons'));
    }

    public function fast2smsIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.fast2sms', compact('form', 'formJsons'));
    }

    public function vonageIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.vonage', compact('form', 'formJsons'));
    }

    public function sendgridIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.sendgrid', compact('form', 'formJsons'));
    }

    public function twilioIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.twilio', compact('form', 'formJsons'));
    }

    public function textlocalIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.textlocal', compact('form', 'formJsons'));
    }

    public function messenteIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.messente', compact('form', 'formJsons'));
    }

    public function smsgatewayIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.smsgateway', compact('form', 'formJsons'));
    }

    public function clicktellIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.clicktell', compact('form', 'formJsons'));
    }

    public function clockworkIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.clockwork', compact('form', 'formJsons'));
    }

    public function formpaymentIntegration(Request $request, $id)
    {
        $form = Form::find($id);
        $paymentType = [];
        $paymentType[''] = 'Select payment';
        if (UtilityFacades::getsettings('stripesetting') == 'on') {
            $paymentType['stripe'] = 'Stripe';
        }
        if (UtilityFacades::getsettings('paypalsetting') == 'on') {
            $paymentType['paypal'] = 'Paypal';
        }
        if (UtilityFacades::getsettings('razorpaysetting') == 'on') {
            $paymentType['razorpay'] = 'Razorpay';
        }
        if (UtilityFacades::getsettings('paytmsetting') == 'on') {
            $paymentType['paytm'] = 'Paytm';
        }
        if (UtilityFacades::getsettings('flutterwavesetting') == 'on') {
            $paymentType['flutterwave'] = 'Flutterwave';
        }
        if (UtilityFacades::getsettings('paystacksetting') == 'on') {
            $paymentType['paystack'] = 'Paystack';
        }
        if (UtilityFacades::getsettings('payumoneysetting') == 'on') {
            $paymentType['payumoney'] = 'PayuMoney';
        }
        if (UtilityFacades::getsettings('molliesetting') == 'on') {
            $paymentType['mollie'] = 'Mollie';
        }
        if (UtilityFacades::getsettings('coingatesetting') == 'on') {
            $paymentType['coingate'] = 'Coingate';
        }
        if (UtilityFacades::getsettings('mercadosetting') == 'on') {
            $paymentType['mercado'] = 'Mercado';
        }
        return view('form.payment', compact('form', 'paymentType'));
    }

    public function formpaymentIntegrationstore(Request $request, $id)
    {
        $form = Form::find($id);
        if ($request->payment_type == "paystack") {
            if ($request->currency_symbol != '₦' || $request->currency_name != 'NGN') {
                return redirect()->back()->with('failed', __('Currency not suppoted this payment getway. please enter NGN currency and ₦ symbol.'));
            }
        }
        if ($request->payment_type == "paytm") {
            if ($request->currency_symbol != '₹' || $request->currency_name != 'INR') {
                return redirect()->back()->with('failed', __('Currency not suppoted this payment getway. please enter INR currency and ₹ symbol.'));
            }
        }
        $form->payment_status   = ($request->payment == 'on') ? '1' : '0';
        $form->amount           = ($request->amount == '') ? '0' : $request->amount;
        $form->currency_symbol  = $request->currency_symbol;
        $form->currency_name    = $request->currency_name;
        $form->payment_type     = $request->payment_type;
        $form->save();
        return redirect()->back()->with('success', __('Form payment integration succesfully.'));
    }

    public function formIntegrationStore(Request $request, $id)
    {
        $slackdata = [];
        $slackFiledtext = [];
        if ($request->get('slack_webhook_url')) {
            foreach ($request->get('slack_webhook_url') as $slackkey => $slackvalue) {
                $slackdata[$slackkey]['slack_webhook_url'] = $slackvalue;
                $slackField                                = $request->input('slack_field' . $slackkey);
                if ($slackField) {
                    $slackFiledtext[] = implode(',', $slackField);
                }
            }
        }
        $slackJsonData = ($slackdata) ? json_encode($slackdata) : null;
        FormIntegrationSetting::updateOrCreate(
            ['form_id' => $id,  'key' => 'slack_integration'],
            ['status' => ($request->get('slack_webhook_url')) ? 1 : 0, 'field_json' => json_encode($slackFiledtext), 'json' => $slackJsonData]
        );
        $telegramdata = [];
        $telegramFiledtext = [];
        if ($request->get('telegram_access_token') && $request->get('telegram_chat_id')) {
            foreach ($request->get('telegram_access_token') as $telegramkey => $telegramvalue) {
                $telegramdata[$telegramkey]['telegram_access_token'] = $telegramvalue;
                $telegramdata[$telegramkey]['telegram_chat_id']      = $request->get('telegram_chat_id')[$telegramkey];
                $telegramField                                       = $request->input('telegram_field' . $telegramkey);
                if ($telegramField) {
                    $telegramFiledtext[] = implode(',', $telegramField);
                }
            }
        }
        $telegramJsonData = ($telegramdata) ? json_encode($telegramdata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'telegram_integration'],
            ['status' => ($request->get('telegram_access_token') && $request->get('telegram_chat_id')) ? 1 : 0, 'field_json' => json_encode($telegramFiledtext), 'json' => $telegramJsonData]
        );

        $mailgundata = [];
        $mailgunFiledtext = [];
        if ($request->get('mailgun_email') && $request->get('mailgun_domain') && $request->get('mailgun_secret')) {
            foreach ($request->get('mailgun_email') as $mailgunkey => $mailgunvalue) {
                $mailgundata[$mailgunkey]['mailgun_email']       = $mailgunvalue;
                $mailgundata[$mailgunkey]['mailgun_domain']      = $request->get('mailgun_domain')[$mailgunkey];
                $mailgundata[$mailgunkey]['mailgun_secret']      = $request->get('mailgun_secret')[$mailgunkey];
                $mailgunField                                    = $request->input('mailgun_field' . $mailgunkey);
                if ($mailgunField) {
                    $mailgunFiledtext[] = implode(',', $mailgunField);
                }
            }
        }
        $mailgunJsonData = ($mailgundata) ? json_encode($mailgundata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'mailgun_integration'],
            ['status' => ($request->get('mailgun_email') && $request->get('mailgun_domain') && $request->get('mailgun_secret')) ? 1 : 0, 'field_json' => json_encode($mailgunFiledtext), 'json' => $mailgunJsonData]
        );

        $bulkgatedata = [];
        $bulkgateFiledtext = [];
        if ($request->get('bulkgate_number') && $request->get('bulkgate_token') && $request->get('bulkgate_app_id')) {
            foreach ($request->get('bulkgate_number') as $bulkgatekey => $bulkgatevalue) {
                $bulkgatedata[$bulkgatekey]['bulkgate_number']      = $bulkgatevalue;
                $bulkgatedata[$bulkgatekey]['bulkgate_token']       = $request->get('bulkgate_token')[$bulkgatekey];
                $bulkgatedata[$bulkgatekey]['bulkgate_app_id']      = $request->get('bulkgate_app_id')[$bulkgatekey];
                $bulkgateField                                      = $request->input('bulkgate_field' . $bulkgatekey);
                if ($bulkgateField) {
                    $bulkgateFiledtext[] = implode(',', $bulkgateField);
                }
            }
        }
        $bulkgateJsonData = ($bulkgatedata) ? json_encode($bulkgatedata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'bulkgate_integration'],
            ['status' => ($request->get('bulkgate_number') && $request->get('bulkgate_token') && $request->get('bulkgate_app_id')) ? 1 : 0, 'field_json' => json_encode($bulkgateFiledtext), 'json' => $bulkgateJsonData]
        );

        $nexmodata = [];
        $nexmoFiledtext = [];
        if ($request->get('nexmo_number') && $request->get('nexmo_key') && $request->get('nexmo_secret')) {
            foreach ($request->get('nexmo_number') as $nexmokey => $nexmovalue) {
                $nexmodata[$nexmokey]['nexmo_number']   = $nexmovalue;
                $nexmodata[$nexmokey]['nexmo_key']      = $request->get('nexmo_key')[$nexmokey];
                $nexmodata[$nexmokey]['nexmo_secret']   = $request->get('nexmo_secret')[$nexmokey];
                $nexmoField                             = $request->input('nexmo_field' . $nexmokey);
                if ($nexmoField) {
                    $nexmoFiledtext[] = implode(',', $nexmoField);
                }
            }
        }
        $nexmoJsonData = ($nexmodata) ? json_encode($nexmodata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'nexmo_integration'],
            ['status' => ($request->get('nexmo_number') && $request->get('nexmo_key') && $request->get('nexmo_secret')) ? 1 : 0, 'field_json' => json_encode($nexmoFiledtext), 'json' => $nexmoJsonData]
        );
        $fast2smsdata = [];
        $fast2smsFiledtext = [];
        if ($request->get('fast2sms_number') && $request->get('fast2sms_api_key')) {
            foreach ($request->get('fast2sms_number') as $fast2smskey => $fast2smsvalue) {
                $fast2smsdata[$fast2smskey]['fast2sms_number']   = $fast2smsvalue;
                $fast2smsdata[$fast2smskey]['fast2sms_api_key']  = $request->input('fast2sms_api_key')[$fast2smskey];
                $fast2smsField                                   = $request->input('fast2sms_field' . $fast2smskey);
                if ($fast2smsField) {
                    $fast2smsFiledtext[] = implode(',', $fast2smsField);
                }
            }
        }
        $fast2smsJsonData = ($fast2smsdata) ? json_encode($fast2smsdata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'fast2sms_integration'],
            ['status' => ($request->get('fast2sms_number') && $request->get('fast2sms_api_key')) ? 1 : 0, 'field_json' => json_encode($fast2smsFiledtext), 'json' => $fast2smsJsonData]
        );

        $vonagedata = [];
        $vonageFiledtext = [];
        if ($request->get('vonage_number') && $request->get('vonage_key') && $request->get('vonage_secret')) {
            foreach ($request->get('vonage_number') as $vonagekey => $vonagevalue) {
                $vonagedata[$vonagekey]['vonage_number']  = $vonagevalue;
                $vonagedata[$vonagekey]['vonage_key']     = $request->input('vonage_key')[$vonagekey];
                $vonagedata[$vonagekey]['vonage_secret']  = $request->input('vonage_secret')[$vonagekey];
                $vonageField                              = $request->input('vonage_field' . $vonagekey);
                if ($vonageField) {
                    $vonageFiledtext[] = implode(',', $vonageField);
                }
            }
        }
        $vonageJsonData = ($vonagedata) ? json_encode($vonagedata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'vonage_integration'],
            ['status' => ($request->get('vonage_number') && $request->get('vonage_key') && $request->get('vonage_secret')) ? 1 : 0, 'field_json' => json_encode($vonageFiledtext), 'json' => $vonageJsonData]
        );

        $sendgriddata = [];
        $sendgridFiledtext = [];
        if ($request->get('sendgrid_email') && $request->get('sendgrid_host') && $request->get('sendgrid_port') && $request->get('sendgrid_username') && $request->get('sendgrid_password') && $request->get('sendgrid_encryption') && $request->get('sendgrid_from_address') && $request->get('sendgrid_from_name')) {
            foreach ($request->get('sendgrid_email') as $sendgridkey => $sendgridvalue) {
                $sendgriddata[$sendgridkey]['sendgrid_email']           = $sendgridvalue;
                $sendgriddata[$sendgridkey]['sendgrid_host']            = $request->get('sendgrid_host')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_port']            = $request->get('sendgrid_port')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_username']        = $request->get('sendgrid_username')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_password']        = $request->get('sendgrid_password')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_encryption']      = $request->get('sendgrid_encryption')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_from_address']    = $request->get('sendgrid_from_address')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_from_name']       = $request->get('sendgrid_from_name')[$sendgridkey];
                $sendgridField                                          = $request->input('sendgrid_field' . $sendgridkey);
                if ($sendgridField) {
                    $sendgridFiledtext[] = implode(',', $sendgridField);
                }
            }
        }
        $sendgridJsonData = ($sendgriddata) ? json_encode($sendgriddata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'sendgrid_integration'],
            ['status' => ($request->get('sendgrid_email') && $request->get('sendgrid_host') && $request->get('sendgrid_port') && $request->get('sendgrid_username') && $request->get('sendgrid_password') && $request->get('sendgrid_encryption') && $request->get('sendgrid_from_address') && $request->get('sendgrid_from_name')) ? 1 : 0, 'field_json' => json_encode($sendgridFiledtext), 'json' => $sendgridJsonData]
        );

        $twiliodata = [];
        $twilioFiledtext = [];
        if ($request->get('twilio_mobile_number') && $request->get('twilio_sid') && $request->get('twilio_auth_token') && $request->get('twilio_number')) {
            foreach ($request->get('twilio_mobile_number') as $twiliokey => $twiliovalue) {
                $twiliodata[$twiliokey]['twilio_mobile_number']    = $twiliovalue;
                $twiliodata[$twiliokey]['twilio_sid']              = $request->get('twilio_sid')[$twiliokey];
                $twiliodata[$twiliokey]['twilio_auth_token']       = $request->get('twilio_auth_token')[$twiliokey];
                $twiliodata[$twiliokey]['twilio_number']           = $request->get('twilio_number')[$twiliokey];
                $twilioField                                       = $request->input('twilio_field' . $twiliokey);
                if ($twilioField) {
                    $twilioFiledtext[] = implode(',', $twilioField);
                }
            }
        }
        $twilioJsonData = ($twiliodata) ? json_encode($twiliodata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'twilio_integration'],
            ['status' => ($request->get('twilio_mobile_number') && $request->get('twilio_sid') && $request->get('twilio_auth_token') && $request->get('twilio_number')) ? 1 : 0, 'field_json' => json_encode($twilioFiledtext), 'json' => $twilioJsonData]
        );

        $textlocaldata = [];
        $textlocalFiledtext = [];
        if ($request->get('textlocal_number') && $request->get('textlocal_api_key')) {
            foreach ($request->get('textlocal_number') as $textlocalkey => $textlocalvalue) {
                $textlocaldata[$textlocalkey]['textlocal_number']   = $textlocalvalue;
                $textlocaldata[$textlocalkey]['textlocal_api_key']  = $request->input('textlocal_api_key')[$textlocalkey];
                $textlocalField                                   = $request->input('textlocal_field' . $textlocalkey);
                if ($textlocalField) {
                    $textlocalFiledtext[] = implode(',', $textlocalField);
                }
            }
        }
        $textlocalJsonData = ($textlocaldata) ? json_encode($textlocaldata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'textlocal_integration'],
            ['status' => ($request->get('textlocal_number') && $request->get('textlocal_api_key')) ? 1 : 0, 'field_json' => json_encode($textlocalFiledtext), 'json' => $textlocalJsonData]
        );

        $messentedata = [];
        $messenteFiledtext = [];
        if ($request->get('messente_number') && $request->get('messente_api_username') && $request->get('messente_api_password') && $request->get('messente_sender')) {
            foreach ($request->get('messente_number') as $messentekey => $messentevalue) {
                $messentedata[$messentekey]['messente_number']                    = $messentevalue;
                $messentedata[$messentekey]['messente_api_username']              = $request->get('messente_api_username')[$messentekey];
                $messentedata[$messentekey]['messente_api_password']              = $request->get('messente_api_password')[$messentekey];
                $messentedata[$messentekey]['messente_sender']                    = $request->get('messente_sender')[$messentekey];
                $messenteField                                                    = $request->input('messente_field' . $messentekey);
                if ($messenteField) {
                    $messenteFiledtext[] = implode(',', $messenteField);
                }
            }
        }
        $messenteJsonData = ($messentedata) ? json_encode($messentedata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'messente_integration'],
            ['status' => ($request->get('messente_number') && $request->get('messente_api_username') && $request->get('messente_api_password') && $request->get('messente_sender')) ? 1 : 0, 'field_json' => json_encode($messenteFiledtext), 'json' => $messenteJsonData]
        );

        $smsgatewaydata = [];
        $smsgatewayFiledtext = [];
        if ($request->get('smsgateway_number') && $request->get('smsgateway_api_key') && $request->get('smsgateway_user_id') && $request->get('smsgateway_user_password') && $request->get('smsgateway_sender_id')) {
            foreach ($request->get('smsgateway_number') as $smsgatewaykey => $smsgatewayvalue) {
                $smsgatewaydata[$smsgatewaykey]['smsgateway_number']              = $smsgatewayvalue;
                $smsgatewaydata[$smsgatewaykey]['smsgateway_api_key']             = $request->get('smsgateway_api_key')[$smsgatewaykey];
                $smsgatewaydata[$smsgatewaykey]['smsgateway_user_id']             = $request->get('smsgateway_user_id')[$smsgatewaykey];
                $smsgatewaydata[$smsgatewaykey]['smsgateway_user_password']       = $request->get('smsgateway_user_password')[$smsgatewaykey];
                $smsgatewaydata[$smsgatewaykey]['smsgateway_sender_id']           = $request->get('smsgateway_sender_id')[$smsgatewaykey];
                $smsgatewayField                                                  = $request->input('smsgateway_field' . $smsgatewaykey);
                if ($smsgatewayField) {
                    $smsgatewayFiledtext[] = implode(',', $smsgatewayField);
                }
            }
        }
        $smsgatewayJsonData = ($smsgatewaydata) ? json_encode($smsgatewaydata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'smsgateway_integration'],
            ['status' => ($request->get('smsgateway_number') && $request->get('smsgateway_sid') && $request->get('smsgateway_user_id') && $request->get('smsgateway_user_password') && $request->get('smsgateway_sender_id')) ? 1 : 0, 'field_json' => json_encode($smsgatewayFiledtext), 'json' => $smsgatewayJsonData]
        );
        $clicktelldata = [];
        $clicktellFiledtext = [];
        if ($request->get('clicktell_number') && $request->get('clicktell_api_key')) {
            foreach ($request->get('clicktell_number') as $clicktellkey => $clicktellvalue) {
                $clicktelldata[$clicktellkey]['clicktell_number']              = $clicktellvalue;
                $clicktelldata[$clicktellkey]['clicktell_api_key']             = $request->get('clicktell_api_key')[$clicktellkey];
                $clicktellField                                                = $request->input('clicktell_field' . $clicktellkey);
                if ($clicktellField) {
                    $clicktellFiledtext[] = implode(',', $clicktellField);
                }
            }
        }
        $clicktellJsonData = ($clicktelldata) ? json_encode($clicktelldata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'clicktell_integration'],
            ['status' => ($request->get('clicktell_number') && $request->get('clicktell_api_key')) ? 1 : 0, 'field_json' => json_encode($clicktellFiledtext), 'json' => $clicktellJsonData]
        );

        $clockworkdata = [];
        $clockworkFiledtext = [];
        if ($request->get('clockwork_number') && $request->get('clockwork_api_token')) {
            foreach ($request->get('clockwork_number') as $clockworkkey => $clockworkvalue) {
                $clockworkdata[$clockworkkey]['clockwork_number']     = $clockworkvalue;
                $clockworkdata[$clockworkkey]['clockwork_api_token']  = $request->input('clockwork_api_token')[$clockworkkey];
                $clockworkField                                       = $request->input('clockwork_field' . $clockworkkey);
                if ($clockworkField) {
                    $clockworkFiledtext[] = implode(',', $clockworkField);
                }
            }
        }
        $clockworkJsonData = ($clockworkdata) ? json_encode($clockworkdata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'clockwork_integration'],
            ['status' => ($request->get('clockwork_number') && $request->get('clockwork_api_token')) ? 1 : 0, 'field_json' => json_encode($clockworkFiledtext), 'json' => $clockworkJsonData]
        );
        return redirect()->back()->with('success', __('Integraci�n de formulario exitosa.'));
    }

    public function formTheme($id)
    {
        $form = Form::find($id);
        return view('form.themes.theme', compact('form'));
    }

    public function formThemeEdit(Request $request, $slug, $id)
    {
        $form = Form::find($id);
        return view('form.themes.index', compact('slug', 'form'));
    }

    public function themeChange(Request $request, $id)
    {
        $form = Form::find($id);
        $form->theme = $request->theme;
        $form->save();
        return redirect()->route('forms.index')->with('success', __('Plantilla exitosamente cambiada.'));
    }

    public function formThemeUpdate(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'background_image' => 'image|mimes:png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors();
            return response()->json(['errors' => $messages->first()]);
        }
        $form = Form::find($id);
        $form->theme = $request->theme;
        $form->theme_color = $request->color;
        if ($request->hasFile('background_image')) {
            $themeBackgroundImage = 'form-background.' . $request->background_image->getClientOriginalExtension();
            $themeBackgroundImagePath = 'form-themes/theme3/' . $form->id;
            $backgroundImage = $request->file('background_image')->storeAs(
                $themeBackgroundImagePath,
                $themeBackgroundImage
            );
            $form->theme_background_image = $backgroundImage;
        }
        $form->save();
        return redirect()->route('forms.index')->with('success', __('Plantilla de formulario elegida exitosamente.'));
    }

    public function formRules(Request $request,  $id)
    {
       // if (\Auth::guard('api')->user()->can('manage-form-rule')) {
            $formRules      = form::find($id);
            $jsonData       = json_decode($formRules->json);
            $rules          = formRule::where('form_id', $id)->get();
            return view('form.conditional-rules.rules', compact('formRules', 'jsonData', 'rules'));
        //} else {
            //return redirect()->back()->with('errors', __('Permiso denegado'));
        //}
    }

    public function storeRule(Request $request)
    {
        if (\Auth::guard('api')->user()->can('create-form-rule')) {

            request()->validate([
                'rule_name'                 => 'required|max:50',
                'condition_type'            => 'nullable',
                'rules.*.if_field_name'     => 'required',
                'rules.*.if_rule_type'      => 'required',
                'rules.*.if_rule_value'     => 'required',
                'rules2.*.else_rule_type'   => 'required',
                'rules2.*.else_field_name'  => 'required',
            ]);

            $conditioal = Form::find($request->form_id);
            $conditioal->conditional_rule = ($request->conditional_rule	 == '1' ? '1'  : '0');
            $conditioal->save();

            $ifJson     = json_encode($request->rules);
            $thenJson   = json_encode($request->rules2);

            $formRule              = new formRule();
            $formRule->form_id     = $request->form_id;
            $formRule->rule_name   = $request->rule_name;
            $formRule->if_json     = $ifJson;
            $formRule->then_json   = $thenJson;
            $formRule->condition   = ($request->condition_type) ?  $request->condition_type : 'or';
            $formRule->save();

            return redirect()->route('form.rules', $request->form_id)->with('success', __('Rule set successfully'));
        } else {
            return redirect()->back()->with('errors', __('Permiso denegado'));
        }
    }

    public function editRule($id)
    {
        if (\Auth::guard('api')->user()->can('edit-form-rule')) {
            $rule           = formRule::where('id', $id)->first();
            $form           = form::find($rule->form_id);

            $jsonDataIf     = json_decode($rule->if_json);
            $jsonDataThen   = json_decode($rule->then_json);
            $jsonData       = json_decode($form->json);

            return view('form.conditional-rules.edit', compact('form', 'rule', 'jsonDataIf', 'jsonDataThen', 'jsonData'));
        } else {
            return redirect()->back()->with('errors', __('Permiso denegado'));
        }
    }

    public function ruleUpdate($id, Request $request)
    {
        if (\Auth::guard('api')->user()->can('edit-form-rule')) {
            request()->validate([
                'rule_name'                 => 'required|max:50',
                'condition_type'            => 'nullable',
                'rules.*.if_field_name'     => 'required',
                'rules.*.if_rule_type'      => 'required',
                'rules.*.if_rule_value'     => 'required',
                'rules2.*.else_rule_type'   => 'required',
                'rules2.*.else_field_name'  => 'required',
            ]);

            $conditioal = Form::find($request->form_id);
            $conditioal->conditional_rule = ($request->conditional_rule	 == 'on' ? '1'  : '0');
            $conditioal->save();

            $newRules       = $request->rules;
            $existingRules  = formRule::find($id)->if_json;
            $existingRules  = json_decode($existingRules, true);

            $countNewRules = count($newRules);
            $countExistingRules = count($existingRules);

            $lastPosition   = count($newRules) - 1;
            $lastRule       = $newRules[$lastPosition];

            if ($countExistingRules < $countNewRules) {
                foreach ($newRules as $newRule) {
                    $newFieldName = $lastRule['if_field_name'];
                    foreach ($existingRules as $existingRule) {
                        $existingFieldName = $existingRule['if_field_name'];

                        if ($newFieldName === $existingFieldName) {
                            return redirect()->back()->with('errors', 'Esta nombre de regla ya existe.');
                        }

                    }
                }
            }

            $ifJson = json_encode($request->rules);
            $thenJson = json_encode($request->rules2);

            $ruleUpdate                 = formRule::find($id);
            $ruleUpdate->rule_name      = $request->rule_name;
            $ruleUpdate->if_json        = $ifJson;
            $ruleUpdate->then_json      = $thenJson;
            $ruleUpdate->condition      = ($request->condition_type) ?  $request->condition_type : 'or';
            $ruleUpdate->save();

            return redirect()->route('form.rules', $request->form_id)->with('success', __('Regla gestionada exitosamente'));
        } else {
            return redirect()->back()->with('errors', __('Permiso denegado'));
        }
    }

    public function ruleDelete($id)
    {
        if (\Auth::guard('api')->user()->can('delete-form-rule')) {
            $ruleDelete  = formRule::find($id);
            $ruleDelete->delete();

            return back()->with('success', __('Regla eliminada exitosamente'));
        } else {
            return redirect()->back()->with('errors', __('Permiso denegado'));
        }
    }

    public function getField(Request $request)
    {
        $form = Form::find($request->id);
        $formData = json_decode($form->json, true);
        $fieldName = $request->input('fieldname');

        $matchingField = null;
        foreach ($formData as $section) {
            foreach ($section as $field) {
                if (isset($field['name']) && $field['name'] === $fieldName) {
                    $matchingField = $field;
                    break 2;
                }
            }
        }

        return response(['matchingField' => $matchingField]);
    }
    
    
}