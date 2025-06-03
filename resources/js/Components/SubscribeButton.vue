<template>
    <button
      :class="[
        'px-4 py-2 rounded-md transition',
        isSubscribed ? 'bg-red-600 text-white' : 'bg-green-600 text-white'
      ]"
      @click="toggleSubscription"
    >
      {{ isSubscribed ? 'Отписаться' : 'Подписаться' }}
    </button>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { router, usePage } from '@inertiajs/vue3'
  
  const props = defineProps({
    userId: {
      type: [String, Number],
      required: true
    },
    initialSubscribed: {
      type: Boolean,
      default: false
    }
  })
  
  const isSubscribed = ref(props.initialSubscribed)
  const user = usePage().props.auth.user
  
  const toggleSubscription = () => {
    const routeUrl = isSubscribed.value
      ? `/unsubscribe/${props.userId}`
      : `/subscribe/${props.userId}`
  
    router.post(routeUrl, {}, {
      preserveScroll: true,
      onSuccess: () => {
        isSubscribed.value = !isSubscribed.value
      }
    })
  }
  </script>
  