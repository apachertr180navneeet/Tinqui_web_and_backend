<template>
    <div class="w-full">
        <div class="w-full">
            <ps-label
                class="mt-6 lg:text-base font-medium text-sm"
                textColor="text-feSecondary-800 dark:text-feSecondary-300"
            >
                {{ $t("item_list__price_range") }}
            </ps-label>
            <div class="grid grid-cols-2 gap-2">
                <ps-input
                    theme="dark:bg-feSecondary-800 dark:text-feSecondary-300"
                    type="text"
                    class="w-full"
                    v-bind:placeholder="$t('item_list__min')"
                    v-model:value="itemProvider.paramHolder.minPrice"
                    @keypress="checkPrice($event)"
                    @keyup.enter="pricerangeItemFilterClicked"
                />
                <ps-input
                    theme="dark:bg-feSecondary-800 dark:text-feSecondary-300"
                    type="text"
                    class="w-full"
                    v-bind:placeholder="$t('item_list__max')"
                    v-model:value="itemProvider.paramHolder.maxPrice"
                    @keypress="checkPrice($event)"
                    @keyup.enter="pricerangeItemFilterClicked"
                />
            </div>
        </div>
    </div>

    <ps-loading-dialog ref="ps_loading_dialog" class="z-40" />
    <ps-error-dialog ref="ps_error_dialog" />
</template>

<script lang="ts">
// Libs
import { ref } from "vue";
import { trans } from "laravel-vue-i18n";
// Components
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialog/PsErrorDialog.vue";
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
//Utils
import PsUtils from "../../../../../../../../../TemplateCore/utils/PsUtils";

export default {
    name: "ItemFilterPriceRangeInput",
    components: {
        PsLabel,
        PsInput,
        PsLoadingDialog,
        PsErrorDialog,
    },
    setup() {
        const psValueStore = PsValueStore();
        const itemProvider = useProductStore("list");
        const ps_loading_dialog = ref();
        const ps_error_dialog = ref();

        function checkPrice(e) {
            const char = String.fromCharCode(e.keyCode); // Get the character
            if (/^[0-9]+$/.test(char)) return true; // Match with regex
            else e.preventDefault(); // If not match, don't add to input text
        }

        async function pricerangeItemFilterClicked() {
            if (
                itemProvider.paramHolder.minPrice != "" &&
                itemProvider.paramHolder.maxPrice != ""
            ) {
                const maxPrice: number = parseFloat(
                    itemProvider.paramHolder.maxPrice.toString()
                );
                const minPrice: number = parseFloat(
                    itemProvider.paramHolder.minPrice.toString()
                );
                if (minPrice >= maxPrice) {
                    ps_error_dialog.value.openModal(
                        trans("item_list__warning"),
                        trans("item_list__invalid_min_max_prices")
                    );
                    return;
                }
            }
            ps_loading_dialog.value.openModal();
            PsUtils.addParamToCurrentUrl(
                itemProvider.getURLforListByParam(itemProvider.paramHolder)
            );
            await itemProvider.resetProductList(
                psValueStore.getLoginUserId(),
                itemProvider.paramHolder
            );
            ps_loading_dialog.value.closeModal();
            //hide popup filter
            itemProvider.showPopUpFilter = false;
        }

        return {
            checkPrice,
            ps_loading_dialog,
            ps_error_dialog,
            itemProvider,
            pricerangeItemFilterClicked,
        };
    },
};
</script>
