<template #status-cell="{ row }">
  <div class="min-h-screen bg-gray-50 p-8 font-sans">
    <div class="max-w-[1100px] mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Блог Пости (Користувач)</h1>
        <UButton to="/posts/create" color="primary" variant="solid" icon="i-heroicons-plus">
          Створити пост
        </UButton>
      </div>

      <div class="mb-6 flex items-center">
        <UInput
          v-model="globalFilter"
          icon="i-heroicons-magnifying-glass-20-solid"
          placeholder="Шукати по автору, ID, заголовку..."
          class="max-w-sm w-full"
          size="md"
        />
      </div>

      <UBadge
        ref="table"
        v-model:sorting="sorting"
        v-model:pagination="pagination"
        v-model:global-filter="globalFilter"
        :data="formattedPosts"
        :columns="columns"
        :loading="pending"
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
          <NuxtLink :to="'/posts/' + row.original.id" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
            {{ row.original.title }}
          </NuxtLink>
        </template>

        <template #actions-cell="{ row }">
          <UDropdownMenu :items="getActionItems(row.original)">
            <UButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
          </UDropdownMenu>
        </template>
      </UBadge>

      <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
        <div class="text-sm text-gray-500 font-medium">
          Всього знайдено: {{ table?.tableApi?.getFilteredRowModel().rows.length || 0 }}
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
import { ref, computed, h, resolveComponent, useTemplateRef } from 'vue'
import { getPaginationRowModel } from '@tanstack/vue-table'

const UButton = resolveComponent('UButton')
const table = useTemplateRef('table')

const sortableHeader = (label: string) => {
  return ({ column }: { column: any }) => {
    const isSorted = column.getIsSorted()
    return h(UButton, {
      color: 'neutral',
      variant: 'ghost',
      label: label,
      icon: isSorted ? (isSorted === 'asc' ? 'i-lucide-arrow-up-narrow-wide' : 'i-lucide-arrow-down-wide-narrow') : 'i-lucide-arrow-up-down',
      class: '-mx-2.5 font-semibold text-gray-900',
      onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
    })
  }
}

// Повертаємо всі колонки, включаючи Дії та ID
const columns = [
  { accessorKey: 'id', header: sortableHeader('ID') },
  { accessorKey: 'author', header: sortableHeader('Автор') },
  { accessorKey: 'category', header: sortableHeader('Категорія') },
  { accessorKey: 'title', header: sortableHeader('Заголовок') },
  { accessorKey: 'status', header: sortableHeader('Статус') },
  { accessorKey: 'actions', header: 'Дії' }
]

const { data, pending, refresh } = await useLazyFetch('http://127.0.0.1:8000/api/admin/blog/posts')

const formattedPosts = computed(() => {
  const rawData = data.value?.data || []
  return rawData.map((post: any) => ({
    id: post.id,
    author: post.user?.name || 'Невідомо',
    category: post.category?.title || 'Без категорії',
    title: post.title,
    // Зберігаємо справжню дату, але додаємо ще й поле статусу
    published_at: post.published_at,
    status: post.is_published ? 'Опубліковано' : 'Чернетка'
  }))
})

const globalFilter = ref('')
const sorting = ref([{ id: 'id', desc: true }])
const pagination = ref({ pageIndex: 0, pageSize: 10 })

const toast = useToast()
// Повертаємо функцію видалення
const deletePost = async (id: number) => {
  if (!confirm('Ви впевнені, що хочете видалити цей пост?')) return;
  try {
    await $fetch(`http://localhost:8000/api/admin/blog/posts/${id}`, { method: 'DELETE' });
    alert('Пост видалено!');
    refresh(); // Оновлюємо таблицю
  } catch (error) {
    alert('Помилка видалення!');
    console.error(error);
  }
}

// Повертаємо меню дій (Перегляд, Редагування, Видалення)
const getActionItems = (post: any) => [
  [
    { label: 'Переглянути', icon: 'i-heroicons-eye-20-solid', to: `/posts/${post.id}` },
    { label: 'Редагувати', icon: 'i-heroicons-pencil-square-20-solid', to: `/posts/${post.id}/edit` }
  ],
  [
    { label: 'Видалити', icon: 'i-heroicons-trash-20-solid', class: 'text-red-500', onSelect: () => deletePost(post.id) }
  ]
]
</script>
