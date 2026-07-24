<?php

namespace Zvizvi\UserFields\Tests\Fixtures\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Concerns\ResolvesDynamicLivewireProperties;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;
use Zvizvi\UserFields\Components\UserEntry;
use Zvizvi\UserFields\Components\UserStackedEntry;
use Zvizvi\UserFields\Tests\Fixtures\Models\Post;

class PostInfolist extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use ResolvesDynamicLivewireProperties;

    public Post $record;

    public function mount(Post $record): void
    {
        $this->record = $record;
    }

    public function postInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->record)
            ->components([
                UserEntry::make('author.name')
                    ->label('Author'),

                UserStackedEntry::make('author.name')
                    ->label('Author avatar'),
            ]);
    }

    public function render(): string
    {
        return <<<'HTML'
        <div>{{ $this->postInfolist }}</div>
        HTML;
    }
}
