<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\Umkm;
use App\Models\TourismPlace;
use App\Models\Article;
use App\Models\Event;
use App\Models\Album;
use App\Services\MapProviderService;
use App\Services\ImpactService;
use Illuminate\Http\Request;

class PublicVillageController extends Controller
{
    protected MapProviderService $mapService;
    protected ImpactService $impactService;

    public function __construct(MapProviderService $mapService, ImpactService $impactService)
    {
        $this->mapService = $mapService;
        $this->impactService = $impactService;
    }

    protected function getVillageBySlug(string $slug): Village
    {
        return Village::with(['profile', 'campus'])->where('slug', $slug)->firstOrFail();
    }

    public function home(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        
        $featuredUmkms = $village->publishedUmkms()->with('products')->take(3)->get();
        $featuredTourism = $village->publishedTourismPlaces()->take(3)->get();
        $latestArticles = $village->publishedArticles()->latest('published_at')->take(3)->get();
        $upcomingEvents = $village->publishedEvents()->where('date', '>=', now()->toDateString())->orderBy('date')->take(3)->get();
        $albums = $village->albums()->with('mediaItems')->take(4)->get();
        
        $impact = $this->impactService->getVillageImpact($village);
        $markers = $this->mapService->getVillageMarkers($village);

        return view('public.village.home', compact(
            'village', 
            'featuredUmkms', 
            'featuredTourism', 
            'latestArticles', 
            'upcomingEvents', 
            'albums', 
            'impact', 
            'markers'
        ));
    }

    public function about(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $profile = $village->profile;
        $facilities = $village->facilities;

        return view('public.village.about', compact('village', 'profile', 'facilities'));
    }

    public function umkm(Request $request, string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        
        $query = $village->publishedUmkms()->with('products');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        if ($request->filled('q')) {
            $search = $request->query('q');
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        $umkms = $query->paginate(9)->withQueryString();
        $categories = Umkm::where('village_id', $village->id)->where('status', 'PUBLISHED')->distinct()->pluck('category');

        return view('public.village.umkm', compact('village', 'umkms', 'categories'));
    }

    public function showUmkm(string $villageSlug, string $umkmSlug)
    {
        $village = $this->getVillageBySlug($villageSlug);
        $umkm = $village->publishedUmkms()->with('products')->where('slug', $umkmSlug)->firstOrFail();

        return view('public.village.umkm_show', compact('village', 'umkm'));
    }

    public function tourism(Request $request, string $slug)
    {
        $village = $this->getVillageBySlug($slug);

        $query = $village->publishedTourismPlaces();

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $tourismPlaces = $query->paginate(9)->withQueryString();
        $categories = TourismPlace::where('village_id', $village->id)->where('status', 'PUBLISHED')->distinct()->pluck('category');

        return view('public.village.tourism', compact('village', 'tourismPlaces', 'categories'));
    }

    public function map(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $markers = $this->mapService->getVillageMarkers($village);

        return view('public.village.map', compact('village', 'markers'));
    }

    public function events(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $upcomingEvents = $village->publishedEvents()->where('date', '>=', now()->toDateString())->orderBy('date')->get();
        $pastEvents = $village->publishedEvents()->where('date', '<', now()->toDateString())->orderBy('date', 'desc')->get();

        return view('public.village.events', compact('village', 'upcomingEvents', 'pastEvents'));
    }

    public function news(Request $request, string $slug)
    {
        $village = $this->getVillageBySlug($slug);

        $query = $village->publishedArticles()->with('author')->latest('published_at');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $articles = $query->paginate(6)->withQueryString();
        $categories = Article::where('village_id', $village->id)->where('status', 'PUBLISHED')->distinct()->pluck('category');

        return view('public.village.news', compact('village', 'articles', 'categories'));
    }

    public function showNews(string $villageSlug, string $articleSlug)
    {
        $village = $this->getVillageBySlug($villageSlug);
        $article = $village->publishedArticles()->with('author')->where('slug', $articleSlug)->firstOrFail();
        $relatedArticles = $village->publishedArticles()->where('id', '!=', $article->id)->latest('published_at')->take(3)->get();

        return view('public.village.news_show', compact('village', 'article', 'relatedArticles'));
    }

    public function gallery(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $albums = $village->albums()->with('mediaItems')->get();

        return view('public.village.gallery', compact('village', 'albums'));
    }

    public function kkn(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $group = $village->activeGroup();
        $programs = $group ? $group->programs()->with('leader')->get() : collect();
        $members = $group ? $group->members : collect();
        $supervisor = $group ? $group->supervisor : null;
        $handover = $village->latestHandoverPackage();

        return view('public.village.kkn', compact('village', 'group', 'programs', 'members', 'supervisor', 'handover'));
    }

    public function impact(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $impact = $this->impactService->getVillageImpact($village);

        return view('public.village.impact', compact('village', 'impact'));
    }

    public function handover(string $slug)
    {
        $village = $this->getVillageBySlug($slug);
        $handover = $village->latestHandoverPackage();

        return view('public.village.handover', compact('village', 'handover'));
    }

    public function contact(string $slug)
    {
        $village = $this->getVillageBySlug($slug);

        return view('public.village.contact', compact('village'));
    }
}
