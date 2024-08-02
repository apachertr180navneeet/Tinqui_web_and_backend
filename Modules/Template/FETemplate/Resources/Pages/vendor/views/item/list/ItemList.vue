<template>
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28">
                <div class="flex flex-col sm:flex-row">
                    <div class="flex flex-row sm:mt-0 mt-6">
                        <ps-breadcrumb-2 :items="breadcrumb" />
                    </div>
                    <item-filter-title :query="query" />
                </div>
                <div class="relative mt-4 sm:mt-10 flex flex-row">
                    <div class="w-64 me-5 hidden sm:flex flex-col dark:bg-feSecondary-800 h-full p-4 rounded-lg">
                        <clear-button />
                        <category-drop-down />
                        <sub-category-drop-down v-if="appInfoStore?.isShowSubCategory()" />
                        <discount-checkbox v-if="appInfoStore?.isShowDiscount()" />
                        <price-range-input v-if="!appInfoStore?.isNoPriceSettingOn()" />
                        <custom-field-section />
                        <city-dropdown />
                        <township-dropdown v-if="appInfoStore?.isShowSubLocation()" />
                        <pick-location-button v-if="appInfoStore?.isFilterLocationOn()" />
                        <apply-button />
                    </div>
                    <div class="w-full filter-button">
                        <div class="flex justify-end mb-4">
                            <keyword-input class="sm:block hidden" />
                            <mobile-filter-button />
                        </div>
                        <keyword-input class="sm:hidden mb-4 sm:mb-0 " />
                        <sort-and-type-section :isNoPriceSettingOn="appInfoStore?.isNoPriceSettingOn()
                            " />
                        <div class="flex items-center">
                            <ps-label textColor="text-xs font-medium me-2 dark:text-feSecondary-200">{{
                                $t('core_fe__products_by')
                                }}</ps-label>
                            <ps-dropdown horizontalAlign="right" h="h-auto" class="h-10 w-auto">
                                <template #select>
                                    <ps-button class=" h-10 " colors="bg-feAchromatic-50 dark:bg-feAchromatic-900"
                                        border="border dark:border-feSecondary-400"
                                        focus="focus:outline-none focus:bg-fePrimary-500 focus:ring focus:ring-fePrimary-300 focus:text-feAchromatic-50"
                                        hover="hover:outline-none hover:bg-fePrimary-600 hover:text-feAchromatic-50">
                                        <span class="me-2 font-medium"> {{ activeProductsArrName ?
                                            $t(activeProductsArrName) : $t('core_fe__relevance') }} </span>
                                        <ps-icon class="flex" name="downChervon" />
                                    </ps-button>
                                </template>
                                <template #list>
                                    <div class="rounded-md bg-feAchromatic-50 dark:bg-feSecondary-800 shadow-xs w-44 ">
                                        <div class="pt-2 z-30">
                                            <div>
                                                <div v-for="sort in productsArr" :key="sort.id"
                                                    class="w-72 flex py-4 px-2 hover:bg-fePrimary-50 dark:hover:bg-feSecondary-500 cursor-pointer items-center"
                                                    @click="orderingByProductsClicked(sort)">
                                                    <ps-label class="ms-2"
                                                        :class="sort.id == activeProductsArrId ? ' font-medium' : 'font-light'">{{
                                                            $t(sort.name) }}</ps-label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </ps-dropdown>
                        </div>
                        <item-vertical-list :initial="initial" :list_type="activeProductsArrId" />
                    </div>
                    <div v-if="itemProvider.showPopUpFilter"
                        class="flex justify-between sm:hidden flex-col absolute top-10 right-[40px]">
                        <transition @enter="enter" @leave="leave">
                            <div
                                class="flex flex-col w-68 p-8 h-auto bg-feAchromatic-50 dark:bg-feSecondary-800 shadow-xl rounded-lg">
                                <clear-button />
                                <category-drop-down class="mb-12" />
                                <sub-category-drop-down v-if="appInfoStore?.isShowSubCategory()" />
                                <discount-checkbox v-if="appInfoStore?.isShowDiscount()" />
                                <stock-section :spaceWrap="false" />
                                <price-range-input v-if="!appInfoStore?.isNoPriceSettingOn()" />
                                <custom-field-section />
                                <city-dropdown />
                                <township-dropdown v-if="appInfoStore?.isShowSubLocation()" />
                                <pick-location-button v-if="appInfoStore?.isFilterLocationOn()" />
                                <apply-button />
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
            <div class="mx-auto">
                <ps-ad-sense adFormat="horizontal"></ps-ad-sense>
            </div>
            <ps-loading-dialog ref="ps_loading_dialog" class="z-40" />
        </template>
    </ps-content-container>
