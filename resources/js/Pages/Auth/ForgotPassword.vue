<template>
    <t-forgot
        color="solid-blue"
        bg-color="light-gray"
        :radius="5"
        button-color="solid-blue"
        :status="status"
    >
        <!--Logo-->
        <template #logo>
            <inertia-link href="/">
                <div class="flex flex-col justify-center items-center w-full">
                    <t-logo class="w-12 h-12" />
                    <span class="text-3xl">Unis Recrutamento</span>
                </div>
            </inertia-link>
        </template>
        <!--Greeting-->
        <template #greeting>
            <b>Esqueceu sua senha? Sem problemas.</b>
        </template>
        <!--Greeting Sub-->
        <template #subGreeting>
            Digite seu email e nós enviaremos um link para resetar sua senha.
        </template>
    </t-forgot>
</template>

<script>
import TForgot from "@/Components/Auth/TForgot";
import TLogo from "@/Components/Icon/TLogo";
export default {
    components: { TLogo, TForgot },
    props: {
        status: String,
    },
};
</script>
