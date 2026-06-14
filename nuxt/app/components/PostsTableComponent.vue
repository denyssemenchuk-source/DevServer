<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-center">
      <div class="w-full max-w-5xl">
        <nav class="bg-gray-100 p-3 mb-4 rounded flex justify-between items-center">
          <span class="font-bold text-lg">Пости блогу</span>
          <a
            href="/admin/blog/posts/create"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
          >Додати</a>
        </nav>
        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
          <div class="p-4">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-gray-50 border-b">
                  <th class="p-3">
                    #
                  </th>
                  <th class="p-3">
                    Автор
                  </th>
                  <th class="p-3">
                    Категорія
                  </th>
                  <th class="p-3">
                    Заголовок
                  </th>
                  <th class="p-3">
                    Дата публікації
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="post in posts"
                  :key="post.id"
                  class="border-b hover:bg-gray-50"
                >
                  <td class="p-3">
                    {{ post.id }}
                  </td>
                  <td class="p-3">
                    {{ post.user?.name || 'Невідомо' }}
                  </td>
                  <td class="p-3">
                    {{ post.category?.title || 'Без категорії' }}
                  </td>
                  <td class="p-3">
                    <a
                      :href="'/admin/blog/posts/' + post.id + '/edit'"
                      class="text-blue-600 hover:underline"
                    >
                      {{ post.title }}
                    </a>
                  </td>
                  <td class="p-3">
                    {{ post.published_at || 'Чернетка' }}
                  </td>
                </tr>
              </tbody>
            </table>
            <div
              v-if="posts.length === 0"
              class="text-center p-6 text-gray-500"
            >
              Немає даних для відображення або завантаження...
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

// 1. Описуємо структуру (тип) нашого посту
interface Post {
  id: number
  title: string
  published_at: string | null
  user?: {
    name: string
  }
  category?: {
    title: string
  }
}

// 2. Описуємо структуру відповіді від Laravel (через пагінацію масив лежить в полі data)
interface PaginatedResponse {
  data: Post[]
}

// 3. Вказуємо, що posts - це масив об'єктів типу Post
const posts = ref<Post[]>([])

const getPosts = async () => {
  try {
    // Використовуємо наш тип PaginatedResponse замість "any"
    const response = await $fetch<PaginatedResponse>('http://localhost:8000/api/admin/blog/posts')
    console.log('Дані з Laravel:', response)

    // Зберігаємо масив постів
    posts.value = response.data || []
  } catch (err) {
    console.error('Помилка завантаження:', err)
  }
}

onMounted(() => {
  getPosts()
})
</script>
