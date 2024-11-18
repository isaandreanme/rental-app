<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Vehicle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        TextInput::make('booking_number')
                            ->required()
                            ->prefix('BO')
                            ->label('Booking Number')
                            ->translateLabel(),
                        Select::make('customer_id')
                            ->relationship('customer', 'first_name')
                            ->label('Customer')
                            ->required()
                            ->translateLabel(),
                        DatePicker::make('rental_start_date')
                            ->label('Rental Start Date')
                            ->translateLabel()
                            ->required()
                            ->reactive()
                            ->default(now()) // Pastikan ada default jika data kosong
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $endDate = $get('rental_end_date');
                                if ($state && $endDate) {
                                    $start = Carbon::parse($state);
                                    $end = Carbon::parse($endDate);
                                    $set('rental_duration', $start->diffInDays($end)); // Menghitung rental_duration
                                }
                            }),
                        DatePicker::make('rental_end_date')
                            ->label('Rental End Date')
                            ->translateLabel()
                            ->required()
                            ->reactive()
                            ->default(now()) // Pastikan ada default jika data kosong
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $startDate = $get('rental_start_date');
                                if ($state && $startDate) {
                                    $start = Carbon::parse($startDate);
                                    $end = Carbon::parse($state);
                                    $set('rental_duration', $start->diffInDays($end)); // Menghitung rental_duration
                                }
                            }),
                        Grid::make(3)
                            ->schema([
                                Select::make('vehicle_id')
                                    ->translateLabel()
                                    ->label('Vehicle')
                                    ->required()
                                    ->reactive()
                                    // ->getOptionLabelFromRecordUsing(fn(Vehicle $record) => "{$record->vehicle_name} - (Rp " . number_format($record->daily_rate, 0, ',', '.') . ") Day")
                                    ->options(function (callable $get) {
                                        $startDate = $get('rental_start_date');
                                        $endDate = $get('rental_end_date');

                                        // Check if both start and end dates are set
                                        if ($startDate && $endDate) {
                                            // Filter vehicles that are not booked within the date range
                                            return \App\Models\Vehicle::whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                                                $query->whereBetween('rental_start_date', [$startDate, $endDate])
                                                    ->orWhereBetween('rental_end_date', [$startDate, $endDate]);
                                            })
                                                // Select both vehicle name and id, using the vehicle id as the key and a formatted string for the option label
                                                ->get()
                                                ->mapWithKeys(function ($vehicle) {
                                                    return [
                                                        $vehicle->id => "{$vehicle->vehicle_name} - (Rp " . number_format($vehicle->daily_rate, 0, ',', '.') . ") /Day"
                                                    ];
                                                });
                                        }

                                        // If no dates are set, show all vehicles
                                        return \App\Models\Vehicle::pluck('vehicle_name', 'id');
                                    }),

                                Select::make('driver_id')
                                    ->label('Driver')
                                    ->translateLabel()
                                    ->required()
                                    ->reactive()
                                    ->options(function (callable $get) {
                                        $startDate = $get('rental_start_date');
                                        $endDate = $get('rental_end_date');
                                        if ($startDate && $endDate) {
                                            return \App\Models\Driver::whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                                                $query->whereBetween('rental_start_date', [$startDate, $endDate])
                                                    ->orWhereBetween('rental_end_date', [$startDate, $endDate]);
                                            })->pluck('first_name', 'id');
                                        }
                                        return \App\Models\Driver::pluck('first_name', 'id');
                                    }),
                                TextInput::make('rental_duration')
                                    ->numeric()
                                    ->disabled()
                                    ->translateLabel()
                                    ->label('Rental Duration (Days)'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_number')
                    ->label('Booking Number')
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('customer.first_name')
                    ->label('Customer')
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('rental_start_date')
                    ->label('Rental Start Date')
                    ->date()
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('rental_end_date')
                    ->label('Rental End Date')
                    ->date()
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('rental_duration')
                    ->label('Rental Duration (Days)')
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('vehicle.vehicle_name')
                    ->label('Vehicle')
                    ->sortable()
                    ->translateLabel(),
                TextColumn::make('driver.first_name')
                    ->label('Driver')
                    ->sortable()
                    ->translateLabel(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
    // Event before save to ensure rental_duration is saved
    public static function beforeSave(array $data): array
    {
        if (isset($data['rental_start_date']) && isset($data['rental_end_date'])) {
            $start = Carbon::parse($data['rental_start_date']);
            $end = Carbon::parse($data['rental_end_date']);
            $data['rental_duration'] = $start->diffInDays($end); // Menghitung rental_duration
        }

        return $data;
    }
}
