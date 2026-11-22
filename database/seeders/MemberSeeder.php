<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::firstOrCreate(
            ['member_code' => 'MBR-001'],
            ['name' => 'Amaa']
        );

        Member::firstOrCreate(
            ['member_code' => 'MBR-002'],
            ['name' => 'Amii']
        );

        Member::firstOrCreate(
            ['member_code' => 'MBR-002'],
            ['name' => 'Taehyung']
        );
    }
}