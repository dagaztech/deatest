<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingValueController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CommentsReplyController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormValueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailTempleteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\FormCommentsController;
use App\Http\Controllers\FormCommentsReplyController;
use App\Http\Controllers\DashboardWidgetController;
use App\Http\Controllers\DocumentGenratorController;
use App\Http\Controllers\DocumentMenuController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FormTemplateController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginSecurityController;
use App\Http\Controllers\PaymentGateway\MercadoController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentGateway\MollieController;
use App\Http\Controllers\NotificationsSettingController;
use App\Http\Controllers\PaymentGateway\PaytmController;
use App\Http\Controllers\PaymentGateway\PayUMoneyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\PageSettingController;
use App\Http\Controllers\PaymentGateway\CoingateController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\GraficasController;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require_once __DIR__ . '/auth.php';
Route::group(['middleware' =>  ['auth', 'Upload', 'verified', 'xss', 'verified_phone']], function () {
});

Route::group(['middleware' =>  ['auth', 'Upload', 'verified', 'xss', 'verified_phone']], function () {
    Route::resource('mailtemplate', MailTempleteController::class);
});

Route::group(['middleware' =>  ['authall:api']], function () {

//EXCLUSIVO PARA TESTING 
    //Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@do']);
    //Route::get('/offline', function () { return view('vendor/laravelpwa/offline'); });

    Route::get('forms/add', [FormController::class, 'addForm'])->name('forms.add');

    Route::resource('mailtemplate', MailTempleteController::class);

    
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('user/status/{id}', [UserController::class, 'userStatus'])->name('users.status');
    Route::get('users/grid/{id?}', [UserController::class, 'gridView'])->name('grid.view');
   Route::get('users/index', [UserController::class, 'index'])->name('user.index');

    Route::resource('profile', ProfileController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::post('role-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.permit');
    Route::resource('faqs', FaqController::class);
    Route::resource('module', ModuleController::class);
    Route::resource('poll', PollController::class);
    Route::resource('form-values', FormValueController::class);
    Route::resource('forms', FormController::class);
    Route::resource('forms', FormController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('blog-category', BlogCategoryController::class);
    Route::post('blogcategory-status/{id}', [BlogCategoryController::class, 'blogCategoryStatus'])->name('blogcategory.status');


    Route::get('forms/{id}/llenardepartamentos', [FormController::class, 'llenardepartamentos'])->name('forms.llenardepartamentos');
    Route::get('forms/{id}/sincronizarlistadeas', [FormController::class, 'sincronizarlistadeas'])->name('forms.sincronizarlistadeas');

    Route::get('forms/{id}/sincronizarlistarepresentantes', [FormController::class, 'sincronizarlistarepresentantes'])->name('forms.sincronizarlistarepresentantes');


    Route::get('forms/municipios/{id}', [FormController::class, 'municipios'])->name('municipios');

    Route::get('/user-operativo', [PagesController::class, 'indexoperativo'])->name('user-operativo.index');

    Route::get('forms/{id}/fill', [FormController::class, 'fill'])->name('forms.fill');
    Route::get('forms/survey/{id}', [FormController::class, 'publicFill'])->name('forms.survey');
    Route::get('forms/qr/{id}', [FormController::class, 'qrCode'])->name('forms.survey.qr');
    Route::put('forms/fill/{id}', [FormController::class, 'fillStore'])->name('forms.fill.store');
    Route::get('form-values/{id}/edit', [FormValueController::class, 'edit'])->name('edit.form.values');
    Route::get('form-values/{id}/view', [FormValueController::class, 'showSubmitedForms'])->name('view.form.values'); 
    Route::get('form-values/{id}/download', [FormValueController::class, 'download'])->name('view.form.download'); 
    Route::post('form-duplicate', [FormController::class, 'duplicate'])->name('forms.duplicate');
    Route::post('ckeditors/upload', [FormController::class, 'ckupload'])->name('ckeditors.upload');
    Route::post('dropzone/upload/{id}', [FormController::class, 'dropzone'])->name('dropzone.upload');
    Route::post('ckeditor/upload', [FormController::class, 'upload'])->name('ckeditor.upload');
    Route::get('design/{id}', [FormController::class, 'design'])->name('forms.design');
    Route::put('forms/{id}/design', [FormController::class, 'designUpdate'])->name('forms.design.update');
    Route::post('form-values/excel', [FormValueController::class, 'exportXlsx'])->name('download.form.values.excel');

    Route::post('update-avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
    Route::post('update-login-details', [ProfileController::class, 'LoginDetails'])->name('update.login.details');
    Route::get('profile-status', [ProfileController::class, 'profileStatus'])->name('profile.status');
    Route::any('profile/basicinfo/update/', [ProfileController::class, 'BasicInfoUpdate'])->name('profile.update.basicinfo');

    Route::get('/user-operativo', [PagesController::class, 'indexoperativo'])->name('user-operativo.index');
    Route::get('/user-administrador/creacion-usuario', [PagesController::class, 'creacionusuario'])->name('user-administrador.creacion-usuario');
    Route::get('/user-administrador/detalle-instalacion', [PagesController::class, 'detalleinstalacion'])->name('user-administrador.detalle-instalacion');
    Route::get('/user-administrador/detalle-usuarios', [PagesController::class, 'detalleusuarios'])->name('user-administrador.detalle-usuarios');
    Route::get('/user-administrador/formulario-campo-dea', [PagesController::class, 'formulariocampodea'])->name('user-administrador.formulario-campo-dea');
    Route::get('/user-administrador/formulario-campo-persona', [PagesController::class, 'formulariocampopersona'])->name('user-administrador.formulario-campo-persona');
    Route::get('/user-administrador/formulario-campo-uso', [PagesController::class, 'formulariocampouso'])->name('user-administrador.formulario-campo-uso');
    Route::get('/user-administrador/gestion-informacion', [PagesController::class, 'gestioninformacion'])->name('user-administrador.gestion-informacion');
    Route::get('/user-administrador/informacion-espacios', [PagesController::class, 'informacionespacios'])->name('user-administrador.informacion-espacios');
    Route::get('/user-administrador/informacion-instalacion', [PagesController::class, 'informacioninstalacion'])->name('user-administrador.informacion-instalacion');
    Route::get('/user-administrador/informacion-usuarios', [PagesController::class, 'informacionusuarios'])->name('user-administrador.informacion-usuarios');
    Route::get('/user-administrador/informacion-reporteuso', [PagesController::class, 'informacionreporteuso'])->name('user-administrador.informacion-reporteuso');
    Route::get('/user-administrador/registro-espacios', [PagesController::class, 'registroespacios'])->name('user-administrador.registro-espacios');
    Route::get('/user-administrador/registro-usuarios', [PagesController::class, 'registrousuarios'])->name('user-administrador.registro-usuarios');
    Route::get('/user-administrador/tableros-useradmin', [PagesController::class, 'tablerosuseradmin'])->name('user-administrador.tableros-useradmin');
    Route::post('/user-administrador/tableros-useradmin', [PagesController::class, 'tablerosuseradmin'])->name('user-administrador.tableros-useradmin');
    
    Route::get('/user-administrador/reportes-useradmin', [PagesController::class, 'reportesuseradmin'])->name('user-administrador.reportes-useradmin');
    Route::get('/user-administrador/graficasbi', [FormValueController::class, 'generateCharts'])->name('user-administrador.graficasbi');


});


Route::group(['middleware' =>  ['authOperador1:api']], function () {

    Route::get('/user-operador1', [PagesController::class, 'index2'])->name('user-operador1.index');
    Route::get('/user-operador1/formulario-anexo2', [PagesController::class, 'formularioanexo2'])->name('user-operador1.formulario-anexo2');
    Route::get('/user-operador1/formulario-anexo25', [PagesController::class, 'formularioanexo25'])->name('user-operador1.formulario-anexo25');
    Route::get('/user-operador1/formulario-anexo3', [PagesController::class, 'formularioanexo3'])->name('user-operador1.formulario-anexo3');
    Route::get('/user-operador1/formulario-eventoencurso', [PagesController::class, 'formularioeventoencurso'])->name('user-operador1.formulario-eventoencurso');
    Route::get('/user-operador1/menu-anexo3', [PagesController::class, 'menuanexo3'])->name('user-operador1.menu-anexo3');
    Route::get('/user-operador1/opciones-formulario', [PagesController::class, 'opcionesformulario'])->name('user-operador1.opciones-formulario');
    Route::get('/user-operador1/formulario-infoevento', [PagesController::class, 'formularioinfoevento'])->name('user-operador1.formulario-infoevento');
});
 
Route::group(['middleware' =>  ['authOperador2:api']], function () {
    Route::get('/user-operador2', [PagesController::class, 'indexoperador2'])->name('user-operador2.index');
});

Route::group(['middleware' =>  ['authConsultaE:api']], function () {
    Route::get('/user-consultaentidad', [PagesController::class, 'indexconsultaentidad'])->name('user-consultaentidad.index');
});
 
Route::group(['middleware' =>  ['authConsultaSSM:api']], function () {
    Route::get('/user-consultassm', [PagesController::class, 'indexconsultassm'])->name('user-consultassm.index');
    Route::get('/user-consultassm/agendamiento-planesrepo', [PagesController::class, 'agendamientoplanesrepo'])->name('user-consultassm.agendamiento-planesrepo');
    Route::get('/user-consultassm/consssm-agendamiento', [PagesController::class, 'consssmagendamiento'])->name('user-consultassm.consssm-agendamiento');
    Route::get('/user-consultassm/consssm-planeacion', [PagesController::class, 'consssmplaneacion'])->name('user-consultassm.consssm-planeacion');
    Route::get('/user-consultassm/consssm-seguimiento', [PagesController::class, 'consssmseguimiento'])->name('user-consultassm.consssm-seguimiento');
    Route::get('/user-consultassm/consultauso-dea', [PagesController::class, 'consultausodea'])->name('user-consultassm.consultauso-dea');
    Route::get('/user-consultassm/informe-ubicaciondeas', [PagesController::class, 'informeubicaciondeas'])->name('user-consultassm.informe-ubicaciondeas');
    Route::get('/user-consultassm/regequipos-dea', [PagesController::class, 'regequiposdea'])->name('user-consultassm.regequipos-dea');
    Route::get('/user-consultassm/eventos-criticosactivos', [PagesController::class, 'eventoscriticosactivos'])->name('user-consultassm.eventos-criticosactivos');
});

Route::group(['middleware' =>  ['authOperativoSSM:api']], function () {
    Route::get('/user-operativo', [PagesController::class, 'indexoperativo'])->name('user-operativo.index');
    Route::get('/user-operativo/historico-usuarios', [HistoricoController::class, 'indexhistorico'])->name('user-operativo.historico-usuarios');
    Route::post('/user-operativo/historico-usuarios', [HistoricoController::class, 'indexhistorico'])->name('historicousuarios');
    Route::get('design/{id}', [FormController::class, 'design'])->name('forms.design');
    Route::put('forms/{id}/design', [FormController::class, 'designUpdate'])->name('forms.design.update');
});


Route::group(['middleware' =>  ['authadmin:api']], function () {
    
    Route::resource('users', UserController::class);
    //Route::get('formas', [FormController::class, 'addForm'])->name('formas');
    Route::get('/user-administrador', [PagesController::class, 'index'])->name('user-administrador.index');
    Route::get('/user-administrador/creacion-usuario', [PagesController::class, 'creacionusuario'])->name('user-administrador.creacion-usuario');
    Route::get('/user-administrador/detalle-instalacion', [PagesController::class, 'detalleinstalacion'])->name('user-administrador.detalle-instalacion');
    Route::get('/user-administrador/detalle-usuarios', [PagesController::class, 'detalleusuarios'])->name('user-administrador.detalle-usuarios');
    Route::get('/user-administrador/formulario-campo-dea', [PagesController::class, 'formulariocampodea'])->name('user-administrador.formulario-campo-dea');
    Route::get('/user-administrador/formulario-campo-persona', [PagesController::class, 'formulariocampopersona'])->name('user-administrador.formulario-campo-persona');
    Route::get('/user-administrador/formulario-campo-uso', [PagesController::class, 'formulariocampouso'])->name('user-administrador.formulario-campo-uso');
    //Route::get('/user-administrador/gestion-informacion', [PagesController::class, 'gestioninformacion'])->name('user-administrador.gestion-informacion');
    Route::get('/user-administrador/informacion-espacios', [PagesController::class, 'informacionespacios'])->name('user-administrador.informacion-espacios');
    Route::get('/user-administrador/informacion-instalacion', [PagesController::class, 'informacioninstalacion'])->name('user-administrador.informacion-instalacion');
    Route::get('/user-administrador/informacion-usuarios', [PagesController::class, 'informacionusuarios'])->name('user-administrador.informacion-usuarios');
    Route::get('/user-administrador/informacion-reporteuso', [PagesController::class, 'informacionreporteuso'])->name('user-administrador.informacion-reporteuso');
    Route::get('/user-administrador/registro-espacios', [PagesController::class, 'registroespacios'])->name('user-administrador.registro-espacios');
    Route::get('/user-administrador/tableros-useradmin', [PagesController::class, 'tablerosuseradmin'])->name('user-administrador.tableros-useradmin');
    Route::get('/user-administrador/reportes-useradmin', [PagesController::class, 'reportesuseradmin'])->name('user-administrador.reportes-useradmin');

//Para carga masiva
    Route::get('/user-administrador/carga-masiva', [PagesController::class,'cargamasiva'])->name('user-administrador.carga-masiva');
    Route::post('/user-administrador/carga-masiva', [PagesController::class,'cargamasivaExcel'])->name('user-administrador.carga-masiva2');


 
    //Route::get('home', [HomeController::class, 'index'])->name('home');
});






//Route::get('home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['authadmin:api']], function () {
    //Route::get('home', [HomeController::class, 'index'])->name('home');
   

    Route::get('forms/use/template/{id}', [FormController::class, 'useFormtemplate'])->name('forms.use.template');

    //Booking
    Route::resource('bookings', BookingController::class);;
    Route::get('bookings/design/{id}', [BookingController::class, 'design'])->name('booking.design');
    Route::put('bookings/design/update/{id}', [BookingController::class, 'designUpdate'])->name('booking.design.update');
    Route::get('bookings/slots/setting/{id}', [BookingController::class, 'slotsSetting'])->name('booking.slots.setting');
    Route::post('bookings/slots/setting/update/{id}', [BookingController::class, 'slotsSettingupdate'])->name('booking.slots.setting.update');
    Route::get('bookings/slots/time/appoinment/{id}', [BookingController::class, 'appoinmentTime'])->name('booking.appoinment.time');
    Route::get('bookings/slots/seat/appoinment/{id}', [BookingController::class, 'appoinmentSeat'])->name('booking.appoinment.seat');
    Route::get('bookings/payment/integration/{id}', [BookingController::class, 'bookingpaymentIntegration'])->name('booking.payment.integration');
    Route::post('bookings/payment/integration/store/{id}', [BookingController::class, 'bookingpaymentIntegrationstore'])->name('booking.payment.integration.store');


    Route::get('calendar/bookings', [BookingController::class, 'bookingCalendar'])->name('booking.calendar');


    //booking value
    Route::get('booking-values/{id}/view', [BookingValueController::class, 'showBookingsForms'])->name('view.booking.values');
    Route::get('booking-values/time/{id}/view', [BookingValueController::class, 'timingBookingvaluesShow'])->name('timing.bookingvalues.show');
    Route::get('booking-values/seats/{id}/view', [BookingValueController::class, 'seatsBookingvaluesShow'])->name('seats.bookingvalues.show');
    Route::get('booking-values/{id}/time-booking/edit', [BookingValueController::class, 'timeBookingEdit'])->name('booking.time-bookings.edit');
    Route::get('booking-values/{id}/seats-booking/edit', [BookingValueController::class, 'seatsBookingEdit'])->name('booking.seats-bookings.edit');
    Route::delete('booking-values/{id}/delete', [BookingValueController::class, 'destroy'])->name('bookingvalues.destroy');


    // Form
    Route::group(['prefix' => 'forms'], function () {

        Route::get('themes/{id}', [FormController::class, 'formTheme'])->name('form.theme');
        Route::get('themes/edit/{theme}/{id}', [FormController::class, 'formThemeEdit'])->name('form.theme.edit');
        Route::post('themes/update/{id}', [FormController::class, 'formThemeUpdate'])->name('form.theme.update');
        Route::get('integration/{id}', [FormController::class, 'formIntegration'])->name('form.integration');
        Route::get('payment/integration/{id}', [FormController::class, 'formpaymentIntegration'])->name('form.payment.integration');
        Route::post('payment/integration/store/{id}', [FormController::class, 'formpaymentIntegrationstore'])->name('form.payment.integration.store');
        Route::post('integration/{id}', [FormController::class, 'formIntegrationStore'])->name('form.integration.store');
        Route::post('themes/change/{id}', [FormController::class, 'themeChange'])->name('form.theme.change');

        Route::get('slack/integration/{id}', [FormController::class, 'slackIntegration'])->name('slack.integration');
        Route::get('telegram/integration/{id}', [FormController::class, 'telegramIntegration'])->name('telegram.integration');
        Route::get('mailgun/integration/{id}', [FormController::class, 'mailgunIntegration'])->name('mailgun.integration');
        Route::get('bulkgate/integration/{id}', [FormController::class, 'bulkgateIntegration'])->name('bulkgate.integration');
        Route::get('nexmo/integration/{id}', [FormController::class, 'nexmoIntegration'])->name('nexmo.integration');
        Route::get('fast2sms/integration/{id}', [FormController::class, 'fast2smsIntegration'])->name('fast2sms.integration');
        Route::get('vonage/integration/{id}', [FormController::class, 'vonageIntegration'])->name('vonage.integration');
        Route::get('sendgrid/integration/{id}', [FormController::class, 'sendgridIntegration'])->name('sendgrid.integration');
        Route::get('twilio/integration/{id}', [FormController::class, 'twilioIntegration'])->name('twilio.integration');
        Route::get('textlocal/integration/{id}', [FormController::class, 'textlocalIntegration'])->name('textlocal.integration');
        Route::get('messente/integration/{id}', [FormController::class, 'messenteIntegration'])->name('messente.integration');
        Route::get('smsgateway/integration/{id}', [FormController::class, 'smsgatewayIntegration'])->name('smsgateway.integration');
        Route::get('clicktell/integration/{id}', [FormController::class, 'clicktellIntegration'])->name('clicktell.integration');
        Route::get('clockwork/integration/{id}', [FormController::class, 'clockworkIntegration'])->name('clockwork.integration');

        Route::get('rules/{id}', [FormController::class, 'formRules'])->name('form.rules');
        Route::post('rule/store', [FormController::class, 'storeRule'])->name('rule.store');
        Route::get('rule/{id}/edit', [FormController::class, 'editRule'])->name('rule.edit');
        Route::patch('rule/{id}/update', [FormController::class, 'ruleUpdate'])->name('rule.update');
        Route::delete('rule/{id}/delete', [FormController::class, 'ruleDelete'])->name('rule.delete');
        Route::get('get/rules', [FormController::class, 'getField'])->name('get.field');

        Route::get('grid/{id?}', [FormController::class, 'gridView'])->name('grid.form.view');
        Route::post('status/{id}', [FormController::class, 'formStatus'])->name('form.status');
    });


    //Form Template
    Route::resource('form-template', FormTemplateController::class);
    Route::post('form-template/status/{id}', [FormTemplateController::class, 'status'])->name('formTemplate.status');
    Route::get('form-template/design/{id}', [FormTemplateController::class, 'design'])->name('formTemplate.design');
    Route::put('form-template/design/update/{id}', [FormTemplateController::class, 'designUpdate'])->name('form.template.design.update');

    // Dashboard-Widget
    Route::get('index-dashboard', [HomeController::class, 'indexDashboard'])->name('index.dashboard');
    Route::get('create-dashboard', [HomeController::class, 'createDashboard'])->name('create.dashboard');
    Route::post('store-dashboard', [HomeController::class, 'storeDashboard'])->name('store.dashboard');
    Route::get('edit-dashboard/{id}/edit', [HomeController::class, 'editDashboard'])->name('edit.dashboard');
    Route::put('update-dashboard/{id}', [HomeController::class, 'updateDashboard'])->name('update.dashboard');
    Route::delete('delete-dashboard/{id}', [HomeController::class, 'deleteDashboard'])->name('delete.dashboard');
    Route::post('update-position/dashboard', [HomeController::class, 'updatePosition'])->name('updatedash.dashboard');
    Route::post('widget/chnages', [HomeController::class, 'WidgetChnages'])->name('widget.chnages');
    Route::post('widget/chartdata', [DashboardWidgetController::class, 'WidgetChartData'])->name('widget.chartdata');

    // Profile
  


    // language
    Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language');
    Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language');
    Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data');
    Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language');
    Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language');
    Route::delete('lang/{lang}', [LanguageController::class, 'destroyLang'])->name('lang.destroy');

    Route::post('change/theme/mode', [HomeController::class, 'changeThememode'])->name('change.theme.mode');
    Route::post('read/notification', [HomeController::class, 'readNotification'])->name('read.notification');

    // user status & grid
    Route::post('user/status/{id}', [UserController::class, 'userStatus'])->name('users.status');
    Route::get('users/grid/{id?}', [UserController::class, 'gridView'])->name('grid.view');
   Route::get('users/index', [UserController::class, 'index'])->name('user.index');

    //profile update
    Route::get('users/verified/{id}', [UserController::class, 'userEmailVerified'])->name('user.verified');
    Route::get('users/phoneverified/{id}', [UserController::class, 'userPhoneVerified'])->name('user.phoneverified');


    //document
    Route::resource('document', DocumentGenratorController::class);
    Route::get('document/design/{id}', [DocumentGenratorController::class, 'design'])->name('document.design');

    //status drag-drop
    Route::post('document/designmenu', [DocumentGenratorController::class, 'updateDesign'])->name('updatedesign.document');
    Route::get('document-status/{id}', [DocumentGenratorController::class, 'documentStatus'])->name('document.status');

    // menu
    Route::get('docmenu/index', [DocumentMenuController::class, 'index'])->name('docmenu.index');
    Route::get('docmenu/create/{docmenu_id}', [DocumentMenuController::class, 'create'])->name('docmenu.create');
    Route::post('docmenu/store', [DocumentMenuController::class, 'store'])->name('docmenu.store');
    Route::delete('document/menu/{id}', [DocumentMenuController::class, 'destroy'])->name('document.design.delete');

    // submenu
    Route::get('docsubmenu/create/{id}/{docmenu_id}', [DocumentMenuController::class, 'submenuCreate'])->name('docsubmenu.create');
    Route::post('docsubmenu/store', [DocumentMenuController::class, 'submenuStore'])->name('docsubmenu.store');
    Route::delete('document/submenu/{id}', [DocumentMenuController::class, 'submenuDestroy'])->name('document.submenu.design.delete');
    Route::post('settings/sms-setting/update', [SettingsController::class, 'smsSettingUpdate'])->name('settings.sms-setting.update');

    // Event
    Route::resource('event', EventController::class);
    Route::post('event/getdata', [EventController::class, 'getEventData'])->name('event.get.data');

    // Testimonial
    Route::resource('testimonial', TestimonialController::class);
    Route::post('testimonials/status/{id}', [TestimonialController::class, 'status'])->name('testimonial.status');

    //sms-templates
    Route::resource('sms-template', SmsTemplateController::class);

    // backend- side settings
    Route::post('settings/email-setting/update', [SettingsController::class, 'emailSettingUpdate'])->name('settings.email-setting.update');
    Route::post('settings/auth-settings/update', [SettingsController::class, 'authSettingsUpdate'])->name('settings.auth-settings.update');
    Route::post('test-mail', [SettingsController::class, 'testSendMail'])->name('test.send.mail');
    Route::post('settings/app-name/update', [SettingsController::class, 'appNameUpdate'])->name('settings.app-name.update');
    Route::post('settings/google-calender/update', [SettingsController::class, 'googleCalender'])->name('settings.google-calender.update');
    Route::post('settings/google-map/update', [SettingsController::class, 'googleMapUpdate'])->name('settings.googlemap.update');
    Route::post('settings/pusher-setting/update', [SettingsController::class, 'pusherSettingUpdate'])->name('settings.pusher-setting.update');
    Route::post('settings/wasabi-setting/update', [SettingsController::class, 'wasabiSettingUpdate'])->name('settings.wasabi-setting.update');
    Route::post('settings/captcha-setting/update', [SettingsController::class, 'captchaSettingUpdate'])->name('settings.captcha-setting.update');
    Route::post('settings/cookie-setting/update', [SettingsController::class, 'cookieSettingUpdate'])->name('settings.cookie-setting.update');
    Route::post('settings/seo-setting/update', [SettingsController::class, 'seoSettingUpdate'])->name('settings.seo-setting.update');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('test-mail', [SettingsController::class, 'testMail'])->name('test.mail');
    Route::post('notification/status/{id}', [NotificationsSettingController::class, 'changestatus'])->name('notification.status.change');



    //froentend
    Route::group(['prefix' => 'landingpage-setting'], function () {

        Route::get('/', [LandingPageController::class, 'landingPageSetting'])->name('landing-page.setting');
        Route::post('app-setting/store', [LandingPageController::class, 'appSettingStore'])->name('landing.app.store');

        Route::get('menu-setting', [LandingPageController::class, 'menuSetting'])->name('menusetting.index');
        Route::post('menu-setting-section1/store', [LandingPageController::class, 'MenuSettingSection1Store'])->name('landing.menusection1.store');
        Route::post('menu-setting-section2/store', [LandingPageController::class, 'MenuSettingSection2Store'])->name('landing.menusection2.store');
        Route::post('menu-setting-section3/store', [LandingPageController::class, 'MenuSettingSection3Store'])->name('landing.menusection3.store');

        Route::get('feature-setting', [LandingPageController::class, 'FeatureSetting'])->name('landing.feature.index');
        Route::post('feature-setting/store', [LandingPageController::class, 'featureSettingStore'])->name('landing.feature.store');
        Route::get('feature/create', [LandingPageController::class, 'featureCreate'])->name('feature.create');
        Route::post('feature/store', [LandingPageController::class, 'featureStore'])->name('feature.store');
        Route::get('feature/{key}/edit', [LandingPageController::class, 'featureEdit'])->name('feature.edit');
        Route::post('feature/{key}/update', [LandingPageController::class, 'featureUpdate'])->name('feature.update');
        Route::delete('feature/{key}/delete', [LandingPageController::class, 'featureDelete'])->name('feature.delete');

        Route::get('business-growth-setting', [LandingPageController::class, 'businessGrowthSetting'])->name('landing.business.growth.index');
        Route::post('business-growth-setting/store', [LandingPageController::class, 'businessGrowthSettingStore'])->name('landing.business.growth.store');
        Route::get('business-growth/create', [LandingPageController::class, 'businessGrowthCreate'])->name('business.growth.create');
        Route::post('business-growth/store', [LandingPageController::class, 'businessGrowthStore'])->name('business.growth.store');
        Route::get('business-growth/{key}/edit', [LandingPageController::class, 'businessGrowthEdit'])->name('business.growth.edit');
        Route::post('business-growth/{key}/update', [LandingPageController::class, 'businessGrowthUpdate'])->name('business.growth.update');
        Route::delete('business-growth/{key}/delete', [LandingPageController::class, 'businessGrowthDelete'])->name('business.growth.delete');

        Route::get('business-growth-view/create', [LandingPageController::class, 'businessGrowthViewCreate'])->name('business.growth.view.create');
        Route::post('business-growth-view/store', [LandingPageController::class, 'businessGrowthViewStore'])->name('business.growth.view.store');
        Route::get('business-growth-view/{key}/edit', [LandingPageController::class, 'businessGrowthViewEdit'])->name('business.growth.view.edit');
        Route::post('business-growth-view/{key}/update', [LandingPageController::class, 'businessGrowthViewUpdate'])->name('business.growth.view.update');
        Route::delete('business-growth-view/{key}/delete', [LandingPageController::class, 'businessGrowthViewDelete'])->name('business.growth.view.delete');

        Route::get('start-view-setting', [LandingPageController::class, 'startViewSetting'])->name('landing.start.view.index');
        Route::post('start-view-setting/store', [LandingPageController::class, 'startViewSettingStore'])->name('landing.start.view.store');

        Route::get('faq-setting', [LandingPageController::class, 'faqSetting'])->name('landing.faq.index');
        Route::post('faq-setting/store', [LandingPageController::class, 'faqSettingStore'])->name('landing.faq.store');

        Route::get('contactus-setting', [LandingPageController::class, 'contactusSetting'])->name('landing.contactus.index');
        Route::post('contactus-setting/store', [LandingPageController::class, 'contactusSettingStore'])->name('landing.contactus.store');

        Route::get('form-setting', [LandingPageController::class, 'formSetting'])->name('landing.form.index');
        Route::post('form-setting/store', [LandingPageController::class, 'formSettingStore'])->name('landing.form.store');

        Route::get('blog-setting', [LandingPageController::class, 'blogSetting'])->name('landing.blog.index');
        Route::post('blog-setting/store', [LandingPageController::class, 'blogSettingStore'])->name('landing.blog.store');

        Route::get('footer-setting', [LandingPageController::class, 'footerSetting'])->name('landing.footer.index');
        Route::post('footer-setting/store', [LandingPageController::class, 'footerSettingStore'])->name('landing.footer.store');

        Route::get('login-setting', [LandingPageController::class, 'loginSetting'])->name('landing.login.index');
        Route::post('login-setting/store', [LandingPageController::class, 'loginSettingStore'])->name('landing.login.store');

        Route::get('captcha-setting', [LandingPageController::class, 'captchaSetting'])->name('landing.captcha.index');
        Route::post('captcha/store', [LandingPageController::class, 'captchaSettingStore'])->name('landing.captcha.store');

        Route::get('announcements-setting', [LandingPageController::class, 'announcementsSetting'])->name('landing.announcements.index');
        Route::post('announcements-setting/store', [LandingPageController::class, 'announcementsSettingStore'])->name('landing.announcements.store');

        // Header Setting
        Route::get('header-setting', [LandingPageController::class, 'headerSetting'])->name('landing.header.index');
        Route::get('header/menu/create', [LandingPageController::class, 'headerMenuCreate'])->name('header.menu.create');
        Route::post('header/menu/store', [LandingPageController::class, 'headerMenuStore'])->name('header.menu.store');
        Route::get('header/menu/{id}/edit', [LandingPageController::class, 'headerMenuEdit'])->name('header.menu.edit');
        Route::post('header/menu/{id}/update', [LandingPageController::class, 'headerMenuUpdate'])->name('header.menu.update');
        Route::delete('header/menu/{id}/delete', [LandingPageController::class, 'headerMenuDelete'])->name('header.menu.delete');

        //Footer settings
        //Main Menu
        Route::get('main/menu/create', [LandingPageController::class, 'footerMainMenuCreate'])->name('footer.main.menu.create');
        Route::post('main/menu/store', [LandingPageController::class, 'footerMainMenuStore'])->name('footer.main.menu.store');
        Route::get('main/menu/{id}/edit', [LandingPageController::class, 'footerMainMenuEdit'])->name('footer.main.menu.edit');
        Route::post('main/menu/{id}/update', [LandingPageController::class, 'footerMainMenuUpdate'])->name('footer.main.menu.update');
        Route::delete('main/menu/{id}/delete', [LandingPageController::class, 'footerMainMenuDelete'])->name('footer.main.menu.delete');

        // Sub menu
        Route::get('sub/menu/create', [LandingPageController::class, 'footerSubMenuCreate'])->name('footer.sub.menu.create');
        Route::post('sub/menu/store', [LandingPageController::class, 'footerSubMenuStore'])->name('footer.sub.menu.store');
        Route::get('sub/menu/{id}/edit', [LandingPageController::class, 'footerSubMenuEdit'])->name('footer.sub.menu.edit');
        Route::post('sub/menu/{id}/update', [LandingPageController::class, 'footerSubMenuUpdate'])->name('footer.sub.menu.update');
        Route::delete('sub/menu/{id}/delete', [LandingPageController::class, 'footerSubMenuDelete'])->name('footer.sub.menu.delete');

        Route::get('page-background-setting', [LandingPageController::class, 'pageBackground'])->name('landing.page.background.index');
        Route::post('page-background-setting/store', [LandingPageController::class, 'pageBackgroundstore'])->name('landing.page.background.store');
    });
});

// Announcement
Route::get('show-public/announcement/{slug}', [AnnouncementController::class, 'showPublicAnnouncement'])->name('show.public.announcement');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('announcement', AnnouncementController::class);
    Route::post('announcement-status/{id}', [AnnouncementController::class, 'announcementStatus'])->name('announcement.status');

    Route::get('show-announcement-list/', [AnnouncementController::class, 'showAnnouncementList'])->name('show.announcement.list');
    Route::get('show-announcement/{id}', [AnnouncementController::class, 'showAnnouncement'])->name('show.announcement');
});

