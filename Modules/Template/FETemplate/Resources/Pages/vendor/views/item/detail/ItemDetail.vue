<template>

    <Head :title="$t('item__detail')" />
    <ps-content-container>
        <template #content>
            <div class="mt-32 mb-10">
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-24">
                    <!-- Bread Crumb -->
                    <ps-breadcrumb-2 :items="breadcrumb" />

                    <!-- Share And Report -->
                    <item-detail-share-and-report :loginUserId="loginUserId" :itemId="itemId" :itemName="itemName" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="col-span-1 sm:col-span-7 md:col-span-8">
                        <!-- gallery -->
                        <gallery-vertical-swiper :galleryList="galleryProvider.galleryList?.data"
                            :video="videoStore.galleryList?.data" :isLoading="galleryProvider.galleryList.data == null &&
                                dataReady
                                ? false
                                : true
                                " />

                        <!-- Price Info -->
                        <item-detail-price-info-card class="mt-6 sm:hidden" :favouriteClicked="favouriteClicked"
                            :loginUserId="loginUserId" :itemId="itemId" :highestBid=highest_bid />

                        <!-- Info Card -->
                        <item-detail-info-card :productRelation="productRelation" />

                        <div class="mt-6 sm:hidden">
                            <vendor-profile-card v-if="
                                appInfoProvider?.isVendorSettingOn() &&
                                productStore.item?.data?.vendor &&
                                productStore.item?.data?.vendor.id != '' &&
                                productStore.item?.data?.user &&
                                productStore.item?.data?.user?.userId !=
                                loginUserId
                            " :vendor="productStore.item?.data?.vendor" :itemId="itemId" />

                            <!-- User List Horizontal -->
                            <user-list-horizontal v-else-if="
                                productStore.item?.data?.user &&
                                productStore.item?.data?.user?.userId !=
                                loginUserId
                            " :user="productStore.item?.data?.user" :storeName="itemId"
                                color="bg-feSecondary-50 dark:bg-feSecondary-800 mt-6" />

                            <!-- Action Card -->
                            <item-detail-action-card :isAllpaymentDisable="isAllPaymentDisable"
                                :loginUserId="loginUserId" :itemId="itemId" :selectedChatType="appInfoProvider.appInfo.data?.psAppSetting
                                    ?.SelectedChatType
                                    " :loadDataForItemDetail="loadDataForItemDetail" :whatsAppNo="whatsAppNo" />

                            <!-- location Card -->
                            <item-detail-location-card :appInfoProvider="appInfoProvider"
                                :productStore="productStore" />
                        </div>

                        <div class="flex flex-col gap-6 col-span-8 mt-8">
                            <!-- safty tips -->
                            <item-detail-learn-more-card :text="$t('item_detail__safety_tips')"
                                :clickLeranMore="safetyTip" />

                            <!-- T&C -->
                            <item-detail-learn-more-card :text="$t('term_and_condition__term_and_condition')
                                " :clickLeranMore="termsAndConditions" />

                            <!-- FAQ -->
                            <item-detail-learn-more-card :text="$t('item_detail__faq')" :clickLeranMore="faq" />
                        </div>
                    </div>
                    <div class="col-span-1 sm:col-span-5 md:col-span-4 hidden sm:block">
                        <!-- Price Info -->
                        <item-detail-price-info-card :favouriteClicked="favouriteClicked" :loginUserId="loginUserId"
                            :itemId="itemId" :highestBid="highest_bid" />

                        <vendor-profile-card v-if="
                            appInfoProvider?.isVendorSettingOn() &&
                            productStore.item?.data?.vendor &&
                            productStore.item?.data?.vendor.id != '' &&
                            productStore.item?.data?.user &&
                            productStore.item?.data?.user?.userId !=
                            loginUserId
                        " :vendor="productStore.item?.data?.vendor" :itemId="itemId" />

                        <!-- User List Horizontal -->
                        <user-list-horizontal v-else-if="
                            productStore.item?.data?.user &&
                            productStore.item?.data?.user?.userId !=
                            loginUserId
                        " :user="productStore.item?.data?.user" :storeName="itemId"
                            color="bg-feSecondary-50 dark:bg-feSecondary-800 mt-6" />

                        <!-- Action Card -->
                        <item-detail-action-card :isAllpaymentDisable="isAllPaymentDisable" :loginUserId="loginUserId"
                            :itemId="itemId" :selectedChatType="appInfoProvider.appInfo.data?.psAppSetting
                                ?.SelectedChatType
                                " :loadDataForItemDetail="loadDataForItemDetail" :whatsAppNo="whatsAppNo" />

                        <!-- location Card -->
                        <!-- <item-detail-location-card :appInfoProvider="appInfoProvider" :productStore="productStore" mapContainer="mapContainer2"/> -->
                    </div>
                </div>

                <item-detail-related-item-horizontal-list />
            </div>
        </template>
    </ps-content-container>

    <ps-loading-dialog ref="ps_loading_dialog" />
    <gallery-detail-horizontal-swiper ref="gallery_detail" />
    <ps-learn-more-dialog ref="ps_learn_more_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

