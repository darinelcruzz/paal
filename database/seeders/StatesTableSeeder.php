<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    function run()
    {
        $states = [
            'aguascalientes', 'baja california', 'baja california sur', 'campeche', 'chiapas', 'chihuahua', 'ciudad de méxico', 'coahuila', 'colima',
            'durango', 'guanajuato', 'guerrero', 'hidalgo', 'jalisco', 'estado de méxico', 'michoacán', 'morelos', 'nayarit', 'nuevo león', 'oaxaca',
            'puebla', 'querétaro', 'quintana roo', 'san luis potosí', 'sinaloa', 'sonora', 'tabasco', 'tamaulipas', 'tlaxcala', 'veracruz', 'yucatán',
            'zacatecas'
        ];

        foreach ($states as $state) {
            factory(\App\State::class)->create([
                'name' => $state,
            ]);
        }
    }
}
