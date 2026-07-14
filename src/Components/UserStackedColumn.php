<?php

namespace Zvizvi\UserFields\Components;

use Filament\Tables\Columns\ImageColumn;
use Zvizvi\UserFields\Components\Concerns\CanResolveUser;

class UserStackedColumn extends ImageColumn
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
