<template>

    <Head :title="$t('buyerbids_page_title')" />
    <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div class="grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-10 word-wrap">
            <div class="col-start-0 col-span-4 sm:col-span-2 lg:col-span-3">
                <ps-label class="text-xl sm:text-3xl font-medium mb-5 ">
                    {{ $t("buyerbids_page_title") }}</ps-label>
            </div>
            <div class="col-span-4 sm:col-span-6 lg:col-span-9">
                <div v-if="ps_loading == true">
                    <div id="winning" class="w-full flex flex-col lg:p-4 p-2 sm:p-3">
                        <div class="w-full">
                            <div class="flex flex-col">
                                <div class="w-full mt-2" v-for="index in 6" :key="index">
                                    <dispute-skeletor-item />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="all" class="flex flex-col mb-16 mt-5" v-if="ps_loading == false">
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div class="w-full relative mb-3 rounded-md h-[27rem]">
                                <div v-if="items.length > 0"
                                    class="relative overflow-x-auto my-3 shadow-md sm:rounded-lg overflow-y-auto h-full">
                                    <div v-for="(item, index) in items" :key="index">
                                        <div class="w-full grid grid-cols-12 border gap-2 p-4">
                                            <div class="col-span-2 h-full flex justify-start items-center">
                                                <img alt="product image"
                                                    class="w-24 h-16 object-cover bg-feAchromatic-50" v-lazy="{
                                                        src:
                                                            $page.props.thumb1xUrl +
                                                            '/' +
                                                            item?.cover[0]?.img_path,
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
                                                    query: { item_id: item.id },
                                                }">
                                                    <h6 class="cursor-pointer text-black font-semibold underline dark:text-white">{{
                                                        item?.title }}</h6>
                                                </ps-route-link>
                                                <h4 class="dark:text-white">{{ item?.category?.name }}</h4>
                                                <p class="dark:text-white">Fr. {{ item?.price }}</p>
                                            </div>
                                            <div class="col-span-2 h-full grid">
                                                <p class="font-semibold dark:text-white">Fr. {{ item.highestBid }}</p>
                                                <ps-route-link :to="{
                                                    name: 'fe_view_bids',
                                                    query: { item_id: item.id },
                                                }">
                                                    <h4 class="text-green-600 cursor-pointer dark:text-white">{{ item.totalBids }} {{
                                                        $t('bids_text')
                                                        }}
                                                    </h4>
                                                </ps-route-link>
                                            </div>
                                            <div class="col-span-2 h-full flex items-center">
                                                <ps-button
                                                    v-if="item.isExpired != '1' && item.isSoldOut != '1' && item.auctionStatus != '1'"
                                                    @click="makeOfferClicked(item)">{{ $t('chat__make_an_offer') }}</ps-button>
                                                <ps-button v-else-if="item.isSoldOut == '1'" disabled>
                                                    {{ $t("chat__mark_sold_out") }}
                                                </ps-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="min-h-full flex items-center justify center">
                                    <p class="m-auto font-semibold text-xl dark:text-white">
                                        {{ $t("profile__user_no_bids") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <offer-modal ref="offer_modal"
        :price="selectedItem?.highestBid > 0 ? selectedItem?.highestBid : selectedItem?.price" :currency="'Fr.'"
        @submit="submitOffer" />
    <ps-loading-dialog ref="ps_loading_dialog" />
    <ps-message-dialog ref="ps_message_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { Ref, onMounted, ref } from "vue";
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
import PsMessageDialog from "@template1/vendor/components/core/dialog/PsMessageDialog.vue";
import OfferModal from "@template1/vendor/components/modules/chat/OfferModal.vue";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import PsUtils from "@templateCore/utils/PsUtils";

export default {
    name: "BuyerBids",
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
        PsMessageDialog,
        OfferModal
    },
    props: ["mobileSetting"],
    layout: PsFrontendLayout,
    setup(_, { emit }) {
        const ps_loading = ref(false);
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const userDisputeStore = DisputeStore();
        const items: Ref<any[]> = ref([]);
        const ps_loading_dialog = ref();
        const ps_message_dialog = ref();
        const selectedItem: Ref = ref({});
        const offer_modal = ref();
        const offerStore = useOfferStoreState();

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
                (await userDisputeStore.getBuyerBidItemList(loginUserId)) || [];
            const result2: [any] = (await userDisputeStore.getBuyerBidList(loginUserId)) || [];
            items.value = result.reverse();
            ps_loading.value = false;
        });

        function makeOfferClicked(item) {
            selectedItem.value = item;
            if (item.highestBid > 0) {
                offer_modal.value.openModal(item.highestBid, item.price);
            } else {
                offer_modal.value.openModal(item.price, item.price);
            }
        }

        async function submitOffer(negoPrice, currency) {
            let comparison = getminimumValue(selectedItem.value?.highestBid ? selectedItem.value?.highestBid : selectedItem.value.price, selectedItem.value.price)
            if (Number(negoPrice) >= Number(comparison)) {
                ps_loading_dialog.value.openModal();

                const currentDate = new Date().getTime();
                const DateTimestampStr =
                    PsUtils.getTimeStampDividedByOneThousand(currentDate);
                let data: any = {}
                data.seller_user_id = selectedItem?.value?.addedUserId;
                data.recharge_timestamp = DateTimestampStr;
                data.product_id = selectedItem?.value?.id
                data.product_title = selectedItem?.value?.title;
                data.product_price = selectedItem?.value?.price;
                data.bid_price = negoPrice;
                const response = await offerStore.placeBid(data, loginUserId);
                if (response.code == 200 || response.code == 201) {
                    ps_message_dialog.value.openModal(
                        trans("bid_placed_title"),
                        trans("bid_placed_message"),
                        trans("core_fe__ok"))

                }
                ps_loading_dialog.value.closeModal();
            } else {
                ps_message_dialog.value.openModal(
                    trans("invalid_amount_title"),
                    `${trans("invalid_amount_message")} Fr. ${comparison}`,
                    trans("core_fe__ok")
                )
            }

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
            ps_loading,
            loginUserId,
            items,
            makeOfferClicked,
            submitOffer,
            ps_message_dialog,
            ps_loading_dialog,
            offer_modal
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
