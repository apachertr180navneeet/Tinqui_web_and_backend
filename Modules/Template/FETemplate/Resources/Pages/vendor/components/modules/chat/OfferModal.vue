<template>
    <ps-modal ref="psmodal" :isClickOut='false' :maxWidth="'570px'" theme="p-6 rounded-md -z-10">
        <template #title>
            <div class="flex justify-between">
                <ps-label-header-6 > {{ $t('offer_modal__make_offer_for_this_item') }}</ps-label-header-6>
                <ps-icon name="close" class="text-feAchromatic-400 hover:cursor-pointer"
                    @click.prevent="psmodal.toggle(false)"></ps-icon>
            </div>
        </template>
        <template #body>
            <div class="my-3">
                <h1 class="font-semibold dark:text-white">{{ currency }} {{ itemPrice }}</h1>
            </div>
            <div class="mt-5">
                <h5 class="font-semibold dark:text-white">{{ $t("your_bid_text") }}</h5>
                <div class=" w-full gap-3">
                    <div class="my-3 relative">
                        <span class="absolute top-[11px] left-[7px] ">{{ currency }}</span>
                        <input type="text" class="w-full rounded-md ps-7 focus:outline-none focus:border-none py-[10px]"
                            @change="(e) => updateValue(e.target.value)" :value="negoPrice" />
                    </div>
                    <p class="dark:text-white">{{ $t('minimum_bid_text') }} {{ currency }} {{ min_price }}</p>
                </div>
                <div class="my-3 col-span-3 bid-button">
                    <ps-button class="px-9 py-3" @click="submitClicked(negoPrice, currency)">{{
                        $t('chat__make_an_offer') }}</ps-button>
                </div>
            </div>
        </template>

    </ps-modal>

    <ps-loading-dialog ref="ps_loading_dialog" :isClickOut='false' />

    <ps-error-dialog ref="ps_error_dialog" />
</template>

<script lang='ts'>

// Libs
import { defineComponent, onMounted, ref } from 'vue';
import { useItemCurrencyStoreState } from '@templateCore/store/modules/item/ItemCurrencyStore';
// Compone
import PsModal from '@template1/vendor/components/core/modals/PsModal.vue';
import PsLabelHeader6 from '@template1/vendor/components/core/label/PsLabelHeader6.vue';
import PsLabel from '@template1/vendor/components/core/label/PsLabel.vue';
import PsInput from '@template1/vendor/components/core/input/PsInput.vue'
import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
import PsErrorDialog from '@template1/vendor/components/core/dialog/PsErrorDialog.vue';
import PsLoadingDialog from '@template1/vendor/components/core/dialog/PsLoadingDialog.vue';
import PsIcon from '@template1/vendor/components/core/icons/PsIcon.vue';
import { useGetChatHistoryStoreState } from "@templateCore/store/modules/chat/GetChatHistoryStore";
import PsDropdown from '@template1/vendor/components/core/dropdown/PsDropdown.vue';
import ItemEntryParameterHolder from '@templateCore/object/holder/ItemEntryParameterHolder';
import PsInputWithLeftIcon from '@template1/vendor/components/core/input/PsInputWithLeftIcon.vue';
import PsLabelCaption from '@template1/vendor/components/core/label/PsLabelCaption.vue';
import format from 'number-format.js';
import { trans } from 'laravel-vue-i18n';
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { usePsAppInfoStoreState } from '@templateCore/store/modules/appinfo/AppInfoStore'
import PsDropdownSelect from '@template1/vendor/components/core/dropdown/PsDropdownSelect.vue';


