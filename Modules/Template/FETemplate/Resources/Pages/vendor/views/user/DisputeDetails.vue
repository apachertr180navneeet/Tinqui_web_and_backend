<template>
    <Head :title="$t('profile__user_disputes')" />
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
                                    class="flex justify-center font-bold text-xl mb-7 title-page"
                                >
                                    <p>{{ $t("dispute_details") }}</p>
                                </div>

                                <div class="flex flex-wrap">
                                    <div class="md:w-full sm:w-full lg:w-full">
                                        <table
                                            class="mt-8 w-full text-center table-border table-display"
                                        >
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>Product Name:</td>
                                                    <td>
                                                        {{
                                                            bidholder.productTitle
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Product Amount:</td>
                                                    <td>
                                                        CHF
                                                        {{
                                                            bidholder.productPrice
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Bid Amount:</td>
                                                    <td>
                                                        CHF
                                                        {{ bidholder.bidPrice }}
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Dispute Status:</td>
                                                    <td>
                                                        {{
                                                            bidholder.dispute_status
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Dispute Reason</td>
                                                    <td>
                                                        {{
                                                            bidholder.dispute_reason
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Note Added by admin</td>
                                                    <td
                                                        v-if="
                                                            bidholder.dispute_status_notes
                                                        "
                                                    >
                                                        {{
                                                            bidholder.dispute_status_notes
                                                        }}
                                                    </td>
                                                    <td v-else>N/A</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Payment Type</td>
                                                    <td>
                                                        {{
                                                            bidholder.paymentType.toUpperCase()
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Refund Allowed</td>
                                                    <td
                                                        class="initiate-button"
                                                        v-if="
                                                            bidholder.dispute_refund ==
                                                                'yes' &&
                                                            bidholder
                                                                .trackRefund
                                                                .length == 0
                                                        "
                                                    >
                                                        <!-- {{
                                                            bidholder.dispute_refund
                                                        }} -->
                                                        <ps-button
                                                            v-if="
                                                                showRefundInitiation
                                                            "
                                                            colors="bg-feSuccess-500 text-feAchromatic-50"
                                                            class="py-3 px-7"
                                                            @click="
                                                                initiateRefund
                                                            "
                                                        >
                                                            Initiate Refund
                                                        </ps-button>
                                                    </td>
                                                    <td v-else>
                                                        {{
                                                            bidholder.dispute_refund
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- <div
                                v-if="
                                    bidholder.dispute_refund == 'yes' &&
                                    bidholder.trackRefund.length > 0
                                "
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                            >
                                <div
                                    class="flex justify-center font-bold text-xl underline mb-7"
                                >
                                    <p>Refund Tracking</p>
                                </div>

                                <div class="flex flex-wrap">
                                    <div class="md:w-full sm:w-full lg:w-full">
                                        <p
                                            v-for="refund in bidholder.trackRefund"
                                            :key="refund"
                                        >
                                            {{ refund }}
                                        </p>
                                    </div>
                                </div>
                            </div> -->
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

    <refund-modal
        ref="refund_modal"
        :bidId="bidId"
        :paymentMethod="paymentMethod"
    />
    <!-- :walletBalance="walletholder.walletBalance" -->
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

import RefundModal from "@template1/vendor/components/modules/credit/RefundModal.vue";

import DisputeStore from "@templateCore/store/modules/disputes/DisputeStore.ts";
import DisputedRefundBidHolder from "@templateCore/object/DisputedRefundBidHolder";

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
        RefundModal,
        DisputeStore,
        DisputedRefundBidHolder,
    },
    layout: PsFrontendLayout,
    props: ["query"],
    setup(props) {
        // Providers
        const userStore = useUserStore();

        // Init Variables
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        /**************feb 14********* */
        const appInfoStore = usePsAppInfoStoreState();
        const ps_warning_dialog = ref();
        const appInfoParameterHolder = new AppInfoParameterHolder();
        appInfoParameterHolder.userId = loginUserId;
        const psmodal = ref();
        const bidId = ref();
        bidId.value = props.query.bid_id;

        const refund_modal = ref();
        const paymentMethod = ref("");

        const psloading = ref();
        const amount = ref("");

        const holder = reactive(new ProfileUpdateViewHolder());
        const bidholder = reactive(new DisputedRefundBidHolder());

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

        const bidInfo = ref(null);
        const userDisputeStore = DisputeStore();

        const showRefundInitiation = ref(false);

        async function openModal() {
            psmodal.value.toggle(true);
            //  await loadUserData();
        }

        async function loadBidDetails() {
            let data = { bid_id: props.query.bid_id };

            const result = await userDisputeStore.loadBidbyId(
                loginUserId,
                data
            );

            const bidInfo = result.data;
            bidholder.buyerId = bidInfo.buyerId;
            if (bidInfo.buyerId == loginUserId) {
                showRefundInitiation.value = true;
            }
            if (bidInfo.sellerId == loginUserId) {
                showRefundInitiation.value = false;
            }
            bidholder.sellerId = bidInfo.sellerId;
            bidholder.bidId = bidInfo.bidId;
            bidholder.productTitle = bidInfo.productTitle;
            bidholder.dispute_refund = bidInfo.dispute_refund;
            bidholder.productPrice = bidInfo.productPrice;
            bidholder.bidPrice = bidInfo.bidPrice;
            // bidholder.dispute_refund = bidInfo.dispute_refund;
            bidholder.dispute_reason = bidInfo.dispute_reason;
            bidholder.dispute_status = bidInfo.dispute_status;
            bidholder.dispute_status_notes = bidInfo.dispute_status_notes;
            bidholder.trackRefund = bidInfo.trackRefund;
            bidholder.paymentType = bidInfo.paymentType;

            paymentMethod.value = bidInfo?.paymentType
                ? bidInfo.paymentType
                : "wallet";
        }

        // Functions
        onMounted(async () => {
            //  loadUserData();
            // loadAppVerifier();
            loadBidDetails();
        });

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

        function initiateRefund() {
            console.log("initiate refund");
            refund_modal.value.openModal();
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
            refund_modal,
            psloading,
            holder,
            bidholder,
            input_email,
            bidInfo,
            initiateRefund,
            bidId,
            showRefundInitiation,
            paymentMethod,
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
                    label: trans("dispute_details"),
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

.flex.justify-center.font-bold.text-xl.underline.mb-7 {
    margin-bottom: 0px;
    text-decoration: none;
}
.flex.justify-center.font-bold.text-xl.underline.mb-7 p {
    color: #01bc61 !important;
}
.table-display td:nth-child(1) {
    width: 30%;
}
.table-display tr.text-center {
    border-bottom: 1px solid #ccc;
}
.table-display td {
    padding: 10px;
}
td.initiate-button {
    justify-content: center;
    display: flex;
}
td.initiate-button {
    justify-content: center;
    display: flex;
}
td.initiate-button button {
    margin-left: 5px;
}
</style>
