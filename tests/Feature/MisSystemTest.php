<?php

use App\Models\HousingApplication;
use App\Models\Scheme;
use App\Models\User;
use App\Models\Village;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\MisSeeder;

beforeEach(function () {
    $this->seed([AdminUserSeeder::class, MisSeeder::class]);
});

test('admin can access mis dashboard with stats', function () {
    $admin = User::where('email', 'admin@example.com')->first();

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Dashboard')
        ->assertSee('Recent applications');
});

test('customer can view their housing applications', function () {
    $customer = User::where('email', 'beneficiary@example.com')->first();

    $this->actingAs($customer)
        ->get(route('applications.index'))
        ->assertOk()
        ->assertSee('Housing Applications');
});

test('officer can access gis map', function () {
    $officer = User::where('email', 'officer@example.com')->first();

    $this->actingAs($officer)
        ->get(route('gis.index'))
        ->assertOk()
        ->assertSee('GIS Map');
});

test('customer can create a housing application draft', function () {
    $customer = User::where('email', 'beneficiary@example.com')->first();
    $scheme = Scheme::first();
    $village = Village::first();

    $this->actingAs($customer)
        ->post(route('applications.store'), [
            'scheme_id' => $scheme->id,
            'village_id' => $village->id,
            'site_address' => 'Test site',
            'latitude' => 26.9,
            'longitude' => 80.9,
        ])
        ->assertRedirect();

    expect(HousingApplication::where('user_id', $customer->id)->count())->toBeGreaterThan(1);
});

test('admin can access master data and audit logs', function () {
    $admin = User::where('email', 'admin@example.com')->first();

    $this->actingAs($admin)
        ->get(route('master.districts.index'))
        ->assertOk()
        ->assertSee('Lucknow');

    $this->actingAs($admin)
        ->get(route('audit-logs.index'))
        ->assertOk()
        ->assertSee('Audit trail');
});

test('customer cannot access admin audit logs', function () {
    $customer = User::where('email', 'beneficiary@example.com')->first();

    $this->actingAs($customer)
        ->get(route('audit-logs.index'))
        ->assertForbidden();
});

test('mis modules overview page is accessible', function () {
    $admin = User::where('email', 'admin@example.com')->first();

    $this->actingAs($admin)
        ->get(route('modules.index'))
        ->assertOk()
        ->assertSee('GIS / Maps')
        ->assertSee('Workflow / Approval')
        ->assertSee('Financial Tracking');
});
