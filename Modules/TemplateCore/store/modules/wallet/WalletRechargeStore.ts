import { reactive, ref } from "vue";
import PsApiService from "@templateCore/api/PsApiService";
import PsResource from "@templateCore/api/common/PsResource";
import WalletRechargeHistoryParameterHolder from "@templateCore/object/holder/WalletRechargeHistoryParameterHolder";
import WalletPaidHistory from "@templateCore/object/WalletPaidHistory";
import MolliePaymentUrl from "@templateCore/object/MolliePaymentUrl";
import BidRefundDetails from "@templateCore/object/HighestBid";

import BidDetailsHistory from "@templateCore/object/BidDetailsHistory";
import WalletWithdrawHistory from "@templateCore/object/WalletWithdrawHistory";
import WithdrawalRequestParameterHolder from "@templateCore/object/holder/WithdrawalRequestParameterHolder";
import RefundBidParameterHolder from "@templateCore/object/holder/RefundBidParameterHolder";

import { defineStore } from "pinia";
import makeSeparatedStore from "@templateCore/store/modules/core/PsSepetetedStore";

import WalletBidDeductionHolder from "../../../object/holder/WalletBidDiductionHolder";
import WalletBidDeductor from "../../../object/WalletBidDeductor";

export const useWalletRechargeState = makeSeparatedStore((key: string) =>
    defineStore(`walletRechargeStore/${key}`, () => {
        const paiditem = reactive<PsResource<WalletPaidHistory>>(
            new PsResource()
        );

        const bidItem = reactive<PsResource<WalletBidDeductor>>(
            new PsResource()
        );

        const bidDetails = reactive<PsResource<BidDetailsHistory>>(
            new PsResource()
        );

        const withdrawDetails = reactive<PsResource<WalletWithdrawHistory>>(
            new PsResource()
        );

        const loading = reactive({
            value: false,
        });

        let limit = ref(10);
        let offset: Number = 0;

        let id: string = "";

        async function postWalletRecharge(
            holder: WalletRechargeHistoryParameterHolder,
            loginUserId
        ): Promise<PsResource<WalletPaidHistory>> {
            loading.value = true;

            const result =
                await PsApiService.postWalletRecharge<WalletPaidHistory>(
                    new WalletPaidHistory(),
                    loginUserId,
                    holder.toMap()
                );

            //paiditem.data = result;

            loading.value = false;

            return result;
        }

        async function walletBidDeduction(
            bid: WalletBidDeductionHolder,
            loginUserId
        ): Promise<PsResource<WalletBidDeductor>> {
            loading.value = true;
            bidItem.data =
                await PsApiService.postWalletBidDeduction<WalletBidDeductor>(
                    new WalletBidDeductor(),
                    loginUserId,
                    bid.toMap()
                );

            loading.value = false;
        }

        async function loadUserBids(loginUserId: string) {
            loading.value = true;

            const result = await PsApiService.getUserBids<BidDetailsHistory>(
                new BidDetailsHistory(),
                loginUserId
            );
            bidDetails.data = result.data;
            bidDetails.code = result.code;
            bidDetails.message = result.message;
            bidDetails.status = result.status;

            loading.value = false;

            return bidDetails;
        }

        async function walletWithdraw(
            holder: WithdrawalRequestParameterHolder,
            loginUserId
        ): Promise<PsResource<MolliePaymentUrl>> {
            loading.value = true;

            const result = await PsApiService.walletWithdraw<MolliePaymentUrl>(
                new MolliePaymentUrl(),
                loginUserId,
                holder.toMap()
            );
            // console.log("result", result);
            // withdrawDetails.data = result.data;

            loading.value = false;

            return result;
        }
        async function walletRefund(
            holder: RefundBidParameterHolder,
            loginUserId
        ): Promise<PsResource<BidRefundDetails>> {
            loading.value = true;

            const result = await PsApiService.walletRefund<BidRefundDetails>(
                new BidRefundDetails(),
                loginUserId,
                holder.toMap()
            );
            // console.log("result", result);
            // withdrawDetails.data = result.data;

            loading.value = false;

            return result;
        }
        async function walletRefundStripe(
            holder: RefundBidParameterHolder,
            loginUserId
        ): Promise<PsResource<BidRefundDetails>> {
            loading.value = true;

            const result =
                await PsApiService.walletRefundStripe<BidRefundDetails>(
                    new BidRefundDetails(),
                    loginUserId,
                    holder.toMap()
                );
            // console.log("result", result);
            // withdrawDetails.data = result.data;

            loading.value = false;

            return result;
        }

        return {
            paiditem,
            loading,
            limit,
            offset,
            id,
            postWalletRecharge,
            walletBidDeduction,
            loadUserBids,
            walletWithdraw,
            walletRefund,
            walletRefundStripe,
        };
    })
);
