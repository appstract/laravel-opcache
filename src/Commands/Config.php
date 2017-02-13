<?php

namespace Appstract\Opcache\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class Config extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'opcache:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show your opcode cache configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $response = $client->get(config('app.url').'/opcache-api/config');
        $response = json_decode($response->getBody()->getContents());

        if ($response->result !== false) {
            $this->line('Version info:');
            $this->table(['key', 'value'], $this->parseTable($response->result->version));

            $this->line(PHP_EOL.'Configuration info:');
            $this->table(['option', 'value'], $this->parseTable($response->result->directives));
        } else {
            $this->error('No OPcache configuration found');
        }
    }

    /**
     * Make up the table for console display.
     *
     * @param $input
     *
     * @return array
     */
    protected function parseTable($input)
    {
        $input = (array) $input;

        return array_map(function ($key, $value) {
            return [
                'key'       => $key,
                'value'     => $value,
            ];
        }, array_keys($input), $input);
    }
}
