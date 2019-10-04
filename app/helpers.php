<?php

use Jenssegers\Date\Date;
use App\Shipping;
use Illuminate\Support\Facades\Storage;

function usesas($ctrl, $fun, $as = null)
{
    if ($as) {
        return ['uses' => "$ctrl@$fun", 'as' => $as];
    }
    return ['uses' => "$ctrl@$fun", 'as' => $fun];
}

function fdate($original_date, $format = 'Y-m-d', $original_format = 'Y-m-d H:i:s')
{
    if ($original_date) {
        $date = Date::createFromFormat($original_format, $original_date);
        return $date->format($format);
    }
        
    return '';
}

function drawHeader(...$titles)
{
    echo "<template slot=\"header\"><tr>";
    foreach ($titles as $title) {
        echo "<th style='text-align: center'>" . ucfirst($title) . "</th>";
    }
    echo "</tr></template>";
}

function pendingShippings()
{
    return Shipping::whereStatus('pendiente')->count();
}

function saveCoffeeFile($file, $folder = 'bills')
{
    if ($file) {
        return Storage::putFileAs("public/coffee/$folder", $file, str_random(15) . '.' . $file->getClientOriginalExtension());
    }

    return null;
}

function saveMbeFile($file, $folder = 'bills')
{
    if ($file) {
        return Storage::putFileAs("public/mbe/$folder", $file, str_random(15) . '.' . $file->getClientOriginalExtension());
    }

    return null;
}

function dateFromRequest($format = 'Y-m-d')
{
    $date = null !== request('date') ? request('date'): date($format);
    return $date;
}