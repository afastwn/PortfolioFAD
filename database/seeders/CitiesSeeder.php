<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    private const PROV_MAP = [
        '11'=>'Aceh','12'=>'Sumatera Utara','13'=>'Sumatera Barat','14'=>'Riau','15'=>'Jambi',
        '16'=>'Sumatera Selatan','17'=>'Bengkulu','18'=>'Lampung','19'=>'Kepulauan Bangka Belitung',
        '21'=>'Kepulauan Riau','31'=>'DKI Jakarta','32'=>'Jawa Barat','33'=>'Jawa Tengah',
        '34'=>'Daerah Istimewa Yogyakarta','35'=>'Jawa Timur','36'=>'Banten','51'=>'Bali',
        '52'=>'Nusa Tenggara Barat','53'=>'Nusa Tenggara Timur','61'=>'Kalimantan Barat',
        '62'=>'Kalimantan Tengah','63'=>'Kalimantan Selatan','64'=>'Kalimantan Timur','65'=>'Kalimantan Utara',
        '71'=>'Sulawesi Utara','72'=>'Sulawesi Tengah','73'=>'Sulawesi Selatan','74'=>'Sulawesi Tenggara',
        '75'=>'Gorontalo','76'=>'Sulawesi Barat','81'=>'Maluku','82'=>'Maluku Utara',
        '91'=>'Papua','92'=>'Papua Barat','93'=>'Papua Selatan','94'=>'Papua Tengah',
        '95'=>'Papua Pegunungan','96'=>'Papua Barat Daya',
    ];

    public function run(): void
    {
        // CARI FILE DENGAN PATH ABSOLUT
        $candidates = [
            storage_path('app/data/geocode_cities.csv'),          // ← yang kamu pakai
            storage_path('app/geocode_cities.csv'),               // fallback
            base_path('storage/app/data/geocode_cities.csv'),     // fallback
            base_path('database/seeders/data/geocode_cities.csv') // fallback opsional
        ];

        $file = null;
        foreach ($candidates as $p) {
            if (is_file($p)) { $file = $p; break; }
        }

        if (!$file) {
            $this->command?->warn("Missing geocode_cities.csv. Tried:\n - ".implode("\n - ", $candidates));
            return;
        }

        $fh = fopen($file, 'r');
        $header = array_map('mb_strtolower', fgetcsv($fh));
        $idx = array_flip($header); // expect: id,name,province_id,latitude,longitude,source

        $n=0;
        while (($r=fgetcsv($fh))!==false) {
            $name = $r[$idx['name']] ?? null;
            $pid  = $r[$idx['province_id']] ?? null;
            $lat  = $r[$idx['latitude']] ?? null;
            $lng  = $r[$idx['longitude']] ?? null;
            if (!$name || !$pid || !$lat || !$lng) continue;

            $type = str_starts_with(mb_strtolower($name), 'kota') ? 'KOTA' : 'KAB';
            $prov = self::PROV_MAP[(string)$pid] ?? 'Indonesia';

            \App\Models\City::updateOrCreate(
                ['province_id' => (string)$pid, 'name' => $name],
                [
                    'type'     => $type,
                    'province' => $prov,
                    'lat'      => (float)$lat,
                    'lng'      => (float)$lng,
                    'raw'      => ['src'=>basename($file)],
                ]
            );
            $n++;
        }
        fclose($fh);
        $this->command?->info("Imported cities: $n from ".basename($file));
    }
}