export default defineComponent({
    name: "OfferModal",
    components: {
        PsModal,
        PsLabelHeader6,
        PsLabel,
        PsButton,
        PsErrorDialog,
        PsLoadingDialog,
        PsInput,
        PsIcon,
        PsDropdown,
        PsInputWithLeftIcon,
        PsLabelCaption,
        PsDropdownSelect
    },
    props: {
        price: {
            type: String,
            default: '0'
        },

    },
    emits: ['submit'],
    setup(props, context) {
        const psmodal = ref();
        const title = ref('');
        const message = ref('');
        const ps_loading_dialog = ref();
        const ps_error_dialog = ref();
        const itemId = '';
        let itemName = ref('');
        let itemImage = ref('');
        let itemCategory = ref('');
        let currency = ref('Fr.');
        const buyerUserId = '';
        const sellerUserId = '';
        const itemCurrencyStore = useItemCurrencyStoreState('entry');
        const price_range = ref([
            {
                id: "1",
                value: "$"
            },
            {
                id: "2",
                value: "$$"
            },
            {
                id: "3",
                value: "$$$"
            },
            {
                id: "4",
                value: "$$$$"
            },
            {
                id: "5",
                value: "$$$$$"
            },

        ]);

        function priceRangeClicked(value) {
            negoPrice.value = value.value;

        }


        let negoPrice: any = ref(props.price);
        let item_price = ref(props.price);
        let itemPrice = ref('');
        // Init Provider
        const appInfoStore = usePsAppInfoStoreState();
        const chatHistoryProvider = useGetChatHistoryStoreState();
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const paramHolder1 = ref(new ItemEntryParameterHolder());
        const min_price: any = ref('');

        function getminimumValue(bidPrice, price) {
            let amt = parseFloat(price);
            let offer = parseFloat(bidPrice);
            if (amt < 1.00) {
                return offer + 0.05;
            } else if (amt >= 1.00 && amt <= 4.99) {
                return offer + 0.25;
            } else if (amt >= 5.00 && amt <= 24.99) {
                return offer + 0.50;
            } else if (amt >= 25.00 && amt <= 99.99) {
                return offer + 1.00;
            } else if (amt >= 100.00 && amt <= 249.99) {
                return offer + 2.50;
            } else if (amt >= 250.00 && amt <= 499.99) {
                return offer + 5.00;
            } else if (amt >= 500.00 && amt <= 999.99) {
                return offer + 10.00;
            } else if (amt >= 1000.00 && amt <= 2499.99) {
                return offer + 25.00;
            } else if (amt >= 2500.00 && amt <= 4999.99) {
                return offer + 50.00;
            } else if (amt >= 5000.00) {
                return offer + 100.00;
            }
        }

        function openModal(bidPrice, price) {


            // alert(data);
            if (appInfoStore.appInfo.data?.psAppSetting?.SelectedPriceType == "PRICE_RANGE") {

                const floatValue = parseFloat(bidPrice);
                const intValue = parseInt(floatValue);
                if (intValue > 5) {
                    bidPrice = '$'.repeat(5);
                }
                else if (intValue < 1) {
                    bidPrice = '$'.repeat(1)
                }
                else {

                    bidPrice = '$'.repeat(intValue);

                }

            }
            if (appInfoStore.appInfo.data?.psAppSetting?.SelectedPriceType == "NO_PRICE") {
                // alert("here");
                bidPrice = 'FREE'
            }

            let value = getminimumValue(bidPrice, price);
            min_price.value = value;
            negoPrice.value = value;
            itemPrice.value = bidPrice;
            psmodal.value.toggle(true);

        }

        function submitClicked(negoPrice, currency) {
            // alert(negoPrice)

            context.emit('submit', negoPrice, currency);
            psmodal.value.toggle(false);
        }
        function loadCurrency() {
            itemCurrencyStore.loadItemCurrencyList(loginUserId);
        }

        function filterCurrency(value) {
            itemCurrencyStore.resetItemCurrencyList()
        }
        function currencyFilterClicked(value) {
            currency.value = value.currencySymbol;
            // alert(currency.value)
            // validation.value.itemCurrencyStatus = false;
        }

        function formatPrice(value) {
            if (value.toString() == '0') {
                return trans('item_price__free');
            } else {
                return format("#'##0.00", value)
            }
        }

        function updateValue(value) {
            negoPrice.value = value;
        }

        // onMounted(() => {
        //     itemCurrencyStore.reset
        // })

        return {
            psmodal,
            openModal,
            itemId,
            itemName,
            itemCategory,
            itemImage,
            currency,
            buyerUserId,
            sellerUserId,
            negoPrice,
            itemPrice,
            title,
            message,
            submitClicked,
            updateValue,
            ps_loading_dialog,
            ps_error_dialog,
            chatHistoryProvider,
            itemCurrencyStore,
            loadCurrency,
            paramHolder1,
            currencyFilterClicked,
            formatPrice,
            appInfoStore,
            price_range,
            priceRangeClicked,
            item_price,
            min_price
        }
    },
})
</script>
<style scoped>
p {
    font-size: 14px;
}
.bid-button {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
</style>