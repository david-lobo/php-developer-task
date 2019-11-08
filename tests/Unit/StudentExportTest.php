<?php

namespace Tests\Unit;

use App\Library\CSVFileExporter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Generator as Faker;
use App\Models\Course;
use App\Models\Student;
use Storage;

class StudentExportTest extends TestCase
{
    /** @test */
    public function it_can_export_all_students_to_csv_file()
    {
        $filename = 'test_all_students.csv';
        $exporter = new CSVFileExporter();
        
        // Add CSV Column headers
        $testData = [
            [
                'Forename',	
                'Surname',
                'Email',
                'University',
                'Course'
            ]
        ];

        $students = Student::with('course')->limit(100)->get()->toArray();

        $this->assertNotEmpty($students);

        $exportData = array_map('App\Models\Student::toCSV', $students);

        $testData = array_merge($testData, $exportData);
        //var_dump($testData);
        //var_dump($students);

        // Save the row data to a CSV file
        $csvFilename = $exporter->export($filename, $testData);

        // Check a filename is returned
        $this->assertNotEmpty($csvFilename);

        // Check the file exists in storage
        $exists = Storage::exists($csvFilename);
        $this->assertTrue($exists);

        // Retrieve and parse the CSV data
        $fileData = Storage::get($csvFilename);
        $this->assertNotEmpty($fileData);
        //var_dump($data);
        $rowData = explode("\n", $fileData);
        $parsedRows = [];
        
        foreach ($rowData as $row) {
            $csvRow = str_getcsv($row);
            $parsedRows[] = $csvRow;
        }
        
        // Check that file data matches test data
        foreach ($testData as $rowIndex => $testRow) {
            foreach($testRow as $colIndex => $testCol) {
                $this->assertEquals($testCol, $parsedRows[$rowIndex][$colIndex]);
            }
        }
    }
}
