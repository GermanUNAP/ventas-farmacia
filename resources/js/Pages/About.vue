<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      Dashboard
    </template>

    <div class="p-4 bg-white rounded-lg shadow-md">
      <div class="text-center text-2xl font-semibold mb-4">Ventas por Día</div>
      <div class="flex justify-center mb-4">
        <select v-model="selectedInterval" @change="fetchSalesData" class="border rounded-md px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <option value="7d">7 días</option>
          <option value="1m">Último mes</option>
          <option value="1y">Último año</option>
        </select>
      </div>

      <!-- Ajuste el tamaño del contenedor del gráfico de barras -->
      <div class="relative h-80 w-full mb-8">
        <Bar :data="chartData" :options="chartOptions" class="absolute inset-0" />
      </div>
      <!-- Botones para generar reportes -->
      <div class="flex justify-center space-x-4">
        <button @click="generateExcelReportSales" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Generar Excel Ventas</button>
        <button @click="generatePDFReportSales" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Generar PDF Ventas</button>
      </div>
      <div class="text-center text-2xl font-semibold mb-4">Medicamentos Más Vendidos</div>
      <!-- Ajuste el tamaño del contenedor del gráfico circular -->
      <div class="relative h-80 w-full mb-4">
        <Pie :data="pieChartData" :options="pieChartOptions" class="absolute inset-0" />
      </div>

      <!-- Botones para generar reportes -->
      <div class="flex justify-center space-x-4">
        <button @click="generateExcelReportTopSelling" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Generar Excel Medicamentos</button>
        <button @click="generatePDFReportTopSelling" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Generar PDF Medicamentos</button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import * as XLSX from 'xlsx';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const selectedInterval = ref('7d');

const chartData = ref({
  labels: [],
  datasets: [{
    label: 'Ventas',
    backgroundColor: '#42A5F5',
    data: []
  }]
});

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: 'top'
    },
    title: {
      display: true,
      text: 'Ventas diarias'
    }
  }
});

const pieChartData = ref({
  labels: [],
  datasets: [{
    label: 'Medicamentos Más Vendidos',
    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
    data: []
  }]
});

const pieChartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: 'top'
    },
    title: {
      display: true,
      text: 'Medicamentos Más Vendidos'
    },
    tooltip: {
      callbacks: {
        label: function (tooltipItem) {
          const dataLabel = tooltipItem.label || '';
          const value = tooltipItem.raw;
          const total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
          const percentage = ((value / total) * 100).toFixed(2);
          return `${dataLabel}: ${value} (${percentage}%)`;
        }
      }
    }
  }
});

const fetchSalesData = async () => {
  try {
    const response = await axios.get('/sales-data', {
      params: { interval: selectedInterval.value }
    });
    const data = response.data;

    if (Array.isArray(data) && data.length > 0) {
      const labels = data.map(item => item.date);
      const salesData = data.map(item => item.total_sales);

      chartData.value = {
        labels: labels,
        datasets: [{
          label: 'Ventas',
          backgroundColor: '#42A5F5',
          data: salesData
        }]
      };
    } else {
      console.error('Datos recibidos no son válidos:', data);
    }
  } catch (error) {
    console.error('Error fetching sales data:', error);
  }
};

const fetchTopSellingMedicamentos = async () => {
  try {
    const response = await axios.get('/top-selling-medicamentos', {
      params: { interval: selectedInterval.value }
    });
    const data = response.data;

    if (Array.isArray(data) && data.length > 0) {
      const labels = data.map(item => item.nombre);
      const salesData = data.map(item => item.total_vendido);

      pieChartData.value = {
        labels: labels,
        datasets: [{
          label: 'Medicamentos Más Vendidos',
          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
          data: salesData
        }]
      };
    } else {
      console.error('Datos recibidos no son válidos:', data);
    }
  } catch (error) {
    console.error('Error fetching top selling medicamentos:', error);
  }
};

const generateExcelReportSales = () => {
  const wb = XLSX.utils.book_new();
  
  // Datos de ventas
  const wsData = [['Fecha', 'Ventas Totales']];
  chartData.value.labels.forEach((label, index) => {
    wsData.push([label, chartData.value.datasets[0].data[index]]);
  });

  const ws = XLSX.utils.aoa_to_sheet(wsData);
  XLSX.utils.book_append_sheet(wb, ws, 'Ventas Por Día');
  
  XLSX.writeFile(wb, 'ventas_por_dia.xlsx');
};

const generateExcelReportTopSelling = () => {
  const wb = XLSX.utils.book_new();
  
  // Datos de medicamentos más vendidos
  const wsData = [['Medicamento', 'Cantidad Vendida']];
  pieChartData.value.labels.forEach((label, index) => {
    wsData.push([label, pieChartData.value.datasets[0].data[index]]);
  });

  const ws = XLSX.utils.aoa_to_sheet(wsData);
  XLSX.utils.book_append_sheet(wb, ws, 'Medicamentos Más Vendidos');
  
  XLSX.writeFile(wb, 'medicamentos_mas_vendidos.xlsx');
};

const generatePDFReportSales = () => {
  const doc = new jsPDF();
  
  doc.text('Reporte de Ventas por Día', 10, 10);
  doc.autoTable({
    head: [['Fecha', 'Ventas Totales']],
    body: chartData.value.labels.map((label, index) => [label, chartData.value.datasets[0].data[index]])
  });

  doc.save('ventas_por_dia.pdf');
};

const generatePDFReportTopSelling = () => {
  const doc = new jsPDF();
  
  doc.text('Reporte de Medicamentos Más Vendidos', 10, 10);
  doc.autoTable({
    head: [['Medicamento', 'Cantidad Vendida']],
    body: pieChartData.value.labels.map((label, index) => [label, pieChartData.value.datasets[0].data[index]])
  });

  doc.save('medicamentos_mas_vendidos.pdf');
};

onMounted(() => {
  fetchSalesData();
  fetchTopSellingMedicamentos();
});
</script>

<style scoped>
/* No se necesitan estilos adicionales aquí */
</style>
