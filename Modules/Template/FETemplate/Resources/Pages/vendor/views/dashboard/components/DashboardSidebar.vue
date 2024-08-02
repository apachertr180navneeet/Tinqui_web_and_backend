<template #content>
    <div class="flex justify-center flex-wrap gap-x-2 sm:gap-x-4 gap-y-4 test-pop-cate">
        <a href="#"
            class="text-feSecondary-800 dark:text-feAchromatic-50 text-sm hover:text-fePrimary-500 hover:dark:text-fePrimary-500 font-medium cursor-pointer px-4 py-2"
            @click="toggleSidebar">{{ $t("category_list__title") }}</a>
        <div class="sidenav" id="sidenav" :class="{ show: showSidebar }">
            <ul @scroll="handleSidebarScroll($event)">
                <li class="title">
                    {{
                        $t("list_fe__view_all_label_category")
                    }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" @click="toggleSidebar"
                        class="close sidenav-overlay">X</a>
                </li>

                <li v-if="categoriesData != null" v-for="category in categoriesData" :key="category.catId"
                    class="show-sub-cate">
                    <ps-route-link :to="{
                        name: showSubCat
                            ? 'fe_sub_category'
                            : 'fe_item_list',
                        query: {
                            cat_id: category.catId,
                            cat_name: category.catName,
                            status: 1,
                        },
                    }" @click="updateCategoryTouchCount(category.catId)" class="sub_category_div">
                        <category-sidebar-item :category="category" :scrollTop="scrollPosition" />
                    </ps-route-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
// Libs
import { onMounted, ref, onUnmounted, reactive } from "vue";
// Components
import { useSubCategoryStoreState } from "@templateCore/store/modules/subCategory/SubCategoryStore";
import { trans } from "laravel-vue-i18n";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLabelHeader5 from "@template1/vendor/components/core/label/PsLabelHeader5.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import CategoryHorizontalItem from "@template1/vendor/components/modules/category/CategoryHorizontalItem.vue";
//feb27
import CategorySidebarItem from "@template1/vendor/components/modules/category/CategorySidebarItem.vue";

import CategoryHorizontalSkeletorItem from "@template1/vendor/components/modules/category/CategoryHorizontalSkeletorItem.vue";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useCategoryStoreState } from "@templateCore/store/modules/category/CategoryStore";
import { useTouchCountStoreState } from "@templateCore/store/modules/category/TouchCountStore";
//Holder
import TouchCountParameterHolder from "@templateCore/object/holder/TouchCountParameterHolder";
import Category from "@templateCore/object/Category";

export default {
    name: "DashboardSidebar",
    components: {
        PsContentContainer,
        PsLabel,
        PsLabelHeader5,
        PsButton,
        PsRouteLink,
        PsIcon,
        CategoryHorizontalItem,
        CategoryHorizontalSkeletorItem,
        CategorySidebarItem,
    },
    props: {
        limit: {
            type: Number,
            default: 100,
        },
        showSubCat: {
            type: Boolean,
            default: true,
        },
    },

    setup(props) {
        const categoriesData = ref(null);
        // const categoriesData = reactive<PsResource<Category[]>>(new PsResource());

        const subCategoriesData = ref([]);

        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const showSidebar = ref(false);
        const scrollPosition = ref(0);

        //touch count
        const touchCountStore = useTouchCountStoreState();
        const touchCountHolder = new TouchCountParameterHolder();
        touchCountHolder.typeName = "category";
        touchCountHolder.userId = loginUserId;

        //category
        const categoryStore = useCategoryStoreState("dashboard");
        categoryStore.limit = props.limit;
        categoryStore.paramHolder.keyword = "";
        categoryStore.paramHolder.orderType = "asc";
        categoryStore.paramHolder.orderBy = "name";

        async function loadCategories() {
            const response =
                await categoryStore.loadCategorieswithSubCategories(
                    loginUserId,
                    categoryStore.paramHolder
                );
            let categories = response.data.map(category => {
                category.catName = trans(category.catName);
                // console.log(category.catName);
                category.subCategories = category.subCategories.map(subcategory => {
                    subcategory.name = trans(subcategory.name);
                    return subcategory;
                })
                category.subCategories.sort((a, b) => {
                    return a.name.localeCompare(b.name);
                });
                return category;
            });

            categories.sort((a, b) => {
                return a.catName.localeCompare(b.catName);
            });

            categoriesData.value = categories;
        }

        function updateCategoryTouchCount(catId) {
            touchCountHolder.typeId = catId;
            touchCountStore.postTouchCount(loginUserId, touchCountHolder);
            //showSidebar.value = false;
        }

        const toggleSidebar = () => {
            showSidebar.value = !showSidebar.value;
        };

        const handleSidebarScroll = (event) => {
            // Get the scroll position
            const scrollTop = event.target.scrollTop;
            scrollPosition.value = scrollTop;
        };

        // onMounted(() => {
        //     // categoryStore.resetCategoryList(
        //     //     loginUserId,
        //     //     categoryStore.paramHolder
        //     // );
        //     console.log("here");
        //     loadCategories();
        //     // console.log("categoryStore", categoryStore.itemList);

        // });
        onMounted(async () => {
            //console.log("insidemounted", props.category.catId);
            loadCategories();
            document.addEventListener("scroll", handleSidebarScroll);
        });

        onUnmounted(() => {
            document.removeEventListener("scroll", handleScroll);
        });

        return {
            showSidebar,
            categoryStore,
            updateCategoryTouchCount,
            toggleSidebar,
            // getSubcategories,
            handleSidebarScroll,
            scrollPosition,
            loadCategories,
            categoriesData,
        };
    },
};
</script>
