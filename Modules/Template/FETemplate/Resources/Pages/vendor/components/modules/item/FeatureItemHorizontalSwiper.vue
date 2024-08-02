<template>
    <div class="flex flex-col">
      <div class="flex justify-between mt-4">
      <button
        class="bg-feSecondary-50 dark:bg-feSecondary-800 w-10 h-10 rounded shadow-sm p-2 splide__arrow--prev"
        @click="prevPage"
        :disabled="currentPage === 1 || !hasPreviousPage"
      >
        <ps-icon textColor="dark:text-feSecondary-200" name="arrowNarrowRight" h="23" w="23" viewBox="0 -3 9 20"/>
      </button>
      
      <!-- Next button -->
      <button 
        class="bg-feSecondary-50 dark:bg-feSecondary-800 w-10 h-10 rounded shadow-sm p-2 splide__arrow--next"
        @click="nextPage"
        :disabled="currentPage === totalPages || !hasNextPage"
      >
        <ps-icon textColor="dark:text-feSecondary-200" name="arrowNarrowRight" h="23" w="23" viewBox="0 -3 9 20"/>
      </button>
  
      </div>
      <div class="slider flex overflow-x-auto">
        <div class="flex" :class="sliderClass">
          <ps-route-link
            v-for="(item, index) in paginatedItemList"
            :key="index"
            class="flex-shrink-0"
            :style="{ width: itemWidth }" 
            :to="{
              name: 'fe_item_detail',
              query: {
                item_id: item.id
              }
            }"
          >
            <item-horizontal-item
              v-if="item.title == ''"
              :item="item"
            />
            <item-horizontal-item
              v-else
              :item="item"
              :notShowTitle="notShowTitle"
              :storeName="storeName"
            />
          </ps-route-link>
        </div>
      </div>
      
    </div>
  </template>
  
  <script>
  import ItemHorizontalItem from '../item/ItemHorizontalItem.vue';
  import PsRouteLink from '@template1/vendor/components/core/link/PsRouteLink.vue';
  import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
  import PsIcon from '@template1/vendor/components/core/icons/PsIcon.vue';
  import ItemHorizontalSkeletorItem from "@template1/vendor/components/modules/item/ItemHorizontalSkeletorItem.vue";
  
  export default {
    name: 'AuctionItemHorizontalSwiper',
    components: {
      ItemHorizontalItem,
      PsRouteLink,
      PsButton,
      PsIcon,
      ItemHorizontalSkeletorItem,
    },
    props: {
      itemList: Array,
      notShowTitle: {
        type: Boolean,
        default: false
      },
      props: {
          itemList: Array,
          notShowTitle: {
              type: Boolean,
              default: false,
          },
          storeName: {
              type: String,
              default: "",
          },
          isLoading: {
              type: Boolean,
              default: true,
          },
      },
    },
    data() {
      return {
        currentPage: 1,
        itemsPerPage: this.getItemsPerPage(window.innerWidth),
        itemWidth: this.getItemWidth(window.innerWidth),
      };
    },
    computed: {
      paginatedItemList() {
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        return this?.itemList?.slice(startIndex, endIndex);
      },
      sliderClass() {
        return {
          'space-x-4 w-[93%]': this.itemsPerPage === 4,
          'space-x-2 w-[96%]': this.itemsPerPage === 2,
          // Add more classes for different itemsPerPage values
        };
      },
      totalPages() {
        return Math.ceil(this.itemList.length / this.itemsPerPage);
      },
      hasPreviousPage() {
        return this.currentPage > 1;
      },
      hasNextPage() {
        return this.currentPage < this.totalPages;
      }
    },
    mounted() {
      window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
      window.removeEventListener('resize', this.handleResize);
    },
    methods: {
      handleResize() {
        this.itemsPerPage = this.getItemsPerPage(window.innerWidth);
        this.itemWidth = this.getItemWidth(window.innerWidth);
      },
      getItemsPerPage(windowWidth) {
        if (windowWidth >= 1536) return 4;
        else if (windowWidth >= 1280) return 4;
        else if (windowWidth >= 1024) return 4;
        else if (windowWidth >= 768) return 2;
        else return 2;
      },
      getItemWidth(windowWidth) {
        const perPage = this.getItemsPerPage(windowWidth);
        return `${100 / perPage}%`;
      },
      nextPage() {
        if (this.hasNextPage) {
          this.currentPage++;
        }
      },
      prevPage() {
        if (this.hasPreviousPage) {
          this.currentPage--;
        }
      }
    },
  }
  </script>