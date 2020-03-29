<?php

namespace Appstract\Opcache\Commands;

use Appstract\Opcache\CreatesRequest;
use Illuminate\Console\Command;

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
    protected $description = 'Show OPcache status';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $response = $this->sendRequest('status');
        $response->throw();

        if ($response['result']) {
            $this->displayTables($response['result']);
        } else {
            $this->error('OPcache not configured');

            return 2;
        }
    }

    /**
     * Display info tables.
     *
     * @param $data
     */
    protected function displayTables($data)
    {
        $general = $data;

        foreach (['memory_usage', 'interned_strings_usage', 'opcache_statistics', 'preload_statistics'] as $unset) {
            unset($general[$unset]);
        }

        $this->table([], $this->parseTable($general));

        $this->line(PHP_EOL.'Memory usage:');
        $this->table([], $this->parseTable($data['memory_usage']));

        if (isset($data['opcache_statistics'])) {
            $this->line(PHP_EOL.'Statistics:');
            $this->table([], $this->parseTable($data['opcache_statistics']));
        }

        if (isset($data['interned_strings_usage'])) {
            $this->line(PHP_EOL.'Interned strings usage:');
            $this->table([], $this->parseTable($data['interned_strings_usage']));
        }

        if (isset($data['preload_statistics'])) {
            $this->line(PHP_EOL.'Preload statistics:');
            $this->table([], $this->parseTable($data['preload_statistics']));
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
        $bytes = ['used_memory', 'free_memory', 'wasted_memory', 'buffer_size'];
        $times = ['start_time', 'last_restart_time'];

        return array_map(function ($key, $value) use ($bytes, $times) {
            if (in_array($key, $bytes)) {
                $value = number_format($value / 1048576, 2).' MB';
            } elseif (in_array($key, $times)) {
                $value = date('Y-m-d H:i:s', $value);
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            return [
                'key' => $key,
                'value' => is_array($value) ? implode(PHP_EOL, $value) : $value,
            ];
        }, array_keys($input), $input);
    }
}
