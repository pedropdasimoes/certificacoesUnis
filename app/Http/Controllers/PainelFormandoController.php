<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Formando;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Throwable;
use PDF;

class PainelFormandoController extends Controller
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

    public function renderLoginFormando($solicitante)
    {
        if ($solicitante == 'view') {
            return Inertia::render('Unis/Externo/Painel/Formando', []);
        } else {
            return Inertia::render('Unis/Erro/Erro');
        }
    }

    public function renderAtualizarDadosFormando($solicitante, $id = null)
    {

        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    $formando = $this->objFormando->find($id);
                    $cursosFormando = array();
                    foreach ($formando->cursos as $curso) {
                        $cursosFormando[] = $this->objCurso->find($curso['idCurso']);
                    }
                    if ($solicitante == 'view') {
                        return Inertia::render('Unis/Externo/PainelFormando/AtualizaDados', [
                            'formando' => $formando,
                            'cursos' => $cursosFormando
                        ]);
                    } elseif ($solicitante == 'alterado') {
                        return Inertia::render('Unis/Externo/PainelFormando/AtualizaDados', [
                            'formando' => $formando,
                            'cursos' => $cursosFormando,
                            'alterado' => 'Informações alteradas com sucesso!'
                        ]);
                    } else {
                        return Inertia::render('Unis/Erro/Erro');
                    }
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

    public function viewAtualizarDadosFormandoGet(Request $request)
    {
        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    return $this->renderAtualizarDadosFormando('view', session()->get('idFormando'));
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


    public function viewAtualizarDadosFormando(Request $request)
    {
        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    return $this->renderAtualizarDadosFormando('view', $request->id);
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

    public function renderCertificadosFormando($solicitante, $id = null)
    {
        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    $formando = $this->objFormando->find($id);
                    $cursosFormando = array();
                    foreach ($formando->cursos as $curso) {
                        $cursosFormando[] = $this->objCurso->find($curso['idCurso']);
                    }
                    if ($solicitante == 'view') {
                        return Inertia::render('Unis/Externo/PainelFormando/Certificados', [
                            'formando' => $formando,
                            'cursos' => $cursosFormando
                        ]);
                    } else {
                        return Inertia::render('Unis/Erro/Erro');
                    }
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

    public function viewCertificadosFormandoGet(Request $request)
    {
        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    return $this->renderCertificadosFormando('view', session()->get('idFormando'));
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

    public function viewCertificadosFormando(Request $request)
    {
        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    return $this->renderCertificadosFormando('view', $request->id);
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

    public function renderAlteraSenhaFormando($solicitante, $id = null)
    {

        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    $formando = $this->objFormando->find($id);
                    $cursosFormando = array();
                    foreach ($formando->cursos as $curso) {
                        $cursosFormando[] = $this->objCurso->find($curso['idCurso']);
                    }
                    if ($solicitante == 'view') {
                        return Inertia::render('Unis/Externo/PainelFormando/AlteraSenha', [
                            'idFormando' => $formando->id
                        ]);
                    } elseif ($solicitante == 'erroSenha') {
                        return Inertia::render('Unis/Externo/PainelFormando/AlteraSenha', [
                            'idFormando' => $formando->id,
                            'spanErroSenhaAtual' => 'Sua senha atual está incorreta.'
                        ]);
                    } elseif ($solicitante == 'senhaAlterada') {
                        return Inertia::render('Unis/Externo/PainelFormando/AlteraSenha', [
                            'idFormando' => $formando->id,
                            'alterado' => 'Sua senha foi alterada com sucesso.'
                        ]);
                    } else {
                        return Inertia::render('Unis/Erro/Erro');
                    }
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

    public function viewAlteraSenhaFormandoGet(Request $request)
    {
        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    return $this->renderAlteraSenhaFormando('view', session()->get('idFormando'));
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

    public function viewAlteraSenhaFormando(Request $request)
    {
        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {

                    return $this->renderAlteraSenhaFormando('view', $request->id);
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

    public function alteraSenhaFormando(Request $request)
    {
        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    $formando = $this->objFormando->find($request->id);
                    if (Hash::check($request->senhaAtual, $formando->password)) {
                        try {
                            $formando->update([
                                'password' => bcrypt($request->novaSenha)
                            ]);
                        } catch (Throwable $e) {
                            report($e);
                            dd($e);

                            return false;
                        }
                        session()->put('password', $request->novaSenha);
                        return $this->renderAlteraSenhaFormando('senhaAlterada', $request->id);
                    } else {
                        return $this->renderAlteraSenhaFormando('erroSenha', $request->id);
                    }
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

    public function alteraSenhaFormandoGet(Request $request)
    {
        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    return $this->renderAlteraSenhaFormando('view', session()->get('idFormando'));
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

    public function atualizaFormando(Request $request)
    {

        if (session()->get('email')) {
            $formandoAuth = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formandoAuth->password)) {
                    $formando = $this->objFormando->find($request->idFormando);

                    if ($formando->redes['whatsapp'] != $request->linkWhatsapp) {
                        $validated = $request->validate([
                            'linkWhatsapp' => 'required|min:18',
                        ]);
                    }

                    // $whatsapp = preg_replace("/[^0-9]/", "", $request->linkWhatsapp);
                    // $whatsapp = 'https://api.whatsapp.com/send?phone=' . $whatsapp;

                    // dd($whatsapp);

                    if ($formando->nome != $request->nome) {
                        $validated = $request->validate([
                            'nome' => 'required|min:2',
                        ]);
                    }

                    if ($formando->redes['linkedin'] != $request->linkLinkedin) {
                        $validated = $request->validate([
                            'linkLinkedin' => 'required|min:2',
                        ]);
                    }

                    $objRedes = new stdClass();
                    $objRedes->linkedin = $request->linkLinkedin ? $request->linkLinkedin : '';
                    $objRedes->whatsapp = $request->linkWhatsapp ? $request->linkWhatsapp : '';

                    // dd($objRedes);

                    if ($request->photo != null) {
                        $arrayName = explode('.', time() . $request->photo->getClientOriginalName());
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
                        $request->photo->move(public_path('img/formandos/'), $imageName);
                        $caminhoImagem = '/img/formandos/' . $imageName;

                        try {
                            $formando->update([
                                'nome' => $request->nome,
                                'redes' => $objRedes,
                                'profile_photo_path' => $caminhoImagem
                            ]);
                        } catch (Throwable $e) {
                            report($e);
                            dd($e);

                            return false;
                        }
                    } else {
                        try {
                            $formando->update([
                                'nome' => $request->nome,
                                'redes' => $objRedes,
                            ]);
                        } catch (Throwable $e) {
                            report($e);
                            dd($e);

                            return false;
                        }
                    }
                    return $this->renderAtualizarDadosFormando('alterado', $request->idFormando);
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

    public function atualizaFormandoGet(Request $request)
    {
        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    return $this->renderAtualizarDadosFormando('view', session()->get('idFormando'));
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

    public function sairPainelFormando()
    {
        session()->forget('email');
        session()->forget('password');
        session()->forget('idFormando');

        return $this->renderLoginFormando('view');
    }

    public function downloadCertificadoGet(Request $request)
    {

        if (session()->get('email')) {
            $formando = $this->objFormando->where('email', session()->get('email'))->first();
            if (session()->get('password')) {
                if (Hash::check(session()->get('password'), $formando->password)) {
                    if (session()->get('cursoId')) {
                        if (session()->get('formandoId')) {
                            $curso = $this->objCurso->find(session()->get('cursoId'));
                            $certificado = $this->objCertificado->find($curso->id_certificado);
                            $dataCertificado = $certificado->data;
                            $formando = $this->objFormando->find(session()->get('formandoId'));
                            $bloco_1 = substr($formando->cpf, 0, 3);
                            $bloco_2 = substr($formando->cpf, 3, 3);
                            $bloco_3 = substr($formando->cpf, 6, 3);
                            $dig_verificador = substr($formando->cpf, -2);
                            $cpfFormando = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;

                            $dataCertificado['texto1'] = str_replace('[nome]', $formando->nome, $dataCertificado['texto1']);
                            $dataCertificado['texto1'] = str_replace('[cpf]', $cpfFormando, $dataCertificado['texto1']);
                            $dataCertificado['texto2'] = str_replace('[nome]', $formando->nome, $dataCertificado['texto2']);
                            $dataCertificado['texto2'] = str_replace('[cpf]', $cpfFormando, $dataCertificado['texto2']);

                            $certificado['data'] = $dataCertificado;
                            $hashFormando = null;
                            foreach ($formando->cursos as $cursoFormando) {
                                if ($cursoFormando['idCurso'] == session()->get('cursoId')) {
                                    $hashFormando = $cursoFormando['hashCurso'];
                                }
                            }


                            return Inertia::render('Unis/Externo/PainelFormando/DownloadCertificado', [
                                'curso' => $curso,
                                'certificado' => $certificado,
                                'formando' => $formando,
                                'hashFormando' => $hashFormando,
                                'tokenFont' => config('global.tokens.fontGoogle')
                            ]);
                        }
                    }
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

    public function downloadCertificado(Request $request)
    {
        // dd($request->all());
        $curso = $this->objCurso->find($request->cursoId);
        $certificado = $this->objCertificado->find($curso->id_certificado);
        $dataCertificado = $certificado->data;
        $formando = $this->objFormando->find($request->formandoId);
        $bloco_1 = substr($formando->cpf, 0, 3);
        $bloco_2 = substr($formando->cpf, 3, 3);
        $bloco_3 = substr($formando->cpf, 6, 3);
        $dig_verificador = substr($formando->cpf, -2);
        $cpfFormando = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;

        $dataCertificado['texto1'] = str_replace('[nome]', $formando->nome, $dataCertificado['texto1']);
        $dataCertificado['texto1'] = str_replace('[cpf]', $cpfFormando, $dataCertificado['texto1']);
        $dataCertificado['texto2'] = str_replace('[nome]', $formando->nome, $dataCertificado['texto2']);
        $dataCertificado['texto2'] = str_replace('[cpf]', $cpfFormando, $dataCertificado['texto2']);

        $certificado['data'] = $dataCertificado;
        $hashFormando = null;
        foreach ($formando->cursos as $cursoFormando) {
            if ($cursoFormando['idCurso'] == $request->cursoId) {
                $hashFormando = $cursoFormando['hashCurso'];
            }
        }

        session()->put('cursoId', $request->cursoId);
        session()->put('formandoId', $request->formandoId);


        return Inertia::render('Unis/Externo/PainelFormando/DownloadCertificado', [
            'curso' => $curso,
            'certificado' => $certificado,
            'formando' => $formando,
            'hashFormando' => $hashFormando,
            'tokenFont' => config('global.tokens.fontGoogle')
        ]);
    }
}
