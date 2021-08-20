<?php

namespace App\Jobs;

use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use App\Models\BaseJob;
use App\Models\Job as TrucksBookJob;
use App\Models\StartedImport;
use App\Models\User;
use App\Notifications\Discord\ErroredJobTransfer as DiscordErroredJobTransfer;
use App\Notifications\Discord\SuccessfulJobTransfer as DiscordSuccessfulJobTransfer;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcessJobTransfer implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private User $user;
    private string $username;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $username
     */
    public function __construct(User $user, string $username)
    {
        $this->user = $user;
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): ?bool
    {
        $company = Company::firstOrCreate([
            'name' => 'PhoenixSwitch',
            'game_id' => 1,
        ]);

        $started_import = StartedImport::where('user_id', $this->user->id)->firstOrFail();

        DB::beginTransaction();
        try {
            TrucksBookJob::where('trucksbook_username', $this->username)->chunk(25, function ($trucksbook_jobs) use ($company) {
                foreach ($trucksbook_jobs as $trucksbook_job) {
                    $base_job = new BaseJob;

                    $base_job->user_id = $this->user->id;
                    $base_job->game_id = $this->gameNameToId($trucksbook_job->game);
                    $base_job->pickup_city_id = $this->findOrCreateCity($trucksbook_job->from)->id;
                    $base_job->destination_city_id = $this->findOrCreateCity($trucksbook_job->to)->id;
                    $base_job->pickup_company_id = $company->id;
                    $base_job->destination_company_id = $company->id;
                    $base_job->cargo_id = $this->findOrCreateCargo($trucksbook_job->cargo, $trucksbook_job->weight, $base_job->game_id)->id;
                    $base_job->finished_at = Carbon::now();
                    $base_job->distance = $this->parseDistance($trucksbook_job);
                    $base_job->load_damage = $trucksbook_job->damage;
                    $base_job->estimated_income = $this->parseIncome($trucksbook_job);
                    $base_job->total_income = $this->parseIncome($trucksbook_job);
                    $base_job->comments = $trucksbook_job->description . ' PhoenixSwitch Import. TrucksBook ID: ' . $trucksbook_job->trucksbook_job_id;
                    $base_job->status = 2;

                    $base_job->save();
                }
            });

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            TrucksBookJob::where('trucksbook_username', $this->username)
                ->first()
                ->notify(new DiscordErroredJobTransfer($this->user, [
                    'class' => get_class($exception),
                    'message' => $exception->getMessage()
                ]));

            $started_import->failed = true;
            $started_import->save();

            $this->fail();
            return false;
        }

        TrucksBookJob::where('trucksbook_username', $this->username)->first()->notify(new DiscordSuccessfulJobTransfer($this->user));

        $started_import->completed = true;
        $started_import->save();

        return true;
    }

    /**
     * Convert the Game Name to Base ID
     *
     * @param string $game
     * @return int
     * @throws Exception
     */
    private function gameNameToId(string $game): int
    {
        if ($game === 'ETS2') {
            return 1;
        }

        if ($game === 'ATS') {
            return 2;
        }

        throw new Exception('Could not convert Game Name to ID');
    }

    /**
     * @param string $city
     * @return City
     */
    private function findOrCreateCity(string $city): City
    {
        return City::firstOrCreate([
            'real_name' => $city,
        ], [
            'name' => Str::snake($city),
            'country' => 'Unknown'
        ]);
    }

    /**
     * @param string $cargo
     * @param int $weight
     * @param int $game_id
     * @return Cargo
     */
    private function findOrCreateCargo(string $cargo, int $weight, int $game_id): Cargo
    {
        // Convert the ETS cargo weight from kilos to tonnes
        if ($game_id === 1) {
            $weight = round($weight / 1000);
        }

        return Cargo::firstOrCreate([
            'name' => $cargo,
            'game_id' => $game_id,
        ], [
            'weight' => $weight,
        ]);
    }

    /**
     * @param $job
     * @return int
     * @throws Exception
     */
    public function parseDistance($job): int
    {
        if ($this->gameNameToId($job->game) === 2) {
            return $job->driven_distance * 1.609;
        }

        return $job->driven_distance;
    }

    /**
     * @param $job
     * @return int
     * @throws Exception
     */
    public function parseIncome($job): int
    {
        if ($this->gameNameToId($job->game) === 2) {
            return $job->profit * 0.83;
        }

        return $job->profit;
    }
}
