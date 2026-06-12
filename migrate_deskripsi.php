<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Room::all() as $room) {
    $val = $room->getAttributes()['deskripsi'];
    if (!empty($val) && !str_starts_with($val, '{')) {
        $room->deskripsi = json_encode([
            'tipe_kamar' => $val,
            'teks_deskripsi' => ''
        ]);
        $room->save();
        echo "Migrated room {$room->no_kamar}\n";
    }
}
echo "Done.\n";
