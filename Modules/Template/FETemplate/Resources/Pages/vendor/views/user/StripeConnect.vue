<template>
    <Head :title="$t('stripe_connect_account')" />
    <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div
            class="grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-10 word-wrap"
        >
            <div class="col-start-0 col-span-4 sm:col-span-2 lg:col-span-3">
                <ps-label class="text-xl sm:text-3xl font-medium mb-5">
                    {{ $t("stripe_connect_connect") }}</ps-label
                >
                <div class=" ">
                    <div
                        class="flex flex-row rtl:space-x-reverse space-x-2 sm:space-x-0 space-y-0 sm:space-y-2 sm:flex-col"
                    >
                        <ps-button
                            class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500"
                            rounded="rounded"
                            @click="switchViews('connect')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("stripe_connect_details")
                            }}</span>
                        </ps-button>
                        <ps-button
                            class="w-full"
                            @click="switchViews('account')"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500"
                            rounded="rounded"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("stripe_connect_ac_management")
                            }}</span>
                        </ps-button>

                        <ps-button
                            class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500"
                            rounded="rounded"
                            @click="switchViews('payments')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("stripe_connect_payments_dashboard")
                            }}</span>
                        </ps-button>

                        <ps-button
                            class="w-full"
                            colors="bg-feAchromatic-50 dark:bg-feAchromatic-800 dark:text-feAchromatic-200 hover:text-feAchromatic-50"
                            border="border border-feAchromatic-300 dark:border-feAchromatic-500"
                            rounded="rounded"
                            @click="switchViews('payouts')"
                        >
                            <span class="me-2 md:me-4">{{
                                $t("stripe_connect_payouts_dashboard")
                            }}</span>
                        </ps-button>
                    </div>
                </div>
            </div>
            <div class="col-span-4 sm:col-span-6 lg:col-span-9">
                <div
                    class="flex flex-col mb-16 mt-7"
                    v-if="viewFocus === 'connect'"
                >
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div
                                class="w-full relative mb-4 rounded-md cursor-pointer h-80"
                            >
                                <div
                                    class="relative overflow-x-auto my-3 shadow-md sm:rounded-lg"
                                >
                                    <ps-label
                                        class="text-sm sm:text-xl font-medium"
                                    >
                                        {{
                                            $t("stripe_connect_details")
                                        }}</ps-label
                                    >
                                    <div
                                        class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                        style="background-color: #e7f5e7"
                                    >
                                        <div class="justify-center">
                                            <p
                                                class="font-bold text-xl underline mb-7"
                                            >
                                                {{
                                                    $t(
                                                        "stripe_connect_partners"
                                                    )
                                                }}
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
                                                            "stripe_connect_features"
                                                        )
                                                    }}
                                                    <a
                                                        target="__blank"
                                                        href="https://stripe.com/in/connect/features"
                                                        >https://stripe.com/in/connect/features</a
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div
                                        class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                    >
                                        <div class="justify-center">
                                            <table
                                                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                                            >
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                                >
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 text-center"
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_id"
                                                                )
                                                            }}
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 text-center"
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_charges"
                                                                )
                                                            }}
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 text-center"
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_transfers"
                                                                )
                                                            }}
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 text-center"
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_payouts"
                                                                )
                                                            }}
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 text-center"
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_onboarding"
                                                                )
                                                            }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                                                    >
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                        >
                                                            {{ accountId }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-if="
                                                                chargesEnabled ==
                                                                1
                                                            "
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_enabled"
                                                                )
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-else
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_not_enabled"
                                                                )
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-if="
                                                                transfersEnabled ==
                                                                1
                                                            "
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_enabled"
                                                                )
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-else
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_not_enabled"
                                                                )
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-if="
                                                                payoutsEnabled ==
                                                                1
                                                            "
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_enabled"
                                                                )
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-else
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_not_enabled"
                                                                )
                                                            }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-if="
                                                                onboardingStatus ==
                                                                0
                                                            "
                                                        >
                                                            <!-- {{
                                                                $t(
                                                                    "stripe_connect_onboarding_not_done"
                                                                )
                                                            }} -->
                                                            <ps-button
                                                                class="lg:mt-5 mt-4 mb-5 text-center w-1/2"
                                                                textSize="lg:text-sm sm:text-xs text-xs"
                                                                theme="bg-fePrimary-500 dark:bg-feAccent-500 text-feAchromatic-50 dark:text-feAchromatic-900 py-1"
                                                                @click="
                                                                    onboardUser()
                                                                "
                                                            >
                                                                {{
                                                                    $t(
                                                                        "stripe_connect_finish_onboarding"
                                                                    )
                                                                }}
                                                            </ps-button>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 justify-center items-center text-center"
                                                            v-else-if="
                                                                onboardingStatus ==
                                                                1
                                                            "
                                                        >
                                                            {{
                                                                $t(
                                                                    "stripe_connect_onboarding_done"
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
                    </div>
                </div>

                <div
                    class="flex flex-col mb-16 mt-7"
                    v-if="viewFocus === 'account'"
                >
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div
                                class="w-full relative mb-4 rounded-md cursor-pointer h-80"
                            >
                                <div
                                    class="w-full relative overflow-x-auto shadow-md sm:rounded-lg"
                                >
                                    <ps-label
                                        class="text-sm sm:text-xl font-medium"
                                        >{{
                                            $t("stripe_connect_ac_management")
                                        }}</ps-label
                                    >
                                    <div
                                        class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                    >
                                        <div
                                            class="justify-center account_management"
                                            ref="account_management"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col mb-16 mt-7"
                    v-if="viewFocus === 'payments'"
                >
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div
                                class="w-full relative mb-4 rounded-md cursor-pointer h-80"
                            >
                                <div
                                    class="w-full relative overflow-x-auto shadow-md sm:rounded-lg"
                                >
                                    <ps-label
                                        class="text-sm sm:text-xl font-medium"
                                        >{{
                                            $t("stripe_connect_payments_dash")
                                        }}</ps-label
                                    >

                                    <div
                                        class="payment_element"
                                        style="overflow-y: scroll"
                                        ref="payment_element"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col mb-16 mt-7"
                    v-if="viewFocus === 'payouts'"
                >
                    <div class="flex flex-row">
                        <div class="flex flex-wrap m-auto w-full">
                            <div
                                class="w-full relative mb-4 rounded-md cursor-pointer h-80"
                            >
                                <div
                                    class="w-full relative overflow-x-auto shadow-md sm:rounded-lg"
                                >
                                    <ps-label
                                        class="text-sm sm:text-xl font-medium"
                                        >{{
                                            $t(
                                                "stripe_connect_payouts_dashboard"
                                            )
                                        }}</ps-label
                                    >

                                    <div
                                        class="payout_element"
                                        style="overflow-y: scroll"
                                        ref="payout_element"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ps-loading-dialog ref="ps_loading_dialog" />

    <user-phone-login-verification-modal
        ref="user_phone_login_verification_modal"
    />

    <ps-error-dialog ref="ps_error_dialog" />
    <ps-warning-dialog-2 ref="ps_warning_dialog" />
    <ps-loading-dialog ref="psloading" :isClickOut="false" />
    <ps-success-dialog ref="ps_success_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
// Libs
import { onMounted, reactive, ref, onBeforeUnmount } from "vue";

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

import { loadConnectAndInitialize } from "@stripe/connect-js";

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

        const payment_element = ref<HTMLElement | null>(null);
        const payout_element = ref<HTMLElement | null>(null);
        const account_management = ref<HTMLElement | null>(null);
        const onboardingStatus = ref();
        const transfersEnabled = ref();
        const payoutsEnabled = ref();
        const chargesEnabled = ref();
        const accountId = ref();
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

        const psloading = ref();

        const provider = useWalletRechargeState();

        const holder = reactive(new ProfileUpdateViewHolder());

        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }

        const date = new Date();
        date.setFullYear(date.getFullYear() - 18);
        const pickedDate = ref();
        const upperDate = ref(date);
        const ps_loading_dialog = ref();
        const ps_error_dialog = ref();
        const ps_success_dialog = ref();
        let oldUser;
        const stripeConnectInstance = ref();

        let form = useForm({
            product_relation: {},
        });
        let product_relation_errors = ref({});

        const viewFocus = ref("connect");
        const stripeLanguage = ref("");

        async function loadStripe() {
            const stripeConnectData = await userStore.loadUserStripeConnect(
                loginUserId
            );
            accountId.value = stripeConnectData.data.accountId;
            onboardingStatus.value = stripeConnectData.data.onboardingStatus;
            chargesEnabled.value = stripeConnectData.data.chargesEnabled;
            transfersEnabled.value = stripeConnectData.data.transfersEnabled;
            payoutsEnabled.value = stripeConnectData.data.payoutsEnabled;
        }
        async function loadStripeConnectDetails(type) {
            const info = await appInfoStore.loadAppInfo(appInfoParameterHolder);

            const fetchClientSecret = async () => {
                const stripeConnectData = await userStore.loadUserStripeConnect(
                    loginUserId
                );

                //console.log(stripeConnectData);
                return stripeConnectData.data.clientSecret;
            };

            const stripeConnectInstance = loadConnectAndInitialize({
                publishableKey: info.data.stripePublishableKey,
                fetchClientSecret: fetchClientSecret,
                appearance: {
                    variables: {
                        colorPrimary: "rgb(2 188 98)",
                    },
                },
                locale: stripeLanguage.value,
            });

            if (type === "account") {
                if (onboardingStatus.value == 0) {
                    ps_error_dialog.value.openModal(
                        trans("ps_error_dialog__error"),
                        trans("account_onboarding_process_incomplete"),
                        trans("edit_profile__ok"),
                        () => {
                            viewFocus.value = "connect";
                        }
                    );
                    return false;
                } else {
                    const accountComponent =
                        stripeConnectInstance.create("account-management");
                    // console.log("accountComponent", accountComponent);
                    if (account_management.value) {
                        account_management.value.appendChild(accountComponent);
                    }
                }
            }
            if (type === "payments") {
                if (onboardingStatus.value == 0) {
                    ps_error_dialog.value.openModal(
                        trans("ps_error_dialog__error"),
                        trans("account_onboarding_process_incomplete"),
                        trans("edit_profile__ok"),
                        () => {
                            viewFocus.value = "connect";
                        }
                    );
                    return false;
                } else {
                    const paymentComponent =
                        stripeConnectInstance.create("payments");

                    if (payment_element.value) {
                        payment_element.value.appendChild(paymentComponent);
                    }
                }
            }
            if (type === "payouts") {
                if (onboardingStatus.value == 0) {
                    ps_error_dialog.value.openModal(
                        trans("ps_error_dialog__error"),
                        trans("account_onboarding_process_incomplete"),
                        trans("edit_profile__ok"),
                        () => {
                            viewFocus.value = "connect";
                        }
                    );
                    return false;
                } else {
                    const payoutsComponent =
                        stripeConnectInstance.create("payouts");

                    if (payout_element.value) {
                        payout_element.value.appendChild(payoutsComponent);
                    }
                }
            }
        }
        // Functions

        async function onboardUser() {
            const connectResult = await userStore.getOnboardUrl(loginUserId);
            //console.log(connectResult.url);
            if (connectResult.status == PsStatus.ERROR) {
                ps_error_dialog.value.openModal(
                    "Error while making the request",
                    ""
                );
            } else {
                const onboardUrl = connectResult.data.url;
                window.location.href = onboardUrl;
                // const width = 800;
                // const height = 600;
                // const left = (screen.width - width) / 2;
                // const top = (screen.height - height) / 2;

                // window.open(
                //     onboardUrl,
                //     "Onboarding",
                //     `width=${width},height=${height},top=${top},left=${left}`
                // );
            }
        }

        function switchViews(view) {
            if (view == "connect") {
                viewFocus.value = "connect";
            } else if (view == "account") {
                loadStripeConnectDetails("account");
                viewFocus.value = "account";
            } else if (view == "payments") {
                loadStripeConnectDetails("payments");
                viewFocus.value = "payments";
            } else if (view == "payouts") {
                loadStripeConnectDetails("payouts");
                viewFocus.value = "payouts";
            }
            //  console.log(viewFocus);
            ps_loading_dialog.value = true;

            ps_loading_dialog.value = false;
        }

        onMounted(async () => {
            loadStripe();

            if (localStorage.activeLanguage == "en") {
                stripeLanguage.value = "en-US";
            }
            if (localStorage.activeLanguage == "fr") {
                stripeLanguage.value = "fr-FR";
            }
            if (localStorage.activeLanguage == "de") {
                stripeLanguage.value = "de-DE";
            }
            if (localStorage.activeLanguage == "it") {
                stripeLanguage.value = "it-IT";
            }
            // loadStripeConnectPayments();
            // loadAppVerifier();
        });
        // onBeforeUnmount(() => {
        //     if (stripeConnectInstance) {
        //         stripeConnectInstance.logout();
        //     }
        // });

        return {
            switchViews,
            appInfoStore,
            userStore,
            pickedDate,
            ps_loading_dialog,
            ps_error_dialog,
            ps_success_dialog,
            upperDate,
            form,
            product_relation_errors,
            ps_warning_dialog,
            psmodal,
            psloading,
            holder,
            payment_element,
            payout_element,
            account_management,
            onboardingStatus,
            viewFocus,
            transfersEnabled,
            chargesEnabled,
            payoutsEnabled,
            accountId,
            onboardUser,
            stripeLanguage,
        };
    },
    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("ps_nav_bar__home"),
                    url: route("dashboard"),
                },
                {
                    label: trans("stripe_connect_account"),
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

.justify-center.payment_element {
    max-height: 279px;
    overflow-y: scroll;
}

.justify-center.account_management {
    max-height: 279px;
    overflow-y: scroll;
}

.payment_element::-webkit-scrollbar {
    width: 5px; /* Set scrollbar width */
    height: 5px; /* Set scrollbar height */
}

.payment_element::-webkit-scrollbar-track {
    background: #f1f1f1; /* Track color */
}

.payment_element::-webkit-scrollbar-thumb {
    background: #888; /* Thumb color */
    border-radius: 6px; /* Round corners */
}

.payment_element::-webkit-scrollbar-thumb:hover {
    background: #555; /* Thumb hover color */
}

.account_management::-webkit-scrollbar {
    width: 5px; /* Set scrollbar width */
    height: 5px; /* Set scrollbar height */
}

.account_management::-webkit-scrollbar-track {
    background: #f1f1f1; /* Track color */
}

.account_management::-webkit-scrollbar-thumb {
    background: #888; /* Thumb color */
    border-radius: 6px; /* Round corners */
}

.account_management::-webkit-scrollbar-thumb:hover {
    background: #555; /* Thumb hover color */
}
</style>
