<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\HousingApplication;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function __construct(protected AuditLogService $auditLog) {}

    public function store(Request $request, HousingApplication $application): RedirectResponse
    {
        $this->authorize('view', $application);

        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,doc,docx'],
            'category' => ['required', 'string', 'max:50'],
            'name' => ['nullable', 'string', 'max:200'],
        ]);

        $file = $request->file('file');
        $path = $file->store("applications/{$application->id}", 'public');

        $document = $application->documents()->create([
            'name' => $validated['name'] ?? $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'category' => $validated['category'],
            'uploaded_by' => $request->user()->id,
        ]);

        $this->auditLog->log('document.uploaded', "Document uploaded for {$application->application_number}.", $document);

        return back()->with('status', 'Document uploaded successfully.');
    }

    public function download(Document $document): StreamedResponse
    {
        $application = $document->documentable;
        abort_unless($application instanceof HousingApplication, 404);
        $this->authorize('view', $application);

        return Storage::disk('public')->download($document->file_path, $document->name);
    }

    public function destroy(Document $document): RedirectResponse
    {
        $application = $document->documentable;
        abort_unless($application instanceof HousingApplication, 404);
        $this->authorize('update', $application);

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        $this->auditLog->log('document.deleted', "Document removed from {$application->application_number}.", $application);

        return back()->with('status', 'Document deleted.');
    }
}
