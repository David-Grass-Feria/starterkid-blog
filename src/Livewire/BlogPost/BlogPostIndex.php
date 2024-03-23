<?php

namespace GrassFeria\StarterkidBlog\Livewire\BlogPost;


use Livewire\Component;
use GrassFeria\Starterkid\Traits\LivewireIndexTrait;


class BlogPostIndex extends Component
{

    use LivewireIndexTrait;


    public function mount()
    {
        $this->authorize('viewAny',\GrassFeria\StarterkidBlog\Models\BlogPost::class);
    }

    public function destroyRecords()
    {
        
        foreach ($this->selected as $recordId) {
            $findRecord = \GrassFeria\StarterkidBlog\Models\BlogPost::find($recordId);
            $this->authorize('delete',[\GrassFeria\StarterkidBlog\Models\BlogPost::class,$findRecord]);
            \GrassFeria\Starterkid\Jobs\SpatieMediaLibary\DeleteMediaCollection::dispatch($findRecord,'images');
            \GrassFeria\Starterkid\Jobs\SpatieMediaLibary\DeleteMediaCollection::dispatch($findRecord,'ckimages');
            $findRecord->delete();

        }

        $this->selected = [];


    }


    public function render()
    {

      
        $blogposts = \GrassFeria\StarterkidBlog\Models\BlogPost::query()
        ->select('id','user_id','name','created_at','status','slug','author','image_credits')
        ->where('id','like','%'.$this->search.'%')
        ->orWhere('name','like','%'.$this->search.'%')
        ->orderBy($this->orderBy, $this->sort)
        ->paginate($this->perPage);

        return view('starterkid-blog::livewire.blog-post.blog-post-index',['blogposts' => $blogposts]);

        
    }
}
