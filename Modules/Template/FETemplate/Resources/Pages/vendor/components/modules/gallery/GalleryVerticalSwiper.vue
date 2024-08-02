<template>
    <div class="wrapper relative rounded-lg overflow-hidden">
    
        <div class="absolute bottom-4 left-4 z-[100] thumbnail-img single-product-thumbnail">
            <Splide class="z-[1000]"
                aria-label="The carousel with thumbnails. Selecting a thumbnail will change the main carousel"
                :options="thumbsOptions" ref="thumbs">
                <SplideSlide v-for="(gallery,index ) in galleryList" :key="gallery.imgId" class="z-[100]">
                    <div class="w-full h-full">
                        <img v-if="gallery.imgType != 'item-video-icon'" @click="clickImage(gallery,index)"
                            class="w-full h-full object-cover rounded-lg cursor-pointer" v-lazy="{
                                                            src:
                                                                $page.props.uploadUrl +
                                                                '/' +
                                                                gallery.imgPath,
                                                            loading:
                                                                $page.props.sysImageUrl +
                                                                '/loading_gif.gif',
                                                            error:
                                                                $page.props.sysImageUrl +
                                                                '/default_photo.png',
                                                        }" />
                        <img v-else class="w-full h-full object-cover rounded-lg" @click="clickImage(gallery,index)" v-lazy="{
                                                            src:
                                                                $page.props.uploadUrl +
                                                                '/' +
                                                                gallery.imgPath,
                                                            loading:
                                                                $page.props.sysImageUrl +
                                                                '/loading_gif.gif',
                                                            error:
                                                                $page.props.sysImageUrl +
                                                                '/default_photo.png',
                                                        }" />
                        <div v-if="gallery.imgType == 'item-video-icon'" @click="clickImage(gallery,index)"
                            class="w-full h-full absolute top-0 left-0 flex justify-center items-center">
                            <ps-icon textColor="text-feAchromatic-50" name="play" w="28" h="28" viewBox="0 0 96 96" />
                        </div>
                    </div>
                </SplideSlide>
            </Splide>
        </div>
        <div class="relative" v-if="selectedImageType=='item-video'">
            <video class="main_image_view w-full pl-[15%]" controls>
                <source :src="$page.props.uploadUrl + '/' + selectedImagePath" type="video/mp4">
                <source :src="$page.props.uploadUrl + '/' + selectedImagePath" type="video/ogg">
            </video>
        </div>
        <div class="relative" v-else>
            <img class="main_image_view w-full pl-[15%]" v-lazy="{
                                                            src:
                                                                $page.props.uploadUrl +
                                                                '/' +
                                                            selectedImagePath,
                                                            loading:
                                                                $page.props.sysImageUrl +
                                                                '/loading_gif.gif',
                                                            error:
                                                                $page.props.sysImageUrl +
                                                                '/default_photo.png',
                                                        }" />
        </div>
    
    </div>
    <ps-gallery-modal ref="ps_gallery_modal" />
</template>

<script lang="ts">
import { Splide, SplideSlide, Options } from "@splidejs/vue-splide";
import { defineComponent, onMounted, ref } from "vue";
import "@splidejs/vue-splide/css";

import DefaultPhoto from "@templateCore/object/DefaultPhoto";
import GalleryHorizontalItem from "@template1/vendor/components/modules/gallery/GalleryHorizontalItem.vue";
import PsGalleryModal from "./PsGalleryModal.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";

export default defineComponent({
  name: "ThumbnailsExample",

  components: {
    Splide,
    SplideSlide,
    GalleryHorizontalItem,
    PsGalleryModal,
    PsIcon,
  },

  props: {
    galleryList: {
      //item, icon
      type: Array as () => Array<DefaultPhoto>,
      default: () => [DefaultPhoto],
    },
    video: {
      //item, video
      type: Array as () => Array<DefaultPhoto>,
      default: () => [DefaultPhoto],
    },
    isLoading: {
      type: Boolean,
      default: true,
    },
  },

  setup(props) {
    // console.log("props.uploadUrl", props);
    const main = ref<InstanceType<typeof Splide>>();
    const thumbs = ref<InstanceType<typeof Splide>>();

    const mainOptions: Options = {
      height: "400px",
      type: "loop",
      perPage: 1,
      perMove: 1,
      gap: "2px",
      pagination: true,
      focus: "center",
      arrows: false,
    };

    const thumbsOptions: Options = {
      height: "300px",
      direction: "ttb",
      type: "slide",
      rewind: true,
      gap: "8px",
      pagination: false,
      fixedWidth: 68,
      fixedHeight: 68,
      cover: true,
      focus: "center",
      isNavigation: true,
      updateOnMove: true,
      arrows: false,
    };

    let clickCount = 0;
    let clickTimer: NodeJS.Timeout | null = null;
    const ps_gallery_modal = ref();
    const gallery_list = ref();
    const selectedImagePath = ref("")
    const selectedImageType = ref("")

    function openImage(activeImgPath) {
      selectedImagePath.value = activeImgPath;
    }

   async function clickImage(gallery: any, index: any) {
      if (gallery.imgType == "item-video-icon") {
        let find = await props.video.filter(item=> item.imgType == "item-video");
        selectedImagePath.value = find[0].imgPath;
        selectedImageType.value = find[0].imgType;
      } else {
        selectedImageType.value = gallery.imgType;
        selectedImagePath.value = gallery.imgPath;
      }
    }

    onMounted(() => {

      const thumbsSplide = thumbs.value?.splide;

      if (thumbsSplide) {
        main.value?.sync(thumbsSplide);
      }
      setTimeout(() => {
        //   console.log("gallery list from props",props.galleryList)
        if (props.galleryList && props.galleryList.length > 0) {
          for (let i = 0; i < props?.galleryList?.length; i++) {

            if (props.galleryList[i].imgPath !== undefined || props.galleryList[i].imgPath !== null) {
              selectedImageType.value = props.galleryList[i].imgType;
              selectedImagePath.value = props.galleryList[i].imgPath;
              break;
            }
          }
        }
      }, 5000)
    });

    return {
      main,
      thumbs,
      mainOptions,
      thumbsOptions,
      openImage,
      ps_gallery_modal,
      gallery_list,
      selectedImagePath,
      clickImage,
      selectedImageType
    };
  },
});
</script>

<style scoped>
.splide__track--nav>.splide__list>.splide__slide.is-active {
    border: none;
}

.loader {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 10px solid #4f5a84;
    border-bottom-color: transparent;
    animation: animate 1.2s linear infinite;
}

.main_image_view {
    height: auto;
    margin-left: 20px;

}
.single-product video {
    height: 360px !important;
}
.single-product .main_image_view {
    width: 80%;
     height: 360px;
}

@keyframes animate {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>