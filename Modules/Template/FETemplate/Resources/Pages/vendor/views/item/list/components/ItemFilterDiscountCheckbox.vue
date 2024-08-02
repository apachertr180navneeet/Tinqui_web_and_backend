<template>
    <div class="mt-6 flex flex-row w-full text-sm font-medium">
        <ps-checkbox-value
            title=""
            class=""
            v-model:value="itemProvider.isDiscount"
            @click="isDiscountFilterClicked"
        />
        <ps-label class="me-2 font-medium text-sm lg:text-base">{{
            $t("item_list__is_discount")
        }}</ps-label>
    </div>
    <ps-loading-dialog ref="ps_loading_dialog" class="z-40" />
</template>

<script>
// Libs
import { ref, onMounted } from "vue";
// Components
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsCheckboxValue from "@template1/vendor/components/core/checkbox/PsCheckboxValue.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
//Utils
import PsUtils from "../../../../../../../../../TemplateCore/utils/PsUtils";

export default {
    name: "ItemFilterDiscountCheckbox",
    components: {
        PsLabel,
        PsCheckboxValue,
        PsLoadingDialog,
    },
    setup() {
        const psValueStore = PsValueStore();
        const itemProvider = useProductStore("list");
        const ps_loading_dialog = ref();

        async function isDiscountFilterClicked() {
            itemProvider.paramHolder.isDiscount =
                itemProvider.isDiscount == false ? "1" : "";
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

        onMounted(() => {
            if (itemProvider.paramHolder.isDiscount == "1") {
                itemProvider.isDiscount = true;
            } else {
                itemProvider.isDiscount = false;
            }
        });

        return {
            itemProvider,
            isDiscountFilterClicked,
            ps_loading_dialog,
        };
    },
};
</script>
