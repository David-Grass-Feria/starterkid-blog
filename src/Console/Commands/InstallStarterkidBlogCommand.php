<?php

namespace GrassFeria\StarterkidBlog\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\UniqueConstraintViolationException;

class InstallStarterkidBlogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starterkid-blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the StarterkidBlog Plugin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
       
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('vendor:publish', ['--provider'=> 'GrassFeria\StarterkidBlog\Providers\AppServiceProvider','--force' => true]);
            
            //try {
            //Artisan::call('db:seed', ['class'=> 'GrassFeria\\StarterkidBlog\\Database\\Seeders\\BlogPostSeeder']);
            //}catch(UniqueConstraintViolationException){
            //    $this->info('success');
            //}

            return $this->info('GREAT! StarterkidBlog INSTALLED..');
       
        
       
    }

    

    
}
