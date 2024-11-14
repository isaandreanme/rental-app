<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
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

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationGroup = 'Business Management';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('vehicle_name')->required()->label('Vehicle Name')->translateLabel(),
                        Select::make('type')->options([
                            'City Car' => 'City Car',
                            'Sedan' => 'Sedan',
                            'Minibus' => 'Minibus',
                            'Mediumbus' => 'Mediumbus',
                            'Vip' => 'Vip',

                        ])->label('Type')->translateLabel(),
                        TextInput::make('model')->label('Model')->translateLabel(),
                        TextInput::make('engine_type')->label('Engine Type')->translateLabel(),
                        TextInput::make('engine_number')->label('Engine Number')->translateLabel(),
                        TextInput::make('license_plate')->label('License Plate')->translateLabel(),
                        DatePicker::make('registration_expiry_date')->label('Registration Expiry Date')->translateLabel(),
                        TextInput::make('year_of_first_immatriculation')->numeric()->label('Year Of First Immatriculation')->translateLabel(),
                        Select::make('fuel_type')
                            ->options([
                                'Petrol' => 'Petrol',
                                'Diesel' => 'Diesel',
                            ])
                            ->label('Fuel Type')->translateLabel(),
                        TextInput::make('kilometer')->numeric()->label('Kilometer')->translateLabel(),
                        TextInput::make('daily_rate')->numeric()->label('Daily Rate')->translateLabel(),
                        Select::make('gearbox')->options([
                            'Automatic' => 'Automatic',
                            'Manual' => 'Manual',
                        ])->default('Automatic')->label('Gearbox')->translateLabel(),
                        Select::make('number_of_seats')
                            ->options([
                                '4' => '4',
                                '7' => '7',
                                '8' => '8',
                                '12' => '12',
                                '15' => '15',
                            ])
                            ->label('Number Of Seats')->translateLabel(),
                        TextInput::make('options')->label('Options')->translateLabel(),
                        FileUpload::make('document')->label('Document')->columnSpanFull()->translateLabel(),
                        Textarea::make('notes')->label('Notes')->columnSpanFull()->translateLabel(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle_name')->label('Vehicle Name')->translateLabel(),
                TextColumn::make('type')->label('Type')->translateLabel(),
                TextColumn::make('model')->label('Model')->translateLabel(),
                TextColumn::make('license_plate')->label('License Plate')->translateLabel(),
                TextColumn::make('daily_rate')->label('Daily Rate')->translateLabel(),
                TextColumn::make('gearbox')->label('Gearbox')->translateLabel(),
                TextColumn::make('fuel_type')->label('Fuel Type')->translateLabel(),
                TextColumn::make('kilometer')->label('Kilometer')->translateLabel(),
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
            'index' => Pages\ListVehicles::route('/'),
            // 'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
