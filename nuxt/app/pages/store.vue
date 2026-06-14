<script setup>
// Отримуємо екземпляр стору (авто-імпорт в Nuxt 3)
const userStore = useUserStore()

// Деструктуризація зі збереженням реактивності
const { name, isLoggedIn, welcomeMessage, profileData, isLoading } = storeToRefs(userStore)

const inputName = ref('')

const handleLogin = () => {
  if (inputName.value) {
    userStore.login(inputName.value)
    inputName.value = ''
  }
}
</script>

<template>
  <div class="container">
    <h1>{{ welcomeMessage }}</h1>

    <div v-if="!isLoggedIn" class="login-form">
      <input v-model="inputName" placeholder="Введіть ваше ім'я" class="input" />
      <button @click="handleLogin" class="btn btn-primary">Увійти</button>
    </div>

    <div v-else class="user-panel">
      <p>Ви зайшли о: {{ userStore.loginTime }}</p>
      <button @click="userStore.logout" class="btn btn-secondary">Вийти</button>

      <hr class="divider" />

      <div class="profile-section">
        <h2>Завантаження профілю GitHub</h2>
        <button @click="userStore.fetchProfile" :disabled="isLoading" class="btn btn-primary">
          {{ isLoading ? 'Завантаження...' : 'Завантажити профіль' }}
        </button>

        <div v-if="profileData" class="profile-card">
          <img :src="profileData.avatar_url" alt="Avatar" class="avatar" />
          <div class="profile-info">
            <p><strong>Логін:</strong> {{ profileData.login }}</p>
            <p><strong>Ім'я:</strong> {{ profileData.name }}</p>
            <p><strong>Компанія:</strong> {{ profileData.company }}</p>
            <p><strong>Локація:</strong> {{ profileData.location }}</p>
            <p><strong>Публічні репозиторії:</strong> {{ profileData.public_repos }}</p>
            <p><strong>Підписники:</strong> {{ profileData.followers }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  padding: 2rem;
  font-family: sans-serif;
  max-width: 600px;
  margin: 0 auto;
}

.login-form {
  display: flex;
  gap: 0.5rem;
  margin-top: 1rem;
}

.input {
  padding: 0.5rem 1rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
  font-size: 1rem;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.375rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-primary {
  background-color: #70e000;
  color: white;
}

.btn-primary:hover {
  background-color: #5cb800;
}

.btn-primary:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.btn-secondary {
  background-color: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background-color: #d1d5db;
}

.user-panel {
  margin-top: 1rem;
}

.divider {
  margin: 1.5rem 0;
  border: none;
  border-top: 1px solid #e5e7eb;
}

.profile-section h2 {
  font-size: 1.25rem;
  margin-bottom: 1rem;
}

.profile-card {
  display: flex;
  gap: 1.5rem;
  margin-top: 1rem;
  padding: 1rem;
  background-color: #f9fafb;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
}

.profile-info p {
  margin: 0.25rem 0;
  font-size: 0.875rem;
}
</style>
