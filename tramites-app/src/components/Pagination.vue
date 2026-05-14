<template>
  <div class="pagination" v-if="meta.last_page > 1">
    <button :disabled="meta.current_page === 1" @click="$emit('page-changed', meta.current_page - 1)"> &lt; Anterior</button>
    
    <button v-for="pagina in meta.last_page" :key="pagina" :class="{ active: pagina === meta.current_page }" @click="$emit('page-changed', pagina)">
      {{ pagina }}
    </button>
    
    <button :disabled="meta.current_page === meta.last_page" @click="$emit('page-changed', meta.current_page + 1)"> Siguiente &gt;</button>

    <span class="pagination-info">Total: {{ meta.total }} tramites</span>
  </div>
</template>

<script setup>
defineProps({
  meta: {
    type: Object,
    required: true
  }
})

defineEmits(['page-changed'])
</script>