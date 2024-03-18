<?php

namespace GrassFeria\StarterkidBlog\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use GrassFeria\StarterkidBlog\Console\Commands\InstallStarterkidBlogCommand;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->mergeConfigFrom(
            __DIR__.'/../../config/starterkid-blog.php', 'starterkid-blog'
        );
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        
        
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'starterkid-blog');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../lang');
        Livewire::component('starterkid-blog::blog-post-create',\GrassFeria\StarterkidBlog\Livewire\BlogPost\BlogPostCreate::class);
        Livewire::component('starterkid-blog::blog-post-edit',\GrassFeria\StarterkidBlog\Livewire\BlogPost\BlogPostEdit::class);
        Livewire::component('starterkid-blog::blog-post-index',\GrassFeria\StarterkidBlog\Livewire\BlogPost\BlogPostIndex::class);
        Livewire::component('starterkid-blog::front-blog-post-index',\GrassFeria\StarterkidBlog\Livewire\Front\BlogPost\FrontBlogPostIndex::class);
        Livewire::component('starterkid-blog::front-blog-post-show',\GrassFeria\StarterkidBlog\Livewire\Front\BlogPost\FrontBlogPostShow::class);

       
        $this->publishes([
            __DIR__.'/../../stubs' => base_path('/'),
        ], 'starterkid-blog');



        // commands
        $this->commands([
            InstallStarterkidBlogCommand::class,
            
        ]);

        // scheduler
        //$this->app->booted(function () {
        //    $schedule = $this->app->make(Schedule::class);
        //    $schedule->command('backup:run')->everyFiveMinutes();
        //    
        //});

        

        $this->app->config->set('filesystems.disks.ckimage', [
            'driver' => 'local',
            'root' => storage_path('app/public/ckimages'),
            'url' => env('APP_URL').'/storage/ckimages',
            'visibility' => 'public',
            'throw' => false,
           ]);
        


       
    }
}