<?php

namespace App\Models;

use App\Enums\GrievanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grievance extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number', 'user_id', 'housing_application_id',
        'subject', 'description', 'status', 'admin_response',
        'assigned_to', 'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => GrievanceStatus::class,
            'resolved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function housingApplication(): BelongsTo
    {
        return $this->belongsTo(HousingApplication::class);
    }

    public function assignedOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
