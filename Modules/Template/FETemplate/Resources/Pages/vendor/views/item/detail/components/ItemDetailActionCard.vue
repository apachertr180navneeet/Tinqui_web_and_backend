<template>
    <div class="flex flex-col px-2 py-4 lg:p-4 rounded-lg bg-feSecondary-50 dark:bg-feSecondary-800"
        v-if="!fixedPriceItem">
        <!-- <table class="w-full">
      <tr>
        <td class="text-left">Highest bid:</td>
        <th class="">Fr. {{ highest_bid }}</th>
      </tr>
    </table> -->
        <!-- <p class="flex flex-wrap">
      <ps-route-link class="text-green-300" :to="{
        name: 'fe_view_bids',
        query: {
          item_id: item?.id
        }
      }">
        <ps-label class="underline">{{ no_of_bids }} {{ $t('bids_text') }}</ps-label>
      </ps-route-link>&nbsp;|&nbsp;<span>{{ time_left }}</span>
    </p> -->
    </div>
    <div class="mt-6" v-if="loginUserId?.toString() !== item?.addedUserId?.toString()">
        <div v-if="selectedChatType != PsConst.NO_CHAT">
            <ps-route-link class="flex flex-grow" :to="{
                name: 'fe_chat',
                query: {
                    buyer_user_id: loginUserId,
                    seller_user_id: item?.addedUserId,
                    item_id: item?.id,
                    chat_flag: PsConst.CHAT_FROM_SELLER,
                },
            }">
                <ps-button class="w-full flex items-center justify-center" padding="px-4 py-1.5">
                    <ps-icon class="cursor-pointer" textColor="text-feAchromatic-50 mr-2" name="message" h="20"
                        w="20" />
                    <ps-label textColor="font-medium text-base">{{
                        $t("item_detail__chat")
                        }}</ps-label>
                </ps-button>
            </ps-route-link>
        </div>
        <div>
            <!-- buy item button for fixed price -->
            <ps-route-link v-if="
                fixedPriceItem &&
                !liveAuctionItem &&
                !isItemExpired &&
                item?.isSoldOut !== '1'
            " :to="{
                name: 'fe_checkout',
                query: {
                    item_id: item?.id,
                },
            }">
                <ps-button rounded="rounded" class="w-full flex items-center justify-center mt-3">{{
                    $t("chat__buy_item") }}</ps-button>
            </ps-route-link>

            <ps-route-link v-if="
                loginUserId?.toString() == highest_bid_user &&
                !fixedPriceItem &&
                (isItemExpired || isLiveEnd) &&
                item?.isSoldOut !== '1'
            " :to="{
                name: 'fe_checkout',
                query: {
                    item_id: item?.id,
                },
            }">
                <ps-button rounded="rounded" class="w-full flex items-center justify-center mt-3">{{
                    $t("chat__go_to_checkout") }}</ps-button>
            </ps-route-link>
            <!-- buy item button for fixed price -->
            <!-- Bid button for normal Auction -->
            <ps-button @click.prevent="makeOfferClicked" rounded="rounded" v-if="
                !liveAuctionItem &&
                !fixedPriceItem &&
                !isItemExpired &&
                item?.isSoldOut !== '1'
            " class="w-full flex items-center justify-center mt-3">{{ $t("chat__make_an_offer") }}</ps-button>
            <!-- Bid button for normal Auction -->

            <!-- Join button for live Auction -->
            <ps-route-link v-if="
                liveAuctionItem &&
                !isItemExpired &&
                !isLiveEnd &&
                !fixedPriceItem &&
                item?.isSoldOut !== '1'
            " class="flex flex-grow mt-2" :to="{
                name: 'fe_join_auction',
                query: { item_id: item?.id, host_id: item?.addedUserId },
            }">
                <ps-button class="w-full bg-feError-300 flex items-center justify-center" padding="px-4 py-1.5">
                    <ps-label textColor="font-medium text-base">{{
                        $t("Chat__auc_join")
                        }}</ps-label>
                </ps-button>
            </ps-route-link>

            <!-- Give review --------------- -->
            <ps-button v-if="show_review" @click="clickGiveReview()"
                colors="bg-feAchromatic-50 text-fePrimary-500 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                border="border border-feAchromatic-300 dark:border-feAchromatic-500 w-full flex items-center justify-center mt-3">
                {{ $t("chat__leave_a_review") }}
            </ps-button>
            <!-- <ps-button
                @click="clickGiveReview()"
                colors="bg-feAchromatic-50 text-fePrimary-500 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                border="border border-feAchromatic-300 dark:border-feAchromatic-500 w-full flex items-center justify-center mt-3"
            >
                {{ $t("chat__leave_a_review") }}
            </ps-button> -->
        </div>

        <!-- WhatApp Button-->
        <ps-button v-if="whatsAppNo != ''" @click="toWhatsApp()" class="w-full flex items-center justify-center mt-4"
            colors="bg-green-900 text-feAchromatic-50" padding="px-4 py-1.5">
            <ps-icon class="cursor-pointer" textColor="text-feAchromatic-50 mr-2" name="whatsapp" h="20" w="20" />
            <ps-label textColor="font-medium text-base"> WhatsApp </ps-label>
        </ps-button>
    </div>
    <div class="mt-6" v-else>
        <div class="flex flex-col px-2 py-4 lg:p-4 rounded-lg bg-feSecondary-50 dark:bg-feSecondary-800">
            <div class="flex items-center gap-1">
                <ps-icon name="statistic" w="24" h="24" />
                <ps-label textColor="text-base font-semibold text-feSecondary-800 dark:text-feSecondary-50">{{
                    $t("item_detail__statistic") }}</ps-label>
            </div>
            <div class="grid grid-cols-2 mt-6">
                <div class="flex flex-col items-center border-e-2 border-feSecondary-500">
                    <ps-label textColor="font-semibold text-xl text-feSecondary-800 dark:text-feSecondary-50">
                        {{ item?.touchCount }}
                    </ps-label>
                    <div class="flex items-center gap-1 mt-1 text-feSecondary-800 dark:text-feSecondary-200">
                        <ps-icon name="eye-on" w="24" h="24" />
                        <ps-label textColor="font-medium text-base">
                            {{ $t("item_detail__views") }}
                        </ps-label>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <ps-label textColor="font-semibold text-xl text-feSecondary-800 dark:text-feSecondary-50">
                        {{ item?.favouriteCount }}
                    </ps-label>
                    <div class="flex items-center gap-1 mt-1 text-feSecondary-800 dark:text-feSecondary-200">
                        <ps-icon name="heart-outline" w="24" h="24" />
                        <ps-label textColor="font-medium text-base">
                            {{ $t("item_detail__favourites") }}
                        </ps-label>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex gap-6 mt-7">
            <ps-button v-if="isDelivered" padding="p-2" @click="deleteClicked()">
                <ps-icon name="trash-alt" w="24" h="24" />
            </ps-button>
            <ps-button v-else disabled padding="p-2">
                <ps-icon name="trash-alt" w="24" h="24" />
            </ps-button>

            <ps-button class="grow" v-if="
                productStore.showPromoteButton(
                    isPromoteSuccessful,
                    isAllPaymentDisable
                ) && item?.isSoldOut !== '1'
            " @click="promoteClicked">
                {{ $t("item_detail__promote") }}
            </ps-button>
            <ps-button class="grow" v-else disabled>
                {{ $t("item_detail__promote") }}
            </ps-button>
        </div>
        <div class="w-full flex gap-6 mt-6">
            <ps-button class="grow" v-if="
                productStore.isSoldOut(loginUserId) &&
                (isLiveEnd || isItemExpired || no_of_bids == '0')
            " @click="markAsSold">
                {{ $t("item_detail__mark_as_sold") }}
            </ps-button>
            <ps-button class="grow" v-else disabled>
                {{ $t("item_detail__mark_as_sold") }}
            </ps-button>
            <!-- <ps-button class="grow" v-if="productStore.productStatus('1') " @click="markAsEnableDisable('disable')">
        {{ $t("item_detail__mark_as_disable") }}
      </ps-button>
      <ps-button class="grow" v-if="productStore.productStatus('2')" @click="markAsEnableDisable('accept')">
        {{ $t("item_detail__mark_as_enable") }}
      </ps-button> -->
        </div>
        <div v-if="
            liveAuctionItem &&
            !isItemExpired &&
            !isLiveEnd &&
            !fixedPriceItem &&
            item?.isSoldOut !== '1'
        ">
            <ps-route-link class="flex flex-grow" :to="{
                name: 'fe_join_auction',
                query: {
                    item_id: item?.id,
                    host_id: item?.addedUserId,
                },
            }">
                <ps-button class="w-full bg-feError-300 flex items-center justify-center my-2" padding="px-4 py-1.5">
                    <ps-label textColor="font-medium text-base">{{
                        $t("Chat__auc_join")
                        }}</ps-label>
                </ps-button>
            </ps-route-link>
        </div>
    </div>
    <div v-if="
        (loginUserId?.toString() == highest_bid_user ||
            loginUserId?.toString() == item?.addedUserId?.toString()) &&
        tracker_data
    " class="mt-6 pl-[5%] bg-gray-100 py-4">
        <h4 class="mb-4 font-semibold">{{ $t("track_order_text") }}</h4>
        <div v-for="(step, index) in steps" :key="step.status">
            <div class="flex">
                <div :class="[
                    'rounded-full h-6 w-6',
                    isStepCompleted(step.status)
                        ? 'bg-green-500 text-white'
                        : 'bg-gray-300 text-gray-500',
                ]"></div>
                <div class="pl-1 font-semibold">{{ $t(`${step.label}`) }}</div>
            </div>
            <div class="flex pl-[0.7rem]">
                <div v-if="index < steps.length - 1" :class="[
                    'h-16 border-l-4',
                    isStepCompleted(step.status)
                        ? 'border-green-500'
                        : 'border-gray-300',
                ]">
                    <div>
                        <p class="pl-[4%]">
                            {{
                                loginUserId?.toString() ===
                                    item?.addedUserId?.toString()
                                    ? $t(`${step.seller_description}`)
                                    : $t(`${step.buyer_description}`)
                            }}
                        </p>
                        <small>{{ step.date }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ps-payment-error ref="ps_payment_error" />

    <stripe-payment-modal ref="stripe_payment_modal" />
    <promote-item-modal ref="promote_item_modal" @isPromoteSuccessful="handlePromote" />
    <ps-confirm-dialog ref="ps_confirm_dialog" />
    <ps-error-dialog ref="ps_error_dialog" />
    <ps-loading-dialog ref="ps_loading_dialog" />
    <offer-modal ref="offer_modal" :price="item?.price" :currency="'Fr.'" @submit="submitOffer" />
    <ps-delete-warn-dialog ref="ps_delete_warn_dialog" />
    <ps-message-dialog ref="ps_message_dialog" />
    <review-modal ref="review_modal" />
    <ps-success-dialog ref="ps_success_dialog" />
</template>

<script>
import { ref, defineAsyncComponent, onMounted, reactive, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";
import firebaseApp from "firebase/app";
import "firebase/auth";
import "firebase/database";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsDeleteWarnDialog from "../../../../components/core/dialog/PsDeleteWarnDialog.vue";
import PsMessageDialog from "../../../../components/core/dialog/PsMessageDialog.vue";
const PromoteItemModal = defineAsyncComponent(() =>
    import("@template1/vendor/components/modules/item/PromoteItemModal.vue")
);
const PsConfirmDialog = defineAsyncComponent(() =>
    import("@template1/vendor/components/core/dialog/PsConfirmDialog.vue")
);
const PsErrorDialog = defineAsyncComponent(() =>
    import("@template1/vendor/components/core/dialog/PsErrorDialog.vue")
);
import { trans } from "laravel-vue-i18n";
import PsUtils from "@templateCore/utils/PsUtils";
import PsStatus from "@templateCore/api/common/PsStatus";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import MarkSoldOutItemParameterHolder from "@templateCore/object/holder/MarkSoldOutItemParameterHolder";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import OfferModal from "@template1/vendor/components/modules/chat/OfferModal.vue";
import MakeOfferParameterHolder from "@templateCore/object/holder/MakeOfferParameterHolder";
import WalletBidDeductionHolder from "../../../../../../../../../TemplateCore/object/holder/WalletBidDiductionHolder";
import { bidDetailsStoreState } from "@templateCore/store/modules/bid/bidDetailsStore";
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import PsPaymentError from "@template1/vendor/components/core/dialog/PsPaymentError.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialog/PsSuccessDialog.vue";
import ReviewModal from "@template1/vendor/components/modules/review/ReviewModal.vue";

export default {
    name: "ItemDetailActionCard",
    components: {
        PsLabel,
        PsIcon,
        PsRouteLink,
        PsButton,
        PromoteItemModal,
        PsConfirmDialog,
        PsErrorDialog,
        OfferModal,
        PsLoadingDialog,
        PsPaymentError,
        PsDeleteWarnDialog,
        PsMessageDialog,
        PsSuccessDialog,
        ReviewModal,
    },
    props: {
        selectedChatType: String,
        loginUserId: null,
        itemId: null,
        whatsAppNo: "",
        loadDataForItemDetail: Function,
        isAllpaymentDisable: null,
    },
    setup(props) {
        // -------------- ref's -------------- //
        const isPromoteSuccessful = ref(false);
        const promote_item_modal = ref();
        const ps_confirm_dialog = ref();
        const ps_error_dialog = ref();
        const ps_loading_dialog = ref();
        const isSoldOut = ref("0");
        const itemDetail = useProductStore();
        const productStore = useProductStore("detail");
        const item = ref({});
        const offer_modal = ref();
        const editRef = firebaseApp
            .database()
            .ref("Editable_Product/" + `edit_${props.itemId}`);
        const editable = ref(true);
        const ps_delete_warn_dialog = ref();
        const disable_bid = ref(false);
        const ps_message_dialog = ref();
        const previous_bid = ref(0);
        const markAsSoldHolder =
            new MarkSoldOutItemParameterHolder().markSoldOutItemHolder();
        const offerProvider = useOfferStoreState();
        const bidDetails = bidDetailsStoreState();
        const no_of_bids = ref("0");
        const highest_bid = ref("0");
        const time_left = ref("0d 0h 0m");
        const highest_bid_user = ref("");
        const ps_success_dialog = ref();
        const review_modal = ref();
        const show_review = ref(false);
        const isDelivered = ref(false);

        const steps = ref(null);
        const delivery_steps = ref([
            {
                label: "status_accepted_label",
                status: "accepted",
                buyer_description: "status_accepted_buyer_text",
                seller_description: "status_accepted_seller_text",
                date: "",
            },
            {
                label: "status_shipped_label",
                status: "item_shipped",
                buyer_description: "status_shipped_buyer_text",
                seller_description: "status_shipped_seller_text",
                date: "",
            },
            {
                label: "status_received_label",
                status: "item_received",
                buyer_description: "status_received_buyer_text",
                seller_description: "status_received_seller_text",
                date: "",
            },
            {
                label: "status_delivered_label",
                status: "item_delivered",
                buyer_description: "status_delivered_buyer_text",
                seller_description: "status_delivered_seller_text",
                date: "",
            },
        ]);

        const refunding_steps = ref([
            {
                label: "status_accepted_label",
                status: "accepted",
                buyer_description: "status_accepted_buyer_text",
                seller_description: "status_accepted_seller_text",
                date: "",
            },
            {
                label: "status_shipped_label",
                status: "item_shipped",
                buyer_description: "status_shipped_buyer_text",
                seller_description: "status_shipped_seller_text",
                date: "",
            },
            {
                label: "status_received_label",
                status: "item_received",
                buyer_description: "status_received_buyer_text",
                seller_description: "status_received_seller_text",
                date: "",
            },
            {
                label: "status_delivered_label",
                status: "item_delivered",
                buyer_description: "status_delivered_buyer_text",
                seller_description: "status_delivered_seller_text",
                date: "",
            },
        ]);

        const cancelled_steps = ref([
            {
                label: "status_processing_label",
                status: "processing",
                buyer_description: "status_processing_buyer_text",
                seller_description: "status_processing_seller_text",
                date: "",
            },
            {
                label: "status_cancelled_label",
                status: "cancelled",
                buyer_description: "status_cancelled_buyer_text",
                seller_description: "status_cancelled_seller_text",
                date: "",
            },
        ]);

        const tracker_data = ref(false);
        const currentStatus = ref("item_received");

        //---- checks start ---- //
        const liveAuctionItem = ref(false);
        const fixedPriceItem = ref(false);
        const isItemExpired = ref(false);
        const isLiveEnd = ref(false);
        //---- checks end ---- //

        function startCountdown(diff) {
            let remainingTime = diff;

            function updateCountdown() {
                if (remainingTime <= 0) {
                    console.log("ln:410", remainingTime);
                    isItemExpired.value = true;
                    clearInterval(interval);
                } else {
                    const days = Math.floor(
                        remainingTime / (1000 * 60 * 60 * 24)
                    );
                    const hours = Math.floor(
                        (remainingTime % (1000 * 60 * 60 * 24)) /
                        (1000 * 60 * 60)
                    );
                    const minutes = Math.floor(
                        (remainingTime % (1000 * 60 * 60)) / (1000 * 60)
                    );
                    const seconds = Math.floor(
                        (remainingTime % (1000 * 60)) / 1000
                    );
                    time_left.value = `${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
                    remainingTime -= 1000;
                }
            }

            const interval = setInterval(updateCountdown, 1000);
            updateCountdown();
        }

        function timeCounter(startString, endDays) {
            const start = new Date(startString);
            const now = new Date();
            const endTime = start.getTime() + endDays * 24 * 60 * 60 * 1000;
            const diff = endTime - now.getTime();
            console.log("ln:432", diff);
            if (diff > 0) {
                startCountdown(diff);
            } else {
                isItemExpired.value = true;
            }
        }

        function startLiveCountdown(diff) {
            let remainingTime = 30 * 60 * 1000 - diff;

            function updateLiveCountdown() {
                if (remainingTime <= 0) {
                    isLiveEnd.value = true;
                    clearInterval(interval);
                } else {
                    const minutes = Math.floor(
                        (remainingTime % (1000 * 60 * 60)) / (1000 * 60)
                    );
                    const seconds = Math.floor(
                        (remainingTime % (1000 * 60)) / 1000
                    );
                    time_left.value = `${minutes}m ${seconds}s remaining`;
                    remainingTime -= 1000;
                }
            }

            const interval = setInterval(updateLiveCountdown, 1000);
            updateLiveCountdown();
        }

        function livetimeCounter(val) {
            const date = new Date(val);
            const now = new Date();

            const adjustedDate = new Date(date.getTime());

            const diff = now.getTime() - adjustedDate.getTime();

            if (diff <= 30 * 60 * 1000) {
                startLiveCountdown(diff);
            } else {
                isLiveEnd.value = true;
            }
        }

        async function getProductBidData() {
            const result = await bidDetails.fetchProductBids(
                props.loginUserId,
                props.itemId
            );

            if (result) {
                if (result?.total_bids) {
                    no_of_bids.value = result?.total_bids;
                    highest_bid.value = result?.highest_bid?.bid_price;
                    highest_bid_user.value = result?.highest_bid?.buyer_id;
                    previous_bid.value = result?.highest_bid?.bid_price;
                }
                if (
                    result?.highest_bid &&
                    result?.highest_bid?.trackStatus?.length > 0
                ) {
                    let final_status =
                        result?.highest_bid?.trackStatus[0].item_status;
                    if (final_status === "cancelled") {
                        tracker_data.value = true;
                        steps.value = cancelled_steps.value;
                        currentStatus.value = final_status;
                    } else if (final_status === "refunded") {
                        tracker_data.value = true;
                        steps.value = refunding_steps.value;
                        currentStatus.value = final_status;
                    } else if (
                        final_status === "processing" ||
                        final_status === "accepted" ||
                        final_status === "item_shipped" ||
                        final_status === "item_received" ||
                        final_status === "item_delivered" ||
                        final_status === "completed"
                    ) {
                        if (final_status === "item_delivered") {
                            show_review.value = true;
                            isDelivered.value = true;
                        }
                        tracker_data.value = true;
                        steps.value = delivery_steps.value;
                        currentStatus.value = final_status;
                    }
                } else {
                    previous_bid.value = itemDetail.item.data?.price;
                }
            }
        }

        function clickGiveReview() {
            review_modal.value.openModal(
                item.value.addedUserId,
                () => {
                    ps_error_dialog.value.openModal(
                        trans("chat__review_error")
                    );
                },
                () => {
                    ps_success_dialog.value.openModal(
                        trans("ps_success_dialog__success"),
                        trans("chat__review_sent"),
                        trans("core__be_btn_ok")
                    );
                }
            );
        }

        onMounted(async () => {
            editRef.on("value", (snapshot) => {
                let data = snapshot.val();
                if (data != null) {
                    editable.value = data.editable;
                }
            });
            await itemDetail.loadItem(props.itemId, props.loginUserId);

            getProductBidData();
            item.value = itemDetail?.item?.data;
            let productRelation = itemDetail.item?.data?.productRelation;
            isItemExpired.value = item.value.isExpired == 1 ? true : false;
            for (let i = 0; i < productRelation.length; i++) {
                if (
                    productRelation[i].coreKeysId === "ps-itm00003" &&
                    productRelation[i].selectedValue[0].value.toLowerCase() ===
                    "fixed price"
                ) {
                    fixedPriceItem.value = true;
                }
            }

            if (
                item.value.isAuctionItem?.toString() == "1" &&
                item.value.auctionStatus?.toString() != "1" &&
                fixedPriceItem.value != true
            ) {
                liveAuctionItem.value = true;
                livetimeCounter(itemDetail?.item?.data?.addedDate);
            } else if (
                item.value.isAuctionItem?.toString() == "1" &&
                item.value.auctionStatus?.toString() == "1" &&
                fixedPriceItem.value != true
            ) {
                isLiveEnd.value = true;
                liveAuctionItem.value = true;
            } else if (fixedPriceItem.value == true && isItemExpired == false) {
                if (item.value.auctionPeriod != "" || null) {
                    timeCounter(
                        itemDetail?.item?.data?.addedDate,
                        itemDetail?.item?.data?.auctionPeriod
                    );
                } else {
                    timeCounter(itemDetail?.item?.data?.addedDate, "7");
                }
            } else if (
                isItemExpired == false &&
                isLiveEnd.value == false &&
                fixedPriceItem.value == false &&
                liveAuctionItem.value == false
            ) {
                if (item.value.auctionPeriod != "" || null) {
                    timeCounter(
                        itemDetail?.item?.data?.addedDate,
                        itemDetail?.item?.data?.auctionPeriod
                    );
                } else {
                    timeCounter(itemDetail?.item?.data?.addedDate, "7");
                }
            }
        });

        let fetcher = setInterval(() => {
            getProductBidData();
        }, 3 * 1000);

        onUnmounted(() => {
            clearInterval(fetcher)
        })

        async function promoteClicked() {
            isPromoteSuccessful.value = true;
            await PsUtils.waitingComponent(promote_item_modal, 20);
            promote_item_modal.value.openModal(
                itemDetail.item?.data?.id,
                itemDetail?.item?.data?.price
            );
        }

        function handlePromote(value) {
            isPromoteSuccessful.value = value;
        }

        function toWhatsApp() {
            const whatsappURL = `https://api.whatsapp.com/send?phone=${props.whatsAppNo
                }&text=${encodeURIComponent(itemDetail.item?.data?.title)}`;
            window.open(whatsappURL, "_blank");
        }

        function deleteClicked() {
            if (
                steps.value?.[-1]?.status == "item_delivered"
            ) {
                ps_confirm_dialog.value.openModal(
                    trans("item_detail__delete_this_item"),
                    trans("item_detail__confirm_to_delete_item"),
                    trans("item_detail__delete"),
                    trans("item_detail__cancel"),
                    () => {
                        doDelete();
                    },
                    () => {
                        PsUtils.log("Cancel");
                    }
                );
            } else {
                if (itemDetail?.item.data?.isSoldOut?.toString() == '1') { warning("del_warning"); }
                else { warning("normal"); }
            }
        }

        async function doDelete() {
            const item = await itemDetail.userDeleteItem(
                props.loginUserId,
                props.itemId
            );
            if (item.status == PsStatus.SUCCESS) {
                router.get(route("dashboard"));
            } else {
                ps_error_dialog.value.openModal(item.message);
            }
        }

        async function loadDataForItemDetail() {
            if (props.loadDataForItemDetail) {
                await props.loadDataForItemDetail();
            }
        }

        async function markAsEnableDisable(status) {
            if (
                props.loginUserId &&
                props.loginUserId != PsConst.NO_LOGIN_USER
            ) {
                ps_confirm_dialog.value.openModal(
                    status == "accept"
                        ? trans("item_detail__mark_this_item_enable")
                        : trans("item_detail__mark_this_item_disable"),
                    status == "accept"
                        ? trans("item_detail__are_you_sure_enable")
                        : trans("item_detail__are_you_sure_disable"),
                    trans("core_fe__confirm"),
                    trans("item_detail__cancel"),
                    async () => {
                        ProductStatusChangeHolder.itemId =
                            itemDetail?.item.data?.id;
                        ProductStatusChangeHolder.status = status;
                        ps_loading_dialog.value.openModal();

                        await offerProvider.productStatusChange(
                            props.loginUserId,
                            ProductStatusChangeHolder
                        );
                        loadDataForItemDetail();

                        ps_loading_dialog.value.closeModal();
                    },
                    () => {
                        PsUtils.log("Cancel");
                    }
                );
            } else {
                router.get(route("login"));
            }
        }

        async function markAsSold() {
            if (
                props.loginUserId &&
                props.loginUserId != PsConst.NO_LOGIN_USER
            ) {
                ps_confirm_dialog.value.openModal(
                    trans("item_detail__item_sold_out"),
                    trans("item_detail__are_you_sure"),
                    trans("core_fe__confirm"),
                    trans("item_detail__cancel"),
                    async () => {
                        markAsSoldHolder.itemId = itemDetail?.item.data?.id;
                        ps_loading_dialog.value.openModal();

                        await offerProvider.markAsSoldFromDetail(
                            props.loginUserId,
                            markAsSoldHolder
                        );
                        loadDataForItemDetail();
                        ps_loading_dialog.value.closeModal();
                    },
                    () => {
                        PsUtils.log("Cancel");
                    }
                );
            } else {
                router.get(route("login"));
            }
        }

        async function submitOffer(negoPrice, currency) {
            let comparison = getminimumValue(previous_bid.value, item.value.price)
            if (Number(negoPrice) >= Number(comparison)) {
                ps_loading_dialog.value.openModal();
                const currentDate = new Date().getTime();
                const DateTimestampStr =
                    PsUtils.getTimeStampDividedByOneThousand(currentDate);
                let data = {};
                data.seller_user_id = item?.value?.addedUserId;
                data.recharge_timestamp = DateTimestampStr;
                data.product_id = item?.value?.id;
                data.product_title = item?.value?.title;
                data.product_price = item?.value?.price;
                data.bid_price = negoPrice;

                previous_bid.value = negoPrice;
                const response = await offerProvider.placeBid(
                    data,
                    props.loginUserId
                );
                if (response.code == 200 || response.code == 201) {
                    ps_message_dialog.value.openModal(
                        trans("bid_placed_title"),
                        trans("bid_placed_message"),
                        trans("core_fe__ok")
                    );
                    editRef.set({ editable: false });
                    getProductBidData();
                }
                ps_loading_dialog.value.closeModal();
            } else {
                ps_message_dialog.value.openModal(
                    trans("invalid_amount_title"),
                    `${trans("invalid_amount_message")} Fr. ${comparison
                    }`,
                    trans("core_fe__ok")
                );
            }
        }

        async function makeOfferClicked() {
            if (
                props.loginUserId == null ||
                props.loginUserId == "" ||
                props.loginUserId == PsConst.NO_LOGIN_USER
            ) {
                router.get(route("login"));
            } else {
                offer_modal.value.openModal(
                    parseFloat(highest_bid.value) > 0
                        ? highest_bid.value
                        : item?.value?.price,
                    item?.value?.price
                );
            }
        }

        function warning(type) {
            ps_delete_warn_dialog.value.openModal(type);
        }

        function isStepCompleted(stepStatus) {
            const stepIndex = steps.value.findIndex(
                (step) => step.status === stepStatus
            );
            const currentIndex = steps.value.findIndex(
                (step) => step.status === currentStatus.value
            );
            return stepIndex <= currentIndex;
        }

        function getminimumValue(bidPrice, price) {
            let amt = parseFloat(price);
            let offer = parseFloat(bidPrice);
            if (amt < 1.00) {
                return offer + 0.05;
            } else if (amt >= 1.00 && amt <= 4.99) {
                return offer + 0.25;
            } else if (amt >= 5.00 && amt <= 24.99) {
                return offer + 0.50;
            } else if (amt >= 25.00 && amt <= 99.99) {
                return offer + 1.00;
            } else if (amt >= 100.00 && amt <= 249.99) {
                return offer + 2.50;
            } else if (amt >= 250.00 && amt <= 499.99) {
                return offer + 5.00;
            } else if (amt >= 500.00 && amt <= 999.99) {
                return offer + 10.00;
            } else if (amt >= 1000.00 && amt <= 2499.99) {
                return offer + 25.00;
            } else if (amt >= 2500.00 && amt <= 4999.99) {
                return offer + 50.00;
            } else if (amt >= 5000.00) {
                return offer + 100.00;
            }
        }

        return {
            item,
            warning,
            PsConst,
            editable,
            isSoldOut,
            markAsSold,
            toWhatsApp,
            disable_bid,
            offer_modal,
            submitOffer,
            deleteClicked,
            handlePromote,
            promoteClicked,
            makeOfferClicked,
            ps_message_dialog,
            ps_loading_dialog,
            ps_delete_warn_dialog,
            markAsEnableDisable,
            loadDataForItemDetail,
            no_of_bids,
            highest_bid,
            productStore,
            time_left,
            currentStatus,
            steps,
            tracker_data,
            isStepCompleted,
            highest_bid_user,
            fixedPriceItem,
            liveAuctionItem,
            isLiveEnd,
            isItemExpired,
            ps_confirm_dialog,
            isPromoteSuccessful,
            promote_item_modal,
            handlePromote,
            clickGiveReview,
            ps_success_dialog,
            review_modal,
            show_review,
            isDelivered
        };
    },
};
</script>
