<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class ImportSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synolia:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import subscribers from csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file_path = storage_path('app/subscribers_large.csv');
        $csv = Reader::createFromPath($file_path);
        $csv->setHeaderOffset(0);
        $chunks = collect($csv)->chunk(600);
        $inserts_count = count($csv / 600);
        $bar = $this->output->createProgressBar($inserts_count);
        $bar->start();
        foreach ($chunks as $chunk) {
            DB::table('subscribers')->insert($chunk->toArray());
            $bar->advance();
        }

        $this->info(' The command was successful!');
        return 0;
    }
}
