<script setup>
import { Head, Link } from '@inertiajs/vue3';
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
            class="relative flex min-h-screen flex-col items-center  selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <CustomHeader :can-login="canLogin" :can-register="canRegister" />

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-1">
                            <div v-for="post in posts" :key="post.url">
                                <Post
                                    :title="post.title"
                                    :authorName="post.authorName"
                                    :authorID="post.authorID"
                                    :text="post.text"
                                    :url="post.url"
                                    :likesCount="post.likesCount"
                                    :dislikesCount="post.dislikesCount"
                                    :isLiked="post.isLiked"
                                    :isDisliked="post.isDisliked"
                                />
                            </div>
                        </div>
                    </div>
                </main>

                <footer
                    class=" bottom-0 left-0 right-0 py-6 text-center text-sm text-black dark:text-white/70 bg-white dark:bg-zinc-900 w-full"
                >
                    Автор: Хакимов Дмитрий Дамирович
                    <br>
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
