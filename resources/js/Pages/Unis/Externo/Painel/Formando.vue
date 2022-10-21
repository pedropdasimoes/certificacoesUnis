<template>
    <div class="min-w-full min-h-full" style="position: absolute; background-color: #fafafa;">
        <img class="imgInicio" src="/img/certificados/fundoCima.png" alt="">
        <div class="fundo">

            <div class="content">
                <h2 class="nomeCurso">Certificados Unis</h2>
                <div class="flex flex-col w-full justify-center items-center">
                    <t-input-group class="desktop:w-2/5 phone:w-4/5 tablet:w-4/5 mb-2" label="Email" labelFor="email">
                        <t-input-text id="email" type="email" v-model="form.email" placeholder="Email" />
                        <div v-if="spanErroEmail">
                            <t-alert class="h-fit mt-1.5" color="light-red" :closeable="true" :radius="5">
                                <b>
                                    {{spanErroEmail}}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>
                    <t-input-group class="desktop:w-2/5 phone:w-4/5 tablet:w-4/5 mb-2" label="Senha"
                        labelFor="password">
                        <t-input-text id="password" type="password" v-model="form.password" placeholder="Senha" />
                        <div v-if="spanErroSenha">
                            <t-alert class="h-fit mt-1.5" color="light-red" :closeable="true" :radius="5">
                                <b>
                                    {{spanErroSenha}}
                                </b>
                            </t-alert>
                        </div>
                    </t-input-group>
                    <button :class="
                        spinLoadingLogar != true
                            ? 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                            : 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-200 to-blue-100 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                    " @click="entraConta()">
                        <span v-if="spinLoadingLogar == false">Entrar</span>
                        <t-svg :spinLoading="spinLoadingLogar"> </t-svg>
                    </button>

                    <a @click="voltarFormando()">
                        <span v-if="spinLoadingVoltar == false">
                            <t-badge class="hover:bg-gray-50 hover:text-gray-700" :radius="8" color="light-gray">Voltar
                            </t-badge>
                        </span>
                        <t-svg :spinLoading="spinLoadingVoltar"> </t-svg>
                    </a>
                </div>
                <img src="https://portal.unis.edu.br/hubfs/Brand%20Center/2020/Grupo%20Unis/Logomarca%20Grupo%20Unis.png?hsLang=pt-br"
                    alt="" style="width:100px;">

            </div>
        </div>
        <img class="imgFim" src="/img/certificados/fundoBaixo.png" alt="" />
    </div>
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
import TButton from "@/Components/Button/TButton";
import SshPre from 'simple-syntax-highlighter'
import 'simple-syntax-highlighter/dist/sshpre.css'
import TLogo from "@/Components/Icon/TLogo";
import TInputGroup from "@/Components/Form/TInputGroup";
import TInputText from "@/Components/Form/Inputs/TInputText";
import TXIcon from "@/Components/Icon/TXIcon";
import TBanIcon from "@/Components/Icon/TBanIcon";
import TModal from "@/Components/Modal/TModal";
import TBadge from "@/Components/Badge/TBadge";
import Papa from 'papaparse';
import axios from "axios";
import TSvg from "@/Components/Svg/TSvg.vue";

export default {
    props: {
        errors: Object,
        spanErroEmail: String,
        spanErroSenha: String
    },
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
        TCollapsibleItem,
        TButton,
        SshPre,
        TLogo,
        TInputGroup,
        TInputText,
        TXIcon,
        TBanIcon,
        TModal,
        TBadge,
        Papa,
        axios,
        TSvg
    },
    data() {
        return {
            spinLoadingLogar: false,
            spinLoadingVoltar: false,
            errorCodigo: false,

            form: this.$inertia.form({
                _method: "POST",
                email: null,
                password: null,
            }),
        };
    },
    beforeMount() {
        this.inicia();
    },
    methods: {
        inicia() {
            // window.location.replace('view-formando');
            // var Backlen = history.length;
            // history.go(-Backlen);
            // window.location.href = "view-formando";

        },
        entraConta() {
            this.spanErroEmail = null;
            this.spanErroSenha = null;
            this.spinLoadingLogar = true;

            this.form.post(route("painel-formando"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (this.spinLoadingLogar = false),
                onError: () => (this.spinLoadingLogar = false),
            });
            this.loading = true;
        },

        voltarFormando() {
            this.spinLoadingVoltar = true;
            window.location.href = "/";
        },
    },

};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap');



