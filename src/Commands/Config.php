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
    protected $description = 'Show your OPcache configuration';

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
                $this->table([], $this->parseTable($response->result->version));

                $this->line(PHP_EOL.'Configuration info:');
                $this->table([], $this->parseTable($response->result->directives));
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
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            return [
                'key'       => $key,
                'value'     => $value,
            ];
        }, array_keys($input), $input);
    }
}
