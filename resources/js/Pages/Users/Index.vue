<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import UserComponent from '@/Components/UserComponent.vue';
import axios from 'axios';

const props = defineProps({
    'users': Array,
    'follows': Array,
    'authUser': Object,
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
    <Head title="ユーザー検索" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ユーザー一覧
            </h2>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center flex flex-col justify-center">
                <h1 class="font-bold title-font text-3xl mb-12">検索</h1>
                <div class="w-full text-center mx-auto mb-12">
                    <form class="w-1/2 flex mx-auto">
                        <input v-model="search" type="text" class="rounded w-4/5 text-center mx-auto">
                        <button @click.prevent="searchUsers" type="submit" class="inline-block w-1/5 px-5 rounded">
                            <svg class="w-1/2 h-1/2" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                        </button>
                    </form>
                </div>
                <div class="w-full text-center mx-auto" v-for="user in props.users">
                    <div class="text-center mx-auto" :key="user.id">
                        <UserComponent :authUser="props.authUser" :user="user" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>