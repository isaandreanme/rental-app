<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'phone_number' => '1234567890',
                'gender' => 'Male',
                'age' => 30,
                'birth_date' => '1993-01-01',
                'address' => '123 Main St',
                'license_number' => 'L123456789',
                'issue_date' => '2022-01-01',
                'expiration_date' => '2025-01-01',
                'document' => 'document123.pdf',
                'license' => 'license123.pdf',
                'reference' => 'Ref123',
                'notes' => 'This is a sample note.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'janesmith@example.com',
                'phone_number' => '0987654321',
                'gender' => 'Female',
                'age' => 25,
                'birth_date' => '1998-02-15',
                'address' => '456 Elm St',
                'license_number' => 'L987654321',
                'issue_date' => '2023-02-15',
                'expiration_date' => '2026-02-15',
                'document' => 'document456.pdf',
                'license' => 'license456.pdf',
                'reference' => 'Ref456',
                'notes' => 'This is another sample note.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('customers')->insert($data);
    }
}
