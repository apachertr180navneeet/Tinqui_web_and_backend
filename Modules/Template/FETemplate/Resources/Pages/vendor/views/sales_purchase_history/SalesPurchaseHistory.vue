<template>

    <Head :title="$t('sales_purchase_section')" />
    <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div class="grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-10 word-wrap">
            <div class="col-start-0 col-span-4 sm:col-span-2 lg:col-span-3">
                <ps-label class="text-xl sm:text-3xl font-medium mb-5">
                    {{ $t("sales_purchase_section") }}</ps-label>
                <div class=" ">
                    <div class="flex flex-row rtl:space-x-reverse space-x-2 sm:space-x-0 space-y-0 sm:space-y-2 sm:flex-col"
                        id="sellerbtn  testid" v-if="!isShowSales" :disabled="true">
                        <ps-button class="w-full" @click="switchSection(' purchase ')">
                            <span class="me-2 md:me-4">{{
                                $t("my_purchases_section")
                            }}</span>
                        </ps-button>
                        <ps-button class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500" rounded="rounded"
                            @click="switchSection(' sale ')">
                            <span class="me-2 md:me-4">{{
                                $t("my_sales_title")
                            }}</span>
                        </ps-button>
                    </div>
                    <div class="flex flex-row rtl:space-x-reverse space-x-2 sm:space-x-0 space-y-0 sm:space-y-2 sm:flex-col"
                        id="buyerbtn" v-else :disabled="true">
                        <ps-button class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500" rounded="rounded"
                            @click="switchSection(' purchase ')">
                            <span class="me-2 md:me-4">{{
                                $t("my_purchases_section")
                            }}</span>
                        </ps-button>
                        <ps-button class="w-full" @click="switchSection(' sale ')">
                            <span class="me-2 md:me-4">{{
                                $t("my_sales_title")
                            }}</span>
                        </ps-button>
                    </div>
                </div>
            </div>
            <div class="col-span-4 sm:col-span-6 lg:col-span-9">
                <div class="col-span-4 sm:col-span-6 lg:col-span-9 mb-2" v-if="isShowSales">
                    <ps-label class="text-sm sm:text-xl font-medium">
                        {{ $t("my_sales_title") }}</ps-label>
                </div>
                <div class="col-span-4 sm:col-span-6 lg:col-span-9 mb-2" v-else>
                    <ps-label class="text-sm sm:text-xl font-medium">{{
                        $t("my_purchases_section")
                    }}</ps-label>
                </div>
                <div v-if="ps_loading == true">
                    <div id="sale" class="w-full flex flex-col lg:p-4 p-2 sm:p-3">
                        <div class="w-full">
                            <div class="flex flex-col">
                                <div class="w-full mt-2" v-for="index in 6" :key="index">
                                    <dispute-skeletor-item />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- purchase history -->
                <div id="purchase" class="flex flex-col mb-16 mt-7" v-if="!isShowSales && ps_loading == false">
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div class="w-full relative mb-4 rounded-md cursor-pointer h-[27rem]">
                                <div v-if="purchaseList.length > 0"
                                    class="relative overflow-x-auto my-3 shadow-md overflow-y-auto sm:rounded-lg h-full">
                                    <div v-for="(item, index) in purchaseList" :key="index">
                                        <div class="w-full grid grid-cols-12 border gap-2 p-4">
                                            <div class="col-span-2 h-full flex justify-start items-center">
                                                <img alt="product image"
                                                    class="w-24 h-16 object-cover bg-feAchromatic-50" v-lazy="{
                                                        src:
                                                            $page.props.thumb1xUrl +
                                                            '/' +
                                                            item?.productData?.defaultPhoto?.imgPath,
                                                        loading:
                                                            $page.props.sysImageUrl +
                                                            '/loading_gif.gif',
                                                        error:
                                                            $page.props.sysImageUrl +
                                                            '/default_photo.png',
                                                    }">
                                            </div>
                                            <div class="col-span-6 h-full grid">
                                                <ps-route-link :to="{
                                                    name: 'fe_item_detail',
                                                    query: { item_id: item.product_id },
                                                }">
                                                    <h6
                                                        class="cursor-pointer text-black font-semibold underline dark:text-white">
                                                        {{
                                                            item?.product_title }}</h6>
                                                </ps-route-link>
                                                <h4 class="dark:text-white">{{ item?.productData?.category?.name }}</h4>
                                                <p class="dark:text-white">Fr. {{ item?.bid_price??item?.productData?.price }}</p>
                                            </div>
                                            <div class="col-span-4 h-full grid">
                                                <ps-route-link :to="{
                                                    name: 'fe_other_profile',
                                                    query: { userId: item?.seller_id },
                                                }">
                                                    <h6> {{ $t('sold_by_text') }}: <span
                                                            class="cursor-pointer text-black font-semibold underline dark:text-white">{{
                                                                item?.sellerData?.[0]?.user_name }}</span></h6>
                                                </ps-route-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="min-h-full flex items-center justify center">
                                    <p class="m-auto font-semibold text-xl dark:text-white">
                                        {{ $t("no_purchase_record") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End purchase history -->

                <!-- sales history -->
                <div id="sale" class="flex flex-col mb-16 mt-7" v-if="isShowSales && ps_loading == false">
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div class="w-full relative mb-4 rounded-md cursor-pointer h-[27rem]">
                                <div v-if="salesList.length > 0"
                                    class="relative overflow-x-auto my-3 shadow-md overflow-y-auto sm:rounded-lg h-full">
                                    <div v-for="(item, index) in salesList" :key="index">
                                        <div class="w-full grid grid-cols-12 border gap-2 p-4">
                                            <div class="col-span-2 h-full flex justify-start items-center">
                                                <img alt="product image"
                                                    class="w-24 h-16 object-cover bg-feAchromatic-50" v-lazy="{
                                                        src:
                                                            $page.props.thumb1xUrl +
                                                            '/' +
                                                            item?.productData?.defaultPhoto?.imgPath,
                                                        loading:
                                                            $page.props.sysImageUrl +
                                                            '/loading_gif.gif',
                                                        error:
                                                            $page.props.sysImageUrl +
                                                            '/default_photo.png',
                                                    }">
                                            </div>
                                            <div class="col-span-6 h-full grid">
                                                <ps-route-link :to="{
                                                    name: 'fe_item_detail',
                                                    query: { item_id: item.product_id },
                                                }">
                                                    <h6
                                                        class="cursor-pointer text-black font-semibold underline dark:text-white">
                                                        {{
                                                            item?.product_title }}</h6>
                                                </ps-route-link>
                                                <h4 class="dark:text-white">{{ item?.productData?.category?.name }}</h4>
                                                <p class="dark:text-white">Fr. {{ item?.bid_price??item?.productData?.price }}</p>
                                            </div>
                                            <div class="col-span-4 h-full grid">
                                                <ps-route-link :to="{
                                                    name: 'fe_other_profile',
                                                    query: { userId: item?.buyer_id },
                                                }">
                                                    <h6 class="dark:text-white"> {{ $t('sold_to_text') }}: <span
                                                            class="cursor-pointer text-black font-semibold underline dark:text-white">{{
                                                                item?.buyerData?.[0]?.user_name }}</span></h6>
                                                </ps-route-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="min-h-full flex items-center justify center">
                                    <p class="m-auto font-semibold text-xl dark:text-white">
                                        {{ $t("no_sales_record") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End sales history -->
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------- START NO PRODUCT MODAL ------------------------------------------------------- -->

    <ps-modal ref="messageModal" maxWidth="350px" :isClickOut="false">
        <template #title>
            <ps-label-title>{{ $t("chat__no") }}&nbsp;{{
                $t("dispute_form_drop_label")
                }}&nbsp;{{ $t("item_detail__available") }}</ps-label-title>
        </template>
        <template #body>
            <ps-label>{{ $t("to_start_dispute") }}</ps-label>
        </template>
        <template #footer>
            <div class="flex justify-end">
                <ps-button @click="messageModal.toggle(false)">
                    {{ $t("ui_collection__ok") }}
                </ps-button>
            </div>
        </template>
    </ps-modal>

    <!-- -------------------------------------------------------- END NO PRODUCT MODAL ------------------------------------------------------- -->

    <!-- -------------------------------------------------------- START ATTACHMENTS MODAL ------------------------------------------------------- -->

    <ps-image-modal ref="imagesModal" :isClickOut="false" class="z-50 content-center mx-auto">
        <template #body>
            <div class="w-screem flex flex-col">
                <div class="flex flex-row justify-between">
                    <div class="flex-grow" />
                    <ps-icon @click="imagesModal.toggle(false)" name="close"
                        class="text-feSecondary-700 dark:text-feAchromatic-500" w="30" h="30" />
                </div>
                <div class="flex flex-row justify-between">
                    <div class="my-auto" @click="leftArrowClicked">
                        <ps-icon name="leftArrow" class="block sm:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500" w="30" h="30" />
                        <ps-icon name="leftArrow" class="hidden sm:block lg:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500" w="40" h="40" />
                        <ps-icon name="leftArrow" class="hidden lg:block stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500" w="50" h="50" />
                    </div>
                    <div class="flex flex-grow max-w-5/6">
                        <img alt="Placeholder" width="300px" height="400px"
                            class="w-full h-112 overflow:hidden object-contain" v-lazy="{
                                src: $page.props.disputesUrl + '/' + image,
                                loading:
                                    $page.props.sysImageUrl +
                                    '/loading_gif.gif',
                                error:
                                    $page.props.sysImageUrl +
                                    '/default_photo.png',
                            }" />
                    </div>
                    <div class="my-auto cursor-pointer" @click="rightArrowClicked">
                        <ps-icon name="rightArrow" class="block sm:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500" w="30" h="30" />
                        <ps-icon name="rightArrow" class="hidden sm:block lg:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500" w="40" h="40" />
                        <ps-icon name="rightArrow" class="hidden lg:block stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500" w="50" h="50" />
                    </div>
                </div>
            </div>
        </template>
    </ps-image-modal>

    <!-- -------------------------------------------------------- END ATTACHMENTS MODAL ------------------------------------------------------- -->
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { onMounted, ref } from "vue";
import PsModal from "@template1/vendor/components/core/modals/PsModal.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialogs/PsLoadingDialog.vue";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLabelTitle from "@template1/vendor/components/core/label/PsLabelTitle.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import DisputeSkeletorItem from "@template1/vendor/components/modules/chat/DisputeSkeletor.vue";
import PsAdSense from "@template1/vendor/components/core/adsense/PsAdSense.vue";
import DisputeStore from "@templateCore/store/modules/disputes/DisputeStore.ts";
import PsConst from "@templateCore/object/constant/ps_constants";
import { router } from "@inertiajs/vue3";
import PsImageModal from "../../components/core/modals/PsImageModal.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import "firebase/auth";

export default {
    name: "SalesPurchaseHistory",
    components: {
        PsModal,
        PsButton,
        PsLabelTitle,
        PsLabel,
        PsRouteLink,
        PsLoadingDialog,
        Head,
        PsBreadcrumb2,
        DisputeSkeletorItem,
        PsAdSense,
        PsImageModal,
        PsIcon,
    },
    props: ["mobileSetting"],
    layout: PsFrontendLayout,
    setup(_, { emit }) {
        const ps_loading = ref(false);
        const isShowSales = ref(false);
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const salesList: any = ref([]);
        const purchaseList: any = ref([]);
        const undisputedBids: any = ref([]);
        const messageModal = ref();
        const imagesModal = ref();
        let attachments = new Array();
        const image = ref();
        const productStore = useProductStore();

        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }

        onMounted(async () => {
            ps_loading.value = true;
            await productStore.getSalesPurchaseHistory(loginUserId).then(result => {
                if (result && result?.data) {
                    purchaseList.value = result?.data?.purchaseData || [];
                    salesList.value = result?.data?.saleData || [];
                }
                // setTimeout(() => {
                    ps_loading.value = false
                // }, 2000)
            });
        });

        async function switchSection(user = " purchase ") {
            if (user == " sale ") {
                isShowSales.value = true;
            } else if (user == " purchase ") {
                isShowSales.value = false;
            }
            ps_loading.value = true;

            ps_loading.value = false;
        }

        function noProduct() {
            messageModal.value.toggle(true);
        }

        function viewAttachments(value: [string]) {
            attachments = value;
            image.value = value[0];
            imagesModal.value.toggle(true);
        }

        function rightArrowClicked() {
            for (let i = 0; i < attachments.length; i++) {
                if (attachments[i] == image.value) {
                    if (i == attachments.length - 1) {
                        image.value = attachments[0];
                        break;
                    } else {
                        image.value = attachments[i + 1];
                        break;
                    }
                }
            }
        }
        function leftArrowClicked() {
            for (let i = 0; i < attachments.length; i++) {
                if (attachments[i] == image.value) {
                    if (i == 0) {
                        image.value = attachments[attachments.length - 1];
                        break;
                    } else {
                        image.value = attachments[i - 1];
                        break;
                    }
                }
            }
        }

        return {
            switchSection,
            isShowSales,
            ps_loading,
            salesList,
            purchaseList,
            loginUserId,
            undisputedBids,
            noProduct,
            messageModal,
            imagesModal,
            attachments,
            viewAttachments,
            image,
            rightArrowClicked,
            leftArrowClicked,
        };
    },
    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("sales_purchase_section"),
                    url: route("fe_sales_purchase"),
                },
                {
                    label: trans("sales_purchase_section"),
                    color: "text-fePrimary-500",
                },
            ];
        },
    },
};
</script>
