<?php

namespace App\Console\Commands;

use App\Imports\JobsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportTrucksbookJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trucksbook:import-jobs {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a TrucksBook CSV job export';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!Storage::exists($this->argument('file'))) {
            $this->error("Specified file doesn't exist.");

            exit;
        }

        $this->comment('Starting import');

        Excel::import(new JobsImport(), $this->argument('file'));

        $this->info('Import successful');
    }
}
