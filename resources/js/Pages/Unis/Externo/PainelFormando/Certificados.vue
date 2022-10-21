<template>
    <div class="min-w-full min-h-full" style="position: absolute; background-color: #fafafa;">
        <img class="imgInicio" src="/img/certificados/fundoCima.png" alt="">
        <div class="fundo">

            <div class="content">

                <h2 class="nomeCurso">Certificados Unis </h2>
                <div :key="keyPai" class="flex flex-col w-full justify-center items-center">
                    <div v-for="(curso,index) in cursos" :key="curso.id"
                        class="flex flex-col w-full justify-center items-center  mt-2 mb-2">
                        <button :class="
                            spinLoadingDownload[index] != true
                                ? 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                                : 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-200 to-blue-100 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                        " @click="certificado(curso.id,index,curso.nome)">
                            <span v-if="spinLoadingDownload[index] == false">Download Certificado {{curso.nome}}</span>
                            <t-svg :spinLoading="spinLoadingDownload[index]"> </t-svg>
                        </button>
                        <button :class="
                            spinLoadingVincular[index] != true
                                ? 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                                : 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-200 to-blue-100 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                        " @click="vincular(curso.id,index)">
                            <span v-if="spinLoadingVincular[index] == false">Vincular {{curso.nome}} ao Linkedin</span>
                            <t-svg :spinLoading="spinLoadingVincular[index]"> </t-svg>
                        </button>

                    </div>
                </div>
                <a @click="voltar()">
                    <span v-if="spinLoadingVoltar == false">
                        <t-badge class="hover:bg-gray-50 hover:text-gray-700" :radius="8" color="light-gray">Voltar
                        </t-badge>
                    </span>
                    <t-svg :spinLoading="spinLoadingVoltar"> </t-svg>
                </a>
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
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import TFormContent from "@/Components/Form/TFormContent";
import TFormSection from "@/Components/Form/TFormSection";
import TPlusIcon from "@/Components/Icon/TPlusIcon";
import TCheckIcon from "@/Components/Icon/TCheckIcon";
import TInputTextArea from "@/Components/Form/Inputs/TInputTextArea";
import TInputSelect from "@/Components/Form/Inputs/TInputSelect";
import TInputFile from "@/Components/Form/Inputs/TInputFile";
import TInputCheckBox from "@/Components/Form/Inputs/TInputCheckBox";
import TInputRadioButton from "@/Components/Form/Inputs/TInputRadioButton";
import TBellIcon from "@/Components/Icon/TBellIcon";
import TInputMultiSelect from "@/Components/Form/Inputs/TInputMultiSelect";
import TSvg from "@/Components/Svg/TSvg.vue";
import axios from "axios";


export default {
    props: {
        errors: Object,
        formando: Object,
        cursos: Array,
        user: Object
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
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetActionMessage,
        JetSecondaryButton,
        TFormContent,
        TFormSection,
        TPlusIcon,
        TCheckIcon,
        TInputTextArea,
        TInputSelect,
        TInputFile,
        TInputCheckBox,
        TInputRadioButton,
        TBellIcon,
        TInputMultiSelect,
        TSvg
    },



    data() {
        return {
            spinLoadingDownload: [],
            spinLoadingVincular: [],
            spinLoadingVoltar: false,
            keyPai: 0,

            photoPreview: null,
            spinLoadingEnviado: false,
            form: this.$inertia.form({
                _method: "POST",
                cursoId: null,
                formandoId: this.formando.id
            }),
        };
    },
    beforeMount() {
        this.atualizaDados();
    },
    methods: {
        atualizaDados() {
            this.cursos.forEach((index, element) => {
                this.spinLoadingDownload.push(false);
                this.spinLoadingVincular.push(false);
            });
            this.keyPai++;
        },
        certificado(cursoId, index, cursoNome) {
            this.spinLoadingDownload[index] = true;
            this.keyPai++;

            this.form.cursoId = cursoId;


            if (this.success != null) {
                this.success = null;
            }
            this.spinLoading = true;
            this.form.post(route("download-certificado"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (this.spinLoading = false),
                onError: () => (this.spinLoading = false),
            });
            this.loading = true;
        },

        vincular(cursoId, index) {
            this.spinLoadingVincular[index] = true;
            this.keyPai++;
            var nomeCurso = null;
            var hashCurso = null;
            var dateArray = null;
            var mesEmissao = null;
            var anoEmissao = null;

            this.cursos.forEach(element => {
                if (element.id == cursoId) {
                    nomeCurso = element.nome;
                }
            });
            this.formando.cursos.forEach(element => {
                if (element.idCurso == cursoId) {
                    dateArray = element.dataEmissao.split("-");
                    mesEmissao = dateArray[1]
                    anoEmissao = dateArray[0]
                    hashCurso = element.hashCurso;
                }
            });
            var urlLinkedin = window.location.protocol + "//" + window.location.host + "/busca-formando/" + hashCurso;
            var url = `https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name=${nomeCurso}&organizationId=552895&issueYear=${anoEmissao}&issueMonth=${mesEmissao}&certUrl=${urlLinkedin}&certId=${hashCurso}`;
            window.open(encodeURI(url), '_blank');

            this.spinLoadingVincular[index] = false;
            this.keyPai++;
        },
        voltar() {
            this.spinLoadingVoltar = true;
            window.location.href = "painel-formando";
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
    padding: 5vw 18.5vw;
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
    margin: 8px 0px 2px 0px;
    align-self: center;
    font-size: 3vw;
    font-weight: 500;
    color: rgb(0 44 82 / 90%);
    text-align: center;
}

.subtituloCurso {
    margin: 0px 0px 15px 0px;
    align-self: center;
    font-size: 1.5vw;
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

    .subtituloCurso {
        margin: 0px 0px 15px 0px;
        align-self: center;
        font-size: 4vw;
        font-weight: 500;
        color: rgb(0 44 82 / 90%);
        text-align: center;
    }


    .titleDireito {
        font-size: 3.8vw;
    }

    .esconde {
        display: none;
    }

}
</style>