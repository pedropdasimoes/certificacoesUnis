<template>
    <app-layout :actionButtons="true">
        <template #action-buttons>
            <t-button v-if="btnAdd" :link="route('criar-formandos')" :radius="8">
                Adicionar Novo Formando
            </t-button>
        </template>
        <template #header> Editar Formando </template>
        <template #default>
            <t-form-content :reset-button="false" :submit-button="btnSalvar" :loading="spinLoading" @reset="reset"
                @submitted="save">
                <t-form-section title="Preencha os campos com as informações do formando.">
                    <input type="hidden" id="id" v-model="form.id" />
                    <!-- Nome -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Nome" labelFor="nome">
                        <t-input-text id="nome" v-model="form.nome" placeholder="Nome" />
                        <t-alert v-if="errors.customer && errors.customer.nome"
                            class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                            :radius="5">
                            <b>
                                {{ errors.customer.nome }}
                            </b>
                        </t-alert>
                    </t-input-group>

                    <!-- CPF -->
                    <t-input-group class="col-span-12 md:col-span-6" label="CPF" labelFor="cpf">
                        <t-input-text id="cpf" v-model="form.cpf" placeholder="CPF" v-mask="'###.###.###-##'" />
                        <t-alert v-if="errors.customer && errors.customer.cpf"
                            class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                            :radius="5">
                            <b>{{ errors.customer.cpf }}</b>
                        </t-alert>
                    </t-input-group>

                    <!-- Email -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Email" labelFor="email">
                        <t-input-text id="email" v-model="form.email" placeholder="Email" type="email" />
                        <t-alert v-if="errors.customer && errors.customer.email"
                            class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                            :radius="5">
                            <b>{{ errors.customer.email }}</b>
                        </t-alert>
                    </t-input-group>

                    <!-- Cursos -->
                    <div class="flex flex-col col-span-12">
                        <h3 class="flex flex-row items-center font-medium text-base text-gray-700 whitespace-normal">
                            Cursos</h3>
                        <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                            <div class="col-span-4 mx-2 my-2">
                                <button type="button" @click="addCurso()"
                                    class="button bg-green-500 border-green-500 hover:bg-green-100 hover:text-green-700 text-gray-100 hover:bg-green-100 hover:text-green-700 rounded-md h-8 text-sm min-w-min min-h-min">Adicionar
                                    Curso</button>
                            </div>
                            <div class="w-full" id="divCursos">
                                <div v-for="(curso, index) in cursosSelecionados" :key="curso.id"
                                    class="flex flex-col col-span-12 p-1.5 my-2 mx-5 border rounded-md shadow ">
                                    <div
                                        class="col-span-12 flex justify-between -mx-2 -mt-2 rounded-t-md items-center py-2.5 px-5 mb-3 bg-blue-200">
                                        <div>
                                            <h3
                                                class="flex flex-row items-center font-medium text-lg text-gray-700 whitespace-normal">
                                                Curso {{index +1}}</h3>
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

                                            <button type="button" v-if="index != cursosSelecionados.length - 1"
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
                                    <!-- Cursos -->
                                    <t-input-group class="col-span-12 md:col-span-6 mb-2" label="Referencia Curso"
                                        labelFor="idCurso">
                                        <t-input-select v-model="curso.idCurso" :clear-button="false"
                                            :options="cursosDisponiveis" :search="true" optionsLabelKey="referencia"
                                            optionsValueKey="id" place-holder="Selecione o Curso"
                                            search-place-holder="Pesquise o Curso..." @input="(i)=>mudou(i, index)" />
                                    </t-input-group>
                                    <t-alert v-if="errorCurso" class="h-fit mt-1.5 col-span-12 md:col-span-6"
                                        color="light-red" :closeable="true" :radius="5">
                                        <b>
                                            É preciso selecionar um curso.
                                        </b>
                                    </t-alert>
                                    <!-- Nome Curso -->
                                    <t-input-group class="col-span-12 md:col-span-6" label="Nome Curso"
                                        labelFor="nomeCurso">
                                        <t-input-text class="mb-2" :disabled="true" id="nomeCurso" v-model="curso.nome"
                                            placeholder="Nome Curso" />
                                        <div v-for="errors in errors.customer" :key="errors.id">
                                            <t-alert v-if="errors.includes('cursosSelecionados.nomeCurso')"
                                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red"
                                                :closeable="true" :radius="5">
                                                <b>
                                                    {{ errors }}
                                                </b>
                                            </t-alert>
                                        </div>
                                    </t-input-group>
                                    <t-input-group class="col-span-12 md:col-span-6 " label="Melhor Formando"
                                        labelFor="radioMelhor">
                                        <div class="inline-flex flex-wrap items-center gap-2 ml-1 mb-2">
                                            <t-input-radio-button :key="radioKeySim[index]" :checked="curso.radioSim"
                                                :radius="3" color="solid-green" input-value="1" label="Sim"
                                                @input="(i)=>alteraRadio(i, index)">
                                                <template #icon>
                                                    <t-check-icon class="w-5 h-5" />
                                                </template>
                                            </t-input-radio-button>
                                            <t-input-radio-button :key="radioKeyNao[index]" :checked="curso.radioNao"
                                                :radius="3" color="solid-red" input-value="2" label="Não"
                                                @input="(i)=>alteraRadio(i, index)">
                                                <template #icon>
                                                    <t-x-icon class="w-5 h-5" />
                                                </template>
                                            </t-input-radio-button>
                                        </div>
                                    </t-input-group>
                                    <!-- Código Verificação -->
                                    <t-input-group class="col-span-12 md:col-span-6" label="Código Verificação"
                                        labelFor="codigoVerificacao">
                                        <t-input-text class="mb-2" :disabled="true" id="codigoVerificacao"
                                            v-model="curso.hashCurso" placeholder="Código Verificação" />
                                        <div v-for="errors in errors.customer" :key="errors.id">
                                            <t-alert v-if="errors.includes('cursosSelecionados.codigoVerificacao')"
                                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red"
                                                :closeable="true" :radius="5">
                                                <b>
                                                    {{ errors }}
                                                </b>
                                            </t-alert>
                                        </div>
                                    </t-input-group>
                                    <!-- Data Fim -->
                                    <t-input-group class="col-span-12 md:col-span-6" label="Data de Emissão"
                                        labelFor="dataEmissao">
                                        <t-input-text class="mb-2" id="dataEmissao" v-model="curso.dataEmissao"
                                            placeholder="19.09.2020" type="date" />
                                        <t-alert v-if="errorData" class="h-fit mt-1.5 col-span-12 md:col-span-6"
                                            color="light-red" :closeable="true" :radius="5">
                                            <b>
                                                Verifique se a data está preenchida e não é maior que a data de hoje. E
                                                tente novamente.
                                            </b>
                                        </t-alert>
                                    </t-input-group>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redes -->
                    <div class="flex flex-col col-span-12">
                        <h3 class="flex flex-row items-center font-medium text-base text-gray-700 whitespace-normal">
                            Redes</h3>
                        <div class="flex flex-col col-span-12 p-1.5 border rounded-md shadow ">
                            <!-- Linkedin -->
                            <t-input-group class="col-span-12 md:col-span-6" label="Linkedin" labelFor="linkedin">
                                <t-input-text id="linkedin" v-model="form.linkedin" placeholder="Linkedin" />
                                <t-alert v-if="errors.customer && errors.customer.linkedin"
                                    class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                    :radius="5">
                                    <b>
                                        {{ errors.customer.linkedin }}
                                    </b>
                                </t-alert>
                            </t-input-group>
                            <!-- WhatsApp -->
                            <t-input-group class="col-span-12 md:col-span-6" label="WhatsApp" labelFor="whatsapp">
                                <t-input-text id="whatsapp" v-model="form.whatsapp" placeholder="WhatsApp"
                                    v-mask="'+55 (##)#####-####'" />
                                <t-alert v-if="errors.customer && errors.customer.whatsapp"
                                    class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                    :radius="5">
                                    <b>
                                        {{ errors.customer.whatsapp }}
                                    </b>
                                </t-alert>
                            </t-input-group>
                        </div>
                    </div>

                </t-form-section>
                <div class="mx-8" v-if="success">
                    <!-- Mensagem de Sucesso -->
                    <t-alert class="mt-2 !m-auto !w-4/5 col-span-4" color="solid-green" :closeable="true" :radius="5">
                        <b>{{ success }}</b>
                    </t-alert>
                </div>

                <div class="mx-8" v-if="errors.customer">
                    <!-- Mensagem de Sucesso -->
                    <t-alert class="mt-2 !m-auto !w-4/5 col-span-4" color="solid-red" :closeable="true" :radius="5">
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



