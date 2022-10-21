<template>
    <app-layout :actionButtons="true">
        <template #header> Listar Formandos </template>
        <template #default>
            <t-alert v-if="deleted != null" class="col-span-6 md:col-span-6" color="solid-red" :closeable="true"
                :radius="5" :timer="5000">
                <b>{{ deleted }}</b>
            </t-alert>
            <t-alert v-if="redefinido != null" class="col-span-6 md:col-span-6" color="solid-green" :closeable="true"
                :radius="5" :timer="5000">
                <b>{{ redefinido }}</b>
            </t-alert>
            <t-table :content="content" :header="header" :searchable="['nome']" color="solid-blue"
                pagination-color="solid-blue" :radius="3" :border="true" :zebra="true" :shadow="true"
                :pagination="true">
                <!--If you want to show somethings like that the button at the right, you should this template area-->
                <template #right>
                    <div class="flex desktop:flex tablet:flex phone:flex-col phone:items-center">
                        <t-button class="desktop:mr-2 phone: mb-2" :link="route('criar-formandos')" :radius="8">
                            Adicionar Fomando Manualmente
                        </t-button>
                        <t-button color="solid-yellow" :link="route('render-csv')" :radius="8">
                            Adicionar Fomandos CSV
                        </t-button>
                    </div>
                </template>

                <template #id="{ props }">
                    <t-dropdown color="light-blue" size="fit">
                        <!--If you want to the dropdown looking like a button-->
                        <template #title> Ações </template>
                        <!--Or For what you want to use whatever-->
                        <!--Route links, you must define links in the web.php-->
                        <t-dropdown-item :link="route('visualizar-formandos', [props.id])">
                            <!--You can use any icon component but you must use slot="icon" attributes-->
                            <span class="mr-1.5">
                                <font-awesome-icon icon="eye" slot="icon" />
                            </span>
                            Visualizar
                        </t-dropdown-item>
                        <!--You can internal links-->
                        <t-dropdown-item :link="route('editar-formandos', [props.id])">
                            <!--You can use any icon component but you must use slot="icon" attributes-->
                            <span class="mr-1.5">
                                <font-awesome-icon icon="pen" slot="icon" />
                            </span>
                            Editar
                        </t-dropdown-item>
                        <t-dropdown-item @click.native="
                            () => {
                                modalRedefinir = !modalRedefinir;
                                nomeFormando = props.nome;
                                idFormando = props.id;
                            }
                        ">
                            <span class="mr-1.5">
                                <font-awesome-icon icon="cog" slot="icon" />
                            </span>

                            Redefinir Senha
                        </t-dropdown-item>
                        <t-dropdown-item @click.native="
                            () => {
                                modalDelete = !modalDelete;
                                nomeFormando = props.nome;
                                idFormando = props.id;
                            }
                        ">
                            <span class="mr-1.5">
                                <font-awesome-icon icon="trash" slot="icon" />
                            </span>

                            Excluir
                        </t-dropdown-item>
                    </t-dropdown>
                </template>
            </t-table>

            <t-modal :radius="3" :show="modalDelete" color="gradient-red-to-pink" @close="modalDelete = $event">
                <template #content>
                    <div class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                        <font-awesome-icon class="my-2" icon="trash" size="2x" />
                        <b>{{ nomeFormando }}</b>
                        <span>Você tem certeza que quer excluir este Formando?</span>
                    </div>
                </template>
                <template #footer-left>
                    <t-button :radius="3" color="solid-white" @click.native="modalDelete = false">
                        Cancelar
                    </t-button>
                </template>
                <template #footer-right>
                    <t-svg :spinLoading="spinLoading" indice="reprovado" validacaoIndice="reprovado">
                    </t-svg>
                    <t-button :radius="3" color="light-red" @click.native="deletar">
                        <font-awesome-icon icon="trash" />
                        Deletar
                    </t-button>
                </template>
            </t-modal>

            <t-modal :radius="3" :show="modalRedefinir" color="gradient-green-to-green"
                @close="modalRedefinir = $event">
                <template #content>
                    <div class="flex flex-col justify-center items-center gap-2 whitespace-normal">
                        <font-awesome-icon class="my-2" icon="cog" size="2x" />
                        <b>{{ nomeFormando }}</b>
                        <span>Você tem certeza que deseja redefinir a senha deste Formando?</span>
                    </div>
                </template>
                <template #footer-left>
                    <t-button :radius="3" color="solid-white" @click.native="modalRedefinir = false">
                        Cancelar
                    </t-button>
                </template>
                <template #footer-right>
                    <t-svg :spinLoading="spinLoadingRedefinir" indice="reprovado" validacaoIndice="reprovado">
                    </t-svg>
                    <t-button :radius="3" color="light-green" @click.native="redefinir">
                        <font-awesome-icon icon="cog" />
                        Redefinir
                    </t-button>
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
import TTable from "@/Components/Table/TTable";
import TDropdown from "@/Components/Dropdown/TDropdown";
import TDropdownItem from "@/Components/Dropdown/TDropdownItem";
import TModal from "@/Components/Modal/TModal";
import TListItem from "@/Components/List/TListItem";
import TList from "@/Components/List/TList";
import TSvg from "@/Components/Svg/TSvg.vue";

export default {
    show: true,
    props: {
        formandos: Array,
        success: String,
        deleted: String,
        redefinido: String
    },
    name: "Table",
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
        TTable,
        TDropdown,
        TDropdownItem,
        TListItem,
        TList,
        TModal,
        TSvg,
    },
    data() {
        return {
            header: [
                { key: "nome", label: "Nome", position: "center" },
                { key: "cpf", label: "CPF", position: "center" },
                { key: "id", label: "Ações", position: "center" },
            ],
            content: this.formandos,
            modalDelete: false,
            modalRedefinir: false,
            idFormando: "",
            nomeFormando: "",
            spinLoading: false,
            spinLoadingRedefinir: false,
            form: this.$inertia.form({
                _method: "POST",
                id: null,
            }),
        };
    },
    methods: {
        deletar() {
            this.form.id = this.idFormando;
            this.spinLoading = true;
            this.form.post(route("deletar-formandos"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (
                    (this.spinLoading = false),
                    (this.modalDelete = false),
                    (this.content = this.formandos)
                ),
                onError: () => (this.spinLoading = false),
            });
            this.loading = false;
        },
        redefinir() {
            this.form.id = this.idFormando;
            this.spinLoadingRedefinir = true;
            this.form.post(route("redefinir-senha-formandos"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (
                    (this.spinLoadingRedefinir = false),
                    (this.modalRedefinir = false),
                    (this.content = this.formandos)
                ),
                onError: () => (this.spinLoadingRedefinir = false),
            });
            this.loading = false;
        },
    },
};
</script>

<style scoped>

</style>
