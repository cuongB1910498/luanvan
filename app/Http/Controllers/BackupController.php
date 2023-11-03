<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Tasks\Backup\BackupJob;

class BackupController extends Controller
{
    public function backupDatabase()
    {
        $backupJob = new BackupJob();
        $backupJob->run();

        $this->dispatch($backupJob);

        return 'Sao lưu cơ sở dữ liệu đã được khởi động.';
    }
}

