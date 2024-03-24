<x-slot:title>{{$blogpost->name}}</x-slot>
<x-slot:robots>noindex, follow</x-slot>


<div>
    @include('starterkid-frontend::header')
    


    <x-starterkid-frontend::card>

      
    <x-starterkid-frontend::wrapper>
   
  
    <x-starterkid-frontend::body-content heading="{{$blogpost->name}}" content="{!!$blogpost->content!!}" imgSrc="{{$blogpost->getFirstMediaUrl('images','large')}}" imgAlt="{{$blogpost->name}}" imageCredits="{{$blogpost->image_credits}}" dateTime="{{$blogpost->getPublished()}}" author="{{$blogpost->author}}"  />

    
      
    </x-starterkid-frontend::wrapper>
 
</x-starterkid-frontend::card>


@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{$blogpost->name}}",
    "image": "{{$blogpost->getFirstMediaUrl('images','large') ?? ''}}",
    "author": {
      "@type": "Person",
      "name": "{{$blogpost->author ?? ''}}"
    },
    "publisher": {
      "@type": "{{config('starterkid-frontend.organization_type')}}",
      "name": "{{$settingOrganizationName ?? ''}}",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ Cache::has('logo') ? Cache::get('logo') : asset('/logo.png') }}"
      }
    },
    "datePublished": "{{$blogpost->getPublished()}}",
    "dateModified": "{{$blogpost->getPublished()}}",
    "description": "{!!$blogpost->preview ?? ''!!}"
  }
</script>
@endsection

    
    @include('starterkid-frontend::footer',['services' => $services])
</div>