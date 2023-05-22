<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import CreatePost from '@/Components/CreatePost.vue'

const props = defineProps({
    'user': Object,
})

const form = useForm({
    content: '',
    filename: null,
    // userId: props.user.id,
})

const submitForm = () => {
    form.post(route('posts.store'));
}

const selectedFile = (e) => {
    console.log(e.target.files[0])
    form.filename = e.target.files[0]
    console.log('filename', filename)
}

</script>

<template>
    <Head title="作成" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                作成
            </h2>
        </template>

        <div class="w-full">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center sm:flex-row mt-10 bg-gray-100 rounded">
                    <div class="border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl text-blue-500">投稿する写真を選択</h1>
                                <input class="p-2" type="file" accept="image/png,image/jpeg,image/jpg" @change="selectedFile">
                            </div>
                            <!-- <div class="w-full mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl">名前</h1>
                                <input class="p-2 title-font rounded text-xl border-2 border-gray-400" >
                            </div>
                            <div class="flex mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl">ユーザーネーム</h1>
                                <input class="px-2 title-font rounded text-xl border-2 border-gray-400">
                            </div> -->
                            <div class="mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl">キャプション</h1>
                                <textarea class="w-full px-2 title-font rounded text-xl border-2 border-gray-400" v-model="form.content"></textarea>
                            </div>
                            <div class="flex justify-between my-8">
                                <button class="rounded py-4 px-8 bg-red-400 text-white font-bold">破棄</button>
                                <button class="rounded py-4 px-8 bg-gray-400 text-white font-bold">シェア</button>
                            </div>
                        </form>                    
                    </div>
                </div>
                <!-- <div class="text-center mt-16">
                    <button type="button" class="rounded py-4 px-8 bg-blue-300 text-white font-bold">更新する</button>
                </div> -->
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>