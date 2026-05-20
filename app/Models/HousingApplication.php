<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Enums\ProgressStage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HousingApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number', 'user_id', 'scheme_id', 'village_id',
        'assigned_officer_id', 'status', 'current_stage', 'completion_percentage',
        'latitude', 'longitude', 'site_address', 'notes',
        'submitted_at', 'reviewed_at', 'approved_at', 'rejected_at', 'rejection_remarks',
    ];

    protected function casts(): array
    {
        return [
            'status' => ApplicationStatus::class,
            'current_stage' => ProgressStage::class,
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scheme(): BelongsTo
    {
        return $this->belongsTo(Scheme::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function assignedOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_officer_id');
    }

    public function progressEntries(): HasMany
    {
        return $this->hasMany(ApplicationProgress::class);
    }

    public function financialRecords(): HasMany
    {
        return $this->hasMany(FinancialRecord::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function grievances(): HasMany
    {
        return $this->hasMany(Grievance::class);
    }

    public function canBeEditedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCustomer() && $this->user_id === $user->id) {
            return in_array($this->status, [ApplicationStatus::Draft, ApplicationStatus::Rejected], true);
        }

        return $user->isOfficer();
    }
}
