<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public function aStoryOfLove()
    {
        return view('articles.a-story-of-love');
    }

}
