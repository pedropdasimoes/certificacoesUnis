<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Throwable;

class UsuarioController extends Controller
{
    private $objUsuario;
    private $objCurso;
    private $objCertificado;

    public function __construct()
    {
        $this->objUsuario = new User();
        $this->objCurso = new Curso();
        $this->objCertificado = new Certificado();
    }

    public function renderListarUsuarios($solicitante)
    {
        $userAuth = auth()->user();
        if ($userAuth) {

            $arrayUsuarios = $this->objUsuario->all();

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Usuarios/Listar', [
                    'usuarios' => $arrayUsuarios,
                ]);
            } elseif ($solicitante == 'deletado') {
                return Inertia::render('Unis/Admin/Usuarios/Listar', [
                    'usuarios' => $arrayUsuarios,
                    'deleted' => 'Usuário deletado com sucesso!'
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function listarUsuarios()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderListarUsuarios('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderViewCriarUsuarios($solicitante)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Usuarios/Criar', [
                    'btnSalvar' => true,
                    'btnAdd' => false
                ]);
            } elseif ($solicitante == 'criado') {
                return Inertia::render('Unis/Admin/Usuarios/Criar', [
                    'success' => 'Usuário criado com sucesso!',
                    'btnAdd' => true,
                    'btnSalvar' => false,
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function createUsuarios(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $validated = $request->validate([
                'email' => 'required|min:2|unique:users,email|unique:formandos,email',
                'nome' => 'required|min:2',
                'titulo' => 'required|min:2',
                'novaSenha' => 'required|min:8',
            ]);

            try {
                $cadastro = $this->objUsuario->create([
                    'name' => $request->nome,
                    'title' => $request->titulo,
                    'email' => $request->email,
                    'password' => bcrypt($request->novaSenha),
                    'current_team_id' => 2
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderViewCriarUsuarios('criado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function criarUsuarios()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderViewCriarUsuarios('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function deletarUsuarios(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $usuario = $this->objUsuario->find($request->id);
            $usuario->delete();

            return $this->renderListarUsuarios('deletado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderEditarUsuarios($solicitante, $id)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            $usuario = $this->objUsuario->find($id);

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Usuarios/Editar', [
                    'usuario' => $usuario,
                    'btnSalvar' => true,
                    'btnAdd' => false
                ]);
            } elseif ($solicitante == 'editado') {
                return Inertia::render('Unis/Admin/Usuarios/Editar', [
                    'usuario' => $usuario,
                    'success' => 'Usuário alterado com sucesso!',
                    'btnSalvar' => false,
                    'btnAdd' => true
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editarUsuarios($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderEditarUsuarios('view', $id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editUsuarios(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $usuario = $this->objUsuario->find($request->id);

            if ($usuario->email != $request->email) {
                $validated = $request->validate([
                    'email' => 'required|min:2|unique:users,email|unique:formandos,email',
                ]);
            }
            $validated = $request->validate([
                'nome' => 'required|min:2',
                'titulo' => 'required|min:2',
            ]);


            if ($request->novaSenha != null) {
                $validated = $request->validate([
                    'novaSenha' => 'required|min:8',
                ]);
                $usuario->update([
                    'name' => $request->nome,
                    'title' => $request->titulo,
                    'email' => $request->email,
                    'password' => bcrypt($request->novaSenha),
                    'current_team_id' => 2
                ]);
            } else {
                $usuario->update([
                    'name' => $request->nome,
                    'title' => $request->titulo,
                    'email' => $request->email,
                    'current_team_id' => 2
                ]);
            }

            return $this->renderEditarUsuarios('editado', $request->id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function visualizarUsuarios($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $usuario = $this->objUsuario->find($id);

            return Inertia::render('Unis/Admin/Usuarios/Visualizar', [
                'usuario' => $usuario,
            ]);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
}
