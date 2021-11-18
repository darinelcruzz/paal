<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\{Shipping, Ingress};

class ShippingsChart extends BaseChart
{
    public ?string $name = 'shippings_chart';

    public ?string $routeName = 'shippings';

    public function handler(Request $request): Chartisan
    {
        $company = $request->company;
        $shippingsByMonth = Shipping::whereYear('created_at', date('Y'))
            ->whereHas('ingress', function ($query) {
                $query->where('company', 'coffee');
            })
            ->whereHas('address')
            ->when($company != 'todos', function ($query) use ($company){
                $query->where('company', $company);
            })
            ->with('address')
            ->get()
            ->groupBy([function ($item, $key) {
                return date('M', strtotime((string)$item->created_at));
            }, function ($item, $key) {
                if ($item->address->state) {
                    return strtoupper($item->address->state);
                }
            }]);

        $chart = Chartisan::build();

        $chart->labels($shippingsByMonth->keys()->toArray());

        // ddd($shippingsByMonth);

        foreach ($shippingsByMonth as $month => $states) {
            // dd($categories);
            foreach ($states as $name => $shippings) {
                $dataset["$name"] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }
        }

        // ddd($dataset);
        $i = 0;

        foreach ($shippingsByMonth as $month => $states) {
            // dd($month, $states, $dataset);

            foreach ($states as $name => $shippings) {
                $dataset["$name"][$i] = $shippings->count();
            }
            $i += 1;
        }

        foreach ($dataset as $key => $value) {
            $chart->dataset($key == '' ? 'INCOMPLETO': $key, $value);
        }        
        
        return $chart;
    }
}