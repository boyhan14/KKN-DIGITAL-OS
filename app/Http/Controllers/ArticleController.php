<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\Article;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Village $village)
    {
        $articles = $village->articles()->with('author')->latest()->get();
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('articles.index', compact('village', 'articles', 'isLocked'));
    }

    public function create(Village $village)
    {
        return view('articles.create', compact('village'));
    }

    public function store(Request $request, Village $village)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:NEWS,ANNOUNCEMENT,KKN,VILLAGE,UMKM,TOURISM,EDUCATION',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['title']);
        if (Article::where('village_id', $village->id)->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $activeGroup = $village->activeGroup();

        $article = Article::create([
            'village_id' => $village->id,
            'kkn_group_id' => $activeGroup?->id,
            'author_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150),
            'content' => $validated['content'],
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? ($validated['excerpt'] ?? null),
            'status' => 'DRAFT',
        ]);

        ActivityLog::create([
            'kkn_group_id' => $activeGroup?->id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'created_article',
            'description' => "Menulis artikel/berita baru: {$article->title}",
            'created_at' => now(),
        ]);

        return redirect()->route('village.articles.index', $village->id)->with('success', 'Artikel berhasil disimpan sebagai DRAFT.');
    }

    public function edit(Village $village, Article $article)
    {
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();
        return view('articles.edit', compact('village', 'article', 'isLocked'));
    }

    public function update(Request $request, Village $village, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:NEWS,ANNOUNCEMENT,KKN,VILLAGE,UMKM,TOURISM,EDUCATION',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $article->update($validated);

        return back()->with('success', 'Artikel berhasil diperbarui.');
    }

    public function submitReview(Village $village, Article $article)
    {
        $article->update(['status' => 'PENDING_REVIEW']);
        return back()->with('success', 'Artikel telah diajukan ke Dosen Pembimbing untuk direview.');
    }

    public function destroy(Village $village, Article $article)
    {
        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
