<template>
    <Head :title="$t('wallet_withdraw_module')" />
    <ps-layout>
        <!-- breadcrumb start -->
        <ps-breadcrumb-2 :items="breadcrumb" class="mb-5 sm:mb-6 lg:mb-8" />
        <!-- breadcrumb end -->

        <!-- alert banner start -->
        <ps-banner-icon
            v-if="visible"
            :visible="visible"
            :theme="
                status.flag == 'danger'
                    ? 'bg-red-500'
                    : status.flag == 'warning'
                    ? 'bg-yellow-500'
                    : 'bg-green-500'
            "
            :iconName="
                status.flag == 'danger'
                    ? 'close-circle'
                    : status.flag == 'warning'
                    ? 'alert-triangle'
                    : 'rightalert'
            "
            class="text-white mb-5 sm:mb-6 lg:mb-8"
            iconColor="white"
            >{{ status.msg }}</ps-banner-icon
        >
        <!-- alert banner end -->

        <!-- data table start -->
        <!-- <ps-table2> </ps-table2> -->

        <table class="table-auto w-full mt-2 sm:mt-2 lg:mt-5">
            <thead
                class="bg-primary-500 text-white dark:text-black text-2xl justify-content"
            >
                <th>
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("disputes_action") }}
                    </p>
                </th>
                <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("withdrawal_request_id") }}
                    </p>
                </th>
                <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("withdrawal_user_name") }}
                    </p>
                </th>
                <!-- <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("withdrawal_user_email") }}
                    </p>
                </th> -->
                <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("withdraw_amount") }}
                    </p>
                </th>
                <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("withdrawal_request_date") }}
                    </p>
                </th>
                <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("Withdraw_status") }}
                    </p>
                </th>

                <th class="truncate">
                    <p
                        class="text-sm font-medium flex text-secondary-50 dark:text-secondary-900 font-semibold my-2 ms-3 items-center"
                    >
                        {{ $t("withdrawal_notes") }}
                    </p>
                </th>
                <th></th>
            </thead>
            <tbody
                class="bg-secondary-50 divide-y divide-secondary-200 dark:bg-secondaryDark-black dark:divide-secondary-100 border-b border-t"
                v-for="request in pageData"
                :key="request.id"
            >
                <tr class="hover:bg-secondary-100 dark:hover:bg-gray-700">
                    <td class="h-11 ps-4 items-center justify-center">
                        <div class="flex flex-row">
                            <ps-button
                                @click="handleEdit(request.id)"
                                class="me-2"
                                rounded="rounded-lg"
                                colors="bg-green-400 text-white"
                                padding="p-1.5"
                                hover="hover:outline-none hover:ring hover:ring-green-100"
                                focus="focus:outline-none focus:ring focus:ring-green-200"
                            >
                                <ps-icon
                                    theme="text-white dark:text-primary-900"
                                    name="editPencil"
                                    w="16"
                                    h="16"
                                />
                            </ps-button>

                            <ps-danger-dialog ref="ps_danger_dialog" />
                        </div>
                    </td>
                    <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{ request.id }}
                        </p>
                    </td>
                    <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{ request.user_name }}
                        </p>
                    </td>
                    <!-- <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{ request.user_email }}
                        </p>
                    </td> -->
                    <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{
                                request.currency + " " + request.withdraw_amount
                            }}
                        </p>
                    </td>
                    <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{ request.request_date }}
                        </p>
                    </td>
                    <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{ request.withdraw_status }}
                        </p>
                    </td>

                    <td class="h-11 ps-4 items-center justify-center">
                        <p
                            class="text-sm font-medium text-secondary-800 text-center"
                        >
                            {{ request.notes }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end mt-5">
            <button
                @click="previousPage"
                :disabled="currentPage === 1"
                class="px-3 py-1 mr-2 bg-gray-200 rounded"
            >
                Prev
            </button>
            <template v-if="currentPage > 1">
                <button
                    @click="goToPage(currentPage - 1)"
                    class="px-3 py-1 mr-2 bg-gray-200 rounded"
                >
                    {{ currentPage - 1 }}
                </button>
            </template>
            <button
                @click="goToPage(currentPage)"
                class="px-3 py-1 mr-2 bg-green-500 text-white rounded"
            >
                {{ currentPage }}
            </button>
            <template v-if="currentPage < totalPages">
                <button
                    @click="goToPage(currentPage + 1)"
                    class="px-3 py-1 mr-2 bg-gray-200 rounded"
                >
                    {{ currentPage + 1 }}
                </button>
            </template>
            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 ml-2 bg-gray-200 rounded"
            >
                Next
            </button>
        </div>
    </ps-layout>
</template>

<script>
import { ref, defineComponent, onMounted } from "vue";
import PsLayout from "@/Components/PsLayout.vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import PsButton from "@/Components/Core/Buttons/PsButton.vue";
import PsTextButton from "@/Components/Core/Buttons/PsTextButton.vue";
import PsBannerIcon from "@/Components/Core/Banners/PsBannerIcon.vue";
import PsBreadcrumb2 from "@/Components/Core/Breadcrumbs/PsBreadcrumb2.vue";
import PsDangerDialog from "@/Components/Core/Dialog/PsDangerDialog.vue";
import PsIcon from "@/Components/Core/Icons/PsIcon.vue";
import PsDropdown from "@/Components/Core/Dropdown/PsDropdown.vue";
import PsDropdownSelect from "@/Components/Core/Dropdown/PsDropdownSelect.vue";
import Dropdown from "@/Components/Core/DropdownModal/Dropdown.vue";
import PsIconButton from "@/Components/Core/Buttons/PsIconButton.vue";
import PsLabel from "@/Components/Core/Label/PsLabel.vue";
import PsLink1 from "@/Components/Core/Link/PsLink1.vue";
import PsToggle from "@/Components/Core/Toggle/PsToggle.vue";
import PsTable2 from "@/Components/Core/Table/PsTable2.vue";
import PsRating from "@/Components/Core/Rating/PsRating.vue";
import DatePicker from "@/Components/Core/DateTime/DatePicker.vue";
import { trans } from "laravel-vue-i18n";

export default defineComponent({
    name: "Index",
    components: {
        Head,
        PsButton,
        PsTextButton,
        PsBannerIcon,
        PsBreadcrumb2,
        PsDangerDialog,
        PsIcon,
        PsDropdown,
        PsDropdownSelect,
        Dropdown,
        PsIconButton,
        PsLabel,
        PsLink1,
        PsToggle,
        PsTable2,
        PsRating,
        DatePicker,
    },
    layout: PsLayout,
    props: {
        can: Object,
        status: Object,
        withdrawRequests: Object,
        roles: Object,
        customizeHeaders: Object,
        customizeDetails: Object,
        hideShowFieldForFilterArr: Object,
        showCoreAndCustomFieldArr: Object,
        selectedRole: { type: String, default: "" },
        authUser: Object,
        usrIsVerifyBlueMark: String,
        uis: Object,
        sort_field: {
            type: String,
            default: "",
        },
        sort_order: {
            type: String,
            default: "desc",
        },
        search: String,
    },
    methods: {
        handleEdit(id) {
            this.$inertia.get(route("withdraw_request.edit", id));
        },
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
                    color: "text-primary-500",
                },
            ];
        },
    },
    setup(props) {
        const withdrawData = ref(null);
        withdrawData.value = props.withdrawRequests;

        const showFilter = ref(false);
        const clearFilter = ref(false);

        let visible = ref(false);

        let search = props.search ? ref(props.search) : ref("");
        let sort_field = props.sort_field ? ref(props.sort_field) : ref("");
        let sort_order = props.sort_order ? ref(props.sort_order) : ref("desc");
        let selected_role = props.selectedRole
            ? ref(props.selectedRole)
            : ref("");
        let selected_date = props.selectedDate
            ? ref(props.selectedDate)
            : ref("");

        const colFilterOptions = ref();
        let columns = ref();

        const ps_danger_dialog = ref();

        //   pagination

        const currentPage = ref(1);
        const perPage = ref(10);
        const totalPages = ref(0);
        const pageData = ref([]);

        const previousPage = () => {
            if (currentPage.value > 1) {
                currentPage.value--;
                dataProvider(currentPage.value);
            }
        };

        const nextPage = () => {
            if (currentPage.value < totalPages.value) {
                currentPage.value++;
                dataProvider(currentPage.value);
            }
        };

        const goToPage = (page) => {
            currentPage.value = page;
            dataProvider(page);
        };

        const dataProvider = (page) => {
            pageData.value = withdrawData.value.slice(
                (page - 1) * perPage.value,
                page * perPage.value
            );
            totalPages.value = Math.ceil(
                withdrawData.value.length / perPage.value
            );
            currentPage.value = page;
        };

        onMounted(() => {
            dataProvider(currentPage.value);
        });

        return {
            withdrawData,
            showFilter,
            clearFilter,
            columns,
            ps_danger_dialog,
            colFilterOptions,
            visible,
            selected_role,
            selected_date,
            nextPage,
            previousPage,
            goToPage,
            currentPage,
            perPage,
            totalPages,
            pageData,
        };
    },
});
</script>
<style>
td.items-center {
    justify-content: center !important;
}
th p.items-center {
    justify-content: center !important;
}
</style>