export default {
    props: {
        arrayBadges: Array,
        arrayKeySim: Array,
        arrayKeyNao: Array,
        formando: Object,
        cursosDisponiveis: Array,
        certificados: Array,
        errors: Object,
        success: String,
        btnSalvar: Boolean,
        btnAdd: Boolean,
        btnCertificado: Boolean,
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
        TXIcon,
        TBanIcon,
        TTable,
        TModal,
        TInformationCircleIcon
    },
    data() {
        return {
            errorData: false,
            errorCurso: false,
            cursosSelecionados: this.formando.cursos,
            radioKeySim: this.arrayKeySim,
            radioKeyNao: this.arrayKeyNao,

            loading: false,
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                id: this.formando.id,
                nome: this.formando.nome,
                cpf: this.formando.cpf,
                email: this.formando.email,
                linkedin: this.formando.redes.linkedin ? this.formando.redes.linkedin : null,
                whatsapp: this.formando.redes.whatsapp ? this.formando.redes.whatsapp : null,
                cursosSelecionados: this.formando.cursos
            }),
        };
    },
    beforeMount() {
        // this.atualizaDados();
    },
    watch: {
        modeloBase(e) {
            this.certificados.forEach(element => {
                if (element.id == e) {

                    this.imagemCurriculo = element.data;
                    this.idCurriculo = element.id;
                }
            });
        }
    },
    methods: {
        makeHash: function () {
            var hash = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 12; i++) {
                hash += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            if (this.arrayBadges.includes(hash)) {
                while (this.arrayBadges.includes(hash)) {
                    console.log('tem');
                    hash = '';
                    for (var i = 0; i < 12; i++) {
                        hash += possible.charAt(Math.floor(Math.random() * possible.length));
                    }
                }
            }

            return hash;
        },
        hideModulos: function () {
            var incrementMinum = 0.045;
            var opacityMinum = 1;
            var instanceMinum = window.setInterval(function () {
                document.getElementById('divCursos').style.opacity = opacityMinum
                opacityMinum = opacityMinum - incrementMinum;
                if (opacityMinum < 0.2) {
                    window.clearInterval(instanceMinum);
                    var incrementPlus = 0.045;
                    var opacityPlus = 0.2;
                    var instancePlus = window.setInterval(function () {
                        document.getElementById('divCursos').style.opacity = opacityPlus
                        opacityPlus = opacityPlus + incrementPlus;
                        if (opacityPlus > 1) {
                            window.clearInterval(instancePlus);
                        }
                    }, 25)
                }
            }, 25)
        },
        atualizaKeyRadio: function () {
            var lastElementSim = this.radioKeyNao[this.radioKeySim.length - 1];
            var lastElementNao = this.radioKeyNao[this.radioKeyNao.length - 1];
            var lastKey = null;
            if (lastElementSim > lastElementNao) {
                lastElementNao++;
                lastKey = lastElementSim;
            } else {

                lastElementNao++;
                lastKey = lastElementNao;
            }
            this.radioKeySim.forEach((element, index) => {
                this.radioKeySim[index] = lastKey;
                lastKey++;
            });
            this.radioKeyNao.forEach((element, index) => {
                this.radioKeyNao[index] = lastKey;
                lastKey++;
            });
        },
        alteraRadio: function (value, index) {
            if (value == 1) {
                this.cursosSelecionados[index].radioSim = true;
                this.cursosSelecionados[index].radioNao = false;
            } else {
                this.cursosSelecionados[index].radioSim = false;
                this.cursosSelecionados[index].radioNao = true;
            }
            this.atualizaKeyRadio();
        },
        mudou: function (value, index) {
            var nomeCurso = '';
            this.cursosDisponiveis.forEach(element => {
                if (element.id == value) {
                    nomeCurso = element.nome
                }
            });
            this.cursosSelecionados[index].nome = nomeCurso
            this.atualizaKeyRadio();

        },

        addCurso: function () {
            this.hideModulos();
            var lastKey = null;
            if (this.radioKeySim.length > 0 && this.radioKeyNao.length > 0) {
                var lastElementSim = this.radioKeyNao[this.radioKeySim.length - 1];
                var lastElementNao = this.radioKeyNao[this.radioKeyNao.length - 1];
                var lastKey = null;
                if (lastElementSim > lastElementNao) {
                    lastKey = lastElementSim;
                } else {

                    lastKey = lastElementNao;
                }
            } else {
                lastKey = 0;
            }
            var hash = this.makeHash();
            setTimeout(() => {
                const newCurso =
                {
                    nome: '',
                    radioSim: false,
                    radioNao: true,
                    idCurso: null,
                    hashCurso: hash,
                    dataEmissao: ""
                };
                this.cursosSelecionados.push(newCurso);
            }, 500)

            this.radioKeySim.push(lastKey + 1);
            this.radioKeyNao.push(lastKey + 2);
            this.atualizaKeyRadio();
        },
        upButton(index) {
            this.hideModulos();

            setTimeout(() => {
                var item = this.cursosSelecionados.splice(index, 1);
                this.cursosSelecionados.splice(index - 1, 0, item[0]);
            }, 500)
            this.atualizaKeyRadio();

        },
        downButton(index) {
            this.hideModulos();
            setTimeout(() => {
                var item = this.cursosSelecionados.splice(index, 1);

                this.cursosSelecionados.splice(index + 1, 0, item[0]);
            }, 500)
            this.atualizaKeyRadio();
        },
        closeButton(index) {
            this.hideModulos();
            setTimeout(() => {
                var item = this.cursosSelecionados.splice(index, 1);
            }, 500)
            this.atualizaKeyRadio();
        },
        atualizaDados() {
            this.texto1 = this.imagemCurriculo.texto1;
            this.texto2 = this.imagemCurriculo.texto2;
            this.texto3 = this.imagemCurriculo.texto3;
            this.texto4 = this.imagemCurriculo.texto4;
            this.texto5 = this.imagemCurriculo.texto5;
            this.texto6 = this.imagemCurriculo.texto6;
            this.assinatura1 = this.imagemCurriculo.assinatura1;
            this.assinatura2 = this.imagemCurriculo.assinatura2;
        },

        reset: function () {
            this.nomeModelo = null;
        },
        getFormattedDate(date) {
            var dateArray = date.split("-");
            var year = dateArray[0];

            var month = dateArray[1];

            var day = dateArray[2];

            return month + '/' + day + '/' + year;
        },
        save() {
            var todaysDate = new Date();
            this.errorData = false;
            var erro = false;
            this.form.cursosSelecionados = this.cursosSelecionados;
            this.cursosSelecionados.forEach((element, index) => {
                if (element.idCurso == null) {
                    erro = true;
                    this.errorCurso = true;
                }
                if (element.dataEmissao == null || element.dataEmissao == '') {
                    erro = true;
                    this.errorData = true;
                } else {
                    var dataEditada = this.getFormattedDate(element.dataEmissao);
                    var inputDate = new Date(dataEditada);
                    if (inputDate.setHours(0, 0, 0, 0) > todaysDate.setHours(0, 0, 0, 0)) {
                        erro = true;
                        this.errorData = true;
                    }
                }
            });
            if (!erro) {
                if (this.success != null) {
                    this.success = null;
                }
                this.spinLoading = true;
                this.form.post(route("edit-formandos"), {
                    errorBag: "customer",
                    preserveScroll: false,
                    onSuccess: () => (this.spinLoading = false),
                    onError: () => (this.spinLoading = false),
                });
                this.loading = true;
            }
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

</style>
