<template>
    <Head :title="$t('profile__user_disputes')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <div class="w-full mb-6">
                    <ps-breadcrumb-2 :items="breadcrumb"></ps-breadcrumb-2>
                </div>
                <div class="flex flex-wrap m-auto min-h-full">
                    <div
                        class="w-full border border-gray-300 shadow-lg py-4 px-7 relative mb-4 rounded-md min-h-full"
                    >
                        <div class="w-full flex items-center mt-3 mb-7">
                            <p class="m-auto font-semibold text-xl">
                                {{ $t("profile__user_create_disputes") }}
                            </p>
                        </div>
                        <div class="my-4">
                            <div class="flex flex-auto mb-2">
                                <ps-label
                                    class="font-medium text-sm lg:text-base"
                                >
                                    {{ $t("dispute_form_drop_label") }}
                                </ps-label>
                                <span style="font-size: 17px; color: red"
                                    >*</span
                                >
                            </div>
                            <div class="inline-block relative w-full">
                                <select
                                    v-if="products.length > 0"
                                    :placeholder="
                                        $t(
                                            'dispute_form_items_drop_placeholder'
                                        )
                                    "
                                    class="w-full appearance-none form-select mt-1 w-60 rounded-md outline-grey-500 border-gray-300 focus:border-feSuccess-500 focus:outline-feSuccess-500"
                                    v-model="selectedProduct"
                                >
                                    <option
                                        class="focus:bg-fePrimary-500 dark:bg-feAccent-500 py-3"
                                        v-for="product in products"
                                        :key="product?.id"
                                        :value="product?.id"
                                    >
                                        {{ product?.productTitle }}
                                    </option>
                                </select>
                                <select
                                    v-else
                                    :placeholder="
                                        $t(
                                            'dispute_form_items_drop_placeholder'
                                        )
                                    "
                                    class="block appearance-none form-select w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline custom-select"
                                >
                                    <option
                                        class="focus:bg-fePrimary-500 dark:bg-feAccent-500 py-3"
                                        disabled
                                    >
                                        {{ $t("no_bidding") }}
                                    </option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                >
                                    <svg
                                        class="fill-current h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                    ></svg>
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-full grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-4 gap-4 sm:gap-3.5 lg:gap-4 my-3"
                        >
                            <div
                                class="col-span-12 md:col-start-1 sm:col-start-2 w-full"
                            >
                                <div class="flex flex-auto">
                                    <ps-label
                                        class="font-medium text-sm lg:text-base"
                                    >
                                        {{ $t("item_entry__photo_title") }}
                                    </ps-label>
                                    <span style="font-size: 17px; color: red"
                                        >*</span
                                    >
                                </div>
                            </div>
                            <div
                                class="col-span-12 md:col-start-1 sm:col-start-2 w-full"
                                v-if="galleryLoad"
                            >
                                <Dropzone
                                    :dir="'dir'"
                                    @clicked="pushImage"
                                    @removeImage="removeImage"
                                    @caption="caption"
                                    @maxfilesexceeded="maxUpload"
                                    ref="dropzone_ref"
                                    @queue-complete="queueComplete"
                                    @file-length="getFileCount"
                                    :images="''"
                                    :edit_mode="0"
                                    :item_id="0"
                                    :max_image_upload="
                                        appInfoStore?.appInfo?.data
                                            ?.psAppSetting?.maxImgUploadOfItem
                                    "
                                    :autoProcessQueue="autoProcessQueue"
                                    @newOrder="imageOrder"
                                    class="my-0"
                                />
                                <ps-label
                                    class="lg:mt-2 mt-1 w-full text-xs"
                                    textColor="text-feError-500"
                                    v-if="validation.imageStatus"
                                >
                                    {{ $t("item_entry__image_required_error") }}
                                </ps-label>
                                <ps-label
                                    class="lg:mt-2 mt-1 w-full text-xs"
                                    textColor="text-feError-500"
                                    v-if="validation.maxImgExceed"
                                >
                                    {{
                                        $t("item_entry_image_upload_exceed") +
                                        " " +
                                        appInfoStore?.appInfo?.data
                                            ?.psAppSetting?.maxImgUploadOfItem
                                    }}
                                </ps-label>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="flex flex-auto mb-2">
                                <ps-label
                                    class="font-medium text-sm lg:text-base"
                                >
                                    {{ $t("dispute_form_reason_label") }}
                                </ps-label>
                                <span style="font-size: 17px; color: red"
                                    >*</span
                                >
                            </div>
                            <ps-input
                                type="text"
                                id="reason"
                                autofocus
                                v-model:value="reason"
                                :placeholder="
                                    $t('dispute_form_reason_placeholder')
                                "
                            />
                        </div>
                        <div
                            class="mt-7 mb-4 flex items-center m-auto w-full justify-center"
                        >
                            <ps-button
                                colors="bg-feSuccess-500 text-feAchromatic-50"
                                class="py-3 px-7"
                                @click="submit()"
                            >
                                {{ $t("contact_us__submit") }}
                            </ps-button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ps-content-container>
    <ps-loading-dialog ref="ps_loading_dialog" />
    <ps-success-dialog ref="ps_success_dialog" />
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import { trans } from "laravel-vue-i18n";
import { ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import PsDropdown from "@template1/vendor/components/core/dropdown/PsDropdown.vue";
import PsDropdownSelect from "@template1/vendor/components/core/dropdown/PsDropdownSelect.vue";
import PsModal from "@template1/vendor/components/core/modals/PsModal.vue";
import PsInputWithRightIcon from "@template1/vendor/components/core/input/PsInputWithRightIcon.vue";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsTextarea from "@template1/vendor/components/core/textarea/PsTextarea.vue";
import PsLoadingDialog from "@template1/vendor/components/core/dialogs/PsLoadingDialog.vue";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsErrorDialog from "@template1/vendor/components/core/dialogs/PsErrorDialog.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialogs/PsSuccessDialog.vue";
import UserPhoneLoginVerificationModal from "@template1/vendor/components/modules/user/UserPhoneLoginVerificationModal.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLabelTitle3 from "@template1/vendor/components/core/label/PsLabelTitle3.vue";
import DatePicker from "@template1/vendor/components/core/datetime/DatePicker.vue";
import PsRadioValue2 from "@template1/vendor/components/core/radio/PsRadioValue2.vue";
import CheckBox from "@template1/vendor/components/core/checkbox/CheckBox.vue";
import PsBreadcrumb2 from "@template1/vendor/components/core/breadcrumbs/PsBreadcrumb2.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
import DisputeFormHolder from "@templateCore/object/holder/DisputeFormHolder";
import Dropzone from "@template1/vendor/components/core/dropzone/DropZone.vue";
import DisputeStore from "@templateCore/store/modules/disputes/DisputeStore.ts";
import DisputedBidsHolder from "@templateCore/object/DisputedBidsHolder.ts";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import PsConst from "@templateCore/object/constant/ps_constants";
import PsStatus from "@templateCore/api/common/PsStatus";
import { router } from "@inertiajs/vue3";
import axios from "axios";

import "firebase/auth";

export default {
    name: "Create User Disputes",
    components: {
        PsModal,
        PsContentContainer,
        PsButton,
        PsLabelHeader4,
        PsIcon,
        PsInput,
        PsTextarea,
        PsLabelTitle3,
        PsErrorDialog,
        UserPhoneLoginVerificationModal,
        PsLabel,
        PsRouteLink,
        PsLoadingDialog,
        Head,
        Dropzone,
        PsDropdownSelect,
        PsDropdown,
        PsInputWithRightIcon,
        DatePicker,
        PsRadioValue2,
        CheckBox,
        PsBreadcrumb2,
        PsSuccessDialog,
        PsStatus,
    },
    layout: PsFrontendLayout,
    setup(_, { emit }) {
        let itemId = 0;
        let gallery = ref();
        const autoProcessQueue = ref();
        const galleryLoad = ref(false);
        const appInfoStore = usePsAppInfoStoreState();
        const paramHolder = ref(new DisputeFormHolder());
        const reason = ref("");
        const dropzoneImages = ref(0);
        const queueFinish = ref(false);
        const dropzone_ref = ref();
        let itemKeyword = ref("");
        const disputedBidHolder = new DisputedBidsHolder();
        const disputeStore = DisputeStore();
        const products = ref<any>([]);
        const selectedProduct = ref<any>("");
        const dropzone_loading = ref(false);
        const ps_loading_dialog = ref();
        const ps_success_dialog = ref();
        const ps_error_dialog = ref();

        const validation = ref({
            imageStatus: false,
            maxImgExceed: false,
            reason: false,
        });

        let form = useForm({
            product_relation: {},
            images: [],
            extra_caption: [],
            item_images: {},
        });

        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();

        if (
            loginUserId == null ||
            loginUserId == "" ||
            loginUserId == PsConst.NO_LOGIN_USER
        ) {
            router.get(route("login"));
        }

        onMounted(async () => {
            let data: [any] = await disputeStore.loadProducts(loginUserId);
            // console.log("data bid list", data)
            if (data && data.length > 0) {
                // console.log("inside of if")
                await data.forEach((dispute) => {
                    if (dispute.buyerId?.toString() === loginUserId) {
                        if (dispute.disputed_bid.toLowerCase() !== "yes") {
                            products.value.push(dispute);
                        }
                    }
                });
            }
            galleryLoad.value = true;
        });

        function imageOrder(value) {
            paramHolder.value.images = value;
        }
        function pushImage(value) {
            validation.value.maxImgExceed = false;
            form.images.push(value);
        }
        function removeImage(value) {
            if (value != undefined || value != null) {
                var index = form.images.indexOf(value);
                form.images.splice(index, 1);
                axios
                    .post(route("item.removeMulti"), {
                        image: value,
                        edit_mode: 1,
                        img_parent_id: itemId,
                    })
                    .then((response) => {})
                    .catch((error) => {});
            }
            validation.value.maxImgExceed = false;
        }
        function caption(value) {
            if (itemId != 0) {
                let flag = false;
                form.extra_caption.forEach((el) => {
                    if (el.name == value.name) {
                        el.value = value.value;
                        flag = true;
                        return false;
                    }
                });
                if (!flag) {
                    form.extra_caption.push({
                        name: value.name,
                        value: value.value,
                    });
                }
            }
        }
        function queueComplete(value) {
            queueFinish.value = value;
        }
        function maxUpload() {
            validation.value.maxImgExceed = true;
        }
        function getFileCount(value) {
            dropzoneImages.value = value;
        }
        async function submit() {
            // ps_loading_dialog.value.openModal();
            let data = {
                dispute_images: dropzone_ref.value.getFiles(),
                dispute_reason: reason.value,
                dispute_type: "refund",
                bid_details_id: selectedProduct.value,
            };

            let result = await disputeStore.raiseDispute(loginUserId, data);
            if (result.status == PsStatus.ERROR) {
                ps_error_dialog.value.openModal(
                    trans("dispute_form_raised_error"),
                    result.message,
                    trans("core__be_btn_ok"),
                    () => {
                        location.reload();
                    }
                );
            } else {
                ps_success_dialog.value.openModal(
                    trans("ps_success_dialog__success"),
                    trans("dispute_form_raised"),
                    trans("core__be_btn_ok"),
                    () => {
                        location.href = "/disputes";
                    }
                );
                // showSuccessDialog(rechargestatus.message);
                //emit("isRechargeSuccessful", true);
                /// PsUtils.log("Cancel");
            }
            // console.log(result);
            // router.get(route("disputes"));
        }
        watch(queueFinish, (value) => {
            if (dropzone_loading.value == true && queueFinish.value == true) {
                ps_loading_dialog.value.closeModal();
                ps_success_dialog.value.openModal(
                    trans("ps_success_dialog__success"),
                    trans("item_upload__success_update"),
                    trans("ps_confirm_dialog__yes"),
                    () => {
                        router.get(route("dashboard"));
                    }
                );
            }
        });

        return {
            itemId,
            galleryLoad,
            pushImage,
            removeImage,
            caption,
            queueComplete,
            maxUpload,
            getFileCount,
            autoProcessQueue,
            imageOrder,
            gallery,
            appInfoStore,
            validation,
            dropzone_ref,
            reason,
            itemKeyword,
            submit,
            products,
            selectedProduct,
            ps_success_dialog,
        };
    },
    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("profile__user_disputes"),
                    url: route("fe_disputes"),
                },
                {
                    label: trans("profile__user_create_disputes"),
                    color: "text-fePrimary-500",
                },
            ];
        },
    },
};
</script>

<style scoped>
.dropzone {
    margin: 0 !important;
}
</style>
