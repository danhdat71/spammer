<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomerImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Customer::firstOrCreate([
                'name' => $row[0],
                'cccd' => $row[1] ?? "",
                'phone' => $row[2],
                'address' => $row[3] ?? ""
            ]);
        }
    }
}
