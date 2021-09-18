<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => strtoupper($this->faker->name),
            'middle_name' => strtoupper($this->faker->lastName),
            'last_name' => strtoupper($this->faker->lastName),
            'other_name' => strtoupper($this->faker->optional()->lastName),
            'work_country' => $this->faker->randomElement(['Estados Unidos', 'Colombia']),
            'document_type' => $this->faker->randomElement(['Cédula de Ciudadanía', 'Cédula de Extranjería', 'Pasaporte', 'Permiso Especial']),
            'document_number' => rand(1111111111, 9999999999),
            'email' => $this->faker->unique()->safeEmail,
            'department' => $this->faker->randomElement(['Administración', 'Financiera', 'Compras', 'Infraestructura', 'Operación', 'Talento Humano', 'Servicios Varios']),
            'status' => $this->faker->randomElement(['Activo', 'Inactivo']),
            'start_date' => $this->faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now')->format('Y-m-d')
        ];
    }
}
