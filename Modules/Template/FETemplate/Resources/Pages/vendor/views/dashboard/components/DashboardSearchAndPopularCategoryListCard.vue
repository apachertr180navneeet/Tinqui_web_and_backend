<template>
    <div class="mt-3 w-full top-banner">
        <div class="bg-feAchromatic-900 relative">
            <div
                class="w-full h-[700px] relative flex justify-center items-center"
                id="sliderContainer"
            >
                <transition name="slide">
                    <img
                        alt="Placeholder"
                        class="w-full opacity-60 banner-image"
                        :class="{ 'slide-in': sliding }"
                        v-if="sliderImage"
                        v-lazy="{
                            src: $page.props.uploadUrl + '/' + sliderImage,
                            error:
                                $page.props.sysImageUrl + '/default_photo.png',
                            lifecycle: lazyOptions.lifecycle,
                        }"
                    />
                </transition>
                <div class="pagination-dots">
                    <span
                        class="dot"
                        v-for="(dot, index) in images"
                        :key="index"
                        @click="goToImage(index)"
                        :class="{ active: currentImageIndex === index }"
                    ></span>
                </div>
            </div>

            <!-- 
                    <div
                        v-if="is_banner_loading"
                        class="opacity-60 w-full h-full flex flex-col justify-center items-center gap-10 absolute bg-gray-300"
                    >
                        <span class="loader"></span>
                        <span class="text-3xl text-gray-500 font-semibold"
                            >Loading</span
                        >
                    </div> -->

            <div
                class="absolute top-0 w-full h-full flex flex-col justify-center gap-5 sm:gap-8"
            >
                <div class="text-center">
                    <ps-label
                        class="text-xl font-semibold mb-4 sm:text-4xl xl:text-5xl"
                        textColor="text-fePrimary-50"
                        v-if="sliderTitle"
                    >
                        {{ sliderTitle }}</ps-label
                    >
                    <ps-label
                        class="text-base font-normal px-10"
                        textColor="text-fePrimary-50"
                        v-if="sliderContent"
                    >
                        {{ sliderContent }}</ps-label
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Libs
import { ref, reactive, onMounted } from "vue";
// Components
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import { useSubCategoryStoreState } from "@templateCore/store/modules/subCategory/SubCategoryStore";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import SearchForLargeScreem from "@template1/vendor/views/search/SearchForLargeScreen.vue";
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useCategoryStoreState } from "@templateCore/store/modules/category/CategoryStore";
import { useTouchCountStoreState } from "@templateCore/store/modules/category/TouchCountStore";
//Holder
import TouchCountParameterHolder from "@templateCore/object/holder/TouchCountParameterHolder";

import SubCategory from "@templateCore/object/SubCategory";
import DashboardSidebar from "./DashboardSidebar.vue";

