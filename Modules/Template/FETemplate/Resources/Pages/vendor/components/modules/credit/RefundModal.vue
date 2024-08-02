<template>
    <bank-ps-modal ref="psmodal" :isClickOut="false">
        <template #title>
            <!-- Item entry title -->
            <div class="flex flex-col items-center mt-5">
                <ps-label-header-4 class="font-bold text-xl">
                    {{ $t("refund_initiation_title") }}
                </ps-label-header-4>
            </div>
        </template>
        <template #body>
            <ps-label-header-6 class="font-bold">
                {{ $t("select_refund_type") }}
            </ps-label-header-6>
            <div>
                <div class="border border-gray-200 py-3 px-4">
                    <input
                        type="radio"
                        value="wallet"
                        v-model="selectedMethod"
                    /><span class="ms-2">{{ $t("tinqui_wallet_method") }}</span>
                </div>
                <div
                    class="border border-gray-200 py-3 px-4"
                    v-if="paymentMethod == 'stripe'"
                >
                    <input
                        type="radio"
                        value="stripe"
                        v-model="selectedMethod"
                    /><span class="ms-2"> {{ $t("original_method") }}</span>
                </div>
            </div>

            <div class="flex items-center justify-center my-7">
                <ps-button
                    class="text-center w-60 py-4 mx-auto"
                    @click="proceedRequest()"
                    >Initiate Refund Request</ps-button
                >
                <ps-button
                    class="text-center w-60 py-4 mx-auto ms-4"
                    theme="btn-second"
                    @click="actionClicked()"
                >
                    {{ $t("stripe_credit_card_modal__cancel") }}
                </ps-button>
            </div>
        </template>

        <div v-if="event && event.error">{{ event.error.message }}</div>
    </bank-ps-modal>

    <ps-loading-dialog ref="psloading" :isClickOut="false" />

    <ps-error-dialog ref="ps_error_dialog" />
    <ps-success-dialog ref="ps_success_dialog" :isClickOut="false" />
    <ps-warning-dialog ref="ps_warning_dialog" />
</template>
<script lang="ts">
import { defineComponent, ref } from "vue";
import { useStripe, StripeElement } from "vue-use-stripe";
import "@stripe/stripe-js";
import BankPsModal from "@template1/vendor/components/core/modals/BankPsModal.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialog/PsErrorDialog.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialogs/PsSuccessDialog.vue";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

import PsWarningDialog from "@template1/vendor/components/core/dialogs/PsWarningDialog.vue";

import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsTextarea from "@/Components/Core/Textarea/PsTextarea.vue";

import { useWalletRechargeState } from "@templateCore/store/modules/wallet/WalletRechargeStore";

import { trans } from "laravel-vue-i18n";
import PsUtils from "@templateCore/utils/PsUtils";

import PsStatus from "@templateCore/api/common/PsStatus";
import PsCheckboxValue from "@/Components/Core/Checkbox/PsCheckboxValue.vue";

import RefundBidParameterHolder from "@templateCore/object/holder/RefundBidParameterHolder";

