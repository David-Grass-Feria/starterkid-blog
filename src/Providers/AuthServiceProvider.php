<?php

namespace GrassFeria\StarterkidBlog\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \GrassFeria\StarterkidBlog\Models\BlogPost::class => \GrassFeria\StarterkidBlog\Policies\BlogPostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}