<?php

namespace App\Services\MeetingLink\Providers\Jitsi;

use App\Contracts\MeetingLinkCreatorInterface;
use Illuminate\Support\Str;

class JitsiBuilder implements MeetingLinkCreatorInterface
{
    protected string $baseUrl;

    protected string $roomName;

    public function __construct()
    {
        $this->baseUrl = config('services.jitsi.base_url');

        $this->roomName = Str::slug(config('app.name')) . '-' . Str::uuid();
    }

    public function getRoomName(): string
    {
        return $this->roomName;
    }

    public function setRoomName(string $roomName): void
    {
        $this->roomName = $roomName;
    }

    public function getMeetingLink(): string
    {
        return $this->baseUrl . $this->getRoomName();
    }
}