<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { Head, Link } from '@inertiajs/vue3';
import Post from '@/Components/Post.vue';
import CustomHeader from '@/Components/CustomHeader.vue';

defineProps({
    users: {
        type: Array,
        required: true
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
})
</script>

<template>
    <Head title="Пользователи" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/100">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative flex min-h-screen flex-col items-center  selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <CustomHeader :can-login="canLogin" :can-register="canRegister" />

                <main class="mt-6 " style="min-height: 100vh">
                    <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-1">
                            <li v-for="user in users" :key="user.id" class="flex items-center justify-between p-2 border-b border-white bg-black bg-opacity-50 backdrop-blur-md rounded-md">
                                <div>
                                    <p class=" font-semibold">{{ user.name }}</p>
                                    <p class=" text-white-500">Количество постов: {{ user.postsCount }}</p>
                                    <p class=" text-white-500">На сайте с: {{ new Intl.DateTimeFormat('ru-RU', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date(user.created_at)) }}</p>
                                </div>
                                <Link :href="user.url" class="text-blue-500 hover:text-blue-700">View Profile</Link>
                            </li>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>


