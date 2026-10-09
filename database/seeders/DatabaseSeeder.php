<?php

namespace Database\Seeders;

use App\Models\Capacitacion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador inicial
        User::updateOrCreate(
            ['email' => 'admin@impulsalocal.gov.co'],
            [
                'name' => 'Administrador Impulsa Local',
                'password' => Hash::make('Admin12345'),
                'rol' => 'administrador',
                'estado' => 'activo',
                'requisitos_verificados' => true,
                'email_verified_at' => now(),
            ]
        );

        // Capacitaciones de ejemplo
        $capacitaciones = [
            [
                'nombre' => 'Ventas locales',
                'area' => 'Marketing y comercio digital',
                'descripcion' => 'Estrategias para vender mejor en el barrio y en redes sociales.',
                'requisitos' => 'Tener un emprendimiento activo.',
                'fecha' => '2026-11-05',
                'hora' => '16:00:00',
                'cupo' => 30,
            ],
            [
                'nombre' => 'Contabilidad básica para tiendas',
                'area' => 'Finanzas',
                'descripcion' => 'Control de ingresos, gastos y ganancias del negocio.',
                'requisitos' => 'Ninguno.',
                'fecha' => '2026-11-12',
                'hora' => '15:00:00',
                'cupo' => 25,
            ],
            [
                'nombre' => 'Comercio digital',
                'area' => 'Marketing y comercio digital',
                'descripcion' => 'Cómo abrir una tienda en línea y recibir pagos.',
                'requisitos' => 'Tener celular con acceso a internet.',
                'fecha' => '2026-11-19',
                'hora' => '17:00:00',
                'cupo' => 20,
            ],
        ];

        foreach ($capacitaciones as $capacitacion) {
            Capacitacion::updateOrCreate(
                ['nombre' => $capacitacion['nombre']],
                $capacitacion
            );
        }
    }
}
