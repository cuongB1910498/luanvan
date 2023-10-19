<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VatExport implements FromView
{
    protected $data;
    protected $additionalInfo;

    public function __construct(array $data, $additionalInfo)
    {
        $this->data = $data;
        $this->additionalInfo = $additionalInfo;
    }
    public function view(): View
    {
        $additionalInfo = $this->additionalInfo;
        return view('pages.exportvat', [
            'data' => $this->data,
            'additionalInfo'=>$this->additionalInfo,
        ]);
    }
}
