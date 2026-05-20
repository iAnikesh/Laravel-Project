<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Enums\FinancialRecordType;
use App\Enums\GrievanceStatus;
use App\Enums\ProgressStage;
use App\Enums\UserRole;
use App\Models\ApplicationProgress;
use App\Models\Block;
use App\Models\District;
use App\Models\FinancialRecord;
use App\Models\Grievance;
use App\Models\HousingApplication;
use App\Models\Scheme;
use App\Models\User;
use App\Models\Village;
use App\Services\ReferenceNumberService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MisSeeder extends Seeder
{
    public function run(): void
    {
        $references = new ReferenceNumberService;

        $district = District::query()->create([
            'name' => 'Lucknow',
            'code' => 'LKO',
            'state' => 'Uttar Pradesh',
        ]);

        $block = Block::query()->create([
            'district_id' => $district->id,
            'name' => 'Malihabad',
            'code' => 'MAL',
        ]);

        $village = Village::query()->create([
            'block_id' => $block->id,
            'name' => 'Rampur Khas',
            'code' => 'RPK',
        ]);

        $gay = Scheme::query()->create([
            'name' => 'Garib Awas Yojana',
            'code' => 'GAY',
            'category' => 'central',
            'description' => 'Pucca houses for rural families in kutcha or dilapidated dwellings.',
            'budget_allocated' => 5000000000,
            'start_date' => '2020-01-01',
        ]);

        Scheme::query()->create([
            'name' => 'PMAY-Gramin',
            'code' => 'PMAYG',
            'category' => 'central',
            'description' => 'Pradhan Mantri Awaas Yojana Gramin housing support.',
            'budget_allocated' => 3000000000,
        ]);

        $officer = User::query()->firstOrCreate(
            ['email' => 'officer@example.com'],
            [
                'name' => 'Field Officer',
                'password' => Hash::make('password'),
                'role' => UserRole::Officer,
                'email_verified_at' => now(),
            ],
        );

        $customer = User::query()->firstOrCreate(
            ['email' => 'beneficiary@example.com'],
            [
                'name' => 'Ramesh Kumar',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
                'unique_user_id' => '987654321012',
                'phone' => '9876543210',
                'district' => 'Lucknow',
                'state' => 'Uttar Pradesh',
                'email_verified_at' => now(),
            ],
        );

        $application = HousingApplication::query()->create([
            'application_number' => $references->application(),
            'user_id' => $customer->id,
            'scheme_id' => $gay->id,
            'village_id' => $village->id,
            'assigned_officer_id' => $officer->id,
            'status' => ApplicationStatus::InProgress,
            'current_stage' => ProgressStage::Foundation,
            'completion_percentage' => 25,
            'latitude' => 26.8467,
            'longitude' => 80.9462,
            'site_address' => 'Ward 4, Rampur Khas',
            'submitted_at' => now()->subDays(30),
            'approved_at' => now()->subDays(25),
        ]);

        ApplicationProgress::query()->create([
            'housing_application_id' => $application->id,
            'stage' => ProgressStage::Sanctioned,
            'percentage' => 10,
            'notes' => 'Sanction issued',
            'recorded_by' => $officer->id,
        ]);

        ApplicationProgress::query()->create([
            'housing_application_id' => $application->id,
            'stage' => ProgressStage::Foundation,
            'percentage' => 25,
            'notes' => 'Foundation work started',
            'recorded_by' => $officer->id,
        ]);

        FinancialRecord::query()->create([
            'housing_application_id' => $application->id,
            'type' => FinancialRecordType::BudgetAllocation,
            'amount' => 120000,
            'description' => 'Initial allocation',
            'transaction_date' => now()->subDays(28),
            'recorded_by' => $officer->id,
        ]);

        Grievance::query()->create([
            'reference_number' => $references->grievance(),
            'user_id' => $customer->id,
            'housing_application_id' => $application->id,
            'subject' => 'Installment delay',
            'description' => 'Second installment has not been credited to bank account.',
            'status' => GrievanceStatus::Open,
        ]);
    }
}
