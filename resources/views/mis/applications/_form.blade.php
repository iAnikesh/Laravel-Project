@props(['application' => null, 'schemes', 'villages'])

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mis-label">Scheme *</label>
        <select name="scheme_id" class="mis-input mt-1" required>
            <option value="">Select scheme</option>
            @foreach ($schemes as $scheme)
                <option value="{{ $scheme->id }}" @selected(old('scheme_id', $application?->scheme_id) == $scheme->id)>{{ $scheme->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mis-label">Village *</label>
        <select name="village_id" class="mis-input mt-1" required>
            <option value="">Select village</option>
            @foreach ($villages as $village)
                <option value="{{ $village->id }}" @selected(old('village_id', $application?->village_id) == $village->id)>
                    {{ $village->name }} ({{ $village->block->name }}, {{ $village->block->district->name }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="mis-label">Site address</label>
        <input type="text" name="site_address" value="{{ old('site_address', $application?->site_address) }}" class="mis-input mt-1" placeholder="Construction site location">
    </div>
    <div>
        <label class="mis-label">Latitude (GIS)</label>
        <input type="number" step="any" name="latitude" value="{{ old('latitude', $application?->latitude) }}" class="mis-input mt-1" placeholder="e.g. 26.8467">
    </div>
    <div>
        <label class="mis-label">Longitude (GIS)</label>
        <input type="number" step="any" name="longitude" value="{{ old('longitude', $application?->longitude) }}" class="mis-input mt-1" placeholder="e.g. 80.9462">
    </div>
    <div class="md:col-span-2">
        <label class="mis-label">Notes</label>
        <textarea name="notes" rows="3" class="mis-input mt-1">{{ old('notes', $application?->notes) }}</textarea>
    </div>
</div>
