<?php

namespace App\Models;

use App\Enums\FinancialRecordType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'housing_application_id', 'type', 'amount', 'reference_number',
        'description', 'transaction_date', 'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'type' => FinancialRecordType::class,
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
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
