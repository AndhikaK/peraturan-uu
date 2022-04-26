<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;
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
        $data = Archive::with(['category'])->select(['id_arsip', 'judul_arsip', 'jenis_arsip', 'status', 'id_kategori', 'file_arsip']);

        if ($request->category) {
            $data->where('id_kategori', $request->category);
        }

        return DataTables::of($data)
            ->editColumn('id_kategori', function ($row) {
                return $row->category->nama_kategori;
            })
            ->addColumn('status', function ($row) {
                return view('components.data-table.archive-status', compact(['row']));
            })
            ->addColumn('file_arsip', function ($row) {
                return view('components.data-table.archive-file', compact(['row']));
            })
            ->rawColumns(['status'])
            ->make(true);
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
            ],
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

    public function store(Request $request)
    {
        dd($request->all());
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

    public function createFileConfirmation($data)
    {
    }

    public function fileStore(Request $request)
    {
        // dd('this is soter');
        $file = $request->archive;

        $request->validate([
            'archive' => 'required|mimes:pdf',
        ]);

        // use of pdf parser to read content from pdf 
        $fileName = $file->getClientOriginalName();

        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($file->path());
        // get the pdf text
        $content = $pdf->getText();
        // make all char Lowercase
        // $contentLowerCase = strtolower($content);
        // remove tab
        $content = str_replace("\t", '', $content);
        // explode by \n
        $arrContent = explode("\n", $content);

        // REQURED INFORMATION
        $totalPasal = 62;
        $indexedPasal = [];

        // TRIM ALL SPACES INSIDE ARRAY DOCUMENT
        for ($i = 0; $i < count($arrContent); $i++) {
            $arrContent[$i] = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $arrContent[$i]);
            $arrContent[$i] = preg_replace('/\h+/u', ' ', $arrContent[$i]);
        }

        // REMOVE UNNECESSARY ARRAY
        $tempContent = '';
        for ($i = count($arrContent) - 1; $i >= 0; $i--) {
            if (strlen($arrContent[$i]) == 0) {
                array_splice($arrContent, $i, 1);
                continue;
            }
            if ($arrContent[$i] == $tempContent) {
                array_splice($arrContent, $i, 2);
                $tempContent = '';
                continue;
            }

            if (str_contains($arrContent[$i], ". . .")) {
                array_splice($arrContent, $i, 1);
                continue;
            }
            $tempContent = $arrContent[$i];
        }

        // CHANGE FONT TO LOWERCASE
        $arrContentLowerCase = [];
        $i = 0;
        foreach ($arrContent as $content) {
            $arrContentLowerCase[$i] = strtolower($content);
            $i++;
        }

        // dd($arrContent, $arrContentLowerCase);

        $i = 0;
        $listPasal = [];
        foreach ($arrContentLowerCase as $idx => $content) {
            // $content = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $content);
            if (in_array($content, $listPasal)) {
                break;
            }

            if (strlen($content) < 15) {
                if (str_contains($content, 'pasal')) {
                    $indexedPasal[$i]['index'] = $idx;
                    $indexedPasal[$i]['content'] = $content;
                    array_push($listPasal, $content);
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
                $pasalContent[$idx]['content'] = array_slice($arrContent, $content['index'] + 1, $indexedPasal[$idx + 1]['index'] - $content['index'] - 1);
            }
            // EXTRAXT THE LAST INDEX
            if ($idx == count($indexedPasal) - 1) {
                $pasalContent[$idx]['title'] = $content['content'];
                // $pasalContent[$idx]['content'] = array_slice($arrContentLowerCase, $content['index']);
                $pasalContent[$idx]['content'][0] = 'Undang-Undang ini mulai berlaku pada saat diundangkan';
            }
        }

        // DIVIDE THE PASAL CONTENT BASED ON AYAT
        $pasalAyat = [];
        $i = 0;
        foreach ($pasalContent as $pasal) {
            $pasalAyat[$i]['title'] = $pasal['title'];
            $pasalAyat[$i]['content'] = [];
            $currentAyat = 1;
            foreach ($pasal['content'] as $ayat) {
                $firstWord = explode(' ', $ayat)[0];
                $firstWordLength = strlen($firstWord);
                $firstChar = substr($firstWord, 0, 1);
                $midleChar = substr($firstWord, 1, $firstWordLength - 2);
                $lastChar = substr($firstWord, -1);
                $arrayLength = count($pasalAyat[$i]['content']);
                if ($firstChar == '(' && $lastChar == ')') {
                    if (is_numeric($midleChar)) {
                        if (empty($pasalAyat[$i]['content'])) {
                            array_push($pasalAyat[$i]['content'], $ayat);
                        } else {
                            if ($midleChar == $currentAyat + 1) {
                                array_push($pasalAyat[$i]['content'], $ayat);
                                $currentAyat++;
                            } else {
                                $divider = $firstWordLength == 2 && $firstWord[1] == '.' ? "\n" : ' ';
                                $pasalAyat[$i]['content'][$arrayLength - 1] .= $divider . $ayat;
                            }
                        }
                    } else {
                        $divider = $firstWordLength == 2 && $firstWord[1] == '.' ? "\n" : ' ';
                        $pasalAyat[$i]['content'][$arrayLength - 1] .= $divider . $ayat;
                    }
                } else {
                    if (empty($pasalAyat[$i]['content'])) {
                        array_push($pasalAyat[$i]['content'], $ayat);
                    } else {
                        $divider = $firstWordLength == 2 && $firstWord[1] == '.' ? "\n" : ' ';
                        $pasalAyat[$i]['content'][$arrayLength - 1] .= $divider . $ayat;
                    }
                }
            }
            $i++;
        }

        // dd($pasalAyat);

        // PAGE SETUP
        $pageTitle = 'Konfirmasi Arsip';
        $active = 'Arsip';
        $breadCrumbs = [
            'bx-icon' => 'bx bx-notepad',
            'list' => [
                ['title' => 'Arsip', 'url' => route('archive.index')],
                ['title' => 'Arsip Baru', 'url' => route('archive.create')],
                ['title' => 'Upload', 'url' => ''],
                ['title' => 'Konfirmasi', 'url' => ''],
            ]

        ];
        // GET DATA
        $categories = Category::all();

        return view('pages.archive-file-create-confirmation', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'categories' => $categories,
            'result' => $pasalAyat,
        ]);
    }
}
