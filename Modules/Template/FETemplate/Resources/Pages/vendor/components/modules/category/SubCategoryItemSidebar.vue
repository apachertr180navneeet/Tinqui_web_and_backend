<template #content>
    <div
        class="flex justify-between items-center mb-6 subcategory-pop-up dark:bg-feSecondary-800"
        :style="{ left: leftOffset + 'px' }"
    >
        <ul v-if="subCategories != null">
            <li v-for="subCategory in subCategories">
                <ps-route-link
                    class="flex-grow"
                    :to="{
                        name: 'fe_item_list',
                        query: {
                            cat_id: catId,
                            cat_name: catName,
                            sub_cat_id: subCategory.id,
                            sub_cat_name: subCategory.name,
                            status: 1,
                        },
                    }"
                >
                    <span class="dark:text-white">{{ $t(subCategory.name) }}</span>
                </ps-route-link>
            </li>
        </ul>
    </div>
</template>

<script>
import PsRouteLink from "@template1/vendor/components/core/link/PsRouteLink.vue";
export default {
    components: {
        PsRouteLink,
    },
    props: {
        subCategories: Array,
        topOffset: Number,
        leftOffset: Number,
        catName: String,
        catId: Number,
        showSubCat: {
            type: Boolean,
            default: true,
        },
    },
};
</script>

<style scoped>
.subcategory-pop-up {
    position: relative;
    background-color: #fff;
    border: 2px solid #ccc;
    padding: 23px;
    box-shadow: 0 4px 4px #0000001a;
    z-index: 999;
}
</style>