// Objects
import PsConst from "@templateCore/object/constant/ps_constants";
import { ref, onMounted, onUnmounted, computed } from "vue";

// Components
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import GalleryDetailHorizontalSwiper from "@template1/vendor/components/modules/gallery/GalleryDetailHorizontalSwiper.vue";
import GalleryVerticalSwiper from "@template1/vendor/components/modules/gallery/GalleryVerticalSwiper.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsConfirmDialog from "@template1/vendor/components/core/dialog/PsConfirmDialog.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialog/PsErrorDialog.vue";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";
import UserListHorizontal from "@template1/vendor/components/modules/user/UserListHorizontal.vue";
import VendorProfileCard from "@template1/vendor/components/modules/vendor/VendorProfileCard.vue";
import PsLearnMoreDialog from "@template1/vendor/components/core/dialogs/PsLearnMoreDialog.vue";

import ItemDetailPriceInfoCard from "./components/ItemDetailPriceInfoCard.vue";
import ItemDetailLearnMoreCard from "./components/ItemDetailLearnMoreCard.vue";
import ItemDetailLocationCard from "./components/ItemDetailLocationCard.vue";
import ItemDetailInfoCard from "./components/ItemDetailInfoCard.vue";
import ItemDetailActionCard from "./components/ItemDetailActionCard.vue";
import ItemDetailRelatedItemHorizontalList from "./components/ItemDetailRelatedItemHorizontalList.vue";
import ItemDetailShareAndReport from "./components/ItemDetailShareAndReport.vue";

// Models
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useGalleryStoreState } from "@templateCore/store/modules/gallery/GalleryStore";
import { useAboutUsStoreState } from "@templateCore/store/modules/aboutus/AboutUsStore";
import { useFavouriteItemStoreState } from "@templateCore/store/modules/item/FavouriteItemStore";
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
import { useTouchCountStore } from "@templateCore/store/modules/item/TouchCountStore";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
// Holders
import ProductParameterHolder from "@templateCore/object/holder/ProductParameterHolder";
import AppInfoParameterHolder from "@templateCore/object/holder/AppInfoParameterHolder";
import TouchCountParameterHolder from "@templateCore/object/holder/TouchCountParameterHolder";
import { trans } from "laravel-vue-i18n";
import { useCustomFieldStoreState } from "@templateCore/store/modules/customField/CustomFieldStore";
import { bidDetailsStoreState } from "@templateCore/store/modules/bid/bidDetailsStore";


