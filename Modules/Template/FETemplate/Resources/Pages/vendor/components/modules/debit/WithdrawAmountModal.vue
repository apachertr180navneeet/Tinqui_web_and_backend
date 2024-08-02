<template>
    <bank-ps-modal ref="psmodal" :isClickOut="false">
        <template #title>
            <!-- Item entry title -->
            <div class="flex flex-col items-center mt-5">
                <ps-label-header-4 class="font-bold text-xl">
                    {{ $t("express_withdrawal") }}
                </ps-label-header-4>
            </div>
        </template>
        <template #body>
            <!-- <ps-label-header-6 class="font-bold"> 
                {{ $t("bank_details") }}
            </ps-label-header-6> -->

            <div class="flex flex-wrap m-auto">
                <div class="md:w-full sm:w-full lg:w-full">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("withdraw_amount") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="withdrawAmount"
                        v-bind:placeholder="$t('enter_amount')"
                        :maxlength="5"
                        style="width: 95% !important"
                        required
                    />
                    <p class="text-sm">
                        {{ $t("withdraw_note") }}
                    </p>
                </div>
                <!-- <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("bank_name_placeholder") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="bankName"
                        v-bind:placeholder="$t('bank_name_placeholder')"
                        :maxlength="19"
                        style="width: 90% !important"
                    />
                </div>  -->
            </div>
            <!-- <div class="flex flex-wrap m-auto">
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("branch_placeholder") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="branchName"
                        v-bind:placeholder="$t('branch_placeholder')"
                        :maxlength="19"
                        style="width: 90% !important"
                    />
                </div>
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("ifsc_placeholder") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="branchCode"
                        v-bind:placeholder="$t('ifsc_placeholder')"
                        :maxlength="5"
                        style="width: 90% !important"
                    />
                </div>
            </div>
            <div class="flex flex-wrap m-auto">
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("account_number_placeholder") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="accountNumber"
                        v-bind:placeholder="$t('account_number_placeholder')"
                        :maxlength="25"
                        style="width: 90% !important"
                    />
                </div>
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("account_name_placeholder") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="accountName"
                        v-bind:placeholder="$t('account_name_placeholder')"
                        :maxlength="50"
                        style="width: 90% !important"
                    />
                </div>
            </div> -->

            <!-- <ps-label class="font-bold mt-5">
                {{ $t("account_details") }}
            </ps-label>
            <ps-label class="mt-4 mx-2">
                {{ $t("address_placeholder") }}
                <span style="font-size: 17px; color: red">*</span>
            </ps-label>
            <ps-textarea
                rows="2"
                v-model:value="address"
                :placeholder="$t('address_placeholder')"
                style="width: 95% !important"
            ></ps-textarea> -->

            <!-- <div class="flex flex-wrap m-auto">
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("credit_card_view__city") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="city"
                        v-bind:placeholder="$t('credit_card_view__city')"
                        :maxlength="20"
                        style="width: 90% !important"
                    />
                </div>
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("credit_card_view__state") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="state"
                        v-bind:placeholder="$t('credit_card_view__state')"
                        :maxlength="20"
                        style="width: 90% !important"
                    />
                </div>
            </div> -->
            <!-- <div class="flex flex-wrap m-auto">
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("credit_card_view__zip_code") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        v-model:value="postal_code"
                        v-bind:placeholder="$t('credit_card_view__zip_code')"
                        :maxlength="10"
                        style="width: 90% !important"
                    />
                </div>
                <div class="md:w-1/2 sm:w-full lg:w-1/2">
                    <ps-label class="mt-4 mx-2">
                        {{ $t("country_placeholder") }}
                        <span style="font-size: 17px; color: red">*</span>
                    </ps-label>
                    <ps-input
                        class="mt-2 mx-2"
                        type="text"
                        readonly
                        v-model:value="country"
                        v-bind:placeholder="$t('country_placeholder')"
                        :maxlength="20"
                        style="width: 90% !important"
                    />
                </div>
            </div> -->
        </template>
        <template #footer>
            <div class="flex items-center justify-center my-7">
                <ps-button
                    class="text-center w-60 py-4 mx-auto"
                    @click="proceedRequest()"
                    >{{ $t("wallet_withdrawal_request") }}</ps-button
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
    <ps-success-dialog ref="ps_success_dialog" />
    <ps-warning-dialog ref="ps_warning_dialog" />
</template>
<script lang="ts">
import { defineComponent, ref } from "vue";
import { useStripe, StripeElement } from "vue-use-stripe";
import "@stripe/stripe-js";
import BankPsModal from "@template1/vendor/components/core/modals/BankPsModal.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialog/PsErrorDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialog/PsSuccessDialog.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

