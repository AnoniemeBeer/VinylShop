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
        $response = $response['feed'];
        $albums = $response['results'];
        $date = Carbon::parse($response['updated'])->format('F d Y');

        return view('livewire.itunes', compact('albums', 'response', 'date'))
            ->layout('layouts.vinylshop', [
                'description' => 'Itunes',
                'title' => 'Itunes',
                'albums' => $albums
            ]);
    }
}
