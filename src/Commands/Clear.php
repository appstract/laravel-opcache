<?php

namespace Appstract\Opcache\Commands;

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
        $response = Lush::get(config('app.url').'/opcache-api/clear');

        if ($response->result !== false) {
            $this->info('Opcode cache cleared');
        } else {
            $this->line('Opcode cache: Nothing to clear');
        }
    }
}
