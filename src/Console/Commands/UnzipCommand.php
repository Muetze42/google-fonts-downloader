<?php

namespace NormanHuth\GoogleFontDownloader\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use ZipArchive;

class UnzipCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unzip  {--delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unzip downloaded fonts';

    /**
     * The Filesystem instance
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $fontDirectory = __DIR__.'/../../../fonts';
        $this->filesystem = new Filesystem;

        $this->handleFolder($fontDirectory);

        return SymfonyCommand::SUCCESS;
    }

    /**
     * @param string $directory
     * @return void
     */
    protected function handleFolder(string $directory): void
    {
        $directory = realpath($directory);

        $files = $this->filesystem->files($directory);
        if (count($files)) {
            $this->handleFiles($files, $directory);
        }

        $directories = $this->filesystem->directories($directory);
        foreach ($directories as $directory) {
            $this->handleFolder($directory);
        }
    }

    /**
     * @param array $files
     * @param string $directory
     * @return void
     */
    protected function handleFiles(array $files, string $directory): void
    {
        foreach ($files as $file) {
            $file = realpath($file);
            $mime = $this->filesystem->mimeType($file);
            if ($mime == 'application/zip') {
                $this->info('Unzip '.$this->filesystem->basename($file));
                $zip = new ZipArchive;
                if ($zip->open($file) === true) {
                    $zip->extractTo($directory.'/'.$this->filesystem->name($file).'/');
                    $zip->close();

                    if ($this->option('delete')) {
                        $this->error('Delete '.$this->filesystem->basename($file));
                        $this->filesystem->delete($file);
                    }
                }
            }
        }
    }
}
