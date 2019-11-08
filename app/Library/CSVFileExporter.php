<?php

namespace App\Library;

use Storage;

class CSVFileExporter implements FileExporterInterface
{
    public function export(string $filename, array $rows) : string
    {   
        $count = 0;

        foreach ($rows as $row) {
            $commaSeparated = implode('","', $row);
            $commaSeparated = '"' . $commaSeparated . '"';
            if ($count === 0) {
                Storage::put($filename, $commaSeparated);
            } else {
                Storage::append($filename, $commaSeparated);
            }
            $count++;
        }

        return $filename;
    }
}