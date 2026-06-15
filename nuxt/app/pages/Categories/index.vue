<template>
  <div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-[1100px] mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Управління категоріями</h1>
        <UButton to="/categories/create" color="primary" variant="solid" icon="i-heroicons-plus">
          Додати категорію
        </UButton>
      </div>

      <UTable :rows="formattedCategories" :columns="columns" :loading="pending">
        <template #actions-data="{ row }">
          <UDropdown :items="getActionItems(row)">
            <UButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
          </UDropdown>
        </template>
      </UTable>

    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

// Налаштування колонок таблиці (додаємо колонку actions)
const columns = [
  { key: 'id', label: '#' },
  { key: 'title', label: 'Назва' },
  { key: 'slug', label: 'Псевдонім' },
  { key: 'parent_title', label: 'Батьківська категорія' },
  { key: 'actions', label: 'Дії' } // Колонка для випадаючого меню
]

// Завантаження даних з API
const { data, pending, refresh } = await useLazyFetch('http://127.0.0.1:8000/api/admin/blog/categories')

const formattedCategories = computed(() => {
  return data.value?.data || [] // Беремо дані з API Resource
})

// Функція видалення
const deleteCategory = async (id: number) => {
  if (!confirm('Ви впевнені, що хочете видалити цю категорію?')) return;

  try {
    await $fetch(`http://127.0.0.1:8000/api/admin/blog/categories/${id}`, {
      method: 'DELETE'
    });
    alert('Категорію видалено!');
    refresh(); // Оновлюємо таблицю після видалення
  } catch (error) {
    alert('Помилка видалення');
    console.error(error);
  }
}

// Формування пунктів випадаючого меню для кожного рядка
const getActionItems = (row: any) => [
  [
    {
      label: 'Редагувати',
      icon: 'i-heroicons-pencil-square-20-solid',
      to: `/categories/${row.id}/edit` // Посилання на сторінку редагування
    }
  ],
  [
    {
      label: 'Видалити',
      icon: 'i-heroicons-trash-20-solid',
      class: 'text-red-500',
      click: () => deleteCategory(row.id)
    }
  ]
]
</script>
