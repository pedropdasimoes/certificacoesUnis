<?php

use App\Http\Controllers\LockAuthController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\UnisController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\AprovacaoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\EmailController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\UsuarioUnis;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormandoController;
use App\Http\Controllers\GerenciamentoDPController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\PainelFormandoController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */




//PainelInicial
Route::get('/', [PainelController::class, 'viewPainelInicial'])->name('view-painel');
Route::get('view-recrutador', [PainelController::class, 'viewPainelRecrutador'])->name('view-recrutador');
Route::get('view-formando', [PainelController::class, 'viewPainelFormando'])->name('view-formando');
Route::get('busca-formando/{hash}', [PainelController::class, 'buscaFormando'])->name('busca-formando');
Route::post('busca-formando/{hash}', [PainelController::class, 'buscaFormando'])->name('busca-formando');



Route::get('listar-painel', [PainelController::class, 'listarPainel'])->name('listar-painel');
Route::get('criar-painel', [PainelController::class, 'criarPainel'])->name('criar-painel');
Route::post('create-painel', [PainelController::class, 'createPainel'])->name('create-painel');
Route::get('create-painel', [PainelController::class, 'listarPainel'])->name('create-painel');
Route::get('visualizar-painel/{id}', [PainelController::class, 'visualizarPainel'])->name('visualizar-painel');
Route::get('editar-painel/{id}', [PainelController::class, 'editarPainel'])->name('editar-painel');
Route::post('edit-painel', [PainelController::class, 'editPainel'])->name('edit-painel');
Route::get('edit-painel', [PainelController::class, 'listarPainel'])->name('edit-painel');
Route::post('deletar-painel', [PainelController::class, 'deletarPainel'])->name('deletar-painel');
Route::get('deletar-painel', [PainelController::class, 'listarPainel'])->name('deletar-painel');



//PainelFormando

Route::get('painel-formando', [PainelController::class, 'acessoFormandoGet'])->name('painel-formando');
Route::post('painel-formando', [PainelController::class, 'acessoFormando'])->name('painel-formando');

Route::get('atualizar-dados-painel-formando', [PainelFormandoController::class, 'viewAtualizarDadosFormandoGet'])->name('atualizar-dados-painel-formando');
Route::post('atualizar-dados-painel-formando', [PainelFormandoController::class, 'viewAtualizarDadosFormando'])->name('atualizar-dados-painel-formando');

Route::get('certificados-painel-formando', [PainelFormandoController::class, 'viewCertificadosFormandoGet'])->name('certificados-painel-formando');
Route::post('certificados-painel-formando', [PainelFormandoController::class, 'viewCertificadosFormando'])->name('certificados-painel-formando');

Route::get('altera-senha-painel-formando', [PainelFormandoController::class, 'viewAlteraSenhaFormandoGet'])->name('altera-senha-painel-formando');
Route::post('altera-senha-painel-formando', [PainelFormandoController::class, 'viewAlteraSenhaFormando'])->name('altera-senha-painel-formando');

Route::get('atualiza-formando', [PainelFormandoController::class, 'atualizaFormandoGet'])->name('atualiza-formando');
Route::post('atualiza-formando', [PainelFormandoController::class, 'atualizaFormando'])->name('atualiza-formando');

Route::get('altera-senha-formando', [PainelFormandoController::class, 'alteraSenhaFormandoGet'])->name('altera-senha-formando');
Route::post('altera-senha-formando', [PainelFormandoController::class, 'alteraSenhaFormando'])->name('altera-senha-formando');

Route::get('sair-painel-formando', [PainelFormandoController::class, 'sairPainelFormando'])->name('sair-painel-formando');
Route::post('sair-painel-formando', [PainelFormandoController::class, 'sairPainelFormando'])->name('sair-painel-formando');

Route::get('download-certificado', [PainelFormandoController::class, 'downloadCertificadoGet'])->name('download-certificado');
Route::post('download-certificado', [PainelFormandoController::class, 'downloadCertificado'])->name('download-certificado');