export default {
    name: "ItemDetailView",
    components: {
        PsLearnMoreDialog,
        PsContentContainer,
        PsBreadcrumb2,
        PsConfirmDialog,
        PsLoadingDialog,
        PsErrorDialog,
        GalleryDetailHorizontalSwiper,
        UserListHorizontal,
        GalleryVerticalSwiper,
        Head,
        ItemDetailPriceInfoCard,
        ItemDetailLearnMoreCard,
        ItemDetailLocationCard,
        ItemDetailInfoCard,
        ItemDetailActionCard,
        ItemDetailRelatedItemHorizontalList,
        ItemDetailShareAndReport,
        VendorProfileCard,
    },
    layout: PsFrontendLayout,
    props: ["query"],
    setup(props) {
        const itemId = props.query.item_id;
        const shared_id = ref(props.query.item_id);
        const itemName = "";

        // Inject Providers
        const relatedItemStore = useProductStore("related_item");
        const productStore = useProductStore("detail");
        const galleryProvider = useGalleryStoreState("detail");
        const videoStore = useGalleryStoreState("video");
        const aboutUsProvider = useAboutUsStoreState();
        const FavouriteItemProvider = useFavouriteItemStoreState();
        relatedItemStore.paramHolder =
            new ProductParameterHolder().getRelatedProductParameterHolder();
        const touchCountStore = useTouchCountStore();
        const itemCustomFieldStore = useCustomFieldStoreState("detail");
        const userCustomFieldStore = useCustomFieldStoreState("owner");

        const dataReady = ref(false);
        const imageCount = ref(1);
        let totalCount = ref(0);
        let whatsAppNo = ref("");

        // Init Variables
        const psValueStore = PsValueStore();

        const loginUserId = ref(psValueStore.getLoginUserId());
        const ps_loading_dialog = ref();
        const ps_learn_more_dialog = ref();
        const gallery_detail = ref();
        const isPromote = ref(false);
        const isAllPaymentDisable = ref();
        const holder = new TouchCountParameterHolder();
        const appInfoProvider = usePsAppInfoStoreState();
        const appInfoParameterHolder = new AppInfoParameterHolder();
        appInfoParameterHolder.userId = psValueStore.getLoginUserId();

        let isVideoSetting = ref(false);
        let productRelation = ref([]);

        const textContent = ref("");
        const textContentT = ref("");
        const textContentF = ref("");
        const bidDetails = bidDetailsStoreState();
        const highest_bid = ref(null);

        onMounted(async () => {
            // Load Item Data
            loadDataForItemDetail();
            holder.typeId = itemId;
            holder.userId = loginUserId.value;
            holder.typeName = "item";
            if (loginUserId.value != "nologinuser") {
                touchCountStore.postTouchCount(loginUserId.value, holder);
            }
            if (!isAllPaymentDisable.value) {
                isAllPaymentDisable.value =
                    appInfoProvider.isAllPaymentDisable();
            }
            const result = await bidDetails.fetchProductBids(loginUserId.value, itemId);

            if (result) {
                console.log(result)
                if (result?.total_bids) {
                    highest_bid.value = result?.highest_bid?.bid_price;
                }
            }
        });
    

        loadAppInfo();

        function safetyTip() {
            if (localStorage.activeLanguage == "en") {
                textContent.value = aboutUsProvider.aboutus?.data?.safetyTips;
            } else if (localStorage.activeLanguage == "fr") {
                textContent.value =
                    "Ne transférez jamais d’argent et ne communiquez jamais en dehors de la plateforme.";
            } else if (localStorage.activeLanguage == "de") {
                textContent.value =
                    "Überweisen Sie niemals Geld und kommunizieren Sie niemals außerhalb der Plattform.";
            } else if (localStorage.activeLanguage == "it") {
                textContent.value =
                    "Non trasferire mai denaro né comunicare al di fuori della piattaforma.";
            }
            ps_learn_more_dialog.value.openModal(
                "item_detail__safety_tips",
                textContent.value
            );
        }

        function termsAndConditions() {
            if (localStorage.activeLanguage == "en") {
                textContentT.value =
                    aboutUsProvider.aboutus?.data?.termsAndConditions;
            } else if (localStorage.activeLanguage == "fr") {
                textContentT.value =
                    "En effectuant un achat, vous acceptez automatiquement nos conditions et conditions.";
            } else if (localStorage.activeLanguage == "de") {
                textContentT.value =
                    "Mit dem Kauf akzeptieren Sie automatisch unsere Geschäftsbedingungen Bedingungen.";
            } else if (localStorage.activeLanguage == "it") {
                textContentT.value =
                    "Effettuando un acquisto, accetti automaticamente i nostri termini e condizioni.";
            }
            ps_learn_more_dialog.value.openModal(
                "term_and_condition__term_and_condition",
                textContentT.value
            );
        }

        function faq() {
            if (localStorage.activeLanguage == "en") {
                textContentF.value = aboutUsProvider.aboutus?.data?.faqPage;
            } else if (localStorage.activeLanguage == "fr") {
                textContentF.value =
                    "Notre section Foire aux questions (FAQ) est conçue pour vous fournir des réponses rapides et complètes aux questions les plus courantes de nos utilisateurs. Nous avons soigneusement organisé les questions en catégories claires et faciles à parcourir, afin que vous puissiez trouver efficacement les informations dont vous avez besoin.";
            } else if (localStorage.activeLanguage == "de") {
                textContentF.value =
                    "In unserem Bereich „Häufig gestellte Fragen“ (FAQ) erhalten Sie schnelle und umfassende Antworten auf die häufigsten Fragen unserer Benutzer. Wir haben die Fragen sorgfältig in klare, leicht zu navigierende Kategorien gegliedert, damit Sie die benötigten Informationen effizient finden können.";
            } else if (localStorage.activeLanguage == "it") {
                textContentF.value =
                    "La nostra sezione Domande frequenti (FAQ) è progettata per fornire risposte rapide ed esaurienti alle domande più comuni dei nostri utenti. Abbiamo organizzato attentamente le domande in categorie chiare e facili da navigare, così puoi trovare in modo efficiente le informazioni di cui hai bisogno.";
            }
            ps_learn_more_dialog.value.openModal(
                "item_detail__faq",
                textContentF.value
            );
        }

        async function loadDataForItemDetail() {
            await aboutUsProvider.loadAboutUs(loginUserId.value);
            await productStore.loadItem(itemId, loginUserId.value);
            await userCustomFieldStore.loadUserCustomFieldList(
                loginUserId.vaolue
            );

            productRelation.value = productStore.loadProductRelation([
                "ps-itm00002",
                "ps-itm00004",
                "ps-itm00007",
            ]);

            for (const customField of userCustomFieldStore.customField.data
                ?.customList) {
                if (
                    customField.coreKeysId == PsConst.WHATSAPP_CORE_KEY_Id &&
                    customField.isVisible == "1"
                ) {
                    const ownerWhatsAppRelation =
                        productStore.item?.data?.user?.userRelation.filter(
                            (pr) =>
                                pr.coreKeysId == PsConst.WHATSAPP_CORE_KEY_Id
                        );
                    if (
                        ownerWhatsAppRelation.length != 0 &&
                        ownerWhatsAppRelation[0]?.value != null
                    ) {
                        whatsAppNo.value = ownerWhatsAppRelation[0]?.value;
                    }
                }
            }

            await galleryProvider.resetGalleryList(
                loginUserId.value,
                itemId,
                PsConst.ITEM__RELATED_TYPE
            );
            relatedItemStore.paramHolder.catId = productStore.item.data.catId;

            await relatedItemStore.resetProductList(
                loginUserId.value,
                relatedItemStore.paramHolder
            );

            if (appInfoProvider.isShowItemVideo()) {
                videoStore.galleryList.data =
                    galleryProvider.galleryList.data.filter(
                        (item) => item.imgType != "item-video-icon"
                    );
                galleryProvider.galleryList.data =
                    galleryProvider.galleryList.data.filter(
                        (item) => item.imgType != "item-video"
                    );
            } else {
                videoStore.galleryList.data =
                    galleryProvider.galleryList.data.filter(
                        (item) =>
                            item.imgType != "item-video-icon" &&
                            item.imgType != "item-video"
                    );
                galleryProvider.galleryList.data =
                    galleryProvider.galleryList.data.filter(
                        (item) =>
                            item.imgType != "item-video" &&
                            item.imgType != "item-video-icon"
                    );
            }

            if (productStore.promoteStatus() && !isAllPaymentDisable.value) {
                isPromote.value = true;
            } else {
                isPromote.value = false;
            }

            await itemCustomFieldStore.loadCustomFieldList(loginUserId.value);
            dataReady.value = true;
        }

        async function loadAppInfo() {
            await appInfoProvider.loadAppInfo(appInfoParameterHolder);
            if (appInfoProvider.isShowItemVideo() == PsConst.ONE) {
                isVideoSetting.value = true;
            }
            if (parseInt(appInfoProvider.maxImgUploadOfItem()) >= 1) {
                imageCount.value = parseInt(
                    appInfoProvider.maxImgUploadOfItem()
                );
                totalCount.value = imageCount.value + 1;
            }
        }

        async function favouriteClicked() {
            if (
                loginUserId.value &&
                loginUserId.value != PsConst.NO_LOGIN_USER
            ) {
                ps_loading_dialog.value.openModal();
                if (productStore.isFavourite()) {
                    ps_loading_dialog.value.message = trans(
                        "item_detail__removing_item_from_favourite"
                    );
                } else {
                    ps_loading_dialog.value.message = trans(
                        "item_detail__adding_item_to_favourite"
                    );
                }

                await FavouriteItemProvider.postFavourite(
                    itemId,
                    loginUserId.value
                );

                await loadDataForItemDetail();
                ps_loading_dialog.value.closeModal();
            } else {
                router.get(route("login"));
            }
        }

        const breadcrumb = computed(() => {
            if (
                appInfoProvider?.isShowSubCategory() ||
                productStore.subCategoryIdIsEmpty()
            ) {
                return [
                    {
                        label: trans("ps_nav_bar__home"),
                        url: route("dashboard"),
                    },
                    {
                        label: trans(
                            productStore.item?.data?.category?.catName
                        ),
                        url: route("fe_item_list", {
                            cat_id: productStore.item?.data?.category?.catId,
                            cat_name:
                                productStore.item?.data?.category?.catName,
                            status: 1,
                        }),
                    },
                    {
                        label: productStore.item?.data?.title,
                        color: "text-fePrimary-500",
                    },
                ];
            } else {
                return [
                    {
                        label: trans("ps_nav_bar__home"),
                        url: route("dashboard"),
                    },
                    {
                        label: trans(
                            productStore.item?.data?.category?.catName
                        ),
                        url: route("fe_item_list", {
                            cat_id: productStore.item?.data?.category?.catId,
                            cat_name:
                                productStore.item?.data?.category?.catName,
                            status: 1,
                        }),
                    },
                    {
                        label: trans(
                            productStore.item?.data?.subCategory?.name
                        ),
                        url: route("fe_item_list", {
                            cat_id: productStore.item?.data?.category?.catId,
                            cat_name:
                                productStore.item?.data?.category?.catName,
                            sub_cat_id:
                                productStore.item?.data?.subCategory?.id,
                            sub_cat_name:
                                productStore.item?.data?.subCategory?.name,
                            status: 1,
                        }),
                    },
                    {
                        label: productStore.item?.data?.title,
                        color: "text-fePrimary-500",
                    },
                ];
            }
        });

        const relatedItem = () => {
            let ids = [];
            ids.push(itemId);

            return relatedItemStore.itemList?.data.filter(
                (item) => ids.indexOf(item.id) == -1
            );
        };

        return {
            loadDataForItemDetail,
            dataReady,
            appInfoProvider,
            loginUserId,
            itemId,
            shared_id,
            itemName,
            productStore,
            galleryProvider,
            videoStore,
            aboutUsProvider,
            favouriteClicked,
            ps_loading_dialog,
            ps_learn_more_dialog,
            gallery_detail,
            isPromote,
            PsConst,
            safetyTip,
            termsAndConditions,
            faq,
            totalCount,
            imageCount,
            itemCustomFieldStore,
            relatedItemStore,
            productRelation,
            isAllPaymentDisable,
            whatsAppNo,
            breadcrumb,
            relatedItem,
            textContent,
            textContentT,
            textContentF,
            highest_bid
        };
    },
};
</script>
