<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Business Management';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('first_name')->required()->label('First Name')->translateLabel(),
                        TextInput::make('last_name')->label('Last Name')->translateLabel(),
                        TextInput::make('email')->email()->label('Email')->translateLabel(),
                        TextInput::make('phone_number')->tel()->label('Phone Number')->translateLabel(),
                        Select::make('gender')->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                            'Other' => 'Other',
                        ])->label('Gender')->translateLabel(),
                        TextInput::make('age')->numeric()->label('Age')->translateLabel(),
                        DatePicker::make('birth_date')->label('Birth Date')->translateLabel(),
                        TextInput::make('address')->label('Address')->translateLabel(),
                        TextInput::make('license_number')->label('License / ID Number')->translateLabel(),
                        DatePicker::make('issue_date')->label('Issue Date')->translateLabel(),
                        DatePicker::make('expiration_date')->label('Expiration Date')->translateLabel(),
                        TextInput::make('reference')->label('Reference')->translateLabel(),
                        FileUpload::make('document')->label('Document')->translateLabel(),
                        FileUpload::make('license')->label('License / ID')->translateLabel(),
                        Textarea::make('notes')->label('Notes')->columnSpanFull()->translateLabel(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->label('First Name')->translateLabel(),
                TextColumn::make('last_name')->label('Last Name')->translateLabel(),
                TextColumn::make('email')->label('Email')->translateLabel(),
                TextColumn::make('phone_number')->label('Phone Number')->translateLabel(),
                TextColumn::make('gender')->label('Gender')->translateLabel(),
                TextColumn::make('age')->label('Age')->translateLabel(),
                TextColumn::make('birth_date')->label('Birth Date')->date()->translateLabel(),
                TextColumn::make('license_number')->label('License / ID Number')->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
