<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;
use Yajra\DataTables\Facades\DataTables;

class ArchiveController extends Controller
{
    use NavigationList;

    public function index()
    {
        // PAGE SETUP
        $pageTitle = 'Arsip';
        $active = 'Arsip';
        $breadCrumbs = [
            'bx-icon' => 'bx bx-notepad',
            'list' => [
                ['title' => 'Arsip', 'url' => route('archive.index')],
            ]

        ];
        // GET DATA
        $categories = Category::all();

        return view('pages.archive-v2', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'categories' => $categories,
        ]);
    }

    public function getData(Request $request)
    {
        $data = Archive::select(['id_arsip', 'judul_arsip', 'jenis_arsip', 'status', 'id_kategori']);

        if ($request->category) {
            $data->where('id_kategori', $request->category);
        }

        return DataTables::of($data)->make(true);

        // return DataTables::of($data)
        //     ->editColumn('created_at', function ($data) {
        //         return $data->created_at->format('d-m-Y');
        //     })
        //     ->editColumn('updated_at', function ($data) {
        //         return $data->updated_at->format('d-m-Y');
        //     })
        //     ->addColumn('checkbox', 'components.admin.table.checkbox')
        //     ->addColumn('action', function ($row) use ($roles) {
        //         return view('components.admin.table.manage-account__action', compact(['row', 'roles']));
        //     })
        //     ->rawColumns(['checkbox', 'action'])
        //     ->make(true);
    }

    public function create()
    {
        // PAGE SETUP
        $pageTitle = 'Arsip';
        $active = 'Arsip';
        $breadCrumbs = [
            'bx-icon' => 'bx bx-notepad',
            'list' => [
                ['title' => 'Arsip', 'url' => route('archive.index')],
                ['title' => 'Arsip Baru', 'url' => ''],
            ]

        ];
        // GET DATA
        $categories = Category::all();

        return view('pages.archive-create', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'categories' => $categories,
        ]);
    }

    public function createFile()
    {
        // PAGE SETUP
        $pageTitle = 'Upload Arsip';
        $active = 'Arsip';
        $breadCrumbs = [
            'bx-icon' => 'bx bx-notepad',
            'list' => [
                ['title' => 'Arsip', 'url' => route('archive.index')],
                ['title' => 'Arsip Baru', 'url' => route('archive.create')],
                ['title' => 'Upload', 'url' => ''],
            ]

        ];
        // GET DATA
        $categories = Category::all();

        return view('pages.archive-file-create', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'categories' => $categories,
        ]);
    }

    public function fileStore(Request $request)
    {
        // dd('this is soter');
        $file = $request->archive;

        $request->validate([
            // 'file' => 'required|mimes:pdf',
        ]);

        // use of pdf parser to read content from pdf 
        $fileName = $file->getClientOriginalName();

        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($file->path());
        // get the pdf text
        $content = $pdf->getText();
        // make all char Lowercase
        $contentLowerCase = strtolower($content);
        // explode by \n
        $arrContent = explode("\n", $contentLowerCase);

        // REQURED INFORMATION
        $totalPasal = 62;
        $indexedPasal = [];

        $i = 0;
        foreach ($arrContent as $idx => $content) {
            if (strlen($content) < 15) {
                if (str_contains($content, 'pasal')) {
                    $indexedPasal[$i]['index'] = $idx;
                    $indexedPasal[$i]['n'] = strlen($content);
                    $indexedPasal[$i]['content'] = $content;
                    $i++;
                }
            }
        }

        $pasalContent = [];
        $i = 0;
        foreach ($indexedPasal as $idx => $content) {
            // EXTRACT EVERYTHING EXCEPT THE LAST INDEX
            if ($idx < count($indexedPasal) - 1) {
                $pasalContent[$idx]['title'] = $content['content'];
                $pasalContent[$idx]['content'] = array_slice($arrContent, $content['index'], $indexedPasal[$idx + 1]['index'] - $content['index']);
            }
            // EXTRAXT THE LAST INDEX
            if ($idx == count($indexedPasal) - 1) {
                $pasalContent[$idx]['title'] = $content['content'];
                $pasalContent[$idx]['content'] = array_slice($arrContent, $content['index']);
            }
        }

        dd($pasalContent);
        // dd($indexedPasal, $arrContent);
    }
}
