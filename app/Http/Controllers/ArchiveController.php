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
        $pageTitle = 'Arsip Undang-Undang';
        $breadCrumbs = [
            ['title' => 'Arsip', 'url' => ''],
            ['title' => 'Data', 'url' => ''],
        ];
        // GET DATA
        $categories = Category::all();
        $archives = Archive::with(['category'])->get();

        return view('pages.archive', [
            'pageTitle' => $pageTitle,
            'breadCrumbs' => $breadCrumbs,
            'categories' => $categories,
            'archives' => $archives,
        ]);
    }

    public function getData()
    {
        $data = Archive::select(['id_arsip', 'judul_arsip', 'jenis_arsip', 'status', 'id_kategori']);

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
