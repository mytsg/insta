<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import MessageList from '@/Components/MessageList.vue';

const props = defineProps({
    'users': Array,
})

</script>

<template>
    <Head title="購買履歴 詳細画面" />

    <BreezeAuthenticatedLayout>
        <template #header>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto flex w-10/12 text-center">
                <MessageList :users="props.users"/>
                <div class="w-full rounded border-gray-200 border-2 text-center items-center flex flex-col">
                    <div class="h-full items-center flex">
                        <div class="">
                            <div class="h-20 w-20 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"/></svg>
                            </div>
                            <h1 class="title-font text-2xl font-bold">メッセージ</h1>
                            <p>メッセージを送信できます。</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>