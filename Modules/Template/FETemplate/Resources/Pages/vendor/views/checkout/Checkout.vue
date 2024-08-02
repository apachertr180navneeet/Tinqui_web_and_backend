<template>

    <Head :title="$t('checkout_page')" />
    <div class="flex flex-wrap sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div class="md:w-5/12 lg:w-5/12 sm:w-5/12 mx-auto">
            <div class="border border-gray-200 shadow-md">
                <div class="border border-gray-200">
                    <h5 class="font-bold py-3 px-4 dark:text-white">
                        {{ $t("pay_with_text") }}
                    </h5>
                </div>
                <div class="border border-gray-200 py-3 px-4">
                    <input type="radio" name="payment_method" id="payment_method" value="wallet"
                        v-model="selectedPaymentMethod" checked /><span class="ms-2 dark:text-white">{{ $t("pay_with_wallet") }}</span>
                </div>
                <div class="border border-gray-200 py-3 px-4">
                    <input type="radio" name="payment_method" id="payment_method" value="stripe"
                        v-model="selectedPaymentMethod" /><span class="ms-2 dark:text-white">{{ $t('original_method') }}</span>
                </div>
            </div>
            <div class="border border-gray-200 my-3 py-3 px-4 shadow-md">
                <h5 class="font-bold dark:text-white">{{ $t("shipping_add_text") }}</h5>
                <textarea rows="4" class="w-full border border-grey-300" placeholder="Enter shipping address">
                </textarea>
            </div>
            <!-- <div class="border border-gray-200 shadow-md">

            </div> -->
        </div>
        <div class="md:w-4/12 lg:w-4/12 sm:w-4/12 mx-auto">
            <div class="border border-gra y-200 px-4 py-3 shadow-md ">
                <table class="w-full dark:text-white">
                    <tbody>
                        <tr>
                            <td class="dark:text-white">
                                {{ $t("core_fe__search_item") }} ({{
                                    quantity
                                }})
                            </td>
                            <td class="text-end dark:text-white">Fr. {{ base_amount }}</td>
                        </tr>
                        <!-- <tr>
                            <td>Shipping</td>
                            <td class="text-end">Free</td>
                        </tr> -->
                        <tr>
                            <td class="dark:text-white">{{ $t("platform_fee_text") }}*</td>
                            <td class="text-end dark:text-white">{{ platform_fee }}</td>
                        </tr>
                    </tbody>
                </table>
                <hr class="my-3" />
                <div>
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td class="font-bold dark:text-white">
                                    {{ $t("package__total_post") }}
                                </td>
                                <td class="font-bold text-end dark:text-white">
                                    Fr. {{ total_amount }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button @click.prevent="buyNow"
                        class="rounded-lg my-4 w-full bg-green-400 hover:bg-green-500 border border-green-500 py-3 text-white font-semibold">
                        {{ $t("pay_now_button") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <ps-payment-error ref="ps_payment_error" />
    <ps-message-dialog ref="ps_message_dialog" />
    <ps-loading-dialog ref="psloading" :isClickOut="false" />
    <stripe-payment-modal ref="stripe_payment_modal" />
    <ps-error-dialog ref="ps_error_dialog" />
    <ps-success-dialog ref="ps_success_dialog" />
</template>

<script>
import { onMounted, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import PsLoadingDialog from "@template1/vendor/components/core/dialogs/PsLoadingDialog.vue";
import { router } from "@inertiajs/vue3";
import PsConst from "@templateCore/object/constant/ps_constants";
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import PsUtils from "@templateCore/utils/PsUtils";
import PsMessageDialog from "@template1/vendor/components/core/dialog/PsMessageDialog.vue";
import PsPaymentError from "@template1/vendor/components/core/dialog/PsPaymentError.vue";
import { trans } from "laravel-vue-i18n";
import MarkSoldOutItemParameterHolder from "@templateCore/object/holder/MarkSoldOutItemParameterHolder";
import PsStatus from "@templateCore/api/common/PsStatus";
import StripePaymentModal from "@template1/vendor/components/modules/credit/StripePaymentModal.vue";

import PsErrorDialog from "@template1/vendor/components/core/dialogs/PsErrorDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialogs/PsSuccessDialog.vue";

export default {
    name: "Checkout",
    layout: PsFrontendLayout,
    components: {
        Head,
        PsPaymentError,
        PsMessageDialog,
        StripePaymentModal,
        PsLoadingDialog,
        PsStatus,
        PsErrorDialog,
        PsSuccessDialog,
    },
    props: ["query"],
    setup(props) {
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }
        const item = ref({});
        const quantity = ref(1);
        const platform_fee = ref(0);
        const total_amount = ref(0);
        const base_amount = ref(0);
        const selectedPaymentMethod = ref("wallet");
        const stripe_payment_modal = ref();
        const user = ref({});
        const userStore = useUserStore();
        const offerProvider = useOfferStoreState();
        const ps_message_dialog = ref();
        const ps_payment_error = ref();
        const ps_loading_dialog = ref();
        const ps_error_dialog = ref();
        const ps_success_dialog = ref();
        const psloading = ref();
        const markAsSoldHolder =
            new MarkSoldOutItemParameterHolder().markSoldOutItemHolder();

        onMounted(async () => {
            const productStore = useProductStore();
            await productStore.loadItem(props.query.item_id, loginUserId);
            item.value = productStore.item.data;
            if (item.value.productRelation.length > 0) {
                item.value.productRelation.map(relation => {
                    if (relation.coreKeysId === "ps-itm00003" && relation.selectedValue[0].value.toLowerCase() === "fixed price") {
                        base_amount.value = item.value.price;
                        total_amount.value =
                            parseFloat(base_amount.value) + parseFloat(platform_fee.value);
                    } else {
                        base_amount.value = item.value.highestBidPrice;
                        total_amount.value =
                            parseFloat(base_amount.value) + parseFloat(platform_fee.value);
                    }
                })
            }
            await userStore.loadUser(loginUserId);
            user.value = userStore.user.data;

            // console.log("user data:\n", user, "\nitem data\n", item)
        });

        async function paymentClicked() {
            const currentDate = new Date().getTime();
            let amountStr = total_amount.value;
            console.log(amountStr);
            const startDateTimestampStr =
                PsUtils.getTimeStampDividedByOneThousand(currentDate);
            console.log("stripe");
            stripe_payment_modal.value.openModal(
                () => {
                    const payment = PsConst.PAYMENT_STRIPE_METHOD.toString();
                    doPayment(payment, amountStr, startDateTimestampStr);
                },
                async () => {
                    //", false);
                    //PsUtils.log("Cancel");
                }
            );

            // doPayment(payment, parseFloat(amountStr), startDateTimestampStr);
        }

        async function doPayment(payment, amount, startDateTimestampStr) {
            console.log("payment");
            psloading.value.openModal();
            let data = {};
            data.seller_user_id = item.value.addedUserId;
            data.recharge_timestamp = startDateTimestampStr;
            data.product_id = item.value.id;
            data.product_title = item.value.title;
            data.product_price = item.value.price;
            data.bid_price = amount;
            data.payment_method_nonce = localStorage.paymentNonce || "";

            const paymentstatus = await offerProvider.buyitNowStripe(
                data,
                loginUserId
            );
            console.log("stripe response", paymentstatus);

            //psmodal.value.toggle(false);
            if (paymentstatus.status == PsStatus.ERROR) {
                psloading.value.closeModal();
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__payment_error"),
                    trans("core__be_btn_ok")
                );
            } else {
                psloading.value.closeModal();
                //  ps_message_dialog.value.openModal(
                //             trans("item_buy_title"),
                //             trans("item_buy_message"),
                //             trans("core_fe__ok")
                //         );
                ps_success_dialog.value.openModal(
                    trans("item_buy_title"),
                    trans("item_buy_message"),
                    trans("core__be_btn_ok"),
                    () => {
                        location.href = "/";
                    }
                );
                // showSuccessDialog(rechargestatus.message);
                //emit("isRechargeSuccessful", true);
                /// PsUtils.log("Cancel");
            }
        }

        async function buyNow() {
            console.log("selectedPaymentMethod", selectedPaymentMethod.value);
            if (selectedPaymentMethod.value == "wallet") {
                const currentDate = new Date().getTime();
                const DateTimestampStr =
                    PsUtils.getTimeStampDividedByOneThousand(currentDate);
                let walletData = await userStore.loadUserWallet(loginUserId);
                if (
                    parseFloat(walletData.data.walletBalance) >
                    parseFloat(item.value.price)
                ) {
                    let data = {};
                    data.seller_user_id = item.value.addedUserId;
                    data.recharge_timestamp = DateTimestampStr;
                    data.product_id = item.value.id;
                    data.product_title = item.value.title;
                    data.product_price = item.value.price;
                    data.bid_price = parseFloat(total_amount.value);

                    const response = await offerProvider.BuyItNow(
                        data,
                        loginUserId
                    );

                    console.log("wallet response", response);

                    if (response.status == PsStatus.ERROR) {
                        ps_error_dialog.value.openModal(
                            trans("ps_error_dialog__payment_error"),
                            trans("core_fe__ok")
                        );
                    } else {
                        ps_success_dialog.value.openModal(
                            trans("item_buy_title"),
                            trans("item_buy_message"),
                            trans("core_fe__ok"),
                            () => {
                                location.href = "/";
                            }
                        );
                    }

                    // router.get(route("dashboard"))
                } else {
                    ps_payment_error.value.openModal();
                }
            }
            if (selectedPaymentMethod.value == "stripe") {
                console.log("stripe");
                paymentClicked();
            }
        }

        return {
            item,
            quantity,
            platform_fee,
            total_amount,
            buyNow,
            ps_payment_error,
            ps_message_dialog,
            StripePaymentModal,
            paymentClicked,
            selectedPaymentMethod,
            stripe_payment_modal,
            psloading,
            ps_loading_dialog,
            ps_error_dialog,
            ps_success_dialog,
            base_amount
        };
    },
};
</script>
