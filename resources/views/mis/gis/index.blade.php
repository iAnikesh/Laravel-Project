<x-mis-layout>
    <x-slot name="header">GIS Map</x-slot>
    <x-slot name="subheader">Geospatial view of housing project sites</x-slot>

    <div id="map" class="h-[calc(100vh-12rem)] min-h-[400px] rounded-xl border border-slate-200 shadow-sm"></div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
        <script>
            const markers = @json($markers);
            const map = L.map('map').setView([26.8467, 80.9462], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const bounds = [];
            markers.forEach(m => {
                const marker = L.marker([m.lat, m.lng]).addTo(map);
                marker.bindPopup(`<strong>${m.number}</strong><br>${m.beneficiary}<br>${m.scheme}<br>Status: ${m.status_label}<br>Progress: ${m.completion}%<br><a href="${m.url}">View details</a>`);
                bounds.push([m.lat, m.lng]);
            });

            if (bounds.length) {
                map.fitBounds(bounds, { padding: [40, 40], maxZoom: 14 });
            }
        </script>
    @endpush
</x-mis-layout>
