<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTracking implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new FirstSheetImport()
        ];
    }

    
}
