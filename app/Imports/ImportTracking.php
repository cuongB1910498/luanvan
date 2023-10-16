<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTracking implements WithMultipleSheets
{
    protected $address_sending;

    public function __construct($address_sending)
    {
        $this->address_sending = $address_sending;
    }   
    public function sheets(): array
    {
        
        return [
            new FirstSheetImport($this->address_sending)
        ];
    }

    
}
