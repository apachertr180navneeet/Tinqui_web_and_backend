<template>
    <div class="">
        <search-and-popular-category-list-card :bannerImgPath="appInfoStore.appInfo.data?.frontendConfigSetting?.frontendBanner
                ?.imgPath
            " :showSubCat="appInfoStore?.isShowSubCategory()"
            :limit="$props.mobileSetting?.category_loading_limit ?? 6" />

        <featured-item-horizontal-list :limit="$props.mobileSetting?.featured_item_loading_limit ?? 12" />

        <dashboard-auctioned-item-list :limit="$props.mobileSetting?.featured_item_loading_limit ?? 12"  />

        <dashboard-fixed-price-list :limit="$props.mobileSetting?.featured_item_loading_limit ?? 12" :itemList = "fixedPriceList" :isLoading="isLoading" />

        <dashboard-traditional-auction-list :limit="$props.mobileSetting?.featured_item_loading_limit ?? 12" :itemList = "auctionedItemList" :isLoading="isLoading" />

        <ps-account-dialog v-if="showAccountModel" ref="ps_account_dialog" :loginUserId="loginUserId"
            :usernameError="usernameError" :passwordError="passwordError" />
    </div>
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import {
    ref,
    defineAsyncComponent,
    onMounted,
    onUnmounted,
    onBeforeUnmount,
} from "vue";
import { trans } from "laravel-vue-i18n";
import SearchAndPopularCategoryListCard from "./components/DashboardSearchAndPopularCategoryListCard.vue";
import CategoryHorizontalList from "./components/DashboardCategoryHorizontalList.vue";
import HowItWorksCard from "./components/DashboardHowItWorksCard.vue";
import FeaturedItemHorizontalList from "./components/DashboardFeaturedItemHorizontalList.vue";
import ItemHorizontalList from "./components/DashboardItemHorizontalList.vue";
import PackageHorizontalList from "./components/DashboardPackageHorizontalList.vue";
import TopSellerHorizontalList from "./components/DashboardTopSellerHorizontalList.vue";
import BlogHorizontalList from "./components/DashboardBlogHorizontalList.vue";
import MobileShowcaseCard from "./components/DashboardMobileShowcaseCard.vue";
import DashboardVendorCard from "./components/DashboardVendorCard.vue";
import DashboardAuctionedItemList from "./components/DashboardAuctionedItemList.vue";
import DashboardFixedPriceList from "./components/DashboardFixedPriceList.vue";
import DashboardTraditionalAuctionList from "./components/DashboardTraditionalAuctionList.vue";
const PsAccountDialog = defineAsyncComponent(
    () =>
        import("@template1/vendor/components/core/dialogs/PsAccountDialog.vue")
);
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
import { useAuthStore } from "../../../../../../../../resources/js/store/AuthStore";
import AppInfoParameterHolder from "@templateCore/object/holder/AppInfoParameterHolder";
import UserExistParameterHolder from "@templateCore/object/holder/UserExistParameterHolder";
import UserCreateParameterHolder from "@templateCore/object/holder/UserCreateParameterHolder";

import PsUtils from "@templateCore/utils/PsUtils";
import { useProductStore } from "../../../../../../../TemplateCore/store/modules/item/ProductStore";

