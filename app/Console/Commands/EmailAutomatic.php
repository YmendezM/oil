<?php

namespace App\Console\Commands;

use App\Http\Services\Gasolinera\AutomaticMailService;
use Illuminate\Console\Command;

class EmailAutomatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:automatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que consultara los reportes automaticos por enviar';

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
    public function handle()
    {
        (new AutomaticMailService())->consultSendMail();
    }
}