// Page Settings
Route::resource('page-setting', PageSettingController::class)->middleware(['auth', 'Setting', 'Upload']);

Route::group(['middleware' => ['Upload']], function () {

    //  Footer page
    Route::get('pages/{slug}', [LandingPageController::class, 'pagesView'])->name('description.page');
    Route::get('contact/us', [FrontController::class, 'contactus'])->name('contactus');
    Route::get('all/faqs', [FrontController::class, 'faqs'])->name('faqs.pages');

    //Blogs pages
    Route::get('blogs/{slug}/', [BlogController::class, 'viewBlog'])->name('view.blog');
    Route::get('see/blogs/', [BlogController::class, 'seeAllBlogs'])->name('see.all.blogs');
});


// sms verify
Route::group(['middleware' => ['Setting', 'xss', 'Upload']], function () {
    Route::get('sms/notice/', [SmsController::class, 'smsNoticeIndex'])->name('smsindex.noticeverification');
    Route::post('sms/notice', [SmsController::class, 'smsNoticeVerify'])->name('sms.noticeverification');
    Route::get('sms/verify/', [SmsController::class, 'smsIndex'])->name('smsindex.verification');
    Route::post('sms/verify', [SmsController::class, 'smsVerify'])->name('sms.verification');
    Route::post('sms/verifyresend', [SmsController::class, 'smsResend'])->name('sms.verification.resend');
    Route::post('contact/mail', [FrontController::class, 'contactMail'])->name('contact.mail');
    Route::get('view/faq', [FrontController::class, 'faq'])->name('faq');
});


