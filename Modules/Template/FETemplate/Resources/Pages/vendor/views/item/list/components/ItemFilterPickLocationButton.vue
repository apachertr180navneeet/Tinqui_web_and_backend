<template>
    <ps-secondary-button 
        @click="mapFilterClicked()" class="mt-4 w-full ">
        {{ $t("item_list__pick_location") }}
    </ps-secondary-button>

    <ps-loading-dialog ref="ps_loading_dialog" class='z-40' />
    <map-with-makers-modal ref="map_with_makers_modal" />
</template>

<script lang="ts">
// Libs
import { ref } from 'vue';
import Axios from 'axios';
// Components
import PsSecondaryButton from '@template1/vendor/components/core/buttons/PsSecondaryButton.vue';
import PsLoadingDialog from '@template1/vendor/components/core/dialog/PsLoadingDialog.vue';
import MapWithMakersModal from '@template1/vendor/components/layouts/map/MapWithMakersModal.vue';
// Providers
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { usePsAppInfoStoreState } from '@templateCore/store/modules/appinfo/AppInfoStore';
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
//Utils
import PsUtils from '../../../../../../../../../TemplateCore/utils/PsUtils';

export default {
    name: 'ItemFilterPickLocationButton',
    components: {
        PsSecondaryButton,
        PsLoadingDialog,
        MapWithMakersModal
    },
    setup() {
        const psValueStore = PsValueStore();
        const itemProvider = useProductStore('list');
        const appInfoStore = usePsAppInfoStoreState();
        const ps_loading_dialog = ref();
        const map_with_makers_modal = ref();

        function mapFilterClicked() {

            if (map_with_makers_modal.value.isFirstTime) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        Axios.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + position.coords.latitude + '&lon=' + position.coords.longitude,
                        ).then(async (response) => {
                            map_with_makers_modal.value.closeModal();

                            itemProvider.paramHolder.lat = await response.data.lat.toString();
                            itemProvider.paramHolder.lng = await response.data.lon.toString();

                            map_with_makers_modal.value.openModal(itemProvider.paramHolder.lat, itemProvider.paramHolder.lng, itemProvider.paramHolder.mile,
                                (lat, lng, mile) => {

                                    if (lat == null || lng == null) {
                                        return;
                                    }

                                    itemProvider.paramHolder.lat = lat;
                                    itemProvider.paramHolder.lng = lng;
                                    itemProvider.paramHolder.mile = mile;
                                    loadDataList();
                                });

                        }).catch(error => {
                            // console.log("sese1");
                            // console.log(error);
                            setDefaultLatLng();
                            map_with_makers_modal.value.openModal(itemProvider.paramHolder.lat, itemProvider.paramHolder.lng, itemProvider.paramHolder.mile,
                                (lat, lng, mile) => {

                                    if (lat == null || lng == null) {
                                        return;
                                    }

                                    itemProvider.paramHolder.lat = lat;
                                    itemProvider.paramHolder.lng = lng;
                                    itemProvider.paramHolder.mile = mile;
                                    loadDataList();
                                });

                        });
                    },
                        error => {
                            // console.log("sese");/
                            // console.log(error);
                            setDefaultLatLng();
                            map_with_makers_modal.value.openModal(itemProvider.paramHolder.lat, itemProvider.paramHolder.lng, itemProvider.paramHolder.mile,
                                (lat, lng, mile) => {

                                    if (lat == null || lng == null) {
                                        return;
                                    }

                                    itemProvider.paramHolder.lat = lat;
                                    itemProvider.paramHolder.lng = lng;
                                    itemProvider.paramHolder.mile = mile;
                                    loadDataList();
                                });

                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 7000,
                            maximumAge: 0
                        });
                } else {
                    alert("Your browser doesn't support geolocation API");
                    setDefaultLatLng();
                    map_with_makers_modal.value.openModal(itemProvider.paramHolder.lat, itemProvider.paramHolder.lng, itemProvider.paramHolder.mile,
                        (lat, lng, mile) => {

                            if (lat == null || lng == null) {
                                return;
                            }

                            itemProvider.paramHolder.lat = lat;
                            itemProvider.paramHolder.lng = lng;
                            itemProvider.paramHolder.mile = mile;
                            loadDataList();
                        });

                }
            } else {

                if (itemProvider.paramHolder.lat == null || itemProvider.paramHolder.lat == '' || itemProvider.paramHolder.lng == null || itemProvider.paramHolder.lng == '') {
                    setDefaultLatLng();
                }
                map_with_makers_modal.value.openModal(itemProvider.paramHolder.lat, itemProvider.paramHolder.lng, itemProvider.paramHolder.mile,
                    (lat, lng, mile) => {

                        if (lat == null || lng == null) {
                            return;
                        }

                        itemProvider.paramHolder.lat = lat;
                        itemProvider.paramHolder.lng = lng;
                        itemProvider.paramHolder.mile = mile;
                        loadDataList();
                    }
                );

            }

        }

        function setDefaultLatLng(){
            if (itemProvider.paramHolder.lat == null || itemProvider.paramHolder.lat == 0 || itemProvider.paramHolder.lat == undefined || 
                itemProvider.paramHolder.lng == null || itemProvider.paramHolder.lng == 0 || itemProvider.paramHolder.lng == undefined) {
                    itemProvider.paramHolder.lat = appInfoStore.appInfo.data?.psAppSetting?.latitude;
                    itemProvider.paramHolder.lng = appInfoStore.appInfo.data?.psAppSetting?.longitude;
                }
        }

        async function loadDataList() {
            ps_loading_dialog.value.openModal();
            PsUtils.addParamToCurrentUrl(itemProvider.getURLforListByParam(itemProvider.paramHolder));
            await itemProvider.resetProductList(psValueStore.getLoginUserId(), itemProvider.paramHolder);
            ps_loading_dialog.value.closeModal();
            //hide popup filter
            itemProvider.showPopUpFilter = false;
        }

        return {
            map_with_makers_modal,
            ps_loading_dialog,
            itemProvider,
            mapFilterClicked
        }
    }

}

</script>
