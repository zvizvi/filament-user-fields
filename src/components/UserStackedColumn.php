<?php

namespace Zvizvi\UserFields\Components;

use Filament\Tables\Columns\ImageColumn;

class UserStackedColumn extends ImageColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->imageHeight(24)
            ->circular()
            ->stacked()
            ->checkFileExistence(false)
            ->tooltip(fn($state) => $state?->name);
    }

    public function getImageUrl(?string $state = null): ?string
    {
        if (!$state) {
            return null;
        }

        $userData = json_decode($state);
        $user = $this->getState()->firstWhere('id', $userData->id);
        return $user ? filament()->getUserAvatarUrl($user) : null;
    }
}
