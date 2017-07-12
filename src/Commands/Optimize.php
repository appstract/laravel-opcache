<?php

namespace Appstract\Opcache\Commands;

use Illuminate\Console\Command;
use Appstract\Opcache\CreatesRequest;
use Appstract\LushHttp\Exception\LushRequestException;

class Optimize extends Command
{
    use CreatesRequest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'opcache:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre-compile your application code';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->line('Optimize started, this can take a while...');

            $response = $this->sendRequest('optimize');

            if ($response->result) {
                $this->info(sprintf('%s of %s files optimized', $response->result->compiled_count, $response->result->total_files_count));
            } else {
                $this->error('No OPcache information available');
            }
        } catch (LushRequestException $e) {
            $this->error($e->getMessage());
            $this->error('Url: '.$e->getRequest()->getUrl());
        }
    }
}
