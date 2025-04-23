<?php

declare(strict_types=1);

namespace AKM\Biovel;

use Exception;
use Illuminate\Support\Facades\Config;

final class Biovel
{
    /**
     * @var resource|null Socket koneksi
     */
    private $socket = null;

    /**
     * @var string IP Address mesin fingerprint
     */
    private string $ip;

    /**
     * @var int Port mesin fingerprint
     */
    private int $port;

    /**
     * Konstruktor untuk kelas Biovel
     *
     * @param  string|null  $ip  IP Address mesin fingerprint
     * @param  int|null  $port  Port koneksi (default: 4370)
     */
    public function __construct(?string $ip = null, ?int $port = null)
    {
        $this->ip = $ip ?? Config::get('biovel.ip');
        $this->port = $port ?? Config::get('biovel.port');
    }

    /**
     * Membuka koneksi socket ke mesin fingerprint
     *
     * @return bool Berhasil atau tidak koneksi
     *
     * @throws Exception Jika gagal membuka koneksi
     */
    public function connect(): bool
    {
        // Jika sudah terkoneksi, return true
        if ($this->isConnected()) {
            return true;
        }

        // Coba membuka koneksi socket
        $socket = @fsockopen($this->ip, $this->port, $errno, $errstr, 5);

        if ($socket === false) {
            throw new Exception("Gagal terhubung ke mesin fingerprint: {$errstr} ({$errno})");
        }

        $this->socket = $socket;

        return true;
    }

    /**
     * Menutup koneksi socket
     */
    public function disconnect(): void
    {
        if ($this->socket !== null) {
            fclose($this->socket);
            $this->socket = null;
        }
    }

    /**
     * Cek apakah koneksi socket masih terbuka
     */
    public function isConnected(): bool
    {
        return $this->socket !== null && get_resource_type($this->socket) === 'stream';
    }

    /**
     * Mengambil data absensi dari mesin fingerprint
     *
     * @return array Data absensi
     */
    public function getAttendance(): array
    {
        // Untuk implementasi awal, kita gunakan data dummy
        // TODO: Implementasi protokol ZKTeco yang sebenarnya

        // Pastikan terkoneksi dulu
        if (! $this->isConnected()) {
            $this->connect();
        }

        // Data dummy untuk contoh
        return [
            [
                'user_id' => 101,
                'name' => 'Budi Santoso',
                'timestamp' => '2024-10-01 08:05:23',
                'status' => 'check-in',
            ],
            [
                'user_id' => 102,
                'name' => 'Dewi Anjani',
                'timestamp' => '2024-10-01 08:15:42',
                'status' => 'check-in',
            ],
            [
                'user_id' => 103,
                'name' => 'Ahmad Riyadi',
                'timestamp' => '2024-10-01 17:02:15',
                'status' => 'check-out',
            ],
            [
                'user_id' => 101,
                'name' => 'Budi Santoso',
                'timestamp' => '2024-10-01 17:30:05',
                'status' => 'check-out',
            ],
        ];
    }

    /**
     * Destruktor untuk menutup koneksi saat objek dihapus
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}
