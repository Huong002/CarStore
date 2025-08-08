<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::insert([
            [
                'name' => 'Trần Phước Hưỡng',
                'adress' => 'TP. HCM',
                'phone' => '0372587759',
                'email' => 'psymint002@gmail.com',
                'birthDay' => '2000-05-05',
                'hire_date' => '2020-01-01'
            ],
            [
                'name' => 'Lê Minh Cường',
                'adress' => 'Đà Nẵng',
                'phone' => '0911222333',
                'email' => 'employee2@example.com',
                'birthDay' => '1985-05-05',
                'hire_date' => '2020-01-01'
            ]
        ]);
    }
}
