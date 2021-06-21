<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Post
{
    public $title;

    public $excerpt;

    public $date;

    public $body;

    public $slug;


    public function __construct($title,$excerpt,$date,$body, $slug)
    {
        $this -> title = $title;

        $this -> excerpt = $excerpt;

        $this -> date = $date;

        $this -> body = $body;

        $this-> slug = $slug;

    }
    
    public static function all()
    {
        $files = File::files(resource_path("posts/"));

        return array_map(function ($file){
            return $file->getContents();
        }, $files);
    }

    public static function find($slug)
    {
        $path = resource_path("posts/{$slug}.html");
        if (! file_exists($path)){
            throw new ModelNotFoundException();
    
        }
        return Cache::remember("posts.{$slug}", 120, function() use($path){
             return file_get_contents($path);
        });
       //return cache()->remember("posts.{$slug}", 1200, fn() => {file_get_contents($path);


    }
}