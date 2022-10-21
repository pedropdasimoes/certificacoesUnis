<template>
    <app-layout :actionButtons="true">
        <template #action-buttons>
            <t-button v-if="btnAdd" :link="route('criar-cursos')" :radius="8">
                Adicionar Novo Template de Curso
            </t-button>
            <t-button v-if="btnCertificado" :link="route('criar-certificados')" :radius="8">
                Adicionar Novo Modelo de Certificado
            </t-button>
        </template>
        <template #header> Criar Template de Curso </template>
        <template #default>

            <div class="hidden">
                <font-picker :api-key="tokenFont" id="font-picker-texto1"
                    :options="optionFont1" :active-font="fontFamily1"></font-picker>
                <font-picker :api-key="tokenFont" id="font-picker-texto2"
                    :options="optionFont2" :active-font="fontFamily2"></font-picker>
                <font-picker :api-key="tokenFont" id="font-picker-texto3"
                    :options="optionFont3" :active-font="fontFamily3"></font-picker>
            </div>
            <t-form-content :reset-button="false" :submit-button="btnSalvar" :loading="spinLoading" @reset="reset"
                @submitted="save">
                <t-form-section title="Preencha os campos para alterar o template do curso.">
                    <!-- Código de Referência -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Código de Referência"
                        labelFor="codigoReferencia">
                        <t-input-text id="codigoReferencia" v-model="form.codigoReferencia"
                            placeholder="Código de Referência" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.codigoReferencia')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Nome Curso -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Nome Curso" labelFor="nomeCurso">
                        <t-input-text id="nomeCurso" v-model="form.nomeCurso" placeholder="Nome Curso" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.nomeCurso')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Modelo de exemplo -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Modelo Certificado" labelFor="modeloBase">
                        <t-input-select v-model="modeloBase" :clear-button="false" :options="certificados"
                            :search="true" optionsLabelKey="nome" optionsValueKey="id"
                            place-holder="Selecione o Modelo do Certificado"
                            search-place-holder="Pesquise o Modelo do Certificado..." />
                    </t-input-group>

                    <!-- Titulo Curso -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Titulo Curso" labelFor="tituloCurso">
                        <t-input-text id="tituloCurso" v-model="form.tituloCurso" placeholder="Titulo Curso" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.tituloCurso')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Carga Horária -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Carga Horária" labelFor="cargaHoraria">
                        <t-input-text id="cargaHoraria" v-model="form.cargaHoraria" placeholder="0" type="number" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.cargaHoraria')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Sobre o Curso -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Sobre o Curso" labelFor="sobreCurso">
                        <t-input-text-area id="sobreCurso" v-model="form.sobreCurso" placeholder="Sobre o Curso" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.sobreCurso')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Competências -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Competências" labelFor="competencias">
                        <t-input-text-area id="competencias" v-model="form.competencias" placeholder="Competências" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.competencias')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>
                    <div class="flex flex-col col-span-12">
                        <h3 class="flex flex-row items-center font-medium text-base text-gray-700 whitespace-normal">
                            Módulos</h3>
                        <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                            <div class="col-span-4 mx-2 my-2">
                                <button type="button" @click="addModulo()"
                                    class="button bg-green-500 border-green-500 hover:bg-green-100 hover:text-green-700 text-gray-100 hover:bg-green-100 hover:text-green-700 rounded-md h-8 text-sm min-w-min min-h-min">Adicionar
                                    Módulo</button>
                            </div>
                            <div class="w-full" id="divModulos">
                                <div v-for="(modulo, index) in modulos" :key="modulo.id"
                                    class="flex flex-col col-span-12 p-1.5 my-2 mx-5 border rounded-md shadow ">
                                    <div
                                        class="col-span-12 flex justify-between -mx-2 -mt-2 rounded-t-md items-center py-2.5 px-5 mb-3 bg-blue-200">
                                        <div>
                                            <h3
                                                class="flex flex-row items-center font-medium text-lg text-gray-700 whitespace-normal">
                                                Módulo {{index +1}}</h3>
                                        </div>
                                        <div class="col-span-12 flex justify-end gap-x-4">
                                            <button type="button" v-if="index != 0"
                                                class="button bg-blue-500 border-blue-500 hover:bg-blue-100 hover:text-blue-700 text-gray-100 hover:bg-blue-100 hover:text-blue-700 rounded-md h-8 text-sm min-w-min min-h-min"
                                                @click="upButton(index)">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 487 487"
                                                    style="enable-background:new 0 0 487 487; fill: #fff; width: 15px;"
                                                    xml:space="preserve">
                                                    <g>
                                                        <path
                                                            d="M397.7,376.1c20.4,20.4,53.6,20.4,74,0s20.4-53.6,0-74L280.5,110.9c-20.4-20.4-53.6-20.4-74,0L15.3,302.1 c-20.4,20.4-20.4,53.6,0,74s53.6,20.4,74,0l154.2-154.2L397.7,376.1z" />
                                                    </g>
                                                </svg>
                                            </button>

                                            <button type="button" v-if="index != modulos.length - 1"
                                                class="button bg-blue-500 border-blue-500 hover:bg-blue-100 hover:text-blue-700 text-gray-100 hover:bg-blue-100 hover:text-blue-700 rounded-md h-8 text-sm min-w-min min-h-min"
                                                @click="downButton(index)">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 55.751 55.751"
                                                    style="enable-background:new 0 0 55.751 55.751; fill: #fff; width: 15px;"
                                                    xml:space="preserve">
                                                    <g>
                                                        <path
                                                            d="M31.836,43.006c0.282-0.281,0.518-0.59,0.725-0.912L54.17,20.485c2.107-2.109,2.109-5.528,0-7.638 c-2.109-2.107-5.527-2.109-7.638,0l-18.608,18.61L9.217,12.753c-2.109-2.108-5.527-2.109-7.637,0 C0.527,13.809-0.002,15.19,0,16.571c-0.002,1.382,0.527,2.764,1.582,3.816l21.703,21.706c0.207,0.323,0.445,0.631,0.729,0.913 c1.078,1.078,2.496,1.597,3.91,1.572C29.336,44.604,30.758,44.084,31.836,43.006z" />
                                                    </g>
                                                </svg>
                                            </button>

                                            <button type="button"
                                                class="button bg-blue-500 border-blue-500 hover:bg-blue-100 hover:text-blue-700 text-gray-100 hover:bg-blue-100 hover:text-blue-700 rounded-md h-8 text-sm min-w-min min-h-min"
                                                @click="closeButton(index)">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 1792 1792"
                                                    style="enable-background:new 0 0 1792 1792; fill: #fff; width: 15px;"
                                                    xml:space="preserve">
                                                    <path
                                                        d="M1082.2,896.6l410.2-410c51.5-51.5,51.5-134.6,0-186.1s-134.6-51.5-186.1,0l-410.2,410L486,300.4 c-51.5-51.5-134.6-51.5-186.1,0s-51.5,134.6,0,186.1l410.2,410l-410.2,410c-51.5,51.5-51.5,134.6,0,186.1 c51.6,51.5,135,51.5,186.1,0l410.2-410l410.2,410c51.5,51.5,134.6,51.5,186.1,0c51.1-51.5,51.1-134.6-0.5-186.2L1082.2,896.6z" />
                                                </svg>
                                            </button>

                                        </div>
                                    </div>
                                    <!-- Titulo Módulo -->
                                    <t-input-group class="col-span-12 md:col-span-6 mb-3" label="Titulo Módulo"
                                        labelFor="tituloModulo">
                                        <t-input-text id="tituloModulo" v-model="modulo.titulo"
                                            placeholder="Titulo Módulo" />
                                        <div v-for="errors in errors.customer" :key="errors.id">
                                            <t-alert v-if="errors.includes('dadosCurriculo.tituloModulo')"
                                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red"
                                                :closeable="true" :radius="5">
                                                <b>
                                                    {{ errors }}
                                                </b>
                                            </t-alert>
                                        </div>
                                    </t-input-group>
                                    <!-- Sobre o Módulo -->
                                    <t-input-group class="col-span-12 md:col-span-6" label="Sobre o Módulo"
                                        labelFor="sobreModulo">
                                        <t-input-text-area id="sobreModulo" v-model="modulo.sobre"
                                            placeholder="Sobre o Módulo" />
                                        <div v-for="errors in errors.customer" :key="errors.id">
                                            <t-alert v-if="errors.includes('dadosCurriculo.sobreModulo')"
                                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red"
                                                :closeable="true" :radius="5">
                                                <b>
                                                    {{ errors }}
                                                </b>
                                            </t-alert>
                                        </div>
                                    </t-input-group>
                                </div>
                            </div>
                        </div>
                    </div>


                </t-form-section>

                <!-- Imagem Certificado -->
                <div
                    class="mt-5 md:mt-0 md:col-span-2 border rounded-md shadow m-4 flex flex-col items-center justify-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-5 mt-2">
                        Pré visualização
                    </h3>

                    <!-- Fundo -->
                    <div :key="keyPai" class="certificado" :style="
                    fundoCSS == null
                    ? {
                    backgroundImage: 'url(' + imagemCurriculo.fundoPadrao + ')',
                    }
                    : {
                    backgroundImage: 'url(' + fundoCSS + ')',
                    }
                    ">
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
                <div class="mx-8" v-if="success">
                    <!-- Mensagem de Sucesso -->
                    <t-alert class="!m-auto !w-4/5 col-span-4" color="solid-green" :closeable="true" :radius="5">
                        <b>{{ success }}</b>
                    </t-alert>
                </div>

                <div class="mx-8" v-if="errors.customer">
                    <!-- Mensagem de Sucesso -->
                    <t-alert class="!m-auto !w-4/5 col-span-4" color="solid-red" :closeable="true" :radius="5">
                        <b>Algum item está com erro</b>
                    </t-alert>
                </div>
            </t-form-content>



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
import TInputMultiSelect from "@/Components/Form/Inputs/TInputMultiSelect";
import TXIcon from "@/Components/Icon/TXIcon";
import TBanIcon from "@/Components/Icon/TBanIcon";
import TTable from "@/Components/Table/TTable";
import TModal from "@/Components/Modal/TModal";
import TInformationCircleIcon from "@/Components/Icon/TInformationCircleIcon";
import FontPicker from 'font-picker-vue';



