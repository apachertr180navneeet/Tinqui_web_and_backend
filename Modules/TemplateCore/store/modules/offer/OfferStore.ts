import { reactive, ref } from "vue";

import PsApiService from "@templateCore/api/PsApiService";
import PsResource from "@templateCore/api/common/PsResource";
import Offer from "@templateCore/object/Offer";
import ApiStatus from "@templateCore/object/ApiStatus";
import MakeOfferParameterHolder from "@templateCore/object/holder/MakeOfferParameterHolder";
import IsUserBoughtParameterHolder from "@templateCore/object/holder/IsUserBoughtParameterHolder";
import OfferParameterHolder from "@templateCore/object/holder/OfferParameterHolder";
import MarkSoldOutItemParameterHolder from "@templateCore/object/holder/MarkSoldOutItemParameterHolder";
import ProductStatusChangeParameterHolder from "@templateCore/object/holder/ProductStatusChangeParameterHolder";
import { defineStore } from "pinia";
import makeSeparatedStore from "@templateCore/store/modules/core/PsSepetetedStore";
import AcceptReject from "@templateCore/object/AcceptReject";
import AcceptRejectHolder from "../../../object/holder/AcceptRejectHolder";
import BuyNowHolder from "../../../object/BuyNow";
import BidPlaceResponse from "../../../object/BidPlaceResponse";
import BidAcceptResponse from "../../../object/SellerAcceptBidResponse";
import BidRejectResponse from "../../../object/SellerRejectedBidResponse";
import BuyWithStripe from "../../../object/BuyWithStripe";

