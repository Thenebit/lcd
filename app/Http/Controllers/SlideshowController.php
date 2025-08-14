<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Service\SupabaseService;

class SlideshowController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    public function index()
    {
        $images = $this->fetchActiveImages();
        return view('slideshow', compact('images'));
    }

    public function getData()
    {
        $images = $this->fetchActiveImages();
        return response()->json($images);
    }

    private function fetchActiveImages()
    {
        $unstruct_events = $this->supabase->getAllEvents();
        $response = collect($unstruct_events);

        $images = $response->filter(function ($event) {
            if (empty($event['event_start_date']) || empty($event['event_end_date'])) {
                return false;
            }

            $start = Carbon::parse($event['event_start_date']);
            $end = Carbon::parse($event['event_end_date']);

            return Carbon::today()->between($start, $end);
        })
        ->pluck('event_image')
        ->filter()
        ->values()
        ->all();

        return $images;
    }
}

