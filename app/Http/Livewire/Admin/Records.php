<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithPagination;
use App\Models\Record;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Records extends Component
{
    use WithPagination;
    // filter and pagination
    public $search;
    public $noStock = false;
    public $noCover = false;
    public $perPage = 5;
    // show/hide the modal
    public $showModal = false;
    // array that contains the values for a new or updated version of the record
    public $newRecord = [
        'id' => null,
        'artist' => null,
        'title' => null,
        'mb_id' => null,
        'stock' => null,
        'price' => null,
        'genre_id' => null,
        'cover' => '/storage/covers/no-cover.png',
    ];

    // validation attributes
    protected $validationAttributes = [
        'newRecord.mb_id' => 'MusicBrainz id',
        'newRecord.artist' => 'artist name',
        'newRecord.title' => 'record title',
        'newRecord.genre_id' => 'genre',
        'newRecord.stock' => 'stock',
        'newRecord.price' => 'price',
    ];

    public $genres;

    // validation rules (use the rules() method, not the $rules property)
    protected function rules()
    {
        return
            [
                'newRecord.mb_id' => 'required|size:36|unique:records,mb_id,' . $this->newRecord['id'],
                'newRecord.artist' => 'required',
                'newRecord.title' => 'required',
                'newRecord.genre_id' => 'required|exists:genres,id',
                'newRecord.stock' => 'required|numeric|min:0',
                'newRecord.price' => 'required|numeric|min:0',
            ];
    }

    // get artist, title and cover from the MusicBrainz API
    public function getDataFromMusicbrainzApi()
    {
        $this->validateOnly('newRecord.mb_id');
        $this->resetErrorBag();
        $response = Http::get('https://musicbrainz.org/ws/2/release/' . $this->newRecord['mb_id'] . '?inc=artists&fmt=json');
        if ($response->successful()) {
            $data = $response->json();
            $this->newRecord['artist'] = $data['artist-credit'][0]['artist']['name'];
            $this->newRecord['title'] = $data['title'];
            if ($data['cover-art-archive']['front']) {
                $this->newRecord['cover'] = 'https://coverartarchive.org/release/' . $this->newRecord['mb_id'] . '/front-250.jpg';
                $originalCover = Image::make($this->newRecord['cover'])->encode('jpg', 75);
                Storage::disk('public')->put('covers/' . $this->newRecord['mb_id'] . '.jpg', $originalCover);
            }
        } else {
            $this->newRecord['artist'] = null;
            $this->newRecord['title'] = null;
            $this->newRecord['cover'] = '/storage/covers/no-cover.png';
            $this->addError('newRecord.mb_id', 'MusicBrainz id not found');
        }
    }

    // set/reset $newRecord and validation
    public function setNewRecord(Record $record = null)
    {
        $this->resetErrorBag();
        if ($record) {
            $this->newRecord['id'] = $record->id;
            $this->newRecord['artist'] = $record->artist;
            $this->newRecord['title'] = $record->title;
            $this->newRecord['mb_id'] = $record->mb_id;
            $this->newRecord['stock'] = $record->stock;
            $this->newRecord['price'] = $record->price;
            $this->newRecord['genre_id'] = $record->genre_id;
            $this->newRecord['cover'] =
                Storage::disk('public')->exists('covers/' . $record->mb_id . '.jpg')
                ? '/storage/covers/' . $record->mb_id . '.jpg'
                : '/storage/covers/no-cover.png';
        } else {
            $this->reset('newRecord');
        }
        $this->showModal = true;
    }

    // reset the paginator
    public function updated($propertyName, $propertyValue)
    {
        if (in_array($propertyName, ['search', 'noStock', 'noCover', 'perPage']))
            $this->resetPage();
    }

    // create a new record
    public function createRecord()
    {
        $this->validate();
        $record = Record::create([
            'mb_id' => $this->newRecord['mb_id'],
            'artist' => $this->newRecord['artist'],
            'title' => $this->newRecord['title'],
            'stock' => $this->newRecord['stock'],
            'price' => $this->newRecord['price'],
            'genre_id' => $this->newRecord['genre_id'],
        ]);
        $this->showModal = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The record <b><i>{$record->title} from {$record->artist}</i></b> has been added",
        ]);
    }

    // update an existing record
    public function updateRecord(Record $record)
    {
        $this->validate();
        $record->update([
            'mb_id' => $this->newRecord['mb_id'],
            'artist' => $this->newRecord['artist'],
            'title' => $this->newRecord['title'],
            'stock' => $this->newRecord['stock'],
            'price' => $this->newRecord['price'],
            'genre_id' => $this->newRecord['genre_id'],
        ]);
        $this->showModal = false;
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The record <b><i>{$record->title} from {$record->artist}</i></b> has been updated",
        ]);
    }

    // delete an existing record
    public function deleteRecord(Record $record)
    {
        $record->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The record <b><i>{$record->title} from {$record->artist}</i></b> has been deleted",
        ]);
    }

    public function mount()
    {
        $this->genres = Genre::orderBy('name')->get();
    }

    public function render()
    {
        // filter by $search
        $query = Record::orderBy('artist')->orderBy('title')
            ->searchTitleOrArtist($this->search);
        // only if $noCover is true, filter the query further, else, skip this step
        if ($this->noStock)
            $query->where('stock', false);
        // only if $noCover is true, filter the query further. else, skip this step
        if ($this->noCover)
            $query->coverExists(false);
        // paginate the $query
        $records = $query->paginate($this->perPage);
        return view('livewire.admin.records', compact('records'))
            ->layout('layouts.vinylshop', [
                'description' => 'Manage the records of your vinyl shop',
                'title' => 'Records',
            ]);
    }
}
