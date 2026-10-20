<?php

namespace Database\Seeders;

use App\Models\PackageStat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Core Administrators for ArtisanCraft
        User::firstOrCreate(
            ['username' => 'pantakarn'],
            [
                'name' => 'Pantakarn Manjan',
                'email' => 'pantakarn@buu.ac.th',
                'role' => 'admin',
                'active' => 'Y',
                'password' => Hash::make('password'),
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'request_uri' => 'artisan:migrate:refresh',
            ]
        );

        User::firstOrCreate(
            ['username' => 'lead.architect'],
            [
                'name' => 'กฤษฎา ว่องวิทย์ (Krisada V.)',
                'email' => 'lead.architect@artisan.io',
                'role' => 'admin',
                'active' => 'Y',
                'password' => Hash::make('password'),
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'request_uri' => 'artisan:migrate:refresh',
            ]
        );

        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@buu.ac.th',
                'role' => 'admin',
                'active' => 'Y',
                'password' => Hash::make('password'),
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'request_uri' => 'artisan:migrate:refresh',
            ]
        );

        // 2. Seed Package Stats from Configuration
        $packages = config('generator.packages', []);
        foreach ($packages as $name => $cfg) {
            PackageStat::firstOrCreate(
                ['package_name' => $name],
                [
                    'source' => $cfg['source'] ?? 'composer',
                    'category' => $cfg['category'] ?? 'devtools',
                    'stars' => (int) ($cfg['fallback_stars'] ?? 0),
                    'downloads_monthly' => 0,
                    'downloads_total' => 0,
                    'latest_version' => null,
                    'sync_status' => 'fallback',
                    'created_by' => 'seeder',
                    'updated_by' => 'seeder',
                    'request_uri' => 'artisan:migrate:refresh',
                ]
            );
        }
    }
}
