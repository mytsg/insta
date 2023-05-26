<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch, watchEffect } from 'vue'
import axios from 'axios';
import MicroModal from 'micromodal';  // es6 module
import Echo from 'laravel-echo';
import dayjs from 'dayjs'

const props = defineProps({
    'post': Object,
    // 'comments': Array,
})
const isShow = ref(false)
const toggleStatus = () => {
    isShow.value = !isShow.value
}

const form = useForm({
    'postId': props.post.id,
    'content': '',
})

const comments = reactive({})
const commentsList = reactive({})
const allCommentsNum = ref(0)
const isShowNextButton = ref(true)
const isShowBackButton = ref(false)

const getComments = async () => {
    try{
        await axios.get(`posts/comments/${props.post.id}`)
        .then(res => {
        comments.value = res.data
        console.log('Object.keys(comments.value).length', Object.keys(comments.value).length) //comments.valueはObject
        commentsList.value = comments.value.slice(countStart.value, countEnd.value)
        allCommentsNum.value = Object.keys(comments.value).length
        if(allCommentsNum.value - countEnd.value >= 0) {
            isShowNextButton.value = true
            console.log('true', allCommentsNum.value - countEnd.value)
        } else {
            isShowNextButton.value = false
            console.log('else', allCommentsNum.value - countEnd.value)
        }

        console.log('allCommentsNum',allCommentsNum.value)
        console.log('allCommentsNum.value - countEnd.value', allCommentsNum.value - countEnd.value)
        console.log('getCommentsしました') })
    } catch(e) {
        console.log(e)
    }
}


const countStart = ref(0)
const countEnd = ref(7)
const isMore = async() => {
    countStart.value += 7
    countEnd.value += 7
    await getComments()

    if(countStart.value > 0) {
        isShowBackButton.value = true
        console.log('countStart ismore t',countStart.value)
    } else {
        console.log('countStart ismess f',countStart.value)
    }

    console.log('comments.value',comments.value)
    console.log('commentsList.value',commentsList.value)
    console.log('countstart.value',countStart.value)
    console.log('countend.value',countEnd.value)
}

const isLess = async() => {
    countStart.value -= 7
    countEnd.value -= 7
    await getComments()

    if(countStart.value > 0) {
        isShowBackButton.value = true
    } else {
        isShowBackButton.value = false
    }
    console.log('countStart isless',countStart.value)
}

onMounted(() => {
    getComments()
    
    window.Echo.channel('comment').listen('CommentCreated', (e) => {
        console.log('listen')
        getComments()
    })
})

const sendComment = () => {
    axios.post(route('comments.store'), form)
    .then( res => {
        getComments()
        form.content = ''
    })
}


</script>

<template>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-1-title">
                
                </h2>
                <button @click="toggleStatus" type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <section class="text-gray-600 body-font">
                    <div class="container mx-auto flex md:flex-row flex-col">
                        <div class="lg:w-1/2 md:w-1/2 w-5/6 mb-10 md:mb-0">
                            <img class="w-full h-full object-cover object-center rounded" alt="hero" :src="'/storage/posts/' + props.post.filename">
                        </div>
                        <div class="parent lg:flex-grow w-2/5 flex flex-col md:text-left text-center rounded border-2 border-gray-300">
                            <div class="w-full flex-col mb-4 items-center p-1 rounded border-b-2 border-gray-300">
                                <div class="flex justify-start w-full space-x-2">
                                    <div v-if="post.user.icon" class="sm:w-6 sm:h-6  inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" :src="'/storage/icons/' + post.user.icon" alt="">
                                    </div>
                                    <div v-else class="sm:w-6 sm:h-6 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" src="/images/no_image.png" alt="">
                                    </div>
                                    <div class="items-center">
                                        <p class="title-font font-bold items-center text-black">{{ post.user.userName }}</p>
                                    </div>
                                    <p>{{ dayjs(props.post.created_at).format('YYYY年MM月DD日 HH時MM分') }}</p>
                                </div>
                                <p class="pt-1">{{ props.post.content }}</p>
                            </div>

                            <div v-for="comment in commentsList.value" :key="comment.id">
                                <div class="w-full flex-col items-center p-1 rounded border-b-2 border-gray-300">
                                    <div class="flex justify-start w-full space-x-2">
                                        <div v-if="comment.user_icon" class="sm:w-6 sm:h-6 inline-flex items-center rounded-full flex-shrink-0">
                                            <img class="rounded-full" :src="'/storage/icons/' + comment.user_icon" alt="">
                                        </div>
                                        <div v-else class="sm:w-6 sm:h-6 inline-flex items-center rounded-full flex-shrink-0">
                                            <img class="rounded-full" src="/images/no_image.png" alt="">
                                        </div>
                                        <div class="items-center">
                                            <p class="title-font font-bold items-center text-black">{{ comment.userName }}</p>
                                        </div>
                                        <p>{{ dayjs(comment.created_at).format('YYYY年MM月DD日 HH時MM分') }}</p>
                                    </div>
                                    <p class="pt-1">{{ comment.content }}</p>
                                </div>
                            </div>
                            <!-- <div class="buttons-parent h-full"> -->
                                <div class="buttons flex justify-around">
                                    <button v-show="isShowBackButton" type="button" @click="isLess" class="back-button inline-block p-2 bg-green-400 rounded text-white">＜ 前へ</button>
                                    <button v-show="isShowNextButton" type="button" @click="isMore" class="next-button inline-block p-2 bg-blue-400 rounded text-white">次へ ＞</button>
                                </div>
                            <!-- </div> -->

                            <div class="form w-full">
                                <form @submit.prevent="sendComment" class="w-full flex">
                                    <input v-model="form.content" type="text" class="border-2 border-gray-200 rounded w-10/12">
                                    <button class="p-2 bg-blue-300 text-white rounded w-2/12">投稿する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <footer class="modal__footer">
                
            </footer>
            </div>
        </div>
    </div>
    <button @click="toggleStatus" type="button" data-micromodal-trigger="modal-1" href='javascript:;'>詳細を見る</button>
</template>