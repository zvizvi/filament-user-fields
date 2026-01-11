<?php

namespace Zvizvi\UserFields\Components;

use Filament\Infolists\Components\ImageEntry;

class UserStackedEntry extends ImageEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->circular()
            ->stacked()
            ->checkFileExistence(false);

        $this
            ->imageHeight(24)
            ->ring(1)
            ->tooltip(fn($state) => $state?->name);
    }

    public function getImageUrl($userData = null): ?string
    {
        if (! $userData) {
            return null;
        }

        $user = $this->getState()->firstWhere('id', $userData->id);

        return $user ? filament()->getUserAvatarUrl($user) : null;
    }
}
