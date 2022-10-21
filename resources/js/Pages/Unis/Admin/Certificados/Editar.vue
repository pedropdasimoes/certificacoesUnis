<template>
    <app-layout :actionButtons="true" @fim="(i) => controlFim = i">
        <template #action-buttons>
            <t-button v-if="btnAdd" :link="route('criar-certificados')" :radius="8">
                Adicionar Novo Certificado
            </t-button>
        </template>
        <template #header> Editar Certificado</template>
        <template #default>
            <t-form-content :reset-button="false" :submit-button="btnSalvar" :loading="spinLoading" @reset="reset"
                @submitted="save">
                <t-form-section title="Preencha os campos para alterar o certificado.">
                    <input type="hidden" id="id" v-model="form.id" />
                    <!-- Nome Modelo -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Nome Modelo" labelFor="nomeModelo">
                        <t-input-text id="nomeModelo" v-model="nomeModelo" placeholder="Nome Modelo" />
                        <t-alert v-if="errors.customer && errors.customer.nomeModel"
                            class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                            :radius="5">
                            <b>{{ errors.customer.nomeModel }}</b>
                        </t-alert>
                    </t-input-group>

                    <!-- Modelo de exemplo -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Modelo base" labelFor="modeloBase">
                        <t-input-select v-model="modeloBase" :clear-button="false" :options="certificados"
                            :search="true" optionsLabelKey="nome" optionsValueKey="id"
                            place-holder="Selecione o Modelo Base" search-place-holder="Pesquise o Modelo Base..." />
                    </t-input-group>

                    <!-- Texto 1 -->
                    <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                        <t-input-group class="col-span-12 md:col-span-6" label="Texto 1" labelFor="texto1">
                            <t-input-text-area id="texto1" v-model="texto1" placeholder="Texto 1" />
                            <t-alert v-if="errors.customer && errors.customer.texto1"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>{{ errors.customer.texto1 }}</b>
                            </t-alert>
                            <!-- Fonte -->
                            <t-input-group class="col-span-12 md:col-span-6" label="Fonte" labelFor="font">
                                <div class="px-8 mb-6 z-10">
                                    <font-picker :api-key="tokenFont"
                                        id="font-picker-texto1" :options="optionFont1" :active-font="fontFamily1"
                                        @change="changeFont1"></font-picker>
                                </div>
                            </t-input-group>
                            <!-- Posição Vertical 1 -->
                            <t-input-group class="col-span-12 md:col-span-6" label="Posição Vertical"
                                labelFor="sliderV1">
                                <div class="px-8 mb-6">
                                    <vue-slider ref="slider" :interval="0.2" v-model="valueSliderV1"
                                        :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                                </div>
                            </t-input-group>
                            <!-- Posição Horizontal 1 -->
                            <t-input-group class="col-span-12 md:col-span-6" label="Posição Horizontal"
                                labelFor="sliderH1">
                                <div class="px-8 mb-6">
                                    <vue-slider ref="slider" :interval="0.2" v-model="valueSliderH1"
                                        :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                                </div>
                            </t-input-group>
                            <!-- Tamanho da Fonte 1 -->
                            <t-input-group class="col-span-12 md:col-span-6" label="Tamanho da Fonte"
                                labelFor="fontSizeSlider1">
                                <div class="px-8 mb-6">
                                    <vue-slider ref="slider" v-model="fontSizeSlider1" :min="0" :max="50"
                                        :tooltip-formatter="formatterPx" :marks="marksFontSize"></vue-slider>
                                </div>
                            </t-input-group>
                            <!-- Espessura da Fonte 1 -->
                            <t-input-group class="col-span-12 md:col-span-6" label="Espessura da Fonte"
                                labelFor="fontWeightSlider1">
                                <div class="px-8 mb-6">
                                    <vue-slider ref="slider" v-model="fontWeightSlider1" :data="dataWeight"
                                        :marks="true">
                                    </vue-slider>
                                </div>
                            </t-input-group>
                        </t-input-group>
                    </div>

                    <!-- Texto 2 -->
                    <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                        <t-input-group class="col-span-12 md:col-span-6 mb-2" label="Texto 2" labelFor="texto2">
                            <t-input-text-area id="texto2" v-model="texto2" placeholder="Texto 2" />
                            <t-alert v-if="errors.customer && errors.customer.texto2"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>{{ errors.customer.texto2 }}</b>
                            </t-alert>
                        </t-input-group>
                        <!-- Fonte -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Fonte" labelFor="font">
                            <div class="px-8 mb-6  z-10">
                                <font-picker :api-key="tokenFont"
                                    id="font-picker-texto2" :options="optionFont2" :active-font="fontFamily2"
                                    @change="changeFont2"></font-picker>
                            </div>
                        </t-input-group>
                        <!-- Posição Vertical 2 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Posição Vertical" labelFor="sliderV2">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" :interval="0.2" v-model="valueSliderV2"
                                    :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Posição Horizontal 2 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Posição Horizontal" labelFor="sliderH2">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" :interval="0.2" v-model="valueSliderH2"
                                    :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Tamanho da Fonte 2 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Tamanho da Fonte"
                            labelFor="fontSizeSlider2">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" v-model="fontSizeSlider2" :min="0" :max="50"
                                    :tooltip-formatter="formatterPx" :marks="marksFontSize"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Espessura da Fonte 2 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Espessura da Fonte"
                            labelFor="fontWeightSlider2">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" v-model="fontWeightSlider2" :data="dataWeight" :marks="true">
                                </vue-slider>
                            </div>
                        </t-input-group>
                    </div>

                    <!-- QrCode -->
                    <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                        <span
                            class="flex flex-row gap-1 items-center font-medium text-base text-gray-700 whitespace-normal mb-3">Qr-Code</span>
                        <!-- Posição Vertical 3 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Posição Vertical" labelFor="sliderV3">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" :interval="0.2" v-model="valueSliderV3"
                                    :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Posição Horizontal 3 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Posição Horizontal" labelFor="sliderH3">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" :interval="0.2" v-model="valueSliderH3"
                                    :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Tamanho da Fonte 3 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Tamanho" labelFor="fontSizeSlider3">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" v-model="fontSizeSlider3" :min="0" :max="200" :interval="0.2"
                                    :tooltip-formatter="formatterPx" :marks="marksQr"></vue-slider>
                            </div>
                        </t-input-group>
                    </div>

                    <!-- Código Hash -->
                    <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                        <span
                            class="flex flex-row gap-1 items-center font-medium text-base text-gray-700 whitespace-normal mb-3">Código
                            de Verificação</span>
                        <!-- Fonte -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Fonte" labelFor="font">
                            <div class="px-8 mb-6  z-10">
                                <font-picker :api-key="tokenFont"
                                    id="font-picker-texto3" :options="optionFont3" :active-font="fontFamily3"
                                    @change="changeFont3"></font-picker>
                            </div>
                        </t-input-group>
                        <!-- Posição Vertical 4 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Posição Vertical" labelFor="sliderV4">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" :interval="0.2" v-model="valueSliderV4"
                                    :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Posição Horizontal 4 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Posição Horizontal" labelFor="sliderH4">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" :interval="0.2" v-model="valueSliderH4"
                                    :tooltip-formatter="formatterPorcent" :marks="marks"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Tamanho da Fonte 4 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Tamanho da Fonte"
                            labelFor="fontSizeSlider4">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" v-model="fontSizeSlider4" :min="0" :max="50"
                                    :tooltip-formatter="formatterPx" :marks="marksFontSize"></vue-slider>
                            </div>
                        </t-input-group>
                        <!-- Espessura da Fonte 4 -->
                        <t-input-group class="col-span-12 md:col-span-6" label="Espessura da Fonte"
                            labelFor="fontWeightSlider4">
                            <div class="px-8 mb-6">
                                <vue-slider ref="slider" v-model="fontWeightSlider4" :data="dataWeight" :marks="true">
                                </vue-slider>
                            </div>
                        </t-input-group>
                    </div>


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




            <div v-if="controlFim" class="rounded-md modal-box overflow-y-auto max-h-34/40" style="position: fixed;
                bottom: 2.5vh;
                right: 2.5vw;
                background-color: #fff;
                z-index: 99999;
                min-width: auto;!important">
                <div
                    class="mt-5 md:mt-0 md:col-span-2 border rounded-md shadow m-4 flex flex-col items-center justify-center">


                    <!-- Fundo -->
                    <div class="certificadoModal" :style="
                    fundoCSS == null
                    ? {
                    backgroundImage: 'url(' + imagemCurriculo.fundoPadrao + ')',
                    }
                    : {
                    backgroundImage: 'url(' + fundoCSS + ')',
                    }
                    ">
                        <!-- Texto 1 -->
                        <div class="div3" v-bind:style="styles.styleObjectDiv3Modal">
                            <span class="apply-font-texto1" v-bind:style="styles.styleObjectDivWeight3"
                                v-html="imagemCurriculo.texto1"></span>
                        </div>

                        <!-- Texto 2 -->
                        <div id="div4" class="div4" v-bind:style="styles.styleObjectDiv4Modal">
                            <span class="apply-font-texto2" v-html="imagemCurriculo.texto2"
                                v-bind:style="styles.styleObjectDivWeight4"></span>
                        </div>

                        <!-- QrCode -->
                        <div class="div11" v-bind:style="styles.styleObjectDivQrModal"
                            style="position:absolute; transform: translate(-50%, -50%);">
                            <QRCanvas v-bind:style="styles.styleObjectQrModal" :options="options"></QRCanvas>
                        </div>
                        <span class="apply-font-texto3" v-bind:style="styles.styleObjectHashModal"
                            style="position:absolute; transform: translate(-50%, -50%);">{{ imagemCurriculo.key
                            }}</span>
                    </div>
                </div>

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
import TInputMultiSelect from "@/Components/Form/Inputs/TInputMultiSelect";
import TXIcon from "@/Components/Icon/TXIcon";
import TBanIcon from "@/Components/Icon/TBanIcon";
import TTable from "@/Components/Table/TTable";
import TModal from "@/Components/Modal/TModal";
import TInformationCircleIcon from "@/Components/Icon/TInformationCircleIcon";
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/antd.css';
import FontPicker from 'font-picker-vue';



