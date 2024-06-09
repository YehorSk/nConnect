<?php

namespace Database\Seeders;
use App\Models\Lecture;
use Illuminate\Database\Seeder;

class LectureSeeder extends Seeder
{
    public function run()
    {
        $lectures = [
            [
                'speaker_id' => null,
                'stage_id' => 1,
                'conference_id' => 1,
                'name' => 'Registracia',
                'short_desc' => 'Registrácia je prvým a zásadným krokom na každej konferencii. Táto sekcia je navrhnutá tak, aby privítala všetkých účastníkov a poskytla im všetky potrebné informácie a materiály pre úspešný začiatok konferencie.',
                'long_desc' => null,
                'capacity' => null,
                'taken_spots' => null,
                'is_lecture' => false,
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
            ],
            [
                'speaker_id' => null,
                'stage_id' => 2,
                'conference_id' => 1,
                'name' => 'Registracia',
                'short_desc' => 'Registrácia je prvým a zásadným krokom na každej konferencii. Táto sekcia je navrhnutá tak, aby privítala všetkých účastníkov a poskytla im všetky potrebné informácie a materiály pre úspešný začiatok konferencie.',
                'long_desc' => null,
                'capacity' => null,
                'taken_spots' => null,
                'is_lecture' => false,
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
            ],
            [
                'speaker_id' => null,
                'stage_id' => 1,
                'conference_id' => 1,
                'name' => 'Otvorenie',
                'short_desc' => 'Zahájenie oficiálneho programu konferenice.',
                'long_desc' => null,
                'capacity' => null,
                'taken_spots' => null,
                'is_lecture' => false,
                'start_time' => '09:00:00',
                'end_time' => '09:15:00',
            ],
            [
                'speaker_id' => null,
                'stage_id' => 2,
                'conference_id' => 1,
                'name' => 'Otvorenie',
                'short_desc' => 'Zahájenie oficiálneho programu konferenice.',
                'long_desc' => null,
                'capacity' => null,
                'taken_spots' => null,
                'is_lecture' => false,
                'start_time' => '09:00:00',
                'end_time' => '09:15:00',
            ],
            [
                'speaker_id' => 1,
                'stage_id' => 1,
                'conference_id' => 1,
                'name' => 'Data-driven business',
                'short_desc' => 'CEO GymBeam, odhalí, ako dátami riadený prístup a hĺbková analýza ovplyvnili rast jeho spoločnosti a zároveň sa podelí o 5 kritických chýb na ceste k úspechu, ponúkajúc cenné lekcie pre začínajúcich podnikateľov v digitálnom prostredí.',
                'long_desc' => null,
                'capacity' => 100,
                'taken_spots' => null,
                'is_lecture' => true,
                'start_time' => '10:00:00',
                'end_time' => '10:45:00',
            ],
            [
                'speaker_id' => 2,
                'stage_id' => 1,
                'conference_id' => 1,
                'name' => 'Ako sme v Muzikeri postavili miliardový sklad!...dátový',
                'short_desc' => 'Výzva pripraviť sa na dátovú dobu stála aj pred nami v Muzikeri. Ako sme sa s touto výzvou popasovali, čo všetko to znamenalo pre nás, aké všetky prekážky sme museli prekonať, aké všetky veci nás vyfackali vám skusime rozpovedať v našom príbehu.',
                'long_desc' => 'Aby to nebola iba "rozprávka", povieme si viac do detailu o databázovej technologii Clickhouse, ktorá nám veľa z tých problémov pomohla poriešiť. A iné zase priniesla',
                'capacity' => 100,
                'taken_spots' => null,
                'is_lecture' => true,
                'start_time' => '09:15:00',
                'end_time' => '10:00:00',
            ],
            [
                'speaker_id' => 3,
                'stage_id' => 2,
                'conference_id' => 1,
                'name' => 'Štruktúra a spoľahlivosť: Nástroj Lerna v monorepo architektúre',
                'short_desc' => 'Téma bude praktickou ukážkou z prostredia firmy Powerplay Studio, kde sme prostredníctvom jednoduchého nástroja Lerna optimalizovali vnútrofiremné procesy vývojárov a sprehľadnili tým náš codebase.',
                'long_desc' => 'Lerna je open-source nástroj na manažovanie monorepa, zabezpečujúci efektívny čas vývoja softvéru bez narušenia robustnosti štruktúry kódu.',
                'capacity' => 100,
                'taken_spots' => null,
                'is_lecture' => true,
                'start_time' => '10:45:00',
                'end_time' => '11:30:00',
            ],
            [
                'speaker_id' => 4,
                'stage_id' => 2,
                'conference_id' => 1,
                'name' => 'Java Virtual Threads – Je reaktívne programovanie mŕtve?',
                'short_desc' => 'Predstavenie novinky z JAVY JDK 21. Virtualne thready ponukaju uplne inu dimenziu priepustnosti a su jednoduche na spravu. Prinesie tato novinka revoluciu z pohladu rychlosti java aplikacii? ',
                'long_desc' => 'Mozeme sa vzdat reactivnej paradigmy v Jave?',
                'capacity' => 100,
                'taken_spots' => null,
                'is_lecture' => true,
                'start_time' => '09:15:00',
                'end_time' => '09:45:00',
            ],
            [
                'speaker_id' => null,
                'stage_id' => 1,
                'conference_id' => 1,
                'name' => 'Ukončenie a networking',
                'short_desc' => 'Ukončenie konferencie je plánované ako dynamické zakončenie plné príležitostí pre networking a zdieľanie zážitkov z celého podujatia.',
                'long_desc' => null,
                'capacity' => null,
                'taken_spots' => null,
                'is_lecture' => false,
                'start_time' => '13:15:00',
                'end_time' => '14:00:00',
            ],
            [
                'speaker_id' => null,
                'stage_id' => 2,
                'conference_id' => 1,
                'name' => 'Ukončenie a networking',
                'short_desc' => 'Ukončenie konferencie je plánované ako dynamické zakončenie plné príležitostí pre networking a zdieľanie zážitkov z celého podujatia.',
                'long_desc' => null,
                'capacity' => null,
                'taken_spots' => null,
                'is_lecture' => false,
                'start_time' => '13:15:00',
                'end_time' => '14:00:00',
            ],
        ];

        foreach ($lectures as $lectureData) {
            $lecture = new Lecture();
            $lecture->speaker_id = $lectureData['speaker_id'];
            $lecture->stage_id = $lectureData['stage_id'];
            $lecture->conference_id = $lectureData['conference_id'];
            $lecture->name = $lectureData['name'];
            $lecture->short_desc = $lectureData['short_desc'];
            $lecture->long_desc = $lectureData['long_desc'];
            $lecture->capacity = $lectureData['capacity'];
            $lecture->taken_spots = $lectureData['taken_spots'];
            $lecture->is_lecture = $lectureData['is_lecture'];
            $lecture->start_time = $lectureData['start_time'];
            $lecture->end_time = $lectureData['end_time'];
            $lecture->save();
        }
    }


}
