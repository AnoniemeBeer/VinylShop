<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Record;
use App\models\Genre;

class RecordController extends Controller
{
    public function index()
    {
        $maxPrice = 20;
        $perPage = 6;
        $records = Record::where('price', '<=', $maxPrice)
            ->orderBy('artist')
            ->orderBy('title')
            ->paginate($perPage);

        // has is used for checking if a data exists for that genre
        $genres = Genre::orderBy('name')->with('records')->has('records')->paginate($perPage);
        //$genres->makeVisible('created_at');
        // for multiple paramaters, use a list.
        // $genres->makeVisible(['updated_at', 'updated_at']);
        return view('admin.records.index', compact('records', 'genres'));
    }
}
