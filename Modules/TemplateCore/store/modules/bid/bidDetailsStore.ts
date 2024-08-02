import { reactive, ref } from "vue";
import PsApiService from "@templateCore/api/PsApiService";
import PsResource from "@templateCore/api/common/PsResource";
import getBidDetailsParameterHolder from "@templateCore/object/holder/getBidDetailsParameterHolder";
import BidDetailsHistory from "@templateCore/object/BidDetailsHistory";

import { defineStore } from "pinia";
import makeSeparatedStore from "@templateCore/store/modules/core/PsSepetetedStore";
import ProductBids from "../../../object/ProductBids";
import BidStatusResponse from "../../../object/BidStatusUpdateRes";

export const bidDetailsStoreState = makeSeparatedStore((key: string) =>
    defineStore(`bidDetailsStoreState/${key}`, () => {
        const reportedReportedItemList = reactive<
            PsResource<BidDetailsHistory>
        >(new PsResource());
        const biddetails = reactive<PsResource<BidDetailsHistory>>(
            new PsResource()
        );
        const loading = reactive({
            value: false,
        });

        let limit = ref(10);
        let offset: Number = 0;

        let id: string = "";

        async function getCurrentBidDetails(
            holder: getBidDetailsParameterHolder,
            loginUserId
        ): Promise<PsResource<BidDetailsHistory>> {
            loading.value = true;

            biddetails.data =
                await PsApiService.getCurrentBidDetails<BidDetailsHistory>(
                    new BidDetailsHistory(),
                    loginUserId,
                    holder.toMap()
                );

            loading.value = false;

            return biddetails;
        }

        async function updateBidStatus(
            data,
            loginUserId
        ): Promise<PsResource<BidStatusResponse>> {
            loading.value = true;
            const result = await PsApiService.updateBidStatus<BidStatusResponse>(new BidStatusResponse(), loginUserId, data);
            loading.value = false;

            return result;
        }

        async function fetchProductBids(
            loginId, product_id
        ): Promise<PsResource<ProductBids>> {
            loading.value = true;
            const result = await PsApiService.getProductBids<ProductBids>(new ProductBids(), loginId, { product_id: product_id });
            loading.value = false;
            if (result?.data) {
                return result.data
            } else {
                return null;
            }
        }



        return {
            reportedReportedItemList,
            biddetails,
            loading,
            limit,
            offset,
            id,
            getCurrentBidDetails,
            updateBidStatus,
            fetchProductBids
        };
    })
);
