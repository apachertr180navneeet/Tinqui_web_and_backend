<template>

  <Head :title="$t('profile__go_live')" />
  <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-18 mx-auto">



    <div class="container mx-auto p-4">
      <div class="grid md:grid-cols-1 xl:grid-cols-4 lg:grid-cols-4 justify-between gap-4 ">
        <!-- First Column: Video -->
        <div class="col-span-2 flex h-full bg-gray-900 items-center ">
          <!-- <iframe class="w-full h-full" allow="camera;microphone" :src="item.jitsiToken"></iframe> -->
          <video :srcObject="stream_object" autoplay></video>
        </div>
        <!-- Second Column: Chat -->
        <div class="col-span-2 sm:col-span-1">
          <div
            class="dark:bg-feAchromatic-900 border border-gray-300 dark:border-gray-600 rounded-lg p-6 mx-auto h-full chat-box">
            <div
              class="chat-container overflow-y-scroll h-96 scrolling-touch flex flex-col-reverse mb-3 py-3 border border-grey-600">
              <div v-for="chat in chats.data" :key="chat.id ?? ''">
                <div class="chat" v-if="chat.message != '' && chat.message != null">
                  <!---------------------------------- IF CHAT TYPE IS CHAT_TYPE_DATE ------------------------------------------------->
                  <!-- <div v-if="chat.type == PsConst.CHAT_TYPE_DATE">
                    <div class="flex w-full justify-center">
                      <span class="px-4 py-2 mt-2 mb-1 rounded-lg inline-block font-medium">
                        <ps-label>
                          {{ chat.message }}
                        </ps-label>
                      </span>
                    </div>
                  </div> -->
                  <!---------------------------------- IF CHAT TYPE IS TEXT ------------------------------------------------->
                  <div v-if="chat.type == PsConst.CHAT_TYPE_TEXT">
                    <div>
                      <!-- Send by me UI -->
                      <div v-if="chat.sendByUserId == loginUserId"
                        class="w-full flex justify-end ps-1/3 flex-row items-end">
                        <div class="">
                          <ps-label-caption-2 @click="
                            showDeleteDropDown(chat.id)
                            " :class="deleteChatId == chat.id
                              ? ''
                              : 'del'
                              " class="cursor-pointer rounded float-right"
                            textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400">
                            <ps-icon name="verticalThreeDot" class="text-feAchromatic-50Dark"></ps-icon>
                          </ps-label-caption-2>
                          <div class="relative">
                            <div @click="deleteConfirm(chat)"
                              class="bg-feAchromatic-50 shadow-sm relative top-4 right-2 px-1 rounded border transform cursor-pointer text-sm dark:bg-feAchromatic-900 dark:text-feAchromatic-50"
                              v-if="
                                deleteChatId == chat.id
                              ">
                              {{
                                $t(
                                  "chat__delete_messages"
                                )
                              }}
                            </div>
                          </div>
                          <ps-label class="me-2 mb-1 text-xs font-normal"
                            textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400">
                            {{ chat.timeString }}
                          </ps-label>
                        </div>
                        <span
                          class="p-4 mt-2 mb-1 ms-2 rounded-md inline-block rounded-bl-none bg-feSecondary-100 dark:bg-feAchromatic-800 dark:text-white">
                          <ps-label class="text-sm">
                            {{ chat.message }}
                          </ps-label>
                        </span>
                      </div>
                      <!-- Receive Message UI -->
                      <div v-else class="pe-1/3 flex flex-row items-end">
                        <span class="p-4 mt-2 mb-1 ms-2 rounded-md inline-block rounded-br-none bg-fePrimary-500">
                          <ps-label textColor="text-feAchromatic-50" class="text-sm">
                            {{ chat.message }}
                          </ps-label>
                        </span>
                        <ps-label class="ms-2 mb-1 text-xs font-normal"
                          textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400">
                          {{ chat.timeString }}
                        </ps-label>
                      </div>
                    </div>
                  </div>
                  <!---------------------------------- IF CHAT TYPE IS CHAT_TYPE_IMAGE -------------------------------------------------->
                  <div v-else-if="chat.type == PsConst.CHAT_TYPE_IMAGE">
                    <!-- Send by me -->
                    <div v-if="chat.sendByUserId == loginUserId"
                      class="w-full flex justify-end ps-1/3 flex-row items-end h-48 mt-4">
                      <div class="relative">
                        <ps-label-caption-2 @click="showDeleteDropDown(chat.id)" :class="deleteChatId == chat.id
                          ? ''
                          : 'del'
                          " class="cursor-pointer rounded float-right"
                          textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400">
                          <ps-icon name="verticalThreeDot" class="text-feAchromatic-50Dark"></ps-icon>
                        </ps-label-caption-2>

                        <!-- <div v-if="deleteChatId == chat.id"></div> -->

                        <div @click="
                          deleteConfirm(
                            chat,
                            chat.message
                          )
                          "
                          class="bg-feAchromatic-50 shadow-sm absolute top-4 right-2 p-1 rounded border cursor-pointer transform"
                          v-if="deleteChatId == chat.id">
                          {{ $t("chat__delete_messages") }}
                        </div>

                        <ps-label class="me-2 mb-1 text-xs font-normal"
                          textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400">
                          {{ chat.timeString }}
                        </ps-label>
                      </div>
                      <img @click="imageView(chat.message)" width="300px" height="200px" alt="Placeholder"
                        class="cursor-pointer w-auto h-48 p-2 object-cover rounded-md" v-lazy="{
                          src:
                            $page.props.thumb3xUrl +
                            '/' +
                            chat.message,
                          loading:
                            $page.props.sysImageUrl +
                            '/loading_gif.gif',
                          error:
                            $page.props.sysImageUrl +
                            '/default_photo.png',
                        }" />
                    </div>

                    <!-- Receive -->
                    <div v-else class="pe-1/3 flex flex-row items-end h-48 mt-4">
                      <img @click="imageView(chat.message)" width="300px" height="200px" alt="Placeholder"
                        class="cursor-pointer w-auto h-48 p-2 object-cover rounded-md" v-lazy="{
                          src:
                            $page.props.thumb3xUrl +
                            '/' +
                            chat.message,
                          loading:
                            $page.props.sysImageUrl +
                            '/loading_gif.gif',
                          error:
                            $page.props.sysImageUrl +
                            '/default_photo.png',
                        }" />
                      <ps-label class="me-2 mb-1 text-xs font-normal"
                        textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400">
                        {{ chat.timeString }}
                      </ps-label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="card_footer" class="flex flex-wrap w-full need_rp">
              <div class="w-full sm:w-8/12 md:w-8/12 lg:w-8/12 out_np">
                <ps-input v-bind:placeholder="$t('chat__type_message')" @keyup.enter="
                  sendMessage(message)
                  " v-model:value="message"
                  theme="form-input dark:bg-feAchromatic-800 text-feSecondary-500 dark:text-feAchromatic-50" />
              </div>
              <div class="w-full sm:w-4/12 md:w-4/12 lg:w-4/12 flex gap-2 custom_send">
                <button type="button" @click.prevent="sendMessage(message)"
                  class="py-2 px-2 flex justify-center items-center bg-feSuccess-500 text-white ms-2 rounded-md">
                  <span>{{ $t('core__fe_forgot_password_send') }}</span>
                  <svg class="icon fill-current text-white dark:text-white" viewBox="0 0 24 24"
                    style="width: 20px; height: 20px;">
                    <g>
                      <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </g>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-span-2 sm:col-span-1">
          <div class="md:flex-1 px-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ item?.title }}</h2>
            <div class="mb-4">
              <div class="mr-4 text-lg">
                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $t('item_entry__price') }}:</span>
                <span class="text-gray-600 dark:text-gray-300">Fr. {{ item?.price }}</span>
              </div>
              <div>
                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $t('buyerbids_win_title') }} :</span>
                <span class="text-gray-600 font-semibold dark:text-gray-300">Fr. {{ highest_bid }}</span>
              </div>
              <div class="mt-3 flex flex-wrap">
                <ps-route-link :to="{
                  name: 'fe_view_bids',
                  query: {
                    item_id: item?.id,
                  },
                }">
                  <span class="text-gray-700 text-lg font-semibold dark:text-gray-300 underline cursor-pointer">{{
                    no_of_bids }} {{
                      $t('bids_text') }}</span>
                </ps-route-link>&nbsp;|&nbsp;<span class="text-gray-700 dark:text-gray-300 text-lg font-semibold">{{
                  time_remaining }}</span>
              </div>

              <div class="mt-2">
                <span class="text-red-500 text-lg" v-if="meet_end">{{ $t('auction_ended') }}</span>
              </div>
            </div>
            <div class="mb-4" v-if="loginUserId !== seller_id">
              <button class="bg-feSuccess-500 hover:bg-feSuccess-600 text-white font-bold py-2 px-4 rounded-full w-80"
                @click.prevent="makeOffer" v-if="!meet_end && item?.isSoldOut !== '1'">
                {{ $t('place_bid_text') }}
              </button>
            </div>
            <div>
              <span class="font-bold text-gray-700 dark:text-gray-300">{{ $t('dispute_form_drop_label') }} {{
                $t('item_detail__description') }}:</span>
              <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                {{ item?.description }}
              </p>
            </div>
          </div>
        </div>
        <div v-if="!meet_end" class="col-span-2 flex gap-3 flex-wrap">
          <!-- <ps-button type="button" class="mb-2" @click="init">Start Stream</ps-button> -->
          <!-- <meter id="mic-meter" min="0" max="1" value="0" low="0.25" high="0.75" optimum="0.9"></meter> -->
          <div>
            <ps-button v-if="mic_muted" type="button" class="py-2 h-[40px] " @click="unmuteAudio">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic-fill"
                viewBox="0 0 16 16">
                <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0z" />
                <path
                  d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5" />
              </svg>
            </ps-button>
            <ps-button v-else type="button" colors="bg-red-600 hover:bg-red-700" class="py-2 h-[40px] " @click="muteAudio">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-mic-mute-fill" viewBox="0 0 16 16">
                <path
                  d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4 4 0 0 0 12 8V7a.5.5 0 0 1 1 0zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a5 5 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4m3-9v4.879L5.158 2.037A3.001 3.001 0 0 1 11 3" />
                <path d="M9.486 10.607 5 6.12V8a3 3 0 0 0 4.486 2.607m-7.84-9.253 12 12 .708-.708-12-12z" />
              </svg>
            </ps-button>
          </div>
          <div>
            <ps-button v-if="video_muted" type="button" class="py-2 h-[40px] " @click="resumeVideo">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-camera-video-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2z" />
              </svg></ps-button>
            <ps-button v-else type="button" colors="bg-red-600 hover:bg-red-700" class="py-2 h-[40px] " @click="stopVideo">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-camera-video-off-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M10.961 12.365a2 2 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272zm-10.114-9A2 2 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728zm9.746 11.925-10-14 .814-.58 10 14z" />
              </svg>
            </ps-button>
          </div>
          <ps-button type="button" colors="bg-red-600 hover:bg-red-700" class=" h-[40px] " @click="endStream">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-telephone-x-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm9.261 1.135a.5.5 0 0 1 .708 0L13 2.793l1.146-1.147a.5.5 0 0 1 .708.708L13.707 3.5l1.147 1.146a.5.5 0 0 1-.708.708L13 4.207l-1.146 1.147a.5.5 0 0 1-.708-.708L12.293 3.5l-1.147-1.146a.5.5 0 0 1 0-.708" />
            </svg>
          </ps-button>
          <br/>
          <select id="videoSource" class="w-1/3 mb-2 rounded-md border border-grey-500 outline-grey-500" :value="selectedVideoSource" v-model="selectedVideoSource">
            <option v-for="item in videoSources" :key="item.value" :value="item.value">{{
              item.label }}
            </option>
          </select>
          <select id="audioSource" class="w-1/3 mb-2 rounded-md border border-grey-500 outline-grey-500" :value="selectedAudioSource" v-model="selectedAudioSource">
            <option v-for="item in audioSources" :key="item.value" :value="item.value">{{
              item.label }}
            </option>
          </select>
        </div>

        <!-- Third Column: Detail -->

      </div>
    </div>
  </div>

  <ps-confirm-dialog-2 ref="ps_confirm_dialog" />
  <ps-loading-dialog ref="ps_loading_dialog" />
  <chat-image-detail ref="chat_image" />
  <ps-message-dialog ref="ps_message_dialog" />
  <ps-message-error-dialog ref="ps_message_error_dialog" />
  <offer-modal ref="offer_modal" :price="item?.price" :currency="'Fr.'" @submit="submitOffer" />
