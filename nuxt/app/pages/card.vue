<script setup lang="ts">
</script>
<template class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
  <div class="relative bg-white w-full max-w-[340px] rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-transparent hover:border-black transition-colors duration-300 overflow-hidden">

    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#70e000] to-[#00bbf9]"></div>

    <div class="p-7">
      <h2 class="text-[22px] font-bold text-gray-900 mb-5">Starter</h2>

      <div class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2 py-1 rounded mb-1">
        7-days free then:
      </div>

      <div class="flex items-baseline mb-1">
        <span class="text-[40px] font-extrabold text-gray-900 tracking-tight">$83.25</span>
        <span class="text-gray-500 text-sm ml-1 font-medium">/month</span>
      </div>

      <p class="text-gray-400 text-xs mb-6">Billed yearly at <span class="text-black">$999.00</span></p>

      <button class="w-full py-2.5 bg-[#e9ecef] text-gray-500 font-medium text-sm rounded-md border border-transparent hover:bg-white hover:border-gray-800 hover:text-gray-800 transition-all duration-200 mb-6">
        Downgrade to Starter
      </button>

      <hr class="border-gray-100 mb-6">

      <ul class="space-y-4">
        <li class="flex items-start">
          <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
          </svg>
          <div class="ml-3">
            <p class="text-[13px] text-gray-800 font-medium leading-snug">Primary user + 0 free team members</p>
            <p class="text-[#a1a1aa] text-[12px] mt-0.5">(extra team members for $35/month)</p>
          </div>
        </li>

        <li class="flex items-start">
          <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
          </svg>
          <div class="ml-3">
            <p class="text-[13px] text-gray-800 font-medium leading-snug">Save unlimited properties</p>
          </div>
        </li>

        <li class="flex items-start">
          <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
          </svg>
          <div class="ml-3">
            <p class="text-[13px] text-gray-800 font-bold leading-snug">10 000 <span class="font-medium">exports</span></p>
            <p class="text-[#a1a1aa] text-[12px] mt-0.5">(additional exports at $0.02 each)</p>
          </div>
        </li>

        <li class="flex items-start">
          <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
          </svg>
          <div class="ml-3">
            <p class="text-[13px] text-gray-800 font-bold leading-snug">500 <span class="font-medium">free skip traces</span></p>
            <p class="text-[#a1a1aa] text-[12px] mt-0.5">(additional skip tracing at $0.08 each)</p>
          </div>
        </li>

        <li class="flex items-start">
          <svg class="w-[18px] h-[18px] text-[#70e000] mt-[2px] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
          </svg>
          <div class="ml-3">
            <p class="text-[13px] text-gray-800 font-medium leading-snug">Imports $0.01</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
