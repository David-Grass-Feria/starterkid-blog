<?php

namespace GrassFeria\StarterkidBlog\Livewire\BlogPost;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class BlogPostEdit extends Component
{
    use WithFileUploads;

    public $blogpost;
    public $name;
    public $title;
    public $content;
    public $created_at;
    public $status = false;
    public $preview;
    public $author;
    public $public_images = [];
    public $image_credits;
    
    



    public function mount($recordId = null)
    {
        
       
        $this->blogpost       = \GrassFeria\StarterkidBlog\Models\BlogPost::find($recordId);
      
        $this->authorize('update',[\GrassFeria\StarterkidBlog\Models\BlogPost::class,$this->blogpost]);
        $this->name                             = $this->blogpost->name;
        $this->title                            = $this->blogpost->title;
        $this->content                          = $this->blogpost->content;
        $this->preview                          = $this->blogpost->preview;
        $this->created_at                        = $this->blogpost->created_at->format(config('starterkid.time_format.date_time_format_for_picker'));
        $this->status                           = $this->blogpost->status;
        $this->author                           = $this->blogpost->author;
        $this->image_credits                    = $this->blogpost->image_credits;

       
    }

    public function save()
    {


        $validated = $this->validate([
            'name'                      => 'required|string',
            'title'                     => 'required|string',
            'content'                   => 'required|string',
            'preview'                   => 'nullable|string',
            'created_at'                 => 'required|date_format:' . config('starterkid.time_format.date_time_format_for_picker'),
            'status'                    => 'required|boolean',
            'author'                    => 'required|string',
            'image_credits'             => 'nullable|string',
           
        ]);
        
       
        $this->authorize('update',[\GrassFeria\StarterkidBlog\Models\BlogPost::class,$this->blogpost]);
        $validated = array_merge($validated, ['user_id' => auth()->user()->id]);
        $this->blogpost->update($validated);
       

        if ($this->public_images !== []) {
            \GrassFeria\Starterkid\Jobs\SpatieMediaLibary\DeleteMediaCollection::dispatch($this->blogpost,'images');
            (new \GrassFeria\Starterkid\Services\SpatieMediaLibary\SaveMediaWithFilenameService($this->public_images,$this->blogpost,'images','public',$this->title));
            
        }
        
        (new \GrassFeria\Starterkid\Services\CheckCkEditorContent($this->blogpost->content,'content'))->checkForCkEditorImages($this->blogpost,'ckimages','ckimage');
        return redirect()->route('blogposts.index')->with('success', __('BlogPost updated'));

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
        return view('starterkid-blog::livewire.blog-post.blog-post-edit',['authors' => $authors]);
        
    }
}