* {
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
    font-size: 1vw;
}

ul,
li,
a {
    outline: none;
    text-decoration: none;
    list-style: none;
}


.fundo {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    width: 100%;
    margin: auto;
    padding-left: 18.5vw;
    padding-right: 18.5vw;
    height: 100%;
    z-index: 999;
    position: relative;
}

.esquerda {
    height: fit-content;
    width: 35%;
    margin-right: 2vw;
    border-radius: 15px;
    display: flex;
    align-items: center;
    flex-direction: column;
    background: rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.imgAvatar {
    width: 12vw;
    height: 12vw;
    border-radius: 15px;
    margin-top: -45px;
}

.informacaoPessoal {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.titleName {
    margin: 10px 25px;
    font-size: 2vw;
    padding: 4px;
    text-align: center;
    color: #FFF;
    background: rgb(0 98 183 / 90%);
    box-shadow: 0 8px 32px 0 rgb(31 38 135 / 37%);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.redesSociais {
    display: flex;
    margin-bottom: 5px;
}

.btnSocial {
    border: none;
    background-color: transparent;
}

.svgFacebook {
    cursor: pointer;
    fill: rgb(0 98 183 / 90%);
}

.svgLinkedin {
    cursor: pointer;
    fill: rgb(0 98 183 / 90%);
}

.svgFacebook:hover {
    cursor: pointer;
    fill: rgba(0, 29, 53, 0.9);
}

.svgLinkedin:hover {
    cursor: pointer;
    fill: rgba(0, 29, 53, 0.9);
}

.hrEsquerda {
    width: 80%;
    margin-top: 10px;
    background-color: rgb(0 89 162 / 15%);
}

.formacoes {
    width: 100%;
    padding-bottom: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.formacoes h3 {
    margin: 10px 0px;
    font-size: 2.2vw;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
}



.informacaoFaculdade {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 0;
}

.imgUnis {
    width: 10vw;
}


.content {
    height: fit-content;
    width: 100%;
    background-color: #fff;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    min-height: 60vh;
    padding: 8vh 2vw;
    background: rgba(255, 255, 255, 0.4);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.titleCurso {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.nomeCurso {
    margin: 15px 0px 5px 0px;
    align-self: center;
    font-size: 3vw;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
    text-align: center;
}

.divInternaTitle {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.hrTitle {
    width: 80%;
    height: 3px;
    background-color: rgb(0 81 255 / 90%);
    border-radius: 5px;
}

.cargaHoraria {
    display: flex;
}

.sobreCurso {
    margin: 15px 0;

}

.titleDireito {
    font-size: 2.2vw;
    margin-bottom: 8px;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
}


.sobreCurso p {
    text-align: justify;
}

.modulos {
    margin-bottom: 25px;
}

.requisito {
    margin-bottom: 25px;
}

.emitido {
    margin-bottom: 25px;
}

.divModulos div:first-child {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.divModulos div:last-child {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.imgInicio {
    width: 50vw;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.imgFim {
    width: 50vw;
    position: absolute;
    bottom: 0;
    right: 0;
    z-index: 1;
}

.botaoEsquerda {
    white-space: normal !important;
    word-wrap: break-word !important;
    height: fit-content !important;
    min-height: 50px !important;
}


.esconde {
    display: none;
}

@media (max-width : 600px) {
    * {
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
        font-size: 3.2vw;
    }



    .esquerda {
        width: 100%;
        margin-bottom: 15px;
    }


    .fundo {
        padding-left: 5.5vw;
        padding-right: 5.5vw;
    }

    .imgAvatar {
        width: 20vw;
        height: 20vw;
    }

    .titleName {
        font-size: 5vw;
        padding: 5px 15px;
    }

    .formacoes h3 {
        font-size: 4.8vw;
    }


    .imgUnis {
        width: 25vw;
    }



    .nomeCurso {
        font-size: 8vw;
    }


    .titleDireito {
        font-size: 3.8vw;
    }

    .esconde {
        display: none;
    }

}
</style>