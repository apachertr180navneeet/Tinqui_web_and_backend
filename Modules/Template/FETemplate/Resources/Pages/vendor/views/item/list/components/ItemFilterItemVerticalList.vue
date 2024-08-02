<template>
    <div class="grid sm:grid-cols-8 xl:grid-cols-9 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-6 mt-5">

        <div class=" sm:col-span-8 zl:col-span-9 col-span-4 w-full h-screen"
            v-if="itemProvider.loading.value == false && item_list.length == 0 && initial == false">
            <div class="flex flex-col items-center justify-center">
                <div class="h-52 ">
                    <img v-lazy="{ src: $page.props.sysImageUrl + '/no_result.png' }" alt=""
                        class="w-full h-52 object-contain">
                </div>
                <ps-label textColor="text-feSecondary-800 dark:text-feSecondary-300" class="text-lg font-semibold mt-4">
                    {{
                        $t("list__no_result") }} </ps-label>
                <ps-label textColor="text-feSecondary-500" class="mt-2 text-sm"> {{
                    $t("list__no_list_found") }} </ps-label>
                <ps-label textColor="text-feSecondary-500" class="text-sm"> {{
                    $t("list__search_again") }} </ps-label>
                <ps-button class="mt-6"> {{ $t("list__search") }} </ps-button>
            </div>
        </div>

        <!-- Column -->
        <div class="col-span-4 sm:col-span-4 xl:col-span-3 w-full" v-for="item in item_list" :key="item.id">
            <item-horizontal-item :item="item" class="infobox-item-properties" storeName="list" />
        </div>
        <!-- END Column -->

    </div>

    <div v-if="itemProvider.itemList?.code != null && itemProvider.itemList?.code.toString() != notDataCode">

        <div class="flex flex-wrap justify-center mb-6">
            <ps-button v-if="itemProvider.loading.value == false && initial == false" class="mx-auto mt-8"
                @click="loadItemList" :class="itemProvider.isNoMoreRecord.value ? 'hidden' : ''"> {{
                    $t("list__load_more") }} </ps-button>
            <ps-button v-else-if="initial == false" class="mx-auto mt-8" @click="loadItemList" :disabled="true">{{
                $t("list__loading") }}</ps-button>
        </div>
    </div>
</template>

<script>
// Libs
import { ref, defineAsyncComponent, onMounted, watch } from 'vue';
// Components
import PsLabel from '@template1/vendor/components/core/label/PsLabel.vue';
import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
const ItemHorizontalItem = defineAsyncComponent(() => import('@template1/vendor/components/modules/item/ItemHorizontalItem.vue'));
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
// Const
import PsConst from '@templateCore/object/constant/ps_constants';

export default {
    name: 'ItemFilterItemVerticalList',
    components: {
        PsLabel,
        PsButton,
        ItemHorizontalItem,
    },
    props: {
        initial: {
            type: Boolean,
            default: false
        },
        list_type: {
            type: String,
            default: '0'
        }
    },
    setup(props) {
        const psValueStore = PsValueStore();
        const itemProvider = useProductStore('list');
        const notDataCode = PsConst.ERROR_CODE_10001;
        const item_list = ref(itemProvider.itemList.data)

        watch(() => props.list_type, (newVal, oldVal) => {
            console.log(newVal, oldVal)
            if (newVal) {
                console.log(newVal);
                filterItemList()
            } 
        });



        async function filterItemList() {
            if (props.list_type == "1") {
                let list = itemProvider.itemList.data.filter((item) => {
                    if (item.isAuctionItem == "1" && item.auctionStatus == "0" && item.isSoldOut != '1' && item.isExpired != '1') {
                        return item;
                    }
                });
                item_list.value = list
            } else if (props.list_type == "2") {

                let list = itemProvider.itemList.data.filter((item) => {
                    for (let i = 0; i < item.productRelation.length; i++) {
                        let relation = item.productRelation[i]
                        if (relation.coreKeysId === "ps-itm00003" && relation.selectedValue[0].value.toLowerCase() === "fixed price" && item.isSoldOut != '1' && item.isExpired != '1') {
                            return item;
                        }
                    }
                })
                item_list.value = list
            } else if (props.list_type == "3") {
                let list = itemProvider.itemList.data.filter((item) => {
                    for (let i = 0; i < item.productRelation.length; i++) {
                        let relation = item.productRelation[i]
                        if (relation.coreKeysId === "ps-itm00003" && relation.selectedValue[0].value.toLowerCase() === "auction" && item.isSoldOut != '1' && item.isExpired != '1') {
                            return item;
                        }
                    }
                })
                item_list.value = list
            } else {
                await itemProvider.loadItemList(psValueStore.getLoginUserId(), itemProvider.paramHolder)
                let list = itemProvider.itemList.data.filter((item) => {
                    if (item.isSoldOut != '1' && item.isExpired != '1') {
                        return item
                    }
                });
                item_list.value = list;
            }
        }

        onMounted(() => {
            filterItemList();
        });

        function loadItemList() {
            itemProvider.loadItemList(psValueStore.getLoginUserId(), itemProvider.paramHolder);
            filterItemList()
        }

        return {
            notDataCode,
            itemProvider,
            loadItemList,
            item_list,
        }
    }

}

</script>
