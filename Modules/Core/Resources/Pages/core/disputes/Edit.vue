<template>
    <Head :title="$t('core__be_edit_disputes')" />

    <ps-layout>
        <!-- breadcrumb start -->
        <ps-breadcrumb-2 :items="breadcrumb" class="mb-5 sm:mb-6 lg:mb-8" />
        <!-- breadcrumb end -->

        <ps-card class="w-full h-auto">
            <div class="rounded-xl">
                <!-- card header start -->
                <div
                    class="bg-primary-50 dark:bg-primary-900 py-2.5 ps-4 rounded-t-xl"
                >
                    <ps-label-header-6
                        textColor="text-secondary-800 dark:text-secondary-100"
                        >{{ $t("disputes_details") }}</ps-label-header-6
                    >
                </div>
                <!-- card header end -->

                <!-- card body start -->
                <div class="px-4 pt-6 dark:bg-backgroundDark">
                    <form @submit.prevent="handleSubmit(DisputesDataHolder.id)">
                        <div class="grid w-full sm:w-1/2 gap-6">
                            <!-- name-->
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_seller_name") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.sellerName
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_seller_email") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.sellerEmail
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_buyer_name") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="DisputesDataHolder.buyerName"
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_buyer_email") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.buyerEmail
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_product_name") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.productTitle
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_product_price") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.productPrice
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_bid_price") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="DisputesDataHolder.bidPrice"
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_dispute_type") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.disputeType
                                    "
                                />
                            </div>

                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_dispute_reason") }}
                                </ps-label>
                                <ps-textarea
                                    rows="4"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.disputeReason
                                    "
                                />
                            </div>
                            <div
                                v-if="
                                    DisputesDataHolder.disputeStatus ==
                                    'resolved'
                                "
                            >
                                <ps-label class="text-base"
                                    >{{ $t("disputes_dispute_status") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.disputeStatus
                                    "
                                />
                            </div>
                            <div v-else>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_dispute_status") }}
                                </ps-label>
                                <select
                                    class="w-full rounded px-4 py-2 text-sm shadow-sm dark:bg-secondaryDark-black placeholder-secondary-500 text-secondary-500 rounded border border-secondary-200 dark:border-secondary-700 focus:outline-none focus:ring-1 focus:ring-primary-500"
                                    type="text"
                                    ref="dispute_status"
                                    :value="form.dispute_status"
                                    @change="handleStatusUpdation"
                                >
                                    <option disabled value="received">
                                        {{ $t("received") }}
                                    </option>
                                    <option value="in_process">
                                        {{ $t("in_process") }}
                                    </option>
                                    <option value="rejected">
                                        {{ $t("rejected") }}
                                    </option>
                                    <option value="resolved">
                                        {{ $t("resolved") }}
                                    </option>
                                </select>
                            </div>
                            <div v-if="disputeResolved == true">
                                <ps-label class="text-base"
                                    >Dispute Refund
                                </ps-label>
                                <select
                                    class="w-full rounded px-4 py-2 text-sm shadow-sm dark:bg-secondaryDark-black placeholder-secondary-500 text-secondary-500 rounded border border-secondary-200 dark:border-secondary-700 focus:outline-none focus:ring-1 focus:ring-primary-500"
                                    type="text"
                                    ref="dispute_refund"
                                    v-model="form.dispute_refund"
                                    :value="DisputesDataHolder.disputeRefund"
                                >
                                    <option value="yes">yes</option>
                                    <option value="no">no</option>
                                </select>
                            </div>
                            <div
                                v-if="
                                    DisputesDataHolder.disputeStatus ==
                                    'resolved'
                                "
                            >
                                <ps-label class="text-base"
                                    >Dispute Refund
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        DisputesDataHolder.disputeRefund
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("disputes_dispute_notes") }}
                                </ps-label>
                                <ps-textarea
                                    rows="4"
                                    ref="dispute_status_notes"
                                    v-model:value="form.dispute_status_notes"
                                    :placeholder="$t('')"
                                />
                            </div>

                            <!-- end role -->

                            <div class="flex flex-row justify-end mb-2.5">
                                <ps-button
                                    @click="handleCancel()"
                                    textSize="text-base"
                                    type="reset"
                                    class="me-4"
                                    colors="text-primary-500"
                                    focus=""
                                    hover=""
                                    >{{ $t("core__be_btn_cancel") }}</ps-button
                                >
                                <ps-button
                                    class="transition-all duration-300 min-w-3xs"
                                    padding="px-7 py-2"
                                    rounded="rounded"
                                    hover=""
                                    focus=""
                                >
                                    <ps-loading
                                        v-if="loading"
                                        theme="border-2 border-t-2 border-text-8 border-t-primary-500"
                                        loadingSize="h-5 w-5"
                                    />
                                    <ps-icon
                                        v-if="success"
                                        name="check"
                                        w="20"
                                        h="20"
                                        class="me-1.5 transition-all duration-300"
                                    />
                                    <span
                                        v-if="success"
                                        class="transition-all duration-300"
                                        >{{ $t("core__be_btn_saved") }}</span
                                    >
                                    <span
                                        v-if="!loading && !success"
                                        class=""
                                        >{{ $t("core__be_btn_save") }}</span
                                    >
                                </ps-button>
                            </div>
                        </div>
                        <div class="grid w-full sm:w-1/2 gap-6"></div>
                    </form>
                </div>
                <!-- card body end -->
            </div>
        </ps-card>
        <ps-confirm-dialog ref="ps_confirm_dialog" />
    </ps-layout>
