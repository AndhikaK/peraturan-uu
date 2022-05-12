<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use App\Models\Pasal;
use App\Models\PreprocessingPasal;
use App\Models\Stemming;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Foreach_;
use Smalot\PdfParser\Parser;
use Yajra\DataTables\Facades\DataTables;
use File;

class ArchiveController extends Controller
{
    use NavigationList;
    use PrepareArchive;

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
        $categories = Category::get();

        return view('pages.archive.index', [
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
        $data = Archive::with(['category'])->select(['id_tbl_uu', 'uu', 'tentang', 'status', 'id_kategori', 'file_arsip']);

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

    public function show($id)
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

        $archive = Archive::with(['category'])->find($id);
        $pasals = Pasal::where('id_tbl_uu', $id)
            ->where(function ($query) {
                $query->where('uud_section', 'pasal')
                    ->orWhere('uud_section', 'ayat');
            })
            ->orderBy('id')->get();

        return view('pages.archive.show', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'archive' => $archive,
            'pasals' => $pasals,
        ]);
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

        return view('pages.archive.create', [
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
        // VALIDATE REQUEST INPUT
        $request->validate([
            'uu' => 'required',
            'tentang' => 'required',
            'category' => 'required'
        ]);

        // try {
        $fileName = '';
        if ($request->fromFileUpload == 'false') {
            // SAVE ARCHIVE FILE PDF
            $file = $request->file('arsip');
            $fileName = 'NewArsip-' . time() . '.' . $file->extension();
        } else {
            // COPY TEMP FILE TO A NEW FOLDER
            $oldFile = public_path() . '\assets\hitung\temp-archive.pdf';
            $newFile = 'NewArsip-' . time() . '.pdf';
            if (!copy($oldFile, public_path('\assets\pdf\\' . $newFile))) {
                return redirect(route('archive.index'))->with('failed', 'Copy file failed!');
            }
            $fileName = $newFile;
        }

        $archive = Archive::create([
            'uu' => $request->uu,
            'tentang' => $request->tentang,
            'file_arsip' => $fileName,
            'id_kategori' => $request->category,
            'text' => 'empty',
            'status' => 1,
        ]);

        $this->simpan($archive);
        // PROCESS PASAL AYAT
        $pasalUpload = [];
        foreach ($request->all() as $key => $item) {
            if (str_contains($key, 'pasal')) {
                $data = [];
                $data['id_tbl_uu'] = $archive->id_tbl_uu;
                $data['uud_id'] = str_replace("_", ' ', $key);
                $data['uud_section'] = 'ayat';
                $data['uud_content'] = str_replace("\r\n", '<br>', $item);;
                array_push($pasalUpload, $data);
            }
        }
        // INSERT PASAL RECORD
        foreach ($pasalUpload as $item) {
            $insert = Pasal::create(
                $item
            );
            // PRERPOCESS FOR PASAL THROUGH OMNILAW FLASK APP
            $this->simpanPasal($insert);
        }

        // } catch (Exception $e) {
        //     dd($e);
        //     return redirect(route('archive.index'))->with('failed', 'Something wrong!');
        // }
        return redirect(route('archive.index'))->with('success', 'Data Undang-Undang berhasil disimpan!');
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

        return view('pages.archive.create-file', [
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
        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);
        $image = $request->file('file');

        $imageName = 'temp-archive' . '.' . $image->extension();
        $image->move(public_path('assets/hitung'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    public function fileProcess(Request $request)
    {
        // dd(asset('assets/hitung/temp-archive.pdf'));
        // dd('this is soter');
        // $file = $request->archive;

        // $request->validate([
        //     'archive' => 'required|mimes:pdf',
        // ]);

        // use of pdf parser to read content from pdf 
        // $fileName = $file->getClientOriginalName();
        $pdfPath = public_path() . '\assets\hitung\temp-archive.pdf';
        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($pdfPath);
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

        return view('pages.archive.create', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'categories' => $categories,
            'result' => $pasalAyat,
            'fromFileUpload' => true,
        ]);
    }

    public function edit($id)
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
        $categories = Category::get();
        $archive = Archive::with(['category'])->find($id);
        $pasals = Pasal::where('id_tbl_uu', $id)
            ->where(function ($query) {
                $query->where('uud_section', 'pasal')
                    ->orWhere('uud_section', 'ayat');
            })
            ->orderBy('id')->get();

        $result = [];
        $tempPasal = '';
        foreach ($pasals as $pasal) {
            $arrPasal = explode(' ', $pasal->uud_id);
            $pasalTitle = count($arrPasal) <= 1 ? $pasal->uud_id : $arrPasal[0];
            $pasalTitle = str_replace('~', ' ', $pasalTitle);
            $noPasal = explode(' ', $pasalTitle);
            $noPasal = count($noPasal) > 1 ? $noPasal[1] : $pasalTitle;

            if ($noPasal == $tempPasal) {
                $iPasal = count($result) - 1;
                array_push($result[$iPasal]['content'], $pasal->uud_content);
            } else {
                $data = [];
                $data['title'] = $pasalTitle;
                $data['content'] = [];
                $pasal->uud_content = str_replace('<br>', "\r\n", $pasal->uud_content);
                array_push($data['content'], $pasal->uud_content);
                array_push($result, $data);
            }
            $tempPasal = $noPasal;
        }

        return view('pages.archive.edit', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'archive' => $archive,
            'result' => $result,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        // VALIDATE REQUEST INPUT
        $request->validate([
            'uu' => 'required',
            'tentang' => 'required',
            'category' => 'required'
        ]);

        try {
            // SAVE ARCHIVE FILE PDF
            $dataToUpdate = [
                'uu' => $request->uu,
                'tentang' => $request->tentang,
                'id_kategori' => $request->category,
                'status' => 1,
            ];
            $fileName = '';
            // SAVE ARCHVE FILE IN FOLDER
            if ($request->arsip) {
                $file = $request->file('arsip');
                $fileName = 'NewArsip-' . time() . '.' . $file->extension();
                $file->move(public_path('assets/pdf'), $fileName);
                $dataToUpdate['file_arsip'] = $fileName;
            }

            $archive = Archive::find($id)
                ->update(
                    $dataToUpdate
                );
            // DELETE EXISTING PASAL BEFORE INSERTING A NEW ONE AGAIN
            $pasals = Pasal::where('id_tbl_uu', $id);
            foreach ($pasals as $pasal) {
                $pasalID = $pasal->id;
                // $pasal->delete();
                $prepPasal = PreprocessingPasal::find($pasalID);
                if ($prepPasal) {
                    $prepPasal->delete();
                }
            }
            $pasals->delete();
            // PROCESS PASAL AYAT
            $pasalUpload = [];
            foreach ($request->all() as $key => $item) {
                if (str_contains($key, 'pasal')) {
                    $data = [];
                    $data['id_tbl_uu'] = $id;
                    $data['uud_id'] = str_replace("_", ' ', $key);
                    $data['uud_section'] = 'ayat';
                    $data['uud_content'] = str_replace("\r\n", '<br>', $item);;
                    array_push($pasalUpload, $data);
                }
            }
            // INSERT PASAL RECORD
            foreach ($pasalUpload as $item) {
                $pasalU = Pasal::create(
                    $item
                );
                $this->simpanPasal($pasalU);
            }
        } catch (Exception $e) {
            return redirect(route('archive.show', $id))->with('failed', 'Something wrong!');
        }
        return redirect(route('archive.show', $id))->with('success', 'Data Undang-Undang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $archive = Archive::find($id)->delete();
            $stemming = Stemming::where('id_tbl_uu', $id)->first();
            if ($stemming) {
                $stemming->delete();
            }

            $pasals = Pasal::where('id_tbl_uu', $id)->get();
            foreach ($pasals as $pasal) {
                $idPasal = $pasal->id;
                $pasal->delete();
                $prepPasal = PreprocessingPasal::find($idPasal);
                if ($prepPasal) {
                    $prepPasal->delete();
                }
            }
        } catch (Exception $e) {
            return redirect(route('archive.index'))->with('failed', 'Something wrong!');
        }

        return redirect(route('archive.index'))->with('success', 'Arsip berhasil dihapus!');
    }
}
