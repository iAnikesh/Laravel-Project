<?php

namespace App\Http\Controllers;

use App\Models\HousingApplication;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GisMapController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = HousingApplication::query()
            ->with(['beneficiary', 'scheme', 'village'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if ($request->user()->isCustomer()) {
            $query->where('user_id', $request->user()->id);
        }

        $markers = $query->get()->map(fn (HousingApplication $app) => [
            'id' => $app->id,
            'lat' => (float) $app->latitude,
            'lng' => (float) $app->longitude,
            'number' => $app->application_number,
            'status' => $app->status->value,
            'status_label' => $app->status->label(),
            'beneficiary' => $app->beneficiary->name,
            'scheme' => $app->scheme->name,
            'village' => $app->village->name,
            'completion' => $app->completion_percentage,
            'url' => route('applications.show', $app),
        ]);

        return view('mis.gis.index', ['markers' => $markers]);
    }
}
