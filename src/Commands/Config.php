<?php

namespace Appstract\Opcache\Commands;

use Illuminate\Console\Command;
use Appstract\Opcache\CreatesRequest;
use Appstract\LushHttp\Exception\LushRequestException;

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
    protected $description = 'Show your opcode cache configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $response = $this->sendRequest('config');

            if ($response->result) {
                $this->line('Version info:');
                $this->table(['key', 'value'], $this->parseTable($response->result->version));

                $this->line(PHP_EOL.'Configuration info:');
                $this->table(['option', 'value'], $this->parseTable($response->result->directives));
            } else {
                $this->error('No OPcache configuration found');
            }
        } catch (LushRequestException $e) {
            $this->error($e->getMessage());
            $this->error('Url: '.$e->getRequest()->getUrl());
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
            $bytes = ['opcache.memory_consumption'];

            if (in_array($key, $bytes)) {
                $value = number_format($value / 1048576, 2).' MB';
            }

            return [
                'key'       => $key,
                'value'     => $value,
            ];
        }, array_keys($input), $input);
    }
}
