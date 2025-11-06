<?php

namespace Zvizvi\UserFields\Components;

use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Collection;

class UserStackedColumn extends ImageColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->circular()
            ->stacked()
            ->checkFileExistence(false);

        if (method_exists($this, 'imageHeight')) {
            $this
                ->imageHeight(24)
                ->ring(1)
                ->tooltip(fn($state) => $state?->name);
        } else { // Filament 3
            $this
                ->extraImgAttributes(fn() => ['style' => 'width: 24px; height: 24px'])
                ->tooltip(fn($state) => ($state instanceof Collection ? $state : collect([$state]))->map(fn($user) => $user->name)->implode(', '));
        }
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
