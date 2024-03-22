<?php

namespace GrassFeria\StarterkidBlog\Policies;

use App\Models\User;
use GrassFeria\Starterkid\Traits\EditorPolicyTrait;
use \GrassFeria\StarterkidBlog\Models\BlogPost;
use Illuminate\Auth\Access\Response;
use GrassFeria\Starterkid\Traits\OnlyUserRecordPolicyTrait;;

class BlogPostPolicy
{
   
     use EditorPolicyTrait;

   

    
}
