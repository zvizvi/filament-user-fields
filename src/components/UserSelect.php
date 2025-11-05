<?php

namespace Zvizvi\UserFields\Components;

use Filament\Forms\Components\Select;

class UserSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->getOptionLabelFromRecordUsing(fn ($record) => view('user-avatar-option', ['user' => $record])->render())
            ->allowHtml();
    }
}
