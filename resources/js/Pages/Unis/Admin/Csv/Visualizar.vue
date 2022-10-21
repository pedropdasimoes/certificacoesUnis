<template>
    <app-layout :actionButtons="true">
        <template #header> Curso </template>
        <template #default>
            <t-list :radius="5" color="solid-white">
                <t-list-item :active="true">
                    <template #title> Nome: </template>
                    <template #default>
                        {{ formando.nome }}
                    </template>
                </t-list-item>
                <t-list-item :active="true">
                    <template #title> CPF: </template>
                    <template #default>
                        {{ formando.cpf }}
                    </template>
                </t-list-item>
                <t-list-item :active="true">
                    <template #title> email: </template>
                    <template #default>
                        {{ formando.email }}
                    </template>
                </t-list-item>
                <t-list-item :active="true">
                    <template #title> Linkedin: </template>
                    <template #default>
                        {{ formando.redes.linkedin }}
                    </template>
                </t-list-item>
                <t-list-item :active="true">
                    <template #title> WhatsApp: </template>
                    <template #default>
                        {{ formando.redes.whatsapp }}
                    </template>
                </t-list-item>
            </t-list>
            <br>

            <div v-for="curso in formando.cursos" :key="curso.id">
                <t-list :radius="5" color="solid-white">
                    <t-list-item :active="true">
                        <template #title> Referência: </template>
                        <template #default>
                            {{curso.referencia}}
                        </template>
                    </t-list-item>
                    <t-list-item :active="false">
                        <template #title>Nome: </template>
                        <template #default>
                            {{curso.nome}}
                        </template>
                    </t-list-item>
                    <t-list-item :active="false" v-if="curso.radioSim">
                        <template #title>Melhor no curso: </template>
                        <template #default>
                            Sim
                        </template>
                    </t-list-item>
                    <t-list-item :active="false" v-else>
                        <template #title>Melhor no curso: </template>
                        <template #default>
                            Não
                        </template>
                    </t-list-item>
                </t-list>
            </div>

            <template>
                <button
                    class="button mt-3 text-white rounded-xl border-blue-500 bg-blue-500 hover:text-blue-700 hover:bg-blue-100 h-10"
                    @click="backView">
                    Voltar
                </button>
            </template>
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



export default {
    props: {
        formando: Object,
        formando: Object,
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
.containerCertificado {
    margin: 16px;
    border: solid 1px rgba(0, 0, 0, 0.5);
    border-radius: 10px;
    --tw-border-opacity: 1;
}

.formando {
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
    