<template>
    <Head :title="$t('chat__title')" />
    <ps-content-container class="h-screen">
        <template #content>
            <div class="relative flex flex-col" style="height: 90vh">
                <div class="lg:mt-32 mt-28 h-48 flex flex-col">
                    <ps-breadcrumb-2 :items="breadcrumb"></ps-breadcrumb-2>
                    <div
                        class="flex flex-wrap items-center mb-2 mt-2 p-2 bg-feAchromatic-50 rounded dark:bg-feAchromatic-900"
                    >
                        <ps-route-link
                            :to="{
                                name: 'fe_other_profile',
                                query: { userId: userStore.user?.data?.userId },
                            }"
                            class="w-16"
                        >
                            <div
                                class="flex flex-row content-end items-center cursor-pointer"
                            >
                                <img
                                    alt="Placeholder"
                                    width="300px"
                                    height="200px"
                                    class="w-12 h-12 object-cover bg-feAchromatic-50 rounded-full me-2"
                                    v-lazy="{
                                        src:
                                            $page.props.thumb1xUrl +
                                            '/' +
                                            userStore.user?.data
                                                ?.userCoverPhoto,
                                        loading:
                                            $page.props.sysImageUrl +
                                            '/loading_gif.gif',
                                        error:
                                            $page.props.sysImageUrl +
                                            '/default_photo.png',
                                    }"
                                />
                            </div>
                        </ps-route-link>

                        <div class="grow">
                            <ps-label class="font-medium text-base">
                                {{ userStore.user?.data?.userName }}
                            </ps-label>
                            <div
                                v-if="isOtherUserOnline"
                                class="flex flex-row items-center"
                            >
                                <ps-icon
                                    name="dot"
                                    w="10"
                                    h="10"
                                    class="text-feSuccess-300 me-2"
                                >
                                </ps-icon>
                                <ps-label> {{ $t("chat__online") }} </ps-label>
                            </div>
                            <div v-else class="flex flex-row items-center">
                                <ps-icon
                                    name="dot"
                                    w="10"
                                    h="10"
                                    class="text-feAchromatic-300 me-2"
                                >
                                </ps-icon>
                                <ps-label> {{ $t("chat__offline") }} </ps-label>
                            </div>
                        </div>
                        <div class="w-52"></div>
                    </div>
                    <div
                        v-if="dataReady"
                        class="flex sm:flex-row justify-between bg-feAchromatic-50 p-2 rounded dark:bg-feAchromatic-900"
                    >
                        <ps-route-link
                            :to="{
                                name: 'fe_item_detail',
                                query: { item_id: itemId },
                            }"
                        >
                            <div class="flex flex-row cursor-pointer">
                                <img
                                    alt="Placeholder"
                                    class="w-24 h-16 object-cover bg-feAchromatic-50 rounded-md"
                                    v-lazy="{
                                        src:
                                            $page.props.thumb2xUrl +
                                            '/' +
                                            itemImageName,
                                        loading:
                                            $page.props.sysImageUrl +
                                            '/loading_gif.gif',
                                        error:
                                            $page.props.sysImageUrl +
                                            '/default_photo.png',
                                    }"
                                />
                            </div>
                        </ps-route-link>

                        <div
                            class="grow grid grid-col-4 sm:flex sm:justify-between ms-4"
                        >
                            <div class="col-span-2">
                                <ps-label
                                    textColor="font-semibold text-fePrimary-500"
                                    class="text-xs sm:text-xl"
                                >
                                    {{ itemName }}
                                </ps-label>
                                <ps-label class="font-normal text-lg">
                                    {{ itemCategory }}
                                </ps-label>
                                <ps-label
                                    class="font-normal text-xs"
                                    textColor="text-feAchromatic-500"
                                >
                                    {{ currency }} {{ formatPrice(itemPrice) }}
                                </ps-label>
                            </div>
                            <div
                                class="col-span-2 sm:hidden flex items-center justify-end"
                            >
                                <ps-route-link
                                    :to="{
                                        name: 'fe_item_detail',
                                        query: { item_id: itemId },
                                    }"
                                    class="block sm:hidden"
                                >
                                    <ps-icon name="doubleRightArrow"></ps-icon>
                                </ps-route-link>
                            </div>

                            <div class="col-span-4 flex items-center me-2">
                                <!-- <ps-button
                                    :class="isSoldOut == '1' ? '' : 'hidden'"
                                    class="h-[20px] sm:h-[28px]"
                                    rounded="rounded"
                                    :hover="false"
                                    >{{ $t("chat__mark_sold_out") }}</ps-button
                                > -->
                                <ps-route-link
                                    :to="{
                                        name: 'fe_item_detail',
                                        query: { item_id: itemId },
                                    }"
                                    class="hidden sm:block"
                                >
                                    <ps-icon name="doubleRightArrow"></ps-icon>
                                </ps-route-link>
                            </div>
                        </div>
                    </div>
                </div>

                <!------------------------------------------------------------ <ps-line class="mt-2"/> ---------------------------------------------------->
                <div
                    ref="messages"
                    v-on:scroll="handleScroll"
                    id="messages"
                    class="px-4 flex flex-col-reverse overflow-y-auto mt-14 sm:mt-3 h-full scrolling-touch"
                >
                    <div v-for="chat in chats.data" :key="chat.id ?? ''">
                        <div
                            class="chat"
                            v-if="chat.message != '' && chat.message != null"
                        >
                            <!---------------------------------- IF CHAT TYPE IS CHAT_TYPE_DATE ------------------------------------------------->
                            <div v-if="chat.type == PsConst.CHAT_TYPE_DATE">
                                <div class="flex w-full justify-center">
                                    <span
                                        class="px-4 py-2 mt-2 mb-1 rounded-lg inline-block font-medium"
                                    >
                                        <ps-label>
                                            {{ chat.message }}
                                        </ps-label>
                                    </span>
                                </div>
                            </div>
                            <!---------------------------------- IF CHAT TYPE IS TEXT ------------------------------------------------->
                            <div
                                v-else-if="chat.type == PsConst.CHAT_TYPE_TEXT"
                            >
                                <div>
                                    <!-- Send by me UI -->
                                    <div
                                        v-if="chat.sendByUserId == loginUserId"
                                        class="w-full flex justify-end ps-1/3 flex-row items-end"
                                    >
                                        <div class="">
                                            <!-- <ps-label-caption-2
                                                @click="
                                                    showDeleteDropDown(chat.id)
                                                "
                                                :class="
                                                    deleteChatId == chat.id
                                                        ? ''
                                                        : 'del'
                                                "
                                                class="cursor-pointer rounded float-right"
                                                textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400"
                                            >
                                                <ps-icon
                                                    name="verticalThreeDot"
                                                    class="text-feAchromatic-50Dark"
                                                ></ps-icon>
                                            </ps-label-caption-2> -->
                                            <!-- <div class="relative">
                                                <div
                                                    @click="deleteConfirm(chat)"
                                                    class="bg-feAchromatic-50 shadow-sm relative top-4 right-2 px-1 rounded border transform cursor-pointer text-sm dark:bg-feAchromatic-900 dark:text-feAchromatic-50"
                                                    v-if="
                                                        deleteChatId == chat.id
                                                    "
                                                >
                                                    {{
                                                        $t(
                                                            "chat__delete_messages"
                                                        )
                                                    }}
                                                </div>
                                            </div> -->
                                            <ps-label
                                                class="me-2 mb-1 text-xs font-normal"
                                                textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400"
                                            >
                                                {{ chat.timeString }}
                                            </ps-label>
                                        </div>
                                        <span
                                            class="p-4 mt-2 mb-1 rounded-md inline-block rounded-bl-none bg-feSecondary-100 dark:bg-feAchromatic-800"
                                        >
                                            <ps-label class="text-sm">
                                                {{ chat.message }}
                                            </ps-label>
                                        </span>
                                    </div>
                                    <!-- Receive Message UI -->
                                    <div
                                        v-else
                                        class="pe-1/3 flex flex-row items-end"
                                    >
                                        <span
                                            class="p-4 mt-2 mb-1 rounded-md inline-block rounded-br-none bg-fePrimary-500"
                                        >
                                            <ps-label
                                                textColor="text-feAchromatic-50"
                                                class="text-sm"
                                            >
                                                {{ chat.message }}
                                            </ps-label>
                                        </span>
                                        <ps-label
                                            class="ms-2 mb-1 text-xs font-normal"
                                            textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400"
                                        >
                                            {{ chat.timeString }}
                                        </ps-label>
                                    </div>
                                </div>
                            </div>
                            <!---------------------------------- IF CHAT TYPE IS CHAT_TYPE_IMAGE -------------------------------------------------->
                            <div
                                v-else-if="chat.type == PsConst.CHAT_TYPE_IMAGE"
                            >
                                <!-- Send by me -->
                                <div
                                    v-if="chat.sendByUserId == loginUserId"
                                    class="w-full flex justify-end ps-1/3 flex-row items-end h-48 mt-4"
                                >
                                    <div class="relative">
                                        <!-- <ps-label-caption-2
                                            @click="showDeleteDropDown(chat.id)"
                                            :class="
                                                deleteChatId == chat.id
                                                    ? ''
                                                    : 'del'
                                            "
                                            class="cursor-pointer rounded float-right"
                                            textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400"
                                        >
                                            <ps-icon
                                                name="verticalThreeDot"
                                                class="text-feAchromatic-50Dark"
                                            ></ps-icon>
                                        </ps-label-caption-2> -->

                                        <!-- <div v-if="deleteChatId == chat.id"></div> -->

                                        <!-- <div
                                            @click="
                                                deleteConfirm(
                                                    chat,
                                                    chat.message
                                                )
                                            "
                                            class="bg-feAchromatic-50 shadow-sm absolute top-4 right-2 p-1 rounded border cursor-pointer transform"
                                            v-if="deleteChatId == chat.id"
                                        >
                                            {{ $t("chat__delete_messages") }}
                                        </div> -->

                                        <ps-label
                                            class="me-2 mb-1 text-xs font-normal"
                                            textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400"
                                        >
                                            {{ chat.timeString }}
                                        </ps-label>
                                    </div>
                                    <img
                                        @click="imageView(chat.message)"
                                        width="300px"
                                        height="200px"
                                        alt="Placeholder"
                                        class="cursor-pointer w-auto h-48 p-2 object-cover rounded-md"
                                        v-lazy="{
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
                                        }"
                                    />
                                </div>

                                <!-- Receive -->
                                <div
                                    v-else
                                    class="pe-1/3 flex flex-row items-end h-48 mt-4"
                                >
                                    <img
                                        @click="imageView(chat.message)"
                                        width="300px"
                                        height="200px"
                                        alt="Placeholder"
                                        class="cursor-pointer w-auto h-48 p-2 object-cover rounded-md"
                                        v-lazy="{
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
                                        }"
                                    />
                                    <ps-label
                                        class="me-2 mb-1 text-xs font-normal"
                                        textColor="text-feAchromatic-50Dark dark:text-feAchromatic-400"
                                    >
                                        {{ chat.timeString }}
                                    </ps-label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Send Message -->
                <div class="mt-2 mb-0 sm:mb-0 absolute inset-y-full w-full">
                    <div class="relative flex pt-1 w-full">
                        <div class="grow relative">
                            <ps-input
                                v-bind:placeholder="$t('chat__type_message')"
                                @keyup.enter="
                                    sendNormalMessage(inputMessageController)
                                "
                                v-model:value="inputMessageController"
                                class="mt-1"
                                theme="form-input dark:bg-feAchromatic-800 text-feSecondary-500 dark:text-feAchromatic-50"
                            />

                            <button
                                type="button"
                                @click.prevent="
                                    sendNormalMessage(inputMessageController)
                                "
                                class="absolute right-3 top-3"
                            >
                                <ps-icon
                                    name="send"
                                    textColor="text-fePrimary-500 dark:text-fePrimary-500"
                                ></ps-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ps-content-container>

    <ps-loading-dialog ref="ps_loading_dialog" />
    <ps-confirm-dialog-2 ref="ps_confirm_dialog" />
    <ps-error-dialog ref="ps_error_dialog" />
    <ps-success-dialog ref="ps_success_dialog" />
    <chat-image-detail ref="chat_image" />
    <ps-message-error-dialog ref="ps_message_error_dialog" />
    <ps-message-dialog ref="ps_message_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import firebaseApp from "firebase/app";
