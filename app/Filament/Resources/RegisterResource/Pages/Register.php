<?php

namespace App\Filament\Resources\RegisterResource\Pages;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;
use Illuminate\Support\Facades\Hash;

class Register extends Page
{
    protected static string $view = 'filament.resources.register-resource.pages.register';

    public $name;
    public $surname;
    public $country;
    public $affiliation;
    public $email;
    public $password;

    public static function isPublic(): bool
    {
        return true;
    }

    public static function getSlug(): string
    {
        return 'register';
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')->label('First Name')->required()->maxLength(255),
            TextInput::make('surname')->label('Surname')->required()->maxLength(255),
            Country::make('country')->required(),
            TextInput::make('affiliation')->label('Affiliation')->required()->maxLength(255),
            TextInput::make('email')->email()->label('Email')->required()->unique('users', 'email')->maxLength(255),
            TextInput::make('password')->password()->label('Password')->required()->minLength(8),
            Select::make('roles')
                ->multiple()
                ->relationship('roles', 'name') // This dropdown shows roles
                ->default([1]) // Replace "1" with the ID of the role you want to set by default
                ->required()
                ->hidden(),
        ];
    }



    public function submit()
    {
        $user = User::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'country' => $this->country,
            'affiliation' => $this->affiliation,
            'email' => $this->email,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $user->roles()->sync([1]);
        session()->flash('success', 'Registration successful. You can now log in.');
        return redirect('admin/login');
    }
}
