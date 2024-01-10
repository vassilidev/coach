<?php

namespace App\Services\MeetingLink;

use App\Contracts\MeetingLinkCreatorInterface;
use App\Exceptions\MeetingLink\InvalidMeetingLinkProvider;
use App\Exceptions\MeetingLink\MeetingLinkProviderNotFound;
use App\Services\MeetingLink\Providers\Jitsi\JitsiBuilder;
use Throwable;

class MeetingLinkCreator implements MeetingLinkCreatorInterface
{
    protected string $provider;

    public ?MeetingLinkCreatorInterface $providerInstance = null;

    public array $providers = [
        'jitsi' => JitsiBuilder::class,
    ];

    /**
     * @throws Throwable
     */
    public function __construct()
    {
        $this->setProvider(config('meetingLink.defaultProvider'));
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @throws Throwable
     */
    public function setProvider(string $provider): self
    {
        throw_unless(array_key_exists($provider, $this->providers), MeetingLinkProviderNotFound::class);

        throw_unless(is_a(new $this->providers[$provider], MeetingLinkCreatorInterface::class), InvalidMeetingLinkProvider::class);

        $this->provider = $provider;

        $this->resolveProvider();

        return $this;
    }

    public function resolveProvider(): MeetingLinkCreatorInterface
    {
        if (is_null($this->providerInstance)) {
            $this->providerInstance = new ($this->providers[$this->provider])();
        }

        return $this->providerInstance;
    }

    public function getMeetingLink(): string
    {
        return $this->resolveProvider()->getMeetingLink();
    }
}