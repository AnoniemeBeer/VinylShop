<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Record;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;
    public $perPage = 6;
    public $loading = 'Please wait...';
    public function render()
    {
        $records = Record::orderBy('artist')
            ->paginate($this->perPage);
        return view('livewire.shop', compact('records'))
            ->layout('layouts.vinylshop', [
                'description' => 'Shop',
                'title' => 'Shop'
            ]);
    }
}
