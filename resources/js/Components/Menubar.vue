<script setup>
import { ref, computed } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <div class="h-full bg-white border-r-4 border-gray-200 w-1/6">
        <Link :herf="route('posts.index')" :active="route().current('posts.index')" class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">ホーム</Link>
        <Link class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">検索</Link>
        <Link :href="route('messages.index')" class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">メッセージ</Link>
        <Link :href="route('posts.create')" :active="route().current('posts.create')" class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">作成</Link>
        <Link :href="route('myprofile')" class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">プロフィール</Link>
        <!-- <Link class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">ログアウト</Link> -->
        <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button" class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">
            Log Out
        </BreezeResponsiveNavLink>
        
    </div>
</template>