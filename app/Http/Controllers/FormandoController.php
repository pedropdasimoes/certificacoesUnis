<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Formando;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Throwable;

class FormandoController extends Controller
{
    private $objCurso;
    private $objCertificado;
    private $objFormando;

    public function __construct()
    {
        $this->objCurso = new Curso();
        $this->objCertificado = new Certificado();
        $this->objFormando = new Formando();
    }

    public function renderListarFormandos($solicitante)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $arrayFormandos = $this->objFormando->all();
            $arrayCertificados = $this->objCertificado->all();

            foreach ($arrayFormandos as $formando) {
                $formando->cpf = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $formando->cpf);
            }

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Formandos/Listar', [
                    'formandos' => $arrayFormandos,
                    'certificados' => $arrayCertificados
                ]);
            } elseif ($solicitante == 'deletado') {
                return Inertia::render('Unis/Admin/Formandos/Listar', [
                    'formandos' => $arrayFormandos,
                    'deleted' => 'Formando deletado com sucesso!'
                ]);
            } elseif ($solicitante == 'redefinido') {
                return Inertia::render('Unis/Admin/Formandos/Listar', [
                    'formandos' => $arrayFormandos,
                    'redefinido' => 'Senha do formando redefinida com sucesso!'
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function listarFormandos()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderListarFormandos('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function renderViewCriarFormandos($solicitante)
    {

        $userAuth = auth()->user();
        if ($userAuth) {
            $cursos = $this->objCurso->all();
            $certificados = $this->objCertificado->all();
            $formandos = $this->objFormando->all();
            $arrayBadge = array();
            foreach ($formandos as $formando) {
                foreach ($formando->badges as $badge) {
                    $arrayBadge[] = $badge;
                }
            }

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Formandos/Criar', [
                    'certificados' => $certificados,
                    'btnSalvar' => true,
                    'btnCertificado' => true,
                    'btnAdd' => false,
                    'cursosDisponiveis' => $cursos,
                    'arrayBadges' => $arrayBadge
                ]);
            } elseif ($solicitante == 'criado') {
                return Inertia::render('Unis/Admin/Formandos/Criar', [
                    'certificados' => $certificados,
                    'success' => 'Formando criado com sucesso!',
                    'btnAdd' => true,
                    'btnCertificado' => false,
                    'btnSalvar' => false,
                    'cursosDisponiveis' => $cursos
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function createFormandos(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {


            if ($request->whatsapp != null && $request->whatsapp != '') {
                $validated = $request->validate([
                    'whatsapp' => 'required|min:11',
                ]);
            }

            if ($request->linkedin != null && $request->linkedin != '') {
                $validated = $request->validate([
                    'linkedin' => 'required|min:2',
                ]);
            }

            $validated = $request->validate([
                'nome' => 'required|min:2',
                'cpf' => 'required|min:11|unique:formandos,cpf',
                'email' => 'required|min:2|unique:formandos,email',
                'cursosSelecionados' => 'required',
            ]);
            $cpf = preg_replace("/[^0-9]/", "", $request->cpf);
            // $whatsapp = preg_replace("/[^0-9]/", "", $request->whatsapp);



            $redesData = new stdClass();
            $redesData->linkedin = $request->linkedin;
            $redesData->whatsapp = $request->whatsapp;

            $badgesData = array();
            foreach ($request->cursosSelecionados as $formando) {
                $badgesData[] = $formando['hashCurso'];
            }

            try {
                $cadastro = $this->objFormando->create([
                    'nome' => $request->nome,
                    'cpf' => $cpf,
                    'email' => $request->email,
                    'cursos' => $request->cursosSelecionados,
                    'redes' => $redesData,
                    'badges' => $badgesData,
                    'password' => bcrypt($cpf)
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderViewCriarFormandos('criado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function criarFormandos()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderViewCriarFormandos('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function deletarFormandos(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $formando = $this->objFormando->find($request->id);
            $formando->delete();

            return $this->renderListarFormandos('deletado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function redefinirSenhaFormandos(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $formando = $this->objFormando->find($request->id);
            try {
                $formandoUpdate = $formando->update([
                    'password' => bcrypt($formando->cpf)
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderListarFormandos('redefinido');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }

    public function renderEditarFormandos($solicitante, $id)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            $cursos = $this->objCurso->all();
            $certificados = $this->objCertificado->all();
            $formando = $this->objFormando->find($id);
            $arrayKeySim = array();
            $arrayKeyNao = array();
            $count = 0;
            foreach ($formando->cursos as $formandoCurso) {
                $arrayKeySim[] = $count++;
                $arrayKeyNao[] = $count++;
            }
            $formandosAll = $this->objFormando->all();
            $arrayBadge = array();
            foreach ($formandosAll as $formandos) {
                foreach ($formandos->badges as $badge) {
                    $arrayBadge[] = $badge;
                }
            }
            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Formandos/Editar', [
                    'arrayKeySim' => $arrayKeySim,
                    'arrayKeyNao' => $arrayKeyNao,
                    'formando' => $formando,
                    'cursosDisponiveis' => $cursos,
                    'certificados' => $certificados,
                    'btnSalvar' => true,
                    'btnAdd' => false,
                    'arrayBadges' => $arrayBadge
                ]);
            } elseif ($solicitante == 'editado') {
                return Inertia::render('Unis/Admin/Formandos/Editar', [
                    'arrayKeySim' => $arrayKeySim,
                    'arrayKeyNao' => $arrayKeyNao,
                    'formando' => $formando,
                    'cursosDisponiveis' => $cursos,
                    'certificados' => $certificados,
                    'btnSalvar' => false,
                    'btnAdd' => true,
                    'success' => 'Formando editado com sucesso.',
                    'arrayBadges' => $arrayBadge
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editarFormandos($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderEditarFormandos('view', $id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editFormandos(Request $request)
    {
        // dd($request->all());
        $userAuth = auth()->user();
        if ($userAuth) {
            $formando = $this->objFormando->find($request->id);

            $cpf = preg_replace("/[^0-9]/", "", $request->cpf);
            // $whatsapp = preg_replace("/[^0-9]/", "", $request->whatsapp);

            if ($formando->cpf != $cpf) {
                $validated = $request->validate([
                    'cpf' => 'required|min:11|unique:formandos,cpf',
                ]);
            }
            if ($formando->email != $request->email) {
                $validated = $request->validate([
                    'email' => 'required|min:2|unique:formandos,email',
                ]);
            }

            if ($formando->whatsapp != null && $formando->whatsapp != '') {
                $validated = $request->validate([
                    'whatsapp' => 'required|min:11',
                ]);
            }

            if ($formando->linkedin != null && $formando->linkedin != '') {
                $validated = $request->validate([
                    'linkedin' => 'required|min:2',
                ]);
            }
            $validated = $request->validate([
                'nome' => 'required|min:2',
                'cursosSelecionados' => 'required',
            ]);

            $redesData = new stdClass();
            $redesData->linkedin = $request->linkedin;
            $redesData->whatsapp = $request->whatsapp;


            $badgesData = array();
            foreach ($request->cursosSelecionados as $curso) {
                $badgesData[] = $curso['hashCurso'];
            }

            try {
                $formando->update([
                    'nome' => $request->nome,
                    'cpf' => $cpf,
                    'email' => $request->email,
                    'cursos' => $request->cursosSelecionados,
                    'redes' => $redesData,
                    'badges' => $badgesData
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderEditarFormandos('editado', $request->id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function visualizarFormandos($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $formando = $this->objFormando->find($id);
            $cursosFormando = $formando->cursos;
            $CursosGeral = $this->objCurso->all();
            $formando->cpf = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $formando->cpf);
            foreach ($CursosGeral as $curso) {
                foreach ($cursosFormando as $key => $cursoUnicoFormando) {
                    if ($curso->id == $cursoUnicoFormando['idCurso']) {
                        $cursosFormando[$key]['referencia'] = $curso->referencia;
                        $cursosFormando[$key]['dataEmissao'] = date("d/m/Y", strtotime($cursosFormando[$key]['dataEmissao']));
                    }
                }
            }
            $formando->cursos = $cursosFormando;


            return Inertia::render('Unis/Admin/Formandos/Visualizar', [
                'formando' => $formando,
            ]);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
}
