<template>
    <div class="min-w-full min-h-full" style="position: absolute; background-color: #fafafa;">
        <img class="imgInicio" src="/img/certificados/fundoCima.png" alt="">
        <div class="fundo">

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
                        <span>Seu arquivo dever ser do tipo: JPG | JPEG | PNG </span>
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
                        <span>Seu arquivo deve ter o tamanho menor que 64MB</span>
                    </div>
                </template>
            </t-modal>
            <div class="content">

                <h2 class="nomeCurso">Certificados Unis</h2>
                <h2 class="subtituloCurso">Atualize seus dados.</h2>
                <div class="w-full flex flex-col md:flex-row mb-8 phone:w-4/5 tablet:w-4/5 desktop:w-2/5">
                    <!-- Profile Photo -->
                    <t-input-group v-if="$page.props.jetstream.managesProfilePhotos"
                        class="flex flex-shrink-0 items-center md:items-start px-4" label="Foto" label-for="photo">
                        <!-- Profile Photo File Input -->
                        <input ref="photo" class="hidden" type="file" @change="updatePhotoPreview" />

                        <!-- Current Profile Photo -->
                        <div v-show="!photoPreview" class="relative w-28 h-28">
                            <img :alt="formando.nome"
                                :src="formando.profile_photo_path?formando.profile_photo_path:'img/certificados/perfilDeafult.png'"
                                class="rounded-full h-28 w-28 object-cover border-2" />
                            <!--Add Button-->
                            <button v-if="!fotoAlterada"
                                class="absolute right-0 top-0 button bg-green-500 border-green-500 hover:bg-green-100 hover:text-green-700 text-gray-100 hover:bg-green-100 hover:text-green-700 rounded-full h-8 w-8 text-sm"
                                type="button" @click.prevent="selectNewPhoto">
                                <t-plus-icon class="w-5 h-5 -mx-1" />
                            </button>
                            <!--Delete Button-->
                            <button v-if="fotoAlterada"
                                class="absolute right-0 top-0 button bg-red-500 border-red-500 hover:bg-red-100 hover:text-red-700 text-gray-100 hover:bg-red-100 hover:text-red-700 rounded-full h-8 w-8 text-sm"
                                type="button" @click.prevent="deletePhoto">
                                <t-x-icon class="w-5 h-5 -mx-1" />
                            </button>
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div v-show="photoPreview" class="relative">
                            <span :style="
                                'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                                photoPreview +
                                '\');'
                            " class="block rounded-full w-28 h-28 border-2">
                            </span>
                            <!--Delete Button-->
                            <t-button v-if="$refs.photo" :radius="8" class="absolute right-0 top-0" color="solid-red"
                                size="sm" type="button" @click.native.prevent="deletePhoto">
                                <t-x-icon class="w-5 h-5 -mx-1" />
                            </t-button>
                        </div>

                        <jet-input-error :message="form.errors.photo" class="mt-2" />
                    </t-input-group>

                    <t-input-group class="col-span-12 md:col-span-6 mb-2" label="Nome" labelFor="nome">
                        <t-input-text id="nome" v-model="form.nome" placeholder="Nome" />
                        <div v-if="errors">
                            <div v-for="errors in errors.customer" :key="errors.id">
                                <t-alert v-if="errors.includes('dadosCurriculo.nome')"
                                    class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                    :radius="5">
                                    <b>
                                        {{ errors }}
                                    </b>
                                </t-alert>
                            </div>
                        </div>
                    </t-input-group>

                    <t-input-group class="col-span-12 md:col-span-6 mb-2" label="Whatsapp" labelFor="linkWhatsapp">
                        <div class="inline-flex flex-wrap items-center gap-2 mb-1">
                            <t-input-radio-button :checked="checkedWhatsappSim" v-model="radioLogo1" :radius="3"
                                color="solid-green" input-value="1" label="Sim">
                                <template #icon>
                                    <t-check-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>

                            <t-input-radio-button :checked="checkedWhatsappNao" v-model="radioLogo1" :radius="3"
                                color="solid-red" input-value="2" label="Não">
                                <template #icon>
                                    <t-x-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>
                        </div>
                        <t-input-text v-if="radioLogo1 == 1" id="linkWhatsapp" v-model="form.linkWhatsapp"
                            placeholder="Whatsapp" v-mask="'+55 (##)#####-####'" />
                        <div v-if="errors">
                            <div v-for="errors in errors.customer" :key="errors.id">
                                <t-alert v-if="errors.includes('dadosCurriculo.linkWhatsapp')"
                                    class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                    :radius="5">
                                    <b>
                                        {{ errors }}
                                    </b>
                                </t-alert>
                            </div>
                        </div>
                    </t-input-group>

                    <t-input-group class="col-span-12 md:col-span-6 mb-2" label="Link Linkedin" labelFor="linkLinkedin">
                        <div class="inline-flex flex-wrap items-center gap-2 mb-1">
                            <t-input-radio-button :checked="checkedLinkedinSim" v-model="radioLogo2" :radius="3"
                                color="solid-green" input-value="1" label="Sim">
                                <template #icon>
                                    <t-check-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>

                            <t-input-radio-button :checked="checkedLinkedinNao" v-model="radioLogo2" :radius="3"
                                color="solid-red" input-value="2" label="Não">
                                <template #icon>
                                    <t-x-icon class="w-5 h-5" />
                                </template>
                            </t-input-radio-button>
                        </div>
                        <t-input-text v-if="radioLogo2 == 1" id="linkLinkedin" v-model="form.linkLinkedin"
                            placeholder="https://www.linkedin.com/in/SEU-PERFIL/" />
                        <div v-if="errors">
                            <div v-for="errors in errors.customer" :key="errors.id">
                                <t-alert v-if="errors.includes('dadosCurriculo.linkLinkedin')"
                                    class="h-fit mt-1.5 col-span-12 md:col-span-6" color="light-red" :closeable="true"
                                    :radius="5">
                                    <b>
                                        {{ errors }}
                                    </b>
                                </t-alert>
                            </div>
                        </div>
                    </t-input-group>
                </div>

                <div class="flex flex-col w-full justify-center items-center mb-8">
                    <button :class="
                        spinLoadingAtualizar != true
                            ? 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                            : 'mb-2 button bg-gradient-to-r from-blue-700 via-blue-200 to-blue-100 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 desktop:w-2/5 phone:w-4/5 tablet:w-4/5 text-center text-xl botaoEsquerda'
                    " @click="atualizar()">
                        <span v-if="spinLoadingAtualizar == false">Atualizar</span>
                        <t-svg :spinLoading="spinLoadingAtualizar"> </t-svg>
                    </button>
                    <a @click="voltar()">
                        <span v-if="spinLoadingVoltar == false">
                            <t-badge class="hover:bg-gray-50 hover:text-gray-700" :radius="8" color="light-gray">Voltar
                            </t-badge>
                        </span>
                        <t-svg :spinLoading="spinLoadingVoltar"> </t-svg>
                    </a>
                </div>
                <div class="mt-3 mb-3" v-if="alterado">
                    <!-- Mensagem de Sucesso -->
                    <t-alert class="!m-auto !w-4/5 col-span-4" color="solid-green" :closeable="true" :radius="5"
                        :timer="5000">
                        <b>{{ alterado }}</b>
                    </t-alert>
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


