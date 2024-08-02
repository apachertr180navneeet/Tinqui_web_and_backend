<template>
    <div
        class="bg-feSecondary-50 dark:bg-feSecondary-800 rounded-lg px-2 py-4 lg:p-4 flex justify-between items-center"
    >
        <ps-label
            textColor="text-xl font-semibold text-feSecondary-800 dark:text-feSecondary-50"
        >
            {{ text }}
        </ps-label>
        <ps-label
            textColor="text-sm font-medium text-feInfo-600 cursor-pointer"
            @click="clickLeranMore"
            >{{ $t("item_detail__learn_more") }}</ps-label
        >
    </div>
</template>

<script>
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";

export default {
    name: "ItemDetailLearnMoreCard",
    components: {
        PsLabel,
    },

    props: {
        clickLeranMore: {
            type: Function,
        },
        text: String,
    },
};
</script>
