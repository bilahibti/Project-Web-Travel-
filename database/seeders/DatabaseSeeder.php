<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota; 
use App\Models\User; 
use App\Models\Destinasi;
use App\Models\Hotel;
use App\Models\Transportasi;
use App\Models\Paket;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $adminRole = Role::where('slug', 'admin')->firstOrFail();
        $staffRole = Role::where('slug', 'staff')->firstOrFail();
        $customerRole = Role::where('slug', 'customer')->firstOrFail();
        $financeRole = Role::where('slug', 'finance')->firstOrFail();

        User::create([ 
            'nama' => 'Administrator', 
            'email' => 'admin@gmail.com',  
            'role_id' => $adminRole?->id,
            'hp' => '0812345678901', 
            'password' => bcrypt('P@55word'), 
        ]); 

        User::create([ 
            'nama' => 'Sopian Aji', 
            'email' => 'sopian4ji@gmail.com',  
            'role_id' => $staffRole?->id,
            'hp' => '081234567892', 
            'password' => bcrypt('P@55word'), 
        ]); 
        
        User::create([ 
            'nama' => 'Karina Adya', 
            'email' => 'adyarin@gmail.com',   
            'role_id' => $adminRole?->id,
            'hp' => '085678916598', 
            'password' => bcrypt('K@rin4'), 
        ]); 

        User::create([ 
            'nama' => 'Aditya Rayhan Pratama', 
            'email' => 'pratamayhan@gmail.com',   
            'role_id' => $customerRole?->id,
            'hp' => '089873456120', 
            'password' => bcrypt('Rayh4ntam@'), 
        ]); 

        User::create([ 
            'nama' => 'Naufal Aksa Pranaya', 
            'email' => 'aksanaya@gmail.com',  
            'role_id' => $financeRole?->id,
            'hp' => '087856432690', 
            'password' => bcrypt('Pranayaksa5^'), 
        ]); 

        
    }
}
