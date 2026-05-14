<template>
    <table class="table">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Institución</th>
                <th>Días Hábiles</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="tramites.length === 0">
                <td colspan="6" style="text-align: center; color: #666; padding: 20px;">No se encontraron trámites</td>
            </tr>

            <tr v-for="tramite in tramites" :key="tramite.id">
                <td><code>{{ tramite.codigo }}</code></td>
                <td>{{ tramite.nombre }}</td>
                <td>{{ tramite.institucion?.nombre ?? 'N/A' }}</td>
                <td>{{ tramite.dias_habiles }}</td>
                <td>
                    <span :class="['status', tramite.activo === 'activo' ? 'active' : 'inactive']">
                        {{ tramite.activo === 'activo' ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 10px;">
                        <router-link :to="{ name: 'tramites-edit', params: { id: tramite.id } }" class="btn btn-sm btn-warning">Editar</router-link>
                        <button v-if="tramite.activo" class="btn btn-sm btn-danger" @click="deleteTramite(tramite)">Desactivar</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
defineProps({
    tramites: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['desactivar'])

const deleteTramite = (tramite) => {
    if (confirm('¿Estás seguro de que deseas desactivar este trámite?')) {
        emit('desactivar', tramite)
    }
}
</script>