<?php

namespace Zvizvi\UserFields\Tests\Fixtures\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Zvizvi\UserFields\Components\UserColumn;
use Zvizvi\UserFields\Tests\Fixtures\Models\User;

class UsersTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                // On the users table itself the record IS the user.
                UserColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ]);
    }

    public function render(): string
    {
        return <<<'HTML'
        <div>{{ $this->table }}</div>
        HTML;
    }
}
