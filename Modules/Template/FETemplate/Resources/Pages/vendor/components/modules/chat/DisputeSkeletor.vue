<template>
    <div class="cursor-pointer w-full">
        <ps-card class="flex flex-col  ">
            <div class="px-4 bg-feAchromatic-50 dark:bg-feAchromatic-900  flex items-center w-full">
                <div class="w-full flex">
                    <Skeletor height="40" class='sm:w-40' />
                    <Skeletor height="40" class='sm:w-40' />
                    <Skeletor height="40" class='sm:w-40' />
                    <Skeletor height="40" class='sm:w-40' />
                    <Skeletor height="40" class='sm:w-40' />
                </div>
            </div>  
        </ps-card>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { Skeletor } from "vue-skeletor";
import "vue-skeletor/dist/vue-skeletor.css";
import PsCard from '@template1/vendor/components/core/card/PsCard.vue';

export default defineComponent ({
    name : "DisputeSkeletorItem",
    components : {
       Skeletor,
       PsCard,
    }
});
</script>
