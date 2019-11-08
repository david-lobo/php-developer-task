<?php

namespace App\Services;

interface StudentExportServiceInterface
{
    public function exportSelected(array $studentIds) : string;
}