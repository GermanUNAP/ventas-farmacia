<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      Ventas
    </template>

    <div class="p-4 bg-white rounded-lg shadow-xs">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Left Side: Medicamentos Table -->
        <div>
          <input
            v-model="query"
            @input="debouncedFetchData"
            placeholder="Buscar medicamentos..."
            class="p-2 border rounded my-2 w-full"
          />
          <div class="flex items-center mb-4">
            <label for="rowsPerPage" class="mr-2">Mostrar:</label>
            <div class="relative">
              <select
                id="rowsPerPage"
                v-model="rowsPerPage"
                @change="handleRowsPerPageChange"
                class="p-2 border rounded pl-8 pr-4"
              >
                <option v-for="option in pageOptions" :key="option" :value="option">
                  {{ option }}
                </option>
              </select>
            </div>
          </div>
          <table class="min-w-full bg-white">
            <thead>
              <tr>
                <th @click="changeSort('id')" class="cursor-pointer">
                  ID
                  <span v-if="sortBy === 'id'">
                    <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                  </span>
                </th>
                <th @click="changeSort('nombre')" class="cursor-pointer">
                  Nombre
                  <span v-if="sortBy === 'nombre'">
                    <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                  </span>
                </th>
                <th @click="changeSort('lote')" class="cursor-pointer">
                  Lote
                  <span v-if="sortBy === 'lote'">
                    <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                  </span>
                </th>
                <th @click="changeSort('cantidad')" class="cursor-pointer">
                  Cantidad
                  <span v-if="sortBy === 'cantidad'">
                    <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                  </span>
                </th>
                <th @click="changeSort('precio_unidad_vender')" class="cursor-pointer">
                  Precio
                  <span v-if="sortBy === 'precio_unidad_vender'">
                    <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                  </span>
                </th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="medicamento in medicamentos.data" :key="medicamento.id">
                <td class="text-center ">{{ medicamento.id }}</td>
                <td class="text-center ">{{ medicamento.nombre }}</td>
                <td class="text-center ">{{ medicamento.lote }}</td>
                <td class="text-center ">{{ medicamento.cantidad }}</td>
                <td class="text-center ">{{ medicamento.precio_unidad_vender }}</td>
                <td class="text-center ">
                  <button @click="addToCart(medicamento)" class="bg-purple-500 text-white px-2 py-1 rounded">Añadir</button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="flex justify-between mt-4 items-center">
            <button
              @click="changePage(medicamentos.prev_page_url)"
              :disabled="!medicamentos.prev_page_url"
              class="px-4 py-2 bg-gray-300 rounded flex items-center"
            >
              <span>&laquo;</span> Anterior
            </button>
            <span>Página {{ medicamentos.current_page }} de {{ medicamentos.last_page }}</span>
            <button
              @click="changePage(medicamentos.next_page_url)"
              :disabled="!medicamentos.next_page_url"
              class="px-4 py-2 bg-gray-300 rounded flex items-center"
            >
              Siguiente <span>&raquo;</span>
            </button>
          </div>
        </div>

        <!-- Right Side: Carrito de Compra -->
        <div>
          <div class="p-4 bg-gray-100 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Carrito de Compras</h2>
            <input v-model="dni" placeholder="DNI Comprador" class="p-2 border rounded w-full mb-4" />
            <div v-if="cart.length === 0">No hay medicamentos en el carrito</div>
            <ul v-else class="space-y-2">
              <li v-for="item in cart" :key="item.id" class="flex justify-between items-center bg-white p-2 rounded">
                <div>{{ item.nombre }}</div>
                <div>{{ item.precio_unidad_vender }} x {{ item.cantidad }}</div>
                <div>{{ (item.precio_unidad_vender * item.cantidad).toFixed(2) }}</div>
                <button @click="removeFromCart(item)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
              </li>
            </ul>
            <div class="mt-4">
              <div class="text-xl font-semibold">Total: {{ total.toFixed(2) }}</div>
              <button @click="checkout" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded">Realizar Venta</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { debounce } from 'lodash';

const medicamentos = ref({});
const query = ref('');
const sortBy = ref('id');
const descending = ref(false);
const page = ref(1);
const rowsPerPage = ref(5); // Valor inicial, puede cambiarse con el dropdown
const pageOptions = [5, 10, 15, 20]; // Opciones para el dropdown

const cart = ref([]);
const total = ref(0);
const dni = ref('');

const fetchData = async () => {
  try {
    const response = await axios.get('/buscar-medicamentos', {
      params: {
        query: query.value,
        sortBy: sortBy.value,
        descending: descending.value,
        page: page.value,
        rowsPerPage: rowsPerPage.value
      }
    });
    medicamentos.value = response.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

// Use lodash debounce to delay the fetchData call
const debouncedFetchData = debounce(fetchData, 1000);

const changeSort = (column) => {
  if (sortBy.value === column) {
    descending.value = !descending.value;
  } else {
    sortBy.value = column;
    descending.value = false;
  }
  fetchData();
};

const changePage = (url) => {
  if (url) {
    const urlParams = new URLSearchParams(url.split('?')[1]);
    page.value = urlParams.get('page');
    fetchData();
  }
};

// Re-fetch data when rowsPerPage changes
const handleRowsPerPageChange = () => {
  page.value = 1; // Reset to first page when changing rows per page
  fetchData();
};

const addToCart = (medicamento) => {
  const existing = cart.value.find(item => item.id === medicamento.id);
  if (existing) {
    existing.cantidad += 1;
  } else {
    cart.value.push({ ...medicamento, cantidad: 1 });
  }
  total.value += parseFloat(medicamento.precio_unidad_vender);
};

const removeFromCart = (item) => {
  const index = cart.value.findIndex(i => i.id === item.id);
  if (index !== -1) {
    if (cart.value[index].cantidad > 1) {
      cart.value[index].cantidad -= 1;
    } else {
      cart.value.splice(index, 1);
    }
    total.value -= parseFloat(item.precio_unidad_vender);
  }
};

const checkout = () => {
  // Obtener los datos necesarios para la venta
  const venta = {
    dni: dni.value,
    medicamentos: cart.value.map(item => ({
      id: item.id,
      cantidad: item.cantidad,
      precio_unidad_vender: item.precio_unidad_vender
    })),
    total: total.value
  };

  // Llamar a la API para guardar la venta
  axios.post('/realizar-venta', venta)
    .then(response => {
      // Limpiar el carrito y cualquier otro estado relacionado
      cart.value = [];
      total.value = 0;
      dni.value = '';
      toastr.success('Venta realizada con éxito');
    })
    .catch(error => {
      console.error('Error al realizar la venta:', error.response.data);
      alert('Error al realizar la venta');
      toastr.error('Ocurrió algun error al realizar la venta');
    });
};

onMounted(fetchData);
</script>

<style scoped>
th {
  cursor: pointer;
}
</style>
