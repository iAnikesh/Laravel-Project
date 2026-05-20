<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    protected $fillable = ['block_id', 'name', 'code', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    public function housingApplications(): HasMany
    {
        return $this->hasMany(HousingApplication::class);
    }

    public function fullLocationName(): string
    {
        return "{$this->name}, {$this->block->name}, {$this->block->district->name}";
    }
}
