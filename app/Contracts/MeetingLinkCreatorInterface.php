<?php

namespace App\Contracts;

interface MeetingLinkCreatorInterface
{
    public function getMeetingLink(): string;
}