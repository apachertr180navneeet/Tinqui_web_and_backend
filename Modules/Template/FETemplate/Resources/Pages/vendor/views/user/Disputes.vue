<template>
    <Head :title="$t('profile__user_disputes')" />
    <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div
            class="grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-10 word-wrap"
        >
            <div class="col-start-0 col-span-4 sm:col-span-2 lg:col-span-3">
                <ps-label class="text-xl sm:text-3xl font-medium mb-5">
                    {{ $t("profile__user_disputes") }}</ps-label
                >
                <div class=" ">
                    <div
                        class="flex flex-row rtl:space-x-reverse space-x-2 sm:space-x-0 space-y-0 sm:space-y-2 sm:flex-col"
                        id="sellerbtn  testid"
                        v-if="!isSellerFocus"
                        :disabled="true"
                    >
                        <ps-button
                            class="w-full"
                            @click="switchDisputes(' buyer ')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("profile__user_buying_disputes")
                            }}</span>
                        </ps-button>
                        <ps-button
                            class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500"
                            rounded="rounded"
                            @click="switchDisputes(' seller ')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("profile__user_selling_disputes")
                            }}</span>
                        </ps-button>
                    </div>
                    <div
                        class="flex flex-row rtl:space-x-reverse space-x-2 sm:space-x-0 space-y-0 sm:space-y-2 sm:flex-col"
                        id="buyerbtn"
                        v-else
                        :disabled="true"
                    >
                        <ps-button
                            class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500"
                            rounded="rounded"
                            @click="switchDisputes(' buyer ')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("profile__user_buying_disputes")
                            }}</span>
                        </ps-button>
                        <ps-button
                            class="w-full"
                            @click="switchDisputes(' seller ')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("profile__user_selling_disputes")
                            }}</span>
                        </ps-button>
                    </div>
                </div>
            </div>
            <div class="col-span-4 sm:col-span-6 lg:col-span-9">
                <div
                    class="col-span-4 sm:col-span-6 lg:col-span-9 mb-2"
                    v-if="isSellerFocus"
                >
                    <ps-label class="text-sm sm:text-xl font-medium">
                        {{ $t("profile__user_selling_disputes") }}</ps-label
                    >
                </div>
                <div class="col-span-4 sm:col-span-6 lg:col-span-9 mb-2" v-else>
                    <ps-label class="text-sm sm:text-xl font-medium">{{
                        $t("profile__user_buying_disputes")
                    }}</ps-label>
                </div>
                <div v-if="ps_loading == true">
                    <div
                        id="seller"
                        class="w-full flex flex-col lg:p-4 p-2 sm:p-3"
                    >
                        <div class="w-full">
                            <div class="flex flex-col">
                                <div
                                    class="w-full mt-2"
                                    v-for="index in 6"
                                    :key="index"
                                >
                                    <dispute-skeletor-item />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- buying disputes horizontal -->
                <div
                    id="buyer"
                    class="flex flex-col mb-16 mt-7"
                    v-if="!isSellerFocus && ps_loading == false"
                >
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div
                                class="w-full relative mb-4 rounded-md cursor-pointer h-[29rem]"
                            >
                                <div class="w-full flex justify-end">
                                    <ps-button
                                        v-if="undisputedBids.length == 0"
                                        @click="noProduct"
                                        colors="bg-fePrimary-400 text-feAchromatic-50"
                                        class="py-3"
                                    >
                                        +
                                        {{
                                            $t("profile__create_dispute_button")
                                        }}
                                    </ps-button>
                                    <ps-route-link
                                        v-else
                                        class="float-end"
                                        :to="{
                                            name: 'fe_create_disputes',
                                        }"
                                    >
                                        <ps-button
                                            colors="bg-fePrimary-400 text-feAchromatic-50"
                                            class="py-3"
                                        >
                                            +
                                            {{
                                                $t(
                                                    "profile__create_dispute_button"
                                                )
                                            }}
                                        </ps-button>
                                    </ps-route-link>
                                </div>
                                <div
                                    v-if="buyerDisputes.length > 0"
                                    class="relative overflow-x-auto my-3 shadow-md sm:rounded-lg overflow-y-auto h-[29rem]"
                                >
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                    >
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                        >
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{
                                                        $t(
                                                            "dispute_form_drop_label"
                                                        )
                                                    }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{ $t("amount") }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{
                                                        $t(
                                                            "item_detail__status"
                                                        )
                                                    }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{ $t("attachments") }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{
                                                        $t(
                                                            "dispute_form_reason_label"
                                                        )
                                                    }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                                                v-for="dispute in buyerDisputes"
                                                :key="dispute.id"
                                            >
                                                <th
                                                    scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {{ dispute.productTitle }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ dispute.bidPrice }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ dispute.dispute_status }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a
                                                        v-if="
                                                            dispute.dispute_images
                                                        "
                                                        @click="
                                                            viewAttachments(
                                                                dispute.dispute_images
                                                            )
                                                        "
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                        >{{ $t("view") }}</a
                                                    >
                                                    <span v-else>{{
                                                        $t("none")
                                                    }}</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ dispute.dispute_reason }}
                                                </td>
                                                <td class="px-6 py-4  dispute-button">
                                                    <ps-route-link
                                                        class="float-end"
                                                        :to="{
                                                            name: 'fe_dispute_details',
                                                            query: {
                                                                bid_id: dispute.id,
                                                            },
                                                        }"
                                                    >
                                                        <ps-button
                                                            colors="bg-fePrimary-400 text-feAchromatic-50"
                                                            class="py-3 w-[128px]"
                                                        >
                                                            View Dispute Details
                                                        </ps-button>
                                                    </ps-route-link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div
                                    v-else
                                    class="min-h-full flex items-center justify center"
                                >
                                    <p class="m-auto font-semibold text-xl">
                                        {{ $t("profile__user_no_disputes") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End buying disputes horizontal -->

                <!-- selling disputes horizontal -->
                <div
                    id="seller"
                    class="flex flex-col mb-16 mt-7"
                    v-if="isSellerFocus && ps_loading == false"
                >
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div
                                class="w-full relative mb-4 rounded-md cursor-pointer h-[29rem]"
                            >
                                <div
                                    v-if="sellerDisputes.length > 0"
                                    class="relative overflow-x-auto my-3 shadow-md sm:rounded-lg overflow-y-auto h-[29rem]"
                                >
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 shadow-lg"
                                    >
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                        >
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{
                                                        $t(
                                                            "dispute_form_drop_label"
                                                        )
                                                    }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{ $t("amount") }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{ $t("service_cost") }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{ $t("received_amount") }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{
                                                        $t(
                                                            "item_detail__status"
                                                        )
                                                    }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{ $t("attachments") }}
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3"
                                                >
                                                    {{
                                                        $t(
                                                            "dispute_form_reason_label"
                                                        )
                                                    }}
                                                </th>
                                                <th scope="col"
                                                class="px-6 py-3"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                                                v-for="dispute in sellerDisputes"
                                                :key="dispute.id"
                                            >
                                                <th
                                                    scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                >
                                                    {{ dispute.productTitle }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ dispute.bidPrice }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ dispute.bidCommission }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ dispute.amountPaid }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ dispute.dispute_status }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a
                                                        v-if="
                                                            dispute.dispute_images
                                                        "
                                                        @click="
                                                            viewAttachments(
                                                                dispute.dispute_images
                                                            )
                                                        "
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                        >View</a
                                                    >
                                                    <span v-else>{{
                                                        $t("none")
                                                    }}</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ dispute.dispute_reason }}
                                                </td>
                                                <td class="px-6 py-4 dispute-button">
                                                    <ps-route-link
                                                        class="float-end"
                                                        :to="{
                                                            name: 'fe_dispute_details',
                                                            query: {
                                                                bid_id: dispute.id,
                                                            },
                                                        }"
                                                    >
                                                        <ps-button
                                                            colors="bg-fePrimary-400 text-feAchromatic-50"
                                                            class="py-3"
                                                        >
                                                            View Dispute Details
                                                        </ps-button>
                                                    </ps-route-link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div
                                    v-else
                                    class="min-h-full flex items-center justify center"
                                >
                                    <p class="m-auto font-semibold text-xl">
                                        {{ $t("profile__user_no_disputes") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End selling disputes horizontal -->
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------- START NO PRODUCT MODAL ------------------------------------------------------- -->

    <ps-modal ref="messageModal" maxWidth="350px" :isClickOut="false">
        <template #title>
            <ps-label-title
                >{{ $t("chat__no") }}&nbsp;{{
                    $t("dispute_form_drop_label")
                }}&nbsp;{{ $t("item_detail__available") }}</ps-label-title
            >
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

    <ps-image-modal
        ref="imagesModal"
        :isClickOut="false"
        class="z-50 content-center mx-auto"
    >
        <template #body>
            <div class="w-screem flex flex-col">
                <div class="flex flex-row justify-between">
                    <div class="flex-grow" />
                    <ps-icon
                        @click="imagesModal.toggle(false)"
                        name="close"
                        class="text-feSecondary-700 dark:text-feAchromatic-500"
                        w="30"
                        h="30"
                    />
                </div>
                <div class="flex flex-row justify-between">
                    <div class="my-auto" @click="leftArrowClicked">
                        <ps-icon
                            name="leftArrow"
                            class="block sm:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500"
                            w="30"
                            h="30"
                        />
                        <ps-icon
                            name="leftArrow"
                            class="hidden sm:block lg:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500"
                            w="40"
                            h="40"
                        />
                        <ps-icon
                            name="leftArrow"
                            class="hidden lg:block stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500"
                            w="50"
                            h="50"
                        />
                    </div>
                    <div class="flex flex-grow max-w-5/6">
                        <img
                            alt="Placeholder"
                            width="300px"
                            height="400px"
                            class="w-full h-112 overflow:hidden object-contain"
                            v-lazy="{
                                src: $page.props.disputesUrl + '/' + image,
                                loading:
                                    $page.props.sysImageUrl +
                                    '/loading_gif.gif',
                                error:
                                    $page.props.sysImageUrl +
                                    '/default_photo.png',
                            }"
                        />
                    </div>
                    <div
                        class="my-auto cursor-pointer"
                        @click="rightArrowClicked"
                    >
                        <ps-icon
                            name="rightArrow"
                            class="block sm:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500"
                            w="30"
                            h="30"
                        />
                        <ps-icon
                            name="rightArrow"
                            class="hidden sm:block lg:hidden stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500"
                            w="40"
                            h="40"
                        />
                        <ps-icon
                            name="rightArrow"
                            class="hidden lg:block stroke-current stroke-0"
                            textColor="text-feSecondary-700 dark:text-feAchromatic-500"
                            w="50"
                            h="50"
                        />
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
import "firebase/auth";

export default {
    name: "My Disputes",
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
        DisputeStore
    },
    props: ["mobileSetting"],
    layout: PsFrontendLayout,
    setup(_, { emit }) {
        const ps_loading = ref(false);
        const isSellerFocus = ref(false);
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const sellerDisputes: any = ref([]);
        const buyerDisputes: any = ref([]);
        const undisputedBids: any = ref([]);
        const userDisputeStore = DisputeStore();
        const messageModal = ref();
        const imagesModal = ref();
        let attachments = new Array();
        const image = ref();

        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }

        onMounted(async () => {
            ps_loading.value = true;
            const result: [any] =
                (await userDisputeStore.loadProducts(loginUserId)) || [];
            if (result.length > 0) {
                await result.forEach((dispute) => {
                    if (dispute.buyerId?.toString() === loginUserId) {
                        if (dispute.disputed_bid.toLowerCase() === "yes") {
                            buyerDisputes.value.push(dispute);
                        } else {
                            undisputedBids.value.push(dispute);
                        }
                    } else if (dispute.sellerId?.toString() === loginUserId) {
                        if (dispute.disputed_bid.toLowerCase() === "yes") {
                            sellerDisputes.value.push(dispute);
                        }
                    }
                });
            }
            ps_loading.value = false;
        });

        async function switchDisputes(user = " buyer ") {
            if (user == " seller ") {
                isSellerFocus.value = true;
            } else if (user == " buyer ") {
                isSellerFocus.value = false;
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
            switchDisputes,
            isSellerFocus,
            ps_loading,
            sellerDisputes,
            buyerDisputes,
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
                    label: trans("profile__user_disputes"),
                    url: route("fe_disputes"),
                },
                {
                    label: trans("profile__user_disputes"),
                    color: "text-fePrimary-500",
                },
            ];
        },
    },
};
</script>
<style scoped>
td.initiate-button {
    text-align: center;
    justify-content: center;
    display: flex;
}
td.initiate-button button {
    margin-left: 10px;
}
.dispute-button button {
    width: max-content !important;
}
</style>