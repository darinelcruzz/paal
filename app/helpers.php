<?php

use Jenssegers\Date\Date;
use Illuminate\Support\Str;
use App\{Shipping, Egress, Product, Ingress, SerialNumber, Purchase, Order, Movement};
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
    Date::setLocale('es');
    if ($original_date != null) {
        return date($format, strtotime($original_date));
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

function pendingShippings($company = 'coffee')
{
    return Shipping::whereStatus('pendiente')
        ->whereHas('ingress', function ($query) use ($company) {
            $query->where('company', $company);
        })
        ->count();
}

function expiringSoonEgresses($company = 'coffee')
{
    return Egress::whereCompany($company)
        ->where('status', '!=', 'pagado')
        ->where('status', '!=', 'eliminado')
        ->whereBetween('expiration', [now(), now()->addDays(3)])
        ->count();
}

function soldProducts($company = 'coffee')
{
    return Ingress::all()
        ->where('company', $company)
        ->where('are_serial_numbers_missing', true)
        ->count();
}

function releasedProducts($company = 'COFFEE')
{
    return Product::whereCompany(strtoupper($company))
        ->whereHas('status', '!=', 'pagado')
        ->count();
}

function saveCoffeeFile($file, $folder = 'bills')
{
    if ($file) {
        return Storage::putFileAs("public/coffee/$folder", $file, Str::random(15) . '.' . $file->getClientOriginalExtension());
    }

    return null;
}

function saveMbeFile($file, $folder = 'bills')
{
    if ($file) {
        return Storage::putFileAs("public/mbe/$folder", $file, Str::random(15) . '.' . $file->getClientOriginalExtension());
    }

    return null;
}

function saveSansonFile($file, $folder = 'bills')
{
    if ($file) {
        return Storage::putFileAs("public/sanson/$folder", $file, Str::random(15) . '.' . $file->getClientOriginalExtension());
    }

    return null;
}

function dateFromRequest($format = 'Y-m-d')
{
    $date = request('date') !== null ? request('date'): date($format);
    return $date;
}

function amountToText($amount)
{
    return strtoupper(getThousandsFromAmount(floor($amount)));
}

function amountDecimals($amount)
{
    $decimals = number_format($amount - floor($amount), 2);
    return substr("0$decimals", -2);
}

function getUnitsFromAmount($amount)
{
    $base = ['cero', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez',
        'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve', 
        'veinte', 'veintiun', 'veintidos', 'veintitres', 'veinticuatro','veinticinco', 'veintiséis','veintisiete',
        'veintiocho','veintinueve'];

    return $base[intval($amount)];
}

function getTensFromAmount($amount)
{
    $tens = ['30' => 'treinta', '40' => 'cuarenta', '50' => 'cincuenta', '60' => 'sesenta',
        '70' => 'setenta', '80' => 'ochenta', '90' => 'noventa'];

    if($amount <= 29) return getUnitsFromAmount($amount);

    $ten = $amount % 10;

    if($ten == 0) {
        return $tens[$amount];
    }
    else return $tens[$amount - $ten] . ' y '. getUnitsFromAmount($ten);
}

function getHundredsFromAmount($amount)
{
    $hundreds = ['100' => 'cien', '200' => 'doscientos', '300' => 'trecientos', '400' => 'cuatrocientos',
        '500' => 'quinientos', '600' => 'seiscientos', '700' => 'setecientos', '800' => 'ochocientos',
        '900' => 'novecientos'];

    if($amount >= 100) {
        if ($amount % 100 == 0 ) {
            return $hundreds[$amount];
        } else {
            $firstDigit = (int) substr($amount, 0, 1);
            $tens = (int) substr($amount, 1, 2);
            return (($firstDigit == 1) ? 'ciento' : $hundreds[$firstDigit * 100]) . ' ' . getTensFromAmount($tens);
        }
    } else return getTensFromAmount($amount);
}

function getThousandsFromAmount($amount)
{
    // return (int)substr($amount, 0, strlen($amount) - 3);
    if($amount > 999) {
        if($amount == 1000) {
            return 'un mil';
        } else {
            $firstDigits = (int)substr($amount, 0, strlen($amount) - 3);
            $hundreds = (int)substr($amount,-3);

            if($firstDigits == 1) {
                $text = 'un mil '. getHundredsFromAmount($hundreds);
            } else if($hundreds == 0) {
                $text = getHundredsFromAmount($firstDigits) . ' mil';
            } else {
                $text = getHundredsFromAmount($firstDigits) . ' mil ' . getHundredsFromAmount($hundreds);
            }
            
            return $text;
        }
    } else return getHundredsFromAmount($amount);
}

function isAdmin()
{
    return auth()->user()->level == 0;
}
