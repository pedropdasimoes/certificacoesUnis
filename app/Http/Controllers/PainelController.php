<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Formando;
use Illuminate\Http\Request;
use Inertia\Inertia;
use stdClass;
use Throwable;
use Illuminate\Support\Facades\Hash;

class PainelController extends Controller
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

    public function renderPainelInicial($solicitante)
    {
        if ($solicitante == 'view') {
            return Inertia::render('Unis/Externo/Painel/Inicial', [
                'btnSalvar' => true
            ]);
        } else {
            return Inertia::render('Unis/Erro/Erro');
        }
    }
    public function viewPainelInicial()
    {
        return $this->renderPainelInicial('view');
    }

    public function renderPainelRecrutador($solicitante)
    {
        if ($solicitante == 'view') {
            return Inertia::render('Unis/Externo/Painel/Recrutador');
        } elseif ($solicitante == 'naoEncontrado') {
            return Inertia::render('Unis/Externo/Painel/Recrutador', [
                'spanErro' => 'Código não encontrado.'
            ]);
        } else {
            return Inertia::render('Unis/Erro/Erro');
        }
    }
    public function viewPainelRecrutador()
    {
        return $this->renderPainelRecrutador('view');
    }

    public function renderLoginFormando($solicitante)
    {
        if ($solicitante == 'view') {
            return Inertia::render('Unis/Externo/Painel/Formando', [
                'btnSalvar' => true
            ]);
        } elseif ($solicitante == 'erroEmail') {
            return Inertia::render('Unis/Externo/Painel/Formando', [
                'spanErroEmail' => 'Email não encontrado.'
            ]);
        } elseif ($solicitante == 'erroSenha') {
            return Inertia::render('Unis/Externo/Painel/Formando', [
                'spanErroSenha' => 'Senha errada.'
            ]);
        } else {
            return Inertia::render('Unis/Erro/Erro');
        }
    }
    public function viewPainelFormando()
    {
        return $this->renderLoginFormando('view');
    }


    public function buscaFormando($hash)
    {
        $formandos = $this->objFormando->all();
        $cursosFormando = array();
        $posicaoCurso = null;
        foreach ($formandos as $formando) {
            if (in_array($hash, $formando->badges)) {
                if ($formando->redes['whatsapp'] != '') {
                    $whatsapp = $formando->redes['whatsapp'];
                    $whatsapp = preg_replace("/[^0-9]/", "", $whatsapp);
                    $whatsapp = 'https://api.whatsapp.com/send?phone=' . $whatsapp;
                } else {
                    $whatsapp = 'false';
                }

                if ($formando->redes['linkedin'] != '') {
                    $linkedin = $formando->redes['linkedin'];
                } else {
                    $linkedin = 'false';
                }
                foreach ($formando->cursos as $key => $curso) {
                    $cursosFormando[] = $this->objCurso->find($curso['idCurso']);
                    if ($curso['hashCurso'] == $hash) {
                        $posicaoCurso = $key;
                    }
                }
                return Inertia::render('Unis/Externo/VisualizarCurriculo', [
                    'formando' => $formando,
                    'cursos' => $cursosFormando,
                    'posicaoCurso' => $posicaoCurso,
                    'whatsapp' => $whatsapp,
                    'linkedin' => $linkedin
                ]);
            }
        }
        return $this->renderPainelRecrutador('naoEncontrado');
    }

    public function acessoFormando(Request $request)
    {
        $formando = $this->objFormando->where('email', $request->email)->first();
        if ($formando != null) {
            if (Hash::check($request->password, $formando->password)) {
                session()->put(['email' => $request->email, 'password' => $request->password, 'idFormando' => $formando->id]);
                return Inertia::render('Unis/Externo/PainelFormando/PainelFormando', [
                    'idFormando' => $formando->id
                ]);
            } else {
                return $this->renderLoginFormando('erroSenha');
            }
        } else {
            return $this->renderLoginFormando('erroEmail');
        }
    }
    public function acessoFormandoGet(Request $request)
    {
        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    return Inertia::render('Unis/Externo/PainelFormando/PainelFormando', [
                        'idFormando' => $formando->id
                    ]);
                } else {
                    return $this->renderLoginFormando('view');
                }
            } else {
                return $this->renderLoginFormando('view');
            }
        } else {
            return $this->renderLoginFormando('view');
        }
    }
}
