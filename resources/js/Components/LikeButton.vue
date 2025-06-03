<template>
    <button 
        :class="['inline-flex items-center', isLiked ? 'bg-red-600' : 'bg-gray-300']"
        @click="emit('like')"
    >
        <span class="text-black">{{ isLiked ? 'Liked' : 'Like' }}</span>
        
        <span class="text-black ml-2">{{ likesCount }}</span>
    </button>
</template>
  
<script setup>
defineProps({
isLiked: Boolean,
likesCount: Number,
});
const emit = defineEmits(['like']);
</script>
  

<style scoped>
button {
    padding: 0.5em 1em;
    border-radius: 4px;
    transition: background-color 0.3s;
}
</style>

