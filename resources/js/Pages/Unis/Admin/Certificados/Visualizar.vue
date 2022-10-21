<template>
    <app-layout :actionButtons="true">
        <template #header> Certitifcado {{ certificado.nome }} </template>
        <template #default>
            <!-- Imagem Certificado -->
            <div
                class="mt-5 py-8 md:mt-0 md:col-span-2 border rounded-md shadow m-4 flex flex-col items-center justify-center">

                <!-- Imagem Certificado -->
                <div
                    class="mt-5 md:mt-0 md:col-span-2 border rounded-md shadow m-4 flex flex-col items-center justify-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-5 mt-2">
                        Pré visualização
                    </h3>
                    <div class="hidden">
                        <font-picker :api-key="tokenFont" id="font-picker-texto1"
                            :options="optionFont1" :active-font="fontFamily1"></font-picker>
                        <font-picker :api-key="tokenFont" id="font-picker-texto2"
                            :options="optionFont2" :active-font="fontFamily2"></font-picker>
                        <font-picker :api-key="tokenFont" id="font-picker-texto3"
                            :options="optionFont3" :active-font="fontFamily3"></font-picker>
                    </div>
                    <div id="widget" style="max-width: 900px">
                        <!-- Fundo -->
                        <div ref="capture" class="certificado">
                            <img :src="imagemCurriculo.fundoPadrao" alt="">
                            <!-- Texto 1 -->
                            <div class="div3" v-bind:style="styles.styleObjectDiv3">
                                <span class="apply-font-texto1" v-bind:style="styles.styleObjectDivWeight3"
                                    v-html="imagemCurriculo.texto1"></span>
                            </div>

                            <!-- Texto 2 -->
                            <div id="div4" class="div4" v-bind:style="styles.styleObjectDiv4">
                                <span class="apply-font-texto2" v-html="imagemCurriculo.texto2"
                                    v-bind:style="styles.styleObjectDivWeight4"></span>
                            </div>

                            <!-- QrCode -->
                            <div class="div11" v-bind:style="styles.styleObjectDivQr"
                                style="position:absolute; transform: translate(-50%, -50%);">
                                <QRCanvas v-bind:style="styles.styleObjectQr" :options="options"></QRCanvas>
                            </div>
                            <span class="apply-font-texto3" v-bind:style="styles.styleObjectHash"
                                style="position:absolute; transform: translate(-50%, -50%);">{{ imagemCurriculo.key
                                }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <template>
                <button
                    class="button mt-3 text-white rounded-xl border-blue-500 bg-blue-500 hover:text-blue-700 hover:bg-blue-100 h-10"
                    @click="backView">
                    Voltar
                </button>
            </template>
            <div id="img-out">

            </div>
        </template>
    </app-layout>
</template>



<script>
import AppLayout from "@/Layouts/AppLayout";
import TButton from "@/Components/Button/TButton";
import TFormSection from "@/Components/Form/TFormSection";
import TFormContent from "@/Components/Form/TFormContent";
import TInputGroup from "@/Components/Form/TInputGroup";
import TInputText from "@/Components/Form/Inputs/TInputText";
import TInputTextArea from "@/Components/Form/Inputs/TInputTextArea";
import SshPre from "simple-syntax-highlighter";
import "simple-syntax-highlighter/dist/sshpre.css";
import TInputSelect from "@/Components/Form/Inputs/TInputSelect";
import TBadge from "@/Components/Badge/TBadge";
import TInputFile from "@/Components/Form/Inputs/TInputFile";
import TInputCheckBox from "@/Components/Form/Inputs/TInputCheckBox";
import TInputRadioButton from "@/Components/Form/Inputs/TInputRadioButton";
import TBellIcon from "@/Components/Icon/TBellIcon";
import TCheckIcon from "@/Components/Icon/TCheckIcon";
import TAlert from "@/Components/Alert/TAlert";
import TList from "@/Components/List/TList";
import TListItem from "@/Components/List/TListItem";
import TAvatar from "@/Components/Avatar/TAvatar";
import VueHtml2Canvas from 'vue-html2canvas';
import domtoimage from "dom-to-image-more";
import html2canvas from 'html2canvas';

const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');

export default {
    props: {
        certificado: Object,
        tokenFont: String
    },
    name: "FormStructure",
    components: {
        TBadge,
        TInputSelect,
        AppLayout,
        TButton,
        TFormSection,
        TFormContent,
        TInputGroup,
        TInputText,
        TInputTextArea,
        SshPre,
        TInputFile,
        TInputCheckBox,
        TInputRadioButton,
        TBellIcon,
        TCheckIcon,
        TAlert,
        TListItem,
        TList,
        TBadge,
        TAvatar,
        QRCanvas,
        VueHtml2Canvas,
        domtoimage,
        html2canvas
    },
    data() {
        return {

            output: null,
            values: this.certificado.data.values,
            styles: this.certificado.data.styles,
            imagemCurriculo: this.certificado.data,
            capturing: false,

            
            fontFamily1: null,
            optionFont1: null,
            fontFamily2: null,
            optionFont2: null,
            fontFamily3: null,
            optionFont3: null,

            options: {
                cellSize: 2,
                data: '',
            },
        };
    },
    mounted() {
        // this.download();
    },
    beforeMount() {
        this.atualizaDados();
    },
    methods: {
        atualizaDados() {
            this.fontFamily1 = this.values.fontFamily1Inicial;
            this.optionFont1 = this.values.optionFont1Inicial;
            this.fontFamily2 = this.values.fontFamily2Inicial;
            this.optionFont2 = this.values.optionFont2Inicial;
            this.fontFamily3 = this.values.fontFamily3Inicial;
            this.optionFont3 = this.values.optionFont3Inicial;
            this.optionFont1.limit = 300;
            this.optionFont2.limit = 300;
            this.optionFont3.limit = 300;

            this.options.data = window.location.protocol + "//" + window.location.host + "/criar-certificado"

        },
        onCapture() {
            this.capturing = true;
            const capture = this.$refs.capture;

            domtoimage
                .toPng(capture)
                .then((dataUrl) => {
                    // this.setImage(dataUrl);
                    console.log(dataUrl);
                    this.capturing = false;
                    var img = new Image();
                    img.src = dataUrl;
                    document.body.appendChild(img);
                })
                .catch((error) => {
                    this.capturing = false;
                    console.error("oops, something went wrong!", error);
                });

        },
        // async download() {
        //     domtoimage.toBlob(document.getElementById("myPNG")).then(function (blob) {
        //         const fileURL = window.URL.createObjectURL(blob);
        //         var filelink = document.createElement("a");
        //         filelink.href = fileURL;
        //         filelink.setAttribute(
        //             "download",
        //             `teste.png`
        //         );
        //         document.body.appendChild(filelink);
        //         filelink.click();
        //     });

        // },

        download() {
            html2canvas(document.getElementById("widget")).then(function (canvas) {
                document.body.appendChild(canvas);
                var a = document.createElement('a');
                // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                a.download = 'somefilename.jpg';
                a.click();
            });
        },
        backView() {
            history.back();
        },
    },
};
</script>

<style scoped>
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
</style>