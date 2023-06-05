<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch, watchEffect } from 'vue'
import axios from 'axios';
import MicroModal from 'micromodal';  // es6 module
import Echo from 'laravel-echo';
import dayjs from 'dayjs'

const props = defineProps({
    'user': Object,
    'authUser': Object
})

const status = ref(false)

const isFollowing = async(userId) => {
    await axios.get(`/follow/${userId}/check`)
    .then( res => {
        if(res.data == 1) {
            status.value = true
        } else {
            status.value = false
        }
    }).catch((e) => {
        console.log(e)
    })
}

isFollowing(props.user.id)

const follow = async(id) => {
    await axios.post(`/follow/${id}`)
    .then( res => {
    }).catch((e) => {
        console.log(e)
    })
    isFollowing(id)
}

</script>

<template>
    <div class="flex justify-center mx-auto w-full">
        <div class="w-1/2 flex justify-around rounded border-2 border-gray-200">
            <Link :href="route('users.show',{user:props.user.id})" class="hover:bg-gray-200 w-3/4 items-center flex">
                <div class="w-1/3 text-center flex justify-around">
                    <div v-if="props.user.icon" class="w-10 h-10 inline-flex items-center justify-center flex-shrink-0">
                        <img class="rounded-full" :src="'/storage/icons/' + props.user.icon" alt="">
                    </div>
                    <div v-else class="w-10 h-10 inline-flex items-center justify-center rounded-full flex-shrink-0">
                        <img class="rounded-full" src='/images/no_image.png' alt="">
                    </div>
                </div>
                <div class="px-4 py-2">
                    <h1 class="font-bold text-black">{{ props.user.userName }}</h1>
                    <h2 class="text-gray-500">{{ props.user.name }}</h2>
                </div>
            </Link>
            <button v-if="status == true" @click.prevent="follow(props.user.id)" class="text-white rounded bg-gray-300 hover:bg-gray-400 w-1/4">フォロー解除</button>
            <button v-else-if="status == false && props.user.id != props.authUser.id" @click.prevent="follow(props.user.id)" class="text-white rounded bg-blue-300 hover:bg-blue-400 w-1/4">フォロー</button>
        </div>
    </div>
</template>

