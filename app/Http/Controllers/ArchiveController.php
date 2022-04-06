<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        // PAGE SETUP
        $pageTitle = 'Arsip';
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
}