export default defineComponent({
    components: {
        StripeElement,
        BankPsModal,
        PsLabelHeader4,
        PsButton,
        PsLoadingDialog,
        PsErrorDialog,
        PsWarningDialog,
        PsLabel,
        PsInput,
        PsTextarea,
        PsCheckboxValue,
        PsSuccessDialog,
    },
    props: {
        bidId: {
            type: Number,
            required: true,
        },
        paymentMethod: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        // console.log("paymentMethod", props.paymentMethod);
        const psmodal = ref();

        const withdrawAmount = ref();
        const bankName = ref("");
        const branchName = ref("");
        const branchCode = ref("");
        const accountNumber = ref("");
        const accountName = ref("");
        const address = ref("");
        const state = ref("");
        const city = ref("");
        const postal_code = ref("");
        const country = ref("Switzerland");

        const ps_error_dialog = ref();
        const ps_success_dialog = ref();
        const ps_warning_dialog = ref();
        const psloading = ref();

        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const provider = useWalletRechargeState();

        const refundBidParameterHolder = new RefundBidParameterHolder();

        const selectedWallet = ref(false);
        const selectedStripe = ref(false);
        const selectedMethod = ref("wallet");

        let okClicked: Function;
        let cancelClicked: Function;
        function actionClicked(status) {
            if (status == "no") {
                cancelClicked();
            }
            psmodal.value.toggle(false);
        }

        function openModal(
            okClickedAction: Function,
            cancelClickedAction: Function
        ) {
            psmodal.value.toggle(true);
            okClicked = okClickedAction;
            cancelClicked = cancelClickedAction;
        }
        function showSuccessDialog(msg) {
            ps_success_dialog.value.openModal(
                trans("ps_success_dialog__success"),
                msg,
                trans("core__be_btn_ok"),
                () => {
                    // loadUserData();
                    location.reload();
                }
            );
        }
        function getCurrentDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, "0");
            const day = String(now.getDate()).padStart(2, "0");

            const hours = String(now.getHours()).padStart(2, "0");
            const minutes = String(now.getMinutes()).padStart(2, "0");
            const seconds = String(now.getSeconds()).padStart(2, "0");

            return `${year}-${month}-${day}`;
        }

        // const currentDateTime = getCurrentDateTime();

        const proceedRequest = async () => {
            const currentDate = getCurrentDateTime();
            const currentDateTime = new Date().getTime();
            const startDateTimestampStr =
                PsUtils.getTimeStampDividedByOneThousand(currentDateTime);
            console.log(currentDate, "currentDate");
            const method = selectedMethod.value;
            refundBidParameterHolder.bidId = props.bidId;
            refundBidParameterHolder.updateDate = currentDate;
            refundBidParameterHolder.rechargeTimeStamp = startDateTimestampStr;
            psloading.value.openModal();
            if (method == "stripe") {
                const resultstatus = await provider.walletRefundStripe(
                    refundBidParameterHolder,
                    loginUserId
                );
                if (resultstatus.status == PsStatus.ERROR) {
                    psloading.value.closeModal();
                    psmodal.value.toggle(false);
                    ps_error_dialog.value.openModal(
                        trans("ps_error_dialog__request_fail"),
                        resultstatus.message,
                        trans("core__be_btn_ok")
                    );
                    return;
                } else if (resultstatus.status == PsStatus.SUCCESS) {
                    psloading.value.closeModal();
                    psmodal.value.toggle(false);
                    ps_success_dialog.value.openModal(
                        trans("ps_success_dialog__success"),
                        "",
                        trans("core__be_btn_ok"),
                        () => {
                            // loadUserData();
                            location.reload();
                        }
                    );
                }
            }

            if (method == "wallet") {
                const resultstatus = await provider.walletRefund(
                    refundBidParameterHolder,
                    loginUserId
                );
                if (resultstatus.status == PsStatus.ERROR) {
                    psloading.value.closeModal();
                    ps_error_dialog.value.openModal(
                        trans("ps_error_dialog__request_fail"),
                        resultstatus.message,
                        trans("core__be_btn_ok")
                    );
                    return;
                } else if (resultstatus.status == PsStatus.SUCCESS) {
                    psloading.value.closeModal();
                    ps_success_dialog.value.openModal(
                        trans("ps_success_dialog__success"),
                        "Request Initiated successfully",
                        trans("core__be_btn_ok"),
                        () => {
                            // loadUserData();
                            location.reload();
                        }
                    );
                }
            }
        };

        function selectRefundType(type) {
            if (type == "stripe") {
                selectedStripe.value = true;
                selectedWallet.value = false;
                selectedMethod.value = "stripe";
                /**********************hit stripe refund API ******************/
            } else {
                selectedWallet.value = true;
                selectedStripe.value = false;
                selectedMethod.value = "wallet";
                /**********************hit wallet refund API ***********************/
            }
        }

        return {
            psloading,
            psmodal,
            openModal,
            actionClicked,
            proceedRequest,
            withdrawAmount,
            bankName,
            branchName,
            branchCode,
            accountNumber,
            accountName,
            address,
            country,
            state,
            city,
            postal_code,
            getCurrentDateTime,
            ps_error_dialog,
            ps_success_dialog,
            ps_warning_dialog,
            showSuccessDialog,
            selectedWallet,
            selectedStripe,
            selectRefundType,
            selectedMethod,
        };
    },
});
</script>
