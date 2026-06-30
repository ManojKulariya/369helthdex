<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class HourlyUpdate extends Command

{


   //protected $signature = 'command:name';
   protected $signature = 'hour:update';



   protected $description = 'Command description';



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

    //   Log::info('Record updated successfully.');

   }

}