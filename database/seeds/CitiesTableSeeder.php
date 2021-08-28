<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    function run()
    {
        $cities = [
            'aguascalientes', 'mexicali', 'la paz', 'campeche', 'tuxtla gutiérrez', 'ciudad juárez', 'ciudad de méxico', 'saltillo', 'colima',
            'durango', 'guanajuato', 'chilpancingo', 'pachuca', 'guadalajara', 'toluca', 'morelia', 'cuernavaca', 'tepic', 'monterrey', 'oaxaca',
            'puebla', 'querétaro', 'chetumal', 'san luis potosí', 'culiacán', 'hermosillo', 'villahermosa', 'ciudad victoria', 'tlaxcala', 'xalapa', 'mérida',
            'zacatecas'
        ];

        $i = 1;

        foreach ($cities as $city) {
            factory(\App\City::class)->create([
                'name' => $city,
                'state_id' => $i,
            ]);
            $i += 1;
        }
    }
}
