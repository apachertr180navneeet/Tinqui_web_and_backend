import { reactive, ref } from "vue";
import PsApiService from "@templateCore/api/PsApiService";
import PsResource from "@templateCore/api/common/PsResource";
import DisputedBidHolder from "@templateCore/object/DisputedBidsHolder";
import DisputedRefundBidHolder from "@templateCore/object/DisputedRefundBidHolder";
import { defineStore } from "pinia";
import makeSeparatedStore from "@templateCore/store/modules/core/PsSepetetedStore";
import BuyerBidResponse from "../../../object/BuyerBidHolder";

const userDisputeStore = makeSeparatedStore((key: string) =>
    defineStore(`userDisputeStore/${key}`, () => {
        const productList = reactive<PsResource<DisputedBidHolder>>(
            new PsResource()
        );

        const loading = reactive({
            value: false,
        });

        async function loadProducts(loginUserId: string) {
            loading.value = true;

            const result =
                await PsApiService.getDisputeSectionBids<DisputedBidHolder>(
                    new DisputedBidHolder(),
                    loginUserId
                );
            // console.log(result, "dispute store");
            productList.data = result.data;
            productList.code = result.code;
            productList.message = result.message;
            productList.status = result.status;

            loading.value = false;

            return result.data;
        }

        // async function loadBidbyId(
        //     loginUserId: string,
        //     data: {
        //         bid_id: string | number;
        //     }
        // ) {
        //     loading.value = true;

        //     const result = await PsApiService.getDisputedBidDetailsbyId(
        //         DisputedRefundBidHolder(),
        //         loginUserId,
        //         data
        //     );
        //     console.log("here");
        //     console.log("result", result);
        //     console.log("----------------------------");
        //     console.log("result", result.data);

        //     loading.value = false;
        //     return result;
        // }

        async function loadBidbyId(
            loginUserId: string,
            data: {
                bid_id: string | number;
            }
        ): Promise<PsResource<DisputedRefundBidHolder>> {
            loading.value = true;

            const result =
                await PsApiService.getDisputedBidDetailsbyId<DisputedRefundBidHolder>(
                    new DisputedRefundBidHolder(),
                    loginUserId,
                    data
                );

            console.log("here");
            console.log("result", result);
            console.log("----------------------------");
            console.log("result", result.data);
            loading.value = false;

            return result;
        }

        async function raiseDispute(
            loginUserId: string,
            data: {
                bid_details_id: string | number;
                dispute_type: string;
                dispute_reason: string;
                dispute_images: [];
            }
        ) {
            loading.value = true;

            const result = await PsApiService.raiseBuyerDispute(
                new DisputedBidHolder(),
                loginUserId,
                data
            );

            loading.value = false;

            return result.status;
        }

        async function getBuyerBidList(
            loginUserId
        ): Promise<PsResource<DisputedBidHolder>> {
            loading.value = true;
            const result = await PsApiService.getBuyerBids<DisputedBidHolder>(
                new DisputedBidHolder(),
                loginUserId
            );
            loading.value = false;
            let data = [];
            if (result?.data && result.data.length > 0) {
                data = result.data;
            }
            return data;
        }

        async function getBuyerBidItemList(
            loginUserId
        ): Promise<PsResource<BuyerBidResponse>> {
            loading.value = true;
            const result =
                await PsApiService.getBuyerBidItems<BuyerBidResponse>(
                    new BuyerBidResponse(),
                    loginUserId
                );
            loading.value = false;
            let data = [];
            if (result?.data && result.data.length > 0) {
                data = result.data;
            }
            return data;
        }

        return {
            loadProducts,
            raiseDispute,
            getBuyerBidList,
            getBuyerBidItemList,
            loadBidbyId,
        };
    })
);

export default userDisputeStore;
