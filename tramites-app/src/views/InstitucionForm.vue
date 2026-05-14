<template>
  <div class="card form-card">
    <h1 class="card-title">Nueva Institución</h1>

    <form @submit.prevent="submitForm">
      <!-- Nombre -->
      <div class="form-group">
        <label for="nombre">Nombre *</label>
        <input type="text" id="nombre" class="form-control" :class="{ 'is-invalid': errors.nombre }"
          v-model="institucion.nombre" placeholder="Nombre de la institución">
        <p v-if="errors.nombre" class="error-text">{{ errors.nombre[0] }}</p>
      </div>
      <!-- Tipo -->
      <div class="form-group">
        <label for="tipo">Tipo *</label>
        <select type="text" id="tipo" class="form-control" :class="{ 'is-invalid': errors.tipo }"
          v-model="institucion.tipo" placeholder="Tipo de institución">
          <option value="">Seleccione un tipo</option>
          <option value="MINISTERIO">Ministerio</option>
          <option value="ALCALDIA">Alcaldía</option>
          <option value="AUTONOMA">Autónoma</option>
        </select>
        <p v-if="errors.tipo" class="error-text">{{ errors.tipo[0] }}</p>
      </div>

      <!-- Botones -->
      <div class="form-actions">
        <button type="submit" class="btn btn-primary" :disabled="enviando">
          <span v-if="enviando" class="spinner"></span>
          <span v-else>Crear Institución</span>
        </button>
        <router-link to="/" class="btn btn-secondary">Cancelar</router-link>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { institucionService } from '../services/api.js';

const institucion = ref({
  nombre: '',
  tipo: '',
});
const errors = ref({});
const enviando = ref(false);

function validar() {
  const newErrors = {};
  if (!institucion.value.nombre.trim()) {
    newErrors.nombre = ['El nombre es obligatorio.'];
  }
  if (!institucion.value.tipo) {
    newErrors.tipo = ['El tipo es obligatorio.'];
  }
  return newErrors;
}

async function submitForm() {
  errors.value = {};

  const err = validar();
  if (Object.keys(err).length > 0) {
    errors.value = err;
    return;
  }

  enviando.value = true;
  try {
    await institucionService.create(institucion.value);
    institucion.value = {
      nombre: '',
      tipo: '',
    };
  } catch (error) {
    console.error('Error al crear la institución:', error);
    if (error.response && error.response.data && error.response.data.errors) {
      errors.value = error.response.data.errors;
    }
  } finally {
    enviando.value = false;
  }
}
</script>

