<template>

    <Head :title="$t('bid_history_title')" />
    <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div class="grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-10 word-wrap">
            <div class="col-start-0 col-span-4 sm:col-span-2 lg:col-span-3">
                <ps-label class="text-xl sm:text-2xl font-medium mb-5 dark:text-white">
                    {{ $t("bid_history_title") }}</ps-label>
            </div>
        </div>

        <div class="flex gap-4 flex-wrap mt-3 mb-10" v-if="data">
            <img alt="product image" class="w-24 h-16 object-cover bg-feAchromatic-50" v-lazy="{
                src:
                    $page.props.thumb1xUrl +
                    '/' +
                    (item_detail?.defaultPhoto?.imgPath ?? ''),
                loading: $page.props.sysImageUrl + '/loading_gif.gif',
                error: $page.props.sysImageUrl + '/default_photo.png',
            }" />
            <p class="font-semibold text-xl dark:text-white">
                {{ data?.product_title ?? "Default Product Title" }}
            </p>
        </div>

        <div v-if="data">
            <table>
                <tbody>
                    <tr class="dark:text-white">
                        <td>{{ $t("buyerbids_win_title") }}:</td>
                        <td class="font-semibold px-3">
                            {{
                                data?.highest_bid
                                    ? "Fr. " + data?.highest_bid?.bid_price
                                    : `Fr. 2.00`
                            }}
                        </td>
                    </tr>
                    <tr class="dark:text-white">
                        <td>{{ $t("winning_user_title") }}:</td>
                        <td class="px-3">
                            {{
                                data?.highest_bid
                                    ? data?.highest_bid?.username
                                    : `Na`
                            }}
                        </td>
                    </tr>
                    <!-- <tr v-if="!is_seller">
                        <td>{{ $t('your_max_bid') }}:</td>
                        <td class="px-3">
                            {{ user_max_bid ? "Fr. " + user_max_bid : `Fr. 2.00` }}
                        </td>
                    </tr> -->
                </tbody>
            </table>

            <div class="view-list my-4">
                <ul class="dark:text-white">
                    <li>
                        <span class="capitalize">{{ $t("bids_text") }}:&nbsp;</span>
                        <span class="font-semibold">{{
                            data?.total_bids ?? "3"
                            }}</span>
                    </li>
                    <li>
                        <span>{{ $t("bidders_text") }}:&nbsp;</span>
                        <span class="font-semibold">{{
                            no_of_bidders ?? "2"
                            }}</span>
                    </li>
                    <li>
                        <span>{{ $t("remaining_time") }}:&nbsp;</span>
                        <span class="font-semibold">{{
                            time_left ?? `0 days 0 hours`
                            }}</span>
                    </li>
                    <li>
                        <span>{{ $t("duration_text") }}:&nbsp;</span>
                    <span class="font-semibold">{{
                        item_detail?.isAuctionItem?.toString() != '1' ? item_detail?.auctionPeriod + ` `+$t('promote_item_modal__days') ?? `7` + " "+$t('promote_item_modal__days'): '30 min'
                        }}</span>
                    </li>
                </ul>
                <!-- <p class="w-full sm:w-1/12 lg:w-1/12 dark:text-white">

                </p>
                <p class="w-full sm:w-1/12 lg:w-1/12 dark:text-white">

                </p>
                <p class="w-full sm:w-2/12 lg:w-2/12 dark:text-white">

                </p>
                <p class="w-full sm:w-2/12 lg:w-2/12 dark:text-white">
                    
                </p> -->
            </div>

            <ps-button class="px-7 py-3 rounded-xl" @click="makeOfferClicked" v-if="
                item_detail.addedUserId != loginUserId &&
                !isItemExpired &&
                !isLiveEnd &&
                item_detail?.isSoldOut != '1'
            ">{{ $t("chat__make_an_offer") }}</ps-button>
            <ps-button class="px-7 py-3 rounded-xl" disabled v-else-if="item_detail?.isSoldOut == '1'">{{
                $t("chat__mark_sold_out") }}</ps-button>
            <hr class="my-7" />
        </div>

        <div v-if="data?.all_bids?.length > 0">
            <table class="w-full border border-gray-200">
                <thead class="text-start">
                    <tr>
                        <th class="p-2 border border-gray-200 dark:text-white">
                            {{ $t("bidder_name_text") }}
                        </th>
                        <th class="p-2 border border-gray-200 dark:text-white">
                            {{ $t("bid_amount_text") }}
                        </th>
                        <th class="p-2 border border-gray-200 dark:text-white">
                            {{ $t("bid_time_text") }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(bid, index) in data?.all_bids" :key="index">
                        <td class="p-2 border border-gray-200 dark:text-white">
                            {{ bid?.username }}
                        </td>
                        <td class="p-2 border border-gray-200 dark:text-white">
                            Fr. {{ bid?.bid_price }}
                        </td>
                        <td class="p-2 border border-gray-200 dark:text-white">
                            {{ bid?.bid_created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <offer-modal ref="offer_modal" :price="data?.highest_bid?.bid_price > 0
        ? data?.highest_bid?.bid_price
        : item_detail?.price
        " :currency="'Fr.'" :bid_count="'14'" :time_left="'6d 10h'" @submit="submitOffer" />
    <ps-loading-dialog ref="ps_loading_dialog" />
    <ps-message-dialog ref="ps_message_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { Ref, onMounted, onUnmounted, ref } from "vue";
import PsModal from "@template1/vendor/components/core/modals/PsModal.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialogs/PsLoadingDialog.vue";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import DisputeSkeletorItem from "@template1/vendor/components/modules/chat/DisputeSkeletor.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import { router } from "@inertiajs/vue3";
import "firebase/auth";
import { bidDetailsStoreState } from "@templateCore/store/modules/bid/bidDetailsStore";
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import OfferModal from "@template1/vendor/components/modules/chat/OfferModal.vue";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import PsUtils from "@templateCore/utils/PsUtils";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import PsMessageDialog from "@template1/vendor/components/core/dialog/PsMessageDialog.vue";
import firebaseApp from "firebase/app";
import "firebase/auth";
import "firebase/database";

export default {
    name: "View",
    components: {
        PsModal,
        PsButton,
        PsLabel,
        PsRouteLink,
        PsLoadingDialog,
        Head,
        PsBreadcrumb2,
        DisputeSkeletorItem,
        OfferModal,
        PsMessageDialog,
    },
    props: ["query"],
    layout: PsFrontendLayout,
    setup(props) {
        const ps_loading = ref(false);
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const bidDetailStore = bidDetailsStoreState();
        const data: any = ref();
        const user_max_bid = ref(0);
        const no_of_bidders = ref(0);
        const userStore = useUserStore();
        const offer_modal = ref();
        const item_detail = ref();
        const ps_loading_dialog = ref();
        const itemStore = useProductStore();
        const offerStore = useOfferStoreState();
        const is_seller = ref(false);
        const ps_message_dialog = ref();
        const editRef = firebaseApp
            .database()
            .ref("Editable_Product/" + `edit_${props?.query?.item_id}`);
        const editable = ref(true);
        const time_left = ref("0d 0h 0m");
        let fetcher;
        //---- checks start ---- //
        const liveAuctionItem = ref(false);
        const fixedPriceItem = ref(false);
        const isItemExpired = ref(false);
        const isLiveEnd = ref(false);

        const bidderList = ref([]);
        //---- checks end ---- //

        function startCountdown(diff) {
            let remainingTime = diff;

            function updateCountdown() {
                if (remainingTime <= 0) {
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
                    time_left.value = `${days}d ${hours}h ${minutes}m ${seconds}s`;
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

        if (!loginUserId || loginUserId == PsConst.NO_LOGIN_USER) {
            router.get(route("login"));
        }

        async function getProductBidData() {
            await itemStore.loadItem(props?.query?.item_id, loginUserId);
            item_detail.value = itemStore?.item?.data;
            const result = await bidDetailStore.fetchProductBids(
                loginUserId,
                props?.query?.item_id
            );
            if (result && typeof result === "object") {
                data.value = result;
                if (result?.all_bids?.length > 0) {
                    result?.all_bids?.forEach((bid) => {
                        if (!bidderList.value.includes(bid?.username)) {
                            no_of_bidders.value += 1;
                        }
                        bidderList.value.push(bid?.username);
                    });
                }
            } else {
                console.error("Unexpected API response:", result);
            }
        }

        onMounted(async () => {
            ps_loading.value = true;
            try {
                await userStore?.loadUser(loginUserId);
                await itemStore?.loadItem(props?.query?.item_id, loginUserId);
                item_detail.value = itemStore?.item.data;
                let productRelation = item_detail?.value?.productRelation;
                isItemExpired.value =
                    item_detail?.value?.isExpired == 1 ? true : false;
                for (let i = 0; i < productRelation?.length; i++) {
                    if (
                        productRelation[i]?.coreKeysId === "ps-itm00003" &&
                        productRelation[
                            i
                        ].selectedValue[0]?.value?.toLowerCase() === "fixed price"
                    ) {
                        fixedPriceItem.value = true;
                    }
                }

                // console.log("is item expired", productRelation, isItemExpired.value, fixedPriceItem.value)

                if (
                    item_detail?.value?.isAuctionItem?.toString() == "1" &&
                    item_detail?.value?.auctionStatus?.toString() != "1" &&
                    fixedPriceItem?.value == false
                ) {
                    liveAuctionItem.value = true;
                    livetimeCounter(itemStore?.item?.data?.addedDate);
                } else if (
                    item_detail?.value?.isAuctionItem?.toString() == "1" &&
                    item_detail?.value?.auctionStatus?.toString() == "1" &&
                    fixedPriceItem?.value == false
                ) {
                    isLiveEnd.value = true;
                    liveAuctionItem.value = true;
                } else if (
                    fixedPriceItem?.value == true &&
                    isItemExpired?.value == false
                ) {
                    if (item_detail?.value?.auctionPeriod != "" || null) {
                        timeCounter(
                            itemStore?.item?.data?.addedDate,
                            itemStore?.item?.data?.auctionPeriod
                        );
                    } else {
                        timeCounter(itemStore?.item?.data?.addedDate, "7");
                    }
                } else if (
                    isItemExpired?.value == false &&
                    isLiveEnd?.value == false &&
                    fixedPriceItem?.value == false &&
                    liveAuctionItem?.value == false
                ) {
                    if (item_detail?.value?.auctionPeriod != "" || null) {
                        timeCounter(
                            itemStore?.item?.data?.addedDate,
                            itemStore?.item?.data?.auctionPeriod
                        );
                    } else {
                        timeCounter(itemStore?.item?.data?.addedDate, "7");
                    }
                }
                getProductBidData();
            } catch (error) {
                console.error("Error fetching bids:", error);
            } finally {
                ps_loading.value = false;
            }

            editRef.on("value", (snapshot) => {
                let data = snapshot.val();
                if (data != null) {
                    editable.value = data?.editable;
                }
            });

            fetcher = setInterval(() => {
                getProductBidData();
            }, 5 * 1000);
        });

        onUnmounted(() => {
            clearInterval(fetcher);
        });

        function convertedDate(dateStr) {
            const dateObj = new Date(dateStr);
            return formatDate(dateObj);
        }

        function formatDate(date) {
            // Adjust for IST (UTC+5:30)
            const istOffset = 5.5 * 60 * 60 * 1000;
            const istDate = new Date(date?.getTime() + istOffset);

            const day = istDate.getUTCDate();
            const month = istDate.toLocaleString("en-US", {
                month: "long",
                timeZone: "UTC",
            });
            const year = istDate.getUTCFullYear();

            let hours = istDate.getUTCHours();
            let minutes = istDate.getUTCMinutes();
            const ampm = hours >= 12 ? "pm" : "am";
            hours = hours % 12;
            hours = hours || 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? "0" + minutes : minutes;
            return `${day} ${month} ${year} at ${hours}:${minutes} ${ampm}`;
        }

        function makeOfferClicked() {
            if (
                data?.value?.highest_bid &&
                data?.value?.highest_bid?.bid_price > 0
            ) {
                offer_modal?.value?.openModal(
                    data?.value?.highest_bid?.bid_price,
                    item_detail?.value?.price
                );
            } else {
                offer_modal.value.openModal(
                    item_detail?.value?.price,
                    item_detail?.value?.price
                );
            }
        }

        async function submitOffer(negoPrice, currency) {
            let comparison = getminimumValue(
                data?.value?.highest_bid && data?.value?.highest_bid?.bid_price > 0
                    ? data?.value?.highest_bid?.bid_price
                    : item_detail?.value?.price,
                item_detail?.value?.price
            );
            if (Number(negoPrice) >= Number(comparison)) {
                ps_loading_dialog?.value?.openModal();

                const currentDate = new Date().getTime();
                const DateTimestampStr =
                    PsUtils.getTimeStampDividedByOneThousand(currentDate);
                let data: any = {};
                data.seller_user_id = item_detail?.value?.addedUserId;
                data.recharge_timestamp = DateTimestampStr;
                data.product_id = item_detail?.value?.id;
                data.product_title = item_detail?.value?.title;
                data.product_price = item_detail?.value?.price;
                data.bid_price = negoPrice;

                user_max_bid.value = negoPrice;
                const response = await offerStore.placeBid(data, loginUserId);
                if (response.code == 200 || response.code == 201) {
                    ps_message_dialog.value.openModal(
                        trans("bid_placed_title"),
                        trans("bid_placed_message"),
                        trans("core_fe__ok")
                    );
                    editRef.set({ editable: false });
                }
                ps_loading_dialog?.value?.closeModal();
            } else {
                ps_message_dialog?.value?.openModal(
                    trans("invalid_amount_title"),
                    `${trans("invalid_amount_message")} Fr. ${comparison}`,
                    trans("core_fe__ok")
                );
            }
        }

        function getminimumValue(bidPrice, price) {
            let amt = parseFloat(price);
            let offer = parseFloat(bidPrice);
            if (amt < 1.0) {
                return offer + 0.05;
            } else if (amt >= 1.0 && amt <= 4.99) {
                return offer + 0.25;
            } else if (amt >= 5.0 && amt <= 24.99) {
                return offer + 0.5;
            } else if (amt >= 25.0 && amt <= 99.99) {
                return offer + 1.0;
            } else if (amt >= 100.0 && amt <= 249.99) {
                return offer + 2.5;
            } else if (amt >= 250.0 && amt <= 499.99) {
                return offer + 5.0;
            } else if (amt >= 500.0 && amt <= 999.99) {
                return offer + 10.0;
            } else if (amt >= 1000.0 && amt <= 2499.99) {
                return offer + 25.0;
            } else if (amt >= 2500.0 && amt <= 4999.99) {
                return offer + 50.0;
            } else if (amt >= 5000.0) {
                return offer + 100.0;
            }
        }

        return {
            ps_loading,
            loginUserId,
            data,
            convertedDate,
            user_max_bid,
            no_of_bidders,
            time_left,
            offer_modal,
            makeOfferClicked,
            item_detail,
            submitOffer,
            ps_loading_dialog,
            is_seller,
            ps_message_dialog,
            fixedPriceItem,
            isLiveEnd,
            isItemExpired,
            liveAuctionItem,
        };
    },
    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("profile__user_disputes"),
                    url: route("fe_view_bids"),
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
