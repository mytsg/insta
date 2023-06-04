<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import PostComponent from '@/Components/PostComponent.vue';

const props = defineProps({
    'posts': Array,
    'authUser': Object,
})

</script>

<template>
    <Head title="購買履歴 詳細画面" />

    <BreezeAuthenticatedLayout>
        <template #header>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto flex justify-around">
                <PostComponent :authUser="props.authUser" :posts=props.posts />
                <div class="text-center w-1/3">
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>