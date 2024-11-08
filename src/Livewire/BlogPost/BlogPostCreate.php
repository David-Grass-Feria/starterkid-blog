<?php

namespace GrassFeria\StarterkidBlog\Livewire\BlogPost;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class BlogPostCreate extends Component
{
    use WithFileUploads;

    public $blogpost;
    public $name;
    public $title;
    public $content;
    public $created_at;
    public $status = true;
    public $slug;
    public $preview;
    public $author;
    public $image_credits;
    public $public_images = [];
    
    



    public function mount($recordId = null)
    {
        
        $this->authorize('create',\GrassFeria\StarterkidBlog\Models\BlogPost::class);
        $this->created_at                              = now()->format(config('starterkid.time_format.date_time_format_for_picker'));
        
        
        
    }

    public function updated($name)
    {
        $this->slug = Str::slug($this->name);
        $this->title = ucfirst($this->name);
    }

    public function save()
    {


        $validated = $this->validate([
            'name'                      => 'required|string',
            'slug'                      => 'required|string|unique:blog_posts',
            'title'                     => 'required|string',
            'content'                   => 'required|string',
            'preview'                   => 'nullable|string',
            'created_at'                 => 'required|date_format:' . config('starterkid.time_format.date_time_format_for_picker'),
            'status'                    => 'required|boolean',
            'author'                    => 'required|string',
            'image_credits'             => 'nullable|string',
           
        ]);
        
        
        $this->authorize('create',\GrassFeria\StarterkidBlog\Models\BlogPost::class);
        $validated = array_merge($validated, ['user_id' => auth()->user()->id]);
        $this->blogpost = \GrassFeria\StarterkidBlog\Models\BlogPost::create($validated);
        
        if ($this->public_images !== []) {
        \GrassFeria\Starterkid\Jobs\SpatieMediaLibary\DeleteMediaCollection::dispatch($this->blogpost,'images');
        (new \GrassFeria\Starterkid\Services\SpatieMediaLibary\SaveMediaWithFilenameService($this->public_images,$this->blogpost,'images','public',$this->title));
        
        }
        
        (new \GrassFeria\Starterkid\Services\CheckCkEditorContent($this->blogpost->content,'content'))->checkForCkEditorImages($this->blogpost,'ckimages','ckimage');
        return redirect()->route('blogposts.index')->with('success', __('BlogPost created'));

    }

    public function removeFile($fileId)
    {
       
        // delete files if click delete button on filepond form
        
        // public_images
         Storage::delete('livewire-tmp'.'/'.$fileId);
         foreach($this->public_images as $key => $file){
           if($file->getFilename() == $fileId){
             unset($this->public_images[$key]);
           }
         }

        

         // more here
 
    }


    public function render()
    {
        
        $authors = \App\Models\User::query()->select('id','name','role')->where('role','editor')->orWhere('role','admin')->get();
        return view('starterkid-blog::livewire.blog-post.blog-post-create',['authors' => $authors]);
        
    }
}
