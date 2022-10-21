<template>
    <app-layout :actionButtons="true">
        <template #action-buttons>
            <t-button v-if="btnAdd" :link="route('criar-certificados')" :radius="8">
                Adicionar Novo Certificado
            </t-button>
        </template>
        <template #header> Criar Modelo de Certificado </template>
        <template #default>
            <t-form-content :reset-button="false" :submit-button="btnSalvar" :loading="spinLoading" @reset="reset"
                @submitted="save">
                <t-form-section title="Preencha os campos para alterar o certificado.">
                    <!-- Nome Modelo -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Nome Modelo" labelFor="nomeModelo">
                        <t-input-text id="nomeModelo" v-model="nomeModelo" placeholder="Nome Modelo" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.nomeModelo')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Modelo de exemplo -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Modelo base" labelFor="modeloBase">
                        <t-input-select v-model="modeloBase" :clear-button="false" :options="certificados"
                            :search="true" optionsLabelKey="nome" optionsValueKey="id"
                            place-holder="Selecione o Modelo Base" search-place-holder="Pesquise o Modelo Base..." />
                    </t-input-group>

                    <!-- Texto 1 -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Texto 1" labelFor="texto1">
                        <t-input-text-area id="texto1" v-model="texto1" placeholder="Texto 1" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.texto1')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Texto 2 -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Texto 2" labelFor="texto2">
                        <t-input-text-area id="texto2" v-model="texto2" placeholder="Texto 2" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.texto2')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Texto 3 -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Texto 3" labelFor="texto3">
                        <t-input-text-area id="texto3" v-model="texto3" placeholder="Texto 3" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.texto3')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Texto 4 -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Texto 4" labelFor="texto4">
                        <t-input-text-area id="texto4" v-model="texto4" placeholder="Texto 4" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.texto4')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Texto 5 -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Texto 5" labelFor="texto5">
                        <t-input-text-area id="texto5" v-model="texto5" placeholder="Texto 5" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.texto5')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Texto 6 -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Texto 6" labelFor="texto6">
                        <t-input-text-area id="texto6" v-model="texto6" placeholder="Texto 6" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.texto6')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Primeira Assinatura -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Primeira Assinatura" labelFor="assinatura1">
                        <t-input-text-area id="assinatura1" v-model="assinatura1" placeholder="Primeira Assinatura" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.assinatura1')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Segunda Assinatura -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Segunda Assinatura" labelFor="assinatura2">
                        <t-input-text-area id="assinatura2" v-model="assinatura2" placeholder="Segunda Assinatura" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.assinatura2')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Logo 1 -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Logo 1" labelFor="logo1">
                        <div class="inline-flex flex-wrap items-center gap-2" :key="keyRadioLogo1">
                            <t-input-radio-button :checked="radioLogoCheckedSim1" v-model="radioLogo1" :radius="3"
                                color="solid-green" input-value="1" label="Sim">
                                <template #icon>
                                    <t-check-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>

                            <t-input-radio-button :checked="radioLogoCheckedNao1" v-model="radioLogo1" :radius="3"
                                color="solid-red" input-value="2" label="Não">
                                <template #icon>
                                    <t-x-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>
                        </div>
                        <t-input-file v-if="radioLogo1 == 1" ref="inputFile1" @input="inputFunction1()" :preview="false"
                            id="logo1" v-model="form.logo1" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.logo1Padrao')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Logo 2 -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Logo 2" labelFor="logo2">
                        <div class="inline-flex flex-wrap items-center gap-2" :key="keyRadioLogo2">
                            <t-input-radio-button :checked="radioLogoCheckedSim2" v-model="radioLogo2" :radius="3"
                                color="solid-green" input-value="1" label="Sim">
                                <template #icon>
                                    <t-check-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>

                            <t-input-radio-button :checked="radioLogoCheckedNao2" v-model="radioLogo2" :radius="3"
                                color="solid-red" input-value="2" label="Não">
                                <template #icon>
                                    <t-x-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>
                        </div>
                        <t-input-file v-if="radioLogo2 == 1" ref="inputFile2" @input="inputFunction2()" :preview="false"
                            id="logo2" v-model="form.logo2" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.logo2Padrao')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Imagem Assinatura 1 -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Imagem Assinatura 1" labelFor="ass1">
                        <t-input-file ref="inputFileAss1" @input="inputFunctionAss1()" :preview="false" id="ass1"
                            v-model="form.ass1" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.ass1Padrao')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Imagem Assinatura 2 -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Imagem Assinatura 2" labelFor="ass2">
                        <t-input-file ref="inputFileAss2" @input="inputFunctionAss2()" :preview="false" id="ass2"
                            v-model="form.ass2" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.ass2Padrao')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Imagem Fundo -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Imagem Fundo" labelFor="imgFundo">
                        <t-input-file ref="inputFileFundo" @input="inputFunctionFundo()" :preview="false" id="imgFundo"
                            v-model="form.imgFundo" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.fundoPadrao')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                </t-form-section>

                <!-- Imagem Certificado -->
                <div
                    class="mt-5 md:mt-0 md:col-span-2 border rounded-md shadow m-4 flex flex-col items-center justify-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-5 mt-2">
                        Pré visualização
                    </h3>

                    <!-- Fundo -->
                    <div class="certificado" :style="
                        fundoCSS == null
                            ? {
                                backgroundImage: 'url(' + imagemCurriculo.fundoPadrao + ')',
                            }
                            : {
                                backgroundImage: 'url(' + fundoCSS + ')',
                            }
                    ">

                        <!-- Logo 1 -->
                        <div class="div1">
                            <img v-if="logo1html != null && radioLogo1 == 1" class="img1"
                                :src="logo1html | urlGenerator" />
                            <span v-else-if="radioLogo1 == 2" class="img1"></span>
                            <img v-else class="img1" :src="imagemCurriculo.logo1Padrao" />
                        </div>

                        <!-- Logo 2 -->
                        <div class="div2">
                            <img v-if="logo2html != null && radioLogo2 == 1" class="img2"
                                :src="logo2html | urlGenerator" />
                            <span v-else-if="radioLogo2 == 2" class="img2"></span>
                            <img v-else class="img2" :src="imagemCurriculo.logo2Padrao" />
                        </div>

                        <!-- Texto 1 -->
                        <div class="div3">
                            <span v-html="imagemCurriculo.texto1"></span>
                        </div>

                        <!-- Texto 2 -->
                        <div id="div4" class="div4">
                            <span v-html="imagemCurriculo.texto2"></span>
                        </div>

                        <!-- Texto 3 -->
                        <div class="div5">
                            <span v-html="imagemCurriculo.texto3"></span>
                        </div>

                        <!-- Texto 4 -->
                        <div class="div6">
                            <span v-html="imagemCurriculo.texto4"></span>
                        </div>

                        <!-- Texto 5 -->
                        <div class="div7">
                            <span v-html="imagemCurriculo.texto5"></span>
                        </div>

                        <!-- Texto 6 -->
                        <div class="div8">
                            <span v-html="imagemCurriculo.texto6"></span>
                        </div>

                        <!-- Imagem Assinatura 1 -->
                        <div class="div9">
                            <img v-if="ass1html != null" class="ass1" :src="ass1html | urlGenerator" />
                            <img v-else class="ass1" :src="imagemCurriculo.ass1Padrao" />
                            <hr />
                            <span v-html="imagemCurriculo.assinatura1"></span>
                        </div>

                        <!-- Imagem Assinatura 2 -->
                        <div class="div10">
                            <img v-if="ass2html != null" class="ass2" :src="ass2html | urlGenerator" />
                            <img v-else class="ass2" :src="imagemCurriculo.ass2Padrao" />
                            <hr />
                            <span v-html="imagemCurriculo.assinatura2"></span>
                        </div>

                        <!-- QrCode -->
                        <div class="div11"
                            style="display:flex; flex-direction:column; justify-content:center; align-items: center;">
                            <QRCanvas :options="options"></QRCanvas>
                            <span>{{ imagemCurriculo.key }}</span>
                        </div>
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


            <t-modal :radius="3" :show="modalErroTipo" color="gradient-red-to-pink" @close="modalErroTipo = false"
                :key="componentKeyTipo">
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
                        <span>Seu arquivo dever ser do tipo: JPG | JPEG | PNG </span>
                    </div>
                </template>
            </t-modal>
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



