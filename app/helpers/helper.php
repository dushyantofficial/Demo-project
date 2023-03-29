<?php


use App\Models\Admin\Notification;
use App\Models\Admin\User_Rating;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;


function get_currency($currency)
{
    return '$' . number_format($currency, 2, ".", ",");
}


function get_rupee_currency($rupee_currency)
{
    return '₹' . number_format($rupee_currency, 2, ".", ",");
}



function date_formate($date)
{
    return \Carbon\Carbon::parse($date)->format('Y-m-d');
}

function formate_date($date)
{
    return \Carbon\Carbon::parse($date)->format('d-m-Y');
}

function translateToGujarati($text)
{
    $translate = new GoogleTranslate();
    $translate->setSource('en');
    $translate->setTarget('gu');
    return $translate->translate($text);
}

function translateToEnglish($text)
{
    $translate = new GoogleTranslate();
    $translate->setSource('gu');
    $translate->setTarget('en');
    return $translate->translate($text);
}

function gujarati_date($date)
{
    // Convert the English digit date to a Carbon instance
    $carbon = Carbon::parse($date);

    // Replace the English digits with Gujarati digits in the date string
    $gujarati_date = strtr($carbon->format('d-m-Y'), [
        '0' => '૦',
        '1' => '૧',
        '2' => '૨',
        '3' => '૩',
        '4' => '૪',
        '5' => '૫',
        '6' => '૬',
        '7' => '૭',
        '8' => '૮',
        '9' => '૯',
    ]);

    return $gujarati_date;
}


function gujarati_number($number)
{
    $gujarati_digits = [
        '૦',
        '૧',
        '૨',
        '૩',
        '૪',
        '૫',
        '૬',
        '૭',
        '૮',
        '૯',
    ];

    // Convert each English digit to the corresponding Gujarati digit
    $gujarati_number = '';
    $english_digits = str_split((string)$number);
    foreach ($english_digits as $digit) {
        $gujarati_number .= $gujarati_digits[$digit];
    }

    return $gujarati_number;
}


if (! function_exists('englishToGujaratiNumber')) {
    function englishToGujaratiNumber($number) {
        $numbers = $number;

        $formatter = new NumberFormatter('guj', NumberFormatter::DECIMAL);
        $formatter->setSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL, '.');
        $formatter->setSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL, ',');
        $gujaratiNumber = $formatter->format($numbers);
//        dd($gujaratiNumber);

        return $gujaratiNumber;
    }
}



