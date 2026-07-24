<?php

namespace Zvizvi\UserFields\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use Zvizvi\UserFields\UserFieldsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin(UserFieldsPlugin::make());
    }
}
