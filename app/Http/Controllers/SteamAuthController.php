<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Invisnik\LaravelSteamAuth\SteamAuth;

class SteamAuthController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected SteamAuth $steam;

    /**
     * AuthController constructor.
     *
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    /**
     * Redirect the user to the authentication page
     *
     * @return RedirectResponse
     */
    public function redirectToSteam(): RedirectResponse
    {
        return $this->steam->redirect();
    }

    /**
     * Get user info and log in
     *
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function handle(): RedirectResponse
    {
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();
            if (!is_null($info)) {

                // Find user or fail
                try {
                    $user = User::where('steam_id', $info['steamID64'])->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    return redirect(route('steps.start'))
                        ->withErrors(['message' => "
                        <strong>We couldn't find a PhoenixBase account linked to this Steam profile.</strong>
                        <br>
                        If you need any assistance, please let us know in the
                        <a class='font-medium underline text-red-700 hover:text-red-600' href='https://discord.gg/PhoenixVTC' target='_blank'>#member-support channel on Discord</a>.
                        "]);
                }

                // Check if the user has permission to use Switch
                if (!$user->can('use switch')) {
                    return redirect(route('steps.start'))
                        ->withErrors(['message' => "
                        <strong>You don't have access to access Phoenix Switch yet.</strong>
                        <br>
                        Currently, only beta testers have access to this platform.
                        <br>
                        If you need any assistance, please let us know in the
                        <a class='font-medium underline text-red-700 hover:text-red-600' href='https://discord.gg/PhoenixVTC' target='_blank'>#member-support channel on Discord</a>.
                        "]);
                }

                Auth::login($user);

                return redirect(route('steps.configure-trucksbook'));
            }
        }

        return $this->redirectToSteam();
    }
}
