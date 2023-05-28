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
    <div class="w-1/3 min-h-screen mr-4">
        <div class="w-full">
            <button type="button" class="w-full inline-block rounded p-2 bg-blue-500 text-white">前へ</button>
        </div>
        <div class="flex flex-col flex-wrap w-full text-center">   
            <div v-for="user in props.users" :key="user.id" class="flex text-center mx-auto hover:bg-gray-200 w-full">
                <Link :href="route('messages.show',{ message: user.id })" class="mx-auto">
                    <div class="flex flex-col my-5 lg:items-start items-center mx-auto">
                        <div class="flex justify-start">
                            <div v-if="user.icon" class="sm:w-10 sm:h-10 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                                <img class="rounded-full" :src="'/storage/icons/' + user.icon" alt="">
                            </div>
                            <div v-else class="sm:w-10 sm:h-10 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                                <img class="rounded-full" src="/images/no_image.png" alt="">
                            </div>
                            <div class="flex items-center">
                                <h2 class="title-font text-xl font-bold items-center text-black">{{ user.userName }}</h2>
                            </div>
                        </div>
                        <p></p>
                    </div>
                </Link>
            </div>
        </div>
        <div class="w-full rounded">
            <button type="button" class="w-full p-2 bg-green-500 text-white">次へ</button>
        </div>
    </div>
</template>