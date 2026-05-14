<template>
  <div class="card">
    <div class="card-header-row">
      <h1 class="card-title">Listado de Trámites</h1>
      <router-link class="btn btn-primary btn-sm" :to="{ name: 'tramites-create' }">Nuevo Trámite</router-link>
    </div>
  </div>

  <div v-if="loading" class="loading-text">Cargando trámites...</div>

  <!-- Tabla -->
  <template v-else>
    <TramitesTable :tramites="tramites" @desactivar="handleDesactivar" />

    <!-- Paginación -->
    <Pagination :meta="meta" @page-changed="cargarTramites" />

  </template>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import {tramiteService} from '../services/api.js';

import TramitesTable from '../components/TramitesTable.vue';
import Pagination from '../components/Pagination.vue';

const tramites = ref([]);
const tramiteSeleccinado = ref(null);
const desactivado = ref(false);
const loading = ref(false);

const meta = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0
});

async function cargarTramites(page = 1) {
  try {
    const params = { page }
    const response = await tramiteService.getAll(params);
    tramites.value = response.data.data;
    meta.value = response.data.meta;
  } catch (error) {
    console.error('Error al cargar los trámites:', error);
  }
}

function handleDesactivar(tramite) {
  tramiteSeleccinado.value = tramite;
  desactivarTramite();
}

async function desactivarTramite() {
  if (!tramiteSeleccinado.value) return;
  desactivado.value = true;
  try{
    await tramiteService.desactivate(tramiteSeleccinado.value.id);
    tramiteSeleccinado.value = null;
    await cargarTramites();
  } catch (error) {
    console.error('Error al desactivar el trámite:', error);
  } finally {
    desactivado.value = false;
  }
}

onMounted(() => {
  cargarTramites();
});
</script>