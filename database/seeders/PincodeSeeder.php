<?php

namespace Database\Seeders;

use App\Models\Pincode;
use Illuminate\Database\Seeder;

/**
 * Trikuti Battery delivery zones (Rabale-based).
 *
 * ZONE A (₹99 delivery, 1–2 days) — one bridge / one trip from Rabale:
 *   Trans-Harbour: Rabale, Airoli, Ghansoli, Kopar Khairane, Turbhe,
 *                  Vashi, Sanpada, Juinagar, Nerul
 *   Thane City:    Thane West + East, Wagle Estate, Kalwa
 *   Central Sub:   Mulund, Nahur, Bhandup, Kanjurmarg
 *
 * ZONE B (₹199 delivery, 2–3 days) — further Central Railway trip:
 *   Mumbra, Diva, Dombivli (East + West), Kalyan (East + West)
 *
 * ANY OTHER PINCODE is not serviced — customers see
 * "Sorry, we don't deliver to this pincode yet" on the PDP delivery-check widget.
 */
class PincodeSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Zone A: ₹99, 1 day ─────────────────────────────────────────────
        $zoneA = [
            // Trans-Harbour corridor (Navi Mumbai)
            ['400701', 'Rabale',           'Navi Mumbai'],
            ['400702', 'Airoli',           'Navi Mumbai'],
            ['400703', 'Ghansoli',         'Navi Mumbai'],
            ['400705', 'Turbhe',           'Navi Mumbai'],
            ['400706', 'Nerul / Juinagar', 'Navi Mumbai'],
            ['400707', 'Sanpada',          'Navi Mumbai'],
            ['400709', 'Kopar Khairane',   'Navi Mumbai'],
            ['400710', 'Turbhe (East)',    'Navi Mumbai'],
            ['400614', 'Vashi',            'Navi Mumbai'],
            // Thane City
            ['400601', 'Thane West',       'Thane'],
            ['400602', 'Thane West',       'Thane'],
            ['400603', 'Pokhran / Thane W','Thane'],
            ['400604', 'Manpada / Thane W','Thane'],
            ['400605', 'Kalwa / Wagle',    'Thane'],
            ['400606', 'Thane (CIDCO)',    'Thane'],
            ['400607', 'Thane East',       'Thane'],
            ['400608', 'Hiranandani Est.', 'Thane'],
            ['400610', 'Mulund East / Thane border', 'Thane'],
            ['400615', 'Thane',            'Thane'],
            // Central Suburbs (Mumbai) — Mulund → Kanjurmarg
            ['400042', 'Kanjurmarg',       'Mumbai (Central Suburbs)'],
            ['400078', 'Bhandup / Nahur',  'Mumbai (Central Suburbs)'],
            ['400080', 'Mulund West',      'Mumbai (Central Suburbs)'],
            ['400081', 'Mulund East',      'Mumbai (Central Suburbs)'],
            ['400082', 'Bhandup West',     'Mumbai (Central Suburbs)'],
        ];

        // ─── Zone B: ₹199, 2 days ───────────────────────────────────────────
        $zoneB = [
            ['400612', 'Mumbra / Diva',    'Thane (East)'],
            ['421201', 'Dombivli East',    'Kalyan-Dombivli'],
            ['421202', 'Dombivli West',    'Kalyan-Dombivli'],
            ['421203', 'Dombivli',         'Kalyan-Dombivli'],
            ['421204', 'Dombivli',         'Kalyan-Dombivli'],
            ['421301', 'Kalyan West',      'Kalyan-Dombivli'],
            ['421302', 'Kalyan West',      'Kalyan-Dombivli'],
            ['421303', 'Kalyan East',      'Kalyan-Dombivli'],
            ['421304', 'Kalyan',           'Kalyan-Dombivli'],
            ['421306', 'Kalyan (Titwala)', 'Kalyan-Dombivli'],
        ];

        // Canonical list of pincodes we serve
        $canonical = array_merge(
            array_column($zoneA, 0),
            array_column($zoneB, 0),
        );

        // 1. Remove any pincode from the DB that's not in our canonical list
        //    (the DeliveryController returns "not serviceable" when a pincode isn't found,
        //    so simply deleting them stops delivery to those areas cleanly)
        Pincode::whereNotIn('pincode', $canonical)->delete();

        // 2. Upsert Zone A (₹99, 1 day)
        foreach ($zoneA as [$pin, $area, $region]) {
            $this->upsert($pin, $area, $region, true, true, 99, 1);
        }

        // 3. Upsert Zone B (₹199, 2 days)
        foreach ($zoneB as [$pin, $area, $region]) {
            $this->upsert($pin, $area, $region, true, true, 199, 2);
        }
    }

    private function upsert(string $pincode, string $city, string $region, bool $serviceable, bool $cod, float $charge, int $days): void
    {
        Pincode::updateOrCreate(
            ['pincode' => $pincode],
            [
                'city'                   => $city,
                'state'                  => 'Maharashtra',
                'region'                 => $region,
                'is_serviceable'         => $serviceable,
                'cod_available'          => $cod,
                'delivery_charge'        => $charge,
                'expected_delivery_days' => $days,
            ],
        );
    }
}