Route::get('create-painel-formando', [PainelFormandoController::class, 'listarCursos'])->name('create-painel-formando');
Route::get('visualizar-painel-formando/{id}', [PainelFormandoController::class, 'visualizarCursos'])->name('visualizar-painel-formando');
Route::get('editar-painel-formando/{id}', [PainelFormandoController::class, 'editarCursos'])->name('editar-painel-formando');
Route::post('edit-painel-formando', [PainelFormandoController::class, 'editCursos'])->name('edit-painel-formando');
Route::get('edit-painel-formando', [PainelFormandoController::class, 'listarCursos'])->name('edit-painel-formando');
Route::post('deletar-painel-formando', [PainelFormandoController::class, 'deletarCursos'])->name('deletar-painel-formando');
Route::get('deletar-painel-formando', [PainelFormandoController::class, 'listarCursos'])->name('deletar-painel-formando');

Route::get('/admin', function () {
    return Inertia::render([
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ], 'Dashboard');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::get('/admin', function () {
    //         return Inertia::render('Dashboard', [
    //         'canLogin' => Route::has('login'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //         ]);
    //     }
    //     )->name('dashboard');

    /*They are the required pages for the system, don't delete it*/
    Route::prefix('settings')->group(
        function () {
            Route::get(
                '/admin',
                function () {
                    return Inertia::render('Settings/Index', [
                        'users_count' => count(User::all('id')),
                        'roles_count' => count(Role::all()),
                        'permissions_count' => count(Permission::all())
                    ]);
                }
            )->name('settings');
            Route::resource('settings-user', UserController::class);
            Route::get(
                'role',
                function () {
                    return Inertia::render('Settings/Role');
                }
            )->name('settings-role');
            Route::get(
                'permission',
                function () {
                    return Inertia::render('Settings/Permission');
                }
            )->name('settings-permission');
            Route::get(
                'system',
                function () {
                    return Inertia::render('Settings/System');
                }
            )->name('settings-system');
        }
    );

    //Erros
    Route::get(
        'erro',
        function () {
            return Inertia::render('Unis/Erro/Erro');
        }
    )->name('erro');
    Route::get(
        'erro-permissao',
        function () {
            return Inertia::render('Unis/Erro/Permissao');
        }
    )->name('erro-permissao');

    //DashboardUnis
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');

    //Cursos
    Route::get('listar-cursos', [CursoController::class, 'listarCursos'])->name('listar-cursos');
    Route::get('criar-cursos', [CursoController::class, 'criarCursos'])->name('criar-cursos');
    Route::post('create-cursos', [CursoController::class, 'createCursos'])->name('create-cursos');
    Route::get('create-cursos', [CursoController::class, 'listarCursos'])->name('create-cursos');
    Route::get('visualizar-cursos/{id}', [CursoController::class, 'visualizarCursos'])->name('visualizar-cursos');
    Route::get('editar-cursos/{id}', [CursoController::class, 'editarCursos'])->name('editar-cursos');
    Route::post('edit-cursos', [CursoController::class, 'editCursos'])->name('edit-cursos');
    Route::get('edit-cursos', [CursoController::class, 'listarCursos'])->name('edit-cursos');
    Route::post('deletar-cursos', [CursoController::class, 'deletarCursos'])->name('deletar-cursos');
    Route::get('deletar-cursos', [CursoController::class, 'listarCursos'])->name('deletar-cursos');

    //Usuarios
    Route::get('listar-usuarios', [UsuarioController::class, 'listarUsuarios'])->name('listar-usuarios');
    Route::get('criar-usuarios', [UsuarioController::class, 'criarUsuarios'])->name('criar-usuarios');
    Route::post('create-usuarios', [UsuarioController::class, 'createUsuarios'])->name('create-usuarios');
    Route::get('create-usuarios', [UsuarioController::class, 'listarUsuarios'])->name('create-usuarios');
    Route::get('visualizar-usuarios/{id}', [UsuarioController::class, 'visualizarUsuarios'])->name('visualizar-usuarios');
    Route::get('editar-usuarios/{id}', [UsuarioController::class, 'editarUsuarios'])->name('editar-usuarios');
    Route::post('edit-usuarios', [UsuarioController::class, 'editUsuarios'])->name('edit-usuarios');
    Route::get('edit-usuarios', [UsuarioController::class, 'listarUsuarios'])->name('edit-usuarios');
    Route::post('deletar-usuarios', [UsuarioController::class, 'deletarUsuarios'])->name('deletar-usuarios');
    Route::get('deletar-usuarios', [UsuarioController::class, 'listarUsuarios'])->name('deletar-usuarios');

    //Certificados
    Route::get('listar-certificados', [CertificadoController::class, 'listarCertificados'])->name('listar-certificados');
    Route::get('criar-certificados', [CertificadoController::class, 'criarCertificados'])->name('criar-certificados');
    Route::post('create-certificados', [CertificadoController::class, 'createCertificados'])->name('create-certificados');
    Route::get('create-certificados', [CertificadoController::class, 'listarCertificados'])->name('create-certificados');
    Route::get('visualizar-certificados/{id}', [CertificadoController::class, 'visualizarCertificados'])->name('visualizar-certificados');
    Route::get('editar-certificados/{id}', [CertificadoController::class, 'editarCertificados'])->name('editar-certificados');
    Route::post('edit-certificados', [CertificadoController::class, 'editCertificados'])->name('edit-certificados');
    Route::get('edit-certificados', [CertificadoController::class, 'listarCertificados'])->name('edit-certificados');
    Route::post('deletar-certificados', [CertificadoController::class, 'deletarCertificados'])->name('deletar-certificados');
    Route::get('deletar-certificados', [CertificadoController::class, 'listarCertificados'])->name('deletar-certificados');

    //Formandos
    Route::get('listar-formandos', [FormandoController::class, 'listarFormandos'])->name('listar-formandos');
    Route::get('criar-formandos', [FormandoController::class, 'criarFormandos'])->name('criar-formandos');
    Route::post('create-formandos', [FormandoController::class, 'createFormandos'])->name('create-formandos');
    Route::get('create-formandos', [FormandoController::class, 'listarFormandos'])->name('create-formandos');
    Route::get('visualizar-formandos/{id}', [FormandoController::class, 'visualizarFormandos'])->name('visualizar-formandos');
    Route::get('editar-formandos/{id}', [FormandoController::class, 'editarFormandos'])->name('editar-formandos');
    Route::post('edit-formandos', [FormandoController::class, 'editFormandos'])->name('edit-formandos');
    Route::get('edit-formandos', [FormandoController::class, 'listarFormandos'])->name('edit-formandos');
    Route::post('deletar-formandos', [FormandoController::class, 'deletarFormandos'])->name('deletar-formandos');
    Route::get('deletar-formandos', [FormandoController::class, 'listarFormandos'])->name('deletar-formandos');
    Route::post('redefinir-senha-formandos', [FormandoController::class, 'redefinirSenhaFormandos'])->name('redefinir-senha-formandos');
    Route::get('redefinir-senha-formandos', [FormandoController::class, 'listarFormandos'])->name('redefinir-senha-formandos');

    //Csv
    Route::get('render-csv', [CsvController::class, 'renderCsv'])->name('render-csv');
    Route::get('criar-csv', [CsvController::class, 'criarCsv'])->name('criar-csv');
    Route::post('create-csv', [CsvController::class, 'createCsv'])->name('create-csv');
    Route::get('create-csv', [CsvController::class, 'listarCsv'])->name('create-csv');
    Route::get('visualizar-csv/{id}', [CsvController::class, 'visualizarCsv'])->name('visualizar-csv');
    Route::get('editar-csv/{id}', [CsvController::class, 'editarCsv'])->name('editar-csv');
    Route::post('edit-csv', [CsvController::class, 'editCsv'])->name('edit-csv');
    Route::get('edit-csv', [CsvController::class, 'listarCsv'])->name('edit-csv');
    Route::post('deletar-csv', [CsvController::class, 'deletarCsv'])->name('deletar-csv');
    Route::get('deletar-csv', [CsvController::class, 'listarCsv'])->name('deletar-csv');
    Route::get('download-exemplo-csv', [CsvController::class, 'downloadExemploCsv'])->name('download-exemplo-csv');


    //Currículo
    // Route::get('visualizar-curriculo', [CertificadosController::class, 'viewVisuazilarCurriculo'])->name('visualizar-curriculo');




    //PAGINAS DE EXEMPLO PARA DEVELOPMENT
    Route::get(
        'login-app',
        function () {

            return Inertia::render('Samples/Examples/Login');
        }
    )->name('login-app');
    Route::get(
        'login-app-1',
        function () {

            return Inertia::render('Samples/Examples/Auth/Login1');
        }
    )->name('login-app-1');
    Route::get(
        'login-app-2',
        function () {

            return Inertia::render('Samples/Examples/Auth/Login2');
        }
    )->name('login-app-2');
    Route::get(
        'login-app-3',
        function () {

            return Inertia::render('Samples/Examples/Auth/Login3');
        }
    )->name('login-app-3');
    Route::get(
        'register-app',
        function () {

            return Inertia::render('Samples/Examples/Register');
        }
    )->name('register-app');
    Route::get(
        'register-app-1',
        function () {

            return Inertia::render('Samples/Examples/Auth/Register1');
        }
    )->name('register-app-1');
    Route::get(
        'register-app-2',
        function () {

            return Inertia::render('Samples/Examples/Auth/Register2');
        }
    )->name('register-app-2');
    Route::get(
        'register-app-3',
        function () {

            return Inertia::render('Samples/Examples/Auth/Register3');
        }
    )->name('register-app-3');
    Route::get(
        'forgot-password-app',
        function () {

            return Inertia::render('Samples/Examples/ForgotPassword');
        }
    )->name('forgot-password-app');
    Route::get(
        'forgot-password-app-1',
        function () {

            return Inertia::render('Samples/Examples/Auth/ForgotPassword1');
        }
    )->name('forgot-password-app-1');
    Route::get(
        'forgot-password-app-2',
        function () {

            return Inertia::render('Samples/Examples/Auth/ForgotPassword2');
        }
    )->name('forgot-password-app-2');
    Route::get(
        'forgot-password-app-3',
        function () {

            return Inertia::render('Samples/Examples/Auth/ForgotPassword3');
        }
    )->name('forgot-password-app-3');
    Route::get(
        'lock-app',
        function () {

            return Inertia::render('Samples/Examples/Lock');
        }
    )->name('lock-app');
    Route::get(
        'lock-app-1',
        function () {

            return Inertia::render('Samples/Examples/Auth/Lock1');
        }
    )->name('lock-app-1');
    Route::get(
        'lock-app-2',
        function () {

            return Inertia::render('Samples/Examples/Auth/Lock2');
        }
    )->name('lock-app-2');
    Route::get(
        'lock-app-3',
        function () {

            return Inertia::render('Samples/Examples/Auth/Lock3');
        }
    )->name('lock-app-3');
    Route::get(
        'profile',
        function () {

            return Inertia::render('Samples/Examples/Profile');
        }
    )->name('profile');
    Route::get(
        'pricing',
        function () {

            return Inertia::render('Samples/Examples/Pricing');
        }
    )->name('pricing');
    Route::get(
        'project-management-app',
        function () {

            return Inertia::render('Samples/Examples/ProjectApp');
        }
    )->name('project-management-app');
    Route::get(
        'todo-app',
        function () {

            return Inertia::render('Samples/Examples/TodoApp');
        }
    )->name('todo-app');
    Route::get(
        'email-app',
        function () {

            return Inertia::render('Samples/Examples/EmailApp');
        }
    )->name('email-app');
    Route::get(
        'chat-app',
        function () {

            return Inertia::render('Samples/Examples/ChatApp');
        }
    )->name('chat-app');
    //Component Pages
    Route::get(
        'alert',
        function () {

            return Inertia::render('Samples/Components/Alert');
        }
    )->name('alert');
    Route::get(
        'avatar',
        function () {

            return Inertia::render('Samples/Components/Avatar');
        }
    )->name('avatar');
    Route::get(
        'badge',
        function () {

            return Inertia::render('Samples/Components/Badge');
        }
    )->name('badge');
    Route::get(
        'breadcrumb',
        function () {

            return Inertia::render('Samples/Components/Breadcrumb');
        }
    )->name('breadcrumb');
    Route::get(
        'button',
        function () {

            return Inertia::render('Samples/Components/Button');
        }
    )->name('button');
    Route::get(
        'chart',
        function () {

            return Inertia::render('Samples/Components/Chart');
        }
    )->name('chart');
    Route::get(
        'collapsible',
        function () {

            return Inertia::render('Samples/Components/Collapsible');
        }
    )->name('collapsible');
    Route::get(
        'dropdown',
        function () {

            return Inertia::render('Samples/Components/Dropdown');
        }
    )->name('dropdown');
    Route::get(
        'list',
        function () {

            return Inertia::render('Samples/Components/List');
        }
    )->name('list');
    Route::get(
        'modal',
        function () {

            return Inertia::render('Samples/Components/Modal');
        }
    )->name('modal');
    Route::get(
        'pagination',
        function () {

            return Inertia::render('Samples/Components/Paginate');
        }
    )->name('pagination');
    Route::get(
        'popover',
        function () {

            return Inertia::render('Samples/Components/Popover');
        }
    )->name('popover');
    Route::get(
        'progress',
        function () {

            return Inertia::render('Samples/Components/Progress');
        }
    )->name('progress');
    Route::get(
        'tab',
        function () {

            return Inertia::render('Samples/Components/Tab');
        }
    )->name('tab');
    Route::get(
        'table',
        function () {

            return Inertia::render('Samples/Components/Table', [
                'users' => User::all()
            ]);
        }
    )->name('table');

    /*TODO: Toastr Feature
     Route::get('toastr',function (){return Inertia::render('Samples/Components/Toastr');})->name('toastr');*/
    Route::get(
        'tooltip',
        function () {

            return Inertia::render('Samples/Components/Tooltip');
        }
    )->name('tooltip');
    // Layout Pages
    Route::get(
        'layout-structure',
        function () {

            return Inertia::render('Samples/Layouts/LayoutStructure');
        }
    )->name('layout-structure');
    Route::get(
        'layout-grid',
        function () {

            return Inertia::render('Samples/Layouts/Grid');
        }
    )->name('layout-grid');
    Route::get(
        'layout-content-box',
        function () {

            return Inertia::render('Samples/Layouts/ContentBox');
        }
    )->name('layout-content-box');
    Route::get(
        'layout-statistic-widget',
        function () {

            return Inertia::render('Samples/Layouts/StatisticWidget');
        }
    )->name('layout-statistic-widget');
    // Form Pages
    Route::get(
        'form-structure',
        function () {

            return Inertia::render('Samples/FormElements/FormStructure');
        }
    )->name('form-structure');
    Route::get(
        'form-input-group',
        function () {

            return Inertia::render('Samples/FormElements/InputGroup');
        }
    )->name('form-input-group');
    Route::get(
        'form-simple-field',
        function () {

            return Inertia::render('Samples/FormElements/SimpleField');
        }
    )->name('form-simple-field');
    Route::get(
        'form-repeatable-field',
        function () {

            return Inertia::render('Samples/FormElements/RepeatableField');
        }
    )->name('form-repeatable-field');
    Route::get(
        'form-inline-repeatable-field',
        function () {

            return Inertia::render('Samples/FormElements/InlineRepeatableField');
        }
    )->name('form-inline-repeatable-field');
    Route::get(
        'form-date-field',
        function () {

            return Inertia::render('Samples/FormElements/DateField');
        }
    )->name('form-date-field');
    Route::get(
        'form-select-input',
        function () {

            return Inertia::render('Samples/FormElements/SelectInput', [
                'users' => User::all()
            ]);
        }
    )->name('form-select-input');
    Route::get(
        'form-multi-select-input',
        function () {

            return Inertia::render('Samples/FormElements/MultiSelectInput', [
                'users' => User::all()
            ]);
        }
    )->name('form-multi-select-input');
    Route::get(
        'form-tag-input',
        function () {

            return Inertia::render('Samples/FormElements/TagInput');
        }
    )->name('form-tag-input');
    Route::get(
        'form-validation',
        function () {

            return Inertia::render('Samples/FormElements/Validation');
        }
    )->name('form-validation');
});
