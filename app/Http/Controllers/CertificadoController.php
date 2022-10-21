<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class CertificadoController extends Controller
{
    private $objCertificado;

    public function __construct()
    {
        $this->objCertificado = new Certificado();
    }

    public function renderListarCertificados($solicitante)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            $arrayCertificados = $this->objCertificado->all();

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Certificados/Listar', [
                    'certificados' => $arrayCertificados,
                ]);
            } elseif ($solicitante == 'deletado') {
                return Inertia::render('Unis/Admin/Certificados/Listar', [
                    'certificados' => $arrayCertificados,
                    'deleted' => 'Certificado deletado com sucesso!'
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function listarCertificados()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderListarCertificados('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderViewCriarCertificados($solicitante)
    {

        $userAuth = auth()->user();
        if ($userAuth) {
            $certificados = $this->objCertificado->all();
            // dd($certificados);

            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Certificados/Criar', [
                    'certificados' => $certificados,
                    'btnSalvar' => true,
                    'success' => '',
                    'tokenFont' => config('global.tokens.fontGoogle')
                ]);
            } elseif ($solicitante == 'criado') {
                return Inertia::render('Unis/Admin/Certificados/Criar', [
                    'success' => 'Certificado criado com sucesso!',
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
    public function createCertificados(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $validated = $request->validate([
                'modeloBase' => 'required',
                'styles' => 'required|array',
                'values' => 'required|array',
                'images' => 'required|array',
                'nomeModel' => 'required|string|min:2|unique:certificados,nome',
                'texto1' => 'required|string',
                'texto2' => 'required|string',
            ]);




            $caminhoImagem = null;
            if (count($request->images['fundo']) > 0) {
                $arrayName = explode('.', time() . $request->images['fundo'][0]->getClientOriginalName());
                $imageName = '';
                foreach ($arrayName as $key => $string) {
                    if ($key != (count($arrayName) - 1)) {
                        $imageName .= $string;
                    }
                }
                $imageName = preg_replace("/[^\w\s]/", "", iconv("UTF-8", "ASCII//TRANSLIT", $imageName));
                $imageName = str_replace(" ", "-", $imageName);
                $imageName = strtolower($imageName);
                $imageName .= '.' . $arrayName[count($arrayName) - 1];
                $request->images['fundo'][0]->move(public_path('img/certificados/'), $imageName);
                $caminhoImagem = '/img/certificados/' . $imageName;
            } else {
                $modeloBase = $this->objCertificado->find($request->modeloBase);
                $caminhoImagem = $modeloBase->data['fundoPadrao'];
            }

            $dadosNovos = [
                'styles' => $request->styles,
                'values' => $request->values,
                'texto1' => $request->texto1,
                'texto2' => $request->texto2,
                'nomeModelo' => $request->nomeModel,
                'key' => $request->key,
                'fundoPadrao' => $caminhoImagem
            ];


            try {
                $cadastro = $this->objCertificado->create([
                    'nome' => $request->nomeModel,
                    'data' => $dadosNovos

                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderViewCriarCertificados('criado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function criarCertificados()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderViewCriarCertificados('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function deletarCertificados(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $certificado = $this->objCertificado->find($request->id);
            $certificado->delete();

            return $this->renderListarCertificados('deletado');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderEditarCertificados($solicitante, $id)
    {

        $userAuth = auth()->user();
        if ($userAuth) {

            $certificado = $this->objCertificado->find($id);
            $arrayCertificados = $this->objCertificado->all();


            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Certificados/Editar', [
                    'certificado' => $certificado,
                    'certificados' => $arrayCertificados,
                    'idCertificado' => $certificado->id,
                    'btnAdd' => true,
                    'btnSalvar' => true,
                    'tokenFont' => config('global.tokens.fontGoogle')
                ]);
            } elseif ($solicitante == 'editado') {
                return Inertia::render('Unis/Admin/Certificados/Editar', [
                    'certificado' => $certificado,
                    'certificados' => $arrayCertificados,
                    'idCertificado' => $certificado->id,
                    'success' => 'Certificado alterado com sucesso!',
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
    public function editarCertificados($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderEditarCertificados('view', $id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function editCertificados(Request $request)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $certificado = $this->objCertificado->find($request->id);
            if ($certificado->nome != $request->nomeModel) {
                $validated = $request->validate([
                    'nomeModel' => 'required|string|min:2|unique:certificados,nome',
                ]);
            } else {
                $validated = $request->validate([
                    'modeloBase' => 'required',
                    'styles' => 'required|array',
                    'values' => 'required|array',
                    'images' => 'required|array',
                    'texto1' => 'required|string',
                    'texto2' => 'required|string',
                ]);
            }

            $caminhoImagem = null;
            if (count($request->images['fundo']) > 0) {
                $arrayName = explode('.', time() . $request->images['fundo'][0]->getClientOriginalName());
                $imageName = '';
                foreach ($arrayName as $key => $string) {
                    if ($key != (count($arrayName) - 1)) {
                        $imageName .= $string;
                    }
                }
                $imageName = preg_replace("/[^\w\s]/", "", iconv("UTF-8", "ASCII//TRANSLIT", $imageName));
                $imageName = str_replace(" ", "-", $imageName);
                $imageName = strtolower($imageName);
                $imageName .= '.' . $arrayName[count($arrayName) - 1];
                $request->images['fundo'][0]->move(public_path('img/certificados/'), $imageName);
                $caminhoImagem = '/img/certificados/' . $imageName;
            } else {
                $modeloBase = $this->objCertificado->find($request->modeloBase);
                $caminhoImagem = $modeloBase->data['fundoPadrao'];
            }

            $dadosNovos = [
                'styles' => $request->styles,
                'values' => $request->values,
                'texto1' => $request->texto1,
                'texto2' => $request->texto2,
                'nomeModelo' => $request->nomeModel,
                'key' => $request->key,
                'fundoPadrao' => $caminhoImagem
            ];

            $certificado->update([
                'nome' => $request->nomeModel,
                'data' => $dadosNovos

            ]);

            return $this->renderEditarCertificados('editado', $request->id);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function visualizarCertificados($id)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $certificado = $this->objCertificado->find($id);

            return Inertia::render('Unis/Admin/Certificados/Visualizar', [
                'certificado' => $certificado,
                'tokenFont' => config('global.tokens.fontGoogle')
            ]);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
}
