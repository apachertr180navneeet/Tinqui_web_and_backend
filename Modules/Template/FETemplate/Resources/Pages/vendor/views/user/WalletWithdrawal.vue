<template>
    <Head :title="$t('profile__user_wallet')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <div class="w-full mb-6">
                    <ps-breadcrumb-2 :items="breadcrumb"></ps-breadcrumb-2>
                </div>

                <div class="flex flex-wrap">
                    <div class="md:w-full sm:w-full lg:w-full">
                        <div
                            class="wallet-outer border border-gray-300 rounded-lg shadow-lg md:w-11/12 lg:w-11/12 h-full"
                        >
                            <div
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                            >
                                <div
                                    class="flex justify-center font-bold text-xl underline mb-7"
                                >
                                    <ps-route-link
                                        :to="{
                                            name: 'fe_wallet',
                                        }"
                                    >
                                        <button
                                            class="align-left text-start font-semibold text-lg mb-2"
                                        >
                                            &larr; {{ $t("core_fe__back") }}
                                        </button>
                                    </ps-route-link>

                                    <p>{{ $t("wallet_request_withdrawal") }}</p>
                                </div>

                                <div class="flex flex-wrap">
                                    <div class="md:w-full sm:w-full lg:w-full">
                                        <div
                                            class="wallet-outer border border-gray-300 rounded-lg shadow-lg md:w-11/12 lg:w-11/12 h-full"
                                        >
                                            <div
                                                class="flex justify-center font-bold text-xl mt-4"
                                            >
                                                <p>
                                                    {{ $t("current_balance") }}
                                                    {{
                                                        walletholder.walletBalance
                                                    }}
                                                </p>
                                            </div>

                                            <div
                                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                            >
                                                <div
                                                    class="flex justify-center"
                                                >
                                                    <table
                                                        class="mt-8 w-full text-center table-border"
                                                    >
                                                        <thead>
                                                            <tr
                                                                class="blue text-center"
                                                            >
                                                                <th>
                                                                    {{
                                                                        $t(
                                                                            "method"
                                                                        )
                                                                    }}
                                                                </th>
                                                                <th>
                                                                    {{
                                                                        $t(
                                                                            "item_detail__description"
                                                                        )
                                                                    }}
                                                                </th>
                                                                <th>
                                                                    {{
                                                                        $t(
                                                                            "fee"
                                                                        )
                                                                    }}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                class="text-center"
                                                            >
                                                                <td>
                                                                    <ps-label
                                                                        class="ms-2 cursor-green underline font-medium"
                                                                        @click="
                                                                            fillBankDetails()
                                                                        "
                                                                        >{{
                                                                            $t(
                                                                                "express_withdrawal"
                                                                            )
                                                                        }}</ps-label
                                                                    >
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        $t(
                                                                            "connect_withdraw"
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        $t(
                                                                            "fees_vary"
                                                                        )
                                                                    }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap mt-4">
                                    <div class="md:w-full sm:w-full lg:w-full">
                                        <div
                                            class="wallet-outer border border-gray-300 rounded-lg shadow-lg md:w-11/12 lg:w-11/12 h-full"
                                        >
                                            <div
                                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                                style="
                                                    background-color: #e7f5e7;
                                                "
                                            >
                                                <div class="justify-center">
                                                    <p
                                                        class="font-bold text-xl underline mb-7"
                                                    >
                                                        {{ $t("things_note") }}
                                                    </p>
                                                    <ul
                                                        style="
                                                            padding-left: 20px;
                                                            list-style-type: disc !important;
                                                        "
                                                    >
                                                        <li>
                                                            {{
                                                                $t(
                                                                    "withdraw_one"
                                                                )
                                                            }}
                                                        </li>
                                                        <li>
                                                            {{
                                                                $t(
                                                                    "withdraw_two"
                                                                )
                                                            }}
                                                        </li>
                                                        <li>
                                                            {{
                                                                $t(
                                                                    "withdraw_three"
                                                                )
                                                            }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 border-t border-gray-300" />

                                <div class="space-y-8">
                                    <div class="card-container">
                                        <div class="card">
                                            <div
                                                class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md"
                                            >
                                                <table
                                                    class="mt-8 w-full text-center table-border"
                                                >
                                                    <thead>
                                                        <tr class="blue">
                                                            <th>
                                                                {{
                                                                    $t(
                                                                        "requested_at"
                                                                    )
                                                                }}
                                                            </th>
                                                            <th>
                                                                {{
                                                                    $t("amount")
                                                                }}
                                                            </th>

                                                            <th>
                                                                {{
                                                                    $t(
                                                                        "item_detail__status"
                                                                    )
                                                                }}
                                                            </th>
                                                            <th>
                                                                {{
                                                                    $t("notes")
                                                                }}
                                                            </th>
                                                            <th>
                                                                {{
                                                                    $t(
                                                                        "reason_decline"
                                                                    )
                                                                }}
                                                            </th>
                                                            <th>
                                                                {{
                                                                    $t(
                                                                        "processing_date"
                                                                    )
                                                                }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                        v-if="withdrawData"
                                                        v-for="(
                                                            withdrawInfo, index
                                                        ) in withdrawData"
                                                        :key="index"
                                                    >
                                                        <tr>
                                                            <td>
                                                                {{
                                                                    withdrawInfo.request_date
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    withdrawInfo.currency +
                                                                    " " +
                                                                    withdrawInfo.withdraw_amount
                                                                }}
                                                            </td>

                                                            <td>
                                                                {{
                                                                    withdrawInfo.withdraw_status
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    withdrawInfo.notes
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    withdrawInfo.decline_reason
                                                                }}
                                                            </td>

                                                            <td>
                                                                {{
                                                                    withdrawInfo.processing_date
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody v-else>
                                                        <tr>
                                                            <td colspan="5">
                                                                {{
                                                                    $t(
                                                                        "no_withdrawals"
                                                                    )
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr
                                                class="my-4 border-t border-gray-300"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ps-content-container>

    <ps-loading-dialog ref="ps_loading_dialog" />

    <user-phone-login-verification-modal
        ref="user_phone_login_verification_modal"
    />

    <ps-error-dialog ref="ps_error_dialog" />
    <ps-warning-dialog-2 ref="ps_warning_dialog" />
    <ps-loading-dialog ref="psloading" :isClickOut="false" />
    <ps-success-dialog ref="ps_success_dialog" />

    <withdraw-amount-modal
        ref="withdrawal_modal"
        :walletBalance="walletholder.walletBalance"
    />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
// Libs
import { onMounted, reactive, ref } from "vue";

// import router from '@template1/router';
import PsDropdown from "@template1/vendor/components/core/dropdown/PsDropdown.vue";
import PsDropdownSelect from "@template1/vendor/components/core/dropdown/PsDropdownSelect.vue";
// Providers
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
// import { createUserStateListProviderState } from '@templateCore/store/modules/user/UserStateProvider';

// Components
import PsModal from "@template1/vendor/components/core/modals/PsModal.vue";
import BankPsModal from "@template1/vendor/components/core/modals/BankPsModal.vue";
import PsInputWithRightIcon from "@template1/vendor/components/core/input/PsInputWithRightIcon.vue";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsTextarea from "@template1/vendor/components/core/textarea/PsTextarea.vue";
import PsWarningDialog2 from "@template1/vendor/components/core/dialog/PsWarningDialog2.vue";
// import PsTextarea from "@/Components/Core/Textarea/PsTextarea.vue";

import PsCheckboxValue from "@template1/vendor/components/core/checkbox/PsCheckboxValue.vue";
import ProfileUpdateViewHolder from "@templateCore/object/holder/ProfileUpdateViewHolder";
import UserWallet from "@templateCore/object/UserWallet";
import PsStatus from "@templateCore/api/common/PsStatus";
import PsLoadingDialog from "@template1/vendor/components/core/dialogs/PsLoadingDialog.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialogs/PsErrorDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialogs/PsSuccessDialog.vue";
import UserPhoneLoginVerificationModal from "@template1/vendor/components/modules/user/UserPhoneLoginVerificationModal.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLabelTitle3 from "@template1/vendor/components/core/label/PsLabelTitle3.vue";
import DatePicker from "@template1/vendor/components/core/datetime/DatePicker.vue";
import PsRadioValue2 from "@template1/vendor/components/core/radio/PsRadioValue2.vue";
import CheckBox from "@template1/vendor/components/core/checkbox/CheckBox.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";

import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import firebaseApp from "firebase/app";
import "firebase/auth";
// language
import { trans } from "laravel-vue-i18n";
import PsConst from "@templateCore/object/constant/ps_constants";
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";

//check if methods are activated or not Feb14//
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
import AppInfoParameterHolder from "@templateCore/object/holder/AppInfoParameterHolder";
import WalletRechargeHistoryParameterHolder from "@templateCore/object/holder/WalletRechargeHistoryParameterHolder";

import { useWalletRechargeState } from "@templateCore/store/modules/wallet/WalletRechargeStore";

import InputEmailModal from "@template1/vendor/components/modules/email/InputEmailModal.vue";

import WithdrawAmountModal from "@template1/vendor/components/modules/debit/WithdrawAmountModal.vue";

//ends here //
export default {
    name: "User Wallet",
    components: {
        PsModal,
        BankPsModal,
        PsContentContainer,
        PsButton,
        PsLabelHeader4,
        PsIcon,
        PsInput,
        PsTextarea,
        PsCheckboxValue,
        PsLabelTitle3,
        InputEmailModal,
        PsLoadingDialog,
        PsErrorDialog,
        UserPhoneLoginVerificationModal,
        PsLabel,
        PsRouteLink,
        Head,
        PsDropdownSelect,
        PsDropdown,
        PsInputWithRightIcon,
        DatePicker,
        PsRadioValue2,
        CheckBox,
        PsBreadcrumb2,
        PsSuccessDialog,
        PsWarningDialog2,
        WithdrawAmountModal,
    },
    layout: PsFrontendLayout,
    setup(_, { emit }) {
        // Providers
        const userStore = useUserStore();

        // Init Variables
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        /**************feb 14********* */
        const appInfoStore = usePsAppInfoStoreState();
        const ps_warning_dialog = ref();
        const isDemoForPayment = ref(false);
        const appInfoParameterHolder = new AppInfoParameterHolder();
        appInfoParameterHolder.userId = loginUserId;
        const psmodal = ref();

        const withdrawal_modal = ref();

        const psloading = ref();
        const walletrechargeParameterHolder =
            new WalletRechargeHistoryParameterHolder();
        const razorId = ref("");
        const amount = ref("");
        const provider = useWalletRechargeState();

        const holder = reactive(new ProfileUpdateViewHolder());
        const walletholder = reactive(new UserWallet());

        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }

        const date_picker = ref(false);

        const date = new Date();
        date.setFullYear(date.getFullYear() - 18);
        const pickedDate = ref();
        const upperDate = ref(date);
        const ps_loading_dialog = ref();
        const ps_error_dialog = ref();
        const ps_success_dialog = ref();
        let oldUser;
        const razorKey = ref("");
        const input_email = ref();

        let form = useForm({
            product_relation: {},
        });
        let product_relation_errors = ref({});

        const userNameStatus = ref(false);
        const bidInfo = ref(null);

        const withdrawData = ref(null);

        async function openModal() {
            psmodal.value.toggle(true);
            await loadUserData();
        }

        // Functions
        onMounted(async () => {
            loadUserData();
            // loadAppVerifier();
        });

        function fillBankDetails() {
            withdrawal_modal.value.openModal();
        }
        function cancelClicked() {
            router.get(route("fe_wallet_withdrawal"));
        }
        async function isRechargeSuccessful(val) {
            this.$emit("isRechargeSuccessful", val);
            psmodal.value.toggle(false);
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
        async function loadUserData() {
            const info = await appInfoStore.loadAppInfo(appInfoParameterHolder);
            if (
                appInfoStore.appInfo.data.mobileSetting.is_demo_for_payment ==
                PsConst.ONE
            ) {
                isDemoForPayment.value = true;
            }

            ps_loading_dialog.value.openModal();
            const returnData = await userStore.loadUser(loginUserId);
            const walletData = await userStore.loadUserWallet(loginUserId);

            const withdrawResultData =
                await userStore.loadUserWalletWithdrawals(loginUserId);
            if (withdrawResultData.status == PsStatus.SUCCESS) {
                // if (withdrawResultData.data.id == undefined) {
                //     withdrawData.value = null;
                // } else {
                withdrawData.value = withdrawResultData.data;
                // }
            } else {
                withdrawData.value = null;
            }

            oldUser = returnData.data;

            ps_loading_dialog.value.closeModal();
            if (walletData.status == PsStatus.SUCCESS) {
                // console.log("walletData", walletData);
                const walletInfo = walletData.data;

                walletholder.walletBalance = walletInfo.walletBalance;
                walletholder.currency = walletInfo.currency;
                walletholder.rechargeDate = walletInfo.rechargeDate;
                walletholder.onHoldAmount = walletInfo.holdAmount;
                walletholder.userWalletLog = walletInfo.userWalletLog;

                const userInfo = returnData.data;
                holder.userName = userInfo.username;
                holder.userEmail = userInfo.userEmail;

                bidInfo.value = walletInfo.bidDetailsHistory;
                // const bidDetailsHolder = reactive(
                //     new BidDetailsHistory().fromMapList(bidInfo)
                // );

                const walletLogInfo = walletInfo.userWalletLog;
            } else {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__error"),
                    trans("edit_profile__ok"),
                    () => {}
                );
                // router.push({ name : "dashboard"});
            }
        }

        return {
            amount,
            appInfoStore,
            userStore,
            date_picker,
            pickedDate,
            ps_loading_dialog,
            ps_error_dialog,
            ps_success_dialog,
            upperDate,
            form,
            product_relation_errors,
            ps_warning_dialog,
            openModal,
            psmodal,
            withdrawal_modal,
            psloading,
            isRechargeSuccessful,
            holder,
            walletholder,
            input_email,
            bidInfo,
            fillBankDetails,
            cancelClicked,
            withdrawData,
        };
    },
    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("profile__user_wallet"),
                    url: route("fe_wallet"),
                },
                {
                    label: trans("wallet_withdrawal"),
                    color: "text-fePrimary-500",
                },
            ];
        },
    },
};
</script>

<style scoped>
::-webkit-scrollbar {
    width: 0;
    background: transparent;
}

.card-container {
    overflow-y: auto;
    max-height: 523px;
}

.blue {
    background: rgb(1 188 97) !important;
    color: #fff;
}
</style>
