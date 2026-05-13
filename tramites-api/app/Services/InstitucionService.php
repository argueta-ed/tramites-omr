<?php
namespace App\Services;

use App\Models\Institucion;
use Illuminate\Database\Eloquent\Collection;

class InstitucionService
{
    /**
     * Obtener todas las instituciones activas.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Institucion::where('activo', true)->orderBy('nombre')->get();
    }

    /**
     * Crear una nueva institución.
     * @param array $data
     * @return Institucion
     */
    public function create(array $data): Institucion
    {
        return Institucion::create($data);
        
    }
}