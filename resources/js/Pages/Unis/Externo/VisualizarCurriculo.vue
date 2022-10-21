<template>
    <div style="position: absolute; background-color: #fafafa; width: 100%;">
        <img class="imgInicio" src="/img/certificados/fundoCima.png" alt="">
        <div class="fundo">
            <div class="esquerda">
                <div class="informacaoPessoal">
                    <img class="imgAvatar" :src="getPhoto()" alt="">
                    <h2 class="titleName">{{ formando.nome }}</h2>
                    <div class="redesSociais">
                        <a v-if="whatsapp!='false'" :href="whatsapp" target="_blank" class="btnSocial">
                            <svg class="svgRedes" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"
                                width="25px" height="25px">
                                <path
                                    d="M 15 3 C 8.373 3 3 8.373 3 15 C 3 17.251208 3.6323415 19.350068 4.7109375 21.150391 L 3.1074219 27 L 9.0820312 25.431641 C 10.829354 26.425062 12.84649 27 15 27 C 21.627 27 27 21.627 27 15 C 27 8.373 21.627 3 15 3 z M 10.892578 9.4023438 C 11.087578 9.4023438 11.287937 9.4011562 11.460938 9.4101562 C 11.674938 9.4151563 11.907859 9.4308281 12.130859 9.9238281 C 12.395859 10.509828 12.972875 11.979906 13.046875 12.128906 C 13.120875 12.277906 13.173313 12.453437 13.070312 12.648438 C 12.972312 12.848437 12.921344 12.969484 12.777344 13.146484 C 12.628344 13.318484 12.465078 13.532109 12.330078 13.662109 C 12.181078 13.811109 12.027219 13.974484 12.199219 14.271484 C 12.371219 14.568484 12.968563 15.542125 13.851562 16.328125 C 14.986562 17.342125 15.944188 17.653734 16.242188 17.802734 C 16.540187 17.951734 16.712766 17.928516 16.884766 17.728516 C 17.061766 17.533516 17.628125 16.864406 17.828125 16.566406 C 18.023125 16.268406 18.222188 16.319969 18.492188 16.417969 C 18.766188 16.515969 20.227391 17.235766 20.525391 17.384766 C 20.823391 17.533766 21.01875 17.607516 21.09375 17.728516 C 21.17075 17.853516 21.170828 18.448578 20.923828 19.142578 C 20.676828 19.835578 19.463922 20.505734 18.919922 20.552734 C 18.370922 20.603734 17.858562 20.7995 15.351562 19.8125 C 12.327563 18.6215 10.420484 15.524219 10.271484 15.324219 C 10.122484 15.129219 9.0605469 13.713906 9.0605469 12.253906 C 9.0605469 10.788906 9.8286563 10.071437 10.097656 9.7734375 C 10.371656 9.4754375 10.692578 9.4023438 10.892578 9.4023438 z" />
                            </svg>
                        </a>
                        <a v-if="linkedin!='false'" :href="linkedin" target="_blank" class="btnSocial">
                            <svg class="svgRedes" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"
                                width="25px" height="25px">
                                <path
                                    d="M9,25H4V10h5V25z M6.501,8C5.118,8,4,6.879,4,5.499S5.12,3,6.501,3C7.879,3,9,4.121,9,5.499C9,6.879,7.879,8,6.501,8z M27,25h-4.807v-7.3c0-1.741-0.033-3.98-2.499-3.98c-2.503,0-2.888,1.896-2.888,3.854V25H12V9.989h4.614v2.051h0.065 c0.642-1.18,2.211-2.424,4.551-2.424c4.87,0,5.77,3.109,5.77,7.151C27,16.767,27,25,27,25z" />
                            </svg>
                        </a>
                    </div>
                    <hr class="hrEsquerda">
                </div>
                <div class="formacoes">
                    <h3>Formações</h3>
                    <div v-for="(curso, index) in formando.cursos" :key="curso.id" class="w-full flex justify-center">
                        <button
                            class="button bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-gray-50 filter hover:brightness-125 text-gray-100 filter hover:brightness-125 rounded-md h-12 w-4/5 text-center botaoEsquerda"
                            @click="alteraCurso(index, curso.idCurso)">
                            {{ curso.nome }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="direita">
                <img class="imgSelo" v-if="melhorAluno" src="/img/certificados/selo.png" alt="">
                <div class="titleCurso">
                    <div class="divInternaTitle">
                        <h2 class="nomeCurso">{{ cursos[cursoSelecionado].nome }}</h2>
                        <div class="hrTitle"></div>
                    </div>
                </div>
                <div class="informacoesCurso">
                    <div class="cargaHoraria">
                        <p><span><b>Carga Horária: </b></span>
                            {{ cursos[cursoSelecionado].data.cargaHoraria }}</p>
                    </div>
                    <div class="sobreCurso">
                        <h4 class="titleDireito">Sobre o Curso</h4>
                        <p>
                            {{ cursos[cursoSelecionado].data.sobre }}
                        </p>
                    </div>
                    <div class="modulos">
                        <h4 class="titleDireito">Modulos</h4>
                        <div class="divModulos" v-for="modulo in cursos[cursoSelecionado].data.modulos"
                            :key="modulo.id">
                            <t-collapsible-item color="solid-blue">
                                <template #title> {{ modulo.titulo }} </template>
                                <template #content>
                                    {{ modulo.sobre }}
                                </template>
                            </t-collapsible-item>
                        </div>
                    </div>
                    <div class="requisito">
                        <h4 class="titleDireito">Competências</h4>
                        <p>
                            {{ cursos[cursoSelecionado].data.competencia }}
                        </p>
                    </div>

                    <div class="emitido">
                        <h4 class="titleDireito">Emitido por:</h4>
                        <div class="informacaoFaculdade">
                            <img class="imgUnis" :src="cursos[cursoSelecionado].data.emitido" alt="">
                        </div>
                    </div>
                </div>
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

export default {
    props: {
        formando: Object,
        cursos: Array,
        posicaoCurso: Number,
        whatsapp: String,
        linkedin: String
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
        SshPre
    },
    data() {
        return {
            cursoSelecionado: this.posicaoCurso,
            melhorAluno: false

        };
    },
    mounted() {
        // if (element.idCurso == id) {
        //     if (element.radioSim == true) {
        //         this.melhorAluno = true;
        //     } else {
        //         this.melhorAluno = false;
        //     }
        //     console.log('entrei');
        // }
        this.formando.cursos.forEach(element => {
            if (element.idCurso == this.cursos[this.posicaoCurso].id) {
                if (element.radioSim == true) {
                    this.melhorAluno = true;
                } else {
                    this.melhorAluno = false;
                }
            }
        });
    },
    methods: {
        getPhoto() {
            if (this.formando.profile_photo_path) {
                return this.formando.profile_photo_path;
            } else {
                return window.location.protocol + '//' + window.location.host + '/img/certificados/perfilDeafult.png';
            }

        },
        alteraCurso(index, id) {
            this.cursoSelecionado = index;
            this.formando.cursos.forEach(element => {
                console.log(element.idCurso)
                console.log(id)
                if (element.idCurso == id) {
                    if (element.radioSim == true) {
                        this.melhorAluno = true;
                    } else {
                        this.melhorAluno = false;
                    }
                }
            });
        },
    },

};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap');



* {
    padding: 0;
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
    align-items: flex-start;
    margin: auto;
    padding-top: 15vh;
    padding-bottom: 15vh;
    padding-left: 7.5vw;
    padding-right: 7.5vw;
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

.svgRedes {
    cursor: pointer;
    fill: rgb(0 98 183 / 90%);
}

.svgLinkedin {
    cursor: pointer;
    fill: rgb(0 98 183 / 90%);
}

.svgRedes:hover {
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


.direita {
    height: fit-content;
    width: 100%;
    background-color: #fff;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    padding: 2vh 2vw;
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

.imgSelo {
    width: 10vw;
    position: absolute;
    right: -5vw;
    top: -5vw;
}

@media (max-width : 600px) {
    * {
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
        font-size: 2.2vw;
    }

    .fundo {
        flex-direction: column;
    }

    .esquerda {
        width: 100%;
        margin-bottom: 15px;
    }


    .fundo {
        padding-top: 10vh;
        padding-bottom: 10vh;
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
        font-size: 5vw;
    }


    .titleDireito {
        font-size: 3.8vw;
    }


}
</style>