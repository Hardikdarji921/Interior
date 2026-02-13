<?php

namespace App\Services;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    public function generateQuotation(Project $project): array
    {
        $project->load(['items.material.category', 'items.colorOption', 'user', 'coupon']);

        $data = [
            'project' => $project,
            'company' => [
                'name' => config('app.name', 'Staging Interior Design'),
                'address' => '7176 Blue Spring Lane, Santa Monica, CA 90403',
                'phone' => '+84 123 456 789',
                'email' => 'info@staging.com',
                'website' => config('app.url'),
                'logo' => public_path('img/logo.png'),
            ],
            'quote_number' => 'QT-' . date('Y') . '-' . str_pad($project->id, 5, '0', STR_PAD_LEFT),
            'quote_date' => now()->format('F d, Y'),
            'valid_until' => $project->valid_until?->format('F d, Y') ?? now()->addDays(30)->format('F d, Y'),
        ];

        $pdf = Pdf::loadView('pdf.quotation', $data);
        
        $filename = 'quotation-' . $project->id . '-' . time() . '.pdf';
        $path = 'quotations/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());

        return [
            'success' => true,
            'filename' => $filename,
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
            'pdf' => $pdf,
        ];
    }

    public function generateInvoice(Project $project): array
    {
        $project->load(['items.material.category', 'items.colorOption', 'user']);

        $data = [
            'project' => $project,
            'company' => [
                'name' => config('app.name', 'Staging Interior Design'),
                'address' => '7176 Blue Spring Lane, Santa Monica, CA 90403',
                'phone' => '+84 123 456 789',
                'email' => 'info@staging.com',
                'gst_number' => 'GSTIN123456789',
                'logo' => public_path('img/logo.png'),
            ],
            'invoice_number' => 'INV-' . date('Y') . '-' . str_pad($project->id, 5, '0', STR_PAD_LEFT),
            'invoice_date' => now()->format('F d, Y'),
            'due_date' => now()->addDays(15)->format('F d, Y'),
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);
        
        $filename = 'invoice-' . $project->id . '-' . time() . '.pdf';
        $path = 'invoices/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());

        return [
            'success' => true,
            'filename' => $filename,
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ];
    }

    public function streamQuotation(Project $project)
    {
        $project->load(['items.material.category', 'items.colorOption', 'user', 'coupon']);

        $data = [
            'project' => $project,
            'company' => [
                'name' => config('app.name', 'Staging Interior Design'),
                'address' => '7176 Blue Spring Lane, Santa Monica, CA 90403',
                'phone' => '+84 123 456 789',
                'email' => 'info@staging.com',
                'logo' => public_path('img/logo.png'),
            ],
            'quote_number' => 'QT-' . date('Y') . '-' . str_pad($project->id, 5, '0', STR_PAD_LEFT),
            'quote_date' => now()->format('F d, Y'),
            'valid_until' => $project->valid_until?->format('F d, Y') ?? now()->addDays(30)->format('F d, Y'),
        ];

        $pdf = Pdf::loadView('pdf.quotation', $data);
        
        return $pdf->stream('quotation-' . $project->id . '.pdf');
    }
}