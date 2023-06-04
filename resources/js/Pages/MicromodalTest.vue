<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import PostComponent from '@/Components/PostComponent.vue';
import MicromodalEx from '@/Components/MicromodalEx.vue';

</script>

<template>
    <Head title="購買履歴 詳細画面" />

    <BreezeAuthenticatedLayout>
        <template #header>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto flex justify-around">
                <MicromodalEx />
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>