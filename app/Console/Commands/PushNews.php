<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\NewsRepository as rNews;


class PushNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate data by articles';

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
     * @return mixed
     */
    public function handle(rNews $parsing)
    {

        $parsing->parserStart();

        $this->info('The generate ended');
    }
}
