<?php

namespace App\Imports;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class JobsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        return new Job([
            'trucksbook_username' => $row['name'] ?? 'Unknown Username',
            'trucksbook_job_id' => $row['trucksbookid'],
            'game' => $row['game'],
            'from' => $row['from'],
            'to' => $row['to'],
            'cargo' => $row['cargo'] ?? 'Unknown Cargo',
            'damage' => $row['damage'],
            'xp' => $row['xp'],
            'profit' => $this->removeNonNumericChars($row['profit']),
            'planned_distance' => $this->removeNonNumericChars($row['planned_distance']),
            'driven_distance' => $this->removeNonNumericChars($row['driven_distance']),
            'weight' => $this->removeNonNumericChars($row['weight']),
            'description' => $row['description'],
        ]);
    }

    private function removeNonNumericChars($string): int
    {
        return preg_replace('/[\D]/', '', $string );
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function uniqueBy(): string
    {
        return 'trucksbook_job_id';
    }
}
