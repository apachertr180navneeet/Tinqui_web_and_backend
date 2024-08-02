<template>

    <!-- For Large Responsive-->
    <div class="flex flex-col px-2 py-4 lg:p-4 rounded-lg bg-feSecondary-50 dark:bg-feSecondary-800">
        <div class="flex justify-between ">

            <div v-if="!appInfoProvider.selectPriceType(PsConst.NO_PRICE)" class="flex flex-wrap items-center gap-1">
                <div v-if="productStore.isItemDiscount() && appInfoProvider.isShowDiscount()">
                    <ps-label
                        textColor="line-through text-lg font-semibold text-feSecondart-600 dark:text-feSecondary-200">
                        <span v-if="appInfoProvider.selectPriceType(PsConst.NORMAL_PRICE)">
                            {{ productStore.item?.data?.itemCurrency?.currencySymbol }}
                            {{ formatPrice(productStore.item?.data ? productStore.item?.data?.originalPrice : '') }}
                        </span>
                    </ps-label>
                </div>
                <ps-label textColor="font-semibold text-fePrimary-500 "
                    :class="formatPrice(productStore.item?.data ? productStore.item?.data?.price : '').length > 15 ? 'text-2xl' : 'text-4xl'">
                    <span v-if="appInfoProvider.selectPriceType(PsConst.NORMAL_PRICE)">{{
                        productStore.item?.data?.itemCurrency?.currencySymbol }}</span>
                    {{ formatPrice(bid_price ? bid_price : productStore.item?.data ?
                        productStore.item?.data?.price : '') }}
                </ps-label>
            </div>
            <ps-button v-if="!productStore.isUserItem(loginUserId)" padding="p-2"
                colors="bg-feAchromatic-50 text-fePrimary-500 dark:bg-feSecondary-700 dark:text-fePrimary-500"
                border="border" hover="" focus="" @click="favouriteClicked">
                <ps-icon textColor="text-fePrimary-500 dark:text-feAchromatic-50" v-if="productStore.isFavourite()"
                    name="heart" w="24" h="24" />
                <ps-icon textColor="text-fePrimary-500 dark:text-fePrimary-500" v-else name="heart-outline" w="24"
                    h="24" />
            </ps-button>
            <ps-route-link v-else-if="productStore.isUserItem(loginUserId) && submitButtonShow == true && productStore.item.data.isSoldOut != '1'"
                class="cursor-pointer"
                :to="{ name: 'fe_item_entry', query: { itemId: productStore.item?.data?.id, categoryId: productStore.item?.data?.category?.catId } }">
                <ps-icon textColor="text-fePrimary-500" name="pencil" w="24" h="24" />
            </ps-route-link>
        </div>
        <!-- <div class="mt-4" v-if="no_of_bids != ''">
            <ps-label textColor="text-base font-normal text-feSecondary-600 dark:text-feSecondary-50">{{
                no_of_bids }} {{ $t('bids_text') }}</ps-label>
        </div> -->
        <div class="mt-4">
            <ps-label textColor="text-base font-normal text-feSecondary-600 dark:text-feSecondary-50">{{
                productStore.item?.data ? productStore.item?.data?.title : '' }}</ps-label>
        </div>
        <div class="mt-3">
            <p v-if="productStore.item?.data?.isSoldOut?.toString()=='0'" class="flex flex-wrap cursor-pointer">
                <ps-route-link class="text-green-300" :to="{
                    name: 'fe_view_bids',
                    query: {
                        item_id: item?.id
                    }
                }">
                    <ps-label class="underline" v-if="!fixedPriceItem" >{{ no_of_bids }} {{ $t('bids_text') }} &nbsp;|&nbsp;</ps-label>
                </ps-route-link><span class="dark:text-white">{{ time_left }}</span>
            </p>
        </div>
        <div class="mt-3" v-if="!fixedPriceItem && (isItemExpired || isLiveEnd)">
            <p class="font-semibold dark:text-white">{{ $t("auction_ended") }}</p>
        </div>
        <!-- <div class="flex justify-between items-center mt-7 location_time">
            <div class="flex">
                <ps-icon name="location" w="20" h="20" viewBox="0 -2 19 19" />
                <ps-label
                    textColor="text-sm font-normal text-feSecondary-600 dark:text-feSecondary-50">{{
                        productStore.item?.data ? productStore.item?.data?.itemLocation.name : ''
                    }}</ps-label>
            </div>
            <ps-label textColor="text-sm font-normal text-feSecondary-600 dark:text-feSecondary-50">{{
                productStore.item?.data ? productStore.item?.data?.addedDateStr : '' }}</ps-label>
        </div> -->
    </div>
</template>

<script>

import { ref, onMounted, watch, onUnmounted } from 'vue';

// Components
import PsLabel from '@template1/vendor/components/core/label/PsLabel.vue';
import PsIcon from '@template1/vendor/components/core/icons/PsIcon.vue';
import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
import PsRouteLink from '@template1/vendor/components/core/link/PsRouteLink.vue';

import { trans } from 'laravel-vue-i18n';

import format from 'number-format.js';
import PsConst from '@templateCore/object/constant/ps_constants';
import { useProductStore } from '@templateCore/store/modules/item/ProductStore';
import { usePsAppInfoStoreState } from '@templateCore/store/modules/appinfo/AppInfoStore';
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { useCustomFieldStoreState } from '@templateCore/store/modules/customField/CustomFieldStore';
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { bidDetailsStoreState } from "@templateCore/store/modules/bid/bidDetailsStore";

