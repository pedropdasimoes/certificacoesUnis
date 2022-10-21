<template>
    <div class="min-w-full min-h-full" style="position: absolute; background-color: #fafafa;">
        <img class="imgInicio" src="/img/certificados/fundoCima.png" alt="">
        <div class="fundo">
            <div class="hidden">
                <font-picker :api-key="tokenFont" id="font-picker-texto1"
                    :options="optionFont1" :active-font="fontFamily1"></font-picker>
                <font-picker :api-key="tokenFont" id="font-picker-texto2"
                    :options="optionFont2" :active-font="fontFamily2"></font-picker>
                <font-picker :api-key="tokenFont" id="font-picker-texto3"
                    :options="optionFont3" :active-font="fontFamily3"></font-picker>
            </div>


            <div class="content">

                <h2 class="nomeCurso">Certificados Unis {{certificado.nome}}</h2>

                <!-- Imagem Certificado -->
                <div :key="keyPai">
                    <h3>
                        Clique no botão para baixar.
                    </h3>
                    <div id="widget" style="max-width: 900px;min-width: 900px" class="hiden">
                        <!-- Fundo -->
                        <div ref="capture" class="certificado">
                            <img :src="imagemCurriculo.fundoPadrao" alt="">
                            <!-- Texto 1 -->
                            <div class="div3" v-bind:style="stylesCapture.styleObjectDiv3Capture">
                                <span class="apply-font-texto1" v-bind:style="stylesCapture.styleObjectDivWeight3"
                                    v-html="texto1"></span>
                            </div>

                            <!-- Texto 2 -->
                            <div id="div4" class="div4" v-bind:style="stylesCapture.styleObjectDiv4">
                                <span class="apply-font-texto2" v-html="texto2"
                                    v-bind:style="stylesCapture.styleObjectDivWeight4"></span>
                            </div>

                            <!-- QrCode -->
                            <div class="div11" v-bind:style="stylesCapture.styleObjectDivQr"
                                style="position:absolute; transform: translate(-50%, -50%);">
                                <QRCanvas v-bind:style="stylesCapture.styleObjectQr" :options="options"></QRCanvas>
                            </div>
                            <span class="apply-font-texto3" v-bind:style="stylesCapture.styleObjectHash"
                                style="position:absolute; transform: translate(-50%, -50%);">{{ key
                                }}</span>
                        </div>
                    </div>
                    <div class="hiden">
                        <div id="certificateView" style="max-width: 900px;min-width: 900px">
                            <div class="certificado">
                                <img :src="imagemCurriculo.fundoPadrao" alt="">
                                <!-- Texto 1 -->
                                <div class="div3" v-bind:style="stylesView.styleObjectDiv3">
                                    <span class="apply-font-texto1" v-bind:style="stylesView.styleObjectDivWeight3"
                                        v-html="texto1"></span>
                                </div>

                                <!-- Texto 2 -->
                                <div id="div4" class="div4" v-bind:style="stylesView.styleObjectDiv4">
                                    <span class="apply-font-texto2" v-html="texto2"
                                        v-bind:style="stylesView.styleObjectDivWeight4"></span>
                                </div>

                                <!-- QrCode -->
                                <div class="div11" v-bind:style="stylesView.styleObjectDivQr"
                                    style="position:absolute; transform: translate(-50%, -50%);">
                                    <QRCanvas v-bind:style="stylesView.styleObjectQr" :options="options"></QRCanvas>
                                </div>
                                <span class="apply-font-texto3" v-bind:style="stylesView.styleObjectHash"
                                    style="position:absolute; transform: translate(-50%, -50%);">{{ key
                                    }}</span>
                            </div>
                        </div>
                    </div>
                </div>


                <template>
                    <button
                        class="button mt-3 mb-3 text-white rounded-xl border-green-500 bg-green-500 hover:text-green-700 hover:bg-green-100 h-10"
                        @click="download">
                        Download Certificado
                    </button>
                </template>
                <a @click="voltar()">
                    <span v-if="spinLoadingVoltar == false">
                        <t-badge class="hover:bg-gray-50 hover:text-gray-700" :radius="8" color="light-gray">Voltar
                        </t-badge>
                    </span>
                    <t-svg :spinLoading="spinLoadingVoltar"> </t-svg>
                </a>
                <img src="https://portal.unis.edu.br/hubfs/Brand%20Center/2020/Grupo%20Unis/Logomarca%20Grupo%20Unis.png?hsLang=pt-br"
                    alt="" style="width:100px;">
            </div>
            <t-modal :radius="3" :show="modalErroSize" color="gradient-red-to-pink" @close="modalErroSize = false"
                :key="componentKeySize">
                <template #content>
                    <div class="
                            flex flex-col
                            justify-center
                            items-center
                            gap-2
                            whitespace-normal
                            ">
                        <font-awesome-icon class="my-2" icon="ban" size="2x" />
                        <b>{{ erroArquivo }}</b>
                        <span>Seu arquivo deve ter o tamanho menor que 64MB</span>
                    </div>
                </template>
            </t-modal>
            <t-modal :radius="3" :show="modalEnviando" :closeModal="closeModalButton" color="solid-white"
                @close="modalEnviando = false" :key="componentKeyEnviando" class="overflow-y-scroll max-h-screen">
                <template #content>
                    <div class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                        <img v-if="!imgFinalizado" src="/img/unis/Hourglass.gif" alt="" />
                        <img v-if="imgFinalizado" src="/img/unis/Check.png" alt="" style="max-width:90px" />
                        <span style="text-align:center">
                            {{mensagemEnviando}}
                        </span>

                        <t-progress :height="4" :value="porcentagem" color="gradient-green-to-green" />
                        <br />
                    </div>
                </template>
            </t-modal>
        </div>
        <img class="imgFim" src="/img/certificados/fundoBaixo.png" alt="" />
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import GridSection from "@/Layouts/GridSection";
import TStatisticWidget from "@/Components/Card/TStatisticWidget";
import TCashIcon from "@/Components/Icon/TCashIcon";
import TShoppingBagIcon from "@/Components/Icon/TShoppingBagIcon";
import TContentCard from "@/Components/Card/TContentCard";
import TList from "@/Components/List/TList";
import TListItem from "@/Components/List/TListItem";
import TAvatar from "@/Components/Avatar/TAvatar";
import TTable from "@/Components/Table/TTable";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import TProgress from "@/Components/Progress/TProgress";
import TAlert from "@/Components/Alert/TAlert";
import TInformationCircleIcon from "@/Components/Icon/TInformationCircleIcon";
import TTrashIcon from "@/Components/Icon/TTrashIcon";
import TCheckCircleIcon from "@/Components/Icon/TCheckCircleIcon";
import TCollapsible from "@/Components/Collapsible/TCollapsible";
import TCollapsibleItem from "@/Components/Collapsible/TCollapsibleItem";
import TButton from "@/Components/Button/TButton";
import SshPre from 'simple-syntax-highlighter'
import 'simple-syntax-highlighter/dist/sshpre.css'
import TLogo from "@/Components/Icon/TLogo";
import TInputGroup from "@/Components/Form/TInputGroup";
import TInputText from "@/Components/Form/Inputs/TInputText";
import TXIcon from "@/Components/Icon/TXIcon";
import TBanIcon from "@/Components/Icon/TBanIcon";
import TModal from "@/Components/Modal/TModal";
import TBadge from "@/Components/Badge/TBadge";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import TFormContent from "@/Components/Form/TFormContent";
import TFormSection from "@/Components/Form/TFormSection";
import TPlusIcon from "@/Components/Icon/TPlusIcon";
import TCheckIcon from "@/Components/Icon/TCheckIcon";
import TInputTextArea from "@/Components/Form/Inputs/TInputTextArea";
import TInputSelect from "@/Components/Form/Inputs/TInputSelect";
import TInputFile from "@/Components/Form/Inputs/TInputFile";
import TInputCheckBox from "@/Components/Form/Inputs/TInputCheckBox";
import TInputRadioButton from "@/Components/Form/Inputs/TInputRadioButton";
import TBellIcon from "@/Components/Icon/TBellIcon";
import TInputMultiSelect from "@/Components/Form/Inputs/TInputMultiSelect";
import TSvg from "@/Components/Svg/TSvg.vue";
import axios from "axios";
import VueHtml2Canvas from 'vue-html2canvas';
import domtoimage from "dom-to-image-more";
import html2canvas from 'html2canvas';
import FontPicker from 'font-picker-vue';
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/antd.css';

