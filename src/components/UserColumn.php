<?php

namespace Zvizvi\UserFields\Components;

use Filament\Tables\Columns\TextColumn;

class UserColumn extends TextColumn
{
    protected bool $isWrapped = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->html()
            ->listWithLineBreaks()
            ->extraAttributes(['class' => 'flex flex-wrap gap-2'])
            ->formatStateUsing(fn($state) => view('user-avatar-option', ['user' => $state])->render());
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
            'class' => 'flex flex-wrap gap-y-1 gap-x-2' . ($this->isWrapped ? ' flex-col' : ''),
        ]);
    }
}
