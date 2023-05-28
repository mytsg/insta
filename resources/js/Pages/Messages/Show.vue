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

console.log('props.authUser.id',props.authUser.id)

const form = useForm({
    'message': '',
    'send_id': props.authUser.id,
    'receive_id': props.opponent.id,
})

const messages = reactive({})

const getMessages = async() => {
    await axios.get(`/getMessages/${props.opponent.id}`)
    .then(res => {
        console.log('res.data', res.data)
        messages.value = res.data
        console.log('messages.value',messages.value[3].send_id)
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

        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto flex w-9/12 text-center">
                <MessageList :users="props.users"/>
                <div class="parent w-full rounded border-gray-200 border-2 text-center items-center flex flex-col">
                    <div class="my-2" v-for="message in messages.value" :key="message.id">
                        <template v-if="message.send_id == props.authUser.id">
                            <div class="mr-3 text-right flex">
                                <div class="my-1 text-right text-black bg-wihte border-2 border-gray-100 rounded-full media-body">
                                    <div class="inline-block bg-light rounded-full py-1 px-3 mb-2">
                                        <p class="text-small mb-0 text-dark">{{message.message}}</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="ml-3 text-left flex">
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
                    
                    
                    <div class="form w-full">
                        <form @submit.prevent="send">
                            <div class="flex">
                                <textarea class="h-12 border-2 border-gray-400 w-10/12" v-model="form.message"></textarea>
                                <div class="w-2/10 flex text-center items-center">
                                    <button class="inline-block bg-gray-300 py-3 md:px-1 lg:px-6 w-full">送信する</button>
                                </div>
                            </div>
                        </form>
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
</style>
