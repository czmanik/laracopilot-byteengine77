<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Event;
use App\Models\PlaceType;
use App\Models\ActivityCategory;
use App\Models\AccessibilityOption;
use App\Models\Organizer;
use App\Models\Place;
use App\Models\Stage;
use App\Models\ProgramSlot;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super admin
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@zizkov.cz',
            'password' => Hash::make('password'),
            'role'     => 'super_admin',
            'is_active'=> true,
        ]);

        // Akce
        $nocEvent = Event::create([
            'name'          => 'Žižkovská noc 2026',
            'slug'          => 'zizkovska-noc-2026',
            'type'          => 'zizkovska_noc',
            'description'   => 'Největší noční festival na Žižkově. Dva dny plné hudby, zábavy a kultury.',
            'date_from'     => '2026-05-08',
            'date_to'       => '2026-05-09',
            'is_paid'       => true,
            'is_active'     => true,
            'primary_color' => '#e11d48',
        ]);

        $mezEvent = Event::create([
            'name'          => 'Žižkovské mezidvorky 2026',
            'slug'          => 'zizkovske-mezidvorky-2026',
            'type'          => 'mezidvorky',
            'description'   => 'Letní festival otevřených dvorů Žižkova. Vstup zdarma pro všechny.',
            'date_from'     => '2026-07-17',
            'date_to'       => '2026-07-18',
            'is_paid'       => false,
            'is_active'     => false,
            'primary_color' => '#ea580c',
        ]);

        // Typy míst
        $types = [
            ['name' => 'Restaurace', 'slug' => 'restaurace', 'icon' => 'heroicon-o-building-storefront'],
            ['name' => 'Klub',       'slug' => 'klub',       'icon' => 'heroicon-o-musical-note'],
            ['name' => 'Kavárna',    'slug' => 'kavarna',    'icon' => 'heroicon-o-beaker'],
            ['name' => 'Galerie',    'slug' => 'galerie',    'icon' => 'heroicon-o-photo'],
            ['name' => 'Dvůr',       'slug' => 'dvur',       'icon' => 'heroicon-o-home'],
            ['name' => 'Bar',        'slug' => 'bar',        'icon' => 'heroicon-o-beaker'],
        ];
        foreach ($types as $t) { PlaceType::create($t); }

        // Typy aktivit
        $cats = [
            ['name' => 'Muzika',    'slug' => 'muzika',    'color' => '#7c3aed'],
            ['name' => 'Divadlo',   'slug' => 'divadlo',   'color' => '#db2777'],
            ['name' => 'Swap',      'slug' => 'swap',      'color' => '#0891b2'],
            ['name' => 'Gastro',    'slug' => 'gastro',    'color' => '#16a34a'],
            ['name' => 'Přednáška', 'slug' => 'prednaska', 'color' => '#ca8a04'],
            ['name' => 'Výstava',   'slug' => 'vystava',   'color' => '#ea580c'],
        ];
        foreach ($cats as $c) { ActivityCategory::create($c); }

        // Dostupnost
        $access = [
            ['name' => 'Vhodné pro děti',    'slug' => 'deti',        'icon' => '👶'],
            ['name' => 'Celá rodina',         'slug' => 'rodina',      'icon' => '👨‍👩‍👧'],
            ['name' => 'Bezbariérový přístup','slug' => 'bezbarierovy','icon' => '♿'],
            ['name' => 'Venkovní prostor',    'slug' => 'venkovni',    'icon' => '🌿'],
            ['name' => '18+',                 'slug' => '18plus',      'icon' => '🔞'],
        ];
        foreach ($access as $a) { AccessibilityOption::create($a); }

        // Organizátoři
        $org1 = Organizer::create([
            'name'      => 'Jana Novotná',
            'email'     => 'jana@zizkov.cz',
            'phone'     => '+420 731 111 222',
            'bio'       => 'Hlavní koordinátorka Žižkovské noci od roku 2020.',
            'is_active' => true,
        ]);
        $org2 = Organizer::create([
            'name'      => 'Tomáš Veselý',
            'email'     => 'tomas@zizkov.cz',
            'phone'     => '+420 722 333 444',
            'bio'       => 'Koordinátor Mezidvorků a komunitních projektů.',
            'is_active' => true,
        ]);

        // Místa
        $placeData = [
            [
                'name'    => 'Palác Akropolis',
                'address' => 'Kubelíkova 1548/27, Praha 3',
                'lat'     => 50.0875,
                'lng'     => 14.4590,
                'type'    => 'Klub',
                'stages'  => ['Velký sál', 'Malý bar'],
            ],
            [
                'name'    => 'Club Vzorkovna',
                'address' => 'Náměstí Míru 9, Praha 2',
                'lat'     => 50.0758,
                'lng'     => 14.4378,
                'type'    => 'Klub',
                'stages'  => ['Main stage', 'Backroom'],
            ],
            [
                'name'    => 'Kavárna Místo',
                'address' => 'Seifertova 35, Praha 3',
                'lat'     => 50.0881,
                'lng'     => 14.4467,
                'type'    => 'Kavárna',
                'stages'  => ['Přednáškový sál'],
            ],
            [
                'name'    => 'Bio Oko',
                'address' => 'Františka Křížka 460/15, Praha 7',
                'lat'     => 50.1014,
                'lng'     => 14.4370,
                'type'    => 'Galerie',
                'stages'  => ['Kinosál', 'Foyer'],
            ],
        ];

        $klube = PlaceType::where('slug', 'klub')->first();
        $kavarna = PlaceType::where('slug', 'kavarna')->first();
        $galerie = PlaceType::where('slug', 'galerie')->first();
        $typeMap = ['Klub' => $klube, 'Kavárna' => $kavarna, 'Galerie' => $galerie];
        $muzika = ActivityCategory::where('slug', 'muzika')->first();
        $prednaska = ActivityCategory::where('slug', 'prednaska')->first();

        foreach ($placeData as $i => $pd) {
            $place = Place::create([
                'event_id'      => $nocEvent->id,
                'place_type_id' => ($typeMap[$pd['type']] ?? $klube)?->id,
                'organizer_id'  => ($i % 2 === 0) ? $org1->id : $org2->id,
                'name'          => $pd['name'],
                'slug'          => Str::slug($pd['name']),
                'description'   => 'Jedno z předních míst Žižkovské noci. Připravte se na skvělou atmosféru a pestrý program.',
                'address'       => $pd['address'],
                'lat'           => $pd['lat'],
                'lng'           => $pd['lng'],
                'program_from'  => '2026-05-08 20:00:00',
                'program_to'    => '2026-05-09 04:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => $i,
            ]);

            // Accessibility
            $place->accessibilityOptions()->attach(
                AccessibilityOption::inRandomOrder()->limit(2)->pluck('id')
            );

            // Stages a sloty
            foreach ($pd['stages'] as $si => $stageName) {
                $stage = Stage::create([
                    'place_id'   => $place->id,
                    'name'       => $stageName,
                    'capacity'   => rand(50, 300),
                    'sort_order' => $si,
                ]);

                // 3 sloty na každou stage
                for ($h = 0; $h < 3; $h++) {
                    $start = \Carbon\Carbon::parse('2026-05-08 20:00:00')->addHours($h * 2);
                    ProgramSlot::create([
                        'stage_id'             => $stage->id,
                        'place_id'             => $place->id,
                        'activity_category_id' => ($h === 1) ? $prednaska->id : $muzika->id,
                        'title'                => 'Vystoupení ' . ($h + 1) . ' – ' . $stageName,
                        'performer'            => 'Kapela ' . chr(65 + $i) . ($h + 1),
                        'description'          => 'Skvělé vystoupení v prostorách ' . $place->name,
                        'starts_at'            => $start,
                        'ends_at'              => $start->copy()->addHours(2),
                        'status'               => 'published',
                        'sort_order'           => $h,
                    ]);
                }
            }

            // Přidáme uživatele-správce místa
            User::create([
                'name'      => 'Správce ' . $pd['name'],
                'email'     => 'spravce' . ($i + 1) . '@zizkov.cz',
                'password'  => Hash::make('password'),
                'role'      => 'place_manager',
                'place_id'  => $place->id,
                'is_active' => true,
            ]);
        }
    }
}