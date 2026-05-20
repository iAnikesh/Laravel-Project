<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'category', 'description',
        'budget_allocated', 'status', 'start_date', 'end_date', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'budget_allocated' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function housingApplications(): HasMany
    {
        return $this->hasMany(HousingApplication::class);
    }
}
