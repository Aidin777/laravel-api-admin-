<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Duel;
use App\Models\DuelContestant;
use App\Models\DuelQuestion;
use App\Models\Question;
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
        // User::factory(2)->create();

        // Duel::create([
        //     'id' => 1,
        //     'status' => 'pending',
        // ]);
        // DuelContestant::create([
        //     'id' => 1,
        //     'user_id' => 1,
        //     'scoreboard' => '[{"1": 1, "2": 0, "3": 1}]',
        //     'nominal_score' => 0,
        //     'duel_id' => 1,
        // ]);
        // DuelContestant::create([
        //     'id' => 2,
        //     'user_id' => 2,
        //     'scoreboard' => '[{"1": 1, "2": 0, "3": 1}]',
        //     'nominal_score' => 0,
        //     'duel_id' => 1,
        // ]);
        // Question::factory(15)->create();
        // DuelQuestion::factory(7)->create();
        User::create(['name' => 'admin','phone'=> 89999996655, 'email' => 'admin@admin.ru', 'password' => Hash::make(123456789), 'role' => 0]);
    }
}
