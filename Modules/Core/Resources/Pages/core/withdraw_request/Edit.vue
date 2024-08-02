<template>
    <Head :title="$t('core__be_edit_withdraw')" />

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
                        >{{ $t("withdrawal_request") }}</ps-label-header-6
                    >
                </div>
                <!-- card header end -->

                <!-- card body start -->
                <div class="px-4 pt-6 dark:bg-backgroundDark">
                    <form
                        @submit.prevent="
                            handleSubmit(withdrawalrequestparameterHolder.id)
                        "
                    >
                        <div class="grid w-full sm:w-1/2 gap-6">
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("request_date") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        withdrawalrequestparameterHolder.request_date
                                    "
                                />
                            </div>

                            <!-- name-->
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("withdraw_amount") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        withdrawalrequestparameterHolder.withdraw_amount
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("package_report_user") }}
                                    {{ $t("core__user_email") }}
                                </ps-label>
                                <ps-input
                                    type="text"
                                    readonly
                                    v-model:value="
                                        withdrawalrequestparameterHolder.user_email
                                    "
                                />
                            </div>
                            <div>
                                <ps-label class="text-base"
                                    >{{ $t("Withdraw_status") }}
                                </ps-label>

                                <select
                                    class="w-full rounded px-4 py-2 text-sm shadow-sm dark:bg-secondaryDark-black placeholder-secondary-500 text-secondary-500 rounded border border-secondary-200 dark:border-secondary-700 focus:outline-none focus:ring-1 focus:ring-primary-500"
                                    ref="status"
                                    :value="form.withdraw_status"
                                    @change="handleStatusUpdation"
                                    :disabled="isStatusAccepted"
                                >
                                    <option disabled value="received">
                                        {{ $t("received") }}
                                    </option>
                                    <option value="inprocess">
                                        {{ $t("in_process") }}
                                    </option>
                                    <option value="accepted">
                                        {{ $t("accepted") }}
                                    </option>
                                    <option value="declined">
                                        {{ $t("declined") }}
                                    </option>
                                </select>
                            </div>
                            <div
                                v-if="
                                    form.withdraw_status.toLowerCase() ===
                                    'accepted'
                                "
                            >
                                <ps-button
                                    @click="handleTransfer()"
                                    textSize="text-base"
                                    type="reset"
                                    class="rounded bg-primary-500 text-white dark:text-secondaryDark-black px-7 py-2 border-none shadow-none text-sm cursor-pointer opacity-100 flex justify-center items-center font-medium"
                                    focus=""
                                    hover=""
                                    >{{ $t("transfer_money") }}</ps-button
                                >
                            </div>
                            <!-- <div v-else>
                                <ps-label class="text-base"
                                    >{{ $t("Withdraw_status") }}
                                </ps-label>

                                <select
                                    class="w-full rounded px-4 py-2 text-sm shadow-sm dark:bg-secondaryDark-black placeholder-secondary-500 text-secondary-500 rounded border border-secondary-200 dark:border-secondary-700 focus:outline-none focus:ring-1 focus:ring-primary-500"
                                    :value="form.withdraw_status"
                                >
                                    <option disabled value="accepted">
                                        {{ $t("accepted") }}
                                    </option>
                                </select>
                            </div> -->

                            <div
                                v-if="
                                    form.withdraw_status.toLowerCase() ===
                                        'inprocess' || 'accepted'
                                "
                            >
                                <ps-label class="text-base"
                                    >{{ $t("processing_date") }}
                                </ps-label>
                                <ps-input
                                    type="date"
                                    v-model:value="form.processing_date"
                                />
                            </div>

                            <!-- for role dropdown -->
                            <div
                                v-if="
                                    form.withdraw_status.toLowerCase() ===
                                    'declined'
                                "
                            >
                                <ps-label class="text-base"
                                    >{{ $t("decline_reason") }}
                                    <span class="text-feError-500">*</span>
                                </ps-label>
                                <ps-input
                                    v-model:value="form.decline_reason"
                                    :placeholder="$t('')"
                                />
                            </div>

                            <div
                                v-if="
                                    form.withdraw_status.toLowerCase() !==
                                        'requested' ||
                                    form.withdraw_status.toLowerCase() !==
                                        'accepted'
                                "
                            >
                                <ps-label class="text-base"
                                    >{{ $t("notes") }},If Any
                                </ps-label>
                                <ps-textarea
                                    rows="4"
                                    v-model:value="
                                        withdrawalrequestparameterHolder.notes
                                    "
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

import WithdrawalRequestDataHolder from "@templateCore/object/holder/WithdrawalRequestDataHolder";

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
        "withdrawRequest",
    ],
    setup(props) {
        const withdrawalrequestparameterHolder = reactive(
            new WithdrawalRequestDataHolder()
        );

        const ps_action_modal = ref();
        const ps_image_icon_modal = ref();
        const ps_danger_dialog = ref();
        let isStatusAccepted = ref(false);
        const { isEmpty, isNum, isEmail } = useValidators();

        const loading = ref(false);
        const success = ref(false);

        const withdrawRequest = ref(null);
        console.log(props.withdrawRequest[0]);
        withdrawRequest.value = props.withdrawRequest[0];

        withdrawalrequestparameterHolder.id = withdrawRequest.value.id;
        withdrawalrequestparameterHolder.user_id =
            withdrawRequest.value.user_id;
        withdrawalrequestparameterHolder.withdraw_amount =
            "Fr. " + withdrawRequest.value.withdraw_amount;

        withdrawalrequestparameterHolder.currency =
            withdrawRequest.value.currency;
        if (withdrawRequest.value.withdraw_status == "accepted") {
            isStatusAccepted = true;
        }
        withdrawalrequestparameterHolder.withdraw_status =
            withdrawRequest.value.withdraw_status;
        withdrawalrequestparameterHolder.request_date =
            withdrawRequest.value.request_date;
        withdrawalrequestparameterHolder.processing_date =
            withdrawRequest.value.processing_date;
        withdrawalrequestparameterHolder.decline_reason =
            withdrawRequest.value.decline_reason;
        withdrawalrequestparameterHolder.notes = withdrawRequest.value.notes;
        withdrawalrequestparameterHolder.user_email =
            withdrawRequest.value.user_email;
        // console.log();
        const validateEmptyInput = (
            fieldName,
            fieldValue,
            errorMessage = ""
        ) => {
            props.errors[fieldName] = !fieldValue
                ? isEmpty(fieldName, fieldValue, errorMessage)
                : "";
        };

        function handleStatusUpdation(event) {
            form.withdraw_status = event.target.value;
        }

        let form = useForm({
            notes: withdrawRequest.value.notes,
            withdraw_status: withdrawRequest.value.withdraw_status,
            decline_reason: withdrawRequest.value.decline_reason,
            processing_date: withdrawRequest.value.processing_date,
            _method: "put",
        });

        function handleSubmit(id) {
            console.log(form);
            this.$inertia.post(route("withdraw_request.update", id), form, {
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
            validateEmptyInput,
            form,
            handleSubmit,
            loading,
            success,
            ps_danger_dialog,
            ps_image_icon_modal,
            ps_action_modal,
            withdrawRequest,
            withdrawalrequestparameterHolder,
            handleStatusUpdation,
            isStatusAccepted,
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
                    label: trans("wallet_withdraw_module"),
                    url: route("withdraw_request.index"),
                },
                {
                    label: trans("core__be_edit_withdraw"),
                    color: "text-primary-500",
                },
            ];
        },
    },
    methods: {
        handleCancel() {
            this.$inertia.get(route("withdraw_request.index"));
        },
    },
});
</script>