</template>

<script>
// Libs
import { onMounted, onUnmounted, ref ,defineAsyncComponent} from "vue";
import { trans } from "laravel-vue-i18n";
//Componets
import PsIcon from '@template1/vendor/components/core/icons/PsIcon.vue';
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsAdSense from "@template1/vendor/components/core/adsense/PsAdSense.vue";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";
import CategoryDropDown from "./components/ItemFilterCategoryDropdown.vue";
import SubCategoryDropDown from "./components/ItemFilterSubCategoryDropdown.vue";
import DiscountCheckbox from "./components/ItemFilterDiscountCheckbox.vue";
import StockSection from "./components/ItemFilterStockSection.vue";
import PriceRangeInput from "./components/ItemFilterPriceRangeInput.vue";
import CustomFieldSection from "./components/ItemFilterCustomFieldSection.vue";
import CityDropdown from "./components/ItemFilterCityDropdown.vue";
import TownshipDropdown from "./components/ItemFilterTownshipDropdown.vue";
import PickLocationButton from "./components/ItemFilterPickLocationButton.vue";
import ItemVerticalList from "./components/ItemFilterItemVerticalList.vue";
import SortAndTypeSection from "./components/ItemFilterSortAndTypeSection.vue";
import ItemFilterTitle from "./components/ItemFilterTitle.vue";
import ApplyButton from "./components/ItemFilterApplyButton.vue";
import KeywordInput from "./components/ItemFilterKeywordInput.vue";
import MobileFilterButton from "./components/ItemFilterMobileFilterButton.vue";
import ClearButton from "./components/ItemFilterClearButton.vue";
const PsDropdown = defineAsyncComponent(() => import('@template1/vendor/components/core/dropdown/PsDropdown.vue'));
import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
import PsLabel from '@template1/vendor/components/core/label/PsLabel.vue';


// Models
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
// Params Holders
import PsConst from "@templateCore/object/constant/ps_constants";
import ProductParameterHolder from "@templateCore/object/holder/ProductParameterHolder";
import AppInfoParameterHolder from "@templateCore/object/holder/AppInfoParameterHolder";
//Utils
import PsUtils from "../../../../../../../../TemplateCore/utils/PsUtils";

