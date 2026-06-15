<template>
  <div class="min-h-screen bg-gray-50 p-8 font-sans">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">

      <div class="mb-6 flex items-center gap-4">
        <UButton to="/BlogPosts" color="gray" variant="ghost" icon="i-heroicons-arrow-left" />
        <h1 class="text-2xl font-bold text-gray-800">Редагувати пост</h1>
      </div>

      <div v-if="pending" class="text-center text-gray-500 py-10">
        Завантаження даних поста...
      </div>

      <UForm v-else :schema="schema" :state="state" class="space-y-5" @submit="onSubmit">

        <UFormField label="Заголовок поста" name="title" required>
          <UInput v-model="state.title" />
        </UFormField>

        <UFormField label="Слаг (URL)" name="slug" required>
          <UInput v-model="state.slug" />
        </UFormField>

        <UFormField label="ID Категорії" name="category_id" required>
          <UInput v-model="state.category_id" type="number" />
        </UFormField>

        <UFormField label="Текст поста" name="content_raw" required>
          <UTextarea v-model="state.content_raw" :rows="6" />
        </UFormField>

        <div class="flex justify-end pt-4 border-t border-gray-100 mt-6">
          <UButton type="submit" color="primary" size="lg" :loading="isSubmitting">
            Оновити пост
          </UButton>
        </div>

      </UForm>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, watch } from 'vue'
import { z } from 'zod'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const toast = useToast() // Підключаємо красиві повідомлення
const postId = route.params.id

const isSubmitting = ref(false)

// 1. Схема валідації
const schema = z.object({
  title: z.string().min(5, 'Заголовок має містити мінімум 5 символів'),
  slug: z.string().min(3, 'Слаг має містити мінімум 3 символи'),
  category_id: z.coerce.number().min(1, 'Вкажіть ID категорії'),
  content_raw: z.string().min(10, 'Текст поста занадто короткий')
})

// 2. Стан форми
const state = reactive({
  title: '',
  slug: '',
  category_id: '',
  content_raw: ''
})

// 3. Завантажуємо поточні дані поста (через наш публічний API)
const { data: postData, pending } = await useLazyFetch(`http://127.0.0.1:8000/api/blog/posts/${postId}`)

// Як тільки дані прийшли - заповнюємо форму
watch(postData, (newData: any) => {
  if (newData) {
    state.title = newData.title
    state.slug = newData.slug || ''
    state.category_id = newData.category_id
    state.content_raw = newData.content_raw
  }
}, { immediate: true })

// 4. Відправка оновлених даних (зверніть увагу на метод PATCH)
async function onSubmit(event: any) {
  isSubmitting.value = true
  try {
    await $fetch(`http://127.0.0.1:8000/api/admin/blog/posts/${postId}`, {
      method: 'PATCH',
      body: event.data
    })

    // Красиве повідомлення замість alert!
    toast.add({
      title: 'Успіх!',
      description: 'Пост успішно оновлено.',
      color: 'green'
    })

    router.push('/BlogPosts')
  } catch (error: any) {
    toast.add({
      title: 'Помилка!',
      description: 'Не вдалося оновити пост. Перевірте консоль.',
      color: 'red'
    })
    console.error(error)
  } finally {
    isSubmitting.value = false
  }
}
</script>
