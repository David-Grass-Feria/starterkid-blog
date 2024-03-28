<?php

namespace GrassFeria\StarterkidBlog\Livewire\Front\BlogPost;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;


#[Lazy]
class FrontBlogPostShow extends Component
{

   public $service;
   public $blogpost; 
   
   public function mount($slug)
   {
      
      $this->blogpost = \GrassFeria\StarterkidBlog\Models\BlogPost::where('slug',$slug)->firstOrFail();
      
   }
  
  
    #[Layout('starterkid-frontend::components.layouts.front')] 
    public function render()
    {
     
      $services =\GrassFeria\StarterkidService\Models\Service::frontGetServicesWhereStatusIsOnline()->get();
      return view('starterkid-blog::livewire.front.blog-post.front-blog-post-show',['services' => $services]);

        
    }
}
