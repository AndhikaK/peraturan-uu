<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use App\Models\StemmingTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sastrawi\Stemmer\StemmerFactory;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class DraftController extends Controller
{
    use NavigationList;

    public function index(Request $request)
    {
        // PAGE SETUP
        $pageTitle = 'Drafting';
        $active = 'Drafting';
        $breadCrumbs = [
            'bx-icon' => 'bx bxs-book-content',
            'list' => [
                ['title' => 'Drafting', 'url' => route('archive.index')],
            ]
        ];
        // GET DATA
        // $categories = Category::all();
        $data = [];

        return view('pages.draft', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'data' => $data,
        ]);
    }

    public function hitungCousine(Request $request)
    {
        $dataTF = StemmingTable::get();
        // PROCESS IF dataTF NOT NULL
        if ($dataTF) {
            $stemmerFactory = new StemmerFactory;
            $stemmer = $stemmerFactory->createStemmer();

            // STEMMING THEME (menghilangkan imbuhan dan akhiran setiap kata pada tema input)
            $stemmingQuery = $stemmer->stem($request->theme);
            // TRANSFORM QUERY INTO ARRAY
            $queries = explode(' ', $stemmingQuery);
            foreach ($dataTF as $key => $value) {
                $newTF[$key] = json_decode($value->array);
            }

            foreach ($dataTF as $key => $value) {
                foreach ($newTF[$key] as $key1 => $value) {
                    $dataTF[$key]->array = $newTF[$key];
                }
            }

            $count = array();
            foreach ($dataTF as $kk => $value2) {
                $text = $value2->array;
                foreach ($text as $keykey => $value) {
                    if ($text[$keykey] == "html") {
                        unset($text[$keykey]);
                    }
                }
                $count[$kk] = array_count_values($text);
            }

            $query1 = array_count_values($queries);

            foreach ($count as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    foreach ($query1 as $key2 => $value2) {
                        if ($key1 == $key2) {
                            $kataSama[$key][$key2] = $value[$key1];
                            $topCos[$key][$key2] = $value[$key1] * $query1[$key2];
                        }
                    }
                }
            }

            $listData = Archive::with(['category'])->get();

            if (!empty($kataSama) && !empty($topCos)) {
                foreach ($kataSama as $key => $value) {
                    if (!empty($kataSama[$key]) && !empty($topCos[$key])) {
                        $newKataSama[$key] = array_sum($value);
                    }
                }
                foreach ($topCos as $key => $value) {
                    $newTopCos[$key] = array_sum($topCos[$key]);
                }

                // echo "<pre>";print_r($newTopCos[5]);die;
                foreach ($count as $key => $value) {
                    foreach ($value as $key1 => $value1) {
                        $bottomCos[$key][$key1] = pow($value[$key1], 2);
                    }
                }
                foreach ($bottomCos as $key => $value) {
                    $bottomCos[$key] = sqrt(array_sum($bottomCos[$key]));
                }
                // echo"count<pre>";print_r($bottomCos[5]);
                foreach ($query1 as $key => $value) {
                    $bottomQuery[$key] = pow($query1[$key], 2);
                }
                $bottomQuery = sqrt(array_sum($bottomQuery));
                // echo"<pre>";print_r($bottomQuery);

                foreach ($bottomCos as $key => $value) {
                    $fixBottomCos[$key] = $value * $bottomQuery;
                }
                // echo"<pre>";print_r($fixBottomCos);die;
                foreach ($newTopCos as $key => $value) {
                    $cosSim[$key] = $newTopCos[$key] / $fixBottomCos[$key];
                }
                // echo"count<pre>";print_r($newTopCos);
                // echo"count<pre>";print_r($cosSim);die;


                // $listData = $this->m_kelola->getArsip();
                foreach ($listData as $key => $value) {
                    if (!empty($newKataSama[$key])) {
                        $data[$key]['id_arsip'] = $listData[$key]->id_arsip;
                        // $data[$key]['judul_arsip'] = $listData[$key]->judul_arsip;
                        $data[$key]['judul_arsip'] = $listData[$key]->judul_arsip;
                        $data[$key]['jenis_arsip'] = $listData[$key]->jenis_arsip;
                        $data[$key]['kategori'] = $listData[$key]->category->nama_kategori;
                        $data[$key]['kataSama'] = $newKataSama[$key];
                        $data[$key]['cosSim'] = $cosSim[$key];
                    } else {
                        $data[$key]['id_arsip'] = $listData[$key]->id_arsip;
                        // $data[$key]['judul_arsip'] = $listData[$key]->judul_arsip;
                        $data[$key]['judul_arsip'] = $listData[$key]->judul_arsip;
                        $data[$key]['jenis_arsip'] = $listData[$key]->jenis_arsip;
                        $data[$key]['kategori'] = $listData[$key]->category->nama_kategori;
                        $data[$key]['kataSama'] = '0';
                        $data[$key]['cosSim'] = 0;
                    }
                }
            } else {
                foreach ($listData as $key => $value) {
                    $data[$key]['id_arsip'] = $listData[$key]->id_arsip;
                    $data[$key]['judul_arsip'] = $listData[$key]->judul_arsip;
                    $data[$key]['jenis_arsip'] = $listData[$key]->jenis_arsip;
                    $data[$key]['kategori'] = $listData[$key]->category->nama_kategori;
                    $data[$key]['kataSama'] = 0;
                    $data[$key]['cosSim'] = 0;
                }
            }

            $sort = array();
            foreach ($data as $key => $row) {
                $sort[$key] = $row['cosSim'];
            }
            array_multisort($sort, SORT_DESC, $data);
            foreach ($data as $key => $value) {
                if ($data[$key]['kataSama'] == 0) {
                    unset($data[$key]);
                }
            }

            // RETURN THE RESULT
            return DataTables::of($data)
                ->editColumn('cosSim', 'components.data-table.draft-cosSim')
                ->make(true);
        }
    }
}
