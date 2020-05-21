<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Console\Command;

class ZahperCreateDemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zahper:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffolds a zahper mailable for you to use';

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
        $this->info("
  _____       _
 |__  / __ _ | |__   _ __    ___  _ __
   / / / _` || '_ \ | '_ \  / _ \| '__|
  / /_| (_| || | | || |_) ||  __/| |
 /____|\__,_||_| |_|| .__/  \___||_|
                    |_|
            ");

        $path = app_path('Mail').DIRECTORY_SEPARATOR;

        // Check directory.
        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        // Read stub and copy file.

        $filePath = $path.'ZahperDemoMailable.php';

        $content = str_replace(
            'classname',
            'ZahperDemoMailable',
            file_get_contents(__DIR__.'/../resources/mailable-demo.stub.php')
        );

        file_put_contents($filePath, $content);

        $this->info('Created your Zahper demo in '.$path.'/ZahperDemoMailable.php');

        $this->info('');

        $this->info('You can check it out in '.route('zahper.demo'));
    }
}