import "firebase/auth";
import "firebase/database";
import { onMounted, onUnmounted, reactive, ref, watch } from "vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsLine from "@template1/vendor/components/core/line/PsLine.vue";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsDropdown from "@template1/vendor/components/core/dropdown/PsDropdown.vue";
import format from "number-format.js";
// import { useRoute } from 'vue-router'
import PsUtils from "@templateCore/utils/PsUtils";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLabelTitle3 from "@template1/vendor/components/core/label/PsLabelTitle3.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsLabelCaption2 from "@template1/vendor/components/core/label/PsLabelCaption2.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import PsLoadingDialog from "@template1/vendor/components/core/dialog/PsLoadingDialog.vue";
import PsConfirmDialog2 from "@template1/vendor/components/core/dialog/PsConfirmDialog2.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialog/PsErrorDialog.vue";
import PsMessageErrorDialog from "@template1/vendor/components/core/dialog/PsMessageErrorDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialog/PsSuccessDialog.vue";
import ChatImageDetail from "@template1/vendor/components/modules/chat/ChatImageDetail.vue";
import BookingModal from "@template1/vendor/components/modules/chat/BookingModal.vue";
import { useGalleryStoreState } from "@templateCore/store/modules/gallery/GalleryStore";
import PsStatus from "@templateCore/api/common/PsStatus";
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import GetChatHistoryParameterHolder from "@templateCore/object/holder/GetChatHistoryParameterHolder";
import { useGetChatHistoryStoreState } from "@templateCore/store/modules/chat/GetChatHistoryStore";
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
import AppInfoParameterHolder from "@templateCore/object/holder/AppInfoParameterHolder";
import { useChatHistoryListStoreState } from "@templateCore/store/modules/chat/ChatHistoryListStore";
import { useOfferStoreState } from "@templateCore/store/modules/offer/OfferStore";
import ChatParameterHolder from "@templateCore/object/holder/ChatParameterHolder";
import ResetUnReadMessageHolder from "@templateCore/object/holder/ResetUnReadMessageHolder";
import ChatMessage from "@templateCore/object/ChatMessage";
import { trans } from "laravel-vue-i18n";
import { router } from "@inertiajs/vue3";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { useUserUnReadMessageStore } from "@templateCore/store/modules/chat/UserUnreadMessageStore";
import UserUnReadMessageParameterHolder from "@templateCore/object/holder/UserUnReadMessageParameterHolder";
import moment from "moment";
import UserParameterHolder from "@templateCore/object/holder/UserParameterHolder";
import PsMessageDialog from "@template1/vendor/components/core/dialog/PsMessageDialog.vue";

