<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HarmonisasiController extends Controller
{
    use NavigationList;

    public function index()
    {

        // PAGE SETUP
        $pageTitle = 'Harmonisasi';
        $active = 'Harmonisasi';

        return view('pages.harmonisasi', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'navs' => $this->NavigationList(),
        ]);
    }

    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = 'pembanding' . '.' . $image->extension();
        $image->move(public_path('assets/hitung'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    public function result()
    {
        // PAGE SETUP
        $pageTitle = 'Hasil Harmonisasi';
        $active = 'Harmonisasi';

        return view('pages.harmonisasi-result', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'navs' => $this->NavigationList(),
        ]);
    }

    public function resultData()
    {
        $url = 'http://localhost:5000/harmonisasi/wordvec/pembanding';
        $data = json_decode(file_get_contents($url))->values;

        return DataTables::of($data)->make(true);
    }
}
