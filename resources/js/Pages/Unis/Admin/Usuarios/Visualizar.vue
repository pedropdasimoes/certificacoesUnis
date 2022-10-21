<template>
    <app-layout :actionButtons="true">
        <template #header> Usuário </template>
        <template #default>
            <t-list :radius="5" color="solid-white">
                <t-list-item :active="true">
                    <template #title> Nome Usuário: </template>
                    <template #default>
                        {{ usuario.name }}
                    </template>
                </t-list-item>
                <t-list-item :active="true">
                    <template #title> Titulo Usuário: </template>
                    <template #default>
                        {{ usuario.title }}
                    </template>
                </t-list-item>
                <t-list-item :active="true">
                    <template #title> Email Usuário: </template>
                    <template #default>
                        {{ usuario.email }}
                    </template>
                </t-list-item>
            </t-list>
            <button
                class="button mt-3 text-white rounded-xl border-blue-500 bg-blue-500 hover:text-blue-700 hover:bg-blue-100 h-10"
                @click="backView">
                Voltar
            </button>
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



const { defineComponent } = require('vue');
const { QRCanvas } = require('qrcanvas-vue');

export default {
    props: {
        usuario: Object,
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
        QRCanvas
    },
    data() {
        return {
        };
    },
    methods: {
        backView() {
            history.back();
        },
    },
};
</script>

<style scoped>

</style>
    