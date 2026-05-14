<template>
  <div class="filters">
    <div class="form-group">
      <label>Buscar por nombre</label>
      <input
        :value="filtros.nombre"
        class="form-control"
        placeholder="Nombre del trámite..."
        @input="$emit('update:filtros', { ...filtros, nombre: $event.target.value })"
      />
    </div>
  
    <div class="form-group">
      <label>Filtrar por institución</label>
      <select
        :value="filtros.institucion_id"
        class="form-control"
        @change="$emit('update:filtros', { ...filtros, institucion_id: $event.target.value })"
      >
        <option value="">Todos</option>
        <option v-for="institucion in instituciones" :key="institucion.id" :value="institucion.id">
          {{ institucion.nombre }}
        </option>
      </select>
    </div>
  
    <button class="btn btn-secondary btn-sm" @click="$emit('limpiar-filtros')">Limpiar Filtros</button>
  </div>
</template>

<script setup>
defineProps({
  filtros: {
    type: Object,
    required: true
  },
  instituciones: {
    type: Array,
    default: () => []
  }
})

defineEmits(['update:filtros', 'limpiar-filtros'])
</script>