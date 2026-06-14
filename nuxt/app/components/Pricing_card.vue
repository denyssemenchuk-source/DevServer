<script setup lang="ts">
import { ref } from 'vue'
import {useSubscriptionStore} from "~/stores/useSubscriptionStore";

const tailwindSafelist = [
  'from-[#70e000]', 'to-[#00bbf9]',
  'from-[#00bbf9]', 'to-[#9b5de5]',
  'from-[#9b5de5]', 'to-[#f15bb5]'
]

const billingCycle = ref('annual')

const { data: plans } = await useFetch('/api/products')

const subscriptionStore = useSubscriptionStore()

const navigateToCheckout = (plan: any) => {
  // Зберігаємо обраний план в Pinia store
  subscriptionStore.selectPlan(plan, billingCycle.value as 'annual' | 'monthly')

  navigateTo({
    path: '/checkout',
    query: {
      plan: plan.name.toLowerCase(),
      billing: billingCycle.value
    }
  })
}
</script>

<template>
  <div class="max-w-[1100px] mx-auto mb-16">
    <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-8 gap-4">
      <h1 class="text-[32px] font-bold text-gray-900 tracking-tight">Start Your 3 Day Free Trial</h1>
      <div class="flex items-center space-x-4">
        <span class="text-[#70e000] text-sm font-semibold">Save up to 20% &#10549;</span>
        <div class="flex border border-gray-200 rounded-md overflow-hidden bg-white shadow-sm">
          <button
            @click="billingCycle = 'annual'"
            :class="['px-5 py-2 text-sm font-medium transition-colors', billingCycle === 'annual' ? 'bg-white text-gray-900 border-b-2 border-[#70e000]' : 'bg-gray-50 text-gray-500 hover:bg-gray-100']"
          >
            Annual
          </button>
          <button
            @click="billingCycle = 'monthly'"
            :class="['px-5 py-2 text-sm font-medium transition-colors', billingCycle === 'monthly' ? 'bg-white text-gray-900 border-b-2 border-[#70e000]' : 'bg-gray-50 text-gray-500 hover:bg-gray-100']"
          >
            Monthly
          </button>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center">
      <div
        v-for="plan in plans"
        :key="plan.name"
        class="relative bg-white w-full max-w-[340px] rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-transparent hover:border-black transition-colors duration-300 overflow-hidden flex flex-col"
      >
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r" :class="plan.gradient"></div>

        <div class="p-7 flex-grow flex flex-col">
          <h2 class="text-[22px] font-bold text-gray-900 mb-5">{{ plan.name }} - {{ billingCycle === 'annual' ? 'Annual' : 'Monthly' }}</h2>

          <div>
            <div class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2 py-1 rounded mb-1">
              3-days free then:
            </div>
          </div>

          <div class="flex items-baseline mb-1">
            <span class="text-[40px] font-extrabold text-gray-900 tracking-tight">${{ billingCycle === 'annual' ? plan.priceAnnual : plan.priceMonthly }}</span>
            <span class="text-gray-500 text-sm ml-1 font-medium">/month</span>
          </div>

          <div class="min-h-[20px] mb-4">
            <p v-if="billingCycle === 'annual'" class="text-gray-400 text-xs">
              billed yearly at <del>${{ plan.yearlyOld }}</del> <span class="text-black font-semibold">${{ plan.yearlyNew }}</span>
            </p>
          </div>

          <div class="min-h-[28px] mb-6">
            <div v-if="billingCycle === 'annual'" class="bg-green-50 text-[#70e000] text-xs font-bold px-3 py-1 rounded inline-block">
              ${{ plan.savings }} in savings
            </div>
          </div>

          <button @click="navigateToCheckout(plan)" class="w-full py-2.5 font-bold text-sm text-white rounded-md transition-all duration-500 mb-6 bg-gradient-to-r from-orange-400 via-pink-500 to-orange-400 bg-[length:200%_auto] hover:bg-right shadow-sm border-transparent cursor-pointer">
            Try It Free
          </button>

          <hr class="border-gray-100 mb-6">

          <ul class="space-y-4">
            <li v-for="(feature, index) in plan.features" :key="index" class="flex items-start">
              <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
              </svg>
              <div class="ml-3" v-html="feature"></div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
