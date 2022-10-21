<template>
    <app-layout :actionButtons="true">
        <template #header> Listar Certificados </template>
        <template #default>
            <t-alert v-if="deleted != null" class="col-span-6 md:col-span-6" color="solid-red" :closeable="true"
                :radius="5" :timer="5000">
                <b>{{ deleted }}</b>
            </t-alert>
            <t-table :content="content" :header="header" :searchable="['nome']" color="solid-blue"
                pagination-color="solid-blue" :radius="3" :border="true" :zebra="true" :shadow="true"
                :pagination="true">
                <!--If you want to show somethings like that the button at the right, you should this template area-->
                <template #right>
                    <t-button :link="route('criar-certificados')" :radius="8">
                        Adicionar novo Certificado
                    </t-button>
                </template>

                <template #id="{ props }">
                    <t-dropdown color="light-blue" size="fit">
                        <!--If you want to the dropdown looking like a button-->
                        <template #title> Ações </template>
                        <!--Or For what you want to use whatever-->
                        <!--Route links, you must define links in the web.php-->
                        <t-dropdown-item :link="route('visualizar-certificados', [props.id])">
                            <!--You can use any icon component but you must use slot="icon" attributes-->
                            <span class="mr-1.5">
                                <font-awesome-icon icon="eye" slot="icon" />
                            </span>
                            Visualizar
                        </t-dropdown-item>
                        <!--You can internal links-->
                        <t-dropdown-item v-if="props.id!= 1" :link="route('editar-certificados', [props.id])">
                            <!--You can use any icon component but you must use slot="icon" attributes-->
                            <span class="mr-1.5">
                                <font-awesome-icon icon="pen" slot="icon" />
                            </span>
                            Editar
                        </t-dropdown-item>
                        <t-dropdown-item v-if="props.id!= 1" @click.native="
                            () => {
                                modalDelete = !modalDelete;
                                nomeCertificado = props.name;
                                idCertificado = props.id;
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
                        <b>{{ nomeCertificado }}</b>
                        <span>Você tem certeza que quer excluir este Certificado?</span>
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
        certificados: Array,
        success: String,
        deleted: String,
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
                { key: "nome", label: "Certificado", position: "center" },
                { key: "id", label: "Ações", position: "center" },
            ],
            content: this.certificados,
            modalDelete: false,
            idCertificado: "",
            nomeCertificado: "",
            spinLoading: false,
            form: this.$inertia.form({
                _method: "POST",
                id: null,
            }),
        };
    },
    methods: {
        deletar() {
            this.form.id = this.idCertificado;
            this.spinLoading = true;
            this.form.post(route("deletar-certificados"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (
                    (this.spinLoading = false),
                    (this.modalDelete = false),
                    (this.content = this.certificados)
                ),
                onError: () => (this.spinLoading = false),
            });
            this.loading = false;
        },
    },
};
</script>

<style scoped>

</style>
