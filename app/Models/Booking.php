<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'customer_id',
        'vehicle_id',
        'driver_id',
        'rental_start_date',
        'rental_end_date',
        'rental_duration',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function rentalAgreement()
    {
        return $this->belongsTo(RentalAgreement::class);
    }

    // Pastikan metode ini didefinisikan statis
    public static function isVehicleAvailable($vehicleId, $startDate, $endDate)
    {
        return !self::where('vehicle_id', $vehicleId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('rental_start_date', [$startDate, $endDate])
                    ->orWhereBetween('rental_end_date', [$startDate, $endDate]);
            })
            ->exists();
    }

    // Pastikan metode ini didefinisikan statis
    public static function isDriverAvailable($driverId, $startDate, $endDate)
    {
        return !self::where('driver_id', $driverId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('rental_start_date', [$startDate, $endDate])
                    ->orWhereBetween('rental_end_date', [$startDate, $endDate]);
            })
            ->exists();
    }

    // Set rental_duration secara otomatis saat menyimpan data
    public function setRentalDurationAttribute($value)
    {
        if ($this->attributes['rental_start_date'] && $this->attributes['rental_end_date']) {
            $start = Carbon::parse($this->attributes['rental_start_date']);
            $end = Carbon::parse($this->attributes['rental_end_date']);
            $this->attributes['rental_duration'] = $start->diffInDays($end); // Menghitung rental_duration
        }
    }

    // Getter untuk rental_duration
    public function getRentalDurationAttribute($value)
    {
        return $value . ' days';
    }

    public static function boot()
    {
        parent::boot();

        // Validasi saat membuat booking baru
        static::creating(function ($booking) {
            if (!self::isVehicleAvailable($booking->vehicle_id, $booking->rental_start_date, $booking->rental_end_date)) {
                throw new \Exception("The selected vehicle is not available for the chosen dates.");
            }

            if (!self::isDriverAvailable($booking->driver_id, $booking->rental_start_date, $booking->rental_end_date)) {
                throw new \Exception("The selected driver is not available for the chosen dates.");
            }
        });

        // Validasi saat memperbarui booking
        static::updating(function ($booking) {
            if (!self::isVehicleAvailable($booking->vehicle_id, $booking->rental_start_date, $booking->rental_end_date)) {
                throw new \Exception("The selected vehicle is not available for the chosen dates.");
            }

            if (!self::isDriverAvailable($booking->driver_id, $booking->rental_start_date, $booking->rental_end_date)) {
                throw new \Exception("The selected driver is not available for the chosen dates.");
            }
        });

        // Menyimpan rental_duration sebelum menyimpan booking
        static::saving(function ($booking) {
            // Pastikan rental_start_date dan rental_end_date ada dan valid
            if ($booking->rental_start_date && $booking->rental_end_date) {
                $start = Carbon::parse($booking->rental_start_date);
                $end = Carbon::parse($booking->rental_end_date);
                $booking->rental_duration = $start->diffInDays($end); // Menghitung rental_duration
            }
        });
    }
}
