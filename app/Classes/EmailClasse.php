<?php

namespace App\Classes;
use App\Models\User;
use stdClass;
use Illuminate\Support\Facades\Mail;
use App\Jobs\UsuarioCriado;

class EmailClasse
{

    private $objUser;

    public function __construct()
    {
        $this->objUser = new User();
    }

    // public function testeEmail($id)
    // {
    //     $data = new stdClass();
    //     $userData = new stdClass();
    //     $vagaData = new stdClass();

    //     $user = $this->objUser->find($id);
    //     $vaga = $this->objVaga->find($id);
    //     $userData->name = $user->name;
    //     $userData->email = $user->email;

    //     $vagaData->nome = $vaga->cargo;

    //     $data->user = $userData;
    //     $data->vaga = $vagaData;


    //     //Mail::send(new \App\Mail\VagasPendentes($data));
    //     return new \App\Mail\VagaAprovada($data);
    // // dispatch(new VagasPendentes($data))->delay(now()->addSecond(3));
    // // return 'ok';
    // }

    // public function emailPendencias($id)
    // {
    //     $data = new stdClass();
    //     $userData = new stdClass();
    //     $pendencias = array();



    //     $user = $this->objUser->find($id);
    //     $vagaAll = $this->objVaga->all();
    //     foreach ($vagaAll as $vaga) {
    //         if ($vaga->status == 0) {
    //             $nivelVaga = $vaga->user_id;
    //             $nivelVaga = $this->objUser->where('user_id', $nivelVaga)->get();
    //             $nivelVaga = explode('-', $nivelVaga[0]['nivel']);
    //             if (in_array($user->id, $nivelVaga)) {
    //                 $aprovacoesVaga = explode('-', $vaga->aprovacao_gestores);
    //                 if (!in_array($user->id, $aprovacoesVaga)) {
    //                     $pendencias[] = $vaga->cargo;
    //                 }
    //             }
    //         }
    //     }

    //     $userData->name = $user->name;
    //     $userData->email = $user->email;

    //     $data->user = $userData;
    //     $data->pendencias = $pendencias;

    //     dispatch(new VagasPendentes($data))->delay(now()->addSecond(3));
    // }

    public function usuarioCriado($id, $senha)
    {
        //RECEBE ID DO USUARIO UNIS
        $usuario = $this->objUser->find($id);

        $data = new stdClass();
        $contato = new stdClass();

        $contato->name = $usuario->nome;
        $contato->email = $usuario->email;
        $data->contato = $contato;
        $data->senha = $senha;
        dispatch(new UsuarioCriado($data))->delay(now()->addSecond(3));
    }
}