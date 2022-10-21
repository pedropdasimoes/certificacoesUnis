<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use App\Models\Certificado;

class UserSeeder extends Seeder
{
    private $objCertificados;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->objCertificados = new Certificado();

        /*Admin*/
        tap(User::create([
            'name' => 'Super Admin',
            'title' => 'Admin',
            'email' => 'admin@certificados.com.br',
            'password' => bcrypt('admin'),
        ]), function (User $user) {
            (new CreateNewUser())->createTeam($user);
        });

        tap(User::create([
            'name' => 'Super Desenvolvedor',
            'title' => 'Desenvolvedor',
            'email' => 'developer@certificados.com.br',
            'password' => bcrypt('developer'),
        ]), function (User $user) {
            (new CreateNewUser())->createTeam($user);
        });

        $cadastro = $this->objCertificados->create([
            'nome' => 'Modelo Base',
            'data' =>
            [
                "styles" => [
                    "styleObjectDiv3" => [
                        "top" => "50%",
                        "left" => "50%",
                        "fontSize" => "13px"
                    ],
                    "styleObjectDiv3Modal" => [
                        "top" => "50%",
                        "left" => "50%",
                        "fontSize" => "4.333333333333333px"
                    ],
                    "styleObjectDivWeight3" => [
                        "fontWeight" => 100
                    ],
                    "styleObjectDiv4" => [
                        "top" => "50%",
                        "left" => "50%",
                        "fontSize" => "13px"
                    ],
                    "styleObjectDiv4Modal" => [
                        "top" => "50%",
                        "left" => "50%",
                        "fontSize" => "4.333333333333333px"
                    ],
                    "styleObjectDivWeight4" => [
                        "fontWeight" => 100
                    ],
                    "styleObjectDivQr" => [
                        "top" => "50%",
                        "left" => "50%"
                    ],
                    "styleObjectDivQrModal" => [
                        "top" => "50%",
                        "left" => "50%"
                    ],
                    "styleObjectQr" => [
                        "width" => "13px"
                    ],
                    "styleObjectQrModal" => [
                        "width" => "4.333333333333333px"
                    ],
                    "styleObjectHash" => [
                        "top" => "50%",
                        "left" => "50%",
                        "fontSize" => "13px",
                        "fontWeight" => 100
                    ],
                    "styleObjectHashModal" => [
                        "top" => "50%",
                        "left" => "50%",
                        "fontSize" => "4.333333333333333px",
                        "fontWeight" => 100
                    ]
                ],
                "values" => [
                    "fontFamily1Inicial" => "Open Sans",
                    "optionFont1Inicial" => [
                        "name" => "texto1",
                        "variants" => [
                            "regular"
                        ],
                        "sort" => "alphabetical",
                        "limit" => 300
                    ],
                    "fontFamily2Inicial" => "Open Sans",
                    "optionFont2Inicial" => [
                        "name" => "texto2",
                        "variants" => [
                            "regular"
                        ],
                        "sort" => "alphabetical",
                        "limit" => 300
                    ],
                    "fontFamily3Inicial" => "Open Sans",
                    "optionFont3Inicial" => [
                        "name" => "texto3",
                        "variants" => [
                            "regular"
                        ],
                        "sort" => "alphabetical",
                        "limit" => 300
                    ],
                    "valueSliderV1Inicial" => 50,
                    "valueSliderH1Inicial" => 50,
                    "fontSizeSlider1Inicial" => 13,
                    "fontWeightSlider1Inicial" => 100,
                    "valueSliderV2Inicial" => 50,
                    "valueSliderH2Inicial" => 50,
                    "fontSizeSlider2Inicial" => 13,
                    "fontWeightSlider2Inicial" => 100,
                    "valueSliderV3Inicial" => 50,
                    "valueSliderH3Inicial" => 50,
                    "fontSizeSlider3Inicial" => 13,
                    "fontWeightSlider3Inicial" => 100,
                    "valueSliderV4Inicial" => 50,
                    "valueSliderH4Inicial" => 50,
                    "fontSizeSlider4Inicial" => 13,
                    "fontWeightSlider4Inicial" => 100
                ],
                "texto1" => "CENTRO UNIVERSITÁRIO DO SUL DE MINAS",
                "texto2" => "Mantido pela Fundação de Ensino e Pesquisa do Sul de Minas-Fepesmig <br/>\r\nCriada pela Lei Estadual nº 2.766/63 e alterada pela lei Estadual nº 8.496/65.\r\n<br/><br/>\r\nCredenciado pelo Decreto Estadual nº 41.372, de 21/11/2000 e <br/>\r\nrecredenciado pela portaria do MEC nº 29, de 16/01/2018 <br/>",
                "nomeModelo" => "Modelo Base",
                "key" => "HASH12345KEY",
                "fundoPadrao" => "/img/certificados/certificado3.png"
            ]

        ]);
    }
}
