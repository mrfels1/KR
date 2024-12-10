<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Post from '@/Components/Post.vue';
import CustomHeader from '@/Components/CustomHeader.vue';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    posts: {
        type: Array,
        required: true,
    },
    user:{
        type: Array,
        required: true
    }
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Главная страница" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <CustomHeader :can-login="canLogin" :can-register="canRegister" />

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-1">
                            <div class="bg-gray-900 bg-opacity-50 backdrop-blur-md rounded-md p-4 border border-black border-opacity-10">
                                <div class="p-6 text-white">
                                    <h2 class="text-xl font-semibold">
                                        Данные пользователя
                                    </h2>
                                    <p class="mt-2">Имя: {{ user.name }}</p>
                                    <p class="mt-2">На сайте с: {{ new Intl.DateTimeFormat('ru-RU').format(new Date(user.created_at)) }}</p>
                                </div>
                            </div>
                                <h2 class="text-xl font-semibold mt-4 text-white">
                                    Посты пользователя
                                </h2>
                            <div v-for="post in posts" :key="post.url">
                                <Post
                                    :title="post.title"
                                    :authorName="post.authorName"
                                    :authorID="post.authorID"
                                    :text="post.text"
                                    :url="post.url"
                                />
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

