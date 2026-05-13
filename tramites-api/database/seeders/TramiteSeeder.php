<?php

namespace Database\Seeders;

use App\Models\Tramite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tramites = [
            [
                'codigo' => 'MH-001', 'nombre' => 'Solvencia de IVA',
                'descripcion' => 'Obtención de solvencia del Impuesto al Valor Agregado.',
                'institucion_id' => 1, 'dias_habiles' => 3,
            ],
            [
                'codigo' => 'MH-002', 'nombre' => 'Devolución de Renta',
                'descripcion' => 'Solicitud de devolución de impuesto sobre la renta.',
                'institucion_id' => 1, 'dias_habiles' => 30,
            ],
            [
                'codigo' => 'MS-001', 'nombre' => 'Registro Sanitario',
                'descripcion' => 'Registro sanitario para productos alimenticios.',
                'institucion_id' => 2, 'dias_habiles' => 15,
            ],
            [
                'codigo' => 'MS-002', 'nombre' => 'Permiso de Funcionamiento',
                'descripcion' => 'Permiso para establecimientos de salud.',
                'institucion_id' => 2, 'dias_habiles' => 20,
            ],
            [
                'codigo' => 'ME-001', 'nombre' => 'Reconocimiento de Títulos',
                'descripcion' => 'Proceso de reconocimiento de títulos extranjeros.',
                'institucion_id' => 3, 'dias_habiles' => 45,
            ],
            [
                'codigo' => 'ASS-001', 'nombre' => 'Solvencia Municipal',
                'descripcion' => 'Solvencia de pagos municipales San Salvador.',
                'institucion_id' => 4, 'dias_habiles' => 1,
            ],
            [
                'codigo' => 'ASS-002', 'nombre' => 'Licencia de Construcción',
                'descripcion' => 'Licencia para construcción de inmuebles en San Salvador.',
                'institucion_id' => 4, 'dias_habiles' => 45,
            ],
            [
                'codigo' => 'ASA-001', 'nombre' => 'Pago de Tasas Municipales',
                'descripcion' => 'Pago de tasas municipales Santa Ana.',
                'institucion_id' => 5, 'dias_habiles' => 1,
            ],
            [
                'codigo' => 'CNR-001', 'nombre' => 'Registro de Inmueble',
                'descripcion' => 'Inscripción de propiedad inmueble en el CNR.',
                'institucion_id' => 6, 'dias_habiles' => 10,
            ],
            [
                'codigo' => 'AND-001', 'nombre' => 'Conexión de Agua Potable',
                'descripcion' => 'Solicitud de nueva conexión domiciliar de agua potable.',
                'institucion_id' => 7, 'dias_habiles' => 30,
            ],
        ];

        foreach ($tramites as $datos) {
            Tramite::create($datos);
        }
    }
}
