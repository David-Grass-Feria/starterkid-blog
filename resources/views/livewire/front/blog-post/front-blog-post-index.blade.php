<x-slot:title>{{config('starterkid-blog.blog_post_title')}}</x-slot>
<x-slot:robots>index, follow</x-slot>
<x-slot:description>{{config('starterkid-blog.blog_post_description')}}</x-slot>

<div>
    @include('starterkid-frontend::header')
    

<x-starterkid-frontend::card>
    <x-starterkid-frontend::card-header heading="{{config('starterkid-blog.blog_post_title')}}" description="{{config('starterkid-blog.blog_post_description')}}" />
      
    <x-starterkid-frontend::wrapper>
   
  
     
            <x-starterkid-frontend::card-grid>
            
            @foreach($blogposts as $blogpost)
           <x-starterkid-frontend::post-card name="{{$blogpost->name}}" linkRoute="{{route('front.blog-post.show',$blogpost->slug)}}" linkTitle="{{$blogpost->name}}" buttonText="{{__('More info')}}" description="{!!$blogpost->preview!!}" imgSrc="{{$blogpost->getFirstMediaUrl('images',config('starterkid.spatie_conversions.large.name'))}}" imgAlt="{{$blogpost->name}}" />
            @endforeach

            
        </x-starterkid-frontend::card-grid>
    
      
    </x-starterkid-frontend::wrapper>
 
</x-starterkid-frontend::card>


    
    @include('starterkid-frontend::footer',['services' => $services])
</div>