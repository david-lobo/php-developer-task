<?php

namespace App\Services;

use App\Library\CSVFileExporter;
use App\Models\Student;
use Carbon\Carbon;

class StudentExportService implements StudentExportServiceInterface
{
    protected $exporter;

    public function __construct(CSVFileExporter $exporter) 
    {
        $this->exporter = $exporter;    
    }

    public function exportSelected(array $studentIds) : string
    {
        // Append a timestamp to make unique filename
        $now = Carbon::now();
        $fileId = $now->format('Ymdhis');
        $filename = "students_{$fileId}.csv";
        
        // Add CSV Column headers
        $allData = [
            [
                'Forename',	
                'Surname',
                'Email',
                'University',
                'Course'
            ]
        ];

        $exportData = [];
        if (!empty($studentIds)) {
            $students = Student::whereIn('id', $studentIds)->with('course')->limit(100)->get()->toArray();
            $exportData = array_map('App\Models\Student::toCSV', $students);
            $allData = array_merge($allData, $exportData);
        }
        
        // Save the row data to a CSV file
        $csvFilename = $this->exporter->export($filename, $allData);

        return $csvFilename;
    }
}