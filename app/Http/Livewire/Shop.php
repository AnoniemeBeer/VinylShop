<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Record;
use App\Models\Genre;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class Shop extends Component
{
    use WithPagination;
    public $perPage = 6;
    public $name;
    public $genre = '%';
    public $price;
    public $priceMin, $priceMax;

    public $loading = 'Please wait...';
    public $selectedRecord;
    public $showModal = false;

    public function updated($propertyName, $propertyValue)
    {
        if (in_array($propertyName, ['perPage', 'name', 'genre', 'price']))
            $this->resetPage();
    }

    public function showTracks(Record $record)
    {
        $this->selectedRecord = $record;
        $url = "https://musicbrainz.org/ws/2/release/{$record->mb_id}?inc=recordings&fmt=json";
        $response = Http::get($url)->json();
        $this->selectedRecord['tracks'] = $response['media'][0]['tracks'];

        $this->showModal = true;
    }

    public function mount()
    {
        $this->priceMin = ceil(Record::min('price'));
        $this->priceMax = ceil(Record::max('price'));
        $this->price = $this->priceMax;
    }

    public function render()
    {
        $allGenres = Genre::has('records')->withCount('records')->get();
        $records = Record::orderBy('artist')->orderBy('title')
            ->searchTitleOrArtist($this->name)
            ->maxPrice($this->price)
            ->where('genre_id', 'like', $this->genre)
            ->paginate($this->perPage);

        // ->where([
        //     ['title', 'like', "%{$this->name}%"],
        //     ['genre_id', 'like', $this->genre],
        //     ['price', '<=', $this->price]
        // ])->orWhere([
        //     ['artist', 'like', "%{$this->name}%"],
        //     ['genre_id', 'like', $this->genre],
        //     ['price', '<=', $this->price]
        // ])

        return view('livewire.shop', compact('records', 'allGenres'))
            ->layout('layouts.vinylshop', [
                'description' => 'Shop',
                'title' => 'Shop'
            ]);
    }
}
