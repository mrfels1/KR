<script setup>
defineProps({
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
    }
})
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
        </div>
    </div>
</template>

