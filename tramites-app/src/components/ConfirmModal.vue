<template>
  <div v-if="visible" class="modal-overlay" @click.self="$emit('cancelar')">
    <div class="modal-box">
      <p class="modal-title">{{ titulo }}</p>
      <p class="modal-text">{{ mensaje }}</p>
      <div class="modal-actions">
        <button class="btn btn-secondary" @click="$emit('cancelar')">Cancelar</button>
        <button class="btn btn-danger" :disabled="cargando" @click="$emit('confirmar')">
          <span v-if="cargando" class="spinner"></span>
          <span v-else>Confirmar</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  visible: {
    type: Boolean,
    required: true
  },
  titulo: {
    type: String,
    default: 'Confirmar Acción'
  },
  mensaje: {
    type: String,
    default: '¿Estás seguro de que deseas realizar esta acción?'
  },
  cargando: {
    type: Boolean,
    default: false
  }

});

defineEmits(['confirmar', 'cancelar'])
</script>