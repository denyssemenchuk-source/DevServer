<template>
  <div class="min-h-screen bg-gray-50 font-sans pb-16">
    <Head>
      <Title>Checkout - Start Your 3-Day Free Trial</Title>
    </Head>
    <Header class="bg-[#3f3f40] text-white py-4 text-center font-bold text-lg shadow-sm">
      Checkout
    </Header>

    <div class="max-w-[1000px] mx-auto px-6 pt-8">
      <NuxtLink to="/" class="text-gray-500 hover:text-gray-800 text-sm mb-6 inline-block transition-colors">
        &lt;&lt; back
      </NuxtLink>

      <h1 class="text-3xl font-bold text-gray-800 mb-3 tracking-tight">You're Almost In - Start Your 3-Day Free Trial Now!</h1>
      <p class="text-gray-600 mb-6 text-[17px]">
        Set up your account to gain instant access! You won't be charged if you decide to cancel within 3 days
      </p>

      <!-- Блок з інформацією про обрану підписку із Pinia Store -->
      <div v-if="subscriptionStore.hasSelectedPlan" class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
        <div class="flex items-center gap-2 mb-2">
          <svg class="w-5 h-5 text-[#70e000]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
          </svg>
          <span class="font-bold text-gray-800">Дані з Pinia Store:</span>
        </div>
        <p class="text-sm text-gray-600">
          <span class="font-medium">План:</span> {{ subscriptionStore.planSummary?.name }} |
          <span class="font-medium">Період:</span> {{ subscriptionStore.planSummary?.billingCycle }} |
          <span class="font-medium">Ціна:</span> ${{ subscriptionStore.planSummary?.displayPrice }}/місяць |
          <span class="font-medium">До сплати:</span> ${{ subscriptionStore.planSummary?.totalDue }}
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-[340px_1fr] gap-8">

        <div v-if="plan" class="relative bg-white w-full rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-transparent overflow-hidden flex flex-col h-fit">
          <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r" :class="plan.gradient"></div>
          <div class="p-7">
            <h2 class="text-[22px] font-bold text-gray-900 mb-5">{{ plan.name }} - {{ plan.billingCycle }}</h2>
            <div class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2 py-1 rounded mb-1">
              3-days free then:
            </div>
            <div class="flex items-baseline mb-1">
              <span class="text-[40px] font-extrabold text-gray-900 tracking-tight">${{ plan.displayPrice }}</span>
              <span class="text-gray-500 text-sm ml-1 font-medium">/month</span>
            </div>
            <div class="min-h-[20px] mb-4">
              <p v-if="plan.billingCycle === 'Annual'" class="text-gray-400 text-xs">
                billed yearly at <del>${{ plan.yearlyOld }}</del> <span class="text-black font-semibold">${{ plan.yearlyNew }}</span>
              </p>
            </div>
            <div class="min-h-[28px] mb-6">
              <div v-if="plan.billingCycle === 'Annual'" class="bg-green-50 text-[#70e000] text-xs font-bold px-3 py-1 rounded inline-block">
                ${{ plan.savings }} in savings
              </div>
            </div>
            <hr class="border-gray-100 mb-6">
            <ul class="space-y-4">
              <li v-for="(feature, index) in plan.features" :key="index" class="flex items-start">
                <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/></svg>
                <div class="ml-3" v-html="feature"></div>
              </li>
            </ul>
          </div>
        </div>

        <div v-if="plan" class="bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-8 h-fit">
          <form @submit.prevent="submitCheckout">

            <h3 class="text-lg font-bold text-gray-800 mb-6">Order Summary</h3>
            <div class="space-y-3 text-sm text-gray-600 mb-6">
              <div class="flex justify-between">
                <span>{{ plan.billingCycle }} Plan</span>
                <span class="font-medium text-gray-800">${{ plan.totalDue }}</span>
              </div>
              <div class="flex justify-between items-center">
                <span>Total Due <span class="text-[11px] text-gray-400">(*not including sales tax where applicable)</span></span>
                <span class="font-medium text-gray-800">${{ plan.totalDue }}</span>
              </div>
              <div class="flex justify-between font-bold text-gray-900 pt-2 border-t">
                <span>Due Today</span>
                <span>$0.00</span>
              </div>
            </div>
            <div class="bg-gray-100 text-center text-gray-600 text-sm font-medium py-3 rounded-md mb-8">
              Includes 3-Day Free Trial
            </div>

            <div class="flex items-center space-x-2 mb-4">
              <h3 class="text-lg font-bold text-gray-800">Billing Information</h3>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>

            <div class="mb-5">
              <label class="block text-sm text-gray-600 mb-2">Card Details</label>
              <div class="flex border rounded-md shadow-sm overflow-hidden bg-white focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                <div class="flex items-center pl-3 text-gray-400 bg-gray-50 border-r px-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <input v-model="form.cardNumber" type="text" placeholder="Number" class="w-full px-3 py-2.5 text-sm outline-none text-gray-700 bg-gray-50 placeholder-gray-400" required>
                <input v-model="form.expiry" type="text" placeholder="MM / YY" class="w-24 px-3 py-2.5 text-sm outline-none border-l text-gray-700 bg-gray-50 placeholder-gray-400 text-center" required>
                <input v-model="form.cvc" type="text" placeholder="CVC" class="w-20 px-3 py-2.5 text-sm outline-none border-l text-gray-700 bg-gray-50 placeholder-gray-400 text-center" required>
              </div>
            </div>

            <div class="mb-6 bg-gray-50/50 p-4 rounded-md border border-gray-100">
              <label class="block text-sm text-gray-600 mb-3">Address</label>

              <div class="mb-3">
                <label class="block text-xs text-gray-500 mb-1">Full name</label>
                <input v-model="form.fullName" type="text" class="w-full border rounded text-sm px-3 py-2.5 outline-none focus:ring-1 focus:ring-blue-500 text-gray-700" required>
              </div>

              <div>
                <label class="block text-xs text-gray-500 mb-1">Address</label>
                <input v-model="form.address" type="text" class="w-full border rounded text-sm px-3 py-2.5 outline-none focus:ring-1 focus:ring-blue-500 text-gray-700" required>
              </div>
            </div>

            <div class="flex items-start mb-6">
              <div class="flex items-center h-5">
                <input v-model="form.consent" id="consent" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" required>
              </div>
              <label for="consent" class="ml-2 text-[12px] text-gray-500 leading-tight">
                I consent to <a href="#" class="font-bold underline text-gray-600 hover:text-gray-900">Terms of Use</a> and understand my 3-day free trial will automatically convert to <b>${{ plan.totalDue }} per {{ plan.billingCycle === 'Annual' ? 'year' : 'month' }}</b> starting on 04/02/2026. The yearly fee will be automatically charged each year going forward unless I cancel my account at least one (1) business day before the end of the current billing period, which can be done by calling (888) 463-3163.
              </label>
            </div>

            <button
              type="submit"
              :disabled="isLoading"
              :class="[
                'w-full py-3 rounded font-bold text-sm transition-all duration-200 shadow-sm',
                form.consent && !isLoading ? 'bg-orange-400 text-white hover:bg-orange-500 cursor-pointer' : 'bg-[#e5e7eb] text-gray-400 cursor-not-allowed'
              ]"
            >
              {{ isLoading ? 'Processing...' : 'Try It Free' }}
            </button>
            <p v-if="successMessage" class="text-green-600 text-sm mt-3 text-center font-medium">{{ successMessage }}</p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const subscriptionStore = useSubscriptionStore()
const { selectedPlan: storedPlan } = storeToRefs(subscriptionStore)


const route = useRoute()


const { data: apiFetchedPlan } =await useFetch('/api/checkout-plan', {
  query: {
    plan: route.query.plan || 'team',
    billing: route.query.billing || 'annual'
  }
})

const plan = computed(() => storedPlan.value || apiFetchedPlan.value)

const form = ref({
  cardNumber: '',
  expiry: '',
  cvc: '',
  fullName: '',
  address: '',
  consent: false
})

const isLoading = ref(false)
const successMessage = ref('')

const submitCheckout = async () => {
  if (!form.value.consent) return
  isLoading.value = true
  successMessage.value = ''

  try {
    const response = await $fetch('/api/subscription/create', {
      method: 'POST',
      body: {
        ...form.value,
        selectedPlan: plan.value.name,
        billingCycle: plan.value.billingCycle
      }
    })

    if (response.success) {
      successMessage.value = response.message
    }
  } catch (error) {
    console.error('Помилка при створенні підписки:', error)
    alert('Сталася помилка при відправці форми.')
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
</style>
