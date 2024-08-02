<template>
    <div v-if="
                        itemListProvider.hasData() != null || itemListProvider.loading.value
                    ">
        <div class="flex justify-between items-center mt-10">
            <ps-label-header-5 class="font-semibold">{{
                $t(title)
                }}</ps-label-header-5>
            <ps-route-link :to="{ name: 'fe_item_list', query: params['query'] }">
                <ps-button class="flex flex-row" padding="p-2 sm:px-4 sm:py-2" shadow="shadow-sm" rounded="rounded" hover=""
                    focus="" border="border border-feSecondary-200 dark:border-feSecondary-800"
                    colors="bg-feAchromatic-50 text-feSecondary-800 dark:bg-feSecondary-800 dark:text-feSecondary-200">
                    <ps-label class="hidden sm:inline">{{
                        $t("list_fe__view_all_label")
                        }}</ps-label>
                    <ps-icon class="sm:ms-2 block rtl:hidden" textColor="dark:text-feSecondary-200" name="rightChervon"
                        h="24" w="24" />
                    <ps-icon class="sm:ms-2 hidden rtl:block" textColor="dark:text-feSecondary-200" name="leftChervon"
                        h="24" w="24" />
                </ps-button>
            </ps-route-link>
        </div>
        <auction-item-horizontal-swiper v-if="itemListProvider.itemList?.data && itemListProvider.itemList?.data.length>0"
            class="mt-6 mb-26 sm:mb-0" :itemList="itemList"
            :isLoading="itemListProvider.loading.value" :storeName="item_list_name" />
    </div>
</template>

<script>
// Libs
import { onMounted, ref } from "vue";
// Components
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import ItemHorizontalSwiper from "@template1/vendor/components/modules/item/ItemHorizontalSwiper.vue";
import PsLabelHeader5 from "@template1/vendor/components/core/label/PsLabelHeader5.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
// Providers
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
// Holder
import ProductParameterHolder from "@templateCore/object/holder/ProductParameterHolder";
import AuctionItemHorizontalSwiper from "@template1/vendor/components/modules/item/AuctionItemHorizontalSwiper.vue";

export default {
  name: "DashboardItemHorizontalList",
  components: {
    ItemHorizontalSwiper,
    PsLabel,
    PsLabelHeader5,
    PsButton,
    PsRouteLink,
    PsIcon,
    AuctionItemHorizontalSwiper
  },
  props: {
    item_list_name: {
      type: String,
      default: "dashboard_recent",
    },
    limit: {
      type: Number,
      default: 12,
    },
  },
  setup(props) {
    const psValueStore = PsValueStore();
    const loginUserId = psValueStore.getLoginUserId();
    const itemListProvider = useProductStore(props.item_list_name);
    let title = "";
    const itemList = ref([])
    switch (props.item_list_name) {
      case "dashboard_recent":
        itemListProvider.paramHolder =
          new ProductParameterHolder().getLatestParameterHolder();
        title = "home__fe_recently_added";
        break;
      case "dashboard_popular":
        itemListProvider.paramHolder =
          new ProductParameterHolder().getPopularParameterHolder();
        title = "dashboard__popular";
        break;
      case "dashboard_discount":
        itemListProvider.paramHolder =
          new ProductParameterHolder().getDiscountParameterHolder();
        title = "dashboard__discount";
        break;
    }
    itemListProvider.limit = props.limit;
    let params = itemListProvider.paramHolder.getUrlParamsAndQuery();

    // console.log(itemListProvider.itemList);
    onMounted(async () => {
      await itemListProvider.resetProductList(
        loginUserId,
        itemListProvider.paramHolder
      );

      if (itemListProvider && itemListProvider?.itemList?.data?.length > 0) {
        itemList.value = itemListProvider.itemList?.data.filter((item) => {
          return item.isAuctionItem.toString() !== "1"
        })
      } else {
        itemList.value = itemListProvider?.itemList?.data || []
      }
    });

    return {
      title,
      itemListProvider,
      params,
      itemList
    };
  },
};
</script>
