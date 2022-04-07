<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArchiveController extends Controller
{
    public function index()
    {
        // PAGE SETUP
        $pageTitle = 'Arsip';
        $active = 'Arsip';
        $breadCrumbs = [
            'bx-icon' => 'bx bx-notepad',
            'list' => [
                ['title' => 'Beranda', 'url' => route('index')],
                ['title' => 'Arsip', 'url' => ''],
            ]

        ];
        // GET DATA
        $categories = Category::all();

        return view('pages.archive-v2', [
            'pageTitle' => $pageTitle,
            'breadCrumbs' => $breadCrumbs,
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
}
