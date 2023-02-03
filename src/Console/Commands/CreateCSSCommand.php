<?php

namespace NormanHuth\GoogleFontDownloader\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CreateCSSCommand extends UnzipCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:css';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CSS file for each font';

    /**
     * @param array $files
     * @param string $directory
     * @throws FileNotFoundException
     * @return void
     */
    protected function handleFiles(array $files, string $directory): void
    {
        $css = '';
        foreach ($files as $file) {
            if ($this->filesystem->extension($file) == 'woff') {
                $family = $this->filesystem->basename($directory);
                $fileName = $this->filesystem->name($file);
                $type = explode('-', $fileName);
                $type = end($type);
                $style = str_contains($type, 'italic') ? 'italic' : 'regular';
                $weight = preg_replace('/\D/', '', $type);
                if (empty($weight)) {
                    $weight = 400;
                }
                $content = $this->filesystem->get(__DIR__.'/../../../stubs/font-face.stub');
                $replace = [
                    '{family}'   => $family,
                    '{style}'    => $style,
                    '{weight}'   => $weight,
                    '{filename}' => $fileName,
                ];
                $content = str_replace(array_keys($replace), array_values($replace), $content);
                if ($css) {
                    $css.="\n";
                }
                $css.=$content;
            }
        }
        $this->filesystem->put($directory.'/font.css', $css);
    }
}