export default {
    name: "ChatView",
    components: {
        PsLabel,
        PsInput,
        PsLine,
        PsContentContainer,
        PsIcon,
        PsLabelTitle3,
        PsLabelCaption2,
        PsLoadingDialog,
        BookingModal,
        PsConfirmDialog2,
        PsErrorDialog,
        PsSuccessDialog,
        ChatImageDetail,
        PsRouteLink,
        PsBreadcrumb2,
        PsButton,
        PsDropdown,
        Head,
        PsMessageErrorDialog,
        PsMessageDialog,
    },
    props: ["query"],
    layout: PsFrontendLayout,

    setup(props) {
        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const dataReady = ref(false);

        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }
        const userUnreadHolder = new UserUnReadMessageParameterHolder();

        userUnreadHolder.userId = loginUserId;
        userUnreadHolder.deviceToken = localStorage.deviceToken;

        const productStore = useProductStore();
        const userunreadmsgStore = useUserUnReadMessageStore();

        // Get Data
        const buyerUserId = props.query?.buyer_user_id?.toString() ?? "";
        const sellerUserId = props.query?.seller_user_id?.toString() ?? "";
        const itemName = ref("");
        const itemCategory = ref("");
        const itemId = props.query?.item_id?.toString() ?? "";
        const itemImageName = ref("");
        let itemPrice = ref("");

        const currency = ref("");
        const chatFlag =
            props.query?.chat_flag?.toString() ?? PsConst.CHAT_FROM_BUYER;
        const isSoldOut = ref("0");

        const bidData = ref(null);
        const isShipItemClicked = ref(false);

        const appInfoParameterHolder = new AppInfoParameterHolder();
        appInfoParameterHolder.userId = loginUserId;
        const appInfoStore = usePsAppInfoStoreState();
        const isBooking = ref(false);
        if (
            appInfoStore?.appInfo?.data?.psAppSetting.SelectedChatType ==
            PsConst.CHAT_AND_APPOINTMENT
        ) {
            isBooking.value = true;
        }

        // Init Provider
        const chatHistoryProvider = useGetChatHistoryStoreState();
        const chatHistoryListStore = useChatHistoryListStoreState();
        const galleryStore = useGalleryStoreState();
        const offerProvider = useOfferStoreState();
        const chatHistoryHolder = new GetChatHistoryParameterHolder();
        const chatHolder = new ChatParameterHolder().ChatParameterHolder();
        const showOffer = ref(false);
        const resetHolder = new ResetUnReadMessageHolder();

        // Prepare Data
        const ps_loading_dialog = ref();
        const ps_confirm_dialog = ref();
        const ps_success_dialog = ref();
        const ps_error_dialog = ref();
        const ps_message_error_dialog = ref();
        const chat_image = ref();
        const image = ref();
        const isOtherUserOnline = ref(false);
        const sessionId = ref(PsUtils.sortinUserId(sellerUserId, buyerUserId));
        let dataRef = firebaseApp.database().ref("Message/" + sessionId.value);
        const chatRef = firebaseApp.database().ref("Current_Chat_With");
        const userRef = firebaseApp.database().ref("User_Presence");
        const paramHolder = new UserParameterHolder().getOtherUserData();
        const ps_message_dialog = ref();

        let otherUserId;

        let deleteChatId = ref("");

        if (sellerUserId == loginUserId) {
            otherUserId = buyerUserId;
        } else {
            otherUserId = sellerUserId;
        }
        const userStore = useUserStore("chat");
        // Load User By ID List
        userStore.loadUser(otherUserId);

        //reset unread message
        resetHolder.itemId = itemId;
        resetHolder.buyerUserId = buyerUserId;
        resetHolder.sellerUserId = sellerUserId;
        if (chatFlag == PsConst.CHAT_FROM_SELLER) {
            resetHolder.type = PsConst.CHAT_TO_BUYER;
        } else {
            resetHolder.type = PsConst.CHAT_TO_SELLER;
        }

        // Init Refs
        const inputMessageController = ref("");
        const chats = reactive({
            data: [] as ChatMessage[],
        });

        async function loadChatHistory() {
            chatHistoryHolder.itemId = itemId;
            chatHistoryHolder.buyerUserId = buyerUserId;
            chatHistoryHolder.sellerUserId = sellerUserId;

            await chatHistoryProvider.loadChatHistory(
                chatHistoryHolder,
                loginUserId
            );
            showOffer.value = true;
            if (chatHistoryProvider.chatHistory?.data?.isOffer == "1") {
                showOffer.value = false;
            }
        }

        function handleScroll(evt) {
            if (evt.target.scrollTop < 50) {
                PsUtils.log("load more......");
            }
        }

        function getCurrentDateTimeStamp() {
            const startDate = new Date().getTime();
            return PsUtils.getTimeStampDividedByOneThousand(
                parseInt(startDate.toString(), 10)
            );
        }

        async function sendNormalMessage(message) {
            const value = inputMessageController.value.trim();

            // Regular expression patterns for email and mobile validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            // const mobilePattern = /^\d{9}$/;
            const mobilePattern = /^\+?[0-9\s\-()]{7,15}$/;
            if (emailPattern.test(value) || mobilePattern.test(value)) {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__error"),
                    trans("ps_error_dialog__personalinformation"),
                    trans("core__be_btn_ok"),
                    () => {}
                );
                //inputMessageController.value = "";
                return false;
            } else if (value == "") {
                ps_error_dialog.value.openModal(
                    trans("ps_error_dialog__error"),
                    trans("ps_error_dialog__entermessage"),
                    trans("core__be_btn_ok"),
                    () => {}
                );
                return false;
            } else {
                paramHolder.loginUserId = loginUserId;
                paramHolder.id = loginUserId;
                chatHolder.id = "";
                chatHolder.addedDateTimeStamp = getCurrentDateTimeStamp();
                chatHolder.is_blocked = false;
                chatHolder.itemId = itemId;
                chatHolder.message = inputMessageController.value;
                chatHolder.sendByUserId = loginUserId;
                chatHolder.sessionId = sessionId.value;
                chatHolder.type = PsConst.CHAT_TYPE_TEXT;

                await sendMessage(chatHolder, true);
            }
        }

        async function sendMessage(
            chatHolder: ChatParameterHolder,
            isSaveInBE = false
        ) {
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

            if (data.sellerId == null) {
                delete data["sellerId"];
            }
            const chat = {
                itemId: chatHolder.itemId,
                receiverId: otherUserId,
                sellerId: sellerId,
            };

            const chat_user_presence = {
                userId: sellerId,
                userName: "Tester",
            };

            dataRef.child(_refKey).set(data);
            chatRef.child(sellerId).set(chat);
            userRef.child(sellerId).set(chat_user_presence);

            let isUserOnlineFlag = "0"; // Default offline
            if (isOtherUserOnline.value) {
                isUserOnlineFlag = "1";
            }

            if (isSaveInBE) {
                if (chatFlag == PsConst.CHAT_FROM_SELLER) {
                    chatHistoryProvider.postChatHistory(
                        itemId,
                        buyerUserId,
                        sellerUserId,
                        PsConst.CHAT_TO_SELLER,
                        isUserOnlineFlag,
                        chatHolder.message,
                        loginUserId
                    );
                } else {
                    chatHistoryProvider.postChatHistory(
                        itemId,
                        buyerUserId,
                        sellerUserId,
                        PsConst.CHAT_TO_BUYER,
                        isUserOnlineFlag,
                        chatHolder.message,
                        loginUserId
                    );
                }
            }

            inputMessageController.value = "";

            scrollToBottom(700);
        }

        let el;
        function scrollToBottom(time) {
            setTimeout(function () {
                if (el != null) {
                    el.scrollTop = el.scrollHeight + 400;
                } else {
                    PsUtils.log("it null");
                }
            }, time);
        }

        onMounted(async () => {
            const chat_user_presence = {
                userId: loginUserId,
                userName: "Tester",
            };
            userRef.child(loginUserId).set(chat_user_presence);
            await chatHistoryListStore.resetUnreadMessageCount(
                loginUserId,
                resetHolder
            );
            userunreadmsgStore.postUserUnreadMessageCount(userUnreadHolder);
            await loadChatHistory();
            await productStore.loadItem(itemId, loginUserId);

            itemName.value = productStore.item.data?.title;
            itemCategory.value = productStore.item.data?.category?.catName;
            itemImageName.value = productStore.item.data?.defaultPhoto?.imgPath;
            itemPrice.value = productStore.item.data?.price;
            currency.value =
                productStore.item.data?.itemCurrency?.currencySymbol;
            isSoldOut.value = productStore.item.data?.isSoldOut;
            dataReady.value = true;

            window.addEventListener("scroll", handleScroll);
            el = document.getElementById("messages");
            dataRef
                .orderByChild("itemId")
                .equalTo(itemId)
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
                            isSoldOut.value = "1";
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
                    scrollToBottom(1500);

                    userRef.child(otherUserId).on("value", (snapshot) => {
                        if (snapshot.val() != null) {
                            const tmpUserId = snapshot.val().userId;
                            if (tmpUserId == otherUserId) {
                                isOtherUserOnline.value = true;
                            } else {
                                isOtherUserOnline.value = false;
                            }
                        } else {
                            isOtherUserOnline.value = false;
                        }
                    });
                });
        });

        onUnmounted(() => {
            chatRef.child(loginUserId).remove();
            userRef.child(loginUserId).remove();
            window.removeEventListener("scroll", handleScroll);
        });

        function onImageClick() {
            image.value.click();
        }

        async function onImageSelected(event) {
            const selectedFiles = event.target.files;

            if (selectedFiles && selectedFiles.length > 1) {
                PsUtils.log(selectedFiles.length);
            } else {
                let selectedFile;
                for (let i = 0; i < selectedFiles.length; i++) {
                    selectedFile = selectedFiles[i];
                }

                if (selectedFile != undefined) {
                    ps_loading_dialog.value.openModal();
                    ps_loading_dialog.value.setMessage(
                        trans("chat__uploading_image")
                    );
                    let chatImageType;
                    if (loginUserId == sellerUserId) {
                        chatImageType = PsConst.CHAT_TO_BUYER;
                    } else {
                        chatImageType = PsConst.CHAT_TO_SELLER;
                    }
                    let isUserOnlineFlag = "0";
                    if (isOtherUserOnline.value) {
                        isUserOnlineFlag = "1";
                    }
                    const returnData = await galleryStore.postChatImageUpload(
                        loginUserId,
                        sellerUserId,
                        buyerUserId,
                        itemId,
                        chatImageType,
                        isUserOnlineFlag,
                        selectedFile
                    );

                    if (returnData.status == PsStatus.SUCCESS) {
                        chatHolder.addedDateTimeStamp =
                            getCurrentDateTimeStamp();
                        chatHolder.isSold = false;
                        chatHolder.isUserBought = false;
                        chatHolder.itemId = itemId;
                        chatHolder.message = returnData.data.imgPath;
                        chatHolder.offerStatus = PsConst.CHAT_STATUS_NULL;
                        chatHolder.sendByUserId = loginUserId;
                        chatHolder.sessionId = sessionId.value;
                        chatHolder.type = PsConst.CHAT_TYPE_IMAGE;

                        await sendMessage(chatHolder, true);
                    } else {
                        PsUtils.log("error");
                    }
                    ps_loading_dialog.value.closeModal();
                }
            }
        }

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

        function formatPrice(value) {
            if (value.toString() == "0") {
                return trans("item_price__free");
            } else {
                return format("#'##0.00", value);
            }
        }

        return {
            dataReady,
            chatHistoryProvider,
            userStore,
            sellerUserId,
            handleScroll,
            chats,
            chatFlag,
            sendMessage,
            inputMessageController,
            itemName,
            itemCategory,
            itemId,
            itemImageName,
            itemPrice,
            currency,
            PsConst,
            loginUserId,
            otherUserId,
            isOtherUserOnline,
            onImageClick,
            image,
            onImageSelected,
            ps_loading_dialog,
            ps_confirm_dialog,
            offerProvider,
            sendNormalMessage,
            imageView,
            chat_image,
            ps_error_dialog,
            ps_success_dialog,
            isSoldOut,
            chatDelete,
            chatImageDelete,
            deleteChatId,
            showDeleteDropDown,
            deleteConfirm,
            moment,
            appInfoStore,
            isBooking,
            bidData,
            isShipItemClicked,
            ps_message_dialog,
            formatPrice,
            ps_message_error_dialog,
        };
    },
    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("chat__chat_list"),
                    url: route("fe_chat_list"),
                },
                {
                    label: "Chat",
                    color: "text-fePrimary-500",
                },
            ];
        },
    },
};
</script>
