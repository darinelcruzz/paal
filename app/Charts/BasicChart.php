<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\{Movement, Ingress};

class BasicChart extends BaseChart
{
    /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'basic_chart';

    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directrive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'basic';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $movementsByMonth = Movement::whereYear('created_at', date('Y'))
            // ->whereHasMorph('movable', Ingress::class, function ($query) {
            //     $query->where('company', 'coffee');
            // })
            ->where('movable_type', 'App\Ingress')
            ->whereHas('product', function ($query) {
                $query->whereIn('category', ['INSUMOS', 'ACCESORIOS', 'VASOS', 'EQUIPO', 'REFACCIONES', 'BARRAS', 'CURSOS', 'OTROS'])
                    ->where('company', 'COFFEE');
            })
            ->with('product')
            ->get()
            ->groupBy([function ($item, $key) {
                // dd($item->created_at);
                return date('M', strtotime((string)$item->created_at));
            }, 'product.category']);

        // ddd($groups);

        $chart = Chartisan::build();

        $chart->labels($movementsByMonth->keys()->toArray());

        foreach ($movementsByMonth as $month => $categories) {
            // dd($categories);
            foreach ($categories as $name => $movements) {
                $dataset["$name"] = [];
            }
        }

        foreach ($movementsByMonth as $month => $categories) {
            // dd($categories);
            foreach ($categories as $name => $movements) {
                array_push($dataset["$name"], $movements->sum('quantity'));
            }
        }

        foreach ($dataset as $key => $value) {
            $chart->dataset($key, $value);
        }
        
        
        return $chart;
    }
}