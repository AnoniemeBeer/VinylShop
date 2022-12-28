<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Genre;
use Livewire\WithPagination;

class Genres extends Component
{
    // sort properties
    public $orderBy = 'name';
    public $orderAsc = true;

    public $newGenre;
    public $editGenre = ['id' => null, 'name' => null];

    use WithPagination;
    public $perPage = 10;

    protected $messages = [
        'newGenre.required' => 'Please enter a genre name.',
        'newGenre.min' => 'The new name must contains at least 3 characters and no more than 30 characters.',
        'newGenre.max' => 'The new name must contains at least 3 characters and no more than 30 characters.',
        'newGenre.unique' => 'This name already exists.',
        'editGenre.name.required' => 'Please enter a genre name.',
        'editGenre.name.min' => 'This name is too short (must be between 3 and 30 characters).',
        'editGenre.name.max' => 'This name is too long (must be between 3 and 30 characters)',
        'editGenre.name.unique' => 'This name is already in use.',
    ];

    // listen to the delete-genre event
    protected $listeners = [
        'delete-genre' => 'deleteGenre',
    ];

    public function updated($propertyName, $propertyValue)
    {
        if (in_array($propertyName, ['perPage']))
            $this->resetPage();
    }

    // edit the value of $editGenre (show inlined edit form)
    public function editExistingGenre(Genre $genre)
    {
        $this->editGenre = [
            'id' => $genre->id,
            'name' => $genre->name,
        ];
    }

    // validation rules
    public function rules()
    {
        return [
            'newGenre' => 'required|min:3|max:30|unique:genres,name',
            'editGenre.name' => 'required|min:3|max:30|unique:genres,name,' . $this->editGenre['id'],
        ];
    }

    // reset $newGenre and validation
    public function resetNewGenre()
    {
        $this->reset('newGenre');
        $this->resetErrorBag();
    }

    // reset $editGenre and validation
    public function resetEditGenre()
    {
        $this->reset('editGenre');
        $this->resetErrorBag();
    }

    // update an existing genre
    public function updateGenre(Genre $genre)
    {

        // $this->validateOnly('editGenre.name');
        // $oldName = $genre->name;
        // $newName =

        $this->validateOnly('editGenre.name');
        $oldName = $genre->name;
        $newName = trim($this->editGenre['name']);

        if ($oldName !== $newName) {
            $genre->update([
                'name' => $newName,
            ]);

            $this->resetEditGenre();
            $this->dispatchBrowserEvent('swal:toast', [
                'background' => 'success',
                'html' => "The genre <b><i>{$oldName}</i></b> has been updated to <b><i>{$genre->name}</i></b>",
            ]);
        } else {
            $this->resetEditGenre();
            $this->dispatchBrowserEvent('swal:toast', [
                'background' => 'info',
                'html' => "The genre <b><i>{$oldName}</i></b> has not been updated.",
            ]);
        }
    }

    // create a new genre
    public function createGenre()
    {
        // validate the new genre name
        $this->validateOnly('newGenre');
        // create the genre
        $genre = Genre::create([
            'name' => trim($this->newGenre),
        ]);
        // reset $newGenre
        $this->resetNewGenre();
        // toast
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The genre <b><i>{$genre->name}</i></b> has been added",
        ]);
    }

    // resort the genres by the given column
    public function resort($column)
    {
        if ($this->orderBy === $column) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $column;
    }

    public function render()
    {
        $genres = Genre::withCount('records')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.genres', compact('genres'))->layout('layouts.vinylshop', [
            'description' => 'Manage the genres of your vinyl records',
            'title' => 'Genres',
        ]);
    }

    // delete a genre
    public function deleteGenre(Genre $genre)
    {
        $genre->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The genre <b><i>{$genre->name}</i></b> has been deleted",
        ]);
    }
}
