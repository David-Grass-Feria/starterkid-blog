<?php

return [
    [
        'title' => env('BLOG_POST_TITLE','Blog'),
        'route' => 'front.blog-post.index',
        'active' => ['front.blog-post.index','front.blog-post.show'],
        'order' => env('BLOG_ORDER_FOR_NAV',1),
        
        
    ],

    
];