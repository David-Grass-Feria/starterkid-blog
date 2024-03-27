<?php

namespace GrassFeria\StarterkidBlog\Livewire\Front\BlogPost;



use Livewire\Component;
use Livewire\Attributes\Layout;

use GrassFeria\Starterkid\Traits\LivewireIndexTrait;



class FrontBlogPostIndex extends Component
{

   
   use LivewireIndexTrait;

   public $robots;

  
    #[Layout('starterkid-frontend::components.layouts.front')]
    public function render()
    {
     
      $blogposts = \GrassFeria\StarterkidBlog\Models\BlogPost::frontGetBlogPostWhereStatusIsOnline($this->search,$this->orderBy, $this->sort)->simplePaginate(config('starterkid-blog.blog_post_pagination'));
    
      $services = \GrassFeria\StarterkidService\Models\Service::frontGetServicesWhereStatusIsOnline()->get();
    

      return view('starterkid-blog::livewire.front.blog-post.front-blog-post-index',['services' => $services,'blogposts' => $blogposts]);

        
    }
}
