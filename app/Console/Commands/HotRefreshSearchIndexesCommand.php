<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class HotRefreshSearchIndexesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:hot_refresh_search_indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Полностью сбрасывает и создает все данные для поиска';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $indexes = config('project_elastic_indexes');
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

//        $out->writeln("----------------------RE-RUN----------------------------------");
//        $out->writeln("Reset and re-run all migrations: " . config('scout.prefix'));
//        Artisan::call('elastic:migrate:reset');
//        Artisan::call('elastic:migrate');
//        $out->writeln("------------------------------------------------------------");

        $out->writeln("----------------------IMPORT---------------------------------");
        foreach ($indexes as $indexData) {
            $this->import($indexData);
            $out->writeln("Импортнул данные для индекса:" . $indexData['target_index']);
        }
        $out->writeln("------------------------------------------------------------");

    }

    /**
     * Импортирует данные в эластик.
     *
     * @param array $indexData
     * @author Rishat Sultanov
     */
    private function import(array $indexData)
    {
        Artisan::call('scout:import', [
            'model' => $indexData['model'],
        ]);
    }
}
