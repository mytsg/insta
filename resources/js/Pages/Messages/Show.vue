<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref, computed, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import MessageList from '@/Components/MessageList.vue';
import axios from 'axios';

const props = defineProps({
    'opponent': Object,
    'authUser': Object,
    'users': Array,
})

const form = useForm({
    'message': '',
    'send_id': props.authUser.id,
    'receive_id': props.opponent.id,
})

const messages = reactive({})

const getMessages = async() => {
    await axios.get(`/getMessages/${props.opponent.id}`)
    .then(res => {
        messages.value = res.data
    })
}

const send = () => {
    axios.post(route('messages.store'),form)
    .then( res => {
        getMessages()
        form.message = ''
    })
}

onMounted(() => {
    getMessages()
    window.Echo.channel('mesaage').listen('MessageCreated', (e) => {
        getMessages()
    })
})

const classes = computed(() => message.send_id === props.opponent.id
    ? 'text-blue-500'
    : 'text-red-500'
);

</script>

<template>
    <Head title="メッセージを送信" />

    <BreezeAuthenticatedLayout>
        <template #header>
        </template>

        <div class="h-full w-full">
            <div class="h-full max-w-7xl mx-auto my-4 flex w-9/12 text-center">
                <MessageList :users="props.users"/>
                <div class="parent w-full rounded border-gray-200 border-2 text-center items-center flex flex-col-reverse">
                    <div class="w-full">
                        <form @submit.prevent="send">
                            <div class="flex">
                                <textarea class="h-12 border-2 border-gray-400 w-10/12" v-model="form.message"></textarea>
                                <div class="w-2/10 flex text-center items-center">
                                    <button class="inline-block bg-gray-300 py-3 md:px-1 lg:px-6 w-full">送信する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="scroll w-full flex flex-col-reverse">
                        <div class="my-2" v-for="message in messages.value" :key="message.id">
                            <template v-if="message.send_id == props.authUser.id">
                                <div class="mr-3 flex justify-end">
                                    <div class="my-1 text-black bg-wihte border-2 border-gray-100 rounded-full media-body">
                                        <div class="inline-block bg-light rounded-full py-1 px-3 mb-2">
                                            <p class="text-small mb-0 text-dark">{{message.message}}</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="ml-3 flex justify-start">
                                    <div v-if="opponent.icon" class="mx-4 sm:w-10 sm:h-10 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" :src="'/storage/icons/' + opponent.icon" alt="">
                                    </div>
                                    <div v-else class="mx-4 sm:w-10 sm:h-10 inline-flex items-center rounded-full flex-shrink-0">
                                        <img class="rounded-full" src="/images/no_image.png" alt="">
                                    </div>
                                    <div class="inline-block my-1 text-black bg-gray-300 rounded-full media-body">
                                        <div class="inline-block bg-light rounded-full py-1 px-3">
                                            <p class="text-small mb-0 text-dark">{{message.message}}</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
.parent {
    position: relative;
}

.form {
    position: absolute;
    bottom: 0;
}

.scroll {
    overflow-y: scroll;
}
</style>
