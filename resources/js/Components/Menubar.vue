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
    <div class="h-screen bg-white border-r-4 border-gray-200 w-1/6">
        <Link :active="route().current('dashboard')" class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">ホーム</Link>
        <Link class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">検索</Link>
        <Link class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">メッセージ</Link>
        <Link class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">作成</Link>
        <Link class="w-full relative py-6 hover:bg-gray-200 text-gray-500 inline-block text-center title-font text-xl rounded font-medium">プロフィール</Link>
    </div>
</template>