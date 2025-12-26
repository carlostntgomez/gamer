<?php

if (!function_exists('format_price')) {
    /**
     * Formats a number as a price, with the currency symbol.
     *
     * @param float|int $amount The amount to format.
     * @param string $currency The currency symbol (defaults to '$').
     * @return string The formatted price.
     */
    function format_price(float|int $amount, string $currency = '$'): string
    {
        // You can customize the decimals, decimal separator, and thousands separator here
        return $currency . number_format($amount, 2, '.', ',');
    }
}
