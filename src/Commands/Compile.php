<?php

namespace Appstract\Opcache\Commands;

use Illuminate\Console\Command;
use Appstract\Opcache\CreatesRequest;
use Appstract\LushHttp\Exception\LushRequestException;

class Compile extends Command
{
    use CreatesRequest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'opcache:compile {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre-compile your application code';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try {
            $this->line('Compiling scripts...');

            $response = $this->sendRequest('compile', ['force' => $this->option('force') ?? false]);

            if (isset($response->result->message)) {
                $this->warn($response->result->message);
                return 1;
            }
            else if ($response->result) {
                $this->info(sprintf('%s of %s files compiled', $response->result->compiled_count, $response->result->total_files_count));
            } else {
                $this->error('OPcache not configured');
                return 2;
            }
        } catch (LushRequestException $e) {
            $this->error($e->getMessage());
            $this->error('Url: '.$e->getRequest()->getUrl());
            return $e->getCode();
        }
    }
}
