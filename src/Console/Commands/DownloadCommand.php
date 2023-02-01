<?php

namespace NormanHuth\GoogleFontDownloader\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class DownloadCommand  extends Command
{
    /**
     * Base API url
     *
     * @var string
     */
    protected string $apiUrl = 'https://gwfh.mranftl.com/api/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Download Google Fonts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $filesystem = new Filesystem;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl.'fonts/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $fonts = json_decode($response, true);
        foreach ($fonts as $font) {
            /* @var array{id: string, family: string, variants: array, subsets: array, category: string, version: string, lastModified: string, popularity: int, defSubset: string, defVariant: string} $font */
            $this->info('Downloading „'.$font['family'].'“ '.$font['version']);
            //sleep(1);
            usleep(300000);

            $targetDir = __DIR__.'/../../../fonts/'.$font['category'];
            //$filename = $font['family'].'-'.$font['version'].'-'.$font['defSubset'];
            $filename = $font['family'];

            if (!$filesystem->isDirectory($targetDir)) {
                $filesystem->makeDirectory($targetDir);
            }
            $zip = file_get_contents('https://gwfh.mranftl.com/api/fonts/'.$font['id'].'?download=zip');
            $filesystem->put($targetDir.'/'.$filename.'.zip', $zip);
        }

        return SymfonyCommand::SUCCESS;
    }
}
