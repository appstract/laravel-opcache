<?php

namespace Appstract\Opcache\Commands;

use Appstract\Opcache\CreatesRequest;
use Illuminate\Console\Command;

class Config extends Command
{
    use CreatesRequest;

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
    protected $description = 'Show your OPcache configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $response = $this->sendRequest('config');
        $response->throw();

        if (! $response->successful()) {
            $this->error('OPcache not configured');

            return 2;
        }

        $this->line('Version info:');
        $this->table([], $this->parseTable($response['result']['version']));
        $this->line(PHP_EOL.'Configuration info:');
        $this->table([], $this->parseTable($response['result']['directives']));
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
                'value'     => $this->parseValue($key, $value),
            ];
        }, array_keys($input), $input);
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    protected function parseValue($key, $value)
    {
        if (in_array($key, ['opcache.memory_consumption'])) {
            return number_format($value / 1048576, 2).' MB';
        }

        return $value ? 'true' : 'false';
    }
}
