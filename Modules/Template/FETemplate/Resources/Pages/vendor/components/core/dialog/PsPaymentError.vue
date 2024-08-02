<template>
    <ps-modal ref="psmodal" maxWidth="350px" :isClickOut='false'>
        <template #title>
            <ps-label-title> {{ title }} </ps-label-title>
        </template>
        <template #body>
            <ps-label class="my-7"> {{ message }} </ps-label>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <ps-button class="justify-start" @click="psmodal.toggle(false)">Cancel</ps-button>
                <ps-route-link :to="{ name: 'fe_wallet' }">
                    <ps-button class="jsutify-end" >Recharge</ps-button>
                </ps-route-link>
            </div>
        </template>
    </ps-modal>
</template>

<script lang='ts'>
import { defineComponent, ref } from 'vue';
import PsModal from '@template1/vendor/components/core/modals/PsModal.vue';
import PsLabelTitle from '@template1/vendor/components/core/label/PsLabelTitle.vue';
import PsLabel from '@template1/vendor/components/core/label/PsLabel.vue';
import PsButton from '@template1/vendor/components/core/buttons/PsButton.vue';
import { trans } from 'laravel-vue-i18n';
import PsRouteLink from '@template1/vendor/components/core/link/PsRouteLink.vue'

export default defineComponent({
    name: "PsErrorDialog",
    components: {
        PsModal,
        PsLabel,
        PsLabelTitle,
        PsButton,
        PsRouteLink
    },
    setup() {
        const psmodal = ref();
        const title = ref(trans('ps_error_dialog__error'));
        const message = ref(trans('ps_error_payment__error_message'));

        function openModal(titleStr, messageStr) {
            if (titleStr != null && titleStr.trim() != '') {
                title.value = titleStr;
            }

            if (messageStr != null && messageStr.trim() != '') {
                message.value = messageStr;
            }
            psmodal.value.toggle(true);
        }

        function closeModal() {
            psmodal.value.toggle(false);
        }

        return {
            psmodal,
            openModal,
            closeModal,
            title,
            message
        }
    },
})
</script>
