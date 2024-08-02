<template>
    <div
        class="h-auto text-100 bg-feSecondary-900 flex flex-col justify-between"
    >
        <div
            class="lg:w-large xl:w-feLarge flex flex-col lg:justify-between xl:justify-center xl:gap-20 sm:flex-row md:flex-col lg:flex-row mx-auto mt-6"
        >
            <div class="flex sm:flex-col md:flex-row gap-10 new_block">
                <div
                    class="flex flex-col sm:grid sm:grid-cols-3 gap-10 sm:hidden md:grid md:grid-cols-2"
                >
                    <div class="flex flex-col gap-6">
                        <ps-label
                            textColor="text-feAchromatic-50"
                            class="font-semibold text-xl sm:text- 2xl"
                        >
                            <!-- {{ $t("footer__shop") }} -->
                        </ps-label>
                        <div class="flex flex-col gap-2 sm:gap-4">
                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <!-- <ps-route-link
                                    :to="{ name: 'fe_category.index' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="text-base font-normal"
                                >
                                    {{ $t("footer__categories") }}
                                </ps-route-link> -->
                                <ps-route-link
                                    :to="{ name: 'fe_terms_and_conditions' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{
                                        $t(
                                            "term_and_condition__term_and_condition"
                                        )
                                    }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                                textColor="text-feAchromatic-50"
                                textSize="font-normal text-base"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_safety_tips' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("footer__safety_tips") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                                textColor="text-feAchromatic-50"
                                textSize="font-normal text-base"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_faq' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("frequent_questions") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                                textColor="text-feAchromatic-50"
                                textSize="font-normal text-base"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_fee_and_commissions' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("fees_and_commissions") }}
                                </ps-route-link>
                            </ps-label>
                        </div>
                    </div>
                    <div class="flex flex-col gap-6 need_gap">
                        <ps-label
                            textColor="text-feAchromatic-50"
                            class="font-semibold text-xl sm:text-2xl"
                        >
                            <!-- {{ $t("footer__support") }} -->
                        </ps-label>
                        <div class="flex flex-col gap-2 sm:gap-4">
                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_contact_us_info' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("information_and_contact") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_privacy' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("legal_and_privacy") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_internal_wallet' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("internal_wallet") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_ad_types' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("ad_types") }}
                                </ps-route-link>
                            </ps-label>
                        </div>
                    </div>
                </div>
                <div
                    class="grid sm:grid-cols-3 md:grid-cols-1 gap-8 md:mx-auto"
                >
                    <div class="flex flex-col hidden sm:block md:hidden">
                        <ps-label
                            textColor="text-feAchromatic-50"
                            class="font-semibold text-xl sm:text-2xl"
                        >
                            <!-- {{ $t("footer__shop") }} -->
                        </ps-label>
                        <div class="flex flex-col gap-2 sm:gap-4 mt-6">
                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_terms_and_conditions' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{
                                        $t(
                                            "term_and_condition__term_and_condition"
                                        )
                                    }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                                textColor="text-feAchromatic-50"
                                textSize="font-normal text-base"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_safety_tips' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("footer__safety_tips") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                                textColor="text-feAchromatic-50"
                                textSize="font-normal text-base"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_faq' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("frequent_questions") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                                textColor="text-feAchromatic-50"
                                textSize="font-normal text-base"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_terms_and_conditions' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("fees_and_commissions") }}
                                </ps-route-link>
                            </ps-label>
                        </div>
                    </div>
                    <div
                        class="flex flex-col col-span-2 hidden sm:block md:hidden"
                    >
                        <ps-label
                            textColor="text-feAchromatic-50"
                            class="font-semibold text-xl sm:text-2xl"
                        >
                            <!-- {{ $t("footer__support") }} -->
                        </ps-label>
                        <div class="flex flex-col gap-2 sm:gap-4 mt-6">
                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_contact_us' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("information_and_contact") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_safety_tips' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("footer__safety_tips") }}
                                </ps-route-link>
                            </ps-label>

                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_privacy' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("legal_and_privacy") }}
                                </ps-route-link>
                            </ps-label>
                            <ps-label
                                class="font-normal text-base cursor-pointer hyphens-none ..."
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_terms_and_conditions' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{
                                        $t(
                                            "term_and_condition__term_and_condition"
                                        )
                                    }}
                                </ps-route-link>
                            </ps-label>
                            <ps-label
                                class="font-normal text-base cursor-pointer"
                            >
                                <ps-route-link
                                    :to="{ name: 'fe_faq' }"
                                    textColor="text-feAchromatic-50"
                                    textSize="font-normal text-base"
                                >
                                    {{ $t("faq_page__faq_page") }}
                                </ps-route-link>
                            </ps-label>
                        </div>
                    </div>

                    <div class="col-span-2 hidden sm:block md:hidden">
                        <div
                            class="flex flex-col items-center sm:items-start mt-8 sm:mt-0"
                        >
                            <ps-label
                                textColor="text-feAchromatic-50"
                                class="font-semibold text-xl sm:text-2xl"
                            >
                                {{ $t("footer__follow_us") }}
                            </ps-label>
                            <div class="flex items-center gap-6 mt-2.5">
                                <ps-route-link :to="{ name: 'dashboard' }">
                                    <ps-icon
                                        class="cursor-pointer"
                                        textColor="text-feAchromatic-50"
                                        name="facebook"
                                        h="20"
                                        w="20"
                                        viewBox="0 0 20 20"
                                    />
                                </ps-route-link>
                                <!-- <ps-route-link :to="{ name: 'dashboard' }">
                                    <ps-icon
                                        class="cursor-pointer"
                                        textColor="text-feAchromatic-50"
                                        name="linkedIn"
                                        h="20"
                                        w="20"
                                        viewBox="0 0 20 20"
                                    />
                                </ps-route-link> -->
                                <ps-route-link :to="{ name: 'dashboard' }">
                                    <ps-icon
                                        class="cursor-pointer"
                                        textColor="text-feAchromatic-50"
                                        name="twitter"
                                        h="20"
                                        w="20"
                                        viewBox="0 0 20 20"
                                    />
                                </ps-route-link>
                                <!-- <ps-route-link :to="{ name: 'dashboard' }">
                                    <ps-icon
                                        class="cursor-pointer"
                                        textColor="text-feAchromatic-50"
                                        name="instagram"
                                        h="20"
                                        w="20"
                                        viewBox="0 0 18 18"
                                    />
                                </ps-route-link>
                                <ps-route-link :to="{ name: 'dashboard' }">
                                    <ps-icon
                                        class="cursor-pointer"
                                        textColor="text-feAchromatic-50"
                                        name="pinterest"
                                        h="20"
                                        w="20"
                                        viewBox="0 0 20 20"
                                    />
                                </ps-route-link>
                                <ps-route-link :to="{ name: 'dashboard' }">
                                    <ps-icon
                                        class="cursor-pointer"
                                        textColor="text-feAchromatic-50"
                                        name="youtube"
                                        h="20"
                                        w="20"
                                        viewBox="0 -3 20 20"
                                    />
                                </ps-route-link> -->
                            </div>
                            <div
                                class="flex justify-center sm:justify-start gap-6 h-8 sm:h-10 mt-8 sm:mt-6"
                            >
                                <div
                                    class="w-40 h-15"
                                    v-if="
                                        appInfoStore?.appInfo?.data
                                            ?.frontendConfigSetting
                                            ?.googleSetting == '1'
                                    "
                                >
                                    <ps-link
                                        class="h-10"
                                        textColor="text-feAchromatic-50"
                                        :url="
                                            appInfoStore.appInfo.data
                                                .frontendConfigSetting
                                                .googlePlayUrl
                                        "
                                    >
                                        <img
                                            class="w-full h-full cursor-pointer object-cover"
                                            alt="goole play store"
                                            width="50px"
                                            height="50px"
                                            v-lazy="{
                                                src:
                                                    $page.props.sysImageUrl +
                                                    '/get_on_google_play_white.png',
                                                loading:
                                                    $page.props.sysImageUrl +
                                                    '/loading_gif.gif',
                                                error:
                                                    $page.props.sysImageUrl +
                                                    '/default_photo.png',
                                            }"
                                        />
                                    </ps-link>
                                </div>
                                <div
                                    class="w-40 h-15"
                                    v-if="
                                        appInfoStore?.appInfo?.data
                                            ?.frontendConfigSetting
                                            ?.appStoreSetting == '1'
                                    "
                                >
                                    <ps-link
                                        class="h-10"
                                        textColor="text-feAchromatic-50"
                                        :url="
                                            appInfoStore.appInfo.data
                                                .frontendConfigSetting
                                                .appStoreUrl
                                        "
                                    >
                                        <img
                                            class="w-full h-full cursor-pointer object-cover"
                                            alt="goole play store"
                                            width="50px"
                                            height="50px"
                                            v-lazy="{
                                                src:
                                                    $page.props.sysImageUrl +
                                                    '/get_on_apple_store_white.png',
                                                loading:
                                                    $page.props.sysImageUrl +
                                                    '/loading_gif.gif',
                                                error:
                                                    $page.props.sysImageUrl +
                                                    '/default_photo.png',
                                            }"
                                        />
                                    </ps-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-col items-center sm:items-start mt-8 sm:mt-0 md:mt-8 block sm:hidden md:flex md:flex-row md:gap-8 lg:flex-col lg:mt-0 lg:gap-10 need_lft"
            >
                <div class="">
                    <ps-label
                        textColor="text-feAchromatic-50"
                        class="font-semibold text-xl sm:text-2xl"
                    >
                        {{ $t("footer__follow_us") }}
                    </ps-label>
                    <div class="flex items-center gap-6 mt-2.5 lg:mt-4">
                        <a @click="hitFb">
                            <ps-icon
                                class="cursor-pointer"
                                textColor="text-feAchromatic-50"
                                name="facebook"
                                h="20"
                                w="20"
                                viewBox="0 0 20 20"
                            />
                        </a>
                        <!-- <ps-route-link :to="{ name: 'dashboard' }">
                            <ps-icon
                                class="cursor-pointer"
                                textColor="text-feAchromatic-50"
                                name="linkedIn"
                                h="20"
                                w="20"
                                viewBox="0 0 20 20"
                            />
                        </ps-route-link> -->
                        <a @click="hitX">
                            <ps-icon
                                class="cursor-pointer"
                                textColor="text-feAchromatic-50"
                                name="twitter"
                                h="20"
                                w="20"
                                viewBox="0 0 20 20"
                            />
                        </a>
                        <a @click="hitIn">
                            <ps-icon
                                class="cursor-pointer"
                                textColor="text-feAchromatic-50"
                                name="instagram"
                                h="20"
                                w="20"
                                viewBox="0 0 18 18"
                            />
                        </a>
                        <a @click="hitT">
                            <img
                                :src="tiktokLogo"
                                style="width: 18px"
                                height="24"
                            />
                        </a>

                        <!-- <ps-route-link :to="{ name: 'dashboard' }">
                            <ps-icon
                                class="cursor-pointer"
                                textColor="text-feAchromatic-50"
                                name="pinterest"
                                h="20"
                                w="20"
                                viewBox="0 0 20 20"
                            />
                        </ps-route-link>
                        <ps-route-link :to="{ name: 'dashboard' }">
                            <ps-icon
                                class="cursor-pointer"
                                textColor="text-feAchromatic-50"
                                name="youtube"
                                h="20"
                                w="20"
                                viewBox="0 -3 20 20"
                            />
                        </ps-route-link> -->
                    </div>
                </div>
                <div
                    class="flex justify-center sm:justify-start gap-6 h-8 sm:h-10 mt-8 sm:mt-6 lg:mt-0"
                >
                    <div
                        class="w-40 h-15.5"
                        v-if="
                            appInfoStore?.appInfo?.data?.frontendConfigSetting
                                ?.googleSetting == '1'
                        "
                    >
                        <ps-link
                            class="h-10"
                            textColor="text-feAchromatic-50"
                            :url="
                                appInfoStore.appInfo.data.frontendConfigSetting
                                    .googlePlayUrl
                            "
                        >
                            <img
                                class="w-full h-full cursor-pointer object-cover"
                                alt="goole play store"
                                width="50px"
                                height="50px"
                                v-lazy="{
                                    src:
                                        $page.props.sysImageUrl +
                                        '/get_on_google_play_white.png',
                                    loading:
                                        $page.props.sysImageUrl +
                                        '/loading_gif.gif',
                                    error:
                                        $page.props.sysImageUrl +
                                        '/default_photo.png',
                                }"
                            />
                        </ps-link>
                    </div>
                    <div
                        class="w-40 h-15.5"
                        v-if="
                            appInfoStore?.appInfo?.data?.frontendConfigSetting
                                ?.appStoreSetting == '1'
                        "
                    >
                        <ps-link
                            class="h-10"
                            textColor="text-feAchromatic-50"
                            :url="
                                appInfoStore.appInfo.data.frontendConfigSetting
                                    .appStoreUrl
                            "
                        >
                            <img
                                class="w-full h-full cursor-pointer object-cover"
                                alt="goole play store"
                                width="50px"
                                height="50px"
                                v-lazy="{
                                    src:
                                        $page.props.sysImageUrl +
                                        '/get_on_apple_store_white.png',
                                    loading:
                                        $page.props.sysImageUrl +
                                        '/loading_gif.gif',
                                    error:
                                        $page.props.sysImageUrl +
                                        '/default_photo.png',
                                }"
                            />
                        </ps-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 flex justify-center items-center mt-8 sm:mt-6">
            <ps-label
                textColor="text-feAchromatic-50"
                class="font-medium text-sm"
            >
                {{ copyRight }}
            </ps-label>
        </div>
    </div>
