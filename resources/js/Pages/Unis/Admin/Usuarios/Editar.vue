<template>
    <app-layout :actionButtons="true">
        <template #action-buttons>
            <t-button v-if="btnAdd" :link="route('criar-usuarios')" :radius="8">
                Adicionar Novo Usuário
            </t-button>
        </template>
        <template #header> Editar {{usuario.nome}} </template>
        <template #default>
            <t-form-content :reset-button="false" :submit-button="btnSalvar" :loading="spinLoading" @reset="reset"
                @submitted="save">
                <t-form-section title="Preencha os campos para criar o usuário.">
                    <input type="hidden" id="id" v-model="form.id" />
                    <!-- Nome -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Nome" labelFor="nome">
                        <t-input-text id="nome" v-model="form.nome" placeholder="Nome" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.nome')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                    <!-- Título -->
                    <t-input-group class="col-span-12 md:col-span-6" label="Título" labelFor="titulo">
                        <t-input-text id="titulo" v-model="form.titulo" placeholder="Título" />
                        <div v-for="errors in errors.customer" :key="errors.id">
                            <t-alert v-if="errors.includes('dadosCurriculo.titulo')"
                                class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{ errors }}
                                </b>
                            </t-alert>
                        </div>
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

                    <!--Senha-->
                    <t-input-group class="col-span-12 lg:col-span-6" label="Nova Senha" labelFor="novaSenha">
                        <t-input-text id="novaSenha" type="password" v-model="novaSenha" placeholder="Senha" />
                        <t-alert v-if="errors.customer && errors.customer.novaSenha"
                            class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                            :radius="5">
                            <b>{{ errors.customer.novaSenha }}</b>
                        </t-alert>
                    </t-input-group>
                    <t-input-group class="col-span-12 lg:col-span-6" label="Confirmar Nova Senha"
                        labelFor="confirmarNovaSenha">
                        <t-input-text id="confirmarNovaSenha" type="password" v-model="confirmarNovaSenha"
                            placeholder="Senha" />
                        <div v-if="spanErroConfirmarNovaSenha">
                            <t-alert class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                :radius="5">
                                <b>
                                    {{spanErroConfirmarNovaSenha}}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>

                </t-form-section>
                <div class="mx-8 mt-2" v-if="success">
                    <!-- Mensagem de Sucesso -->
                    <t-alert class="!m-auto !w-4/5 col-span-4" color="solid-green" :closeable="true" :radius="5">
                        <b>{{ success }}</b>
                    </t-alert>
                </div>

                <div class="mx-8 mt-2" v-if="errors.customer">
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



const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');

export default {
    props: {
        errors: Object,
        success: String,
        btnSalvar: Boolean,
        btnAdd: Boolean,
        usuario: Object
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
            novaSenha: null,
            confirmarNovaSenha: null,
            spanErroNovaSenha: null,
            spanErroConfirmarNovaSenha: null,


            loading: false,
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                id: this.usuario.id,
                nome: this.usuario.name,
                titulo: this.usuario.title,
                email: this.usuario.email,
                novaSenha: null,
                confirmarNovaSenha: null,
            }),
        };
    },
    watch: {
        novaSenha() {
        },
        confirmarNovaSenha() {
            if (this.novaSenha == this.confirmarNovaSenha) {
                this.spanErroConfirmarNovaSenha = null;
            }
        },
    },
    methods: {
        save() {
            this.errors.customer = null;
            if (this.novaSenha != this.confirmarNovaSenha) {
                this.spanErroConfirmarNovaSenha = 'A nova senha não corresponde à confirmação.';
            } else {
                this.spanErroNovaSenha = null;
                this.spanErroConfirmarNovaSenha = null;

                this.form.novaSenha = this.novaSenha;
                this.form.confirmarNovaSenha = this.confirmarNovaSenha;
                this.spinLoading = true;

                this.form.post(route("edit-usuarios"), {
                    errorBag: "customer",
                    preserveScroll: false,
                    onSuccess: () => (this.spinLoading = false),
                    onError: () => (this.spinLoading = false),
                });
                this.loading = true;
            }

        },
        reset: function () {
            console.log('reset');
        },
    },
};
</script>

<style scoped>

</style>
