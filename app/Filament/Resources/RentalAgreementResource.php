<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalAgreementResource\Pages;
use App\Filament\Resources\RentalAgreementResource\RelationManagers;
use App\Models\RentalAgreement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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

class RentalAgreementResource extends Resource
{
    protected static ?string $model = RentalAgreement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Business Management';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'first_name')
                            ->label('Customer')
                            ->required()->translateLabel(),
                        Select::make('driver_id')
                            ->relationship('driver', 'first_name')
                            ->label('Driver')->translateLabel(),
                        Select::make('vehicle_id')
                            ->relationship('vehicle', 'vehicle_name')
                            ->label('Vehicle')
                            ->required()->translateLabel(),
                        TextInput::make('rental_duration')->numeric()->label('Rental Duration (Days)')->translateLabel(),
                        DatePicker::make('rental_start_date')->label('Rental Start Date')->required()->translateLabel(),
                        DatePicker::make('rental_end_date')->label('Rental End Date')->translateLabel(),
                        Select::make('status')
                            ->options([
                                'Draft' => 'Draft',
                                'Active' => 'Active',
                                'Completed' => 'Completed',
                                'Cancelled' => 'Cancelled',
                            ])
                            ->default('Draft')
                            ->label('Status')->translateLabel(),
                        TextInput::make('terms_condition')->label('Number Terms & Condition')->translateLabel(),
                        Textarea::make('description')->label('Description')->columnSpanFull()->translateLabel(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.first_name')->label('Customer')->translateLabel(),
                TextColumn::make('driver.first_name')->label('Driver')->translateLabel(),
                TextColumn::make('vehicle.vehicle_name')->label('Vehicle')->translateLabel(),
                TextColumn::make('rental_start_date')->label('Rental Start Date')->translateLabel(),
                TextColumn::make('rental_end_date')->label('Rental End Date')->translateLabel(),
                TextColumn::make('rental_duration')->label('Rental Duration (Days)')->translateLabel(),
                TextColumn::make('status')
                    ->label('Status')->badge()->translateLabel(),
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
            'index' => Pages\ListRentalAgreements::route('/'),
            // 'create' => Pages\CreateRentalAgreement::route('/create'),
            'edit' => Pages\EditRentalAgreement::route('/{record}/edit'),
        ];
    }
}
