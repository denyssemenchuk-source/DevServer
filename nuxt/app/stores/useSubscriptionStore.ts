import { defineStore } from 'pinia'

interface SubscriptionPlan {
  name: string
  gradient: string
  priceAnnual: number
  priceMonthly: number
  yearlyOld: string
  yearlyNew: string
  savings: string
  features: string[]
  billingCycle: 'annual' | 'monthly'
  displayPrice: number
  totalDue: string
}

export const useSubscriptionStore = defineStore('subscription', () => {
  // State
  const selectedPlan = ref<SubscriptionPlan | null>(null)
  const billingCycle = ref<'annual' | 'monthly'>('annual')

  // Getters
  const hasSelectedPlan = computed(() => selectedPlan.value !== null)

  const planSummary = computed(() => {
    if (!selectedPlan.value) return null
    return {
      name: selectedPlan.value.name,
      billingCycle: selectedPlan.value.billingCycle,
      displayPrice: selectedPlan.value.displayPrice,
      totalDue: selectedPlan.value.totalDue
    }
  })

  // Actions
  function selectPlan(plan: any, billing: 'annual' | 'monthly') {
    billingCycle.value = billing
    selectedPlan.value = {
      ...plan,
      billingCycle: billing === 'annual' ? 'Annual' : 'Monthly',
      displayPrice: billing === 'annual' ? plan.priceAnnual : plan.priceMonthly,
      totalDue: billing === 'annual' ? plan.yearlyNew : plan.priceMonthly.toString()
    }
  }

  function clearSelection() {
    selectedPlan.value = null
    billingCycle.value = 'annual'
  }

  return {
    selectedPlan,
    billingCycle,
    hasSelectedPlan,
    planSummary,
    selectPlan,
    clearSelection
  }
})
