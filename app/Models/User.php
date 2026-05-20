<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'role', 'unique_user_id', 'phone', 'aadhaar_number', 'address_1', 'address_2', 'city', 'pin_code', 'district', 'state', 'bank_account_number', 'bank_ifsc_code', 'bank_branch'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'role' => UserRole::class,
        ];
    }

    public function housingApplications(): HasMany
    {
        return $this->hasMany(HousingApplication::class);
    }

    public function assignedApplications(): HasMany
    {
        return $this->hasMany(HousingApplication::class, 'assigned_officer_id');
    }

    public function grievances(): HasMany
    {
        return $this->hasMany(Grievance::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isOfficer(): bool
    {
        return $this->role === UserRole::Officer;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    public function isStaff(): bool
    {
        return $this->isAdmin() || $this->isOfficer();
    }
}
