<template>
    <Head :title="$t('profile__user_wallet')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <div class="w-full mb-6">
                    <!-- <ps-breadcrumb-2 :items="breadcrumb" class="" /> -->
                    <ps-breadcrumb-2 :items="breadcrumb"></ps-breadcrumb-2>
                </div>

                <div class="flex flex-wrap m-auto">
                    <div class="md:w-1/2 sm:w-full lg:w-1/2 m-auto">
                        <div
                            class="wallet-outer border border-gray-300 rounded-lg shadow-lg md:w-11/12 lg:w-11/12 h-full"
                        >
                            <div
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                v-if="walletView === 'default'"
                            >
                                <div
                                    class="flex justify-center font-bold text-3xl mb-5 underline"
                                >
                                    <p>{{ $t("tinqui_wallet") }}</p>
                                </div>
                                <div
                                    class="text-center w-full mt-5 sm:mt-5 gap-3"
                                >
                                    <input
                                        class="text-center w-full text-feSecondary-800 dark:text-feSecondary-300 text-base border-0"
                                        type="text"
                                        id="available_balance"
                                        readonly
                                        :value="
                                            'Fr.' +
                                            (walletholder.walletBalance !==
                                            undefined
                                                ? walletholder.walletBalance
                                                : 0.0)
                                        "
                                    />

                                    <p
                                        class="wallet-balance text-feSecondary-800 dark:text-feSecondary-300 text-base my-2"
                                    >
                                        {{ $t("available_wallet_balance") }}
                                    </p>
                                </div>
                                <hr class="border-b-2 my-7" />
                                <div class="my-5">
                                    <div
                                        class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md cursor-pointer"
                                        @click="changeView('recharge')"
                                    >
                                        <div class="flex flex-wrap m-auto">
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2"
                                            >
                                                <p
                                                    class="font-semibold flex justify-between"
                                                >
                                                    {{ $t("recharge") }}
                                                </p>
                                                <p class="text-sm">
                                                    {{ $t("recharge_wallet") }}
                                                </p>
                                            </div>
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2 text-end"
                                            >
                                                <span class="text-3xl"
                                                    >&rarr;</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div
                                        class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md cursor-pointer"
                                        @click="changeView('stripeconnect')"
                                    >
                                        <div class="flex flex-wrap m-auto">
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2"
                                            >
                                                <p
                                                    class="font-semibold flex justify-between"
                                                >
                                                    {{
                                                        $t(
                                                            "stripe_connect_account"
                                                        )
                                                    }}
                                                </p>
                                                <p class="text-sm">
                                                    {{
                                                        $t("payments_dashboard")
                                                    }}
                                                </p>
                                            </div>
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2 text-end"
                                            >
                                                <span class="text-3xl"
                                                    >&rarr;</span
                                                >
                                            </div>
                                        </div>
                                    </div> -->
                                    <ps-route-link
                                        :to="{
                                            name: 'fe_wallet_withdrawal',
                                        }"
                                    >
                                        <div
                                            class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md cursor-pointer"
                                            style="color: #000 !important"
                                        >
                                            <div class="flex flex-wrap m-auto">
                                                <div
                                                    class="md:w-1/2 sm:w-full lg:w-1/2"
                                                >
                                                    <p
                                                        class="font-semibold flex justify-between"
                                                    >
                                                        {{
                                                            $t(
                                                                "withdraw_amount"
                                                            )
                                                        }}
                                                    </p>
                                                    <p class="text-sm">
                                                        {{
                                                            $t(
                                                                "withdraw_wallet"
                                                            )
                                                        }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="md:w-1/2 sm:w-full lg:w-1/2 text-end"
                                                >
                                                    <span class="text-3xl"
                                                        >&rarr;</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </ps-route-link>

                                    <div
                                        class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md cursor-pointer"
                                        @click="changeView('onHold')"
                                    >
                                        <div class="flex flex-wrap m-auto">
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2"
                                            >
                                                <p
                                                    class="font-semibold flex justify-between"
                                                >
                                                    {{ $t("onhold_wallet") }}
                                                </p>
                                                <p class="text-sm">
                                                    {{
                                                        $t(
                                                            "check_onhold_wallet"
                                                        )
                                                    }}.
                                                </p>
                                            </div>
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2 text-end"
                                            >
                                                <span class="text-3xl"
                                                    >&rarr;</span
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md cursor-pointer"
                                        @click="changeView('walletHistory')"
                                    >
                                        <div class="flex flex-wrap m-auto">
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2"
                                            >
                                                <p
                                                    class="font-semibold flex justify-between"
                                                >
                                                    {{
                                                        $t(
                                                            "wallet_transactions"
                                                        )
                                                    }}
                                                </p>
                                                <p class="text-sm">
                                                    {{
                                                        $t(
                                                            "check_wallet_transactions"
                                                        )
                                                    }}.
                                                </p>
                                            </div>
                                            <div
                                                class="md:w-1/2 sm:w-full lg:w-1/2 text-end"
                                            >
                                                <span class="text-3xl"
                                                    >&rarr;</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                v-else-if="walletView === 'stripeconnect'"
                            >
                                <button
                                    class="text-start font-semibold text-lg mb-2"
                                    @click="changeView('default')"
                                >
                                    &larr; {{ $t("core_fe__back") }}
                                </button>
                                <div class="flex mb-5"> 
                                    <p
                                        class="underline font-bold text-xl m-auto"
                                    >
                                        {{
                                            $t(
                                                "stripe_connect_payments_dashboard"
                                            )
                                        }}
                                    </p>
                                </div>

                                <div class="my-5">
                                    <div
                                        class="payment-btns flex gap-2 flex-row flex-wrap justify-between"
                                    >
                                        <iframe
                                            v-if="payment_element"
                                            :src="payment_element"
                                            frameborder="0"
                                            width="100%"
                                            height="600px"
                                        ></iframe>
                                       <div v-html="payment_element"></div>
                                        <div id="error" hidden>
                                            Something went wrong!
                                        </div> 
                                    </div>
                                    <br />
                                    <br />
                                </div>
                            </div> -->
                            <div
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                v-else-if="walletView === 'recharge'"
                            >
                                <button
                                    class="text-start font-semibold text-lg mb-2"
                                    @click="changeView('default')"
                                >
                                    &larr; {{ $t("core_fe__back") }}
                                </button>
                                <div class="flex mb-5">
                                    <p
                                        class="underline font-bold text-xl m-auto"
                                    >
                                        {{ $t("recharge") }}&nbsp;{{
                                            $t("user_wallet")
                                        }}
                                    </p>
                                </div>
                                <div
                                    class="text-center w-full mt-5 sm:mt-5 gap-3"
                                >
                                    <ps-input
                                        class="text-center w-full text-feSecondary-800 dark:text-feSecondary-300 text-base border-0"
                                        type="number"
                                        id="recharge_balance"
                                        autofocus
                                        v-model:value="amount"
                                        placeholder="Enter Amount to Recharge"
                                        :maxLength="7"
                                    />
                                    <!-- <p
                                        class="wallet-balance text-feSecondary-800 dark:text-feSecondary-300 text-base my-1"
                                    >
                                        Enter Amount To Add
                                    </p> -->
                                </div>
                                <hr class="border-b-2 my-7" />
                                <div class="my-5">
                                    <!-- Top-up buttons -->
                                    <div
                                        class="payment-btns flex gap-2 flex-row flex-wrap justify-between"
                                    >
                                        <ps-button
                                            colors="bg-feBrand-stripe text-feAchromatic-50"
                                            class="py-3"
                                            style="width: 20%"
                                            @click="fillAmount(100)"
                                        >
                                            Fr. 100
                                        </ps-button>
                                        <ps-button
                                            colors="bg-feBrand-stripe text-feAchromatic-50"
                                            class="py-3"
                                            style="width: 20%"
                                            @click="fillAmount(200)"
                                        >
                                            Fr. 200
                                        </ps-button>
                                        <ps-button
                                            colors="bg-feBrand-stripe text-feAchromatic-50"
                                            class="py-3"
                                            style="width: 20%"
                                            @click="fillAmount(500)"
                                        >
                                            Fr. 500
                                        </ps-button>
                                        <ps-button
                                            colors="bg-feBrand-stripe text-feAchromatic-50"
                                            class="py-3"
                                            style="width: 20%"
                                            @click="fillAmount(800)"
                                        >
                                            Fr. 800
                                        </ps-button>
                                    </div>
                                    <br />
                                    <br />
                                    <!-- Payment Methods -->
                                    <ps-label
                                        class="pay-with ms-8 font-medium text-sm lg:text-base mb-2"
                                    >
                                        {{ $t("promote_item_modal__pay_with") }}
                                        Stripe
                                    </ps-label>
                                    <div
                                        class="pay-with-btns flex gap-3 flex-col flex-wrap justify-center items-center"
                                    >
                                        <ps-button
                                            colors="bg-feBrand-stripe text-feAchromatic-50"
                                            v-if="
                                                appInfoStore.appInfo.data
                                                    ?.stripeEnable == '1'
                                            "
                                            class="py-3"
                                            style="width: 50%"
                                            @click="paymentClicked()"
                                            >Proceed</ps-button
                                        >
                                        <div
                                            class="mt-3"
                                            style="
                                                display: inline-flex;
                                                align-items: center;
                                            "
                                        >
                                            <span> &#128275;</span>
                                            <span
                                                class="secure-pay"
                                                style="margin-left: 5px"
                                                >{{ $t("safe_payments") }}</span
                                            >
                                        </div>
                                        <hr />
                                    </div>
                                </div>
                            </div>
                            <div
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                v-else-if="walletView === 'onHold'"
                            >
                                <button
                                    class="text-start font-semibold text-lg mb-2"
                                    @click="changeView('default')"
                                >
                                    &larr; {{ $t("core_fe__back") }}
                                </button>
                                <div class="flex mb-5">
                                    <p
                                        class="underline font-bold text-xl m-auto"
                                    >
                                        {{ $t("onhold_wallet") }}
                                    </p>
                                </div>
                                <div
                                    class="text-center w-full mt-5 sm:mt-5 gap-3"
                                >
                                    <input
                                        class="text-center w-full text-feSecondary-800 dark:text-feSecondary-300 text-base border-0"
                                        type="text"
                                        id="available_balance"
                                        readonly
                                        :value="
                                            'Fr.' + walletholder.onHoldAmount
                                        "
                                    />
                                    <p
                                        class="wallet-balance text-feSecondary-800 dark:text-feSecondary-300 text-base my-1"
                                    >
                                        {{ $t("onhold_wallet") }}&nbsp;{{
                                            $t("balance")
                                        }}
                                    </p>
                                </div>
                                <hr class="border-b-2 mt-7" />
                                <div class="my-3">
                                    <p
                                        class="underline font-semibold my-3 text-lg"
                                    >
                                        {{ $t("previous_products") }}
                                    </p>
                                    <div class="card-container">
                                        <div
                                            v-if="bidInfo"
                                            v-for="(bid, index) in bidInfo"
                                            :key="index"
                                            class="card"
                                        >
                                            <div
                                                class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md"
                                            >
                                                <table class="mt-8 w-full">
                                                    <tr>
                                                        <td
                                                            class="font-semibold w-1/2"
                                                        >
                                                            {{
                                                                $t(
                                                                    "dispute_form_drop_label"
                                                                )
                                                            }}&nbsp;{{
                                                                $t(
                                                                    "item_list__name"
                                                                )
                                                            }}:
                                                        </td>
                                                        <td class="text-end">
                                                            {{
                                                                bid.productTitle
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="font-semibold w-1/2"
                                                        >
                                                            {{
                                                                $t(
                                                                    "dispute_form_drop_label"
                                                                )
                                                            }}&nbsp;{{
                                                                $t(
                                                                    "item_entry__price"
                                                                )
                                                            }}:
                                                        </td>
                                                        <td class="text-end">
                                                            {{
                                                                bid.productPrice
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="font-semibold w-1/2"
                                                        >
                                                            {{
                                                                $t(
                                                                    "chat__make_an_offer"
                                                                )
                                                            }}&nbsp;{{
                                                                $t(
                                                                    "item_entry__price"
                                                                )
                                                            }}:
                                                        </td>
                                                        <td class="text-end">
                                                            {{ bid.bidPrice }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="font-semibold w-1/2"
                                                        >
                                                            {{
                                                                $t(
                                                                    "service_cost"
                                                                )
                                                            }}&nbsp;%:
                                                        </td>
                                                        <td class="text-end">
                                                            {{
                                                                bid.bidCommission *
                                                                100
                                                            }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="font-semibold w-1/2"
                                                        >
                                                            {{
                                                                $t(
                                                                    "package__total_post"
                                                                )
                                                            }}&nbsp;{{
                                                                $t(
                                                                    "service_cost"
                                                                )
                                                            }}:
                                                        </td>
                                                        <td class="text-end">
                                                            {{
                                                                bid.bidCommission *
                                                                bid.bidPrice
                                                            }}
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div
                                                    class="pt-4 mt-4 border-t border-gray-400 text-gray-800"
                                                >
                                                    <table class="w-full">
                                                        <tr>
                                                            <td
                                                                class="font-semibold w-1/2"
                                                            >
                                                                You will
                                                                receive:
                                                            </td>
                                                            <td
                                                                class="text-end"
                                                            >
                                                                {{
                                                                    bid.amountPaid
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr
                                                class="my-4 border-t border-gray-300"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="wallet-inner w-full flex flex-col border rounded-md border-feSecondary-400 dark:border-feAchromatic-500 py-6 sm:py-6 md:py-6 lg:py-6 px-6 sm:px-10 md:px-12 lg:px-24"
                                v-else-if="walletView === 'walletHistory'"
                            >
                                <button
                                    class="text-start font-semibold text-lg mb-2"
                                    @click="changeView('default')"
                                >
                                    &larr; {{ $t("core_fe__back") }}
                                </button>
                                <div class="flex mb-5">
                                    <p
                                        class="underline font-bold text-xl m-auto"
                                    >
                                        {{ $t("wallet_transactions") }}
                                    </p>
                                </div>

                                <div class="my-3">
                                    <div
                                        class="card-container"
                                        v-if="walletLogInfo"
                                        v-for="(
                                            transaction, index
                                        ) in walletLogInfo"
                                        :key="index"
                                    >
                                        <div
                                            class="card"
                                            v-if="
                                                transaction.log_type ==
                                                    'credit' ||
                                                transaction.log_type == 'debit'
                                            "
                                        >
                                            <div
                                                class="border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md"
                                            >
                                                <table class="mt-8 w-full">
                                                    <tr
                                                        v-if="
                                                            transaction.log_type ==
                                                            'credit'
                                                        "
                                                    >
                                                        <td
                                                            class="w-1/4 text-center"
                                                        >
                                                            <div
                                                                class="flex items-center justify-center h-10 w-24 rounded-md text-white font-semibold bg-green-500"
                                                            >
                                                                <span>{{
                                                                    convertedDate(
                                                                        transaction.createdAt
                                                                    )
                                                                }}</span>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="w-1/2 text-center"
                                                        >
                                                            <div
                                                                class="font-semibold"
                                                            >
                                                                <div>
                                                                    {{
                                                                        $t(
                                                                            "wallet_topup"
                                                                        )
                                                                    }}
                                                                </div>
                                                                <div
                                                                    class="text-sm text-gray-600 mt-1"
                                                                >
                                                                    <p>
                                                                        {{
                                                                            $t(
                                                                                "txn_id"
                                                                            )
                                                                        }}:
                                                                    </p>
                                                                    <p
                                                                        v-if="
                                                                            transaction.transactionId !=
                                                                            null
                                                                        "
                                                                    >
                                                                        {{
                                                                            transaction.transactionId
                                                                        }}
                                                                    </p>
                                                                    <p v-else>
                                                                        N/A
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="w-1/4 text-end font-semibold text-green-500"
                                                        >
                                                            +Fr.
                                                            {{
                                                                transaction.amountAdded
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        v-if="
                                                            transaction.log_type ==
                                                            'debit'
                                                        "
                                                    >
                                                        <td
                                                            class="w-1/4 text-center"
                                                        >
                                                            <div
                                                                class="flex items-center justify-center h-10 w-24 rounded-md text-white font-semibold bg-red-500"
                                                            >
                                                                <span>{{
                                                                    convertedDate(
                                                                        transaction.createdAt
                                                                    )
                                                                }}</span>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="w-1/2 text-center"
                                                        >
                                                            <div
                                                                class="font-semibold"
                                                            >
                                                                <div>
                                                                    {{
                                                                        $t(
                                                                            "wallet_withdraw"
                                                                        )
                                                                    }}
                                                                </div>
                                                                <div
                                                                    class="text-sm text-gray-600 mt-1"
                                                                >
                                                                    <p>
                                                                        {{
                                                                            $t(
                                                                                "txn_id"
                                                                            )
                                                                        }}:
                                                                    </p>
                                                                    <p
                                                                        v-if="
                                                                            transaction.transactionId !=
                                                                            null
                                                                        "
                                                                    >
                                                                        {{
                                                                            transaction.transactionId
                                                                        }}
                                                                    </p>
                                                                    <p v-else>
                                                                        N/A
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="w-1/4 text-end font-semibold text-red-500"
                                                        >
                                                            -Fr.
                                                            {{
                                                                transaction.amountDeducted
                                                            }}
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- <table v-else>
                                                    <tr>
                                                        <td colspan="3">
                                                            {{
                                                                $t(
                                                                    "no_transactions"
                                                                )
                                                            }}
                                                        </td>
                                                    </tr>
                                                </table> -->
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
    <stripe-payment-modal ref="stripe_payment_modal" />
    <paypal-payment-modal ref="paypal_payment_modal" />
    <ps-error-dialog ref="ps_error_dialog" />
    <ps-warning-dialog-2 ref="ps_warning_dialog" />
    <ps-loading-dialog ref="psloading" :isClickOut="false" />
    <ps-success-dialog ref="ps_success_dialog" />

    <input-email-modal ref="input_email" />

    <withdraw-amount-modal ref="withdrawal_modal" />
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

import { loadConnectAndInitialize } from "@stripe/connect-js";

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
        PsStatus,
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
        const stripe_payment_modal = ref();
        const paypal_payment_modal = ref();

        const withdrawal_modal = ref();

        const client_secret = ref("");
        const targetDiv = ref("");
        // const payment_element = ref<HTMLElement | null>(null);
        const payment_element = ref();

        const psloading = ref();
        const walletrechargeParameterHolder =
            new WalletRechargeHistoryParameterHolder();
        const razorId = ref("");
        const amount = ref("");
        const walletView = ref("default");
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
        const walletLogInfo = ref(null);

        async function openModal() {
            psmodal.value.toggle(true);
            await loadUserData();
        }

        // Functions
        onMounted(async () => {
            loadUserData();
            // loadStripeConnectDetails();
        });

        async function isRechargeSuccessful(val) {
            this.$emit("isRechargeSuccessful", val);
            psmodal.value.toggle(false);
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

                walletLogInfo.value = walletInfo.userWalletLog;
            } else {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__error"),
                    trans("edit_profile__ok"),
                    () => {}
                );
                // router.push({ name : "dashboard"});
            }

            // loadAppVerifier();
        }

        // async function loadStripeConnectDetails() {
        //     //const fetchClientSecret = async () => {
        //     const stripeConnectData = await userStore.loadUserStripeConnect(
        //         loginUserId
        //     );
        //     console.log("stripeConnectData", stripeConnectData);
        //     //dashboardUrl.value = stripeConnectData.data.clientSecret;
        //     payment_element.value = stripeConnectData.data.clientSecret;
        //     // return stripeConnectData.data.clientSecret;
        //     // };

        //     // const stripeConnectInstance = loadConnectAndInitialize({
        //     //     publishableKey: appInfoStore.appInfo.data.stripePublishableKey,
        //     //     fetchClientSecret: fetchClientSecret,
        //     // });

        //     // const paymentComponent = stripeConnectInstance.create("payments");
        //     // console.log(paymentComponent);
        //     // payment_element.value = paymentComponent.innerHTML;
        // }

        function fillAmount(value) {
            amount.value = value;
        }

        // function showWithdrawModal() {
        //     withdrawal_modal.value.openModal();
        // }

        function cancelClicked() {
            router.get(route("fe_profile"));
        }

        function paymentClicked() {
            const currentDate = new Date().getTime();
            const startDateTimestampStr =
                PsUtils.getTimeStampDividedByOneThousand(currentDate);

            if (amount.value == "") {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__amount_not_entered"),
                    trans("ps_error_dialog__amount_enter"),
                    trans("edit_profile__ok")
                );
                return;
            }
            let amountStr = parseFloat(amount.value);

            if (amountStr < 10) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__amount_less"),
                    trans("ps_error_dialog__amount_less_than"),
                    trans("edit_profile__ok")
                );
                return;
            }
            if (amountStr > 2000) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__amount_max_limit"),
                    trans("ps_error_dialog__amount_invalid"),
                    trans("edit_profile__ok")
                );
                return;
            }
            //const payment = "stripe";

            stripe_payment_modal.value.openModal(
                () => {
                    const payment = PsConst.PAYMENT_STRIPE_METHOD.toString();
                    doPayment(payment, amountStr, startDateTimestampStr);
                },
                async () => {
                    emit("isRechargeSuccessful", false);
                    PsUtils.log("Cancel");
                    const walletData = await userStore.loadUserWallet(
                        loginUserId
                    );
                    const walletInfo = walletData.data;

                    walletholder.walletBalance = walletInfo.walletBalance;
                    walletholder.currency = walletInfo.currency;
                    walletholder.rechargeDate = walletInfo.rechargeDate;
                    walletholder.onHoldAmount = walletInfo.holdAmount;
                    walletholder.userWalletLog = walletInfo.userWalletLog;
                }
            );
            // doPayment(payment, parseFloat(amountStr), startDateTimestampStr);
        }

        async function doPayment(payment, amount, startDateTimestampStr) {
            psloading.value.openModal();
            walletrechargeParameterHolder.amount = amount;
            walletrechargeParameterHolder.paymentMethod = payment;
            walletrechargeParameterHolder.paymentMethodNounce =
                localStorage.paymentNonce || "";
            walletrechargeParameterHolder.razorId = razorId.value || "";
            walletrechargeParameterHolder.rechargeTimeStamp =
                startDateTimestampStr;

            const rechargestatus = await provider.postWalletRecharge(
                walletrechargeParameterHolder,
                loginUserId
            );
            // console.log("rechargestatus", rechargestatus);
            psloading.value.closeModal();
            //psmodal.value.toggle(false);
            if (rechargestatus.status == PsStatus.ERROR) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__recharge_error"),
                    ""
                );
            } else {
                ps_success_dialog.value.openModal(
                    trans("ps_success_dialog__success"),
                    trans("ps_error_dialog__recharge_success"),
                    trans("core__be_btn_ok"),
                    () => {
                        location.reload();
                    }
                );
                // showSuccessDialog(rechargestatus.message);
                //emit("isRechargeSuccessful", true);
                /// PsUtils.log("Cancel");
            }

            // const redirectUrl = rechargestatus.data.url;

            // const width = 600;
            // const height = 600;
            // const left = (window.screen.width - width) / 2;
            // const top = (window.screen.height - height) / 2;

            // const popup = window.open(
            //     redirectUrl,
            //     "Payment",
            //     `width=${width}, height=${height}, left=${left}, top=${top}`
            // );

            // if (!popup || popup.closed || typeof popup.closed === "undefined") {
            //     ps_error_dialog.value.openModal(
            //         "Popup was blocked!",
            //         " Please enable popups for this site.",
            //         "Okay"
            //     );
            // } else {
            //     popup.focus();
            // }
        }
        function showSuccessDialog(msg) {
            ps_success_dialog.value.openModal(
                trans("ps_success_dialog__success"),
                msg,
                trans("core__be_btn_ok"),
                () => {
                    location.reload();
                }
            );
        }

        function changeView(view) {
            // if (view == "stripeconnect") {
            //     walletView.value = view;

            //     /***********************May 28 *******************************/

            //     /************************************************************/
            // } else {
            walletView.value = view;
            // }
        }

        function convertedDate(dateStr) {
            const dateObj = new Date(dateStr);
            return formatDate(dateObj);
        }

        function formatDate(date) {
            // Adjust for IST (UTC+5:30)
            const istOffset = 5.5 * 60 * 60 * 1000;
            const istDate = new Date(date?.getTime() + istOffset);

            const day = istDate.getUTCDate();
            const month = istDate.toLocaleString("en-US", {
                month: "long",
                timeZone: "UTC",
            });
            const year = istDate.getUTCFullYear();

            let hours = istDate.getUTCHours();
            let minutes = istDate.getUTCMinutes();
            const ampm = hours >= 12 ? "pm" : "am";
            hours = hours % 12;
            hours = hours || 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? "0" + minutes : minutes;
            return `${day} ${month} ${year}`;
        }

        return {
            convertedDate,
            formatDate,
            showSuccessDialog,
            amount,
            walletView,
            changeView,
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
            cancelClicked,
            ps_warning_dialog,
            paymentClicked,
            openModal,
            psmodal,
            stripe_payment_modal,
            withdrawal_modal,
            psloading,
            isRechargeSuccessful,
            fillAmount,
            // showWithdrawModal,
            holder,
            walletholder,
            paypal_payment_modal,
            input_email,
            bidInfo,
            walletLogInfo,
            client_secret,
            payment_element,
            // offline_payment_modal,
            // ps_warning_dialog,
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
                    label: trans("profile__user_wallet"),
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
.secure-pay {
    font-family: Arial, sans-serif;
    font-size: 14px;
    font-weight: 200;
    background: linear-gradient(to right, rgb(10 98 194), rgb(13 176 19));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
