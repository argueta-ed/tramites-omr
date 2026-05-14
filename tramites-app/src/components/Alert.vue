<template>
  <div v-if="mensaje" class="alert" :class="claseAlerta">
    {{ mensaje }}
    <slot></slot>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  tipo: {
    type: String,
    default: 'danger',
  },
  mensaje: {
    type: String,
    default: ''
  }
});

const claseAlerta = computed(() => {
  return `alert-${props.tipo}`;
});
</script>