<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class Itunes extends Component
{
    public $countryCode = 'be';
    public $amount = 10;
    public $type = true;
    public $url = 'https://rss.applemarketingtools.com/api/v2/%s/music/most-played/%d/%s.json';
    public $response;
    public $albums;
    public $date;
    public $feed;

    public $loading = 'Please wait...';

    public function request()
    {
        $type = ($this->type) ? 'albums' : 'songs';
        $this->response = Http::get(sprintf($this->url, $this->countryCode, $this->amount, $type))->json();
        $this->feed = $this->response['feed'];
        $this->albums = $this->feed['results'];
        $this->date = Carbon::parse($this->feed['updated'])->format('F d Y');
    }

    public function updated($propertyName, &$propertyValue)
    {
        if (in_array($propertyName, ['countryCode', 'amount', 'type'])) {
            $this->request();
        }
    }

    public function render()
    {
        $url = 'https://rss.applemarketingtools.com/api/v2/be/music/most-played/10/albums.json';
        $this->request();

        $albums = $this->albums;
        $feed = $this->feed;
        $date = $this->date;

        return view('livewire.itunes')
            ->layout('layouts.vinylshop', [
                'description' => 'Itunes',
                'title' => 'Itunes',
                'albums' => $this->albums
            ]);
    }
}
