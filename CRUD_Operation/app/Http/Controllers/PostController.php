<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function welcome()
    {
        $posts = PostModel::with('user')
        ->orderBy('created_at', 'desc')
            ->get();

          // Get the error message from the session, if any
          $errorMessage = Session::get('error');

          return view('welcome', ['posts' => $posts, 'errorMessage' => $errorMessage]);
    }

    public function index()
    {
        $posts = PostModel::with('user') // Eager load the 'user' relationship
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('posts', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'string|max:500',
            'images.*' => 'required|mimes:jpeg,jpg,png|max:50000',
        ]);
        $imagenames = [];
        foreach ($validatedData['images'] as $key => $file) {
            // dd($file);
            // $imagepath = time() . '.' . $file->extension();
            $imagepath = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('postImages'), $imagepath);
            $imagenames[] = $imagepath;
        }
        $imageString = implode(',', $imagenames);

        $post = PostModel::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
            'images' => $imageString,
        ]);

        if ($post) {
            return redirect()->route('posts.index')->with('success', 'Data has been submitted successfully');
        } else {
            return redirect()->route('posts.index')->withErrors(['error' => 'Data submission failed!'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = PostModel::findOrFail($id);

        return view('viewPost', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = Auth::id();

        $post = PostModel::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

            if (!$post) {
                Session::flash('error', 'You cannot delete posts that do not belong to you');
                return redirect()->route('welcome')->with(['error' => 'You cannot delete posts that do not belong to you']);
            }else{
                return view('editPost', compact('post'));
            }

       
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:500',
            'images.*' => 'nullable|mimes:jpeg,jpg,png|max:50000',
        ]);

        $userId = Auth::id();

        $post = PostModel::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

            if (!$post) {
                Session::flash('error', 'You cannot delete posts that do not belong to you');
                return redirect()->route('welcome')->with(['error' => 'You cannot delete posts that do not belong to you']);
            }

        // Update the post fields except for images
        $post->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        // Handle image update only if new images are uploaded
        if ($request->hasFile('images')) {
            $imagenames = [];
            foreach ($validatedData['images'] as $key => $file) {
                $imagepath = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('postImages'), $imagepath);
                $imagenames[] = $imagepath;
            }
            $imageString = implode(',', $imagenames);
            // Update the post's images
            $post->images = $imageString;
            $post->save();
        }

        return redirect()->route('posts.index')->with('success', 'Post has been updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userId = Auth::id();

        $post = PostModel::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

            if (!$post) {
                Session::flash('error', 'You cannot delete posts that do not belong to you');
                return redirect()->route('welcome')->with(['error' => 'You cannot delete posts that do not belong to you']);
            }

        $imageFilenames = explode(',', $post->images);

        $deleted = $post->delete();

        if ($deleted) {
            // Delete the associated image files from the storage folder
            foreach ($imageFilenames as $filename) {
                $imagePath = public_path('postImages') . '/' . $filename;
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the file
                }
            }

            return redirect()->route('posts.index')->with('success', 'Post and associated images have been deleted successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to delete the post and associated images']);
        }
    }
}
