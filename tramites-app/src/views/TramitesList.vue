<template>
  <div class="card">
    <div class="card-header-row">
      <h1 class="card-title">Listado de Trámites</h1>
      <router-link class="btn btn-primary btn-sm" :to="{ name: 'tramites-create' }">Nuevo Trámite</router-link>
    </div>
  </div>


  <!-- Filtros -->
  <TramitesFiltros v-model:filtros="filtros" :instituciones="instituciones" @limpiar-filtros="limpiarFiltros" />

  <!-- Mensaje de carga -->
  <div v-if="loading" class="loading-text">Cargando trámites...</div>
  <Alert v-else-if="error" :mensaje="error" />

  <!-- Tabla -->
  <template v-else>
    <TramitesTable :tramites="tramites" @desactivar="abrirModal" />

    <!-- Paginación -->
    <Pagination :meta="meta" @page-changed="cargarTramites" />

  </template>

  <!-- Modal de confirmación -->
  <ConfirmModal
    :visible="!!tramiteSeleccionado"
    titulo="Confirmar Desactivación"
    :mensaje="`¿Estás seguro de que deseas desactivar el trámite ${tramiteSeleccionado?.nombre}?`"
    :cargando="desactivado"
    @confirmar="desactivarTramite"
    @cancelar="tramiteSeleccionado = null"
  />

</template>


<script setup>
import { ref, onMounted, watch } from 'vue';
import {tramiteService, institucionService} from '../services/api.js';

import TramitesTable from '../components/TramitesTable.vue';
import Pagination from '../components/Pagination.vue';
import TramitesFiltros from '../components/TramitesFiltros.vue';
import Alert from '../components/Alert.vue';
import ConfirmModal from '../components/ConfirmModal.vue';

const tramites = ref([]);
const instituciones = ref([]);
const tramiteSeleccionado = ref(null);
const desactivado = ref(false);
const loading = ref(false);
const error = ref(null);

const meta = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0
});
const filtros = ref({
  nombre: '',
  institucion_id: ''
});

async function cargarTramites(page = 1) {
  loading.value = true;
  error.value = null;

  try {
    const params = { page, ...filtros.value };
    Object.keys(params).forEach(k => !params[k] && delete params[k])

    const response = await tramiteService.getAll(params);
    tramites.value = response.data.data;
    meta.value = response.data.meta;
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Error al cargar los trámites.';
  } finally {
    loading.value = false;
  }
}

async function cargarInstituciones() {
  try {
    const response = await institucionService.getAll();
    instituciones.value = response.data.data;
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Error al cargar las instituciones.';
  }
}

function limpiarFiltros() {
  filtros.value = {
    nombre: '',
    institucion_id: ''
  };
}

function abrirModal(tramite) {
  tramiteSeleccionado.value = tramite;
}

async function desactivarTramite() {
  if (!tramiteSeleccionado.value) return;
  desactivado.value = true;
  try{
    await tramiteService.desactivate(tramiteSeleccionado.value.id);
    tramiteSeleccionado.value = null;
    await cargarTramites(meta.value.current_page);
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Error al desactivar el trámite.';
  } finally {
    desactivado.value = false;
  }
}

onMounted(() => {
  cargarTramites();
  cargarInstituciones();
});

let searchTimeout = null
watch(filtros, () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    cargarTramites(1);
  }, 300);
}, { deep: true });
</script>