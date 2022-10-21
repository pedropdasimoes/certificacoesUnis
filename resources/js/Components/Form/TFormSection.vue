<template>
    <div
        v-if="drag != 'true'"
        class="md:grid md:grid-cols-3 md:gap-6 space-y-4"
    >
        <!--Section Header-->
        <div class="md:col-span-1">
            <div class="p-4">
                <!--Title-->
                <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
                <!--Description-->
                <p class="mt-1 text-sm text-gray-600">{{ description }}</p>
            </div>
        </div>
        <!--Section Content-->
        <div class="mt-5 md:mt-0 md:col-span-2 border rounded-md shadow m-4">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-12 gap-4">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="mx-4 flex flex-col items-center justify-center">
        <!--Section Header-->
        <div class="md:col-span-1">
            <div class="mt-4">
                <h3 class="text-xl font-bold text-gray-900">
                    {{ titleInterno }}
                </h3>
            </div>
        </div>
        <!--Section Content-->
        <div
            class="mt-5 md:mt-0 md:col-span-2 border rounded-md shadow m-4 w-full"
        >
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="flex justify-center flex-wrap w-full">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["title", "titleInterno", "description", "drag"],
    components: {},

    computed: {},

    methods: {
        reset() {
            this.$emit("reset");
        },
    },
};
</script>
