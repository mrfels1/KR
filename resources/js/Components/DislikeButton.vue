<template>

    <button 
        :class="['inline-flex items-center', isDisliked ? 'bg-red-600' : 'bg-gray-300']"
        @click="emit('dislike')"
    >
        <span class="text-black">{{ isDisliked ? 'Disliked' : 'Dislike' }}</span>
        <span class="text-black ml-2">{{ dislikesCount }}</span>
    </button>
</template>
  
<script setup>
defineProps({
isDisliked: Boolean,
dislikesCount: Number,
});
const emit = defineEmits(['dislike']);
</script>
  

<style scoped>
button {
    padding: 0.5em 1em;
    border-radius: 4px;
    transition: background-color 0.3s;
}
</style>

