<?php

namespace Zvizvi\UserFields\Components;

use Filament\Infolists\Components\TextEntry;

class UserEntry extends TextEntry
{
    protected bool $isWrapped = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->formatStateUsing(fn($state) => view('user-avatar-option', ['user' => $state])->render())
            ->listWithLineBreaks()
            ->html();
    }

    public function wrapped(bool $isWrapped = true): static
    {
        $this->isWrapped = $isWrapped;

        return $this;
    }

    protected function getWrapped(): bool
    {
        return $this->isWrapped;
    }

    public function getExtraAttributes(): array
    {
        return array_merge(parent::getExtraAttributes(), [
            'class' => 'flex flex-wrap gap-2' . ($this->isWrapped ? ' flex-col' : ''),
        ]);
    }
}
