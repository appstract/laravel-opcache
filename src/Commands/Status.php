<?php

namespace Appstract\Opcache\Commands;

use Illuminate\Console\Command;
use Appstract\Opcache\CreatesRequest;
use Appstract\LushHttp\Exception\LushRequestException;

class Status extends Command
{
    use CreatesRequest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'opcache:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show state information, memory usage, etc..';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $response = $this->sendRequest('status');

            if ($response->result) {
                $this->displayTables($response->result);
            } else {
                $this->error('No OPcache status information available');
            }
        } catch (LushRequestException $e) {
            $this->error($e->getMessage());
            $this->error('Url: '.$e->getRequest()->getUrl());
        }
    }

    /**
     * Display info tables.
     *
     * @param $data
     */
    protected function displayTables($data)
    {
        $this->line('General:');
        $general = (array) $data;
        unset($general['memory_usage'], $general['interned_strings_usage'], $general['opcache_statistics']);
        $this->table(['key', 'value'], $this->parseTable($general));

        $this->line(PHP_EOL.'Memory usage:');
        $this->table(['key', 'value'], $this->parseTable($data->memory_usage));

        $this->line(PHP_EOL.'Interned strings usage:');
        $this->table(['key', 'value'], $this->parseTable($data->interned_strings_usage));

        $this->line(PHP_EOL.'Statistics:');
        $this->table(['option', 'value'], $this->parseTable($data->opcache_statistics));
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
            $bytes = ['used_memory', 'free_memory', 'wasted_memory', 'buffer_size'];
            $times = ['start_time', 'last_restart_time'];

            if (in_array($key, $bytes)) {
                $value = number_format($value / 1048576, 2).' MB';
            } elseif (in_array($key, $times)) {
                $value = date('Y-m-d H:i:s', $value);
            }

            return [
                'key'       => $key,
                'value'     => $value,
            ];
        }, array_keys($input), $input);
    }
}
