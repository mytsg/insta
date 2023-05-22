<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios';
const isShow = ref(false)
const toggleStatus = () => {
    isShow.value = !isShow.value
}

const props = defineProps({
    'post': Object,
})

console.log('modal', props.post)
// onMounted(() => {
//     axios.get('/api/user')
//     .then( res => {
//         console.log(res)
//     })
// })
</script>

<template>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <!-- <h2 class="modal__title" id="modal-1-title">
                Micromodal
                </h2> -->
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
                        <div class="parent lg:flex-grow w-2/5 flex flex-col md:text-left text-center">
                            <div class="w-full flex-col items-center p-2 rounded border-2 border-gray-300">
                                <div class="flex justify-start w-full">
                                    <div v-if="post.user.icon" class="sm:w-8 sm:h-8 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" :src="'/storage/icons/' + post.user.icon" alt="">
                                    </div>
                                    <div v-else class="sm:w-8 sm:h-8 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" src="/images/no_image.png" alt="">
                                    </div>
                                    <div class="items-center">
                                        <h2 class="title-font text-xl font-bold items-center text-black">{{ post.user.userName }}</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- <p class="mb-8 leading-relaxed w-full">Copperaaaa</p> -->
                            <div class="w-full flex-col items-center p-2 rounded border-2 border-gray-300">
                                <div class="flex justify-start w-full">
                                    <div v-if="post.user.icon" class="sm:w-8 sm:h-8 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" :src="'/storage/icons/' + post.user.icon" alt="">
                                    </div>
                                    <div v-else class="sm:w-8 sm:h-8 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" src="/images/no_image.png" alt="">
                                    </div>
                                    <div class="items-center">
                                        <h2 class="title-font text-xl font-bold items-center text-black">{{ post.user.userName }}</h2>
                                    </div>
                                </div>
                                <p class="py-2">{{ props.post.content }}</p>
                            </div>
                            <div class="form">
                                <h2>ここにコメント用のフォーム</h2>
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