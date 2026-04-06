<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'name' => 'Astri Wijaya',
                'member_code' => 'MBR-001',
                'email' => 'astri.wijaya@example.com',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 12, Bandung',
                'status' => 'active',
                'joined_at' => '2025-08-10',
            ],
            [
                'name' => 'Bimo Santoso',
                'member_code' => 'MBR-002',
                'email' => 'bimo.santoso@example.com',
                'phone' => '081298765432',
                'address' => 'Jl. Cendrawasih No. 45, Jakarta',
                'status' => 'inactive',
                'joined_at' => '2024-12-01',
            ],
            [
                'name' => 'Citra Dewi',
                'member_code' => 'MBR-003',
                'email' => 'citra.dewi@example.com',
                'phone' => '081310111222',
                'address' => 'Jl. Melati No. 7, Surabaya',
                'status' => 'suspended',
                'joined_at' => '2025-01-15',
            ],
            [
                'name' => 'Dedi Prasetyo',
                'member_code' => 'MBR-004',
                'email' => 'dedi.prasetyo@example.com',
                'phone' => '081322334455',
                'address' => 'Jl. Pahlawan No. 21, Yogyakarta',
                'status' => 'inactive',
                'joined_at' => '2025-03-20',
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate([
                'member_code' => $member['member_code'],
            ], $member);
        }
    }
}
