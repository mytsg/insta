<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch } from 'vue'
import axios from 'axios';
import MicroModal from 'micromodal';  // es6 module
import Echo from 'laravel-echo';

MicroModal.init({
  disableScroll: true
});

const isShow = ref(false)
const toggleStatus = () => {
    isShow.value = !isShow.value
}

const props = defineProps({
    'post': Object,
    // 'comments': Array,
})

const form = useForm({
    'postId': props.post.id,
    'content': '',
})


const comments = reactive({})
const getComments = () => {
    axios.get(`posts/comments/${props.post.id}`)
    .then(res => {
        console.log('res.data', res.data)
        comments.value = res.data
    })
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
                <!-- <p>
                Try hitting the <code>tab</code> key and notice how the focus stays within the modal itself. Also, <code>esc</code> to close modal.
                </p> -->
                <section class="text-gray-600 body-font">
                    <div class="container mx-auto flex md:flex-row flex-col">
                        <div class="lg:w-1/2 md:w-1/2 w-5/6 mb-10 md:mb-0">
                            <img class="w-full h-full object-cover object-center rounded" alt="hero" :src="'/storage/posts/' + props.post.filename">
                        </div>
                        <div class="parent lg:flex-grow w-2/5 flex flex-col md:text-left text-center rounded border-2 border-gray-300">
                            <div class="w-full flex-col items-center p-1 rounded border-b-2 border-gray-300">
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
                                    <p>{{ props.post.created_at }}</p>
                                </div>
                                <p class="pt-1">{{ props.post.content }}</p>
                            </div>

                            <div v-for="comment in comments.value">
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
                                        <p>{{ comment.created_at }}</p>
                                    </div>
                                    <p class="pt-1">{{ comment.content }}</p>
                                </div>
                            </div>

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