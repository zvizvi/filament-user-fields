<?php

namespace Zvizvi\UserFields\Tests\Fixtures\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Zvizvi\UserFields\Components\UserColumn;
use Zvizvi\UserFields\Tests\Fixtures\Models\Post;

class PostsTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query())
            ->columns([
                TextColumn::make('title'),

                // The documented, fixed form: dot notation enables native
                // search / sort while the avatar still resolves per row.
                UserColumn::make('author.name')
                    ->searchable()
                    ->sortable(),

                // The relationship-model form: state is the related User itself.
                UserColumn::make('author'),
            ]);
    }

    public function render(): string
    {
        return <<<'HTML'
        <div>{{ $this->table }}</div>
        HTML;
    }
}
