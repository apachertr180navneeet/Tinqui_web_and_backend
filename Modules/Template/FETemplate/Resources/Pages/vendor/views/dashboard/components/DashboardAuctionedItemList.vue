<template>
  <div class="xl:w-feLarge lg:w-large md:w-full md:px-6 lg:px-0 mx-auto">
    <div v-if="itemList && itemList.length > 0"
      class="bg-feSecondary-50 dark:bg-feAchromatic-900 justify-between  mt-10 px-4 py-2 sm:p-4 list_view_div">

      <div class="flex flex-col mt-6 sm:mb-0">
        <ps-label-header-5 class="font-semibold" textColor="">{{ $t("home__fe_auction_items")
          }}</ps-label-header-5>
      </div>
      <!-- <div class="sm:mt-0">
        <ps-label class="text-base sm:text-lg font-normal" textColor="dark:text-feSecondary-300">{{
          $t("home__fe_auction_items_desc") }}</ps-label>
      </div>
   -->
      <ps-route-link class="flex-grow view_more_btn" :to="{
        name: 'fe_item_list',
        query: {
          product_type: 'live-video-auction',
          status: 1,
        },
      }">
        {{ $t('fe__view_all') }}
      </ps-route-link>
      <div class="homepage-slider w-full">
        <auction-item-horizontal-swiper :itemList="itemList" :isLoading="isLoading" storeName="dashboard_auction" />
      </div>
    </div>
  </div>
</template>

<script>


import { onMounted, ref } from 'vue';
import AuctionItemHorizontalSwiper from "@template1/vendor/components/modules/item/AuctionItemHorizontalSwiper.vue";
import PsLabel from '@template1/vendor/components/core/label/PsLabel.vue';
import PsLabelHeader5 from '@template1/vendor/components/core/label/PsLabelHeader5.vue';
import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
import PsRouteLink from '@template1/vendor/components/core/link/PsRouteLink.vue';
import PsIcon from '@template1/vendor/components/core/icons/PsIcon.vue';
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import AuctionItemParameterHolder from "@templateCore/object/holder/AuctionItemParameterHolder";

export default {
  name: 'DashboardAuctionedItemList',
  components: {
    AuctionItemHorizontalSwiper,
    PsLabel,
    PsLabelHeader5,
    PsButton,
    PsRouteLink,
    PsIcon
  },
  props: {
    limit: {
      type: Number,
      default: 12
    },
  },
  setup(props) {
    const psValueStore = PsValueStore();
    const loginUserId = psValueStore.getLoginUserId();
    const holder = new AuctionItemParameterHolder();
    holder.orderType = 'desc';
    holder.paidStatus = 'normal_ads_only';
    holder.status = '1';
    holder.auctionItem = '1';
    const store = useProductStore()
    const itemList = ref([]);
    const isLoading = ref(true);

    onMounted(async () => {
      const result = await store.loadAuctionList(loginUserId, holder);
      for (let i = 0; i < result.length; i++) {
        if (result[i].isAuctionItem.toString() == "1" && result[i].auctionStatus.toString() !== "1" && result[i].isSoldOut.toString() !== "1" && result[i].isExpired.toString() !=='1') {
          itemList.value.push(result[i])
        }
      }
      if (itemList.value.length > 0) {
        isLoading.value = false;
      }
    });

    return {
      itemList,
      isLoading
    }
  }

}
</script>

<style scoped>
.view_more_btn{
  background-color: rgb(var(--color-fePrimary-500) / var(--tw-bg-opacity));
    float: right;
    color: #fff;
    padding: .5rem 1rem;
    position: absolute;
    top: 30px;
    right: 30px;
    cursor: pointer;
}
.list_view_div{
  position: relative;
}
</style>