const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');


export default {
    props: {
        certificado: Object,
        hashFormando: String,
        formando: Object,
        tokenFont: String
    },
    components: {
        TCheckCircleIcon,
        TTrashIcon,
        TInformationCircleIcon,
        TAlert,
        TProgress,
        TBreadcrumb,
        TTable,
        TAvatar,
        TListItem,
        TList,
        TContentCard,
        TShoppingBagIcon,
        TCashIcon,
        TStatisticWidget,
        GridSection,
        AppLayout,
        Welcome,
        TCollapsible,
        TCollapsibleItem,
        TButton,
        SshPre,
        TLogo,
        TInputGroup,
        TInputText,
        TXIcon,
        TBanIcon,
        TModal,
        TBadge,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetActionMessage,
        JetSecondaryButton,
        TFormContent,
        TFormSection,
        TPlusIcon,
        TCheckIcon,
        TInputTextArea,
        TInputSelect,
        TInputFile,
        TInputCheckBox,
        TInputRadioButton,
        TBellIcon,
        TInputMultiSelect,
        TSvg,
        QRCanvas,
        VueHtml2Canvas,
        domtoimage,
        html2canvas,
        FontPicker,
        VueSlider
    },



    data() {
        return {
            imgFinalizado: false,
            modalEnviando: false,
            componentKeyEnviando: 25,
            closeModalButton: false,
            modalErroSize: false,
            componentKeySize: null,
            erroArquivo: null,
            mensagemEnviando: "Estamos convocando nossos melhores Designers.",
            porcentagem: 0,

            key: '123456',
            values: this.certificado.data.values,
            stylesView: this.certificado.data.styles,
            stylesCapture: this.certificado.data.styles,
            imagemCurriculo: this.certificado.data,

            texto1: null,
            texto2: null,
            fontFamily1: null,
            optionFont1: null,
            fontFamily2: null,
            optionFont2: null,
            fontFamily3: null,
            optionFont3: null,
            options: {
                cellSize: 5,
                data: '',
            },

            loading: false,
            spinLoading: false,
            output: null,
            capturing: false,
            spinLoadingVoltar: false,
            keyPai: 0,

            spinLoadingEnviado: false,
            form: this.$inertia.form({
                _method: "POST",
                cursoId: null,
            }),
        };
    },
    beforeMount() {
        this.atualizaDados();
    },
    methods: {
        atualizaDados() {
            this.texto1 = this.imagemCurriculo.texto1;
            this.texto2 = this.imagemCurriculo.texto2;
            this.fontFamily1 = this.values.fontFamily1Inicial;
            this.optionFont1 = this.values.optionFont1Inicial;
            this.fontFamily2 = this.values.fontFamily2Inicial;
            this.optionFont2 = this.values.optionFont2Inicial;
            this.fontFamily3 = this.values.fontFamily3Inicial;
            this.optionFont3 = this.values.optionFont3Inicial;
            this.optionFont1.limit = 300;
            this.optionFont2.limit = 300;
            this.optionFont3.limit = 300;
            this.key = this.hashFormando;

            this.options.data = window.location.protocol + "//" + window.location.host + "/busca-formando/" + this.hashFormando;


            var porcentDiv3 = parseInt(this.stylesCapture.styleObjectDiv3['top']);
            var styleObjectDiv3Capture = { 'top': (porcentDiv3 - 3) + '%', 'fontSize': this.stylesCapture.styleObjectDiv3['fontSize'], 'left': this.stylesCapture.styleObjectDiv3['left'] };
            this.stylesCapture.styleObjectDiv3Capture = styleObjectDiv3Capture;
            this.keyPai++;

            this.options.data = window.location.protocol + "//" + window.location.host + "/criar-certificado"

        },
        download() {
            var nomeArquivo = this.certificado.nome + '-' + this.formando.nome;
            this.imgFinalizado = false;
            this.mensagemEnviando = 'Estamos convocando nossos melhores Designers.';
            this.porcentagem = 0;
            this.modalEnviando = true;
            setTimeout(() => {
                this.mensagemEnviando = 'Juntando todas as cores.';
                this.porcentagem = 25;
            }, 2000);
            setTimeout(() => {
                this.mensagemEnviando = 'Escrevendo seu nome.';
                this.porcentagem = 50;
            }, 4000);
            setTimeout(() => {
                this.mensagemEnviando = 'Finalizando seu certificado.';
                this.porcentagem = 75;
            }, 6000);

            setTimeout(() => {
                document.getElementById("widget").classList.remove('hiden');
                document.getElementById("certificateView").classList.add('hiden');
                html2canvas(document.getElementById("widget")).then(function (canvas) {
                    var elementCanva = document.body.appendChild(canvas);
                    elementCanva.setAttribute("id", "idCanva");
                    var a = document.createElement('a');
                    // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                    a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                    a.download = nomeArquivo + '.png';
                    a.click();
                });
                document.getElementById("widget").classList.add('hiden');
                document.getElementById("certificateView").classList.remove('hiden');
                this.mensagemEnviando = 'Certificado finalizado.';
                this.porcentagem = 100;
            }, 8000);
            setTimeout(() => {
                document.getElementById("idCanva").remove();
                this.imgFinalizado = true;
                this.closeModalButton = true;
                this.componentKeyEnviando++;
            }, 15000);
        },
        voltar() {
            this.spinLoadingVoltar = true;
            window.location.href = "certificados-painel-formando";
        },

    },

};
</script>