</template>

<script>
// Libs
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsLink from "@template1/vendor/components/core/link/PsLink.vue";
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
import PsLabelCaption from "@template1/vendor/components/core/label/PsLabelCaption.vue";
import PsIcon from "@template1/vendor/components/core/icons/PsIcon.vue";
// Holders
import ProductParameterHolder from "@templateCore/object/holder/ProductParameterHolder";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
// import PsConfig from "@template1/config/PsConfig";
import { usePsAppInfoStoreState } from "@templateCore/store/modules/appinfo/AppInfoStore";
// import AppInfoParameterHolder from '@templateCore/object/holder/AppInfoParameterHolder';
export default {
    components: {
        PsLabel,
        PsIcon,
        PsLink,
        PsRouteLink,
        PsLabelCaption,
    },
    setup() {
        const copyRight = ref("");
        // Inject Item Provider
        const psValueStore = PsValueStore();
        const locationId = ref(psValueStore.locationId);
        const versionNo = "1.0.1";

        // Inject Item Provider
        const loginUserId = psValueStore.getLoginUserId();
        const appInfoStore = usePsAppInfoStoreState();
        // const appInfoParameterHolder = new AppInfoParameterHolder();
        // appInfoParameterHolder.userId = loginUserId;
        function gotToHome() {
            router.get(route("dashboard"));
        }
        // appInfoStore.loadAppInfo(appInfoParameterHolder);

        const tiktokLogo = "/storage/MPC/uploads/tik-tok.png";
        function viewAllRecentItemList() {
            const holder =
                new ProductParameterHolder().getLatestParameterHolder();
            const params = holder.getUrlParamsAndQuery();

            router.get(route("fe_item_list", params.query));
        }

        function viewAllPopularItemList() {
            const holder =
                new ProductParameterHolder().getPopularParameterHolder();
            const params = holder.getUrlParamsAndQuery();

            // Redirect
            router.get(route("fe_item_list", params.query));
        }

        function hitT() {
            if (localStorage.getItem("activeLanguage") === "fr") {
                window.open("https://www.tiktok.com/@tinqui_suisse", "_blank");
            } else if (localStorage.getItem("activeLanguage") === "it") {
                window.open(
                    "https://www.tiktok.com/@tinqui_svizzera",
                    "_blank"
                );
            } else {
                window.open("https://www.tiktok.com/@tinqui_schweiz", "_blank");
            }
        }

        function hitIn() {
            if (localStorage.getItem("activeLanguage") === "fr") {
                window.open(
                    "https://www.instagram.com/tinqui_suisse/",
                    "_blank"
                );
            } else if (localStorage.getItem("activeLanguage") === "it") {
                window.open(
                    "https://www.instagram.com/tinqui_svizzera",
                    "_blank"
                );
            } else {
                window.open(
                    "https://www.instagram.com/tinqui_schweiz",
                    "_blank"
                );
            }
        }
        function hitFb() {
            if (localStorage.getItem("activeLanguage") === "fr") {
                window.open(
                    "https://www.facebook.com/profile.php?id=61558479545208",
                    "_blank"
                );
            } else if (localStorage.getItem("activeLanguage") === "it") {
                window.open(
                    "https://www.facebook.com/profile.php?id=61558170406044",
                    "_blank"
                );
            } else {
                window.open(
                    "https://www.facebook.com/profile.php?id=61558391590015",
                    "_blank"
                );
            }
        }
        function hitX() {
            if (localStorage.getItem("activeLanguage") === "fr") {
                window.open("https://twitter.com/Tinqui_Suisse", "_blank");
            } else if (localStorage.getItem("activeLanguage") === "it") {
                window.open("https://twitter.com/Tinqui_Svizzera", "_blank");
            } else {
                window.open("https://twitter.com/Tinqui_Schweiz", "_blank");
            }
        }

        if (localStorage.activeLanguage == "en") {
            copyRight.value =
                appInfoStore?.appInfo?.data?.frontendConfigSetting?.copyRight;
        } else if (localStorage.activeLanguage == "fr") {
            copyRight.value =
                "© droits d'auteur" +
                " " +
                new Date().getFullYear() +
                " " +
                "| Tous droits réservés";
        } else if (localStorage.activeLanguage == "de") {
            copyRight.value =
                "© Urheberrechte" +
                " " +
                new Date().getFullYear() +
                " " +
                "| Alle Rechte vorbehalten";
        } else if (localStorage.activeLanguage == "it") {
            copyRight.value =
                "© Diritto d'autore" +
                " " +
                new Date().getFullYear() +
                " " +
                "| Tutti i diritti riservati";
        }

        return {
            gotToHome,
            viewAllPopularItemList,
            viewAllRecentItemList,
            versionNo,
            // PsConfig,
            appInfoStore,
            hitFb,
            hitIn,
            hitX,
            hitT,
            tiktokLogo,
            copyRight,
        };
    },
};
</script>

<style>
@media screen and (max-width: 480px) {
    .new_block {
        display: inline-block !important;
    }
    .need_lft {
        align-items: baseline;
    }
    .flex.flex-col.gap-6.need_gap {
        margin-bottom: 40px;
    }
}
</style>