export default {
    name: "ItemListView",
    components: {
        PsBreadcrumb2,
        PsContentContainer,
        PsLoadingDialog,
        PsAdSense,
        CategoryDropDown,
        SubCategoryDropDown,
        DiscountCheckbox,
        StockSection,
        PriceRangeInput,
        CustomFieldSection,
        CityDropdown,
        TownshipDropdown,
        PickLocationButton,
        ItemVerticalList,
        SortAndTypeSection,
        ItemFilterTitle,
        ApplyButton,
        KeywordInput,
        MobileFilterButton,
        ClearButton,
        PsDropdown,
        PsIcon,
        PsButton,
        PsLabel
    },
    layout: PsFrontendLayout,
    props: ["query"],
    setup(props) {
        /**
         * Init Providers & Refs
         */
        const itemProvider = useProductStore("list");
        const appInfoStore = usePsAppInfoStoreState();
        const psValueStore = PsValueStore();
        const ps_loading_dialog = ref();

        const initial = ref(true);
        const appInfoParameterHolder = new AppInfoParameterHolder();
        itemProvider.paramHolder.parseParamsAndQuery(props.query);
        const activeProductsArrName = ref("item_list__all");
        const activeProductsArrId = ref("0");
        const productsArr = ref([
            { id: "0", name: "item_list__all" },
            { id: "1", name: "home__fe_auction_items" },
            { id: "2", name: "home__fe_fixed_price" },
            { id: "3", name: "home__fe_traditional_auction" }
        ])

        onMounted(async () => {
            console.log(props.query.product_type)
            if (props.query.product_type == "live-video-auction") {
                activeProductsArrId.value = "1";
                activeProductsArrName.value = "home__fe_auction_items";
            } else if (props.query.product_type == "buyable") {
                activeProductsArrId.value = "2";
                activeProductsArrName.value = "home__fe_fixed_price";
            } else if (props.query.product_type == "traditional-auction") {
                activeProductsArrId.value = "3";
                activeProductsArrName.value = "home__fe_traditional_auction";
            } else {
                activeProductsArrId.value = "0";
                activeProductsArrName.value = "item_list__all";
            }

            appInfoParameterHolder.userId = psValueStore.getLoginUserId();
            appInfoStore.loadAppInfo(appInfoParameterHolder);

            setTimeout(async () => {
                // console.log(window.popStateDetected);
                if (!window.popStateDetected) {
                    if (
                        initial.value == true &&
                        itemProvider.itemList.data == null
                    ) {
                        ps_loading_dialog.value.openModal();
                    }

                    if (
                        itemProvider.paramHolder.orderBy !=
                        PsConst.FILTERING_TRENDING ||
                        itemProvider.paramHolder.orderType !=
                        PsConst.FILTERING__DESC
                    ) {
                        itemProvider.paramHolder.sortingName == "Recent";
                        itemProvider.paramHolder.orderBy ==
                            PsConst.FILTERING__ADDED_DATE;
                        itemProvider.paramHolder.orderType ==
                            PsConst.FILTERING__DESC;
                    }
                    await loadDataList();
                } else {
                    initial.value = false;
                    window.popStateDetected = false;
                }
            }, 1000);
        });
        onUnmounted(() => {
            itemProvider.paramHolder =
                new ProductParameterHolder().getRecentParameterHolder();
        });

        async function loadDataList() {
            ps_loading_dialog.value.openModal();
            if (
                itemProvider.paramHolder.mile == "0" ||
                itemProvider.paramHolder.mile.toString() == ""
            ) {
                itemProvider.paramHolder.lat = "";
                itemProvider.paramHolder.lng = "";
            }
            PsUtils.addParamToCurrentUrl(
                itemProvider.getURLforListByParam(itemProvider.paramHolder)
            );
            await itemProvider.resetProductList(
                psValueStore.getLoginUserId(),
                itemProvider.paramHolder
            );
            ps_loading_dialog.value.closeModal();
            initial.value = false;
        }

        const arrowIcon = ref("downArrow");
        function enter(el, done) {
            arrowIcon.value = "upArrow";
        }

        function leave(el, done) {
            arrowIcon.value = "downArrow";
        }

        function orderingByProductsClicked(data) {
            activeProductsArrId.value = data.id;
            activeProductsArrName.value = data.name;
        }

        return {
            ps_loading_dialog,
            itemProvider,
            appInfoStore,
            enter,
            leave,
            initial,
            activeProductsArrName,
            productsArr,
            orderingByProductsClicked,
            activeProductsArrId
        };
    },
    computed: {
        breadcrumb() {
            if (
                this.itemProvider.paramHolder.catName &&
                this.itemProvider.paramHolder.subCatName
            ) {
                return [
                    {
                        label: trans("item_detail__home"),
                        url: route("dashboard"),
                    },
                    {
                        label: trans("category_list__title"),
                        url: route("fe_category.index"),
                    },
                    {
                        label: trans(this.itemProvider.paramHolder.catName),
                        url: route("fe_sub_category", {
                            cat_id: this.query.cat_id,
                            cat_name: this.query.cat_name,
                        }),
                    },
                    {
                        label: trans(this.itemProvider.paramHolder.subCatName),
                        color: "text-fePrimary-500",
                    },
                ];
            } else if (this.itemProvider.paramHolder.catName) {
                return [
                    {
                        label: trans("item_detail__home"),
                        url: route("dashboard"),
                    },
                    {
                        label: trans("category_list__title"),
                        url: route("fe_category.index"),
                    },
                    {
                        label: trans(this.itemProvider.paramHolder.catName),
                        color: "text-fePrimary-500",
                    },
                ];
            } else {
                return [
                    {
                        label: trans("item_detail__home"),
                        url: route("dashboard"),
                    },
                    {
                        label: trans("fe__search_result"),
                        color: "text-fePrimary-500",
                    },
                ];
            }
        },
    },
};
</script>
<style scoped>
[v-cloak] {
    display: none;
}
</style>
