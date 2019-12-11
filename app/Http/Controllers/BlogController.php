<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public $redis;

    public function __construct()
    {
        $this->redis = app()->make('redis');
    }

    public function index()
    {
        $popular = $this->redis->zRevRange('articleViews', 0, -1);
        echo 'Most popular articles:<br>';
        foreach($popular as $value){
            $id = str_replace('article_', '', $value);
            echo '<a href="/article/' . $id . '">Article ' . $id . '</a>' . '<br>';
        }
    }
    public function showArticle($id)
    {
        $views = $this->redis->zIncrBy('articleViews', 1, 'article_' . $id);

        return 'Article ' . $id . ' with ' . $views . ' views';
    }
}
