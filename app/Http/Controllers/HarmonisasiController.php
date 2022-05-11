<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HarmonisasiController extends Controller
{
    use NavigationList;
    use PrepareArchive;

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

        return DataTables::of($data)
            ->addColumn('file_arsip', function ($row) {
                return view('components.data-table.harmonisasi-file', compact(['row']));
            })
            ->make(true);
    }

    public function resultDetail(Request $request)
    {
        // PAGE SETUP
        $pageTitle = 'Detail Harmonisasi';
        $active = 'Harmonisasi';

        //  GET ARCHIVE AND PEMBANDING
        $archive = Archive::find($request->archive);

        // return back if not parameter is not valid or when there is no archive found
        if (!$request->archive || !$archive) {
            return redirect(route('harmonisasi.result'))->with('failed', 'Something wrong!');
        }
        // EXTRACT PDF CONTENTS
        // $pembandingPath = public_path('\assets\hitung\pembanding.pdf');
        $pembandingPath = asset('assets/hitung/pembanding.pdf');
        $archivePath = asset('assets/pdf/' . $archive->file_arsip);
        // $archivePath = public_path('\assets\pdf\\' . $archive->file_arsip);

        return view('pages.harmonisasi.result-detail', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'navs' => $this->NavigationList(),
            'pembandingPath' => $pembandingPath,
            'archivePath' => $archivePath,
            'archive' => $archive,
        ]);
    }
}
