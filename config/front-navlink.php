<?php

return [
    [
        'title' => env('BLOG_POST_MENU_NAME','Blog'),
        'route' => 'front.blog-post.index',
        'active' => ['front.blog-post.index','front.blog-post.show'],
        'order' => env('BLOG_ORDER_FOR_NAV',1),
        
        
    ],

    
];