</template>

<script>
import { defineComponent, ref, watch, reactive } from "vue";
import PsLayout from "@/Components/PsLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import useValidators from "@/Validation/Validators";
import PsInput from "@/Components/Core/Input/PsInput.vue";
import PsInputWithRightIcon from "@/Components/Core/Input/PsInputWithRightIcon.vue";
import PsTextarea from "@/Components/Core/Textarea/PsTextarea.vue";
import PsLabel from "@/Components/Core/Label/PsLabel.vue";
import PsButton from "@/Components/Core/Buttons/PsButton.vue";
import PsLabelHeader6 from "@/Components/Core/Label/PsLabelHeader6.vue";
import PsDropdown from "@/Components/Core/Dropdown/PsDropdown.vue";
import PsDropdownSelect from "@/Components/Core/Dropdown/PsDropdownSelect.vue";
import PsIcon from "@/Components/Core/Icons/PsIcon.vue";
import PsLoading from "@/Components/Core/Loading/PsLoading.vue";
import PsCheckboxValue from "@/Components/Core/Checkbox/PsCheckboxValue.vue";
import PsBreadcrumb2 from "@/Components/Core/Breadcrumbs/PsBreadcrumb2.vue";
import PsLabelCaption from "@/Components/Core/Label/PsLabelCaption.vue";
import PsImageUpload from "@/Components/Core/Upload/PsImageUpload.vue";
import PsLabelTitle3 from "@/Components/Core/Label/PsLabelTitle3.vue";
import PsActionModal from "@/Components/Core/Modals/PsActionModal.vue";
import PsImageIconModal from "@/Components/Core/Modals/PsImageIconModal.vue";
import PsDangerDialog from "@/Components/Core/Dialog/PsDangerDialog.vue";
import { trans } from "laravel-vue-i18n";
import CheckBox from "../components/CheckBox.vue";
import PsConfirmDialog from "@/Components/Core/Dialog/PsConfirmDialog.vue";
import { getPhoneCountryCodes } from "@/Api/psApiService.js";
import DatePicker from "@/Components/Core/DateTime/DatePicker.vue";
import PsRadioValue from "@/Components/Core/Radio/PsRadioValue.vue";

import DisputeHistoryParameterHolder from "@templateCore/object/holder/DisputeHistoryParameterHolder";

