<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, nextTick} from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import MicroModal from '@/Components/MicroModal.vue'
import axios from 'axios';
import Like from '@/Components/Like.vue'

const props = defineProps({
    'posts': Array,
    'authUser': Object,
})

</script>

<template>
    <section class="w-full text-gray-600 body-font">
        <div v-for="post in props.posts" :key="post.id" class="w-full flex justify-center mb-4">
            <div class="container w-2/3 rounded border-gray-200 border-2 flex flex-col px-12 py-4 justify-center items-center">
                <div class="w-full md:w-2/3 flex-col items-center">
                    <Link :herf="route('users.show',{ user: post.user.id})" class="flex justify-start">
                        <div v-if="post.user.icon" class="sm:w-10 sm:h-10 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                            <img class="rounded-full" :src="'/storage/icons/' + post.user.icon" alt="">
                        </div>
                        <div v-else class="sm:w-10 sm:h-10 mr-4 inline-flex items-center rounded-full flex-shrink-0">
                            <img class="rounded-full" src="/images/no_image.png" alt="">
                        </div>
                        <div class="items-center">
                            <h2 class="title-font text-2xl font-bold items-center text-black">{{ post.user.userName }}</h2>
                        </div>
                    </Link>
                </div>
                <img class="w-4/5 my-2 object-cover object-center rounded" alt="hero" :src="'/storage/posts/' + post.filename">
                <div class="w-full md:w-2/3 flex-col mb-4 items-center">
                    <Like :post="post" :authUser="props.authUser"/>
                    <p class="w-full my-4 leading-relaxed text-black">{{ post.content }}</p>
                    <MicroModal :post="post" :comments="post.comments"/>
                </div>
            </div>
        </div>
    </section>
</template>