<?php

namespace Appstract\Opcache\Commands;

use Illuminate\Console\Command;
use Appstract\Opcache\CreatesRequest;
use Appstract\LushHttp\Exception\LushRequestException;

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
    protected $description = 'Clear the opcode cache';

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
                $this->info('Opcode cache cleared');
            } else {
                $this->line('Opcode cache: Nothing to clear');
            }
        } catch (LushRequestException $e) {
            $this->error($e->getMessage());
            $this->error('Url: '.$e->getRequest()->getUrl());
        }
    }
}
