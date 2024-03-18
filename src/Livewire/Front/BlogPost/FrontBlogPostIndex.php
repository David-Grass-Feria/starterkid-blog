<?php

namespace GrassFeria\StarterkidBlog\Livewire\Front\BlogPost;


use Livewire\Component;
use Livewire\Attributes\Layout;
use GrassFeria\Starterkid\Traits\LivewireIndexTrait;



class FrontBlogPostIndex extends Component
{

   
   use LivewireIndexTrait;
  
  
    #[Layout('starterkid-frontend::components.layouts.front')]
    public function render()
    {
     
      $blogposts = \GrassFeria\StarterkidBlog\Models\BlogPost::frontGetBlogPostWhereStatusIsOnline($this->search,$this->orderBy, $this->sort)->get();
      $services = \GrassFeria\StarterkidService\Models\Service::frontGetServicesWhereStatusIsOnline($this->search,$this->orderBy, $this->sort)->get();
      return view('starterkid-blog::livewire.front.blog-post.front-blog-post-index',['services' => $services,'blogposts' => $blogposts]);

        
    }
}