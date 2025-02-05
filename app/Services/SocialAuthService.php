<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Exception;

class SocialAuthService
{
    /**
     * Redirect to the social provider.
     *
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(string $provider)
    {
        request()->setLaravelSession(Session::driver('array'));
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle social provider callback.
     *
     * @param string $provider
     * @return User
     * @throws Exception
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            throw new Exception('Failed to authenticate with ' . $provider);
        }

        return $this->findOrCreateUser($socialUser, $provider);
    }

    /**
     * Find or create user based on social account.
     *
     * @param $socialUser
     * @param string $provider
     * @return User
     */
    private function findOrCreateUser($socialUser, string $provider)
    {
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if ($socialAccount) {
            return $socialAccount->user;
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'  => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(str()->random(12)), // Default password (random)
            ]);
        }

        $user->socialAccounts()->create([
            'provider_id'   => $socialUser->getId(),
            'provider_name' => $provider
        ]);

        return $user;
    }
}
