<?php

namespace App\Library;

interface FileExporterInterface
{
    public function export(string $filename, array $rows) : string;
}