export default {
    name: "ItemDetailPriceInfoCard",
    components: {
        PsLabel,
        PsIcon,
        PsButton,
        PsRouteLink
    },
    props: {
        loginUserId: null,
        favouriteClicked: Function,
        itemId: String,
        highestBid: String
    },
    setup(props) {

        const productStore = useProductStore('detail');
        const appInfoProvider = usePsAppInfoStoreState();
        const userProvider = useUserStore();
        const itemCustomFieldStore = useCustomFieldStoreState('detail');
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const no_of_bids = ref('0')
        const bidDetailStore = bidDetailsStoreState();
        const submitButtonShow = ref();
        const itemId = ref(props.itemId);
        const bid_price = ref(props.highestBid);
        const item = ref();
        let fetcher ;

        //---- checks start ---- //
        const liveAuctionItem = ref(false);
        const fixedPriceItem = ref(false);
        const isItemExpired = ref(false);
        const isLiveEnd = ref(false);
        const time_left = ref('0d 0h 0m');
        //---- checks end ---- //

        function startCountdown(diff) {
            let remainingTime = diff;

            function updateCountdown() {
                if (remainingTime <= 0) {
                    isItemExpired.value = true;
                    clearInterval(interval);
                } else {
                    const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
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
                    const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
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


        watch(() => props.highestBid, (newVal, oldVal) => {

            if (newVal) {
                bid_price.value = newVal;
            }
        });

        async function fetchDetails() {
            await productStore.loadItem(props.itemId, loginUserId);
            item.value = productStore?.item?.data;
            const result = await bidDetailStore.fetchProductBids(loginUserId, props.itemId);
            no_of_bids.value = result?.total_bids || '0'
            let productRelation = item.value?.productRelation;
            isItemExpired.value = item.value?.isExpired == 1 ? true : false;
            for (let i = 0; i < productRelation.length; i++) {
                if (productRelation[i].coreKeysId === "ps-itm00003" && productRelation[i].selectedValue[0].value.toLowerCase() === "fixed price") {
                    fixedPriceItem.value = true;
                }
            }


            // console.log("is item expired", productRelation, isItemExpired.value, fixedPriceItem.value)

            if (item.value.isAuctionItem?.toString() == "1" && item.value.auctionStatus?.toString() != "1" && fixedPriceItem.value == false) {
                liveAuctionItem.value = true;
                livetimeCounter(productStore?.item?.data?.addedDate)
            } else if (item.value.isAuctionItem?.toString() == "1" && item.value.auctionStatus?.toString() == "1" && fixedPriceItem.value == false) {
                isLiveEnd.value = true;
                liveAuctionItem.value = true;
            } else if (fixedPriceItem.value == true && isItemExpired.value == false) {
                if (item.value.auctionPeriod != "" || null) {
                    timeCounter(productStore?.item?.data?.addedDate, productStore?.item?.data?.auctionPeriod)
                } else {
                    timeCounter(productStore?.item?.data?.addedDate, "7");
                }
            } else if (isItemExpired.value == false && isLiveEnd.value == false && fixedPriceItem.value == false && liveAuctionItem.value == false) {
                if (item.value.auctionPeriod != "" || null) {
                    timeCounter(productStore?.item?.data?.addedDate, productStore?.item?.data?.auctionPeriod)
                } else {
                    timeCounter(productStore?.item?.data?.addedDate, "7");
                }
            }
        }

        onMounted(async () => {
            isSubmitButtonShow();
            fetchDetails()
           fetcher =  setInterval(async () => {
                const result = await bidDetailStore.fetchProductBids(loginUserId, props.itemId);
                no_of_bids.value = result?.total_bids || '0'
                // console.log(result)
                if(result?.highest_bid!= null){
                    bid_price.value = result?.highest_bid?.bid_price;
                }
            }, 1000 * 3)
        });

        onUnmounted(()=>{
        clearInterval(fetcher)
      })

        function formatPrice(value) {

            if (appInfoProvider.appInfo.data?.psAppSetting?.SelectedPriceType == PsConst.NORMAL_PRICE && value.toString() == '0') {
                return trans('item_price__free');
            } else {
                if (appInfoProvider.appInfo.data?.psAppSetting?.SelectedPriceType == PsConst.PRICE_RANGE) {
                    const floatValue = parseFloat(value);
                    const intValue = parseInt(floatValue);
                    if (intValue > 5) {
                        return '$'.repeat(5);
                    }
                    if (intValue < 1) {
                        return '$'.repeat(1);
                    }
                    return '$'.repeat(intValue);
                } else {

                    if (appInfoProvider?.appInfo?.data?.mobileSetting?.price_format === "###,###") {
                        const formattedNumber = new Intl.NumberFormat('en-FR', {
                            style: 'decimal',
                            useGrouping: true,
                            minimumFractionDigits: 0,
                        }).format(value);
                        return formattedNumber.replace(",", ' ');
                    } else {
                        return format("#'##0.00", value);
                    }
                }
            }
        }

        async function isSubmitButtonShow() {
            if (props.loginUserId != 'nologinuser') {
                await userProvider.loadUser(props.loginUserId);
                const roleId = await userProvider.user.data ? userProvider.user.data.roleId : '';
                const isVerifybluemark = await userProvider.user.data ? userProvider.user.data.isVerifybluemark : '';

                submitButtonShow.value = appInfoProvider.isSubmitButtonShow(roleId, isVerifybluemark);

            } else {
                submitButtonShow.value = true
            }
        }


        return {
            PsConst,
            formatPrice,
            productStore,
            appInfoProvider,
            submitButtonShow,
            no_of_bids,
            bid_price,
            itemCustomFieldStore,
            time_left,
            item,
            fixedPriceItem
        }
    }
}
</script>
