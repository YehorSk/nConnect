<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\Speaker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeakersSeeder extends Seeder
{
    public function run(){
        $speakers =[
            [
                'first_name'=>'DALIBOR',
                'last_name'=>'CICMAN',
                'picture'=>'images\speakers\Gymbeam.jpg',
                'short_desc'=>'Zakladateľ a CEO GymBeam, od roku 2014 transformoval trh so športovou výživou na e-commerce platformu pôsobiacu v 16 krajinách s ročnými tržbami presahujúcimi 100 miliónov Eur.',
                'long_desc'=>'Ako nositeľ ocenení Forbes "30 pod 30" a YT Podnikateľ roka 2024, Dalibor presadzuje význam dátovo riadeného prístupu, inovačnej kultúry a tímovej spolupráce pri budovaní značky.',
                'Company'=>'GymBeam',
                'Instagram'=>'https://www.instagram.com/daliborcicman/',
                'LinkedIn'=>'https://www.linkedin.com/in/dalibor-cicman/',
                'Facebook'=>'https://www.facebook.com/dalibor.cicman/',
                'Twitter'=>'https://twitter.com/DaliborCicman',

            ],
            [
                'first_name'=>'LUKÁŠ',
                'last_name'=>'KOZELNICKÝ',
                'picture'=>'images\speakers\muziker.jpg',
                'short_desc'=>'Lukáš pôsobí v Muzikeri od začiatku roku 2022 a teda od začiatku budovania nového dátového skladu. Deväť rokov sa venoval sieťam a DevOps a od roku 2020 sa viac venuje dátovej vede.',
                'long_desc'=>' Má skúsenosti s technológiami ako Python, Airflow, DBT či ClickHouse.',
                'Company'=>'Muziker',
                'Instagram'=>'https://www.instagram.com/muziker.shop/',
                'LinkedIn'=>'',
                'Facebook'=>'https://www.facebook.com/muziker.sk/',
                'Twitter'=>'https://twitter.com/muziker_sk',

            ],
            [
                'first_name'=>'PETER',
                'last_name'=>'PŠENÁK',
                'picture'=>'images\speakers\PPS.jpg',
                'short_desc'=>'Som programátor so záľubou v JavaScripte a jeho typovo stabilnejšom "mladšom bratovi" TypeScripte. Rád sa zahrám aj s inými jazykmi vrátane Pythonu, R-ka a PHP-čka. Počas mojej niekoľkoročnej kariéry som pôsobil už v spoločnostiach ako Nay alebo PwC.',
                'long_desc'=>'Aktuálne pôsobím ako technický riaditeľ spoločnosti Powerplay Studio, kde spríjemňujem život mojich programátorských kolegov mojimi "jednoduchými" zadaniami. Vo voľnom čase... programujem.',
                'Company'=>'PowerPlay Studio',
                'Instagram'=>'https://www.instagram.com/powerplay_studio_pps/',
                'LinkedIn'=>'https://www.linkedin.com/in/peter-p%C5%A1en%C3%A1k-3bb441159/?originalSubdomain=sk',
                'Facebook'=>'https://www.facebook.com/PowerPlayStudioSK/',
                'Twitter'=>'',

            ],
            [
                'first_name'=>'PATRIK',
                'last_name'=>'MALÝ',
                'picture'=>'images\speakers\uniqua.jpg',
                'short_desc'=>'Softvérový inžinier s viac ako desaťročnou praxou v oblasti moderného vývoja softvéru v ekosystéme Javy, ktorý sa vyznačuje nielen hlbokými technickými znalosťami, ale aj schopnosťou viesť a inšpirovať tím vývojárov.',
                'long_desc'=>'Aktuálne zastáva pozíciu vedúceho skupiny vývojárov v spoločnosti UNIQA GSC Slovensko, kde je zodpovedný za riadenie tímu, strategické plánovanie projektov a implementáciu nových technologických riešení.',
                'Company'=>'UNIQA GSC Slovensko',
                'Instagram'=>'https://www.instagram.com/uniqa_sk/',
                'LinkedIn'=>'https://www.linkedin.com/in/patrik-mal%C3%BD-69502b10a/?originalSubdomain=sk',
                'Facebook'=>'https://www.facebook.com/UNIQASlovensko/',
                'Twitter'=>'',

            ],

        ];
        foreach ($speakers as $speakerData) {
            $speaker = new Speaker();
            $speaker->first_name = $speakerData['first_name'];
            $speaker->last_name = $speakerData['last_name'];
            $speaker->picture = $speakerData['picture'];
            $speaker->short_desc = $speakerData['short_desc'];
            $speaker->long_desc = $speakerData['long_desc'];
            $speaker->company = $speakerData['Company'];
            $speaker->instagram = $speakerData['Instagram'];
            $speaker->linkedin = $speakerData['LinkedIn'];
            $speaker->facebook = $speakerData['Facebook'];
            $speaker->twitter = $speakerData['Twitter'];
            $speaker->save();
            $conference = Conference::find(1);
            $conference->speakers()->attach($speaker);
        }

    }


}