Route::group(['middleware' => ['authadmin:api']], function () {

    Route::post('comment/store', [CommentsController::class, 'store'])->name('comment.store');
    Route::delete('comment/{id}/destroy', [CommentsController::class, 'destroy'])->name('comment.destroy');
    Route::post('comment/reply/store', [CommentsReplyController::class, 'store'])->name('comment.reply.store');
    Route::post('form/comment/store', [CommentsController::class, 'store'])->name('form.comment.store');
    Route::delete('form/comment/{id}/destroy', [FormCommentsController::class, 'destroy'])->name('form.comment.destroy');
    Route::post('form/comment/reply/store', [FormCommentsReplyController::class, 'store'])->name('form.comment.reply.store');

    // Form Builder
    Route::get('form-values/{id}/download/pdf', [FormValueController::class, 'downloadPdf'])->name('download.form.values.pdf');
    Route::post('files/video/store', [FormValueController::class, 'VideoStore'])->name('videostore');
    Route::get('download-image/{id}', [FormValueController::class, 'SelfieDownload'])->name('selfie.image.download');

    //Booking
    Route::get('bookings/survey/time-wise/{id}', [BookingController::class, 'publicTimeFill'])->name('booking.survey.time.wise');
    Route::get('bookings/survey/seats-wise/{id}', [BookingController::class, 'publicSeatFill'])->name('booking.survey.seats.wise');
    Route::get('bookings/qr/{id}', [BookingController::class, 'qrCode'])->name('booking.survey.qr');
    Route::get('bookings/appoinment/{id}/edit', [BookingValueController::class, 'editAppoinment'])->name('appointment.edit');
    Route::delete('bookings/appoinment/{id}/slots-cancel', [BookingValueController::class, 'SlotCancel'])->name('appointment.slot.cancel');
    Route::delete('bookings/appoinment/{id}/seats-cancel', [BookingValueController::class, 'SeatCancel'])->name('appointment.seat.cancel');

    //appoinment time
    Route::post('bookings/slots/appoinment/get/{id}', [BookingController::class, 'getappoinmentSlot'])->name('booking.slots.appoinment.get');
    Route::post('bookings/seats/slot/appoinment/get/{id}', [BookingController::class, 'getappoinmentSeat'])->name('booking.seats.slot.appoinment.get');
    Route::post('bookings/seats/seat/appoinment/get/{id}', [BookingController::class, 'getappoinmentSeatSeat'])->name('booking.seats.seat.appoinment.get');
    Route::put('bookings/fill/{id}', [BookingController::class, 'fillStore'])->name('booking.fill.store');

    Route::post('mass/export/xlsx', [FormValueController::class, 'exportXlsx'])->name('mass.export.xlsx');
    Route::post('mass/export/csv', [FormValueController::class, 'export'])->name('mass.export.csv');
});