export default defineComponent({
    name: "Edit",
    components: {
        Head,
        CheckBox,
        PsInput,
        PsLabel,
        PsButton,
        PsLabelHeader6,
        PsDropdown,
        PsDropdownSelect,
        PsIcon,
        PsLoading,
        PsCheckboxValue,
        PsBreadcrumb2,
        PsLabelCaption,
        PsImageUpload,
        PsLabelTitle3,
        PsActionModal,
        PsImageIconModal,
        PsDangerDialog,
        PsTextarea,
        PsConfirmDialog,
        PsInputWithRightIcon,
        DatePicker,
        PsRadioValue,
    },
    layout: PsLayout,
    props: [
        "errors",
        "coreFieldFilterSettings",
        "roles",
        "user",
        "customizeHeaders",
        "customizeDetails",
        "validation",
        "authUser",
        "disputedBid",
    ],
    setup(props) {
        const DisputesDataHolder = reactive(
            new DisputeHistoryParameterHolder()
        );

        const ps_action_modal = ref();
        const ps_image_icon_modal = ref();
        const ps_danger_dialog = ref();
        const { isEmpty, isNum, isEmail } = useValidators();

        const loading = ref(false);
        const success = ref(false);
        const disputeResolved = ref(false);

        DisputesDataHolder.id = props.disputedBid[0].id;
        DisputesDataHolder.buyerName = props.disputedBid[0].buyer_name;
        DisputesDataHolder.buyerEmail = props.disputedBid[0].buyer_email;
        DisputesDataHolder.sellerName = props.disputedBid[0].seller_name;
        DisputesDataHolder.sellerEmail = props.disputedBid[0].seller_email;

        DisputesDataHolder.bidPrice = "Fr. " + props.disputedBid[0].bid_price;
        DisputesDataHolder.productPrice =
            "Fr. " + props.disputedBid[0].product_price;
        DisputesDataHolder.productId = props.disputedBid[0].product_id;
        DisputesDataHolder.productTitle = props.disputedBid[0].product_title;
        DisputesDataHolder.bidStatus = props.disputedBid[0].bid_status;
        DisputesDataHolder.bidCommission = props.disputedBid[0].bid_commission;
        DisputesDataHolder.disputedBid = props.disputedBid[0].disputed_bid;
        DisputesDataHolder.disputeType = props.disputedBid[0].dispute_type;
        DisputesDataHolder.disputeReason = props.disputedBid[0].dispute_reason;
        DisputesDataHolder.disputeStatus = props.disputedBid[0].dispute_status;
        DisputesDataHolder.disputeStatusNotes =
            props.disputedBid[0].dispute_status_notes;
        DisputesDataHolder.DisputeImages = props.disputedBid[0].dispute_images;

        DisputesDataHolder.disputeRefund = props.disputedBid[0].dispute_refund;

        let form = useForm({
            dispute_status_notes: props.disputedBid[0].dispute_status_notes,
            dispute_status: props.disputedBid[0].dispute_status,
            dispute_refund: props.disputedBid[0].dispute_refund,
            _method: "put",
        });

        // const validateEmptyInput = (
        //     fieldName,
        //     fieldValue,
        //     errorMessage = ""
        // ) => {
        //     props.errors[fieldName] = !fieldValue
        //         ? isEmpty(fieldName, fieldValue, errorMessage)
        //         : "";
        // };

        function handleStatusUpdation(event) {
            form.dispute_status = event.target.value;
            if (event.target.value == "resolved") {
                disputeResolved.value = true;
            } else {
                disputeResolved.value = false;
            }
        }

        function handleSubmit(id) {
            console.log(form);
            this.$inertia.post(route("disputes.update", id), form, {
                forceFormData: true,
                onBefore: () => {
                    loading.value = true;
                },
                onSuccess: () => {
                    loading.value = false;
                    success.value = true;
                    setTimeout(() => {
                        success.value = false;
                    }, 2000);
                },
                onError: () => {
                    loading.value = false;
                },
            });
        }

        return {
            // validateEmptyInput,
            form,
            handleSubmit,
            loading,
            success,
            disputeResolved,
            ps_danger_dialog,
            ps_image_icon_modal,
            ps_action_modal,
            DisputesDataHolder,
            handleStatusUpdation,
        };
    },

    computed: {
        breadcrumb() {
            return [
                {
                    label: trans("core__be_dashboard_label"),
                    url: route("admin.index"),
                },
                {
                    label: trans("disputes_module"),
                    url: route("disputes.index"),
                },
                {
                    label: trans("core__be_edit_disputes"),
                    color: "text-primary-500",
                },
            ];
        },
    },
    methods: {
        handleCancel() {
            this.$inertia.get(route("disputes.index"));
        },
    },
});
</script>
