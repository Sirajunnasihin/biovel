<?php

declare(strict_types=1);

namespace AKM\Biovel\Commands;

use AKM\Biovel\Facades\Biovel;
use Illuminate\Console\Command;

class BiovelSyncCommand extends Command
{
    public $signature = 'biovel:sync';

    public $description = 'Sinkronisasi data absensi dari mesin fingerprint';

    public function handle(): int
    {
        $this->info('Mulai sinkronisasi data absensi...');

        try {
            // Konek ke mesin fingerprint
            $this->info('Menghubungkan ke mesin fingerprint...');
            Biovel::connect();

            // Ambil data absensi
            $this->info('Mengambil data absensi...');
            $attendanceData = Biovel::getAttendance();

            // Tampilkan data ke console
            $this->info('Data absensi berhasil diambil:');
            $this->table(
                ['User ID', 'Nama', 'Timestamp', 'Status'],
                array_map(function ($item) {
                    return [
                        $item['user_id'],
                        $item['name'],
                        $item['timestamp'],
                        $item['status'],
                    ];
                }, $attendanceData)
            );

            $this->info('Sinkronisasi selesai!');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Gagal sinkronisasi: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
