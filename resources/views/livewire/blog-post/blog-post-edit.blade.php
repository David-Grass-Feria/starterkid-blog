<div>
        <x-starterkid::starterkid.card>
                <x-slot name="header">
                <a href="{{route('blogposts.index')}}" title="{{__('BlogPost list')}}">
                <x-starterkid::starterkid.button-secondary type="button">{{__('Back')}}</x-starterkid::starterkid.button-secondary>
                </a>
                </x-slot>
                <x-starterkid::starterkid.form cancelRoute="{{route('blogposts.index')}}">
                
                <x-starterkid::starterkid.form.text wire:model="name" for="name" id="name" type="text" label="{{__('Name')}}" required/>
                <x-starterkid::starterkid.form.text wire:model="title" for="title" id="title" type="text" label="{{__('Title')}}" required/>
                <x-starterkid::starterkid.form.text wire:model="slug" for="slug" id="slug" type="text" label="{{__('Slug')}}" required/>
              
                <x-starterkid::starterkid.form.ckeditor5 wire:model="content" for="content" id="content" rows="5" label="{{__('Content')}}" required>
                {!!$blogpost->content!!}
                </x-starterkid::starterkid.form.ckeditor5>
                <x-starterkid::starterkid.form.ckeditor5 wire:model="preview" for="preview" id="preview" rows="5" label="{{__('Preview')}}">
                <x-slot name="removePlugins">
                'CodeBlock','List','Highlight','HorizontalLine','BlockQuote','Table','Italic','Heading','Image','ImageUpload','MediaEmbed','SimpleUploadAdapterPlugin'
                </x-slot>
                {!!$blogpost->preview!!}
                </x-starterkid::starterkid.form.ckeditor5>
                
                <x-starterkid::starterkid.form.file name="public_images" wire:model="public_images" for="public_images" id="public_images" label="{{__('Post image')}}" maxFileSize="{{config('starterkid.max_file_size_mb')}}MB" maxTotalFileSize="{{config('starterkid.max_file_size_mb')}}MB" required >
                <x-slot name="acceptedFileTypes">
                'image/*'
                </x-slot>
                </x-starterkid::starterkid.form.file>
                <livewire-starterkid::show-image key="public_images_{{$blogpost->id}}" :record="$blogpost" collection="images" divClass="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-1 mt-5 mb-5" imgClass="h-32" />

                <x-starterkid::starterkid.form.datetime wire:model="published" for="published" id="published" label="{{__('Published')}}" required />
                <x-starterkid::starterkid.form.select wire:model="author" for="author" id="author" label="{{__('Author')}}" placeholder="{{__('Choose your author')}}" required>
                @foreach($authors as $author)
                <option value="{{$author->id}}">{{$author->name}}</option>
                @endforeach
                </x-starterkid::starterkid.form.select>
                <x-starterkid::starterkid.form.checkbox for="status" id="status" label="{{__('Status')}}">
                <x-starterkid::starterkid.input-checkbox-radio-panel>
                <x-starterkid::starterkid.input-checkbox wire:model="status" name="status" />
                <x-starterkid::starterkid.label>{{__('Online')}}</x-starterkid::starterkid.label>
                </x-starterkid::starterkid.input-checkbox-radio-panel>
                </x-starterkid::starterkid.form.checkbox>

              

                </x-starterkid::starterkid.form>


        </x-starterkid::starterkid.card>
        </div>