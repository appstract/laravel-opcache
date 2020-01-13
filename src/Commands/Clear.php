<?php

namespace Appstract\Opcache\Commands;

use Appstract\LushHttp\Exception\LushRequestException;
use Appstract\Opcache\CreatesRequest;
use Illuminate\Console\Command;

class Clear extends Command
{
    use CreatesRequest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'opcache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear OPCache';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $response = $this->sendRequest('clear');

            if ($response->result === true) {
                $this->info('OPcache cleared');
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
