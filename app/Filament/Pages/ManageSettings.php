<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationLabel = 'Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::get('site_name', ''),
            'tagline' => Setting::get('tagline', ''),
            'logo_url' => Setting::get('logo_url', ''),
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_twitter' => Setting::get('social_twitter', ''),
            'social_instagram' => Setting::get('social_instagram', ''),
            'contact_email' => Setting::get('contact_email', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Site identity')
                    ->schema([
                        Forms\Components\TextInput::make('site_name'),
                        Forms\Components\TextInput::make('tagline'),
                        Forms\Components\TextInput::make('logo_url')
                            ->label('Logo URL'),
                    ]),

                Forms\Components\Section::make('Social links')
                    ->schema([
                        Forms\Components\TextInput::make('social_facebook')->label('Facebook URL'),
                        Forms\Components\TextInput::make('social_twitter')->label('Twitter / X URL'),
                        Forms\Components\TextInput::make('social_instagram')->label('Instagram URL'),
                    ]),

                Forms\Components\Section::make('Contact')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')->email(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