// Survey form
Route::get('user/forms/survey/{id}', [HomeController::class, 'userFormQrcode'])->name('users.all.formsSurvey');

// Poll Management
Route::group(['middleware' => ['xss', 'Upload']], function () {

    Route::get('poll/fill/{id}', [PollController::class, 'poll'])->name('poll.fill')->middleware(['auth', 'Setting']);
    Route::post('poll/store/{id}', [PollController::class, 'fillStore'])->name('fill.poll.store');
    Route::post('image/poll/store/{id}', [PollController::class, 'ImageStore'])->name('image.poll.store');
    Route::post('meeting/poll/store/{id}', [PollController::class, 'MeetingStore'])->name('meeting.poll.store');
    Route::get('poll/image/fill/{id}', [PollController::class, 'ImagePoll'])->name('image.poll.fill');
    Route::get('poll/meeting/fill/{id}', [PollController::class, 'MeetingPoll'])->name('meeting.poll.fill');
    Route::get('poll/result/{id}', [PollController::class, 'PollResult'])->name('poll.result');
    Route::get('poll/image/result/{id}', [PollController::class, 'PollImageResult'])->name('poll.image.result');
    Route::get('poll/meeting/result/{id}', [PollController::class, 'PollMeetingResult'])->name('poll.meeting.result');

    Route::get('poll/survey/{id}', [PollController::class, 'publicFill'])->name('poll.survey');
    Route::get('poll/survey/meeting/{id}', [PollController::class, 'PublicFillMeeting'])->name('poll.survey.meeting');
    Route::get('poll/survey/image/{id}', [PollController::class, 'PublicFillImage'])->name('poll.survey.image');
    Route::get('poll/share/{id}', [PollController::class, 'Share'])->name('poll.share');
    Route::get('qr/share/{id}', [PollController::class, 'ShareQr'])->name('poll.share.qr');
    Route::get('poll/share/image/{id}', [PollController::class, 'ShareImage'])->name('poll.share.image');
    Route::get('qr/share/image/{id}', [PollController::class, 'ShareQrImage'])->name('poll.share.qr.image');
    Route::get('poll/share/meeting/{id}', [PollController::class, 'ShareMeeting'])->name('poll.share.meeting');
    Route::get('qr/share/meeting/{id}', [PollController::class, 'ShareQrMeeting'])->name('poll.share.qr.meeting');
    Route::get('poll/shares/{id}', [PollController::class, 'Shares'])->name('poll.shares');
    Route::get('poll/shares/meetings/{id}', [PollController::class, 'ShareMeetings'])->name('poll.shares.meetings');
    Route::get('poll/shares/images/{id}', [PollController::class, 'ShareImages'])->name('poll.shares.images');
    Route::get('poll/public/result/{id}', [PollController::class, 'PublicFillResult'])->name('poll.public.result');
    Route::get('meeting/public/result/{id}', [PollController::class, 'PublicFillResultMeeting'])->name('poll.public.result.meeting');
    Route::get('image/public/result/{id}', [PollController::class, 'PublicFillResultImage'])->name('poll.public.result.image');

    // Cookie
    Route::any('cookie/consent', [SettingsController::class, 'CookieConsent'])->name('cookie.consent');

    // Cache
    Route::any('/config-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', __('Cache clear successfully.'));
    })->name('config.cache');
});

