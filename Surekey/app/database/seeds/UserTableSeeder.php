<?php
class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->insert(
 
            array(
                array(
                    'id' => 1,
                    'username' => 'admin',
                    'password' => Hash::make('admin'),
                    'email' => 'admin@exemple.fr',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ), 
                array(
                    'id' => 2,
                    'username' => 'Martin',
                    'password' => Hash::make('martin'),
                    'email' => 'martin@exemple.fr',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ),
                array(
                    'id' => 3,
                    'username' => 'Lefevre',
                    'password' => Hash::make('lefevre'),
                    'email' => 'lefevre@exemple.fr',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ), 
                array(
                    'id' => 4,
                    'username' => 'Dupond',
                    'password' => Hash::make('dupond'),
                    'email' => 'dupond@exemple.fr',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                )
            )
        );
    }
}