<?php

namespace Zvizvi\UserFields\Components;

use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;

class UserSelectFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->getOptionLabelFromRecordUsing(fn ($record) => view('user-fields::user-avatar-option', ['user' => $record])->render())
            ->modifyFormFieldUsing(fn (Select $select) => $select->allowHtml());
    }
}
