<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Post;
use App\Models\PostMultipleImage;
use App\Models\PostTranslation;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CleanTextController;
use App\Models\PostTag;
use App\Models\TagTranslation;

class PostController extends Controller
{
    public function Post()
    {
        $posts = Post::withoutTrashed()->get();
        $trashed = Post::onlyTrashed()->count();
        $update = null;
        return view('admin.post.post_all', compact('posts', 'trashed', 'update'));
    }

    public function CreatePost()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.post_add', compact('categories', 'tags'));
    }

    public function StorePost(Request $request)
    {
        $boolean = $request->status;
        $request->validate([
            'en_title' => 'required',
            'en_description' => 'required',
            'la_title' => 'required',
            'la_description' => 'required',
            'post_images' => 'required|between:1,2048',
            'category' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|between:1,2048',
        ]);
        $en_title = strip_tags($request->en_title);
        $la_title = strip_tags($request->la_title);
        $valid_en = PostTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_la = PostTranslation::where('title', $la_title)->where('locale', 'la')->first();
        if ($valid_en || $valid_la) {
            $notifiction = array(
                'message' => 'This Post Already have! Please try again!!', 'alert-type' => 'error'
            );
            return back()->with($notifiction);
        }

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $save_url = 'storage/media/' . $name_gen;

        $img = Image::make($image->getRealPath());
        $img->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($save_url);

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $la_description = $cleanText->ReplaceScriptWithPTag($request->la_description);

        if ($boolean == null || $request->category == null) {
            if ($request->category == null) {
                $post = Post::create([
                    'user_id' => Auth::user()->id,
                    'category_id' => 0,
                    'publish' => 1,
                    'feature_image' => $save_url,
                    'status' => 'true',
                    'created_at' => Carbon::now(),
                ]);
                PostTranslation::insert([
                    'post_id' => $post->id,
                    'locale' => 'en',
                    'title' => $en_title,
                    'slug' => strtolower(str_replace(' ', '-', $en_title)),
                    'description' => $en_description,
                ]);

                PostTranslation::insert([
                    'post_id' => $post->id,
                    'locale' => 'la',
                    'title' => $la_title,
                    'slug' => strtolower(str_replace(' ', '-', $la_title)),
                    'description' => $la_description,
                ]);
            } else if ($boolean == null) {
                $post = Post::create([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category,
                    'publish' => 0,
                    'feature_image' => $save_url,
                    'status' => 'true',
                    'created_at' => Carbon::now(),
                ]);
                PostTranslation::insert([
                    'post_id' => $post->id,
                    'locale' => 'en',
                    'title' => $en_title,
                    'slug' => strtolower(str_replace(' ', '-', $en_title)),
                    'description' => $en_description,
                ]);

                PostTranslation::insert([
                    'post_id' => $post->id,
                    'locale' => 'la',
                    'title' => $la_title,
                    'slug' => strtolower(str_replace(' ', '-', $la_title)),
                    'description' => $la_description,
                ]);
            }
        } else {
            $post = Post::create([
                'user_id' => Auth::user()->id,
                'category_id' => $request->category,
                'publish' => 1,
                'feature_image' => $save_url,
                'status' => 'true',
                'created_at' => Carbon::now(),
            ]);
            PostTranslation::insert([
                'post_id' => $post->id,
                'locale' => 'en',
                'title' => $en_title,
                'slug' => strtolower(str_replace(' ', '-', $en_title)),
                'description' => $en_description,
            ]);

            PostTranslation::insert([
                'post_id' => $post->id,
                'locale' => 'la',
                'title' => $la_title,
                'slug' => strtolower(str_replace(' ', '-', $la_title)),
                'description' => $la_description,
            ]);
        }

        if ($request->has('post_images')) {
            foreach ($request->file('post_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());

                $img->resize(1500, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                PostMultipleImage::insert([
                    'post_id' => $post->id,
                    'name' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        $notifiction = array(
            'message' => 'Posts Inserted Successfully', 'alert-type' => 'success'
        );

        return redirect()->route('post')->with($notifiction);
    }

    public function DeletePost(Request $req)
    {
        Post::findOrFail($req->id)->delete();
        $notifiction = array(
            'message' => 'Posts Deleted Successfully', 'alert-type' => 'success'
        );
        return redirect()->route('post')->with($notifiction);
    }

    public function EditPost(Request $request)
    {
        $id = $request->id;
        $locale = app()->getLocale();
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $en_post = PostTranslation::where('post_id', $id)->where('locale', 'en')->first();
        $la_post = PostTranslation::where('post_id', $id)->where('locale', 'la')->first();
        $post_images = DB::table('post_multiple_images')->where('post_id', $id)->get();
        $category = CategoryTranslation::where('category_id', $post->category_id)->where('locale', $locale)->first();
        $tags = Tag::all();
        return view('admin.post.post_edit', compact('en_post', 'la_post', 'post', 'post_images', 'categories', 'tags', 'category'));
    }

    public function UpdatePost(Request $request)
    {
        $request->validate([
            'en_title' => 'required',
            'en_description' => 'required',
            'la_title' => 'required',
            'la_description' => 'required',
            'category' => 'required',
        ]);

        $en_id = $request->en_id;
        $la_id = $request->la_id;
        $en_title = strip_tags($request->en_title);
        $la_title = strip_tags($request->la_title);
        $valid_en = PostTranslation::where('title', $en_title)->where('locale', 'en')->first();
        $valid_la = PostTranslation::where('title', $la_title)->where('locale', 'la')->first();

        if ($valid_en) {
            $db_en_id = $valid_en->id;
            if ($en_id != $db_en_id) {
                $notifiction = array(
                    'message' => 'This Post Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }
        if ($valid_la) {
            $db_la_id = $valid_la->id;
            if ($la_id != $db_la_id) {
                $notifiction = array(
                    'message' => 'This Post Already have! Please try again!!', 'alert-type' => 'error'
                );
                return back()->with($notifiction);
            }
        }

        $post_id = $request->postId;
        $boolean = $request->status;
        $post = DB::table('posts')->where('id', $post_id)->get();
        $image = $request->file('image');
        if ($boolean == null) {
            Post::findOrFail($post_id)->update([
                'publish' => 0,
            ]);
        } else {
            Post::findOrFail($post_id)->update([
                'publish' => 1,
            ]);
        }

        Post::findOrFail($post_id)->update([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category,
            'updated_at' => Carbon::now(),
        ]);

        // clean script function
        $cleanText = new CleanTextController();
        $en_description = $cleanText->ReplaceScriptWithPTag($request->en_description);
        $la_description = $cleanText->ReplaceScriptWithPTag($request->la_description);

        PostTranslation::findOrFail($en_id)->update([
            'title' => $en_title,
            'slug' => strtolower(str_replace(' ', '-', $en_title)),
            'description' => $en_description,
        ]);

        PostTranslation::findOrFail($la_id)->update([
            'title' => $la_title,
            'slug' => strtolower(str_replace(' ', '-', $la_title)),
            'description' => $la_description,
        ]);

        if ($request->has('post_images')) {
            $request->validate(['post_images.*' => 'required|image|mimes:jpeg,jpg,png|max:2048']);
            foreach ($request->file('post_images') as $mul_image) {
                $mul_name_gen = hexdec(uniqid()) . '.' . $mul_image->getClientOriginalExtension();
                $save_url = 'storage/media/' . $mul_name_gen;
                $img = Image::make($mul_image->getRealPath());
                $img->resize(1000, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_url);

                PostMultipleImage::insert([
                    'post_id' => $post_id,
                    'name' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,gif|between:1,100',
            ]);
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'storage/media/' . $name_gen;
            $img = Image::make($image->getRealPath());
            $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($save_url);

            Post::findOrFail($post_id)->update([
                'feature_image' => $save_url,
            ]);
            if (file_exists($post[0]->feature_image)) {
                unlink($post[0]->feature_image);
            }
        }

        $updatePost = Post::findOrFail($request->postId);
        if ($request->has('tags')) {
            $updatePost->tags()->syncWithoutDetaching($request->tags);
        }

        $notifiction = array(
            'message' => 'Posts Updated Successfully', 'alert-type' => 'success'
        );

        return back()->with($notifiction);
    }

    public function DeleteSingleImage(Request $request)
    {
        $id = $request->id;
        $single_image = PostMultipleImage::findOrFail($id);
        unlink($single_image->name);
        $single_image->delete();

        $notifiction = array(
            'message' => 'Delete Image Successfully', 'alert-type' => 'success'
        );

        return redirect()->back()->with($notifiction);
    }

    public function DeletePostTag(Request $request)
    {
        $post_id = $request->post_id;
        $tag_id = $request->tag_id;
        $post = Post::findOrFail($post_id);
        $post->tags()->detach($tag_id);
        $notifiction = array(
            'message' => 'Delete Tag from this post Successfully', 'alert-type' => 'success'
        );

        return back()->with($notifiction);
    }

    public function index()
    {
        $trashed = Post::onlyTrashed()->get();
        return view('admin.post.post_trash', compact('trashed'));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        Post::where('id', $id)->withTrashed()->restore();
        $notifiction = array(
            'message' => 'Restore Post Sucessfully!!', 'alert-type' => 'success'
        );
        return redirect()->route('post')->with($notifiction);
    }

    public function force_delete(Request $request)
    {
        $id = $request->id;
        $multi_image = DB::table('post_multiple_images')->where('post_id', $id)->get();
        foreach ($multi_image as $image) {
            if (file_exists($image->name)) {
                unlink($image->name);
            }
        }
        $image = PostMultipleImage::where('post_id', $id)->delete();

        $post = DB::table('posts')->where('id', $id)->first();
        $single_image = $post->feature_image;
        if (file_exists($single_image)) {
            unlink($single_image);
        }
        Post::where('id', $id)->withTrashed()->forceDelete();

        $notification = array(
            'message' => 'Deleted Post Sucessfully!!', 'alert-type' => 'danger'
        );

        return back()->with($notification);
    }

    public function getTags(Request $request)
    {
        dd($request);
        $tags = [];
        if ($search = $request->name) {
            $tags = TagTranslation::where('name', 'LIKE', "%$search%")->get();
        }

        return response()->json($tags);
    }
}
