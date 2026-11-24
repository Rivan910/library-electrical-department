<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Commands & Scheduler - Library Electrical P611
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkronisasi Dokumen Library Electrical P611 dari Google Sheets setiap 1 menit.
Schedule::command('sheets:sync-library')
    ->everyMinute()
    ->withoutOverlapping()
    ->environments(['local', 'production'])
    ->appendOutputTo(storage_path('logs/library-sync.log'));
