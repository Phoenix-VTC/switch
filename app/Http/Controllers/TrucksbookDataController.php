<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParseTrucksbookUserIdRequest;
use App\Jobs\ProcessJobTransfer;
use App\Models\Job;
use App\Models\StartedImport;
use Auth;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class TrucksbookDataController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTrucksbookIdentifierPage(Request $request)
    {
        return view('steps.configure-trucksbook-identifier', ['identifier' => $this->generateTrucksbookIdentifier($request)]);
    }

    public function findTrucksbookAccount(ParseTrucksbookUserIdRequest $request)
    {
        $client = new Client();

        // Try to access the TrucksBook profile
        try {
            (string)$response = $client->request('GET', 'https://trucksbook.eu/profile/' . $request['user_id'])->getBody();
        } catch (RequestException | ClientException | ServerException $e) {
            return redirect(route('steps.configure-trucksbook'))
                ->withErrors(['message' => '<strong>Oh no! Something went wrong while trying to connect to TrucksBook:</strong><br>' . $e->getMessage()])
                ->withInput();
        }

        // Check if the profile exists
        try {
            $this->checkIfProfileExists($response);
        } catch (Throwable $e) {
            return redirect(route('steps.configure-trucksbook'))
                ->withErrors(['message' => $e->getMessage()])
                ->withInput();
        }

        // Check if the profile contains the provided username
        try {
            $this->checkIfProfileContainsUsername($response, $request['username']);
        } catch (Throwable $e) {
            return redirect(route('steps.configure-trucksbook'))
                ->withErrors(['message' => $e->getMessage()])
                ->withInput();
        }

        // Check if the profile contains the Identifier
        try {
            $this->checkIfProfileContainsIdentifier($response, $request->session()->get('trucksbook_identifier'));
        } catch (Throwable $e) {
            return redirect(route('steps.configure-trucksbook'))
                ->withErrors(['message' => $e->getMessage()])
                ->withInput();
        }

        $request->session()->put('trucksbook_username', $request['username']);

        return redirect()->route('steps.confirm-jobs');
    }

    public function showConfirmJobsPage(Request $request)
    {
        if (!$request->session()->has('trucksbook_username')) {
            return redirect()->route('steps.start');
        }

        $username = $request->session()->get('trucksbook_username');
        $recent_jobs = Job::where('trucksbook_username', $username)
            ->orderBy('trucksbook_job_id', 'desc')
            ->limit(10)
            ->get();

        return view('steps.confirm-jobs', ['recent_jobs' => $recent_jobs]);
    }

    /**
     * Check if a TrucksBook profile exists, based on the HTML page.
     * TrucksBook does not return 404s on these pages, hence why the str_contains.
     *
     * @param string $profile
     * @throws Throwable
     */
    private function checkIfProfileExists(string $profile): void
    {
        $profile_exists = !str_contains($profile, 'User does not exist');

        throw_unless($profile_exists, new Exception("
            <strong>This User ID does not exist on TrucksBook.</strong>
            <br>
            If you need any assistance, please let us know in the
            <a class='font-medium underline text-red-700 hover:text-red-600' href='https://discord.gg/PhoenixVTC' target='_blank'>#member-support channel on Discord</a>.
        "));
    }

    /**
     * Check if the TrucksBook profile contains the provided username.
     *
     * @param string $profile
     * @param string $username
     * @throws Throwable
     */
    private function checkIfProfileContainsUsername(string $profile, string $username): void
    {
        $has_identifier = str_contains($profile, 'Phoenix ' . $username);

        throw_unless($has_identifier, new Exception("
            <strong>We couldn't link the above username with this profile.<br>Please try again.</strong>
            <br>
            If you need any assistance, please let us know in the
            <a class='font-medium underline text-red-700 hover:text-red-600' href='https://discord.gg/PhoenixVTC' target='_blank'>#member-support channel on Discord</a>.
        "));
    }

    /**
     * Check if the TrucksBook profile contains the identifier.
     *
     * @param string $profile
     * @param string $identifier
     * @throws Throwable
     */
    private function checkIfProfileContainsIdentifier(string $profile, string $identifier): void
    {
        $has_identifier = str_contains($profile, $identifier);

        throw_unless($has_identifier, new Exception("
            <strong>We couldn't find the provided identifier (step 2) in this profile.<br>Please try again.</strong>
            <br>
            If you need any assistance, please let us know in the
            <a class='font-medium underline text-red-700 hover:text-red-600' href='https://discord.gg/PhoenixVTC' target='_blank'>#member-support channel on Discord</a>.
        "));
    }

    private function generateTrucksbookIdentifier(Request $request): string
    {
        if ($request->session()->has('trucksbook_identifier')) {
            return $request->session()->get('trucksbook_identifier');
        }

        $identifier = Str::random();

        $request->session()->put('trucksbook_identifier', $identifier);

        return $identifier;
    }

    public function startDataTransfer(Request $request)
    {
        $started_import = StartedImport::create(['user_id' => Auth::id()]);

        ProcessJobTransfer::dispatch(Auth::user(), $request->session()->get('trucksbook_username'));

        // Handle success page
    }
}
