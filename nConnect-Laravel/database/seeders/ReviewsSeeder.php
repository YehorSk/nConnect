<?php

namespace Database\Seeders;

use App\Models\Conference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewsSeeder extends Seeder
{
    public function run(){

        $conference = Conference::find(1);
        $review = [
            [
                'name'=>'DÁVID DRŽÍK - DOKTORAND FPVAI UKF',
                'text'=>'Oceňujem, že vzniká nová iniciativá spojiť časť akademickej obce v podobe študentov a súkromný sektor v našom regióne',
                'photo'=>'images\reviews\1.jpg'
            ],
            [
                'name'=>'RICHARD KRUPIČKA - HEAD OF RECRUITMENT V SYNCULARIO',
                'text'=>'Je vždy dobré, keď sa aktivizuje IT komunita aj v oblastaich mimo Bratislavi.',
                'photo'=>'images\reviews\2.jpg'
            ],
            [
                'name'=>'DÁVID FRŤALA - SENIOR FULL STACK ENGINEER',
                'text'=>'Som veľmi rád, že vidím prvé náznaky kreovania aktívnej IT komunity zameranej nie len na B2B formát.',
                'photo'=>'images\reviews\3.jpg'
            ],
            [
                'name'=>'MARTIN DRLÍK - PRODEKAN FPVAI UKF',
                'text'=>'Táto konferencia predstavuje vynikajúcu príležitosť pre našich študentov, aby sa nielen zoznámili s najnovšími trendmi v oblasti informatiky, ale aj naviazali cenné kontakty s profesionálmi z praxe.',
                'photo'=>'images\reviews\4.jpg'
            ],

        ];
        foreach ($review as $reviewData) {
            $review = new Review();
            $review ->name=$reviewData['name'];
            $review ->text=$reviewData['text'];
            $review ->photo=$reviewData['photo'];
            $review->conference()->associate($conference);
            $review->save();
        }
    }
}