const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');

export default {
    props: {
        certificados: Array,
        errors: Object,
        success: String,
        btnSalvar: Boolean,
        btnAdd: Boolean,
        btnCertificado: Boolean,
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
        TInputMultiSelect,
        QRCanvas,
        TXIcon,
        TBanIcon,
        TTable,
        TModal,
        TInformationCircleIcon,
        FontPicker
    },
    data() {
        return {
            keyPai: 0,
            modulos: [
                { titulo: 'Título Modulo 1', sobre: 'Esse campo é falando sobre o Modulo 1' },
                { titulo: 'Título Modulo 2', sobre: 'Esse campo é falando sobre o Modulo 2' },
                { titulo: 'Título Modulo 3', sobre: 'Esse campo é falando sobre o Modulo 3' },
            ],
            codigoReferencia: null,
            nomeCurso: null,
            tituloCurso: null,
            cargaHoraria: null,
            sobreCurso: null,
            competencias: null,

            values: this.certificados[0].data.values,
            styles: this.certificados[0].data.styles,
            imagemCurriculo: this.certificados[0].data,
            idCurriculo: this.certificados[0].id,
            options: {
                cellSize: 5,
                data: '',
            },
            modeloBase: 1,
            texto1: null,
            texto2: null,
            fundoCSS: null,




            fontFamily1: null,
            optionFont1: null,
            fontFamily2: null,
            optionFont2: null,
            fontFamily3: null,
            optionFont3: null,





            loading: false,
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                codigoReferencia: null,
                nomeCurso: null,
                tituloCurso: null,
                cargaHoraria: null,
                sobreCurso: null,
                competencias: null,
                idCurriculo: null,
                modulos: []
            }),
        };
    },
    beforeMount() {
        this.atualizaDados();
    },
    watch: {
        modeloBase(e) {
            this.certificados.forEach(element => {
                if (element.id == e) {
                    this.values = element.data.values;
                    this.styles = element.data.styles;
                    this.imagemCurriculo = element.data;
                    this.idCurriculo = element.id;
                    this.atualizaDados();
                }
            });
        }
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

            this.valueSliderV1 = this.values.valueSliderV1Inicial;
            this.valueSliderH1 = this.values.valueSliderH1Inicial;
            this.fontSizeSlider1 = this.values.fontSizeSlider1Inicial;
            this.fontWeightSlider1 = this.values.fontWeightSlider1Inicial;
            this.valueSliderV2 = this.values.valueSliderV2Inicial;
            this.valueSliderH2 = this.values.valueSliderH2Inicial;
            this.fontSizeSlider2 = this.values.fontSizeSlider2Inicial;
            this.fontWeightSlider2 = this.values.fontWeightSlider2Inicial;
            this.valueSliderV3 = this.values.valueSliderV3Inicial;
            this.valueSliderH3 = this.values.valueSliderH3Inicial;
            this.fontSizeSlider3 = this.values.fontSizeSlider3Inicial;
            this.valueSliderV4 = this.values.valueSliderV4Inicial;
            this.valueSliderH4 = this.values.valueSliderH4Inicial;
            this.fontSizeSlider4 = this.values.fontSizeSlider4Inicial;
            this.fontWeightSlider4 = this.values.fontWeightSlider4Inicial;
            this.keyPai++;

            this.options.data = window.location.protocol + "//" + window.location.host + "/criar-certificado"

        },
        hideModulos: function () {
            var incrementMinum = 0.045;
            var opacityMinum = 1;
            var instanceMinum = window.setInterval(function () {
                document.getElementById('divModulos').style.opacity = opacityMinum
                opacityMinum = opacityMinum - incrementMinum;
                if (opacityMinum < 0.2) {
                    window.clearInterval(instanceMinum);
                    var incrementPlus = 0.045;
                    var opacityPlus = 0.2;
                    var instancePlus = window.setInterval(function () {
                        document.getElementById('divModulos').style.opacity = opacityPlus
                        opacityPlus = opacityPlus + incrementPlus;
                        if (opacityPlus > 1) {
                            window.clearInterval(instancePlus);
                        }
                    }, 25)
                }
            }, 25)
        },
        addModulo: function () {
            this.hideModulos();
            setTimeout(() => {
                const newModulo = {
                    titulo: '',
                    sobre: ''
                };
                this.modulos.push(newModulo);
            }, 500)
        },
        upButton(index) {
            this.hideModulos();
            setTimeout(() => {
                var item = this.modulos.splice(index, 1);

                this.modulos.splice(index - 1, 0, item[0]);
            }, 500)
        },
        downButton(index) {
            this.hideModulos();
            setTimeout(() => {
                var item = this.modulos.splice(index, 1);

                this.modulos.splice(index + 1, 0, item[0]);
            }, 500)
        },
        closeButton(index) {
            this.hideModulos();
            setTimeout(() => {
                var item = this.modulos.splice(index, 1);
            }, 500)
        },

        reset: function () {
            this.nomeModelo = null;
        },
        save() {
            this.form.idCurriculo = this.idCurriculo;
            this.form.modulos = this.modulos;

            if (this.success != null) {
                this.success = null;
            }
            this.spinLoading = true;
            this.form.post(route("create-cursos"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (this.spinLoading = false),
                onError: () => (this.spinLoading = false),
            });
            this.loading = true;
        },
    },
    filters: {
        urlGenerator(value) {
            return URL.createObjectURL(value);
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
    height: 562px;
    width: 900px;
    background-color: #fff;
    background-repeat: no-repeat;
    background-size: contain;
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