export default {
    name: "DashboardSearchAndPopularCategoryListCard",
    components: {
        PsLabel,
        PsButton,
        PsRouteLink,
        PsIcon,
        SearchForLargeScreem,
        DashboardSidebar,
    },
    props: {
        bannerImgPath: {
            type: String,
            default: "",
        },
        limit: {
            type: Number,
            default: 12,
        },
        showSubCat: {
            type: Boolean,
            default: true,
        },
        subCategoryData: {
            type: Array,
            default: null,
        },
        // images: {
        //     type: Array,
        //     default: [
        //         "65925a262b8e4_.jpg",
        //         "slider_image_3.jpg",
        //         "65925a262b8e4_.jpg",
        //         "slider_image_3.jpg",
        //     ],
        // },
        // title: {
        //     type: Array,
        //     default: [
        //         "Live Auctions",
        //         "Direct sale at a fixed price",
        //         "Auction mode",
        //         "Featured Products",
        //     ],
        // },
        // content: {
        //     type: Array,
        //     default: [
        //         "Auction your items in real time thanks to our live video technology",
        //         "Acquire or sell your products immediately,simply and quickly without waiting",
        //         "Bid on unique items. get the products you want",
        //         "Discover our selection of featured products",
        //     ],
        // },
    },
    setup(props) {
        const sliderImage = ref("");
        const sliderTitle = ref("");
        const sliderContent = ref("");
        const sliding = ref(false);
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();

        const is_banner_loading = ref(true);
        const images = ref(null);
        const title = ref(null);
        const content = ref(null);
        function goToImage(index) {
            setCurrentImageIndex(index);
        }

        if (localStorage.activeLanguage == "fr") {
            images.value = [
                "fr_image_1.png",
                "fr_image_2.png",
                "fr_image_3.png",
                "fr_image_4.png",
                "fr_image_5.png",
                "fr_image_6.png",
                "fr_image_7.png",
            ];
        } else if (localStorage.activeLanguage == "de") {
            images.value = [
                "de_image_1.png",
                "de_image_2.png",
                "de_image_3.png",
                "de_image_4.png",
                "de_image_5.png",
                "de_image_6.png",
                "de_image_7.png",
            ];
        } else if (localStorage.activeLanguage == "it") {
            images.value = [
                "it_image_1.png",
                "it_image_2.png",
                "it_image_3.png",
                "it_image_4.png",
                "it_image_5.png",
                "it_image_6.png",
                "it_image_7.png",
            ];
        } else {
            images.value = [
                "de_image_1.png",
                "de_image_2.png",
                "de_image_3.png",
                "de_image_4.png",
                "de_image_5.png",
                "de_image_6.png",
                "de_image_7.png",
            ];
            //   content.value = [
            //     "Auction your items in real time thanks to our live video technology",
            //     "Acquire or sell your products immediately,simply and quickly without waiting",
            //     "Bid on unique items. get the products you want",
            //     "Discover our selection of featured products",
            //   ];
            //   title.value = [
            //     "Live Auctions",
            //     "Direct sale at a fixed price",
            //     "Auction mode",
            //     "Featured Products",
            //   ];
        }

        const showSubcategories = ref(false);
        const subCategoryData = ref(null);
        const lazyOptions = reactive({
            lifecycle: {
                loading: () => {
                    is_banner_loading.value = true;
                },
                error: () => {
                    is_banner_loading.value = false;
                },
                loaded: () => {
                    is_banner_loading.value = false;
                },
            },
        });

        function goToImage(index) {
            setCurrentImageIndex(index);
        }

        function setCurrentImageIndex(index) {
            currentImageIndex = index; // Update the currentImageIndex
            // You may also need to call updateImage(index) here to update other data related to the current image
        }

        //touch count
        const touchCountStore = useTouchCountStoreState();
        const touchCountHolder = new TouchCountParameterHolder();
        touchCountHolder.typeName = "category";
        touchCountHolder.userId = loginUserId;

        //category
        const popularCategoryStore = useCategoryStoreState(
            "dashboard_popular_cat"
        );

        popularCategoryStore.limit = props.limit;
        popularCategoryStore.paramHolder.keyword = "";
        popularCategoryStore.paramHolder.orderType = "desc";
        popularCategoryStore.paramHolder.orderBy = "category_touch_count";

        const subCategoryStore = useSubCategoryStoreState();
        const hoveredCategoryId = ref(null);

        function updateCategoryTouchCount(catId) {
            touchCountHolder.typeId = catId;
            touchCountStore.postTouchCount(loginUserId, touchCountHolder);
        }

        const handleMouseOver = (catId) => {
            // alert("here");
            loadSubCategories(catId);
            showSubcategories.value = true;
            hoveredCategoryId.value = catId;
        };

        const handleMouseLeave = () => {
            showSubcategories.value = false;
            hoveredCategoryId.value = null;
            subCategoryData.value = null;
        };

        async function loadSubCategories(catId) {
            const data = await subCategoryStore.getsubCategoryList(
                loginUserId,
                catId
            );
            subCategoryData.value = data.data;
            // subCategoryDataLoaded.value = true;
        }

        let currentImageIndex = 0;
        function setCurrentImageIndex(index) {
            updateImage(index);
        }

        function showNextImage() {
            // currentImageIndex = (currentImageIndex + 1) % props.images.length;
            // console.log("currentImageIndex", currentImageIndex);
            // updateImage(currentImageIndex);

            currentImageIndex = (currentImageIndex + 1) % images.value.length;
            sliding.value = true;
            setTimeout(updateImage(currentImageIndex), 3000);
        }

        function showPreviousImage() {
            currentImageIndex =
                (currentImageIndex - 1 + images.value.length) %
                images.value.length;

            sliding.value = true;
            setTimeout(updateImage(currentImageIndex), 3000);
        }
        // console.log("currentImageIndex", currentImageIndex);
        function getImageUrl(currentImageIndex) {
            // const imagePathPrefix = "/storage/MPC/uploads/";
            return images.value[currentImageIndex];
        }
        function getImageTitle(currentImageIndex) {
            // const imagePathPrefix = "/storage/MPC/uploads/";
            return title.value[currentImageIndex];
        }
        function getImageContent(currentImageIndex) {
            // const imagePathPrefix = "/storage/MPC/uploads/";
            return content.value[currentImageIndex];
        }

        function updateImage(currentImageIndex) {
            sliding.value = false;

            //   if (
            //     localStorage.activeLanguage == "en" ||
            //     localStorage.activeLanguage == "es"
            //   ) {
            //     const imageUrl = getImageUrl(currentImageIndex);
            //     sliderImage.value = imageUrl;
            //     const imageTitle = getImageTitle(currentImageIndex);
            //     const imageContent = getImageContent(currentImageIndex);
            //     sliderTitle.value = imageTitle;
            //     sliderContent.value = imageContent;
            //   } else {
            const imageUrl = getImageUrl(currentImageIndex);
            sliderImage.value = imageUrl;
            //   }

            //timer.value = setInterval(showNextImage, 8000);
        }

        onMounted(() => {
            popularCategoryStore.resetCategoryList(
                loginUserId,
                popularCategoryStore.paramHolder
            );

            updateImage(0);

            setInterval(showNextImage, 6000);
        });

        return {
            lazyOptions,
            is_banner_loading,
            popularCategoryStore,
            updateCategoryTouchCount,
            handleMouseOver,
            handleMouseLeave,
            showSubcategories,
            subCategoryData,
            hoveredCategoryId,
            showNextImage,
            showPreviousImage,
            updateImage,
            getImageUrl,
            sliderImage,
            sliderTitle,
            sliderContent,
            setCurrentImageIndex,
            sliding,
            getImageContent,
            getImageTitle,
            images,
            title,
            content,
            goToImage,
            setCurrentImageIndex,
        };
    },
};
</script>

<style scoped>
.loader {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 15px solid #4f5a84;
    border-bottom-color: transparent;
    animation: animate 1.2s linear infinite;
}

@keyframes animate {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.subcategory-pop-up-show {
    visibility: visible !important;
}

.subcategory-pop-up li:hover {
    color: green;
}

.subcategory-pop-up {
    position: relative;
    background-color: #fff;
    border: 2px solid #ccc;
    padding: 23px;
    box-shadow: 0 4px 4px #0000001a;
    z-index: 999;
    visibility: hidden;
    box-sizing: border-box;
    column-count: 3;
}

.slide-in {
    transition: left 0.3s ease;
    left: -100% !important;
    position: relative;
}

/* .slide-in-enter-active {
    transform: translateX(-100%);
}

.slide-in-leave-active {
    transform: translateX(100%);
}
#sliderContainer {
    overflow: hidden;
} */
</style>
