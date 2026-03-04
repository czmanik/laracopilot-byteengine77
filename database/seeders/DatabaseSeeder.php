<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\PlaceType;
use App\Models\ActivityCategory;
use App\Models\AccessibilityOption;
use App\Models\Organizer;
use App\Models\Place;
use App\Models\Stage;
use App\Models\ProgramSlot;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Super admin ──────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@zizkov.cz'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('password'),
                'role'      => 'super_admin',
                'is_active' => true,
            ]
        );

        // ── Akce ─────────────────────────────────────────────────────
        $noc = Event::firstOrCreate(
            ['slug' => 'zizkovska-noc-2026'],
            [
                'name'          => 'Žižkovská noc 2026',
                'type'          => 'zizkovska_noc',
                'description'   => 'Největší noční festival na Žižkově. Dva dny plné hudby, zábavy a kultury v desítkách klubů, barů a kaváren.',
                'date_from'     => '2026-05-08',
                'date_to'       => '2026-05-09',
                'is_paid'       => true,
                'is_active'     => true,
                'primary_color' => '#e11d48',
            ]
        );

        $mez = Event::firstOrCreate(
            ['slug' => 'zizkovske-mezidvorky-2026'],
            [
                'name'          => 'Žižkovské mezidvorky 2026',
                'type'          => 'mezidvorky',
                'description'   => 'Letní festival otevřených dvorů Žižkova. Vstup zdarma pro celou rodinu.',
                'date_from'     => '2026-07-17',
                'date_to'       => '2026-07-18',
                'is_paid'       => false,
                'is_active'     => false,
                'primary_color' => '#ea580c',
            ]
        );

        // ── Typy míst ────────────────────────────────────────────────
        $placeTypes = [
            ['name' => 'Restaurace', 'slug' => 'restaurace', 'icon' => 'heroicon-o-building-storefront'],
            ['name' => 'Klub',       'slug' => 'klub',       'icon' => 'heroicon-o-musical-note'],
            ['name' => 'Kavárna',    'slug' => 'kavarna',    'icon' => 'heroicon-o-beaker'],
            ['name' => 'Galerie',    'slug' => 'galerie',    'icon' => 'heroicon-o-photo'],
            ['name' => 'Dvůr',       'slug' => 'dvur',       'icon' => 'heroicon-o-home'],
            ['name' => 'Bar',        'slug' => 'bar',        'icon' => 'heroicon-o-beaker'],
        ];
        foreach ($placeTypes as $pt) {
            PlaceType::firstOrCreate(['slug' => $pt['slug']], $pt);
        }

        // ── Typy aktivit ─────────────────────────────────────────────
        $activityCats = [
            ['name' => 'Muzika',    'slug' => 'muzika',    'color' => '#7c3aed'],
            ['name' => 'Divadlo',   'slug' => 'divadlo',   'color' => '#db2777'],
            ['name' => 'Swap',      'slug' => 'swap',      'color' => '#0891b2'],
            ['name' => 'Gastro',    'slug' => 'gastro',    'color' => '#16a34a'],
            ['name' => 'Přednáška', 'slug' => 'prednaska', 'color' => '#ca8a04'],
            ['name' => 'Výstava',   'slug' => 'vystava',   'color' => '#ea580c'],
        ];
        foreach ($activityCats as $ac) {
            ActivityCategory::firstOrCreate(['slug' => $ac['slug']], $ac);
        }

        // ── Dostupnost ───────────────────────────────────────────────
        $accessibilities = [
            ['name' => 'Vhodné pro děti',     'slug' => 'deti',         'icon' => '👶'],
            ['name' => 'Celá rodina',          'slug' => 'rodina',       'icon' => '👨‍👩‍👧'],
            ['name' => 'Bezbariérový přístup', 'slug' => 'bezbarierovy', 'icon' => '♿'],
            ['name' => 'Venkovní prostor',     'slug' => 'venkovni',     'icon' => '🌿'],
            ['name' => '18+',                  'slug' => '18plus',       'icon' => '🔞'],
        ];
        foreach ($accessibilities as $a) {
            AccessibilityOption::firstOrCreate(['slug' => $a['slug']], $a);
        }

        // ── Organizátoři ─────────────────────────────────────────────
        $org1 = Organizer::firstOrCreate(
            ['email' => 'jana@zizkov.cz'],
            [
                'name'      => 'Jana Novotná',
                'phone'     => '+420 731 111 222',
                'bio'       => 'Hlavní koordinátorka Žižkovské noci od roku 2020.',
                'is_active' => true,
            ]
        );
        $org2 = Organizer::firstOrCreate(
            ['email' => 'tomas@zizkov.cz'],
            [
                'name'      => 'Tomáš Veselý',
                'phone'     => '+420 722 333 444',
                'bio'       => 'Koordinátor Mezidvorků a komunitních projektů.',
                'is_active' => true,
            ]
        );

        // ── Načtení pomocných modelů ─────────────────────────────────
        $typKlub     = PlaceType::where('slug', 'klub')->first();
        $typKavarna  = PlaceType::where('slug', 'kavarna')->first();
        $typGalerie  = PlaceType::where('slug', 'galerie')->first();
        $typRestaurace = PlaceType::where('slug', 'restaurace')->first();
        $typBar      = PlaceType::where('slug', 'bar')->first();
        $typDvur     = PlaceType::where('slug', 'dvur')->first();

        $catMuzika   = ActivityCategory::where('slug', 'muzika')->first();
        $catDivadlo  = ActivityCategory::where('slug', 'divadlo')->first();
        $catGastro   = ActivityCategory::where('slug', 'gastro')->first();
        $catPred     = ActivityCategory::where('slug', 'prednaska')->first();
        $catVystava  = ActivityCategory::where('slug', 'vystava')->first();
        $catSwap     = ActivityCategory::where('slug', 'swap')->first();

        $accDeti      = AccessibilityOption::where('slug', 'deti')->first();
        $accRodina    = AccessibilityOption::where('slug', 'rodina')->first();
        $accBezbar    = AccessibilityOption::where('slug', 'bezbarierovy')->first();
        $accVenkovni  = AccessibilityOption::where('slug', 'venkovni')->first();
        $acc18        = AccessibilityOption::where('slug', '18plus')->first();

        // ── Místa ────────────────────────────────────────────────────
        $placesData = [
            [
                'event_id'      => $noc->id,
                'place_type_id' => $typKlub->id,
                'organizer_id'  => $org1->id,
                'name'          => 'Palác Akropolis',
                'slug'          => 'palac-akropolis',
                'description'   => 'Palác Akropolis je legendární multifunkční kulturní centrum v srdci Žižkova. Nabízí dva sály pro živou hudbu, bar a jedinečnou atmosféru secesního paláce.',
                'address'       => 'Kubelíkova 1548/27, Praha 3',
                'lat'           => 50.0875,
                'lng'           => 14.4590,
                'website'       => 'https://www.palacakropolis.cz',
                'program_from'  => '2026-05-08 20:00:00',
                'program_to'    => '2026-05-09 03:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 1,
                'accessibility' => [$accBezbar->id, $acc18->id],
                'stages'        => [
                    ['name' => 'Velký sál', 'capacity' => 500, 'sort_order' => 1],
                    ['name' => 'Malý bar',  'capacity' => 80,  'sort_order' => 2],
                ],
                'program' => [
                    // Velký sál
                    ['stage_idx' => 0, 'cat' => $catMuzika,  'title' => 'The Plastic People Revival',    'performer' => 'The Plastic People Revival', 'start' => '2026-05-08 20:30', 'end' => '2026-05-08 22:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika,  'title' => 'Midi Lidi',                     'performer' => 'Midi Lidi',                  'start' => '2026-05-08 22:30', 'end' => '2026-05-09 00:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika,  'title' => 'DJ Standa Fatáček',             'performer' => 'DJ Standa Fatáček',           'start' => '2026-05-09 00:30', 'end' => '2026-05-09 03:00'],
                    // Malý bar
                    ['stage_idx' => 1, 'cat' => $catMuzika,  'title' => 'Akustická večeře s Janem Pokým','performer' => 'Jan Poký',                   'start' => '2026-05-08 21:00', 'end' => '2026-05-08 23:00'],
                    ['stage_idx' => 1, 'cat' => $catMuzika,  'title' => 'Poetická noc – slam poetry',    'performer' => 'Různí autoři',               'start' => '2026-05-08 23:30', 'end' => '2026-05-09 01:00'],
                ],
            ],
            [
                'event_id'      => $noc->id,
                'place_type_id' => $typKlub->id,
                'organizer_id'  => $org2->id,
                'name'          => 'Club Vzorkovna',
                'slug'          => 'club-vzorkovna',
                'description'   => 'Podzemní klub s bohatou historií a dvěma sály. Domov elektronické hudby, experimentálního umění a alternativní kultury.',
                'address'       => 'Náměstí Míru 9, Praha 2',
                'lat'           => 50.0758,
                'lng'           => 14.4378,
                'program_from'  => '2026-05-08 21:00:00',
                'program_to'    => '2026-05-09 04:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 2,
                'accessibility' => [$acc18->id],
                'stages'        => [
                    ['name' => 'Main stage', 'capacity' => 300, 'sort_order' => 1],
                    ['name' => 'Backroom',   'capacity' => 100, 'sort_order' => 2],
                ],
                'program' => [
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'Techno Session: Ondřej Skála', 'performer' => 'Ondřej Skála',  'start' => '2026-05-08 22:00', 'end' => '2026-05-09 00:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'DJ Set: Tereza K.',            'performer' => 'Tereza K.',      'start' => '2026-05-09 00:00', 'end' => '2026-05-09 02:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'Closing set: Anonym404',       'performer' => 'Anonym404',      'start' => '2026-05-09 02:00', 'end' => '2026-05-09 04:00'],
                    ['stage_idx' => 1, 'cat' => $catMuzika, 'title' => 'Lo-fi & Chill with Bára',     'performer' => 'Bára Hašková',   'start' => '2026-05-08 21:00', 'end' => '2026-05-08 23:00'],
                    ['stage_idx' => 1, 'cat' => $catMuzika, 'title' => 'Experimental: Zvuková Lab',   'performer' => 'Zvuková Lab',    'start' => '2026-05-08 23:30', 'end' => '2026-05-09 02:00'],
                ],
            ],
            [
                'event_id'      => $noc->id,
                'place_type_id' => $typKavarna->id,
                'organizer_id'  => $org1->id,
                'name'          => 'Kavárna Místo',
                'slug'          => 'kavarna-misto',
                'description'   => 'Komunitní kavárna a kulturní prostor na Žižkově. Přednášky, debaty, výstavy a dobrá káva v útulném prostředí.',
                'address'       => 'Seifertova 35, Praha 3',
                'lat'           => 50.0881,
                'lng'           => 14.4467,
                'website'       => 'https://www.kavarna-misto.cz',
                'program_from'  => '2026-05-08 18:00:00',
                'program_to'    => '2026-05-08 23:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 3,
                'accessibility' => [$accBezbar->id, $accDeti->id, $accRodina->id],
                'stages'        => [
                    ['name' => 'Přednáškový sál', 'capacity' => 60, 'sort_order' => 1],
                ],
                'program' => [
                    ['stage_idx' => 0, 'cat' => $catPred,   'title' => 'Žižkov – čtvrť, která odmítá zestárnout', 'performer' => 'Historik Pavel Bureš',    'start' => '2026-05-08 18:30', 'end' => '2026-05-08 19:30'],
                    ['stage_idx' => 0, 'cat' => $catPred,   'title' => 'Komunitní zahradničení v městě',          'performer' => 'Tereza Zelenková',        'start' => '2026-05-08 20:00', 'end' => '2026-05-08 21:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'Akustický večer: Klára & Friends',        'performer' => 'Klára Procházková',       'start' => '2026-05-08 21:30', 'end' => '2026-05-08 23:00'],
                ],
            ],
            [
                'event_id'      => $noc->id,
                'place_type_id' => $typGalerie->id,
                'organizer_id'  => $org2->id,
                'name'          => 'Galerie Emila Filly',
                'slug'          => 'galerie-emila-filly',
                'description'   => 'Moderní galerie v rekonstruovaném průmyslovém objektu. Výstavy současného umění, instalace a večerní vernisáže.',
                'address'       => 'Blanická 4, Praha 2',
                'lat'           => 50.0764,
                'lng'           => 14.4390,
                'program_from'  => '2026-05-08 19:00:00',
                'program_to'    => '2026-05-09 01:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 4,
                'accessibility' => [$accBezbar->id, $accVenkovni->id],
                'stages'        => [
                    ['name' => 'Hlavní galerie', 'capacity' => 200, 'sort_order' => 1],
                    ['name' => 'Dvorek',         'capacity' => 80,  'sort_order' => 2],
                ],
                'program' => [
                    ['stage_idx' => 0, 'cat' => $catVystava, 'title' => 'Vernisáž: Město v pohybu',        'performer' => 'Kolektiv Pohyb',       'start' => '2026-05-08 19:00', 'end' => '2026-05-08 21:00'],
                    ['stage_idx' => 0, 'cat' => $catDivadlo, 'title' => 'Divadelní čtení: Kafka na Žižkově','performer' => 'Divadlo Na zábradlí', 'start' => '2026-05-08 21:30', 'end' => '2026-05-08 23:00'],
                    ['stage_idx' => 1, 'cat' => $catMuzika,  'title' => 'Jazz pod hvězdami',               'performer' => 'Prague Jazz Quartet',  'start' => '2026-05-08 20:00', 'end' => '2026-05-08 22:30'],
                    ['stage_idx' => 1, 'cat' => $catMuzika,  'title' => 'Noční jam session',               'performer' => 'Open session',         'start' => '2026-05-08 23:00', 'end' => '2026-05-09 01:00'],
                ],
            ],
            [
                'event_id'      => $noc->id,
                'place_type_id' => $typRestaurace->id,
                'organizer_id'  => $org1->id,
                'name'          => 'Restaurace U Sadu',
                'slug'          => 'restaurace-u-sadu',
                'description'   => 'Tradiční česká hospoda s přátelskou atmosférou. Během Žižkovské noci otevíráme zahradu a nabízíme speciální degustační menu.',
                'address'       => 'Škroupovo náměstí 5, Praha 3',
                'lat'           => 50.0849,
                'lng'           => 14.4556,
                'program_from'  => '2026-05-08 18:00:00',
                'program_to'    => '2026-05-09 02:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 5,
                'accessibility' => [$accBezbar->id, $accVenkovni->id, $accDeti->id],
                'stages'        => [
                    ['name' => 'Zahrada', 'capacity' => 120, 'sort_order' => 1],
                    ['name' => 'Vnitřek', 'capacity' => 80,  'sort_order' => 2],
                ],
                'program' => [
                    ['stage_idx' => 0, 'cat' => $catGastro,  'title' => 'Degustace žižkovských piv',         'performer' => 'Pivovar Žižkov',      'start' => '2026-05-08 18:00', 'end' => '2026-05-08 20:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika,  'title' => 'Country večer: Skupina Sekeráči',   'performer' => 'Sekeráči',            'start' => '2026-05-08 20:30', 'end' => '2026-05-08 22:30'],
                    ['stage_idx' => 0, 'cat' => $catMuzika,  'title' => 'Swing noc s Orchestrem Starých pánů','performer' => 'Orchestr Starých pánů','start' => '2026-05-08 23:00', 'end' => '2026-05-09 01:30'],
                    ['stage_idx' => 1, 'cat' => $catGastro,  'title' => 'Workshop: Tradiční česká kuchyně',  'performer' => 'Šéfkuchař Ondřej Matouš','start' => '2026-05-08 19:00', 'end' => '2026-05-08 21:00'],
                ],
            ],
            [
                'event_id'      => $noc->id,
                'place_type_id' => $typBar->id,
                'organizer_id'  => $org2->id,
                'name'          => 'Bar Cobra',
                'slug'          => 'bar-cobra',
                'description'   => 'Ikonický žižkovský bar s punkovým duchem. Neonové světla, hlasitá muzika a koktejly za dobré peníze.',
                'address'       => 'Fibichova 9, Praha 3',
                'lat'           => 50.0861,
                'lng'           => 14.4612,
                'program_from'  => '2026-05-08 22:00:00',
                'program_to'    => '2026-05-09 05:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 6,
                'accessibility' => [$acc18->id],
                'stages'        => [
                    ['name' => 'Hlavní bar', 'capacity' => 150, 'sort_order' => 1],
                ],
                'program' => [
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'Punk Night: Marná Sláva',         'performer' => 'Marná Sláva',         'start' => '2026-05-08 22:00', 'end' => '2026-05-09 00:00'],
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'Hardcore set: Vztek',             'performer' => 'Vztek',               'start' => '2026-05-09 00:30', 'end' => '2026-05-09 02:30'],
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'DJ afterparty: Štefan Remix',    'performer' => 'Štefan Remix',        'start' => '2026-05-09 03:00', 'end' => '2026-05-09 05:00'],
                ],
            ],
            // ── Mezidvorky místa ──────────────────────────────────
            [
                'event_id'      => $mez->id,
                'place_type_id' => $typDvur->id,
                'organizer_id'  => $org2->id,
                'name'          => 'Dvůr na Seifertově',
                'slug'          => 'dvur-na-seifertove',
                'description'   => 'Krásný komunitní dvůr otevřený veřejnosti. Během Mezidvorků zde probíhá program pro celou rodinu.',
                'address'       => 'Seifertova 42, Praha 3',
                'lat'           => 50.0888,
                'lng'           => 14.4471,
                'program_from'  => '2026-07-17 14:00:00',
                'program_to'    => '2026-07-17 22:00:00',
                'status'        => 'approved',
                'is_active'     => true,
                'sort_order'    => 1,
                'accessibility' => [$accDeti->id, $accRodina->id, $accVenkovni->id, $accBezbar->id],
                'stages'        => [
                    ['name' => 'Dvorek', 'capacity' => 100, 'sort_order' => 1],
                ],
                'program' => [
                    ['stage_idx' => 0, 'cat' => $catSwap,   'title' => 'Swap oblečení a knih',             'performer' => 'Komunita Žižkov',     'start' => '2026-07-17 14:00', 'end' => '2026-07-17 17:00'],
                    ['stage_idx' => 0, 'cat' => $catDivadlo,'title' => 'Loutkové divadlo pro děti',         'performer' => 'Loutky Marjánka',     'start' => '2026-07-17 16:00', 'end' => '2026-07-17 17:30'],
                    ['stage_idx' => 0, 'cat' => $catMuzika, 'title' => 'Letní koncert: Folkové melodie',    'performer' => 'Trio Seifertova',     'start' => '2026-07-17 19:00', 'end' => '2026-07-17 22:00'],
                ],
            ],
        ];

        foreach ($placesData as $idx => $pd) {
            $stagesData  = $pd['stages'];
            $programData = $pd['program'];
            $accIds      = $pd['accessibility'];

            unset($pd['stages'], $pd['program'], $pd['accessibility']);

            $place = Place::firstOrCreate(
                ['slug' => $pd['slug']],
                $pd
            );

            // Dostupnost
            $place->accessibilityOptions()->syncWithoutDetaching($accIds);

            // Stages
            $createdStages = [];
            foreach ($stagesData as $sd) {
                $stage = Stage::firstOrCreate(
                    ['place_id' => $place->id, 'name' => $sd['name']],
                    array_merge($sd, ['place_id' => $place->id])
                );
                $createdStages[] = $stage;
            }

            // Program sloty
            foreach ($programData as $slot) {
                $stage = $createdStages[$slot['stage_idx']] ?? $createdStages[0];
                ProgramSlot::firstOrCreate(
                    [
                        'stage_id'  => $stage->id,
                        'place_id'  => $place->id,
                        'title'     => $slot['title'],
                        'starts_at' => Carbon::parse($slot['start']),
                    ],
                    [
                        'activity_category_id' => $slot['cat']->id,
                        'performer'            => $slot['performer'],
                        'description'          => null,
                        'ends_at'              => Carbon::parse($slot['end']),
                        'status'               => 'published',
                        'sort_order'           => 0,
                    ]
                );
            }

            // Uživatel-správce místa
            $email = 'spravce' . ($idx + 1) . '@zizkov.cz';
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name'      => 'Správce – ' . $place->name,
                    'password'  => Hash::make('password'),
                    'role'      => 'place_manager',
                    'place_id'  => $place->id,
                    'is_active' => true,
                ]
            );
        }
    }
}