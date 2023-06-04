<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import UserComponent from '@/Components/UserComponent.vue';
import axios from 'axios';

const props = defineProps({
    'followerUsers': Array,
    'auth': Object,
})

const search = ref('')

const searchUsers = () => {
    console.log('search',search.value)
    Inertia.get(route('users.index'),{
        search: search.value
    })
}
</script>

<template>
    <Head title="フォロー中のユーザー" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                フォローされているユーザー一覧
            </h2>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center flex flex-col justify-center">
                <h1 class="font-bold title-font text-3xl mb-12">フォローされているユーザー</h1>
                <div class="w-full text-center mx-auto" v-for="user in props.followerUsers">
                    <div class="text-center mx-auto" :key="user[0].id">
                        <UserComponent :authUser="props.auth" :user="user[0]" />
                    </div>
                </div>
                <h1 v-if="Object.keys(props.followerUsers).length == 0" class="font-bold title-font text-3xl mb-12">誰からもフォローされていません</h1>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>