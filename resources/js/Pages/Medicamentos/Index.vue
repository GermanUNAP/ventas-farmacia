<template>
  <Head title="Medicamentos" />

  <AuthenticatedLayout>
    <template #header>
      Medicamentos
    </template>

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
                <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
              </span>
            </th>
            <th @click="changeSort('nombre')" class="cursor-pointer">
              Nombre
              <span v-if="sortBy === 'nombre'">
                <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
              </span>
            </th>
            <th @click="changeSort('lote')" class="cursor-pointer">
              Lote
              <span v-if="sortBy === 'lote'">
                <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
              </span>
            </th>
            <th @click="changeSort('cantidad')" class="cursor-pointer">
              Cantidad
              <span v-if="sortBy === 'cantidad'">
                <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
              </span>
            </th>
            <th @click="changeSort('precio_unidad_vender')" class="cursor-pointer">
              Precio
              <span v-if="sortBy === 'precio_unidad_vender'">
                <svg v-if="!descending" class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                <svg v-else class="w-4 h-4 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
              </span>
            </th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="medicamento in medicamentos.data" :key="medicamento.id">
            <td class="text-center">{{ medicamento.id }}</td>
            <td class="text-center">{{ medicamento.nombre }}</td>
            <td class="text-center">{{ medicamento.lote }}</td>
            <td class="text-center">{{ medicamento.cantidad }}</td>
            <td class="text-center">{{ medicamento.precio_unidad_vender }}</td>
            <td class="text-center">
              <button @click="openEditModal(medicamento)" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
              <button @click="openDeleteModal(medicamento.id)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
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

    <!-- Modal para editar medicamento -->
    <div v-if="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded">
        <h2 class="text-lg font-semibold mb-4">Editar Medicamento</h2>
        <form @submit.prevent="updateMedicamento">
          <div class="mb-4">
            <label for="editNombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input
              type="text"
              id="editNombre"
              v-model="editForm.nombre"
              class="mt-1 p-2 border rounded w-full"
              required
            />
          </div>
          <div class="mb-4">
            <label for="editLote" class="block text-sm font-medium text-gray-700">Lote</label>
            <input
              type="text"
              id="editLote"
              v-model="editForm.lote"
              class="mt-1 p-2 border rounded w-full"
              required
            />
          </div>
          <div class="mb-4">
            <label for="editCantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
            <input
              type="number"
              id="editCantidad"
              v-model="editForm.cantidad"
              class="mt-1 p-2 border rounded w-full"
              required
            />
          </div>
          <div class="mb-4">
            <label for="editPrecio" class="block text-sm font-medium text-gray-700">Precio</label>
            <input
              type="number"
              id="editPrecio"
              v-model="editForm.precio_unidad_vender"
              class="mt-1 p-2 border rounded w-full"
              required
            />
          </div>
          <div class="flex justify-end">
            <button @click="closeEditModal" type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded">
        <h2 class="text-lg font-semibold mb-4">Eliminar Medicamento</h2>
        <p>¿Está seguro de que desea eliminar este medicamento?</p>
        <div class="flex justify-end mt-4">
          <button @click="closeDeleteModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
          <button @click="deleteMedicamento" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const medicamentos = ref([]);
const query = ref('');
const sortBy = ref('id');
const descending = ref(false);
const currentPage = ref(1);
const rowsPerPage = ref(10);
const page = ref(1);
const pageOptions = [10, 20, 30, 40, 50];
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const editForm = reactive({
  id: '',
  nombre: '',
  lote: '',
  cantidad: '',
  precio_unidad_vender: ''
});
const deleteId = ref(null);

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

const debouncedFetchData = debounce(fetchData, 800);

onMounted(fetchData);

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
    axios.get(url).then((response) => {
      medicamentos.value = response.data;
    });
  }
};

const handleRowsPerPageChange = () => {
  currentPage.value = 1;
  fetchData();
};

const openEditModal = (medicamento) => {
  editForm.id = medicamento.id;
  editForm.nombre = medicamento.nombre;
  editForm.lote = medicamento.lote;
  editForm.cantidad = medicamento.cantidad;
  editForm.precio_unidad_vender = medicamento.precio_unidad_vender;
  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
};

const updateMedicamento = () => {
  axios
    .put(route('ventas-farmacia.actualizar-medicamento', editForm.id), editForm)
    .then(() => {
      fetchData();
      showEditModal.value = false;
    })
    .catch((error) => {
      console.error(error);
    });
};

const openDeleteModal = (id) => {
  deleteId.value = id;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
};

const deleteMedicamento = () => {
  axios
    .delete(route('ventas-farmacia.eliminar-medicamento', deleteId.value))
    .then(() => {
      fetchData();
      showDeleteModal.value = false;
    })
    .catch((error) => {
      console.error(error);
    });
};
</script>

<style scoped>
/* Aquí puedes añadir tus estilos personalizados */
</style>