const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');

export default {
    props: {
        certificados: Array,
        errors: Object,
        success: String,
        btnSalvar: Boolean,
        btnAdd: Boolean,
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
        TInformationCircleIcon
    },
    data() {
        return {
            keyRadioLogo1: 10,
            keyRadioLogo2: 11,
            radioLogoCheckedSim1: true,
            radioLogoCheckedNao1: true,
            radioLogoCheckedSim2: false,
            radioLogoCheckedNao2: false,
            imagemCurriculo: this.certificados[0].data,
            options: {
                cellSize: 2,
                data: '',
            },
            nomeModelo: null,
            texto1: null,
            texto2: null,
            texto3: null,
            texto4: null,
            texto5: null,
            texto6: null,
            assinatura1: null,
            assinatura2: null,
            dadosCurriculo: [],
            images: {
                logo1: [],
                logo2: [],
                ass1: [],
                ass2: [],
                fundo: [],
            },
            logo1html: null,
            logo2html: null,
            ass1html: null,
            ass2html: null,
            fundoCSS: null,
            radioLogo1: 1,
            radioLogo2: 1,
            modeloBase: 1,

            erroArquivo: null,
            componentKeyTipo: 0,
            componentKeySize: 1,
            modalErroTipo: false,
            modalErroSize: false,
            loading: false,
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                dadosCurriculo: [],
                images: {
                    logo1: [],
                    logo2: [],
                    ass1: [],
                    ass2: [],
                    fundo: [],
                },
            }),
        };
    },
    beforeMount() {
        this.atualizaDados();
    },
    watch: {
        nomeModelo() {
            this.imagemCurriculo.nomeModelo = this.nomeModelo;
        },
        texto1() {
            this.imagemCurriculo.texto1 = this.texto1;
        },
        texto2() {
            this.imagemCurriculo.texto2 = this.texto2;
        },
        texto3() {
            this.imagemCurriculo.texto3 = this.texto3;
        },
        texto4() {
            this.imagemCurriculo.texto4 = this.texto4;
        },
        texto5() {
            this.imagemCurriculo.texto5 = this.texto5;
        },
        texto6() {
            this.imagemCurriculo.texto6 = this.texto6;
        },
        assinatura1() {
            this.imagemCurriculo.assinatura1 = this.assinatura1;
        },
        assinatura2() {
            this.imagemCurriculo.assinatura2 = this.assinatura2;
        },
        modeloBase(e) {
            console.log(e);
            this.certificados.forEach(element => {
                if (element.id == e) {

                    this.imagemCurriculo = element.data;
                }
            });
            console.log(this.certificados[this.modeloBase].data);
        }
    },
    methods: {
        atualizaDados() {
            this.texto1 = this.imagemCurriculo.texto1;
            this.texto2 = this.imagemCurriculo.texto2;
            this.texto3 = this.imagemCurriculo.texto3;
            this.texto4 = this.imagemCurriculo.texto4;
            this.texto5 = this.imagemCurriculo.texto5;
            this.texto6 = this.imagemCurriculo.texto6;
            this.assinatura1 = this.imagemCurriculo.assinatura1;
            this.assinatura2 = this.imagemCurriculo.assinatura2;
            if (this.imagemCurriculo.logo1Padrao == null) {
                this.radioLogo1 = 2;
                this.radioLogoCheckedNao1 = true;
                this.radioLogoCheckedSim1 = false;
            } else {

                this.radioLogoCheckedSim1 = true;
                this.radioLogoCheckedNao1 = false;
            }
            if (this.imagemCurriculo.logo2Padrao == null) {
                this.radioLogo2 = 2;
                this.radioLogoCheckedNao2 = true;
                this.radioLogoCheckedSim2 = false;

            } else {

                this.radioLogoCheckedSim2 = true;
                this.radioLogoCheckedNao2 = false;
            }
            if (this.keyRadioLogo1 > this.keyRadioLogo2) {
                this.keyRadioLogo2 = this.keyRadioLogo1 + 1;
            } else {
                this.keyRadioLogo2 = this.keyRadioLogo2 + 1;
            }
        },
        inputFunction1() {
            if (this.$refs.inputFile1.files.length > 1) {
                this.$refs.inputFile1.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.inputFile1.files[0].type) {
                case "image/jpg":
                    validate = true;
                    break;
                case "image/jpeg":
                    validate = true;
                    break;
                case "image/png":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.inputFile1.files[0].size > 64000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (validate) {
                this.logo1html = null;
                this.form.images.logo1 = [];
                this.logo1html = this.$refs.inputFile1.files[0];
                this.form.images.logo1.push(this.$refs.inputFile1.files[0]);
            } else {
                if (tipoErro == "tipo") {
                    this.$refs.inputFile1.files.splice(0, 1);
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.$refs.inputFile1.files.splice(0, 1);
                    this.modalErroSize = true;
                }
            }

        },

        inputFunction2() {
            if (this.$refs.inputFile2.files.length > 1) {
                this.$refs.inputFile2.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.inputFile2.files[0].type) {
                case "image/jpg":
                    validate = true;
                    break;
                case "image/jpeg":
                    validate = true;
                    break;
                case "image/png":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.inputFile2.files[0].size > 64000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (validate) {
                this.logo2html = null;
                this.form.images.logo2 = [];
                this.logo2html = this.$refs.inputFile2.files[0];
                this.form.images.logo2.push(this.$refs.inputFile2.files[0]);
            } else {
                if (tipoErro == "tipo") {
                    this.$refs.inputFile2.files.splice(0, 1);
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.$refs.inputFile2.files.splice(0, 1);
                    this.modalErroSize = true;
                }
            }

        },

        inputFunctionAss1() {
            if (this.$refs.inputFileAss1.files.length > 1) {
                this.$refs.inputFileAss1.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.inputFileAss1.files[0].type) {
                case "image/jpg":
                    validate = true;
                    break;
                case "image/jpeg":
                    validate = true;
                    break;
                case "image/png":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.inputFileAss1.files[0].size > 64000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (validate) {
                this.ass1html = null;
                this.form.images.ass1 = [];
                this.ass1html = this.$refs.inputFileAss1.files[0];
                this.form.images.ass1.push(this.$refs.inputFileAss1.files[0]);
            } else {
                if (tipoErro == "tipo") {
                    this.$refs.inputFileAss1.files.splice(0, 1);
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.$refs.inputFileAss1.files.splice(0, 1);
                    this.modalErroSize = true;
                }
            }

        },

        inputFunctionAss2() {
            if (this.$refs.inputFileAss2.files.length > 1) {
                this.$refs.inputFileAss2.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.inputFileAss2.files[0].type) {
                case "image/jpg":
                    validate = true;
                    break;
                case "image/jpeg":
                    validate = true;
                    break;
                case "image/png":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.inputFileAss2.files[0].size > 64000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (validate) {
                this.ass2html = null;
                this.form.images.ass2 = [];
                this.ass2html = this.$refs.inputFileAss2.files[0];
                this.form.images.ass2.push(this.$refs.inputFileAss2.files[0]);
            } else {
                if (tipoErro == "tipo") {
                    this.$refs.inputFileAss2.files.splice(0, 1);
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.$refs.inputFileAss2.files.splice(0, 1);
                    this.modalErroSize = true;
                }
            }

        },

        inputFunctionFundo() {
            if (this.$refs.inputFileFundo.files.length > 1) {
                this.$refs.inputFileFundo.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.inputFileFundo.files[0].type) {
                case "image/jpg":
                    validate = true;
                    break;
                case "image/jpeg":
                    validate = true;
                    break;
                case "image/png":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.inputFileFundo.files[0].size > 64000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (validate) {
                this.fundoCSS = null;
                this.form.images.fundo = [];
                this.fundoCSS = URL.createObjectURL(this.$refs.inputFileFundo.files[0]);
                this.form.images.fundo.push(this.$refs.inputFileFundo.files[0]);
            } else {
                if (tipoErro == "tipo") {
                    this.$refs.inputFileFundo.files.splice(0, 1);
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.$refs.inputFileFundo.files.splice(0, 1);
                    this.modalErroSize = true;
                }
            }

        },

        reset: function () {
            this.nomeModelo = null;
        },
        save() {
            console.log(this.imagemCurriculo)
            if (this.radioLogo1 == 2) {
                this.imagemCurriculo.logo1Padrao = null;
            }

            if (this.radioLogo2 == 2) {
                this.imagemCurriculo.logo2Padrao = null;
            }

            this.form.dadosCurriculo = this.imagemCurriculo;

            if (this.success != null) {
                this.success = null;
            }
            this.spinLoading = true;
            this.form.post(route("create-certificados"), {
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
    height: 562px;
    width: 900px;
    background-color: #fff;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    grid-template-rows: repeat(7, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    padding: 45px 65px;
    background-repeat: no-repeat;
    background-size: contain;
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
    grid-area: 1 / 2 / 2 / 7;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    margin-top: 20px;
}

.div4 {
    grid-area: 2 / 2 / 3 / 7;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 13px;
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

.div11 {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    margin-top: -15px;
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