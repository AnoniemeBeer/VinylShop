<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class Itunes extends Component
{
    public function render()
    {
        // dump data from https://rss.applemarketingtools.com/api/v2/be/music/most-played/10/albums.json
        $url = 'https://rss.applemarketingtools.com/api/v2/be/music/most-played/10/albums.json';
        $response = Http::get($url)->json();
        $feed = $response['feed'];
        $albums = $feed['results'];
        $date = Carbon::parse($feed['updated'])->format('F d Y');

        return view('livewire.itunes', compact('albums', 'feed', 'date'))
            ->layout('layouts.vinylshop', [
                'description' => 'Itunes',
                'title' => 'Itunes',
                'albums' => $albums
            ]);
    }
}
