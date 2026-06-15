<template>
  <div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">

      <div class="mb-6 flex items-center gap-4">
        <UButton to="/categories" color="gray" variant="ghost" icon="i-heroicons-arrow-left" />
        <h1 class="text-2xl font-bold text-gray-800">Створити категорію</h1>
      </div>

      <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">

        <UFormGroup label="Назва категорії" name="title" required>
          <UInput v-model="state.title" placeholder="Введіть назву..." />
        </UFormGroup>

        <UFormGroup label="Опис" name="description">
          <UTextarea v-model="state.description" placeholder="Короткий опис категорії..." />
        </UFormGroup>

        <UFormGroup label="ID Батьківської категорії" name="parent_id">
          <UInput v-model="state.parent_id" type="number" />
        </UFormGroup>

        <div class="flex justify-end pt-4">
          <UButton type="submit" color="primary" :loading="isSubmitting">
            Зберегти
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

// 1. Описуємо правила валідації за допомогою Zod
const schema = z.object({
  title: z.string().min(3, 'Назва має містити мінімум 3 символи').max(200, 'Занадто довга назва'),
  description: z.string().optional(),
  parent_id: z.coerce.number().min(1, 'ID має бути більшим за 0') // coerce перетворює рядок на число
})

// 2. Стан (дані) форми
const state = reactive({
  title: '',
  description: '',
  parent_id: 1
})

// 3. Відправка даних на сервер Laravel
async function onSubmit(event: any) {
  isSubmitting.value = true
  try {
    // event.data містить вже провалідовані дані
    await $fetch('http://127.0.0.1:8000/api/admin/blog/categories', {
      method: 'POST',
      body: event.data
    })

    alert('Категорію успішно створено!')
    router.push('/categories') // Повертаємось до списку
  } catch (error: any) {
    console.error('Помилка збереження:', error)
    alert('Помилка при збереженні. Перевірте консоль.')
  } finally {
    isSubmitting.value = false
  }
}
</script>