import PsWarningDialog from "@template1/vendor/components/core/dialogs/PsWarningDialog.vue";

import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsTextarea from "@/Components/Core/Textarea/PsTextarea.vue";

import WithdrawalRequestParameterHolder from "@templateCore/object/holder/WithdrawalRequestParameterHolder";
import { useWalletRechargeState } from "@templateCore/store/modules/wallet/WalletRechargeStore";

import { trans } from "laravel-vue-i18n";
import PsUtils from "@templateCore/utils/PsUtils";

import PsStatus from "@templateCore/api/common/PsStatus";

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
        PsSuccessDialog,
    },
    props: {
        walletBalance: {
            type: Number,
            required: true,
        },
    },
    setup(props) {
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

        const withdrawalrequestparameterHolder =
            new WithdrawalRequestParameterHolder();

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

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        const currentDateTime = getCurrentDateTime();

        const proceedRequest = async () => {
            const balance = props.walletBalance;

            if (balance == 0) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__insufficient_wallet"),
                    trans("ps_error_dialog__insufficient_wallet_msg") +
                        "(Wallet Balance = CHF" +
                        balance +
                        ")",
                    () => {}
                );
                return false;
            }
            if (
                withdrawAmount.value == undefined ||
                isNaN(withdrawAmount.value)
            ) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__invalid"),
                    trans("ps_error_dialog__invalid_msg"),
                    () => {}
                );
                return false;
            }

            if (withdrawAmount.value > balance) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__invalid"),
                    trans("ps_error_dialog__amount_compare") + "CHF " + balance,
                    () => {}
                );
                return false;
            }
            psloading.value.openModal();
            const currentDate = new Date().getTime();
            const startDateTimestampStr =
                PsUtils.getTimeStampDividedByOneThousand(currentDate);
            withdrawalrequestparameterHolder.withdraw_amount =
                withdrawAmount.value;
            withdrawalrequestparameterHolder.currency = "CHF";
            // withdrawalrequestparameterHolder.bank_name = bankName.value;
            // withdrawalrequestparameterHolder.bank_code = branchCode.value;
            // withdrawalrequestparameterHolder.branch_name = branchName.value;
            // withdrawalrequestparameterHolder.account_number =
            //     accountNumber.value;
            // withdrawalrequestparameterHolder.account_name = accountName.value;
            // withdrawalrequestparameterHolder.address = address.value;
            // withdrawalrequestparameterHolder.country = country.value;
            // withdrawalrequestparameterHolder.city = city.value;
            // withdrawalrequestparameterHolder.state = state.value;
            // withdrawalrequestparameterHolder.postal_code = postal_code.value;
            withdrawalrequestparameterHolder.request_date = currentDateTime;
            withdrawalrequestparameterHolder.timestamp = startDateTimestampStr;

            // console.log(withdrawalrequestparameterHolder);

            const withdrawalstatus = await provider.walletWithdraw(
                withdrawalrequestparameterHolder,
                loginUserId
            );
            // console.log(withdrawalstatus);
            // return false;
            if (withdrawalstatus.status == PsStatus.ERROR) {
                psloading.value.closeModal();
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__request_fail"),
                    withdrawalstatus.message,
                    trans("core__be_btn_ok")
                );
                return;
            } else if (withdrawalstatus.status == PsStatus.SUCCESS) {
                psloading.value.closeModal();
                // console.log("withdrawalstatus", withdrawalstatus);

                // return false;
                // window.location.href = withdrawalstatus.data.url;
                //alert("ok");
                // showSuccessDialog(withdrawalstatus.message);

                ps_success_dialog.value.openModal(
                    trans("ps_success_dialog__success"),
                    trans("core__api_withdrawal_submitted_successfully"),
                    trans("core__be_btn_ok"),
                    () => {
                        //console.log("here");
                        // loadUserData();
                        psmodal.value.toggle(false);
                        // window.location.href = "/withdraw";
                        location.reload();
                    }
                );
                // ps_success_dialog.value.openModal(
                //     trans("ps_success_dialog__success"),
                //     trans("core__api_withdrawal_submitted_successfully"),
                //     trans("core__be_btn_ok"),
                //     () => {
                //         // loadUserData();
                //         location.reload();
                //     }
                // );
            } else if (withdrawalstatus.status == 422) {
                psloading.value.closeModal();
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__request_fail"),
                    withdrawalstatus.message,
                    trans("core__be_btn_ok"),
                    () => {
                        // loadUserData();
                        location.href = "/stripe-connect";
                    }
                );
            } else {
                psloading.value.closeModal();
                ps_error_dialog.value.openModal(
                    "",
                    trans("ps_error_dialog__recharge_error")
                );
                return;
            }
        };

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
        };
    },
});
</script>
