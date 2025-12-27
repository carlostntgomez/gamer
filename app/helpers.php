<?php

if (!function_exists('format_price')) {
    /**
     * Formats a number as a price, with the currency symbol.
     *
     * @param float|int|null $amount The amount to format.
     * @param string $currency The currency symbol (defaults to '$').
     * @return string The formatted price.
     */
    function format_price(float|int|null $amount, string $currency = '$'): string
    {
        if (is_null($amount)) {
            return $currency . '0.00';
        }

        // You can customize the decimals, decimal separator, and thousands separator here
        return $currency . number_format($amount, 2, '.', ',');
    }
}
