<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected string $filter;
    protected ?int $classId;
    protected ?int $activityId;

    public function __construct(string $filter = 'all', ?int $classId = null, ?int $activityId = null)
    {
        $this->filter     = $filter;
        $this->classId    = $classId;
        $this->activityId = $activityId;
    }

    public function query()
    {
        $query = Student::with(['schoolClass', 'activities']);

        match ($this->filter) {
            'approved'  => $query->where('status', 'approved'),
            'pending'   => $query->where('status', 'pending'),
            'rejected'  => $query->where('status', 'rejected'),
            'by_class'  => $query->where('class_id', $this->classId),
            'by_activity' => $query->whereHas('activities', fn($q) => $q->where('activities.id', $this->activityId)),
            default     => $query,
        };

        return $query->orderBy('full_name');
    }

    public function headings(): array
    {
        return [
            'الاسم الكامل',
            'الرقم القومي',
            'رقم الهاتف',
            'اسم الفصل',
            'الأنشطة',
            'الحالة',
            'تاريخ التسجيل',
        ];
    }

    public function map($student): array
    {
        return [
            $student->full_name,
            $student->national_id,
            $student->phone,
            $student->schoolClass?->name ?? '-',
            $student->activities->pluck('name')->implode(' - '),
            $student->status_label,
            $student->created_at->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'size'  => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'الطلاب';
    }
}
