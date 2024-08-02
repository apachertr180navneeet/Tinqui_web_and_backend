<template>
    <div
        id="category_outer"
        class="text-center cursor-pointer w-full overflow-hidden bg-feAchromatic-50 border border-feAchromatic-100 dark:border-feAchromatic-700 dark:bg-feSecondary-800 rounded-x sm:rounded-xl lg:rounded-lg hover:shadow-md"
        @mouseenter="handleMouseOver($event, category.catId)"
        @mouseleave="handleMouseLeave(category.catId)"
    >
        <div
            class="cate-icon-img w-14 h-14 absolute -bottom-7 bg-feAchromatic-50 p-3 items-center rounded-full border-2 border-white dark:bg-feSecondary-800 shadow-md"
        >
            <img
                alt="Placeholder"
                class="w-7 h-7 transform transition duration-500 hover:scale-110 object-contain"
                v-lazy="{
                    src:
                        $page.props.thumb2xUrl +
                        '/' +
                        category.defaultIcon.imgPath,
                    error: $page.props.sysImageUrl + '/default_photo.png',
                }"
            />
        </div>

        <ps-label
            class="h-20 pt-9 lg:text-base sm:text-sm text-base font-medium"
            textColor=""
        >
            {{
                category.catName
            }}
        </ps-label>

        <div class="cateabousult-div absolute left-full text-center">
            <!-- <div
                v-if="showSubcategories"
                class="flex justify-between items-center mb-6 subcategory-pop-up"
                :class="{
                    'subcategory-pop-up-show custom-sub-cat': showSubcategories,
                }"
                :style="{ top: -topPosition + 'px', left: -17 + 'px' }"
            > -->
                <div
                    v-if="showSubcategories"
                    class="flex justify-between items-center mb-6 subcategory-pop-up bg-white dark:bg-feSecondary-800"
                    :class="{
                        'subcategory-pop-up-show custom-sub-cat dark:bg-feSecondary-800':
                            showSubcategories,
                    }"
                    :style="{ top: -topPosition + 'px', left: -17 + 'px' }"
                >
                    <ul>
                        <li
                        class="dark:text-feSecondary-800"
                            v-for="(
                                subCategory, index
                            ) in category.subCategories"
                            :key="index"
                            @click="
                                clicksubCatRoute('fe_item_list', {
                                    cat_id: category.catId,
                                    cat_name: category.catName,
                                    sub_cat_id: subCategory.id,
                                    sub_cat_name: subCategory.name,
                                    status: 1,
                                })
                            "
                        >
                            {{ $t(subCategory.name) }}
                        </li>
                    </ul>
                </div>
            <!-- </div> -->
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, reactive, onMounted, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { useSubCategoryStoreState } from "@templateCore/store/modules/subCategory/SubCategoryStore";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import Category from "@templateCore/object/Category";
import SubCategory from "@templateCore/object/SubCategory";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import SubCategoryItemSidebar from "@template1/vendor/components/modules/category/SubCategoryItemSidebar.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";

export default defineComponent({
    name: "CategorySidebarItem",
    props: {
        category: { type: Category },
        scrollTop: { type: Number },
    },
    components: {
        PsLabel,
        SubCategoryItemSidebar,
        PsRouteLink,
    },
    setup(props) {
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();

        const subCategoryStore = useSubCategoryStoreState();
        const showSubcategories = ref(false);

        // const subCategoryData = ref(null);
        const subCategoryData = ref<Array<SubCategory> | null>(null);

        const topOffset = ref(0);
        const topPosition = ref(0);
        const leftOffset = ref(0);

        let catIdforSubCat = ref(0);

        const calculatePosition = (event) => {
            topOffset.value = event.pageY;
            leftOffset.value = event.eventX;
        };

        const handleMouseOver = (event, catId) => {
            calculatePosition(event);

            if (catIdforSubCat != catId) {
                catIdforSubCat.value = catId;

                showSubcategories.value = true;
            }
        };

        const handleMouseLeave = (catId) => {
            //catIdforSubCat.value = 0;
            if (catIdforSubCat != catId) {
                showSubcategories.value = false;
            }
        };

        function clicksubCatRoute(name, params) {
            const baseUrl = route(name);
            const queryString = Object.keys(params)
                .map(
                    (key) =>
                        `${encodeURIComponent(key)}=${encodeURIComponent(
                            params[key]
                        )}`
                )
                .join("&");

            const urlWithParams = `${baseUrl}?${queryString}`;
            window.location.href = urlWithParams;
            showSubcategories.value = false;
        }

        watch(
            () => catIdforSubCat.value,
            (newVal) => {
                if (newVal == props.category.catId) {
                    showSubcategories.value = true;
                }
            }
        );

        watch(
            () => props.scrollTop,
            (newValue) => {
                if (newValue) {
                    const topValue = newValue;
                    topPosition.value = topValue;
                }
            }
        );


        return {
            subCategoryStore,
            showSubcategories,
            catIdforSubCat,
            calculatePosition,
            topOffset,
            leftOffset,
            handleMouseOver,
            handleMouseLeave,
            subCategoryData,
            topPosition,
            clicksubCatRoute,
        };
    },
});
</script>
<style scoped>
.absolute {
    position: absolute;
    z-index: 10;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.subcategory-pop-up-show {
    visibility: visible !important;
}

.subcategory-pop-up li:hover {
    color: green;
}

li {
    cursor: pointer;
}

.subcategory-pop-up {
    position: relative;
    padding: 23px;
    box-shadow: 0 4px 4px #0000001a;
    z-index: 999;
    visibility: hidden;
}

.dark .subcategory-pop-up li[data-v-863bc712] {
    color: #000;
}
</style>
