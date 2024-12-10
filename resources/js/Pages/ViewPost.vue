<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Post from '@/Components/Post.vue';
import CustomHeader from '@/Components/CustomHeader.vue';
import { comment } from 'postcss';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    post: {
        type: Array,
        required: true
    },
    comments: {
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
                                    <Post 
                                        :title="post.title" 
                                        :authorName="post.authorName" 
                                        :authorID="post.authorID" 
                                        :text="post.text" 
                                        :url="post.url"
                                    />
                                </div>

                                <form @submit.prevent="this.$inertia.post('/create-comment', {
                                    text: text,
                                    post_id: post.id,
                                    user_id: this.$page.props.auth.user.id,
                                })" class="space-y-4">
                                    <label for="text" class="block mb-2 text-sm font-medium text-white">Оставить комментарий</label>
                                    <textarea v-model="text" required class="bg-transparent border border-white text-white text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-4 h-40 resize-none"></textarea>
                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                                        Опубликовать
                                    </button>
                                </form>

                                <div class="mt-4 space-y-4">
                                    <h2 class="text-xl text-white font-semibold">Комментарии</h2>
                                    <div v-for="comment in comments" :key="comment.text">
                                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                            <a :href="comment.authorID" class="hover:underline">
                                                {{ comment.authorName }}
                                            </a> 
                                            ({{ new Intl.DateTimeFormat('ru-RU').format(new Date(comment.created_at)) }})
                                        </p>
                                        <p class="text-sm">{{ comment.text }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