<style scoped>
* {
    box-sizing: border-box;
}

ul,
li,
a {
    outline: none;
    text-decoration: none;
    list-style: none;
}

.hiden {
    display: none;
}

.containerCertificado {
    margin: 16px;
    border: solid 1px rgba(0, 0, 0, 0.5);
    border-radius: 10px;
    --tw-border-opacity: 1;
}

.certificado {
    overflow: hidden;
    position: relative;
}

.certificadoModal {
    overflow: hidden;
    height: 187px;
    width: 300px;
    background-color: #fff;
    background-repeat: no-repeat;
    background-size: contain;
    position: relative;
}

.div1 {
    grid-area: 1 / 1 / 3 / 2;
    display: flex;
    justify-content: center;
    align-items: center;
}

.div2 {
    grid-area: 1 / 7 / 3 / 8;
    display: flex;
    justify-content: center;
    align-items: center;
}

.div3 {
    text-align: center;
    position: absolute;
    transform: translate(-50%, -50%);
    width: 100%;
}

.div4 {
    text-align: center;
    position: absolute;
    transform: translate(-50%, -50%);
    width: 100%;
}

.div5 {
    grid-area: 3 / 1 / 4 / 8;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 24px;
    font-weight: 700;
    margin-top: 20px;
}

.div6 {
    grid-area: 4 / 1 / 5 / 8;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-weight: 600;
}

