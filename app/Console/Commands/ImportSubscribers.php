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
    protected $signature = 'synolia:import 
        { --chunks=600 : Ammount of chunks to divide the files for insert operation }
        { --filename=subscribers.csv : The name of the file in storage/app }    
    ';

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
        $filename = $this->option('filename');
        $file_path = storage_path('app/'.$filename);
        $csv = Reader::createFromPath($file_path);
        $csv->setHeaderOffset(0);

        $chunk_number = $this->option('chunks');
        $chunks = collect($csv)->chunk($chunk_number);

        $inserts_count = count($csv) / $chunk_number;
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
