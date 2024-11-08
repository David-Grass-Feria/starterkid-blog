<x-slot:title>{{$blogpost->title}}</x-slot>
<x-slot:robots>index, follow</x-slot>
<x-slot:description>{{ strip_tags($blogpost->preview) ?? '' }}</x-slot>

<div>
    @include('starterkid-frontend::header')
    


    <x-starterkid-frontend::card>

      
    <x-starterkid-frontend::wrapper>
   
    
    <x-starterkid-frontend::body-content heading="{{$blogpost->name}}" content="{!!$blogpost->content!!}" imgSrc="{{$blogpost->getFirstMediaUrl('images','large')}}" imgSrcMedium="{{$blogpost->getFirstMediaUrl('images','medium')}}" imgAlt="{{$blogpost->name}}" imageCredits="{{$blogpost->image_credits}}" dateTime="{{$blogpost->getPublished()}}" author="{{$blogpost->author}}"  />
   
    
      
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
    "description": "{{ strip_tags($blogpost->preview) ?? '' }}"
  }
</script>
@endsection

    
    @include('starterkid-frontend::footer',['services' => $services])
</div>

@section('meta')
<meta property="og:title" content="{{$blogpost->name}}" />
<meta property="og:description" content="{{ strip_tags($blogpost->preview) ?? '' }}" />
<meta property="og:image" content="{{$blogpost->getFirstMediaUrl('images','large') ?? ''}}" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:type" content="website" />
@endsection