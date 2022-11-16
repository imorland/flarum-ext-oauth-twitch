<?php

/*
 * This file is part of ianm/oauth-twitch.
 *
 * Copyright (c) 2022 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\OAuthTwitch\Providers;

use Flarum\Forum\Auth\Registration;
use FoF\OAuth\Provider;
use League\OAuth2\Client\Provider\AbstractProvider;
use Vertisan\OAuth2\Client\Provider\TwitchHelix;
use Vertisan\OAuth2\Client\Provider\TwitchHelixResourceOwner;

class Twitch extends Provider
{
    /**
     * @var LineProvider
     */
    protected $provider;

    public function name(): string
    {
        return 'twitch';
    }

    public function link(): string
    {
        return 'https://dev.twitch.tv/docs/authentication/register-app';
    }

    public function fields(): array
    {
        return [
            'client_id'     => 'required',
            'client_secret' => 'required',
        ];
    }

    public function provider(string $redirectUri): AbstractProvider
    {
        return $this->provider = new TwitchHelix([
            'clientId'     => $this->getSetting('client_id'),
            'clientSecret' => $this->getSetting('client_secret'),
            'redirectUri'  => $redirectUri,
        ]);
    }

    public function options(): array
    {
        return [
            'scope'      => ['user:read:email'],
        ];
    }

    public function suggestions(Registration $registration, $user, string $token)
    {
        /** @var TwitchHelixResourceOwner $user */
        $registration
            ->suggestUsername($user->getDisplayName())
            ->setPayload($user->toArray());

        if ($email = $user->getEmail()) {
            $this->verifyEmail($email);
            $registration->provideTrustedEmail($email);
        }

        if ($picture = $user->getProfileImageUrl()) {
            $registration->provideAvatar($picture);
        }
    }
}
