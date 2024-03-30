<?php

use Illuminate\Support\Facades\Route;
use \GrassFeria\StarterkidBlog\Livewire\BlogPost\BlogPostEdit;
use \GrassFeria\StarterkidBlog\Livewire\BlogPost\BlogPostIndex;
use \GrassFeria\StarterkidBlog\Livewire\BlogPost\BlogPostCreate;
use GrassFeria\StarterkidBlog\Livewire\Front\BlogPost\FrontBlogPostShow;
use GrassFeria\StarterkidBlog\Livewire\Front\BlogPost\FrontBlogPostIndex;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web'])->group(function () {
   
    Route::get(config('starterkid-blog.blog_post_slug'),FrontBlogPostIndex::class)->name('front.blog-post.index')->middleware(['minify']);
    Route::get(config('starterkid-blog.blog_post_slug').'/{slug}',FrontBlogPostShow::class)->name('front.blog-post.show')->middleware(['minify','cache']);
  

   
   

});




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   
    Route::get('/dashboard/blog',BlogPostIndex::class)->name('blogposts.index');
    Route::get('/dashboard/blog/create',BlogPostCreate::class)->name('blogposts.create');
    Route::get('/dashboard/blog/edit/{recordId}',BlogPostEdit::class)->name('blogposts.edit');

    


   
});