<template>
  <div class="min-h-screen bg-gray-50 p-8 font-sans">
   <Pricing_card/>
  <div class="max-w-[1100px] mx-auto bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">

    <div class="mb-6 flex items-center justify-between">
      <UInput
        v-model="globalFilter"
        icon="i-heroicons-magnifying-glass-20-solid"
        placeholder="Шукати продукти..."
        class="max-w-sm"
        size="md"
      />
    </div>

    <UTable
      ref="table"
      v-model:sorting="sorting"
      v-model:pagination="pagination"
      v-model:global-filter="globalFilter"
      :data="products"
      :columns="columns"
      :pagination-options="{
        getPaginationRowModel: getPaginationRowModel()
      }"
      class="w-full border-t border-gray-100"
      :ui="{
        th: { padding: 'py-4', font: 'font-semibold', color: 'text-gray-100' },
        td: { padding: 'py-4' }
      }"
    >
      <template #thumbnail-cell="{ row }">
        <img :src="row.original.thumbnail" alt="Product" class="w-[100px] h-[100px] object-contain rounded-md bg-gray-50 border border-gray-100" />
      </template>

      <template #title-cell="{ row }">
        <span class="font-medium text-gray-900">{{ row.original.title }}</span>
      </template>

      <template #description-cell="{ row }">
        <div class="max-w-xs whitespace-normal text-gray-500 text-sm leading-relaxed">{{ row.original.description }}</div>
      </template>

      <template #price-cell="{ row }">
        <span class="font-bold text-gray-900">${{ row.original.price }}</span>
      </template>

      <template #rating-cell="{ row }">
    <span :class="row.original.rating >= 4.5 ? 'text-[#70e000] font-bold' : 'text-red-500 font-bold'">
      {{ row.original.rating }}
    </span>
      </template>

      <template #brand-cell="{ row }">
        <span class="text-gray-400 text-sm">{{ row.original.brand || 'Без бренду' }}</span>
      </template>

      <template #category-cell="{ row }">
        <span class="text-gray-400 text-sm">{{ row.original.category }}</span>
      </template>
    </UTable>

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

  const colorMode = useColorMode()
  colorMode.preference = 'light'

  const UButton = resolveComponent('UButton')


  const table = useTemplateRef('table')

  const sortableHeader = (label: string) => {
    return ({ column }: { column: any }) => {
      const isSorted = column.getIsSorted()
      return h(UButton, {
        color: 'neutral',
        variant: 'ghost',
        label: label,
        icon: isSorted
          ? isSorted === 'asc'
            ? 'i-lucide-arrow-up-narrow-wide'
            : 'i-lucide-arrow-down-wide-narrow'
          : 'i-lucide-arrow-up-down',
        class: '-mx-2.5',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc')
      })
    }
  }


  const columns = [
    { accessorKey: 'thumbnail', header: 'Фото' },
    { accessorKey: 'title', header: sortableHeader('Назва') },
    { accessorKey: 'description', header: sortableHeader('Опис') },
    { accessorKey: 'price', header: sortableHeader('Ціна') },
    { accessorKey: 'rating', header: sortableHeader('Оцінка') },
    { accessorKey: 'brand', header: sortableHeader('Бренд') },
    { accessorKey: 'category', header: sortableHeader('Категорія') }
  ]


  const { data } = await useLazyFetch('https://dummyjson.com/products?limit=200')
  const products = computed(() => data.value?.products || [])

  // 5. Стани таблиці (Пошук, Сортування, Пагінація)
  const globalFilter = ref('')
  const sorting = ref([{ id: 'title', desc: false }])
  const pagination = ref({
    pageIndex: 0,
    pageSize: 5
  })
</script>


<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
  body { font-family: 'Inter', sans-serif; }
</style>
