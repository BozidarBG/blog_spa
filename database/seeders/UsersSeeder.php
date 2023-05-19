<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run()
    {
        $names=['LeBron James', 'Nikola Jokic','Domantas Sabonis', 'Rudy Gobert', 'Mikael Bridges', 'Franz Wagner', 'DeMar DeRozan', 'Breadley Beal', 'Luka Doncic', 'James Harden', 'Jrue Holiday', 'Anthony Davis', 'Joel Embiid',  'Donovan Mitchell', 'Bogdan Bogdanovic', 'Kawhi Leonard', 'Paul George', 'Stephen Curry', 'Marcus Smart', 'Jeff Green', 'Kevin Durant', 'Adin Vrabac', 'Zion Williamson', 'Klay Thompson', 'Jason Tatum', 'Trae Young', 'Jamal Murray', 'Tyler Herro', 'Jimmy Butler', 'Russell Westbrook', 'Ja Morant', 'Aaron Gordon'];

        for($i=0; $i<count($names); $i++){
            $user=new User();
            $user->name = $names[$i];

            $name_arr=explode(' ', $names[$i]);
            $user->email=strtolower($name_arr[1]).'@gmail.com';
            $user->password=Hash::make('Ii123456/');
            if($i===0){
                $user->role=1;
            }elseif ($i >=1 && $i<=5){
                $user->role=2;
            }
            $user->save();
        }
    }
}
