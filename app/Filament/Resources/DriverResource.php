<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
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

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Business Management';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make(2)
                ->schema([
                    TextInput::make('first_name')->required()->label('First Name'),
                    TextInput::make('last_name')->label('Last Name'),
                    TextInput::make('email')->email()->label('Email'),
                    TextInput::make('phone_number')->tel()->label('Phone Number'),
                    Select::make('gender')->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ])->label('Gender'),
                    TextInput::make('age')->numeric()->label('Age'),
                    DatePicker::make('birth_date')->label('Birth Date'),
                    TextInput::make('address')->label('Address'),
                    TextInput::make('license_number')->label('License / ID Number'),
                    DatePicker::make('issue_date')->label('Issue Date'),
                    DatePicker::make('expiration_date')->label('Expiration Date'),
                    TextInput::make('reference')->label('Reference'),
                    FileUpload::make('document')->label('Document'),
                    FileUpload::make('license')->label('License / ID'),
                    Textarea::make('notes')->label('Notes')->columnSpanFull(),
                ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')->label('First Name'),
                TextColumn::make('last_name')->label('Last Name'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('phone_number')->label('Phone Number'),
                TextColumn::make('gender')->label('Gender'),
                TextColumn::make('age')->label('Age'),
                TextColumn::make('birth_date')->label('Birth Date')->date(),
                TextColumn::make('license_number')->label('License Number'),
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
            'index' => Pages\ListDrivers::route('/'),
            // 'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
