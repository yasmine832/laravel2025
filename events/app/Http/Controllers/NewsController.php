<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('publish_date', 'desc')->paginate(10);
        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function create()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user?->isAdmin()) {
            abort(403);
        }
        return view('news.create');
    }

    public function store(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user?->isAdmin()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|max:1024',
        ]);

        $imagePath = $request->file('image')->store('news', 'public');

        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'publish_date' => now()
        ]);

        return redirect()->route('news.index')->with('success', 'News item created successfully');
    }

    public function edit(News $news)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user?->isAdmin()) {
            abort(403);
        }
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user?->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($news->image_path);
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $validated['image_path'] ?? $news->image_path,
            'publish_date' => now() //keep?? 
        ]);

        return redirect()->route('news.show', $news)->with('success', 'News item updated successfully');
    }

    public function destroy(News $news)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user?->isAdmin()) {
            abort(403);
        }
        
        Storage::disk('public')->delete($news->image_path);
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News item deleted successfully');
    }
}