<template>
    <div class="w-full">
        <form :enctype="enctype" @submit.prevent="$emit('submitted')">
            <!--Form Body-->
            <div
                class="mt-5 md:mt-0 md:col-span-2 bg-white shadow sm:rounded-md"
            >
                <slot></slot>
                <!--Form Buttons Container-->
                <transition duration="500" name="status">
                    <div
                        v-if="
                            submitButton ||
                                resetButton ||
                                loading ||
                                $slots.status ||
                                $slots.button + '-area'
                        "
                        class="flex flex-wrap col-span-12 justify-center tablet:justify-end space-x-2 mr-4 py-4"
                    >
                        <!--Extra Form Buttons Area-->
                        <slot name="button-area" />
                        <!--Status Area-->
                        <slot v-if="$slots.status" name="status" />
                        <!--Default Form Buttons-->
                        <div
                            v-else
                            class="flex flex-wrap w-full justify-center tablet:justify-end items-center space-x-2"
                        >
                            <svg
                                v-if="loading"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                style="margin: inherit; background: none; display: block; shape-rendering: auto;"
                                width="40px"
                                height="40px"
                                viewBox="0 0 100 100"
                                preserveAspectRatio="xMidYMid"
                            >
                                <g transform="rotate(0 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.9166666666666666s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(30 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.8333333333333334s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(60 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.75s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(90 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.6666666666666666s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(120 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.5833333333333334s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(150 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.5s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(180 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.4166666666666667s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(210 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.3333333333333333s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(240 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.25s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(270 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.16666666666666666s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(300 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="-0.08333333333333333s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <g transform="rotate(330 50 50)">
                                    <rect
                                        x="47"
                                        y="24"
                                        rx="3"
                                        ry="6"
                                        width="6"
                                        height="12"
                                        fill="#0055a5"
                                    >
                                        <animate
                                            attributeName="opacity"
                                            values="1;0"
                                            keyTimes="0;1"
                                            dur="1s"
                                            begin="0s"
                                            repeatCount="indefinite"
                                        ></animate>
                                    </rect>
                                </g>
                                <!-- [ldio] generated by https://loading.io/ -->
                            </svg>
                            <!--Reset Button-->
                            <t-button
                                v-if="resetButton"
                                :radius="3"
                                color="solid-yellow"
                                type="button"
                                @click.native="reset"
                            >
                                Limpar
                            </t-button>
                            <!--Save Button-->
                            <t-button
                                v-if="submitButton"
                                :disabled="disabled"
                                :radius="3"
                                color="solid-green"
                                icon="plus"
                                type="submit"
                            >
                                Salvar
                            </t-button>
                        </div>
                    </div>
                </transition>

                <div
                    v-if="hasActions"
                    class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6"
                >
                    <slot name="actions"></slot>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import TButton from "@/Components/Button/TButton";

export default {
    props: {
        enctype: String,
        disabled: Boolean,
        resetButton: {
            type: Boolean,
            default: true
        },
        submitButton: {
            type: Boolean,
            default: true
        },
        loading: {
            type: Boolean,
            default: false
        }
    },
    components: {
        TButton
    },

    computed: {
        hasActions() {
            return !!this.$slots.actions;
        }
    },

    methods: {
        reset() {
            this.$emit("reset");
        }
    }
};
</script>

<style>
/*Status Change Effect*/
.status-enter-active,
.status-leave-active {
    transition: all 1s;
}

.status-enter,
.status-leave-to {
    opacity: 0;
}

.status-enter-to,
.status-leave {
    opacity: 1;
}
</style>
