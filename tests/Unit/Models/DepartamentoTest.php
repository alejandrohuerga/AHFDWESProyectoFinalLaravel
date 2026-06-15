<?php

namespace Tests\Unit\Models;

use App\Models\Departamento;
use Tests\TestCase;

class DepartamentoTest extends TestCase
{
    public function test_table_name(): void
    {
        $model = new Departamento;
        $this->assertEquals('_t02_departamento', $model->getTable());
    }

    public function test_primary_key_name(): void
    {
        $model = new Departamento;
        $this->assertEquals('CodDepartamento', $model->getKeyName());
    }

    public function test_primary_key_is_not_incrementing(): void
    {
        $model = new Departamento;
        $this->assertFalse($model->getIncrementing());
    }

    public function test_primary_key_type_is_string(): void
    {
        $model = new Departamento;
        $this->assertEquals('string', $model->getKeyType());
    }

    public function test_timestamps_disabled(): void
    {
        $model = new Departamento;
        $this->assertFalse($model->usesTimestamps());
    }

    public function test_fillable_attributes(): void
    {
        $model = new Departamento;
        $expected = [
            'CodDepartamento',
            'DescDepartamento',
            'FechaCreacionDepartamento',
            'VolumenDeNegocio',
            'FechaBajaDepartamento',
        ];

        $this->assertEquals($expected, $model->getFillable());
    }

    public function test_mass_assignment(): void
    {
        $model = new Departamento;
        $model->fill([
            'CodDepartamento' => 'DEP001',
            'DescDepartamento' => 'Desarrollo',
            'FechaCreacionDepartamento' => '2026-01-01',
            'VolumenDeNegocio' => 50000,
            'FechaBajaDepartamento' => null,
        ]);

        $this->assertEquals('DEP001', $model->CodDepartamento);
        $this->assertEquals('Desarrollo', $model->DescDepartamento);
        $this->assertEquals(50000, $model->VolumenDeNegocio);
    }

    public function test_uses_has_factory_trait(): void
    {
        $this->assertTrue(
            in_array(
                \Illuminate\Database\Eloquent\Factories\HasFactory::class,
                class_uses_recursive(Departamento::class)
            )
        );
    }
}
