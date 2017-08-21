<?php

namespace shopTest\Console\Commands;

use Illuminate\Console\Command;
use DB;
use shopTest\Mail\ProductImport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class mystore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mystore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command mannager store';

    protected $files_import;
    protected $files_imported = array();

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // $this->namefile = $name_file;
    }

    public function importproducts($files,$bar){ 

        foreach($files as $file_name)   {
            if(Storage::disk('local')->exists($file_name))
            {
                $this->line(storage_path($file_name));
                if (($handle = fopen(storage_path("app/".$file_name),"r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if ($data[0]) {
                            DB::table('products')->insert([
                                'name'          => addslashes($data[0]), 
                                'description'   => addslashes($data[1]),
                                'price'         => number_format($data[2],2),
                                'quantity'      => intval($data[3]),
                                'created_at'    => date("Y-m-d h:i:s") 
                                ]);                    
                        }
                    }
                    $name = explode(".",$file_name);
                    array_pop($name);
                    $name = implode($name);
                    $name = basename($name)."_imported";
                    Storage::move($file_name, '/import/product/'.$name.".csv");
                    $this->files_imported[] = $name.".csv";
                    $bar->advance();
                }
            }
        }
    
        
        //marcar os arquivos como lidos
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$email_warning = $this->ask("What email should be warned, when us finished ?","carinaberri@gmail.com");
        /** 
         *  Ler os arquivos da pasta
         *  pegar todos os que não foram lidos
         */
        
        $files          = Storage::allFiles("/import/product/");
        $files_import   = array();
        if(count($files)>0)
        {
            foreach ($files as $file){
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if($ext == "csv" && (preg_match('/imported/', $file) == 0)){
                    $files_import[] =  $file;
                }
            }    
        } 

        if(count($files_import) == 0){
            $this->error('I\'m not found nothing file');
        }   
        $this->line(strpos("basename","test"));
        
        $bar = $this->output->createProgressBar(count($files_import));
        $this->importproducts($files_import,$bar);
        if(count($this->files_imported)>0){
            $email_warning = env(MAIL_TO_IMPORT);
            Mail::to($email_warning)->send(new ProductImport(implode("<br/>",$this->files_imported)));
        }
        
        $this->line('Import executed !!');
        $bar->finish();
        $this->line('');
        //verify if the email exist
    }
}
