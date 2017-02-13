<?php

namespace Appstract\Opcache\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class Optimize extends Command
{
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
    protected $description = 'Pre-compile your application code (experimental)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Optimize started, this can take a while...');

        $client = new Client();
        $response = $client->get(config('app.url').'/opcache-api/optimize');
        $response = json_decode($response->getBody()->getContents());

        if ($response->result) {
            $this->info(sprintf('%s of %s files optimized', $response->result->compiled_count, $response->result->total_files_count));
        } else {
            $this->error('No opcode information available');
        }
    }
}
