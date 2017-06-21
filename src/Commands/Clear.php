<?php

namespace Appstract\Opcache\Commands;

use Appstract\LushHttp\Exception\LushRequestException;
use Illuminate\Console\Command;
use Appstract\LushHttp\LushFacade as Lush;

class Clear extends Command
{
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
            $response = Lush::get(config('opcache.url').'/opcache-api/clear');

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
