<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanChunkedUploads extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'uploads:clean-chunks {--hours=1 : Hours threshold for old files}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Clean up old chunked upload temporary files';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $hours = (int) $this->option('hours');
    $threshold = Carbon::now()->subHours($hours);

    // Get the chunks storage path (used by pion/laravel-chunk-upload)
    $chunksPath = storage_path('app/chunks');

    if (!File::exists($chunksPath)) {
      $this->info('No chunks directory found. Nothing to clean.');
      return 0;
    }

    $deletedCount = 0;
    $freedSpace = 0;

    // Get all files in chunks directory
    $files = File::allFiles($chunksPath);

    foreach ($files as $file) {
      $lastModified = Carbon::createFromTimestamp($file->getMTime());

      if ($lastModified->lt($threshold)) {
        $freedSpace += $file->getSize();
        File::delete($file->getPathname());
        $deletedCount++;

        $this->line("Deleted: {$file->getFilename()}");
      }
    }

    // Also clean empty directories
    $directories = File::directories($chunksPath);
    foreach ($directories as $directory) {
      if (count(File::allFiles($directory)) === 0) {
        File::deleteDirectory($directory);
        $this->line("Removed empty directory: " . basename($directory));
      }
    }

    $freedSpaceMB = round($freedSpace / 1024 / 1024, 2);
    $this->info("Cleanup complete. Deleted {$deletedCount} file(s), freed {$freedSpaceMB} MB.");

    return 0;
  }
}
