<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Post from '@/Components/Post.vue';
import CustomHeader from '@/Components/CustomHeader.vue';

const title = defineModel("title");
const text = defineModel("text");


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
                            <div class="bg-black-900 bg-opacity-50 backdrop-blur-md rounded-md p-4 border border-black border-opacity-10">
                                <form @submit.prevent="this.$inertia.post('/create-post', {
                                    title: title,
                                    text: text,
                                    user: this.$page.props.auth.user,
                                })" class="space-y-4">
                                    <label for="title" class="block mb-2 text-sm font-medium text-white">Заголовок</label>
                                    <input v-model="title" type="text" required class="bg-transparent border border-white text-white text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5">
                                    <label for="text" class="block mb-2 text-sm font-medium text-white">Текст</label>
                                    <textarea v-model="text" required class="bg-transparent border border-white text-white text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-4 h-40 resize-none"></textarea>
                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                        Опубликовать
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

