<?php

namespace Zvizvi\UserFields\Components;

use Filament\Infolists\Components\ImageEntry;
use Zvizvi\UserFields\Components\Concerns\CanResolveUser;

class UserStackedEntry extends ImageEntry
{
    use CanResolveUser;

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
            ->tooltip(function ($state, $record) {
                $user = $this->resolveUserFromState($state, $record);

                return $user ? filament()->getUserName($user) : null;
            });
    }

    public function getImageUrl($userData = null): ?string
    {
        $user = $this->resolveUserFromState($userData, $this->getRecord());

        return $user ? filament()->getUserAvatarUrl($user) : null;
    }
}
