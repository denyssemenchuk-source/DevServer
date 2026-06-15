<template>
  <div class="min-h-screen bg-gray-50 p-8 font-sans">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">

      <div class="mb-6 flex items-center gap-4">
        <UButton to="/BlogPostsUi" color="gray" variant="ghost" icon="i-heroicons-arrow-left" />
        <h1 class="text-2xl font-bold text-gray-800">Створити новий пост</h1>
      </div>

      <UForm :schema="schema" :state="state" class="space-y-5" @submit="onSubmit">

        <UFormField label="Заголовок поста" name="title" required>
          <UInput v-model="state.title" placeholder="Наприклад: Мій перший пост..." />
        </UFormField>

        <UFormField label="Слаг (URL)" name="slug" required>
          <UInput v-model="state.slug" placeholder="Наприклад: mij-pershiy-post" />
        </UFormField>

        <UFormField label="ID Категорії" name="category_id" required>
          <UInput v-model="state.category_id" type="number" placeholder="Введіть число (ID категорії)" />
        </UFormField>

        <UFormField label="Текст поста" name="content_raw" required>
          <UTextarea v-model="state.content_raw" :rows="6" placeholder="Напишіть щось цікаве..." />
        </UFormField>

        <div class="flex justify-end pt-4 border-t border-gray-100 mt-6">
          <UButton type="submit" color="primary" size="lg" :loading="isSubmitting">
            Зберегти пост
          </UButton>
        </div>

      </UForm>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { z } from 'zod'
import { useRouter } from 'vue-router'

const router = useRouter()
const isSubmitting = ref(false)

// 1. Правила валідації (Zod)
const schema = z.object({
  title: z.string().min(5, 'Заголовок має містити мінімум 5 символів'),
  slug: z.string().min(3, 'Слаг має містити мінімум 3 символи'),
  category_id: z.coerce.number().min(1, 'Вкажіть існуючий ID категорії'),
  content_raw: z.string().min(10, 'Текст поста занадто короткий (мінімум 10 символів)')
})

// 2. Початковий стан форми
const state = reactive({
  title: '',
  slug: '',
  category_id: '',
  content_raw: ''
})

// 3. Відправка даних на Laravel API
async function onSubmit(event: any) {
  isSubmitting.value = true
  try {
    // Відправляємо POST запит
    await $fetch('http://localhost:8000/api/admin/blog/posts', {
      method: 'POST',
      body: event.data // event.data містить дані, які успішно пройшли валідацію Zod
    })

    alert('Пост успішно створено!')
    router.push('/BlogPostsUi') // Повертаємось до списку постів
  } catch (error: any) {
    console.error('Помилка збереження:', error)
    alert('Помилка при збереженні! Перевірте консоль.')
  } finally {
    isSubmitting.value = false
  }
}
</script>