// mercado
Route::post('mercado/fill/prepare', [MercadoController::class, 'mercadofillPaymentPrepare'])->name('mercadofillprepare');
Route::get('mercado-fill-payment/{id}', [MercadoController::class, 'mercadofillPlanGetPayment'])->name('mercadofillcallback');

// paytm
Route::post('paytm-payment', [PaytmController::class, 'paytmPayment'])->name('paytm.payment');
Route::post('/paytm-callback', [PaytmController::class, 'paytmCallback'])->name('paytm.callback');

// coingate
Route::post('coingateprepare', [CoingateController::class, 'coingatePaymentPrepare'])->name('coingateprepare');
Route::get('coingate-payment/{id}', [CoingateController::class, 'coingatePlanGetPayment'])->name('coingatecallback');

// Form Payumoney
Route::post('payumoney/fill/prepare', [PayUMoneyController::class, 'payumoneyfillPaymentPrepare'])->name('payumoneyfillprepare');
Route::any('payumoney-fill-payment', [PayUMoneyController::class, 'payumoneyfillPlanGetPayment'])->name('payumoneyfillcallback');

// Form Mollie
Route::post('mollie/fill/prepare', [MollieController::class, 'molliefillPaymentPrepare'])->name('molliefillprepare');
Route::any('mollie-fill-payment', [MollieController::class, 'molliefillPlanGetPayment'])->name('molliefillcallback');

