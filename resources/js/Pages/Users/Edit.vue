<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import axios from 'axios';

const props = defineProps({
    'user': Object
})

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    userName: props.user.userName,
    profile: props.user.profile,
    icon: props.user.fileName,
    email: props.user.email
})

const submitForm = id => {
    form.post(route('users.update',{ user: id }), form)
}

const selectedFile = (e) => {
    console.log('e.target.files.[0].name',e.target.files[0].name)
    form.icon = e.target.files[0]
    console.log('form.icon',form.icon)
}

</script>

<template>
    <Head title="購買履歴 詳細画面" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                プロフィールを編集
            </h2>
        </template>

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row mt-10">
                    <div class="w-1/3 text-center ">
                        <div v-if="props.user.icon" class="sm:w-48 sm:h-48 inline-flex items-center justify-center flex-shrink-0">
                            <img class="mt-8 rounded-full" :src="'/storage/icons/' + props.user.icon" alt="">
                        </div>
                        <div v-else class="sm:w-40 sm:h-40 sm:mr-10 inline-flex items-center justify-center rounded-full flex-shrink-0">
                            <img class="mt-8 rounded-full" src='/images/no_image.png' alt="">
                        </div>
                    </div>
                    <div class="w-2/3 sm:pl-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                        <form @submit.prevent="submitForm(props.user.id)" >
                            <div class="mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl text-blue-500">プロフィール写真を変更</h1>
                                <input class="p-2" type="file" accept="image/png,image/jpeg,image/jpg" @change="selectedFile">
                            </div>
                            <div class="flex mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl">名前</h1>
                                <input class="p-2 title-font rounded text-xl border-2 border-gray-400" v-model="form.name">
                            </div>
                            <div class="flex mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl">ユーザーネーム</h1>
                                <input class="px-2 title-font rounded text-xl border-2 border-gray-400" v-model="form.userName">
                            </div>
                            <div class="mb-4">
                                <h1 class="m-2 pr-8 title-font font-bold text-2xl">プロフィール</h1>
                                <textarea class="px-2 title-font rounded text-xl border-2 border-gray-400" v-model="form.profile"></textarea>
                            </div>
                            <div class="text-center mt-16">
                                <button class="rounded py-4 px-8 bg-blue-300 text-white font-bold">更新する</button>
                            </div>
                        </form>                    
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>