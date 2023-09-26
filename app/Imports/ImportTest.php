<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ImportTest implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new FirstSheetImport()
        ];
    }
    // public function model(array $row)
    // {
    //     return new test([
    //         'id_test' => null,
    //         'name' => $row[1], 
    //         'id_staff' => $row[2],
    //     ]);
    // }
}
