<?php

namespace Database\Seeders;

use App\Models\Pincode;
use Illuminate\Database\Seeder;

/**
 * Mumbai-only pincode coverage.
 *
 * Zones:
 *  - Mumbai City + Suburbs (400001-400104): Free delivery, same/next day, COD enabled
 *  - Thane (400601-400615): ₹99 delivery, 2 days, COD enabled
 *  - Navi Mumbai (400614, 400701-400710): ₹99 delivery, 2 days, COD enabled
 */
class PincodeSeeder extends Seeder
{
    public function run(): void
    {
        $mumbaiCity = [
            ['400001', 'Fort'],
            ['400002', 'Kalbadevi'],
            ['400003', 'Masjid Bunder'],
            ['400004', 'Girgaon'],
            ['400005', 'Colaba'],
            ['400006', 'Malabar Hill'],
            ['400007', 'Grant Road'],
            ['400008', 'Mumbai Central'],
            ['400009', 'Chinchpokli'],
            ['400010', 'Mazgaon'],
            ['400011', 'Lalbaug'],
            ['400012', 'Parel'],
            ['400013', 'Lower Parel'],
            ['400014', 'Dadar East'],
            ['400015', 'Sewri'],
            ['400016', 'Mahim'],
            ['400017', 'Matunga'],
            ['400018', 'Worli'],
            ['400019', 'Matunga East'],
            ['400020', 'Marine Lines'],
            ['400021', 'Nariman Point'],
            ['400022', 'Sion'],
            ['400024', 'Kurla West'],
            ['400025', 'Prabhadevi'],
            ['400026', 'Breach Candy'],
            ['400028', 'Dadar West'],
            ['400029', 'Santacruz'],
        ];

        $westernSuburbs = [
            ['400049', 'Khar West'],
            ['400050', 'Bandra West'],
            ['400051', 'Bandra Kurla Complex'],
            ['400052', 'Bandra'],
            ['400053', 'Andheri West'],
            ['400054', 'Santacruz West'],
            ['400055', 'Santacruz East'],
            ['400056', 'Vile Parle West'],
            ['400057', 'Vile Parle East'],
            ['400058', 'Andheri West'],
            ['400059', 'Marol'],
            ['400060', 'SEEPZ'],
            ['400061', 'Madh Island'],
            ['400062', 'Goregaon West'],
            ['400063', 'Goregaon West'],
            ['400064', 'Malad West'],
            ['400065', 'Aarey Colony'],
            ['400066', 'Borivali East'],
            ['400067', 'Kandivali West'],
            ['400068', 'Borivali West'],
            ['400069', 'Andheri East'],
            ['400090', 'Charkop'],
            ['400091', 'Borivali West'],
            ['400092', 'Borivali West'],
            ['400093', 'Andheri East'],
            ['400095', 'Borivali East'],
            ['400097', 'Malad East'],
            ['400099', 'Andheri East (Airport)'],
            ['400101', 'Kandivali East'],
            ['400102', 'Andheri West (Lokhandwala)'],
            ['400103', 'Kandivali East'],
            ['400104', 'Malad West'],
        ];

        $centralSuburbs = [
            ['400070', 'Kurla East'],
            ['400071', 'Chembur'],
            ['400072', 'Saki Naka'],
            ['400074', 'Chembur Naka'],
            ['400075', 'Ghatkopar West'],
            ['400076', 'Powai'],
            ['400077', 'Ghatkopar East'],
            ['400078', 'Bhandup'],
            ['400079', 'Vikhroli'],
            ['400080', 'Mulund West'],
            ['400081', 'Mulund East'],
            ['400082', 'Bhandup West'],
            ['400083', 'Vikhroli East'],
            ['400084', 'Ghatkopar'],
            ['400086', 'Pant Nagar'],
            ['400088', 'Govandi'],
            ['400089', 'Chembur East'],
            ['400094', 'Anushakti Nagar'],
        ];

        $thane = [
            ['400601', 'Thane West'],
            ['400602', 'Thane West'],
            ['400603', 'Pokhran'],
            ['400604', 'Manpada'],
            ['400605', 'Wagle Estate'],
            ['400606', 'Thane (CIDCO)'],
            ['400607', 'Thane East'],
            ['400608', 'Hiranandani Estate'],
            ['400610', 'Mulund East'],
            ['400612', 'Thane West'],
            ['400615', 'Thane'],
        ];

        $naviMumbai = [
            ['400614', 'Vashi'],
            ['400701', 'Airoli'],
            ['400702', 'Rabale'],
            ['400703', 'Mahape'],
            ['400705', 'Belapur'],
            ['400706', 'Nerul'],
            ['400707', 'Sanpada'],
            ['400708', 'Kalamboli'],
            ['400709', 'Kopar Khairane'],
            ['400710', 'Sanpada'],
        ];

        // Mumbai City + Suburbs: Free delivery, 1 day
        foreach (array_merge($mumbaiCity, $westernSuburbs, $centralSuburbs) as [$pin, $area]) {
            $this->upsert($pin, $area, 'Maharashtra', 'Mumbai Metro', true, true, 0, 1);
        }

        // Thane: ₹99 delivery, 2 days
        foreach ($thane as [$pin, $area]) {
            $this->upsert($pin, $area, 'Maharashtra', 'Thane', true, true, 99, 2);
        }

        // Navi Mumbai: ₹99 delivery, 2 days
        foreach ($naviMumbai as [$pin, $area]) {
            $this->upsert($pin, $area, 'Maharashtra', 'Navi Mumbai', true, true, 99, 2);
        }
    }

    private function upsert(string $pincode, string $city, string $state, string $region, bool $serviceable, bool $cod, float $charge, int $days): void
    {
        Pincode::updateOrCreate(
            ['pincode' => $pincode],
            [
                'city' => $city,
                'state' => $state,
                'region' => $region,
                'is_serviceable' => $serviceable,
                'cod_available' => $cod,
                'delivery_charge' => $charge,
                'expected_delivery_days' => $days,
            ],
        );
    }
}