export default {
    props: {
        errors: Object,
        permissoes: Array,
        formando: Object,
        cursos: Array,
        user: Object,
        alterado: String
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
            radioLogo1: 1,
            radioLogo2: 1,
            checkedWhatsappSim: false,
            checkedWhatsappNao: false,
            checkedLinkedinSim: false,
            checkedLinkedinNao: false,
            spinLoadingVoltar: false,
            spinLoadingAtualizar: false,
            fotoAlterada: false,


            erroArquivo: null,
            componentKeyTipo: 0,
            componentKeySize: 1,
            modalErroTipo: false,
            modalErroSize: false,

            photoPreview: null,
            spinLoadingEnviado: false,
            form: this.$inertia.form({
                _method: "POST",
                nome: this.formando.nome,
                linkWhatsapp: this.formando.redes.whatsapp,
                linkLinkedin: this.formando.redes.linkedin,
                photo: null,
                idFormando: this.formando.id,
            }),
        };
    },
    beforeMount() {
        this.atualizaDados();
    },
    methods: {
        atualizaDados() {
            if (this.formando.redes.whatsapp == '') {
                this.checkedWhatsappSim = false;
                this.checkedWhatsappNao = true;
                this.radioLogo1 = 2;
            } else {
                this.checkedWhatsappSim = true;
                this.checkedWhatsappNao = false;
                this.radioLogo1 = 1;
            }
            if (this.formando.redes.linkedin == '') {
                this.checkedLinkedinSim = false;
                this.checkedLinkedinNao = true;
                this.radioLogo2 = 2;
            } else {
                this.checkedLinkedinSim = true;
                this.checkedLinkedinNao = false;
                this.radioLogo2 = 1;
            }
        },
        selectNewPhoto() {
            this.$refs.photo.click();

        },

        updatePhotoPreview() {
            if (this.$refs.photo.files.length > 1) {
                this.$refs.photo.files.splice(0, 1);
            }
            var validate = true;
            var tipoErro = "";
            switch (this.$refs.photo.files[0].type) {
                case "image/jpg":
                    validate = true;
                    break;
                case "image/jpeg":
                    validate = true;
                    break;
                case "image/png":
                    validate = true;
                    break;
                default:
                    validate = false;
                    tipoErro = "tipo";
                    break;
            }

            if (this.$refs.photo.files[0].size > 64000000) {
                validate = false;
                tipoErro = "tamanho";
            }
            if (!validate) {
                if (tipoErro == "tipo") {
                    this.photoPreview = null;
                    this.$refs.photo.value = null;
                    this.modalErroTipo = true;
                }
                if (tipoErro == "tamanho") {
                    this.photoPreview = null;
                    this.$refs.photo.value = null;
                    this.modalErroSize = true;
                }
            } else {
                this.fotoAlterada = true;
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            }
        },
        deletePhoto() {

            this.fotoAlterada = false;
            this.spinLoadingEnviado = true;
            this.photoPreview = null;
            this.$refs.photo.value = null;
            this.spinLoadingEnviado = false;
        },
        voltar() {
            this.spinLoadingVoltar = true;
            window.location.href = "painel-formando";
        },
        atualizar() {
            if (this.$refs.photo.files.length > 0) {
                this.form.photo = this.$refs.photo.files[0];
            }
            this.spinLoadingAtualizar = true;

            this.form.post(route("atualiza-formando"), {
                errorBag: "customer",
                preserveScroll: false,
                onSuccess: () => (this.spinLoadingAtualizar = false),
                onError: () => (this.spinLoadingAtualizar = false),
            });
            this.loading = true;
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