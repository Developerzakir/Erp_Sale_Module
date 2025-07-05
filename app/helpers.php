<?php
if (!function_exists('calculateSaleTotal')) {
    function calculateSaleTotal($items) {
        return collect($items)->sum(function ($item) {
            return ($item['quantity'] * $item['price']) - $item['discount'];
        });
    }
}