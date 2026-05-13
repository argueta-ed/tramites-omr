<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instituciones = [
            ['nombre' => 'Ministerio de Hacienda', 'tipo' => 'MINISTERIO'],
            ['nombre' => 'Ministerio de Salud', 'tipo' => 'MINISTERIO'],
            ['nombre' => 'Ministerio de Educación', 'tipo' => 'MINISTERIO'],
            ['nombre' => 'Alcaldía Municipal de San Salvador', 'tipo' => 'ALCALDIA'],
            ['nombre' => 'Alcaldía Municipal de Santa Ana', 'tipo' => 'ALCALDIA'],
            ['nombre' => 'CNR — Registro Nacional', 'tipo' => 'AUTONOMA'],
            ['nombre' => 'ANDA', 'tipo' => 'AUTONOMA'],
        ];

        foreach ($instituciones as $datos){
            Institucion::create($datos);
        }
    }
}
