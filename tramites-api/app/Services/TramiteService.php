<?php

namespace App\Services;

use App\Models\Tramite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TramiteService
{

    /**
     * Obtener trámites con paginación y filtros.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginated(array $filters): LengthAwarePaginator
    {
        $query = Tramite::with('institucion');

        if (!empty($filters['institucion_id'])) {
            $query->where('institucion_id', $filters['institucion_id']);
        }

        if (!empty($filters['nombre'])) {
            $query->where('nombre', 'like', '%' . $filters['nombre'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Obtener un trámite por su ID.
     *
     * @param int $id
     * @return Tramite|null
     */
    public function findById(int $id): ?Tramite
    {
        return Tramite::with('institucion')->findOrFail($id);
    }

    /**
     * Crear un nuevo trámite.
     * @param array $data
     * @return Tramite
     */
    public function create(array $data): Tramite
    {
        $tramite = Tramite::create($data);
        return $tramite->load('institucion');        
    }

    /**
     * Actualizar un trámite existente.
     * @param Tramite $tramite
     * @param array $data
     * @return Tramite
     */
    public function update(Tramite $tramite, array $data): Tramite
    {
        $tramite->update($data);
        return $tramite->fresh('institucion');
    }

    /**
     * Desactivar un trámite (marcar como inactivo).
     * @param Tramite $tramite
     * @return Tramite
     */
    public function desactivate(Tramite $tramite): Tramite
    {
        $tramite->update(['activo' => false]);
        return $tramite;
    }
}