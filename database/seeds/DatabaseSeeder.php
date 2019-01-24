<?php

use App\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(EventsTableSeeder::class);
        $role = Role::create(['name' => 'admin']);
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@falyat.com',
            'password' => bcrypt('admin123')
        ]);

        $user = User::where('email', 'admin@falyat.com')->first();
        $user->roles()->attach($role);
    }
}
