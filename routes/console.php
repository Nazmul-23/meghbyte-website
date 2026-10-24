<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('meghbyte:about', function () {
    $this->info('Meghbyte website — websites, mobile apps and management software.');
})->purpose('Show app info');
