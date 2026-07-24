<?php

namespace Zvizvi\UserFields\Tests\Fixtures\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Concerns\ResolvesDynamicLivewireProperties;
use Filament\Schemas\Schema;
use Livewire\Component;
use Zvizvi\UserFields\Components\UserSelect;
use Zvizvi\UserFields\Tests\Fixtures\Models\Post;

class PostForm extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use ResolvesDynamicLivewireProperties;

    public Post $record;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(Post $record): void
    {
        $this->record = $record;
        $this->form->fill($record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->model($this->record)
            ->statePath('data')
            ->components([
                UserSelect::make('author_id')
                    ->relationship('author', 'name')
                    ->preload()
                    ->searchable(),
            ]);
    }

    public function render(): string
    {
        return <<<'HTML'
        <div>{{ $this->form }}</div>
        HTML;
    }
}
