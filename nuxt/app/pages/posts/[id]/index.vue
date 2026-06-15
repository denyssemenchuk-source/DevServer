<template>
  <div class="min-h-screen bg-gray-50 py-10 px-4 font-sans">
    <div class="max-w-3xl mx-auto">
      <div
        v-if="pending"
        class="text-center text-gray-500"
      >
        Завантаження поста...
      </div>

      <div
        v-else-if="error"
        class="bg-red-100 text-red-700 p-4 rounded-lg text-center font-medium"
      >
        Помилка: Пост не знайдено або сталася помилка на сервері.
      </div>

      <div
        v-else-if="post"
        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
      >
        <div class="p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-4">
            {{ post.title }}
          </h1>

          <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-8 pb-6 border-b border-gray-100">
            <div class="flex items-center gap-1">
              <UIcon
                name="i-heroicons-user"
                class="w-4 h-4"
              />
              <span>{{ post.user?.name || 'Невідомий автор' }}</span>
            </div>
            <div class="flex items-center gap-1">
              <UIcon
                name="i-heroicons-folder"
                class="w-4 h-4"
              />
              <span class="bg-green-50 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                {{ post.category?.title || 'Без категорії' }}
              </span>
            </div>
            <div class="flex items-center gap-1">
              <UIcon
                name="i-heroicons-calendar"
                class="w-4 h-4"
              />
              <span>{{ post.published_at || 'Чернетка' }}</span>
            </div>
          </div>

          <div class="text-gray-700 leading-relaxed text-lg">
            {{ post.content_raw }}
          </div>
        </div>
      </div>

      <div class="mt-6 text-center">
        <NuxtLink
          to="/BlogPost"
          class="inline-flex items-center gap-2 text-gray-500 hover:text-green-600 transition-colors font-medium"
        >
          <UIcon
            name="i-heroicons-arrow-left"
            class="w-5 h-5"
          />
          Повернутися до всіх постів
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'

// 1. Описуємо структуру нашого поста, щоб TypeScript знав, які поля там існують
interface Post {
  id: number
  title: string
  content_raw: string
  published_at: string | null
  user?: {
    name: string
  }
  category?: {
    title: string
  }
}

// Отримуємо доступ до параметрів URL
const route = useRoute()

// Беремо id з назви нашого файлу index.vue
const postId = route.params.id

// 2. Робимо запит, обов'язково вказавши тип <Post>
const { data: post, pending, error } = await useLazyFetch<Post>(`http://localhost:8000/api/blog/posts/${postId}`)
</script>
