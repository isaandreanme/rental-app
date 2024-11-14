<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
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
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-minus';
    protected static ?string $navigationGroup = 'Business Management';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        DatePicker::make('date_expense')->label('Date')->required()->columnSpanFull()->translateLabel(),
                        Select::make('vehicle_id')
                            ->relationship('vehicle', 'vehicle_name')
                            ->label('Vehicle')->translateLabel(),
                        Select::make('driver_id')
                            ->relationship('driver', 'first_name')
                            ->label('Driver')->translateLabel(),
                        Select::make('type_date_expense')
                            ->options([
                                'Fuel' => 'Fuel',
                                'Maintenance' => 'Maintenance',
                                'Repairs' => 'Repairs',
                                'Insurance' => 'Insurance',
                                'Parking Fees' => 'Parking Fees',
                                'Toll Fees' => 'Toll Fees',
                                'Cleaning' => 'Cleaning',
                                'Marketing' => 'Marketing',
                            ])
                            ->label('Type')->translateLabel(),
                        TextInput::make('total_amount')->numeric()->label('Total Amount')->translateLabel(),
                        FileUpload::make('receipt')->label('Receipt')->columnSpanFull()->translateLabel(),
                        Textarea::make('notes')->label('Notes')->columnSpanFull()->translateLabel(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.vehicle_name')
                    ->label('Vehicle')->translateLabel(),
                TextColumn::make('driver.first_name')
                    ->label('Driver')->translateLabel(),
                TextColumn::make('date_expense')->label('Date')->translateLabel(),
                TextColumn::make('total_amount')->numeric()->label('Total Amount')->translateLabel(),
                SelectColumn::make('type_date_expense')
                    ->options([
                        'Fuel' => 'Fuel',
                        'Maintenance' => 'Maintenance',
                        'Repairs' => 'Repairs',
                        'Insurance' => 'Insurance',
                        'Parking Fees' => 'Parking Fees',
                        'Toll Fees' => 'Toll Fees',
                        'Cleaning' => 'Cleaning',
                        'Marketing' => 'Marketing',
                    ])
                    ->label('Type')->translateLabel(),
                TextColumn::make('notes')->label('Notes')->translateLabel(),
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
            'index' => Pages\ListExpenses::route('/'),
            // 'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
