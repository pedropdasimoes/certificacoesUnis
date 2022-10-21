<template>
    <app-layout :key="keyApp" :actionButtons="true">
        <template #action-buttons>
            <t-button :link="route('download-exemplo-csv')" :radius="8">
                Baixar CSV Exemplo
            </t-button>
        </template>
        <template #header> Adicionar CSV </template>
        <template #default>
            <t-form-content :reset-button="false" :submit-button="btnSalvar" :loading="spinLoading" @reset="reset"
                @submitted="startSend">
                <t-form-section
                    title="Faça upload de um arquivo csv, caso precise de um exemplo basta baixa-lo no botão acima.">
                    <!-- Arquivo CSV -->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Arquivo CSV" labelFor="csvFile">
                        <t-input-file ref="inputFileCSV" @input="inputFunctionCSV($event)" :preview="false" id="csvFile"
                            v-model="form.csvFile" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>
                </t-form-section>
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
                        <span>Seu arquivo dever ser do tipo: CSV </span>
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
                        <span>Seu arquivo deve ter o tamanho menor que 5MB</span>
                    </div>
                </template>
            </t-modal>

            <t-modal :radius="3" :show="modalNenhumArquivo" color="gradient-red-to-pink"
                @close="modalNenhumArquivo = false" :key="componentKeyNenhumArquivo">
                <template #content>
                    <div class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                        <font-awesome-icon class="my-2" icon="ban" size="2x" />
                        <b>{{ erroArquivo }}</b>
                        <span>Nenhum arquivo carregado, por favor carregue para
                            enviar.</span>
                    </div>
                </template>
            </t-modal>
            <t-modal :radius="3" :show="modalErroCsv" color="gradient-red-to-pink" @close="modalErroCsv = false"
                :key="componentKeyErroCsv">
                <template #content>
                    <div class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                        <font-awesome-icon class="my-2" icon="ban" size="2x" />
                        <b>{{ erroArquivo }}</b>
                        <span>Seu CSV está com os dados ou cabeçalho errado, por favor baixe o exemplo no botão abaixo e
                            confira o erro.</span>
                        <t-button :link="route('criar-certificados')" :radius="8">
                            Baixar CSV Exemplo
                        </t-button>
                    </div>
                </template>
            </t-modal>
            <t-modal :radius="3" :show="modalEnviando" :closeModal="closeModalButton" color="solid-white"
                @close="fecharModalEnviando" :key="componentKeyEnviando" class="overflow-y-scroll max-h-screen">
                <template #content>
                    <div class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                        <img v-if="!imgFinalizado" src="/img/unis/Hourglass.gif" alt="" />
                        <img v-if="imgFinalizado" src="/img/unis/Check.png" alt="" style="max-width:90px" />
                        <b>{{ erroArquivo }}</b>
                        <span>{{mensagemModal}}
                        </span>

                        <span>
                            {{ arquivosEnviados }}/{{ totalArquivos }}
                        </span>

                        <t-progress :height="4" :value="porcentagem" color="gradient-green-to-green"
                            title="Arquivos enviados" />
                        <br />
                        <div v-if="arquivosComErro > 0"
                            class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                            <span>
                                Os seguintes arquivos obtiveram erro ao enviar:
                            </span>
                            <ul>
                                <li v-for="arquivos in arquivosErrados" :key="arquivos.id">
                                    {{ arquivos }}
                                </li>
                            </ul>
                            <span>Aguarde finaliazar e envie novamente.</span>
                        </div>
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
import Papa from 'papaparse';
import axios from "axios";
import TProgress from "@/Components/Progress/TProgress";


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
        TXIcon,
        TBanIcon,
        TTable,
        TModal,
        TInformationCircleIcon,
        Papa,
        axios,
        TProgress
    },
    data() {
        return {
            imgFinalizado: false,
            mensagemModal: 'Estamos enviando seus Arquivos, por favor aguarde.',
            keyApp: 10,
            arquivosErrados: [],
            closeModalButton: false,
            totalArquivos: 0,
            arquivosEnviados: 0,
            arquivosComErro: 0,
            porcentagem: 0,
            controleAxios: 0,
            enviando: false,
            file: '',
            content: [],
            parsed: false,
            erroArquivo: null,
            componentKeyTipo: 0,
            componentKeySize: 10,
            componentKeyNenhumArquivo: 20,
            componentKeyEnviando: 30,
            componentKeyErroCsv: 40,
            modalErroTipo: false,
            modalErroSize: false,
            modalEnviando: false,
            modalNenhumArquivo: false,
            modalErroCsv: false,
            loading: false,
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                csv: [],
            }),
        };
    },
    beforeMount() {
    },
    watch: {
    },
    methods: {
        fecharModalEnviando: function () {
            this.modalEnviando = false;
            window.location.reload();
        },
        inputFunctionCSV() {

            if (this.$refs.inputFileCSV.files.length > 1) {
                this.$refs.inputFileCSV.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.inputFileCSV.files[0].type) {
                case "text/csv":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.inputFileCSV.files[0].size > 5000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (validate) {
                this.file = event.target.files[0];
                this.parseFile();
                this.form.csv = [];
                this.form.csv.push(this.$refs.inputFileCSV.files[0]);
            } else {
                if (tipoErro == "tipo") {
                    this.$refs.inputFileCSV.files.splice(0, 1);
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.$refs.inputFileCSV.files.splice(0, 1);
                    this.modalErroSize = true;
                }
            }

        },
        parseFile() {
            Papa.parse(this.file, {
                header: true,
                skipEmptyLines: true,
                complete: function (results) {
                    this.content = results;
                    this.parsed = true;
                }.bind(this)
            });
        },
        reset: function () {
            this.nomeModelo = null;
        },
        startSend(response = null) {
            var verificaHeader = true;
            if (this.enviando == false) {
                this.enviando = true;
                if (this.content.data) {
                    if (this.content.data.length > 0) {
                        if (response == null) {
                            for (let index = 0; index < this.content.meta.fields.length; index++) {
                                switch (index) {
                                    case 0:
                                        if (this.content.meta.fields[index] != 'nome') {
                                            verificaHeader = false;
                                        }
                                        break;
                                    case 1:
                                        if (this.content.meta.fields[index] != 'cpf') {
                                            verificaHeader = false;
                                        }
                                        break;
                                    case 2:
                                        if (this.content.meta.fields[index] != 'email') {
                                            verificaHeader = false;
                                        }
                                        break;
                                    case 3:
                                        if (this.content.meta.fields[index] != 'referencia') {
                                            verificaHeader = false;
                                        }
                                        break;
                                    case 4:
                                        if (this.content.meta.fields[index] != 'melhorFormando') {
                                            verificaHeader = false;
                                        }
                                        break;
                                    case 5:
                                        if (this.content.meta.fields[index] != 'dataEmissao') {
                                            verificaHeader = false;
                                        }
                                        break;
                                    default:
                                        verificaHeader = false;
                                        break;
                                }
                            }
                        }
                        if (verificaHeader) {
                            this.content.data.forEach(element => {
                                this.totalArquivos++;
                            });
                        }
                    }


                }
            }
            if (verificaHeader) {
                if (this.totalArquivos == 0) {

                    this.mensagemModal = 'Estamos enviando seus Arquivos, por favor aguarde.';
                    this.modalNenhumArquivo = true;
                    this.enviando = false;
                }
                else {
                    this.modalEnviando = true;
                    if (response != null && response.status == true) {
                        this.arquivosEnviados++;
                        this.porcentagem =
                            (this.arquivosEnviados * 100) / this.totalArquivos;
                    } else if (response != null && response.status == false) {
                        this.arquivosComErro++;
                        this.arquivosErrados.push(response.erro);
                        this.totalArquivos--;
                    }
                    this.controleAxios++;
                    var controleInterno = 0;
                    var indexArray = 0;
                    var indexCsv = 0;
                    if (this.content.data.length > 0) {
                        this.content.data.forEach(
                            (formando, index) => {
                                // console.log(formando);
                                indexArray = index;
                                indexCsv = index;
                                controleInterno++;
                                if (
                                    this.controleAxios >
                                    this.totalArquivos
                                ) {
                                    this.closeModalButton = true;
                                    this.componentKeyEnviando++;
                                    this.mensagemModal = 'Envio finalizado.';
                                    this.imgFinalizado = true;
                                }
                                if (
                                    controleInterno ==
                                    this.controleAxios
                                ) {
                                    if (
                                        controleInterno ==
                                        this.totalArquivos
                                    ) {
                                        return this.enviaFormando(formando);
                                    } else {
                                        return this.enviaFormando(formando);
                                    }
                                }
                            }
                        );
                    }
                }
            } else {
                this.modalErroCsv = true;
                this.enviando = false;
            }

        },
        enviaFormando(formando) {
            console.log('--------')
            console.log(formando);
            console.log('--------')
            const formData = new FormData();
            formData.append("nome", formando.nome);
            formData.append("cpf", formando.cpf);
            formData.append("email", formando.email);
            formData.append("referencia", formando.referencia);
            formData.append("melhorFormando", formando.melhorFormando);
            formData.append("dataEmissao", formando.dataEmissao);
            axios
                .post(route("create-csv"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.log("Resposta: ");
                    console.log(response);
                    console.log('--------');
                    return this.startSend(response.data);
                })
                .catch(function (error) {
                    console.log("Erro: ");
                    console.log(error);
                    // return this.startSend(error);
                });
        },
        save() {
            // console.log(this.content);
            // this.spinLoading = true;
            // this.form.post(route("create-csv"), {
            //     errorBag: "customer",
            //     preserveScroll: false,
            //     onSuccess: () => (this.spinLoading = false),
            //     onError: () => (this.spinLoading = false),
            // });
            // this.loading = true;
        },
    },
};
</script>

<style scoped>

</style>