<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Record;

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

    // validation rules (use the rules() method, not the $rules property)
    protected function rules()
    {
        return [];
    }

    // validation attributes
    protected $validationAttributes = [];

    // set/reset $newRecord and validation
    public function setNewRecord()
    {
    }

    // reset the paginator
    public function updated($propertyName, $propertyValue)
    {
        $this->resetPage();
    }

    // create a new record
    public function createRecord()
    {
    }

    // update an existing record
    public function updateRecord()
    {
    }

    // delete an existing record
    public function deleteRecord()
    {
    }

    public function render()
    {
        // filter by $search
        $query = Record::orderBy('artist')->orderBy('title')
            ->searchTitleOrArtist($this->search);
        // only if $noCover is true, filter the query further, else, skip this step
        if ($this->noStock)
            $query->where('stock', false);
        // paginate the $query
        $records = $query->paginate($this->perPage);
        return view('livewire.admin.records', compact('records'))
            ->layout('layouts.vinylshop', [
                'description' => 'Manage the records of your vinyl shop',
                'title' => 'Records',
            ]);
    }
}