const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');

export default {
    props: {
        certificados: Array,
        certificado: Object,
        errors: Object,
        success: String,
        btnSalvar: Boolean,
        btnAdd: Boolean,
        idCertificado: Number,
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
        VueSlider,
        FontPicker
    },
    data() {
        return {


            values: this.certificado.data.values,
            styles: this.certificado.data.styles,
            imagemCurriculo: this.certificado.data,



            fontFamily1: null,
            optionFont1: null,
            fontFamily2: null,
            optionFont2: null,
            fontFamily3: null,
            optionFont3: null,
            valueSliderV1: null,
            valueSliderH1: null,
            fontSizeSlider1: null,
            fontWeightSlider1: null,
            valueSliderV2: null,
            valueSliderH2: null,
            fontSizeSlider2: null,
            fontWeightSlider2: null,
            valueSliderV3: null,
            valueSliderH3: null,
            fontSizeSlider3: null,
            valueSliderV4: null,
            valueSliderH4: null,
            fontSizeSlider4: null,
            fontWeightSlider4: null,
            dadosCurriculo: [],
            images: {
                fundo: [],
            },
            fundoCSS: null,
            modeloBase: this.idCertificado,
            nomeModelo: null,
            texto1: null,
            texto2: null,
            options: {
                cellSize: 5,
                data: '',
            },
            controlFim: true,
            formatterPorcent: '{value}%',
            formatterPx: '{value}px',
            marks: val => val % 25 === 0 ? ({
                label: `${val}%`,
                labelStyle: {
                    opacity: val * 0.01 * 0.7 + 0.3
                },
                labelActiveStyle: {
                    color: '#3498db'
                }
            }) : false,
            marksFontSize: val => val % 10 === 0 ? ({
                label: `${val}px`,
                labelStyle: {
                    opacity: val * 0.01 * 0.7 + 0.3
                },
                labelActiveStyle: {
                    color: '#3498db'
                }
            }) : false,
            marksQr: val => val % 50 === 0 ? ({
                label: `${val}px`,
                labelStyle: {
                    opacity: val * 0.01 * 0.7 + 0.3
                },
                labelActiveStyle: {
                    color: '#3498db'
                }
            }) : false,
            dataWeight: ['100', '200', '300', '400', '500', '600', '700', '800', '900'],
            erroArquivo: null,
            componentKeyTipo: 0,
            componentKeySize: 1,
            modalErroTipo: false,
            modalErroSize: false,
            loading: false,
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                id: this.certificado.id,
                images: {
                    fundo: []
                },
                styles: null,
                values: null,
                nomeModel: null,
                texto1: null,
                texto2: null,
                modeloBase: null,
                key: 'HASH12345KEY'
            }),
        };
    },
    beforeMount() {
        this.atualizaDados();
    },
    watch: {
        valueSliderV1(e) {
            this.styles.styleObjectDiv3.top = e + '%';
            this.styles.styleObjectDiv3Modal.top = e + '%';
        },
        valueSliderH1(e) {
            this.styles.styleObjectDiv3.left = e + '%';
            this.styles.styleObjectDiv3Modal.left = e + '%';
        },
        fontSizeSlider1(e) {
            this.styles.styleObjectDiv3.fontSize = e + 'px';
            this.styles.styleObjectDiv3Modal.fontSize = (e / 3) + 'px';
        },
        fontWeightSlider1(e) {
            this.styles.styleObjectDivWeight3.fontWeight = e;
        },
        valueSliderV2(e) {
            this.styles.styleObjectDiv4.top = e + '%';
            this.styles.styleObjectDiv4Modal.top = e + '%';
        },
        valueSliderH2(e) {
            this.styles.styleObjectDiv4.left = e + '%';
            this.styles.styleObjectDiv4Modal.left = e + '%';
        },
        fontSizeSlider2(e) {
            this.styles.styleObjectDiv4.fontSize = e + 'px';
            this.styles.styleObjectDiv4Modal.fontSize = (e / 3) + 'px';
        },
        fontWeightSlider2(e) {
            this.styles.styleObjectDivWeight4.fontWeight = e;
        },
        valueSliderV3(e) {
            this.styles.styleObjectDivQr.top = e + '%';
            this.styles.styleObjectDivQrModal.top = e + '%';
        },
        valueSliderH3(e) {
            this.styles.styleObjectDivQr.left = e + '%';
            this.styles.styleObjectDivQrModal.left = e + '%';
        },
        fontSizeSlider3(e) {
            this.styles.styleObjectQr.width = e + 'px';
            this.styles.styleObjectQrModal.width = (e / 3) + 'px';
        },
        valueSliderV4(e) {
            this.styles.styleObjectHash.top = e + '%';
            this.styles.styleObjectHashModal.top = e + '%';
        },
        valueSliderH4(e) {
            this.styles.styleObjectHash.left = e + '%';
            this.styles.styleObjectHashModal.left = e + '%';
        },
        fontSizeSlider4(e) {
            this.styles.styleObjectHash.fontSize = e + 'px';
            this.styles.styleObjectHashModal.fontSize = (e / 3) + 'px';
        },
        fontWeightSlider4(e) {
            this.styles.styleObjectHash.fontWeight = e;
            this.styles.styleObjectHashModal.fontWeight = e;
        },
        nomeModelo() {
            this.imagemCurriculo.nomeModelo = this.nomeModelo;
        },
        texto1() {
            this.imagemCurriculo.texto1 = this.texto1;
        },
        texto2() {
            this.imagemCurriculo.texto2 = this.texto2;
        },
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
        changeFont1(e) {
            this.fontFamily1 = e.family;
        },
        changeFont2(e) {
            this.fontFamily2 = e.family;
        },
        changeFont3(e) {
            this.fontFamily3 = e.family;
        },
        atualizaDados() {
            this.nomeModelo = this.imagemCurriculo.nomeModelo;
            this.texto1 = this.imagemCurriculo.texto1;
            this.texto2 = this.imagemCurriculo.texto2;
            this.fontFamily1 = this.values.fontFamily1Inicial;
            this.optionFont1 = this.values.optionFont1Inicial;
            this.fontFamily2 = this.values.fontFamily2Inicial;
            this.optionFont2 = this.values.optionFont2Inicial;
            this.fontFamily3 = this.values.fontFamily3Inicial;
            this.optionFont3 = this.values.optionFont3Inicial;
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
            this.optionFont1.limit = 300;
            this.optionFont2.limit = 300;
            this.optionFont3.limit = 300;

            this.options.data = window.location.protocol + "//" + window.location.host + "/criar-certificado"

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
            this.values.fontFamily1Inicial = this.fontFamily1;
            this.values.optionFont1Inicial = {
                "name": "texto1",
                "variants": ["regular"],
                "sort": "alphabetical",
                "limit": 300
            };
            this.values.fontFamily2Inicial = this.fontFamily2;
            this.values.optionFont2Inicial = {
                "name": "texto2",
                "variants": ["regular"],
                "sort": "alphabetical",
                "limit": 300
            };
            this.values.fontFamily3Inicial = this.fontFamily3;
            this.values.optionFont3Inicial = {
                "name": "texto3",
                "variants": ["regular"],
                "sort": "alphabetical",
                "limit": 300
            };
            this.values.valueSliderV1Inicial = this.valueSliderV1;
            this.values.valueSliderH1Inicial = this.valueSliderH1;
            this.values.fontSizeSlider1Inicial = this.fontSizeSlider1;
            this.values.fontWeightSlider1Inicial = this.fontWeightSlider1;
            this.values.valueSliderV2Inicial = this.valueSliderV2;
            this.values.valueSliderH2Inicial = this.valueSliderH2;
            this.values.fontSizeSlider2Inicial = this.fontSizeSlider2;
            this.values.fontWeightSlider2Inicial = this.fontWeightSlider2;
            this.values.valueSliderV3Inicial = this.valueSliderV3;
            this.values.valueSliderH3Inicial = this.valueSliderH3;
            this.values.fontSizeSlider3Inicial = this.fontSizeSlider3;
            this.values.valueSliderV4Inicial = this.valueSliderV4;
            this.values.valueSliderH4Inicial = this.valueSliderH4;
            this.values.fontSizeSlider4Inicial = this.fontSizeSlider4;
            this.values.fontWeightSlider4Inicial = this.fontWeightSlider4;
            this.form.styles = this.styles;
            this.form.values = this.values;
            this.form.nomeModel = this.nomeModelo;
            this.form.texto1 = this.texto1;
            this.form.texto2 = this.texto2;
            this.form.modeloBase = this.modeloBase;


            // if (this.success != null) {
            //     this.success = null;
            // }
            this.spinLoading = true;
            this.form.post(route("edit-certificados"), {
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