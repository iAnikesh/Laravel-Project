<?php

namespace App\Models;

use App\Enums\ProgressStage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationProgress extends Model
{
    use HasFactory;

    protected $table = 'application_progress';

    protected $fillable = [
        'housing_application_id', 'stage', 'percentage', 'notes', 'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'stage' => ProgressStage::class,
        ];
    }

    public function housingApplication(): BelongsTo
    {
        return $this->belongsTo(HousingApplication::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