</template>

<script lang="ts">
import { onMounted, onUnmounted, reactive, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import AuctionItem from "@templateCore/object/AuctionItem";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import PsUtils from '../../../../../../../TemplateCore/utils/PsUtils';
import firebaseApp from "firebase/app";
import "firebase/auth";
import "firebase/database";
import PsConst from "@templateCore/object/constant/ps_constants";
import ChatMessage from "@templateCore/object/ChatMessage";
import { useGalleryStoreState } from "@templateCore/store/modules/gallery/GalleryStore";
import ChatParameterHolder from "@templateCore/object/holder/ChatParameterHolder";
import ChatImageDetail from "@template1/vendor/components/modules/chat/ChatImageDetail.vue";
import PsMessageErrorDialog from "@template1/vendor/components/core/dialog/PsMessageErrorDialog.vue";
import PsConfirmDialog2 from "@template1/vendor/components/core/dialog/PsConfirmDialog2.vue";
import { bidDetailsStoreState } from "@templateCore/store/modules/bid/bidDetailsStore";
import OfferModal from "@template1/vendor/components/modules/chat/OfferModal.vue";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsMessageDialog from "@template1/vendor/components/core/dialog/PsMessageDialog.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsIcon from "@/Components/Core/Icons/PsIcon.vue";


export default {
  name: "AuctionHost",
  components: {
    Head,
    PsInput,
    OfferModal,
    PsLoadingDialog,
    PsRouteLink,
    ChatImageDetail,
    PsConfirmDialog2,
    PsMessageDialog,
    PsMessageErrorDialog,
    PsButton,
    PsIcon
  },
  props: ["query"],
  layout: PsFrontendLayout,
  setup(props) {
    const productStore = useProductStore();
    const item: AuctionItem = ref();
    const psValueStore = new PsValueStore();
    const loginUserId = psValueStore.getLoginUserId();
    const seller_id = props.query.host_id;
    const buyer_id = loginUserId;
    const item_id = props.query.item_id;
    const bidDetails = bidDetailsStoreState();
    const no_of_bids = ref('0');
    const highest_bid = ref(0);
    const ps_loading_dialog = ref();
    const ps_message_dialog = ref();
    const offerProvider = useOfferStoreState()
    const editRef = firebaseApp.database().ref("Editable_Product/" + `edit_${props.query.item_id}`);
    const editable = ref(true)
    //chat variables ------------- ;;;

    const showOffer = ref(false);
    const message = ref("");
    const chats = reactive({
      data: [] as ChatMessage[],
    });
    const sessionId = ref(seller_id + "_auc_" + item_id);
    let dataRef = firebaseApp.database().ref("Message/" + sessionId.value);
    const chatRef = firebaseApp.database().ref("Current_Chat_With");
    const userRef = firebaseApp.database().ref("User_Presence");

    const mic_muted = ref(false);
    const video_muted = ref(false);

    const deleteChatId = ref('');
    const chat_image = ref();
    const ps_confirm_dialog = ref();
    const galleryStore = useGalleryStoreState;
    const ps_message_error_dialog = ref();
    const chatHolder = new ChatParameterHolder().ChatParameterHolder();
    const offer_modal = ref();
    const time_remaining = ref('0 m 0s');
    const meet_end = ref(false);
    let fetcher;
    const videoSources: any = ref([]);
    const audioSources: any = ref([]);
    const selectedVideoSource: any = ref();
    const selectedAudioSource: any = ref();
    const stream_object = ref(null);
    let interval;
    if (
      loginUserId == null ||
      loginUserId == "" ||
      loginUserId == PsConst.NO_LOGIN_USER
    ) {
      router.get(route("login"));
    }


    function startCountdown(diff) {
      let remainingTime = 30 * 60 * 1000 - diff;

      async function updateCountdown() {
        if (remainingTime <= 0) {
          endStream()
        } else {
          const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
          const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
          time_remaining.value = `${minutes}m ${seconds}s`;
          remainingTime -= 1000;
        }
      }

      interval = setInterval(updateCountdown, 1000);
      updateCountdown();
    }

    async function timeCounter(time) {
      const date = new Date(time);
      const now = new Date();
      const adjustedDate = new Date(date.getTime());
      const diff = now.getTime() - adjustedDate.getTime();
      if (diff <= 30 * 60 * 1000) {
        startCountdown(diff);
      } else {
        endStream()
      }
    }

    onMounted(async () => {
      await productStore.loadAuctionItem(props.query.item_id, loginUserId);
      item.value = productStore?.item?.data;
      timeCounter(productStore?.item?.data?.addedDate)
      dataRef
        .orderByChild("itemId")
        .equalTo(item_id)
        .on("value", (snapshot) => {
          chats.data = [];
          const data = [] as ChatMessage[];
          let lastDateTime = "";
          let tempShowOffer = showOffer.value;
          snapshot.forEach((doc) => {
            const item = doc.val();
            item.key = doc.key;

            if (
              item.offerStatus == PsConst.CHAT_STATUS_REJECT ||
              item.offerStatus ==
              PsConst.CHAT_STATUS_IS_USER_BOUGHT
            ) {
              tempShowOffer = true;
            } else if (
              item.offerStatus == PsConst.CHAT_STATUS_SOLD
            ) {
              tempShowOffer = false;
            } else {
              tempShowOffer = showOffer.value;
            }
            if (item != null) {
              item.dateTimeString = PsUtils.timeStampToDateString(
                item.addedDate
              );
              if (
                item.dateTimeString != null &&
                item.dateTimeString != "" &&
                item.dateTimeString.includes(" ")
              ) {
                const dateTimeArr =
                  item.dateTimeString.split(" ");
                item.dateString = dateTimeArr[0];
                item.timeString = dateTimeArr[1];

                if (
                  lastDateTime == "" ||
                  lastDateTime != item.dateString
                ) {
                  lastDateTime = item.dateString;

                  const date: any = {};
                  date.message = item.dateString;
                  date.type = PsConst.CHAT_TYPE_DATE;
                  data.push(date);
                }
              }
              let chatMessage = new ChatMessage();
              chatMessage = chatMessage.fromMap(item);

              data.push(chatMessage);
            }
          });
          showOffer.value = tempShowOffer;
          chats.data = data.reverse();
        });

      const result = await bidDetails.fetchProductBids(loginUserId, item_id);
      if (result) {
        if (result?.total_bids) {
          no_of_bids.value = result?.total_bids;
          highest_bid.value = result?.highest_bid?.bid_price;
        }
      }

      fetcher = setInterval(async () => {
        const result = await bidDetails.fetchProductBids(loginUserId, item_id);
        if (result) {
          if (result?.total_bids) {
            no_of_bids.value = result?.total_bids;
            highest_bid.value = result?.highest_bid?.bid_price;
          }
        }
      }, 5 * 1000)

      editRef.on("value", (snapshot) => {
        let data = snapshot.val();
        if (data != null) {
          editable.value = data.editable
        }
      })


      const devices = await navigator.mediaDevices.enumerateDevices();
      // console.log(devices)
      devices.forEach(device => {
        if (device.kind === 'videoinput') {
          // console.log(device)
          let source = {
            label: device.label || `Camera ${videoSources.value.length + 1}`,
            value: device.deviceId
          }
          videoSources.value.push(source);
        } else if (device.kind === 'audioinput') {
          let source = {
            label: device.label || `Microphone ${audioSources.value.length + 1}`,
            value: device.deviceId
          }
          audioSources.value.push(source);
        }
      });
      selectedVideoSource.value = videoSources.value[0].value;
      selectedAudioSource.value = audioSources.value[0].value;
      init()

    })

    onUnmounted(() => {
      clearInterval(fetcher)
    })

    function deleteConfirm(chat, fileName = "") {
      ps_confirm_dialog.value.openModal(
        trans("chat__delete_message_title"),
        trans("chat__confirm_to_delete_dialog"),
        trans("chat__remove"),
        trans("chat__cancel"),
        () => {
          if (fileName != "") {
            chatDelete(chat.id);
          } else {
            chatImageDelete(chat.id, fileName);
          }
        },
        () => {
          PsUtils.log("cancel");
          deleteChatId.value = "";
        }
      );
    }

    function imageView(image) {
      chat_image.value.openModal(image);
    }

    async function chatDelete(chatKey) {
      await dataRef.child(chatKey).remove();
    }

    async function chatImageDelete(chatKey, fileName) {
      await dataRef.child(chatKey).remove();
      galleryStore.postChatImageDelete(fileName, loginUserId);
    }

    function showDeleteDropDown(chatId) {
      if (deleteChatId.value == "") {
        deleteChatId.value = chatId ?? "";
      } else {
        deleteChatId.value = "";
      }
    }

    function getCurrentDateTimeStamp() {
      const startDate = new Date().getTime();
      return PsUtils.getTimeStampDividedByOneThousand(
        parseInt(startDate.toString(), 10)
      );
    }

    async function sendMessage() {
      const value = message.value.trim();
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const mobilePattern = /^\d{10}$/;

      if (emailPattern.test(value) || mobilePattern.test(value)) {
        ps_message_error_dialog.value.openModal()
      } else {
        chatHolder.id = "";
        chatHolder.addedDateTimeStamp = getCurrentDateTimeStamp();
        chatHolder.is_blocked = false;
        chatHolder.itemId = item_id;
        chatHolder.message = message.value;
        chatHolder.sendByUserId = loginUserId;
        chatHolder.sessionId = sessionId.value;
        chatHolder.type = PsConst.CHAT_TYPE_TEXT;

        let _refKey;
        if (chatHolder.id == "") {
          _refKey = dataRef.push().key ?? "";
        } else {
          _refKey = chatHolder.id;
        }
        const sellerId = chatHolder.sendByUserId;
        const data = {
          addedDate: chatHolder.addedDateTimeStamp,
          id: _refKey,
          itemId: chatHolder.itemId,
          message: chatHolder.message,
          sendByUserId: chatHolder.sendByUserId,
          sessionId: chatHolder.sessionId,
          type: chatHolder.type,
          sellerId: chatHolder?.sellerId || null,
        };

        message.value = "";

        if (data.sellerId == null) {
          delete data["sellerId"];
        }
        const chat = {
          itemId: chatHolder.itemId,
          receiverId: sellerId,
          sellerId: sellerId,
        };

        dataRef.child(_refKey).set(data);
        chatRef.child(sellerId).set(chat);
      }
    }

    function makeOffer() {
      offer_modal.value.openModal(highest_bid.value > 0 ? highest_bid.value : item?.value?.price, item?.value?.price);
    }

    async function submitOffer(negoPrice) {
      let comparison = highest_bid.value > 0 ? highest_bid.value : item?.value?.price
      if (Number(negoPrice) > Number(comparison)) {
        ps_loading_dialog.value.openModal();

        const currentDate = new Date().getTime();
        const DateTimestampStr =
          PsUtils.getTimeStampDividedByOneThousand(currentDate);
        let data: any = {}
        data.seller_user_id = item?.value?.addedUserId;
        data.recharge_timestamp = DateTimestampStr;
        data.product_id = item?.value?.id
        data.product_title = item?.value?.title;
        data.product_price = item?.value?.price;
        data.bid_price = negoPrice;

        const response = await offerProvider.placeBid(data, loginUserId);
        if (response.code == 200 || response.code == 201) {
          // console.log("Success")
          ps_message_dialog.value.openModal(
            trans("bid_placed_title"),
            trans("bid_placed_message"),
            trans("core_fe__ok"))
          editRef.set({ editable: false })
        }
        ps_loading_dialog.value.closeModal();
      } else {
        ps_message_dialog.value.openModal(
          trans("invalid_amount_title"),
          `${trans("invalid_amount_message")} Fr. ${highest_bid.value > 0 ? highest_bid.value : item?.value?.price}`,
          trans("core_fe__ok")
        )
      }
    }

    function messageInput(e) {
      message.value = e.target.value;
    }

    let peer;
    async function init() {
      // console.log("room id ", props.query.item_id)
      const roomId = props.query.item_id;
      const videoSource = selectedVideoSource.value
      const audioSource = selectedAudioSource.value
      const constraints = {
        video: { deviceId: videoSource ? { exact: videoSource } : undefined },
        audio: { deviceId: audioSource ? { exact: audioSource } : undefined }
      };
      try {
        await navigator.mediaDevices.getUserMedia(constraints).then((value) => {
          stream_object.value = value
        });
        peer = createPeer(roomId);
        stream_object.value.getTracks().forEach(track => peer.addTrack(track, stream_object.value));
      } catch (error) {
        // alert('Could not access media devices. Please make sure your camera and microphone are connected.');
      }
    }

    function createPeer(roomId) {
      const peer = new RTCPeerConnection({
        iceServers: [
          { urls: 'turn:54.196.181.163:3478', username: 'admin', credential: 'pass@123' },
          { urls: 'stun:54.196.181.163:3478', username: 'admin', credential: 'pass@123' }
        ]
      });
      peer.onnegotiationneeded = () => handleNegotiationNeededEvent(peer, roomId);
      peer.oniceconnectionstatechange = handleICEConnectionStateChange;
      peer.onconnectionstatechange = handleConnectionStateChange;
      return peer;
    }

    async function handleNegotiationNeededEvent(peer, roomId) {
      const offer = await peer.createOffer();
      await peer.setLocalDescription(offer);
      const payload = {
        sdp: peer.localDescription,
        roomId: roomId
      };
      try {
        const { data } = await axios.post('https://stream.codenomad.net/broadcast', payload);
        const desc = new RTCSessionDescription(data.sdp);
        await peer.setRemoteDescription(desc);
      } catch (error) {
        // alert(`Error: ${error.response.data.error}`);
      }
    }

    function handleICEConnectionStateChange() {
      switch (peer.iceConnectionState) {
        case 'disconnected':
        case 'failed':
          // alert('Your video is not streaming due to connectivity issues.');
          break;
        case 'closed':
          // alert('Connection closed.');
          break;
      }
    }

    function handleConnectionStateChange() {
      switch (peer.connectionState) {
        case 'disconnected':
        case 'failed':
          // alert('Your video is not streaming due to connectivity issues.');
          break;
        case 'closed':
          // alert('Connection closed.');
          break;
      }
    }

    function muteAudio() {
      stream_object.value.getAudioTracks().forEach(track => track.enabled = false);
      mic_muted.value = true
    }

    function unmuteAudio() {
      stream_object.value.getAudioTracks().forEach(track => track.enabled = true);
      mic_muted.value = false
    }

    function stopVideo() {
      stream_object.value.getVideoTracks().forEach(track => track.enabled = false);
      video_muted.value = true;
    }

    function resumeVideo() {
      stream_object.value.getVideoTracks().forEach(track => track.enabled = true);
      video_muted.value = false;
    }

    async function endStream() {
      console.log('Ending stream')
      const roomId = props.query.item_id;
      try {
        await axios.post('https://stream.codenomad.net/end', { roomId });
        stream_object.value = null;
        meet_end.value = true;
        peer.close();
        await productStore.updateAuctionStatus(
          item_id,
          loginUserId
        );
        clearInterval(interval);
        time_remaining.value = "0m 0s";
      } catch (error) {
        // alert(`Error: ${error.response.data.error}`);
      }
    }

    function setupMicMeter(stream) {
      const audioContext = new (window.AudioContext || window?.webkitAudioContext)();
      const mediaStreamSource = audioContext.createMediaStreamSource(stream);
      const analyser = audioContext.createAnalyser();
      analyser.fftSize = 256;
      mediaStreamSource.connect(analyser);
      const dataArray = new Uint8Array(analyser.frequencyBinCount);
      const micMeter: any = document.getElementById('mic-meter');
      function updateMeter() {
        analyser.getByteFrequencyData(dataArray);
        let values = 0;
        const length = dataArray.length;
        for (let i = 0; i < length; i++) {
          values += dataArray[i];
        }
        const average = values / length;
        micMeter.value = average / 256; // Normalizing to 0-1 range
        requestAnimationFrame(updateMeter);
      }
      updateMeter();
    }

    return {
      item,
      chats,
      PsConst,
      PsUtils,
      message,
      meet_end,
      makeOffer,
      imageView,
      no_of_bids,
      chat_image,
      submitOffer,
      highest_bid,
      offer_modal,
      loginUserId,
      seller_id,
      sendMessage,
      messageInput,
      deleteConfirm,
      time_remaining,
      ps_confirm_dialog,
      showDeleteDropDown,
      ps_loading_dialog,
      ps_message_dialog,
      ps_message_error_dialog,
      audioSources,
      videoSources,
      selectedAudioSource,
      selectedVideoSource,
      resumeVideo,
      stopVideo,
      unmuteAudio,
      muteAudio,
      init,
      stream_object,
      endStream,
      mic_muted,
      video_muted
    };
  },
  computed: {
    breadcrumb() {
      return [
        {
          label: trans("profile_label"),
          url: route("fe_profile"),
        },
        {
          label: trans("profile__user_disputes"),
          color: "text-fePrimary-500",
        },
      ];
    },
  },
};
</script>


<style scoped>
.chat-box {
  box-shadow: 0px 4.979px 29.872px rgba(0, 0, 0, 0.25);
}

.outer_frame {
  display: flex;
}

.first_frame {
  width: 50%;
}

.outer_frame iframe.w-full.h-full {
  height: 450px;
}

.outer_frame .second_frame {
  width: 25%;
}

iframe .no-header button.navbar-toggler {
  padding: 3px 5px;
}

iframe .no-header span.navbar-toggler-icon {
  width: 30px;
  height: 30px;
}

iframe .user-video.ui-dialog .ui-dialog-content .video video,
.user-video.ui-dialog .ui-dialog-content .video audio {
  height: 100% !important;
  width: 100% !important;
  object-fit: cover !important;
}

@media screen and (max-width: 767px) {

  .outer_frame {
    display: block !important;
  }

  .outer_frame iframe.w-full.h-full {
    height: 300px;
  }

  .first_frame {
    width: 100%;
  }

  .outer_frame .col-span-1 {
    margin-top: 30px;
  }

  .outer_frame .second_frame {
    width: 100%;
  }
}
</style>