//stripe
Route::post('settings/stripe-setting/update', [SettingsController::class, 'paymentSettingUpdate'])->name('settings/stripe-setting/update');
Route::post('settings/social-setting/update', [SettingsController::class, 'socialSettingUpdate'])->name('settings/social-setting/update');


Route::get('redirect/{provider}', [SocialLoginController::class, 'redirect']);
Route::get('callback/{provider}', [SocialLoginController::class, 'callback'])->name('social.callback');

//document
Route::post('document/design-menu/{id}', [DocumentGenratorController::class, 'documentDesignMenu'])->name('document.design.menu')->middleware(['auth', 'verified', '2fa', 'Upload', 'verified_phone']);
Route::post('document/status/{id}', [DocumentGenratorController::class, 'DocumentGenStatus'])->name('document.status');

// public document
Route::get('document/public/{slug}', [DocumentGenratorController::class, 'documentPublic'])->name('document.public');
Route::get('documents/{slug}/{changelog?}', [DocumentGenratorController::class, 'documentPublicMenu'])->name('documentmenu.menu');
Route::get('document/{slug}/{slugmenu}', [DocumentGenratorController::class, 'documentPublicSubmenu'])->name('documentsubmenu.submenu');


// impersonate
Route::impersonate();
Route::get('users/{id}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
Route::get('impersonate/leave', [UserController::class, 'leaveImpersonate'])->name('impersonate.leave');
Route::get('changeLang/{lang?}', [HomeController::class, 'changeLang'])->name('change.lang');

Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');

Route::group(['prefix' => '2fa'], function () {
    Route::get('/', [LoginSecurityController::class, 'show2faForm']);
    Route::delete('/generateSecret', [LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret');
    Route::post('/enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
    Route::post('/disable2fa', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa');
});

Route::get('/{lang?}', [HomeController::class, 'landingPage'])->name('landingpage');

Route::get('/offline', function () {     return view('vendor/laravelpwa/offline'); });

Route::get('/check-session', function () {
    return response()->json(['authenticated' => Auth::check()]);
});