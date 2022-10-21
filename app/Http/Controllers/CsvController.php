<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Formando;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use stdClass;
use Throwable;

class CsvController extends Controller
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

    public function renderAddCsv($solicitante)
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            if ($solicitante == 'view') {
                return Inertia::render('Unis/Admin/Csv/Adicionar', [
                    'btnSalvar' => true
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function renderCsv()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            return $this->renderAddCsv('view');
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
    public function createCsv(Request $request)
    {
        $formandos = $this->objFormando->all();
        $arrayBadge = array();
        foreach ($formandos as $formando) {
            foreach ($formando->badges as $badge) {
                $arrayBadge[] = $badge;
            }
        }

        $cpf = preg_replace("/[^0-9]/", "", $request->cpf);

        $verificaFormando = $this->objFormando->where('cpf', $cpf)->first();
        $verficaInformacoes = true;
        $request->dataEmissao = str_replace('/', '-', $request->dataEmissao);
        trim(htmlspecialchars($request->nome));
        trim(htmlspecialchars($request->cpf));
        trim(htmlspecialchars($request->email));
        trim(htmlspecialchars($request->referencia));
        trim(htmlspecialchars($request->melhorFormando));
        trim(htmlspecialchars($request->dataEmissao));

        if (strlen($request->nome) < 2) {
            $verficaInformacoes = false;
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois o nome deve ser maior que 2 caracteres.'];
        }
        if (strlen($request->cpf) < 11) {
            $verficaInformacoes = false;
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois o CPF está incorreto.'];
        }
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $verficaInformacoes = false;
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois o email está incorreto.'];
        }
        if (strlen($request->referencia) < 2) {
            $verficaInformacoes = false;
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois a referência deve ser maior que 2 caracteres.'];
        }

        $radioSim = false;
        $radioNao = false;
        if (intval($request->melhorFormando) == 0 || intval($request->melhorFormando) == 1) {
            if (intval($request->melhorFormando) == 0) {
                $radioNao = true;
            } else {
                $radioSim = true;
            }
        } else {
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois o campo melhor formando deve ser 1 para Sim e 0 para Não.'];
        }

        if (strtotime('now') < strtotime($request->dataEmissao)) {
            $verficaInformacoes = false;
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois a data de emissão deve ser menor que a de hoje.'];
        }

        $cursoSelecionado = $this->objCurso->where('referencia', $request->referencia)->first();

        if ($cursoSelecionado == null) {
            $verficaInformacoes = false;
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado pois a referência do curso está errada.'];
        }

        $request->dataEmissao = date('Y-m-d', strtotime($request->dataEmissao));

        if (!$verficaInformacoes) {
            return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" contém erro em algum dado.'];
        }
        if ($verificaFormando == null) {


            $hash = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            $hashLength = strlen($hash);
            $randomHash = '';
            for ($i = 0; $i < 12; $i++) {
                $randomHash .= $hash[rand(0, $hashLength - 1)];
            }
            if (in_array($randomHash, $arrayBadge)) {
                while (in_array($randomHash, $arrayBadge)) {
                    $randomHash = '';
                    for ($i = 0; $i < 12; $i++) {
                        $randomHash .= $hash[rand(0, $hashLength - 1)];
                    }
                }
            }

            $informacoesCurso = new stdClass();
            $informacoesCurso->nome = $cursoSelecionado['nome'];
            $informacoesCurso->radioSim = $radioSim;
            $informacoesCurso->radioNao = $radioNao;
            $informacoesCurso->idCurso = $cursoSelecionado->id;
            $informacoesCurso->hashCurso = $randomHash;
            $informacoesCurso->dataEmissao = $request->dataEmissao;

            try {
                $cadastro = $this->objFormando->create([
                    'nome' => $request->nome,
                    'cpf' => $cpf,
                    'email' => $request->email,
                    'cursos' => [$informacoesCurso],
                    'redes' => ['linkedin' => '', 'whatsapp' => ''],
                    'badges' => [$randomHash],
                    'password' => bcrypt($cpf)
                ]);
            } catch (Throwable $e) {
                report($e);
                // dd($e);

                return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado por erro no banco.'];
            }
        } else {
            $cursos = $verificaFormando->cursos;
            $badges = $verificaFormando->badges;
            foreach ($cursos as $curso) {
                if ($curso['idCurso'] == $cursoSelecionado->id) {
                    return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" já possui esse curso registrado.'];
                }
            }

            $hash = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            $hashLength = strlen($hash);
            $randomHash = '';
            for ($i = 0; $i < 12; $i++) {
                $randomHash .= $hash[rand(0, $hashLength - 1)];
            }
            if (in_array($randomHash, $arrayBadge)) {
                while (in_array($randomHash, $arrayBadge)) {
                    $randomHash = '';
                    for ($i = 0; $i < 12; $i++) {
                        $randomHash .= $hash[rand(0, $hashLength - 1)];
                    }
                }
            }

            $informacoesCurso = array();
            $informacoesCurso['nome'] = $cursoSelecionado['nome'];
            $informacoesCurso['radioSim'] = $radioSim;
            $informacoesCurso['radioNao'] = $radioNao;
            $informacoesCurso['idCurso'] = $cursoSelecionado->id;
            $informacoesCurso['hashCurso'] = $randomHash;
            $informacoesCurso['dataEmissao'] = $request->dataEmissao;

            $cursos[] = $informacoesCurso;
            $badges[] = $randomHash;


            try {
                $verificaFormando->update([
                    'nome' => $request->nome,
                    'cpf' => $cpf,
                    'email' => $request->email,
                    'cursos' => $cursos,
                    'badges' => $badges
                ]);
            } catch (Throwable $e) {
                report($e);
                // dd($e);

                return ['status' => false, 'message' => "Curso já cadastrado", 'erro' => 'O formando: "' . $request->nome . '" não foi cadastrado por erro no banco.'];
            }
        }

        return ['status' => true, 'message' => 'Formando cadastrado com sucesso!'];
    }

    public function downloadExemploCsv()
    {
        $userAuth = auth()->user();
        if ($userAuth) {
            $file = public_path() . "/csv/csvExemplo.csv";

            $headers = array(
                'Content-Type: text/csv',
            );

            return Response::download($file, 'exemploCsv.csv', $headers);
        } else {
            return Inertia::render('Unis/Erro/Permissao');
        }
    }
}
