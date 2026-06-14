<template>
  <div class="min-h-screen bg-gray-50 p-8 font-sans">
    <div class="max-w-[1100px] mx-auto bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
          Блог Пости (Nuxt UI)
        </h1>
        <UButton color="primary" variant="solid" label="Додати новий" icon="i-heroicons-plus" />
      </div>

      <UTable
        ref="table"
        v-model:pagination="pagination"
        :data="formattedPosts"
        :columns="columns"
        :pagination-options="{
          getPaginationRowModel: getPaginationRowModel()
        }"
        class="w-full border-t border-gray-100"
        :ui="{
          th: { padding: 'py-4', font: 'font-semibold', color: 'text-gray-900' },
          td: { padding: 'py-4' }
        }"
      >
        <template #title-cell="{ row }">
          <NuxtLink :to="'/admin/blog/posts/' + row.original.id + '/edit'" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
            {{ row.original.title }}
          </NuxtLink>
        </template>
      </UTable>

      <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
        <div class="text-sm text-gray-500 font-medium">
          Всього записів: {{ table?.tableApi?.getFilteredRowModel().rows.length || 0 }}
        </div>

        <UPagination
          :page="(table?.tableApi?.getState().pagination.pageIndex || 0) + 1"
          :items-per-page="table?.tableApi?.getState().pagination.pageSize"
          :total="table?.tableApi?.getFilteredRowModel().rows.length"
          @update:page="(p) => table?.tableApi?.setPageIndex(p - 1)"
          :active-button="{ color: 'green', variant: 'solid' }"
          :inactive-button="{ color: 'gray', variant: 'solid' }"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, useTemplateRef } from 'vue'
import { getPaginationRowModel } from '@tanstack/vue-table'

const table = useTemplateRef('table')

// Визначаємо колонки для UTable
const columns = [
  { accessorKey: 'id', header: '#' },
  { accessorKey: 'author', header: 'Автор' },
  { accessorKey: 'category', header: 'Категорія' },
  { accessorKey: 'title', header: 'Заголовок' },
  { accessorKey: 'published_at', header: 'Дата публікації' }
]

// Завантажуємо дані з Laravel API
const { data } = await useLazyFetch('http://localhost:8000/api/admin/blog/posts')

// Форматуємо дані для таблиці (захист від null значень)
const formattedPosts = computed(() => {
  const rawData = data.value?.data || [] // Беремо .data, бо Laravel загортає пагінацію в об'єкт
  return rawData.map((post: any) => ({
    id: post.id,
    author: post.user?.name || 'Невідомо',
    category: post.category?.title || 'Без категорії',
    title: post.title,
    published_at: post.published_at || 'Чернетка'
  }))
})

// Стейт для пагінації на стороні клієнта
const pagination = ref({
  pageIndex: 0,
  pageSize: 10 // Кількість постів на сторінку
})
</script>
