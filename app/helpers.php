<?php

use Jenssegers\Date\Date;

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

function updateEnv($key, $value)
{
    $path = base_path('.env');

    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            "$key=" . env($key), "$key=" . $value, file_get_contents($path)
        ));

        return true;
    }

    return false;
}