<?php

namespace App\Traits;

/**
 * Trait HasFormatRupiah
 */
trait HasFormatRupiah
{
    function formatRupiah($field, $prefix = null)
    {
        $prefix = $prefix ? $prefix : 'Rp. ';
        $nominal = $this->attributes[$field];
        return $prefix.number_format($nominal, 0, ',', '.');
    }
}


?>
