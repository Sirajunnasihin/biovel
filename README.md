# AKM BioVel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/akm/biovel.svg?style=flat-square)](https://packagist.org/packages/akm/biovel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/akm/biovel/phpstan.yml?branch=main&label=tests&style=flat-square)](https://github.com/akm/biovel/actions?query=workflow%3APHPStan+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/akm/biovel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/akm/biovel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/akm/biovel.svg?style=flat-square)](https://packagist.org/packages/akm/biovel)

Laravel package untuk berkomunikasi dengan mesin fingerprint seperti Solution X105 (ZKTeco Protocol) melalui koneksi TCP/IP (LAN).

## Fitur

- Koneksi ke mesin fingerprint melalui TCP/IP
- Pengambilan data absensi dari mesin
- Command Artisan untuk sinkronisasi data

## Instalasi

Kamu bisa menginstall package melalui composer:

```bash
composer require akm/biovel
```

Kemudian publish file konfigurasi dengan command:

```bash
php artisan vendor:publish --tag="biovel-config"
```

## Konfigurasi

Setelah publikasi konfigurasi, kamu bisa mengatur koneksi ke mesin fingerprint di file `config/biovel.php`.

Kamu juga bisa mengatur konfigurasi melalui environment variables di file `.env`:

```dotenv
FINGERPRINT_IP=192.168.1.201
FINGERPRINT_PORT=4370
```

## Penggunaan

### Basic Usage

```php
// Menggunakan Facade
use AKM\Biovel\Facades\Biovel;

// Koneksi ke mesin fingerprint
Biovel::connect();

// Mengambil data absensi
$attendanceData = Biovel::getAttendance();

// Menutup koneksi
Biovel::disconnect();
```

### Contoh Dalam Controller

```php
<?php

namespace App\Http\Controllers;

use AKM\Biovel\Facades\Biovel;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    public function sync(): JsonResponse
    {
        try {
            // Koneksi ke mesin fingerprint
            Biovel::connect();
            
            // Ambil data absensi
            $attendanceData = Biovel::getAttendance();
            
            // Proses data (simpan ke database, dll)
            // ...
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disinkronkan',
                'data' => $attendanceData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal sinkronisasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

### Command Artisan

Paket ini menyediakan command Artisan untuk melakukan sinkronisasi data:

```bash
php artisan biovel:sync
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [SirajunNasihin](https://github.com/sirajunnasihin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
