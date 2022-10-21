<template>
    <app-layout>
        <template #header> Bem vindo a certificações Unis </template>
        <template #subHeader> </template>
        <template #default>
            <t-collapsible-item color="solid-blue">
                <template #title> Cadastros </template>
                <template #content>
                    <t-collapsible-item color="light-blue">
                        <template #title> Certificados </template>
                        <template #content>
                            Nesta aba você poderá listar todos os certificados já cadastrados, podendo edita-los
                            exclui-los e adicionar.
                        </template>
                    </t-collapsible-item>
                    <t-collapsible-item color="light-blue">
                        <template #title> Cursos </template>
                        <template #content>
                            Nesta aba você poderá listar todos os cursos já cadastrados, podendo edita-los
                            exclui-los e adicionar.
                        </template>
                    </t-collapsible-item>
                    <t-collapsible-item color="light-blue">
                        <template #title> Formandos </template>
                        <template #content>
                            Nesta aba você poderá listar todos os formandos já cadastrados, podendo edita-los
                            exclui-los e adicionar.
                        </template>
                    </t-collapsible-item>
                </template>
            </t-collapsible-item>
            <t-collapsible-item color="solid-blue">
                <template #title> Usuários </template>
                <template #content>
                    <t-collapsible-item color="light-blue">
                        <template #title> Criar usuário </template>
                        <template #content>
                            Nesta aba você poderá adicionar usuários para a utilização interna do sistema.
                        </template>
                    </t-collapsible-item>
                    <t-collapsible-item color="light-blue">
                        <template #title> Listar Usuários </template>
                        <template #content>
                            Nesta aba será listado todos os usuários cadastrados
                            no sistema.
                        </template>
                    </t-collapsible-item>
                </template>
            </t-collapsible-item>
            <t-collapsible-item color="solid-blue">
                <template #title> Configurações </template>
                <template #content>
                    <t-collapsible-item color="light-blue">
                        <template #title> Perfil </template>
                        <template #content>
                            Nesta aba você poderá alterar sua informações no sistema.
                        </template>
                    </t-collapsible-item>
                </template>
            </t-collapsible-item>
        </template>
    </app-layout>
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

export default {
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
        TCollapsibleItem
    },
    data() {
        return {
            tableHeader: [
                { key: "id", label: "ID", position: "center" },
                { key: "name", label: "Name", position: "left" },
                { key: "start", label: "Start Date", position: "left" },
                { key: "end", label: "End Date", position: "left" },
                { key: "status", label: "Status", position: "center" },
            ],
            tableContent: [
                {
                    id: 1,
                    name: "VueJS Components",
                    start: "01.03.2021",
                    end: "14.09.2021",
                    status: 10,
                },
                {
                    id: 2,
                    name: "Custom Style Optimize",
                    start: "02.05.2021",
                    end: "25.08.2021",
                    status: 20,
                },
                {
                    id: 3,
                    name: "Error Management",
                    start: "25.04.2021",
                    end: "30.12.2021",
                    status: 70,
                },
            ],
            breadcrumbs: [
                { label: "Home", link: "/", active: false },
                {
                    label: "Dashboard",
                    link: "",
                    active: true,
                    activeColor: "blue",
                },
            ],
        };
    },
};
</script>
