@if(request()->query())
<x-slot:robots>noindex,follow</x-slot>
@else
<x-slot:robots>index,follow</x-slot>
@endif
<x-slot:title>{{config('starterkid-blog.blog_post_title')}}</x-slot>


<x-slot:description>{{config('starterkid-blog.blog_post_description')}}</x-slot>

<div>
    @include('starterkid-frontend::header')
    

<x-starterkid-frontend::card>
    <x-starterkid-frontend::card-header heading="{{config('starterkid-blog.blog_post_title')}}" description="{{config('starterkid-blog.blog_post_description')}}" />
      
    <x-starterkid-frontend::wrapper>
    
        <x-slot name="header">
            <x-starterkid::starterkid.input wire:model.live.debounce.600ms="search" id="search" type="search" placeholder="{{__('Search')}}" class="w-full xl:w-1/4"/>
        </x-slot>
        <x-slot name="paginationLinks">
            {{$blogposts->links()}}
        </x-slot>
    
       
                
                <x-starterkid-frontend::card-grid>
                @foreach($blogposts as $blogpost)
               <x-starterkid-frontend::card-grid-blogpost-item 
               imgSrc="{{$blogpost->getFirstMediaUrl('images', 'medium')}}" 
               imgAlt="{{$blogpost->name}}" 
               imgCredits="{{$blogpost->image_credits}}" 
               dateTime="{{$blogpost->getPublished()}}" 
               author="{{$blogpost->author}}" 
               heading="{{$blogpost->name}}" 
               preview="{!!Str::limit($blogpost->preview,200)!!}" 
               href="{{route('front.blog-post.show',$blogpost->slug)}}" 
               hrefTitle="{{$blogpost->name}}" />
                @endforeach
                
              </x-starterkid-frontend::card-grid>

                 
         
          
          

   
   
      
    </x-starterkid-frontend::wrapper>
 
</x-starterkid-frontend::card>


    
    @include('starterkid-frontend::footer',['services' => $services])
</div>