<template>
    <div class="flex items-center gap-7 self-end">
        <ps-label
            textColor="text-sm text-feInfo-500 cursor-pointer share-button"
            @click="shareClicked(productStore.item?.data?.dynamicLink)"
            >{{ $t("item_detail__share") }}</ps-label
        >
        <div v-if="!productStore.isUserItem(loginUserId)">
            <ps-label
                textColor="text-sm text-fePrimary-500 cursor-pointer report-button"
                @click="reportItemClicked"
                >{{ $t("item_detail__report_this_ad") }}</ps-label
            >
        </div>
        <div
            v-if="
                status !== null &&
                (loginUserId?.toString() ==
                    highest_bid?.seller_id?.toString() ||
                    loginUserId?.toString() ==
                        highest_bid?.buyer_id?.toString())
            "
        >
            <ps-button
                v-if="
                    status?.item_status == 'accepted' &&
                    loginUserId?.toString() ==
                        highest_bid?.seller_id?.toString()
                "
                @click.prevent="updateStatus('item_shipped', 'seller')"
                >{{ $t("status_ship_order_button") }}</ps-button
            >
            <ps-button
                v-else-if="
                    status?.item_status == 'item_shipped' &&
                    loginUserId?.toString() == highest_bid?.buyer_id?.toString()
                "
                @click.prevent="updateStatus('item_received', 'buyer')"
                >{{ $t("status_receive_order_button") }}</ps-button
            >
            <ps-button
                v-else-if="
                    status?.item_status == 'item_received' &&
                    loginUserId?.toString() ==
                        highest_bid?.seller_id?.toString()
                "
                @click.prevent="updateStatus('item_delivered', 'seller')"
                >{{ $t("status_deliver_order_button") }}</ps-button
            >
            <!-- <ps-button
                v-else-if="
                    status?.item_status == 'item_delivered' &&
                    loginUserId?.toString() == highest_bid?.buyer_id?.toString()
                "
                @click.prevent="updateStatus('completed', 'buyer')"
                >{{ $t("status_satisfying_order_button") }}</ps-button
            > -->
        </div>
    </div>

    <share-to-social-modal ref="share_modal" />
    <ps-confirm-dialog ref="ps_confirm_dialog" />
    <ps-error-dialog ref="ps_error_dialog" />
    <ps-confirm-dialog-2 ref="ps_confirm_dialog_2" />
</template>

<script>
import { onMounted, ref } from "vue";

import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import ShareToSocialModal from "@template1/vendor/components/layouts/share/ShareToSocialModal.vue";

import PsConfirmDialog from "@template1/vendor/components/core/dialog/PsConfirmDialog.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialog/PsErrorDialog.vue";

import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { useReportedItemStoreState } from "@templateCore/store/modules/item/ReportedItemStore";
import ReportItemHolder from "@templateCore/object/holder/ReportItemHolder";
import PsConst from "@templateCore/object/constant/ps_constants";
import { router } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import PsUtils from "@templateCore/utils/PsUtils";
import PsStatus from "@templateCore/api/common/PsStatus";
import { bidDetailsStoreState } from "@templateCore/store/modules/bid/bidDetailsStore";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsConfirmDialog2 from "@template1/vendor/components/core/dialog/PsConfirmDialog2.vue";

export default {
    name: "ItemDetailShareAndReport",
    components: {
        PsLabel,
        ShareToSocialModal,
        PsConfirmDialog,
        PsErrorDialog,
        PsButton,
        PsConfirmDialog2,
    },
    props: {
        loginUserId: null,
        itemId: null,
        itemName: String,
    },
    setup(props) {
        const productStore = useProductStore("detail");
        const reportedItemStore = useReportedItemStoreState();
        const reportItemHolder = new ReportItemHolder();
        const share_modal = ref();
        const ps_confirm_dialog = ref();
        const ps_error_dialog = ref();
        const status = ref(null);
        const item = ref(null);
        const bidDetails = bidDetailsStoreState();
        const highest_bid = ref(null);
        const ps_confirm_dialog_2 = ref();
        function shareClicked(url) {
            share_modal.value.openModal(url, props.itemId, props.itemName);
        }

        // Report Item Functions
        function reportItemClicked() {
            if (
                props.loginUserId &&
                props.loginUserId != PsConst.NO_LOGIN_USER
            ) {
                ps_confirm_dialog.value.openModal(
                    trans("item_detail__confirm"),
                    trans("item_detail__confirm_to_report_item"),
                    trans("item_detail__report"),
                    trans("item_detail__cancel"),
                    () => {
                        doReport();
                    },
                    () => {
                        PsUtils.log("Cancel");
                    }
                );
            } else {
                router.get(route("login"));
            }
        }

        async function doReport() {
            reportItemHolder.itemId = props.itemId;
            reportItemHolder.reportedUserId = props.loginUserId;
            const item = await reportedItemStore.addReportItem(
                props.loginUserId,
                reportItemHolder
            );

            if (item.status == PsStatus.SUCCESS) {
                router.get(route("dashboard"));
            } else {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__error"),
                    item.message,
                    trans("edit_profile__ok"),
                    () => {}
                );
                return;
                ps_error_dialog.value.openModal();
            }
        }

        onMounted(async () => {
            await productStore.loadItem(props.itemId, props.loginUserId);
            item.value = productStore.item.data;
            const result = await bidDetails.fetchProductBids(
                props.loginUserId,
                props.itemId
            );
            if (result) {
                highest_bid.value = result?.highest_bid;
                if (
                    result?.highest_bid &&
                    result?.highest_bid?.trackStatus?.length > 0
                ) {
                    status.value = result?.highest_bid?.trackStatus[0];
                }
            }
        });

        function updateStatus(update_status, user) {
            ps_confirm_dialog_2.value.openModal(
                trans("order_update_status_title"),
                trans("order_update_status_message"),
                trans("chat__confirm"),
                trans("chat__cancel"),
                async () => {
                    let data = {
                        bid_details_id: highest_bid.value?.id,
                        bid_status: update_status,
                        updated_by: user,
                    };
                    let result = await bidDetails.updateBidStatus(
                        data,
                        props.loginUserId
                    );
                    window.location.reload();
                },
                () => {
                    PsUtils.log("Cancel");
                }
            );
        }
        return {
            productStore,
            shareClicked,
            reportItemClicked,
            share_modal,
            ps_confirm_dialog,
            ps_error_dialog,
            updateStatus,
            item,
            status,
            highest_bid,
            ps_confirm_dialog_2,
        };
    },
};
</script>
<style scoped>
.report-button {
    background-color: rgb(var(--color-fePrimary-500) / var(--tw-bg-opacity));
    float: right;
    color: #fff;
    padding: .5rem 1rem;
    cursor: pointer;
    width: max-content;
} 
</style>
