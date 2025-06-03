<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'


import DislikeButton from './DislikeButton.vue'
import LikeButton from './LikeButton.vue'

const props = defineProps({
    title: {
        type: String,
        required: true 
    },
    authorName: {
        type: String,
        required: true
    },
    text: {
        type: String,
        required: true
    },
    url: {
        type: String,
        required: true
    },
    authorID: {
        type: String,
        required: true
    },
    likesCount: {
        type: Number,
        required: true
    },
    dislikesCount: {
        type: Number,
        required: true
    },
    isLiked: {
        type: Boolean,
        required: true
    },
    isDisliked: {
        type: Boolean,
        required: true
    }
})

const emit = defineEmits(['like', 'dislike']);

const isLiked = ref(props.isLiked);
const isDisliked = ref(props.isDisliked);
const likes = ref(props.likesCount);
const dislikes = ref(props.dislikesCount);

// Следим за обновлениями props (если компонент обновляется снаружи)
watch(() => props.isLiked, (val) => (isLiked.value = val));
watch(() => props.isDisliked, (val) => (isDisliked.value = val));
watch(() => props.likesCount, (val) => (likes.value = val));
watch(() => props.dislikesCount, (val) => (dislikes.value = val));


const page = usePage();
const userId = page.props.auth.user.id;
const postId = props.url.split('/').pop(); // Предполагается, что URL заканчивается на ID поста

// Лайк
const toggleLike = () => {
  if (isLiked.value) {
    isLiked.value = false;
    likes.value--;
    // Удаление лайка
    router.post(`/remove-like/${postId}`, {}, { preserveScroll: true });
  } else {
    isLiked.value = true;
    likes.value++;
    if (isDisliked.value) {
      isDisliked.value = false;
      dislikes.value--;
      router.post(`/remove-like/${postId}`, {}, { preserveScroll: true });
    }
    router.post(`/like/${postId}`, {
      user_id: userId,
    }, { preserveScroll: true });
  }

  emit('like', isLiked.value);
};

// Дизлайк
const toggleDislike = () => {
  if (isDisliked.value) {
    isDisliked.value = false;
    dislikes.value--;
    router.post(`/remove-like/${postId}`, {}, { preserveScroll: true });
  } else {
    isDisliked.value = true;
    dislikes.value++;
    if (isLiked.value) {
      isLiked.value = false;
      likes.value--;
      router.post(`/remove-like/${postId}`, {}, { preserveScroll: true });
    }
    router.post(`/dislike/${postId}`, {
      user_id: userId,
    }, { preserveScroll: true });
  }

  emit('dislike', isDisliked.value);
};
</script>

<template>
    <div
        class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
    >
        <div class="pt-3 sm:pt-5">
            <h2
                class="text-xl font-semibold text-black dark:text-white"
            >
                <a :href="url" class="hover:underline">
                    {{ title !== undefined ? title : 'undefined' }}
                </a>
            </h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                <a :href="authorID" class="hover:underline">
                    Автор: {{ authorName !== undefined ? authorName : 'undefined' }}
                </a>
            </p>
            <p class="mt-4 text-sm/relaxed">
                {{ text !== undefined ? text : 'undefined' }}
            </p>
            <div class="mt-6 flex items-center gap-2" v-if="$page.props.auth.user">
                <LikeButton
                    :likesCount="likes"
                    :isLiked="isLiked"
                    @like="toggleLike"
                />
                <DislikeButton
                    :dislikesCount="dislikes"
                    :isDisliked="isDisliked"
                    @dislike="toggleDislike"
                />
            </div>
            <div v-else class="mt-6 flex items-center gap-2">
                <span class="text-gray-500 dark:text-gray-400">Чтобы поставить лайк или дизлайк,</span>
                <a href="/login" class="text-[#FF2D20] hover:underline">войдите в систему</a> или
                <a href="/register" class="text-[#FF2D20] hover:underline">зарегистрируйтесь</a>.
            </div>
        </div>
    </div>
</template>

