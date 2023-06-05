<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import axios from 'axios';
import MicroModal from '@/Components/MicroModal.vue'

const props = defineProps({
    'user': Object,
    'posts': Array,
    'amount': Number,
    'following': Number,
    'follower': Number,
})

const amount = ref(props.amount)
const followingAmount = ref(props.following)
const followerAmount = ref(props.follower)

const status = ref(false)

const isFollowing = async(userId) => {
    await axios.get(`/follow/${userId}/check`)
    .then( res => {
        if(res.data == 1) {
            console.log('true')
            status.value = true
        } else {
            console.log('false')
            status.value = false
        }
    }).catch((e) => {
        console.log(e)
    })
}

const countFollowingAmount = async(userId) => {
    await axios.get(`/followingAmount/${userId}`)
    .then( res => {
        followingAmount.value = res.data
    })
}

const countFollowerAmount = async(userId) => {
    await axios.get(`/followerAmount/${userId}`)
    .then( res => {
        followerAmount.value = res.data
    })
}

isFollowing(props.user.id)
countFollowingAmount(props.user.id)
countFollowerAmount(props.user.id)

const follow = async(id) => {
    await axios.post(`/follow/${id}`)
    .then( res => {
    }).catch((e) => {
        console.log(e)
    })
    isFollowing(id)
    countFollowingAmount(id)
    countFollowerAmount(id)
}

onMounted(() => {

})
</script>

<template>
    <Head title="プロフィール" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.user.name }}のプロフィール
            </h2>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row mt-10">
                    <div class="w-1/3 text-center ">
                        <div v-if="props.user.icon" class="sm:w-48 sm:h-48 inline-flex items-center justify-center flex-shrink-0">
                            <img class="mt-8 rounded-full" :src="'/storage/icons/' + props.user.icon" alt="">
                        </div>
                        <div v-else class="sm:w-48 sm:h-48 inline-flex items-center justify-center rounded-full flex-shrink-0">
                            <img class="mt-8 rounded-full" src="/images/no_image.png" alt="">
                        </div>
                    </div>
                    <div class="w-2/3 sm:pl-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                        <div class="flex mb-4">
                            <h1 class="font-bold title-font text-2xl">{{ props.user.name }}</h1>
                            <button v-if="status" @click.prevent="follow(props.user.id)" class="w-1/8 text-xl ml-16 inline-block text-white bg-gray-300 hover:bg-gray-400 rounded px-8 py-2">フォロー解除</button>
                            <button v-else @click.prevent="follow(props.user.id)" class="w-1/8 text-xl ml-16 inline-block text-white bg-blue-300 hover:bg-blue-400 rounded px-8 py-2">フォロー</button>
                            <Link :href="route('messages.show',{ message: props.user.id})" class="w-1/8 text-xl ml-4 inline-block text-white bg-gray-300 hover:bg-gray-400 rounded px-8 py-2">メッセージ</Link>                        
                        </div>
                        <div class="flex justify-start mb-4">
                            <h1 class="title-font font-bold text-xl">投稿{{ props.amount }}件</h1>
                            <Link :href="`/users/followerList/${props.user.id}`" class="title-font font-bold text-xl ml-16">フォロワー{{ followerAmount }}人</Link>
                            <Link :href="`/users/followingList/${props.user.id}`" class="title-font font-bold text-xl ml-16">フォロー{{ followingAmount }}人</Link>
                        </div>
                        <h1 class="title-font font-bold text-2xl pb-4">{{ props.user.userName }}</h1>
                        <p class="leading-relaxed text-lg mb-4">{{ props.user.profile }}</p>
                    </div>
                </div>
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            <div v-for="post in props.posts" :key="post.id" class="w-1/3 p-4">
                                <div class="flex relative pb-2">
                                    <img class="w-full h-full object-cover object-center" :src="'/storage/posts/'+ post.filename">
                                </div>
                                <MicroModal :post="post" :comments="post.comments"/>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>