.div7 {
    grid-area: 5 / 1 / 6 / 8;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 0 30px;
    font-size: 13px;
}

.div8 {
    grid-area: 6 / 1 / 7 / 8;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin-top: -20px;
}

.div9 {
    grid-area: 7 / 1 / 8 / 4;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-direction: column;
    padding-left: 30px;
}

.div10 {
    grid-area: 7 / 5 / 8 / 8;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-direction: column;
    padding-right: 30px;
}


.img1 {
    height: 90px;
    width: 90px;
}

.img2 {
    height: 90px;
    width: 90px;
}

hr {
    width: 100%;
}

.ass1 {
    height: 60px;
    margin-bottom: -15px;
}

.ass2 {
    height: 60px;
    margin-bottom: -15px;
}

.qr {
    height: 95px;
    margin-bottom: 10px;
}

.fundo {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100%;
    margin: auto;
    padding: 5vw 18.5vw;
    height: 100%;
    z-index: 999;
    position: relative;
}

.esquerda {
    height: fit-content;
    width: 35%;
    margin-right: 2vw;
    border-radius: 15px;
    display: flex;
    align-items: center;
    flex-direction: column;
    background: rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.imgAvatar {
    width: 12vw;
    height: 12vw;
    border-radius: 15px;
    margin-top: -45px;
}

.informacaoPessoal {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.titleName {
    margin: 10px 25px;
    font-size: 2vw;
    padding: 4px;
    text-align: center;
    color: #FFF;
    background: rgb(0 98 183 / 90%);
    box-shadow: 0 8px 32px 0 rgb(31 38 135 / 37%);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.redesSociais {
    display: flex;
    margin-bottom: 5px;
}

.btnSocial {
    border: none;
    background-color: transparent;
}

.svgFacebook {
    cursor: pointer;
    fill: rgb(0 98 183 / 90%);
}

.svgLinkedin {
    cursor: pointer;
    fill: rgb(0 98 183 / 90%);
}

.svgFacebook:hover {
    cursor: pointer;
    fill: rgba(0, 29, 53, 0.9);
}

.svgLinkedin:hover {
    cursor: pointer;
    fill: rgba(0, 29, 53, 0.9);
}

.hrEsquerda {
    width: 80%;
    margin-top: 10px;
    background-color: rgb(0 89 162 / 15%);
}

.formacoes {
    width: 100%;
    padding-bottom: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.formacoes h3 {
    margin: 10px 0px;
    font-size: 2.2vw;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
}



.informacaoFaculdade {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 0;
}

.imgUnis {
    width: 10vw;
}


.content {
    height: fit-content;
    width: 100%;
    background-color: #fff;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    min-height: 60vh;
    padding: 8vh 2vw;
    background: rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.titleCurso {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.nomeCurso {
    margin: 8px 0px 2px 0px;
    align-self: center;
    font-size: 3vw;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
    text-align: center;
}

.subtituloCurso {
    margin: 0px 0px 15px 0px;
    align-self: center;
    font-size: 1.5vw;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
    text-align: center;
}

.divInternaTitle {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.hrTitle {
    width: 80%;
    height: 3px;
    background-color: rgb(0 81 255 / 90%);
    border-radius: 5px;
}

.cargaHoraria {
    display: flex;
}

.sobreCurso {
    margin: 15px 0;

}

.titleDireito {
    font-size: 2.2vw;
    margin-bottom: 8px;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
}


.sobreCurso p {
    text-align: justify;
}

.modulos {
    margin-bottom: 25px;
}

.requisito {
    margin-bottom: 25px;
}

.emitido {
    margin-bottom: 25px;
}

.divModulos div:first-child {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.divModulos div:last-child {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.imgInicio {
    width: 50vw;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.imgFim {
    width: 50vw;
    position: absolute;
    bottom: 0;
    right: 0;
    z-index: 1;
}

.botaoEsquerda {
    white-space: normal !important;
    word-wrap: break-word !important;
    height: fit-content !important;
    min-height: 50px !important;
}


.esconde {
    display: none;
}

@media (max-width : 600px) {
    * {
        box-sizing: border-box;
    }



    .esquerda {
        width: 100%;
        margin-bottom: 15px;
    }


    .fundo {
        padding-left: 5.5vw;
        padding-right: 5.5vw;
    }

    .imgAvatar {
        width: 20vw;
        height: 20vw;
    }

    .titleName {
        font-size: 5vw;
        padding: 5px 15px;
    }

    .formacoes h3 {
        font-size: 4.8vw;
    }


    .imgUnis {
        width: 25vw;
    }



    .nomeCurso {
        font-size: 8vw;
    }

    .subtituloCurso {
        margin: 0px 0px 15px 0px;
        align-self: center;
        font-size: 4vw;
        font-weight: 500;
        color: rgb(0 44 82 / 90%);
        text-align: center;
    }


    .titleDireito {
        font-size: 3.8vw;
    }

    .esconde {
        display: none;
    }

}
</style>