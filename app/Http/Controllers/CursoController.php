<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Throwable;

class CursoController extends Controller
{

    private $objCurso;
    private $objCertificado;

    public function __construct()
    {
        $this->objCurso = new Curso();
        $this->objCertificado = new Certificado();
    }

    public function renderListarCursos($solicitante)
    {
        $userAuth = auth()->user();
        if ($userAuth) {

            $arrayCursos = $this->objCurso->all();
            $arrayCertificados = $this->objCertificado->all();

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Cursos/Listar', [
                    'cursos' => $arrayCursos,
                    'certificados' => $arrayCertificados
                ]);
            } elseif ($solicitante == 'deletado') {
                return Inertia::render('Unis/Admin/Cursos/Listar', [
                    'cursos' => $arrayCursos,
                    'deleted' => 'Curso deletado com sucesso!'
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function listarCursos()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderListarCursos('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderViewCriarCursos($solicitante)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            $certificados = $this->objCertificado->all();

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Cursos/Criar', [
                    'certificados' => $certificados,
                    'btnSalvar' => true,
                    'btnCertificado' => true,
                    'btnAdd' => false,
                    'tokenFont' => config('global.tokens.fontGoogle')
                ]);
            } elseif ($solicitante == 'criado') {
                return Inertia::render('Unis/Admin/Cursos/Criar', [
                    'certificados' => $certificados,
                    'success' => 'Curso criado com sucesso!',
                    'btnAdd' => true,
                    'btnCertificado' => false,
                    'btnSalvar' => false,
                    'tokenFont' => config('global.tokens.fontGoogle')
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function createCursos(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $validated = $request->validate([
                'codigoReferencia' => 'required|min:2|unique:cursos,referencia',
                'nomeCurso' => 'required|min:2',
                'tituloCurso' => 'required|min:2',
                'cargaHoraria' => 'required|numeric|min:1',
                'sobreCurso' => 'required|min:2',
                'competencias' => 'required|min:2',
                'modulos' => 'required',
            ]);

            $cursoData = new stdClass();
            $cursoData->nome = $request->nomeCurso;
            $cursoData->titulo = $request->tituloCurso;
            $cursoData->cargaHoraria = $request->cargaHoraria . ' h';
            $cursoData->sobre = $request->sobreCurso;
            $cursoData->competencia = $request->competencias;
            $cursoData->emitido = "https://portal.unis.edu.br/hubfs/Brand%20Center/2020/Grupo%20Unis/Logomarca%20Grupo%20Unis.png?hsLang=pt-br";
            $cursoData->url = "https://www.google.com";
            $cursoData->modulos = $request->modulos;

            try {
                $cadastro = $this->objCurso->create([
                    'referencia' => $request->codigoReferencia,
                    'nome' => $request->nomeCurso,
                    'data' => $cursoData,
                    'id_certificado' => $request->idCurriculo
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderViewCriarCursos('criado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function criarCursos()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderViewCriarCursos('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function deletarCursos(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $curso = $this->objCurso->find($request->id);
            $curso->delete();

            return $this->renderListarCursos('deletado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderEditarCursos($solicitante, $id)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            $curso = $this->objCurso->find($id);
            $cargaHoraria = intval($curso->data['cargaHoraria']);
            $certificado = $this->objCertificado->find($curso->id_certificado);
            $certificados = $this->objCertificado->all();

            // dump($curso);
            // dump($certificado);
            // dd($certificados);

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Cursos/Editar', [
                    'curso' => $curso,
                    'cargaHoraria' => $cargaHoraria,
                    'certificado' => $certificado,
                    'certificados' => $certificados,
                    'idCertificado' => $certificado->id,
                    'btnSalvar' => true,
                    'btnCertificado' => true,
                    'btnAdd' => false,
                    'tokenFont' => config('global.tokens.fontGoogle')
                ]);
            } elseif ($solicitante == 'editado') {
                return Inertia::render('Unis/Admin/Cursos/Editar', [
                    'curso' => $curso,
                    'cargaHoraria' => $cargaHoraria,
                    'certificado' => $certificado,
                    'certificados' => $certificados,
                    'idCertificado' => $certificado->id,
                    'success' => 'Curso alterado com sucesso!',
                    'btnSalvar' => false,
                    'btnCertificado' => false,
                    'btnAdd' => true,
                    'tokenFont' => config('global.tokens.fontGoogle')
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editarCursos($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderEditarCursos('view', $id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editCursos(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $curso = $this->objCurso->find($request->id);

            if ($curso->referencia != $request->codigoReferencia) {
                $validated = $request->validate([
                    'codigoReferencia' => 'required|min:2|unique:cursos,referencia',
                    'nomeCurso' => 'required|min:2',
                    'tituloCurso' => 'required|min:2',
                    'cargaHoraria' => 'required|numeric|min:1',
                    'sobreCurso' => 'required|min:2',
                    'competencias' => 'required|min:2',
                    'modulos' => 'required',
                ]);
            } else {
                $validated = $request->validate([
                    'nomeCurso' => 'required|min:2',
                    'tituloCurso' => 'required|min:2',
                    'cargaHoraria' => 'required|numeric|min:1',
                    'sobreCurso' => 'required|min:2',
                    'competencias' => 'required|min:2',
                    'modulos' => 'required',
                ]);
            }

            $cursoData = new stdClass();
            $cursoData->nome = $request->nomeCurso;
            $cursoData->titulo = $request->tituloCurso;
            $cursoData->cargaHoraria = $request->cargaHoraria . ' h';
            $cursoData->sobre = $request->sobreCurso;
            $cursoData->competencia = $request->competencias;
            $cursoData->emitido = "https://portal.unis.edu.br/hubfs/Brand%20Center/2020/Grupo%20Unis/Logomarca%20Grupo%20Unis.png?hsLang=pt-br";
            $cursoData->url = "https://www.google.com";
            $cursoData->modulos = $request->modulos;

            $curso->update([
                'referencia' => $request->codigoReferencia,
                'nome' => $request->nomeCurso,
                'data' => $cursoData,
                'id_certificado' => $request->idCurriculo
            ]);

            return $this->renderEditarCursos('editado', $request->id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function visualizarCursos($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $curso = $this->objCurso->find($id);
            $certificado = $this->objCertificado->find($curso->id_certificado);

            return Inertia::render('Unis/Admin/Cursos/Visualizar', [
                'curso' => $curso,
                'certificado' => $certificado,
                'tokenFont' => config('global.tokens.fontGoogle')
            ]);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
}
