<template>
    <Head :title="$t('profile__user_wallet')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <div class="w-full mb-6">
                    <!-- <ps-breadcrumb-2 :items="breadcrumb" class="" /> -->
                    <ps-breadcrumb-2 :items="breadcrumb"></ps-breadcrumb-2>
                </div>
    
                <div class="flex flex-wrap m-auto success-message">
                    <div
                        class="wallet-outer border border-gray-300 rounded-2xl shadow-xl md:w-1/2 lg:w-1/2 h-full grid py-7">
                        <p class="font-semibold text-2xl">
                            Recharge Failed!
                        </p>
                        <div class="flex items-center justify-center my-5">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="300" height="300"
                                viewBox="0 0 24 24" style="fill: #ff0800;">
                                <path
                                    d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 8.7070312 7.2929688 L 7.2929688 8.7070312 L 10.585938 12 L 7.2929688 15.292969 L 8.7070312 16.707031 L 12 13.414062 L 15.292969 16.707031 L 16.707031 15.292969 L 13.414062 12 L 16.707031 8.7070312 L 15.292969 7.2929688 L 12 10.585938 L 8.7070312 7.2929688 z">
                                </path>
                            </svg>
                        </div>
                        <div class="w-full flex flex-wrap m-auto justify-center">
                            <button
                                class="rounded text-feError-500 py-2 px-4 border-2 border-feError-500 shadow-none text-sm hover:outline-none  
                                hover:bg-feError-500 hover:text-white active:bg-feError-700 focus:outline-none  focus:ring focus:ring-feError-300 cursor-pointer opacity-100 flex justify-center items-center font-medium transition duration-150 ease-in-out align-center text-center font-semibold py-3 text-lg mb-2 md:w-1/2 lg:w-1/2 sm:w-1/2"
                                @click="redirectToAnotherPage">
                                Try Again Later
                            </button>
                        </div>
                    </div>
    
                    <hr />
                </div>
            </div>
        </template>
    </ps-content-container>
</template>
<script lang="ts">
import { Head } from "@inertiajs/vue3";
// Libs
import { onMounted, reactive, ref } from "vue";

import axios from "axios";
// import router from '@template1/router';
import PsDropdown from "@template1/vendor/components/core/dropdown/PsDropdown.vue";
import PsDropdownSelect from "@template1/vendor/components/core/dropdown/PsDropdownSelect.vue";
// Providers
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
// import { createUserStateListProviderState } from '@templateCore/store/modules/user/UserStateProvider';

// Components
import PsModal from "@template1/vendor/components/core/modals/PsModal.vue";
import PsInputWithRightIcon from "@template1/vendor/components/core/input/PsInputWithRightIcon.vue";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsTextarea from "@template1/vendor/components/core/textarea/PsTextarea.vue";

import StripePaymentModal from "@template1/vendor/components/modules/credit/StripePaymentModal.vue";
import PaypalPaymentModal from "@template1/vendor/components/modules/credit/PaypalPaymentModal.vue";
import OfflinePaymentModal from "@template1/vendor/components/modules/credit/OfflinePaymentModal.vue";
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
import PsUtils from "@templateCore/utils/PsUtils";
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

// import BidDetailsHistory from "@templateCore/object/BidDetailsHistory";
import WithdrawAmountModal from "@template1/vendor/components/modules/debit/WithdrawAmountModal.vue";

import PaystackPop from "@paystack/inline-js";
//ends here //
export default {
  name: "User Wallet",
  components: {
    PsModal,
    PsContentContainer,
    PsButton,
    PsLabelHeader4,
    PsIcon,
    PsInput,
    PsTextarea,
    PsCheckboxValue,
    PsLabelTitle3,
    StripePaymentModal,
    PaypalPaymentModal,
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
    function redirectToAnotherPage() {
      if (window.opener && !window.opener.closed) {
        window.opener.location.reload();
      }

      window.close();
    }
    return {
      redirectToAnotherPage,
      // offline_payment_modal,
      // ps_warning_dialog,
    };
  },
  computed: {
    breadcrumb() {
      return [
        {
          label: "Wallet",
          url: route("fe_wallet"),
        },
        {
          label: "Recharge Failed",
          color: "text-fePrimary-500",
        },
      ];
    },
  },
};
</script>

<style scoped>
.success-message {
    text-align: center;
}

.tick-mark-icon {
    width: 200px;
    height: 200px;
    display: block;
    margin: 0 auto;
}
</style>
