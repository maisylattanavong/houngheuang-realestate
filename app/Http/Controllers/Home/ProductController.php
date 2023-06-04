<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Socialmedia;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryTranslation;
use App\Models\TagTranslation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function single_post($locale, PostTranslation $post_id, Request $request)
    {
        $search = request()->query('search');
        if ($search) {
            $search_post = TagTranslation::where('name', 'LIKE', "%{$search}%")->get();
            foreach ($search_post as $item) {
                $tag_id = $item->tag_id;
            }
        } else {
            $search_post = null;
            $tag_id = null;
        }

        $post_id = $post_id->post_id;
        Post::find($post_id)->increment('views');
        $data = Post::findOrFail($post_id);
        $images = DB::table('post_multiple_images')->where('post_id', $post_id)->get();
        $categoryId = $data->category_id;
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        $postData = Post::where('category_id', $categoryId)->where('id', '!=', $post_id)->paginate(4);
        $SITE_DOMAIN = env('SITE_DOMAIN');
        return view('frontend.single_post', compact('data', 'images', 'postData', 'social', 'line', 'footer', 'SITE_DOMAIN', 'search_post', 'tag_id'));
    }

    public function categoryPost($locale, CategoryTranslation $category_id)
    {
        $category_id = $category_id->category_id;
        $postData = Post::where('category_id', $category_id)->get();
        $categoryData = Category::findOrFail($category_id);
        $categoryName = $categoryData->name;
        $social = Socialmedia::where('name', '!=', 'Line')->latest()->take(3)->get();
        $line = Socialmedia::where('name', 'Line')->get();
        $footer = Company::whereNotNull('id')->latest()->take(1)->get();
        $SITE_DOMAIN = env('SITE_DOMAIN');
        return view('frontend.category_post', compact('postData', 'categoryName', 'social', 'line', 'footer', 'SITE_DOMAIN'));
    }
}
