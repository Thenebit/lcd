<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SlideshowController extends Controller
{
    private $firebaseUrl = "https://firestore.googleapis.com/v1/projects/project_id/databases/(default)/documents/events";

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
        $response = Http::get($this->firebaseUrl);

        $images = [];
        if ($response->successful()) {
            $documents = $response->json('documents') ?? [];

            foreach ($documents as $doc) {
                $fields = $doc['fields'] ?? [];
                $start = isset($fields['event_start_date']['stringValue']) ? Carbon::parse($fields['event_start_date']['stringValue']) : null;
                $end = isset($fields['event_end_date']['stringValue']) ? Carbon::parse($fields['event_end_date']['stringValue']) : null;

                if ($start && $end && Carbon::today()->between($start, $end)) {
                    $images[] = $fields['image_url']['stringValue'] ?? '';
                }
            }
        }
        return $images;
    }
}
