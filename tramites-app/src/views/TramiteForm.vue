<template>
  <div class="card form-card">
    <h1 class="card-title"> {{ isEdit ? 'Editar Trámite' : 'Crear Trámite' }} </h1>

    <Alert tipo="success" :mensaje="mensajeExito">
      <router-link to="/" style="margin-left: 8px; color: inherit; font-weight: 600;">
        Ver listado
      </router-link>
    </Alert>

    <div v-if="loadingTramite" class="loading-text">Cargando datos...</div>

    <form v-else @submit.prevent="submitForm">
      <!-- Codigo -->
      <div class="form-group">
        <label for="codigo">Código *</label>
        <input id="codigo" class="form-control" :class="{ 'is-invalid': errors.codigo }" v-model="tramite.codigo"
          placeholder="Ej. MH-003" :disabled="isEdit">
        <p v-if="errors.codigo" class="error-text">{{ errors.codigo[0] }}</p>
      </div>
      <!-- Nombre -->
      <div class="form-group">
        <label for="nombre">Nombre *</label>
        <input type="text" id="nombre" class="form-control" :class="{ 'is-invalid': errors.nombre }"
          v-model="tramite.nombre" placeholder="Nombre del trámite">
        <p v-if="errors.nombre" class="error-text">{{ errors.nombre[0] }}</p>
      </div>
      <!-- Descripción -->
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" class="form-control" v-model="tramite.descripcion" rows="3"
          placeholder="Descripción del trámite"></textarea>
      </div>
      <!-- Institución -->
      <div class="form-group">
        <label for="institucion_id">Institución *</label>
        <select id="institucion_id" class="form-control" :class="{ 'is-invalid': errors.institucion_id }"
          v-model="tramite.institucion_id">
          <option value="">Seleccione una institución</option>
          <option v-for="institucion in instituciones" :key="institucion.id" :value="institucion.id">
            {{ institucion.nombre }}
          </option>
        </select>
        <p v-if="errors.institucion_id" class="error-text">{{ errors.institucion_id[0] }}</p>
        <p v-if="loadingInstituciones" class="hint-text">Cargando instituciones...</p>
      </div>
      <!-- Días hábiles -->
      <div class="form-group">
        <label for="dias_habiles">Días Hábiles *</label>
        <input type="number" id="dias_habiles" class="form-control" :class="{ 'is-invalid': errors.dias_habiles }"
          v-model="tramite.dias_habiles" placeholder="Número de días">
        <p v-if="errors.dias_habiles" class="error-text">{{ errors.dias_habiles[0] }}</p>
      </div>

      <!-- Errores generales -->
      <Alert :mensaje="errorGeneral"/>

      <!-- Botones -->
      <div class="form-actions">
        <button type="submit" class="btn btn-primary" :disabled="enviando">
          <span v-if="enviando" class="spinner"></span>
          <span v-else>{{ isEdit ? 'Actualizar' : 'Crear Trámite' }}</span>
        </button>
        <router-link to="/" class="btn btn-secondary">Cancelar</router-link>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { tramiteService, institucionService } from '../services/api.js'
import Alert from '../components/Alert.vue';

const route = useRoute();
const router = useRouter();

const isEdit = computed(() => !!route.params.id);

const tramite = ref({
  codigo: '',
  nombre: '',
  descripcion: '',
  institucion_id: '',
  dias_habiles: '',
});

const instituciones = ref([]);
const errors = ref({});
const errorGeneral = ref(null);
const mensajeExito = ref(null);
const loadingTramite = ref(false);
const loadingInstituciones = ref(false);
const enviando = ref(false);

async function cargarTramite(id) {
  loadingTramite.value = true;

  try {
    const response = await tramiteService.getById(id);
    const data = response.data.data;
    tramite.value = {
      codigo: data.codigo,
      nombre: data.nombre,
      descripcion: data.descripcion ?? '',
      institucion_id: data.institucion_id,
      dias_habiles: data.dias_habiles
    };
  } catch (error) {
    errorGeneral.value = 'No se pudo cargar los datos del trámite.';
  } finally {
    loadingTramite.value = false;
  }
}

async function cargarInstituciones() {
  loadingInstituciones.value = true;

  try {
    const response = await institucionService.getAll();
    instituciones.value = response.data.data;
  } catch (error) {
    errorGeneral.value = 'No se pudo cargar las instituciones.';
  } finally {
    loadingInstituciones.value = false;
  }
}

function validar() {
  const newErrors = {};
  if (!tramite.value.codigo.trim()) {
    newErrors.codigo = ['El código es obligatorio.'];
  }
  if (!tramite.value.nombre.trim()) {
    newErrors.nombre = ['El nombre es obligatorio.'];
  }
  if (!tramite.value.institucion_id) {
    newErrors.institucion_id = ['La institución es obligatoria.'];
  }
  if (!tramite.value.dias_habiles || tramite.value.dias_habiles < 1) {
    newErrors.dias_habiles = ['Los días hábiles son obligatorios.'];
  }

  return newErrors;
}

async function submitForm() {
  errors.value = {};
  errorGeneral.value = null;
  mensajeExito.value = null;

  const err = validar();
  if (Object.keys(err).length > 0) {
    errors.value = err;
    return;
  }

  enviando.value = true;

  try {
    if (isEdit.value) {
      await tramiteService.update(route.params.id, tramite.value);
      mensajeExito.value = 'Trámite actualizado exitosamente.';
    } else {
      await tramiteService.create(tramite.value);
      mensajeExito.value = 'Trámite creado exitosamente.';
      tramite.value = {
        codigo: '',
        nombre: '',
        descripcion: '',
        institucion_id: '',
        dias_habiles: '',
      };
    }
  } catch (error) {
    if (error.response && error.response.data && error.response.data.errors) {
      errors.value = error.response.data.errors ?? {};
    } else {
      errorGeneral.value = error.response?.data?.message ?? 'Ocurrió un error al guardar el trámite.';
    }
  } finally {
    enviando.value = false;
  }
  
}

onMounted(async () => {
  await cargarInstituciones();
  if (isEdit.value) {
    await cargarTramite(route.params.id);
  }
});

</script>