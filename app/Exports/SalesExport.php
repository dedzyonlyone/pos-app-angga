<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Enumerable;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection(): Enumerable
    {
        return Sale::with(['user', 'customer'])
            ->where('status', 'paid')
            ->whereDate('sale_date', '>=', $this->startDate)
            ->whereDate('sale_date', '<=', $this->endDate)
            ->orderBy('sale_date', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Tanggal',
            'Kasir',
            'Pelanggan',
            'Metode Bayar',
            'Subtotal (Rp)',
            'Diskon (Rp)',
            'Total (Rp)',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->invoice_number,
            $sale->sale_date->format('d/m/Y H:i'),
            $sale->user->name,
            $sale->customer->name ?? 'Umum',
            strtoupper($sale->payment_method),
            $sale->subtotal,
            $sale->discount,
            $sale->total,
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0F4C5C']]
            ],
        ];
    }
}