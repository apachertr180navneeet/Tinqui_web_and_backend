<template>
    <!-- Category -->
    <ps-label
        class="mt-6 lg:text-base font-medium text-sm"
        textColor="text-feSecondary-800 dark:text-feSecondary-300"
    >
        {{ $t("category_list__title") }}
    </ps-label>
    <ps-dropdown align="left" class="mt-1 lg:mt-2" @onClick="loadCategory">
        <template #select>
            <ps-dropdown-select
                placeholderLang="item_list__all"
                border="border dark:border-feSecondary-200"
                :selectedValue="$t(itemProvider.paramHolder.catName)"
            />
        </template>
        <template #list>
            <div class="rounded-md shadow-xs w-56">
                <div class="pt-2 z-30">
                    <div v-if="categoryStore.itemList.data == null">
                        <ps-label class="p-2 flex" @click="loadCategory">
                            {{ $t("list__loading") }}
                        </ps-label>
                    </div>
                    <div v-else>
                        <div
                            class="w-72 flex py-4 px-2 hover:bg-fePrimary-50 dark:hover:bg-feAchromatic-800 cursor-pointer items-center"
                            @click="
                                categoryFilterClicked({
                                    catId: '',
                                    catName: $t('item_list__all'),
                                })
                            "
                        >
                            <ps-label
                                class="ms-2"
                                :class="
                                    itemProvider.paramHolder.catId == ''
                                        ? ' font-medium'
                                        : 'font-light'
                                "
                            >
                                {{ $t("item_list__all") }}
                            </ps-label>
                        </div>
                        <div
                            v-for="selectData in categoryStore.itemList.data"
                            :key="selectData.catId"
                            class="w-72 flex py-4 px-2 hover:bg-fePrimary-50 dark:hover:bg-feAchromatic-800 cursor-pointer items-center"
                            @click="categoryFilterClicked(selectData)"
                        >
                            <ps-label
                                class="ms-2"
                                :class="
                                    selectData.catId ==
                                    itemProvider.paramHolder.catId
                                        ? ' font-medium'
                                        : 'font-light'
                                "
                            >
                                {{ $t(selectData.catName) }}
                            </ps-label>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #loadmore>
            <div class="mb-2 w-56">
                <div
                    v-if="
                        categoryStore.itemList.data != null &&
                        categoryStore.loading.value == true
                    "
                    class="mt-4 ms-4 flex"
                >
                    <ps-label-caption>
                        {{ $t("list__loading") }}
                    </ps-label-caption>
                </div>

                <ps-label
                    class="mt-4 ms-4 mb-2 underline font-medium cursor-pointer flex"
                    v-if="!categoryStore.isNoMoreRecord"
                    @click="loadCategory"
                >
                    {{ $t("list__load_more") }}
                </ps-label>
            </div>
        </template>
    </ps-dropdown>
    <ps-loading-dialog ref="ps_loading_dialog" class="z-40" />
</template>

<script>
// Libs
import { ref, defineAsyncComponent } from "vue";
// Components
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
const PsDropdown = defineAsyncComponent(() =>
    import("@template1/vendor/components/core/dropdown/PsDropdown.vue")
);
import PsDropdownSelect from "@template1/vendor/components/core/dropdown/PsDropdownSelect.vue";
import PsLabelCaption from "@template1/vendor/components/core/label/PsLabelCaption.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useCategoryStoreState } from "@templateCore/store/modules/category/CategoryStore";
import { useSubCategoryStoreState } from "@templateCore/store/modules/subCategory/SubCategoryStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
//Utils
import PsUtils from "../../../../../../../../../TemplateCore/utils/PsUtils";

export default {
    name: "ItemFilterCategoryDropdown",
    components: {
        PsLabel,
        PsDropdown,
        PsDropdownSelect,
        PsLabelCaption,
        PsLoadingDialog,
    },
    setup() {
        const psValueStore = PsValueStore();
        const categoryStore = useCategoryStoreState("cat");
        const subCategoryStore = useSubCategoryStoreState();
        const itemProvider = useProductStore("list");
        const ps_loading_dialog = ref();
        // const subcatHolder = new SubCategoryListParameterHolder();

        function loadCategory() {
            categoryStore.loadItemList(
                psValueStore.getLoginUserId(),
                categoryStore.paramHolder
            );
        }

        async function categoryFilterClicked(value) {
            itemProvider.paramHolder.catId = value.catId;
            itemProvider.paramHolder.catName = value.catName;
            itemProvider.paramHolder.subCatId = "";
            itemProvider.paramHolder.subCatName = "";

            PsUtils.addParamToCurrentUrl(
                itemProvider.getURLforListByParam(itemProvider.paramHolder)
            );

            ps_loading_dialog.value.openModal();
            await itemProvider.resetProductList(
                psValueStore.getLoginUserId(),
                itemProvider.paramHolder
            );
            subCategoryStore.resetSubCategoryList(value.catId);
            ps_loading_dialog.value.closeModal();

            //hide popup filter
            itemProvider.showPopUpFilter = false;
        }

        return {
            categoryStore,
            itemProvider,
            loadCategory,
            categoryFilterClicked,
            ps_loading_dialog,
        };
    },
};
</script>