export const useOfferStoreState = makeSeparatedStore((key: string) =>
    defineStore(`offerStore/${key}`, () => {
        const offerList = reactive<PsResource<Offer[]>>(new PsResource());
        const loading = reactive({
            value: false,
        });

        let limit = ref(30);
        let offset: Number = 0;
        const isNoMoreRecord = reactive({
            value: false,
        });

        async function makeOffer(
            loginUserId,
            holder: MakeOfferParameterHolder
        ) {
            loading.value = true;

            const returnData = await PsApiService.makeOffer<Offer>(
                new Offer(),
                loginUserId,
                holder.toMap()
            );

            loading.value = false;
            return returnData;
        }
        async function acceptOffer(
            loginUserId,
            holder: MakeOfferParameterHolder
        ) {
            loading.value = true;

            const returnData = await PsApiService.acceptedOffer<Offer>(
                new Offer(),
                holder.toMap(),
                loginUserId
            );

            loading.value = false;
            return returnData;
        }

        async function sellerAcceptsBid(
            loginUserId,
            acceptHolder: AcceptRejectHolder
        ) {
            loading.value = true;
            const isAccepted =
                await PsApiService.postSellerAcceptedBid<BidAcceptResponse>(
                    new BidAcceptResponse(),
                    loginUserId,
                    acceptHolder.toMap()
                );

            loading.value = false;
            return isAccepted;
        }

        async function rejectOffer(
            loginUserId,
            rejectHolder: AcceptRejectHolder
        ) {
            loading.value = true;

            const isRejected =
                await PsApiService.postSellerRejectedBid<BidRejectResponse>(
                    new BidRejectResponse(),
                    loginUserId,
                    rejectHolder.toMap()
                );

            // console.log("response of offer rejected by seller", isRejected);

            loading.value = false;

            return isRejected;
        }

        async function isUserBought(
            loginUserId,
            holder: IsUserBoughtParameterHolder
        ) {
            loading.value = true;

            const returnData = await PsApiService.isUsetBought<ApiStatus>(
                new ApiStatus(),
                loginUserId,
                holder.toMap()
            );

            loading.value = false;
            return returnData;
        }
        async function markAsSold(
            loginUserId,
            holder: IsUserBoughtParameterHolder
        ) {
            loading.value = true;

            const returnData = await PsApiService.makeMarkAsSold<ApiStatus>(
                new ApiStatus(),
                loginUserId,
                holder.toMap()
            );

            loading.value = false;
            return returnData;
        }
        async function markAsSoldFromDetail(
            loginUserId,
            holder: MarkSoldOutItemParameterHolder
        ) {
            loading.value = true;

            const returnData = await PsApiService.markSoldOutItem<ApiStatus>(
                new ApiStatus(),
                loginUserId,
                holder.toMap()
            );

            loading.value = false;
            return returnData;
        }
        async function productStatusChange(
            loginUserId,
            holder: ProductStatusChangeParameterHolder
        ) {
            loading.value = true;

            const returnData =
                await PsApiService.productStatusChange<ApiStatus>(
                    new ApiStatus(),
                    loginUserId,
                    holder.toMap()
                );

            loading.value = false;
            return returnData;
        }

        function updateOfferList(responseData: PsResource<Offer[]>) {
            if (
                offerList != null &&
                offerList.data != null &&
                offerList.data.length > 0 &&
                offset != 0
            ) {
                if (responseData.data != null && responseData.data.length > 0) {
                    if (responseData.data?.length < limit.value) {
                        isNoMoreRecord.value = true;
                    } else {
                        isNoMoreRecord.value = false;
                    }
                    offerList.data.push(...responseData.data);
                } else {
                    isNoMoreRecord.value = true;
                }

                offerList.code = responseData.code;
                offerList.status = responseData.status;
                offerList.message = responseData.message;
            } else {
                if (
                    responseData.data?.length < limit.value ||
                    responseData.data == null
                ) {
                    isNoMoreRecord.value = true;
                } else {
                    isNoMoreRecord.value = false;
                }
                offerList.data = responseData.data;
                offerList.code = responseData.code;
                offerList.status = responseData.status;
                offerList.message = responseData.message;
            }

            if (offerList != null && offerList.data != null) {
                offset = offerList.data.length;
            }
        }

        async function loadOfferList(
            holder: OfferParameterHolder,
            loginUserId
        ) {
            loading.value = true;

            const responseData = await PsApiService.getOfferList<Offer>(
                new Offer(),
                limit.value,
                offset,
                loginUserId,
                holder.toMap()
            );

            updateOfferList(responseData);

            loading.value = false;
        }

        async function resetOfferList(
            holder: OfferParameterHolder,
            loginUserId
        ) {
            offset = 0;

            loading.value = true;

            const responseData = await PsApiService.getOfferList<Offer>(
                new Offer(),
                limit.value,
                offset,
                loginUserId,
                holder.toMap()
            );
            //console.log(responseData);
            updateOfferList(responseData);

            loading.value = false;
        }

        async function BuyItNow(data, loginUserId) {
            loading.value = true;

            const returnData = await PsApiService.postBuyItNow<BuyNowHolder>(
                new BuyNowHolder(),
                loginUserId,
                data
            );

            loading.value = false;
            return returnData;
        }
        async function buyitNowStripe(data, loginUserId) {
            loading.value = true;

            const returnData =
                await PsApiService.postbuyitNowStripe<BuyWithStripe>(
                    new BuyWithStripe(),
                    loginUserId,
                    data
                );

            loading.value = false;
            return returnData;
        }

        async function placeBid(data, loginUserId) {
            loading.value = true;

            const returnData =
                await PsApiService.BidPlacedByUser<BidPlaceResponse>(
                    new BidPlaceResponse(),
                    loginUserId,
                    data
                );

            loading.value = false;
            // console.log(returnData);
            return returnData;
        }

        return {
            isNoMoreRecord,
            loading,
            limit,
            offset,
            offerList,
            markAsSoldFromDetail,
            markAsSold,
            isUserBought,
            acceptOffer,
            rejectOffer,
            sellerAcceptsBid,
            makeOffer,
            resetOfferList,
            loadOfferList,
            productStatusChange,
            BuyItNow,
            placeBid,
            buyitNowStripe,
        };
    })
);
