<template>
  <header class="z-10 py-4 bg-white shadow-md border-2 border-b-purple-600">
    <div class="container flex justify-between items-center px-6 mx-auto h-full text-purple-600 md:justify-end">
      <!-- Mobile hamburger -->
      <button @click="$page.props.showingMobileMenu = !$page.props.showingMobileMenu" class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" aria-label="Menu">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        </svg>
      </button>

      <!-- Add Medicamento Button -->
      <button @click="showModal = true" class="p-2 bg-purple-600 text-white rounded-md mr-4">
        Añadir Medicamento
      </button>

      <Dropdown>
        <template #trigger>
          <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" aria-label="Account" aria-haspopup="true">
            {{ $page.props.auth.user.name }}
          </button>
        </template>

        <template #content>
          <DropdownLink :href="route('profile.edit')">
            <template #icon>
              <svg class="mr-3 w-4 h-4" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Profile
            </template>
          </DropdownLink>

          <DropdownLink :href="route('logout')" method="post" as="button">
            <template #icon>
              <svg class="mr-3 w-4 h-4" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
              </svg>
              Log Out
            </template>
          </DropdownLink>
        </template>
      </Dropdown>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl mb-4">Añadir Medicamento</h2>
        <form @submit.prevent="addMedicamento">
          <div class="mb-4">
            <label for="name" class="block text-gray-700">Nombre</label>
            <input type="text" id="name" v-model="medicamento.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
          </div>
          <div class="mb-4">
            <label for="cantidad" class="block text-gray-700">Cantidad</label>
            <input type="number" id="cantidad" v-model="medicamento.cantidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
          </div>
          <div class="mb-4">
            <label for="precio" class="block text-gray-700">Precio por Unidad</label>
            <input type="number" step="0.01" id="precio" v-model="medicamento.precio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
          </div>
          <div class="flex justify-end">
            <button @click="showModal = false" type="button" class="mr-4 px-4 py-2 bg-gray-300 rounded-md">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showModal = ref(false);
const medicamento = ref({
  name: '',
  cantidad: 0,
  precio: 0.00,
});

const addMedicamento = () => {
  // Lógica para agregar medicamento
  // Podrías hacer una petición AJAX a tu backend aquí
  console.log(medicamento.value);
  showModal.value = false;
}
</script>
