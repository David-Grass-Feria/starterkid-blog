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
    
        <div>
            <div class="mx-auto">
            
              <div class="mx-auto mt-5 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                
                
                @foreach($blogposts as $blogpost)
                <article class="flex flex-col items-start justify-between bg-white rounded-3xl border border-gray-400">
                  <div class="relative w-full">
                    @if (!empty($blogpost->getFirstMediaUrl('images', 'medium')))
                    <img src="{{$blogpost->getFirstMediaUrl('images','medium')}}" alt="{{$blogpost->name}}" class="w-full object-cover rounded-t-3xl aspect-[2/2] lg:aspect-[3/3]">
                    
                    @else
                    <img src="{{Cache::has('logo') ? Cache::get('logo') : asset('/logo.png')}}" alt="{{$blogpost->name}}" class="w-full object-contain rounded-t-3xl aspect-[2/2] lg:aspect-[3/3]">
                    @endif
                    
                    <x-starterkid-frontend::image-credits imageCredits="{{$blogpost->image_credits}}"/>
                  </div>
                  <div class="w-full text-font_primary p-3">
                    <div class="mt-8 flex items-center gap-x-4 text-xs">
                      <time datetime="{{$blogpost->getPublished()}}">{{$blogpost->getPublished()}}</time>
                      <p>{{$blogpost->author}}</p>
                    </div>
                    <div class="group relative">
                      <h3 class="mt-3 text-lg font-semibold">
                        <a href="{{route('front.blog-post.show',$blogpost->slug)}}">
                          <span class="absolute inset-0"></span>
                          {{$blogpost->name}}
                        </a>
                      </h3>
                      <p class="mt-5 line-clamp-3 text-sm">{!!Str::limit($blogpost->preview,200)!!}</p>
                    </div>
                   
                  </div>
                </article>
                @endforeach
                
                

                 
              </div>
            </div>
          </div>
          
          

   
   
      
    </x-starterkid-frontend::wrapper>
 
</x-starterkid-frontend::card>


    
    @include('starterkid-frontend::footer',['services' => $services])
</div>