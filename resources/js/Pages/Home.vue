<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated class="bg-primary text-white" height-hint="98">
      <q-toolbar>
        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg" alt="Quasar logo">
          </q-avatar>
          Medicamentos
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page class="row q-col-gutter-md">
        <!-- Left Side: Medicamentos Table -->
        <div class="col-12 col-md-8">
          <q-table
            flat bordered
            ref="tableRef"
            title="Medicamentos"
            :rows="rows"
            :columns="columns"
            row-key="id"
            v-model:pagination.sync="pagination"
            :loading="loading"
            :filter="filter"
            binary-state-sort
            @request="onRequest"
          >
            <template v-slot:top-right>
              <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar medicamentos...">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            <template v-slot:body-cell-actions="props">
              <q-td align="center">
                <q-btn flat round icon="add" @click="addToCart(props.row)" />
              </q-td>
            </template>
          </q-table>
        </div>

        <!-- Right Side: Carrito de Compra -->
        <div class="col-12 col-md-4">
          <q-card>
            <q-card-section>
              <div class="text-h6">Carrito de Compras</div>
            </q-card-section>
            <q-separator />
            <q-card-section>
              <q-input v-model="dni" label="DNI Comprador" dense />
              <div v-if="cart.length === 0">No hay medicamentos en el carrito</div>
              <q-list v-else>
                <q-item v-for="item in cart" :key="item.id" class="q-py-xs">
                  <q-item-section>{{ item.nombre }}</q-item-section>
                  <q-item-section>{{ item.precio_unidad_vender }} x {{ item.cantidad }}</q-item-section>
                  <q-item-section>{{ (item.precio_unidad_vender * item.cantidad).toFixed(2) }}</q-item-section>
                  <q-item-section>
                    <q-btn flat round icon="remove_circle" @click="removeFromCart(item)" />
                  </q-item-section>
                </q-item>
              </q-list>
            </q-card-section>
            <q-separator />
            <q-card-section>
              <div class="text-h6">Total: {{ total.toFixed(2) }}</div>
              <q-btn color="primary" class="q-mt-md" @click="checkout">Concretar Venta</q-btn>
            </q-card-section>
          </q-card>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { ref, onMounted, watch } from 'vue';

export default {
  setup() {
    const tableRef = ref(null);
    const rows = ref([]);
    const filter = ref('');
    const loading = ref(false);
    const pagination = ref({
      sortBy: 'id',
      descending: false,
      page: 1,
      rowsPerPage: 10,
      rowsNumber: 0
    });

    const columns = [
      { name: 'id', required: true, label: 'ID', align: 'left', field: 'id', sortable: true },
      { name: 'nombre', align: 'left', label: 'Nombre', field: 'nombre', sortable: true },
      { name: 'cantidad', align: 'center', label: 'Cantidad', field: 'cantidad', sortable: true },
      { name: 'precio_unidad_vender', align: 'center', label: 'Precio Unidad', field: 'precio_unidad_vender', sortable: true },
      { name: 'precio_venta', align: 'center', label: 'Precio Venta', field: 'precio_venta', sortable: true },
      { name: 'precio_comprado', align: 'center', label: 'Precio Comprado', field: 'precio_comprado', sortable: true },
      { name: 'vencimiento', align: 'center', label: 'Vencimiento', field: 'vencimiento', sortable: true },
      { name: 'lote', align: 'center', label: 'Lote', field: 'lote', sortable: true },
      { name: 'actions', label: 'Actions', align: 'center' }
    ];

    const cart = ref([]);
    const total = ref(0);
    const dni = ref('');

    function fetchMedicamentos(query, page, rowsPerPage, sortBy, descending) {
      loading.value = true;

      fetch(`http://ventas-farmacia.test/buscar-medicamentos?query=${query}&page=${page}&rowsPerPage=${rowsPerPage}&sortBy=${sortBy}&descending=${descending}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          rows.value = data.data;
          pagination.value.rowsNumber = data.total;
          pagination.value.page = data.current_page;
        })
        .catch(error => {
          console.error('Error fetching medicamentos:', error);
          alert('Error fetching medicamentos');
        })
        .finally(() => {
          loading.value = false;
        });
    }

    function onRequest(props) {
      const { page, rowsPerPage, sortBy, descending } = props.pagination;
      const filterValue = props.filter;

      fetchMedicamentos(filterValue, page, rowsPerPage, sortBy, descending);
    }

    function addToCart(medicamento) {
      const existing = cart.value.find(item => item.id === medicamento.id);
      if (existing) {
        existing.cantidad += 1;
      } else {
        cart.value.push({ ...medicamento, cantidad: 1 });
      }
      total.value += parseFloat(medicamento.precio_unidad_vender);
    }

    function removeFromCart(item) {
      const index = cart.value.findIndex(i => i.id === item.id);
      if (index !== -1) {
        if (cart.value[index].cantidad > 1) {
          cart.value[index].cantidad -= 1;
        } else {
          cart.value.splice(index, 1);
        }
        total.value -= parseFloat(item.precio_unidad_vender);
      }
    }

    function checkout() {
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
      fetch('http://ventas-farmacia.test/realizar-venta', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(venta)
      })
        .then(response => {
          if (!response.ok) {
            console.log('Error al realizar la venta');
          }
          return response.json();
        })
        .then(data => {
          // Limpiar el carrito y cualquier otro estado relacionado
          cart.value = [];
          total.value = 0;
          dni.value = '';
          alert('Venta realizada con éxito');
        })
        .catch(error => {
          console.error('Error al realizar la venta:', error);
          alert('Error al realizar la venta');
        });
    }

    onMounted(() => {
      onRequest({ pagination: pagination.value, filter: filter.value });
    });

    watch(filter, (newFilter) => {
      onRequest({ pagination: pagination.value, filter: newFilter });
    });

    watch(pagination, (newPagination) => {
      onRequest({ pagination: newPagination, filter: filter.value });
    }, { deep: true });

    return {
      tableRef,
      rows,
      columns,
      filter,
      loading,
      pagination,
      onRequest,
      cart,
      total,
      addToCart,
      removeFromCart,
      checkout,
      dni
    };
  }
};
</script>

<style scoped>
/* Estilos específicos si es necesario */
</style>