export default {
    name: "DashboardView",
    components: {
        Head,
        ItemHorizontalList,
        FeaturedItemHorizontalList,
        CategoryHorizontalList,
        HowItWorksCard,
        SearchAndPopularCategoryListCard,
        PackageHorizontalList,
        TopSellerHorizontalList,
        BlogHorizontalList,
        MobileShowcaseCard,
        PsAccountDialog,
        DashboardVendorCard,
        DashboardFixedPriceList,
        DashboardAuctionedItemList,
        DashboardTraditionalAuctionList
    },
    props: {
        errors: Object,
        mobileSetting: Object,
    },
    layout: PsFrontendLayout,

    setup() {
        const psValueStore = PsValueStore();
        const ps_account_dialog = ref();
        const showAccountModel = ref(false);
        const authStore = useAuthStore();
        const userParamHolder = new UserExistParameterHolder();
        const userCreateParamHolder = new UserCreateParameterHolder();
        let usernameError = ref();
        let passwordError = ref();

        const appInfoStore = usePsAppInfoStoreState();
        const loginUserId = psValueStore.getLoginUserId();
        const appInfoParameterHolder = new AppInfoParameterHolder();
        const productStore = useProductStore("dashboard_recent");

        const fixedPriceList:any = ref([]);
        const auctionedItemList:any = ref([]);
        const isLoading = ref(false);

        async function checkUserAccount(username, hasPassword) {
            ps_account_dialog.value.openModal(
                trans("dashboard_modal_user_info"),
                trans("item_detail__confirm_to_mark_as_sold"),
                trans("core__fe_update_user"),
                trans("item_detail__cancel"),
                username,
                hasPassword,

                async () => {
                    userCreateParamHolder.username =
                        ps_account_dialog.value.form.username;
                    userCreateParamHolder.loginUserId = loginUserId;
                    userCreateParamHolder.loginMethod = "checkFromDashboard";

                    if (hasPassword == "false") {
                        userCreateParamHolder.password =
                            ps_account_dialog.value.form.password;
                    }

                    usernameError.value = "";
                    passwordError.value = "";
                    const UserLogindata =
                        await authStore.createUserwithUsername(
                            userCreateParamHolder
                        );
                    if (UserLogindata.data.status == "error") {
                        usernameError.value = authStore.isEmpty(
                            UserLogindata.data.message.username
                        )
                            ? ""
                            : UserLogindata.data.message.username[0];
                        passwordError.value = authStore.isEmpty(
                            UserLogindata.data.message.password
                        )
                            ? ""
                            : UserLogindata.data.message.password[0];
                    }
                    if (UserLogindata.data.status == "success") {
                        ps_account_dialog.value.closeModal();
                    }
                },
                () => {
                    PsUtils.log("Cancel");
                }
            );
        }

        onMounted(async () => {
            appInfoParameterHolder.userId = loginUserId;
            appInfoStore.loadAppInfo(appInfoParameterHolder);

            if (loginUserId !== "nologinuser") {
                userParamHolder.id = loginUserId;
                userParamHolder.loginMethod = "checkFromDashboard";
                const UserLogindata = await authStore.existUser(
                    userParamHolder
                );
                if (
                    UserLogindata.data.message.user.username == "" ||
                    UserLogindata.data.message.user.hasPassword == "false"
                ) {
                    showAccountModel.value = true;
                    await PsUtils.waitingComponent(ps_account_dialog);
                    await checkUserAccount(
                        UserLogindata.data.message.user.username,
                        UserLogindata.data.message.user.hasPassword
                    );
                }
            }

         refleshData()
        });

        async function refleshData() {
            isLoading.value = true;
            await productStore.refleshProductList(loginUserId, productStore.paramHolder);
            productStore.itemList.data.map(item => {
                if (item.productRelation.length > 0 && item?.isAuctionItem != '1' && item?.isSoldOut != '1' && item?.isExpired != '1') {
                    item.productRelation.map(relation => {
                        // console.log("relation",relation)
                        if (relation.coreKeysId === "ps-itm00003" && relation.selectedValue[0].value.toLowerCase() === "fixed price") {
                            fixedPriceList.value.push(item);
                        } else if (relation.coreKeysId === "ps-itm00003" && relation.selectedValue[0].value.toLowerCase() === "auction") {
                            auctionedItemList.value.push(item);
                        }
                    })
                }
            })
            isLoading.value = false;
        }

        onBeforeUnmount(() => {
            PsUtils.log("onBeforeUnmount");
        });
        onUnmounted(() => {
            PsUtils.log("unmounting success");
        });

        return {
            appInfoStore,
            PsValueStore,
            ps_account_dialog,
            checkUserAccount,
            loginUserId,
            usernameError,
            passwordError,
            showAccountModel,
            fixedPriceList,
            auctionedItemList,
            isLoading
        };
    },
};
</script>
