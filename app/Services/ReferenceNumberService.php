<?php

namespace App\Services;

use Illuminate\Support\Str;

class ReferenceNumberService
{
    public function application(): string
    {
        return 'HA-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));
    }

    public function grievance(): string
    {
        return 'GR-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));
    }
}
