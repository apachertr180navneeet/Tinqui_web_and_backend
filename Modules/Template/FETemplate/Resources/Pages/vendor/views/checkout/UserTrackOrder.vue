<template>

    <Head :title="$t('checkout_page')" />
    <div class="flex flex-wrap sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div class="md:w-5/12 lg:w-5/12 sm:w-5/12 mx-auto">
            <div class="border border-gray-200 shadow-md flex flex-wrap">
                <img alt="Placeholder" width="300px" height="200px"
                    class="w-12 h-12 object-cover bg-feAchromatic-50 rounded-full me-2" v-lazy="{
                        src:
                            $page.props.thumb1xUrl +
                            '/' +
                            '',
                        loading:
                            $page.props.sysImageUrl +
                            '/loading_gif.gif',
                        error:
                            $page.props.sysImageUrl +
                            '/default_photo.png',
                    }" />
                <div class="grid">
                    <h5 class="text-green-3xl font-bold">Item Name</h5>
                    <p>category: item category</p>
                    <p>price: Fr. --</p>
                </div>
            </div>
            <div class="border bg-green-200 border-gray-200 my-3 py-3 px-4 shadow-md w-full grid grid-cols-12">
                <div class="col-span-8">
                    <div v-if="!isLoginUser && status == 'shipped'">
                        <h5>Confirm the Delivery</h5>
                        <p>Please confirm if the product has been delivered successfully</p>
                    </div>
                    <div v-if="!isLoginUser && status == 'recieved'">
                        <h5>Confirm the Delivery</h5>
                        <p>Please confirm if the product has been delivered successfully</p>
                    </div>
                </div>
                <div class="col-span-4">
                    <button v-if="isLoginUser" class="bg-green-400 py-2 px-4" type="button"
                        @click.prevent="updateStatus">Item
                        Shipped</button>
                    <button v-else-if="!isLoginUser && status == 'shipped'" class="bg-green-400 py-2 px-4" type="button"
                        @click.prevent="loginUser">Item
                        recieved</button>
                    <button v-else-if="!isLoginUser && status == 'recieved'" class="bg-green-400 py-2 px-4"
                        type="button" @click.prevent="loginUser">Satisfied</button>
                </div>
            </div>
        </div>
        <div class="md:w-4/12 lg:w-4/12 sm:w-4/12 mx-auto">
            <div class="border border-gra
            y-200 px-4 py-3 shadow-md">
                <table class="w-full">
                    <tbody>
                        <tr>
                            <td>{{ $t('core_fe__search_item') }} ({{ quantity }})</td>
                            <td class="text-end">Fr. {{ item?.price }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t('platform_fee_text') }}*</td>
                            <td class="text-end">{{ platform_fee }}</td>
                        </tr>
                    </tbody>
                </table>
                <hr class="my-3" />
                <div>
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td class="font-bold">{{ $t('package__total_post') }}</td>
                                <td class="font-bold text-end">Fr. {{ total_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button @click.prevent="buyNow"
                        class="rounded-lg my-4 w-full bg-green-400 hover:bg-green-500 border border-green-500 py-3 text-white font-semibold  ">
                        {{ $t('pay_now_button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <ps-payment-error ref="ps_payment_error" />
    <ps-message-dialog ref="ps_message_dialog" />
</template>

<script>

import { onMounted, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import PsConst from "@templateCore/object/constant/ps_constants";
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import PsMessageDialog from "@template1/vendor/components/core/dialog/PsMessageDialog.vue";
import PsPaymentError from "@template1/vendor/components/core/dialog/PsPaymentError.vue";
import MarkSoldOutItemParameterHolder from "@templateCore/object/holder/MarkSoldOutItemParameterHolder";

export default {
    name: "UserTrackOrder",
    layout: PsFrontendLayout,
    components: {
        Head,
        PsPaymentError,
        PsMessageDialog
    },
    props: ['query'],
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
        const user = ref({})
        const userStore = useUserStore();
        const offerProvider = useOfferStoreState();
        const ps_message_dialog = ref()
        const ps_payment_error = ref()
        const markAsSoldHolder =
            new MarkSoldOutItemParameterHolder().markSoldOutItemHolder();

        onMounted(async () => {
            console.log("itemid", props.query.item_id);
            const productStore = useProductStore();
            await productStore.loadItem(props.query.item_id, loginUserId);
            item.value = productStore.item.data;
            total_amount.value = parseFloat(item.value.price) + parseFloat(platform_fee.value);
            await userStore.loadUser(loginUserId);
            user.value = userStore.user.data;

            // console.log("user data:\n", user, "\nitem data\n", item)
        })




        return {
            item,
            quantity,
            platform_fee,
            total_amount,
            ps_payment_error,
            ps_message_dialog
        }
    }

}
</script>