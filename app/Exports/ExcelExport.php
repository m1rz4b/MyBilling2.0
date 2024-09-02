<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;
    }
    
    // public function headings(): array
    // {
    //     return ["Sl", "Invoice No", "Client ID"];
    // }
}
