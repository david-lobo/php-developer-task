<?php

namespace Tests\Unit;

use App\Library\CSVFileExporter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Generator as Faker;
use Storage;

class FileExportTest extends TestCase
{
    /** @test */
    public function it_can_export_test_data_to_csv_file()
    {
        $filename = 'test_students.csv';
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

        // Add CSV rows for testing
        for ($i = 0; $i < 10; $i++) {
            $testData[] = [
                $this->faker->firstName,
                $this->faker->lastName,
                $this->faker->email,
                $this->faker->company,
                $this->faker->words($nb = 3, $asText = true)
            ];
        }

        // Save the row data to a CSV file
        $csvFilename = $exporter->export($filename, $testData);
        //echo $text;

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
        //
        //$this->assertNotEmpty($rows);

        /*foreach ($testData as $testRow) {
            foreach ($testRow as $index => $testCol) {

            }
        }*/

        //$this->assertEquals($testData[0][0], $rows[0]);
    }
}
