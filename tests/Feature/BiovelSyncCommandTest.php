<?php

use AKM\Biovel\Biovel;
use Illuminate\Support\Facades\Artisan;

class FakeBiovel
{
    public function connect(): bool
    {
        return true;
    }
    
    public function getAttendance(): array
    {
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
        ];
    }
}

class FailingBiovel
{
    public function connect(): bool
    {
        throw new \Exception('Koneksi gagal');
    }
    
    public function getAttendance(): array
    {
        return [];
    }
}

test('command biovel:sync dapat dijalankan dengan sukses', function () {
    // Bind fake implementation ke container
    $this->app->instance('biovel', new FakeBiovel());
    $this->app->instance(Biovel::class, new FakeBiovel());
    
    // Jalankan perintah artisan
    $result = Artisan::call('biovel:sync');
    
    // Periksa bahwa perintah berhasil (mengembalikan kode 0)
    expect($result)->toBe(0);
});

test('command biovel:sync menampilkan output yang benar', function () {
    // Bind fake implementation ke container
    $this->app->instance('biovel', new FakeBiovel());
    $this->app->instance(Biovel::class, new FakeBiovel());
    
    // Jalankan command dan periksa outputnya
    $this->artisan('biovel:sync')
        ->expectsOutputToContain('Mulai sinkronisasi data absensi...')
        ->expectsOutputToContain('Menghubungkan ke mesin fingerprint...')
        ->expectsOutputToContain('Mengambil data absensi...')
        ->expectsOutputToContain('Data absensi berhasil diambil:')
        ->expectsOutputToContain('Budi Santoso')
        ->expectsOutputToContain('Dewi Anjani')
        ->expectsOutputToContain('Sinkronisasi selesai!')
        ->assertSuccessful();
});

test('command biovel:sync menampilkan pesan error jika koneksi gagal', function () {
    // Bind failing implementation ke container
    $this->app->instance('biovel', new FailingBiovel());
    $this->app->instance(Biovel::class, new FailingBiovel());
    
    // Jalankan perintah dan periksa output error
    $this->artisan('biovel:sync')
        ->expectsOutputToContain('Gagal sinkronisasi: Koneksi gagal')
        ->assertFailed();
}); 