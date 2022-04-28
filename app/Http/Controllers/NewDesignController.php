<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class NewDesignController extends Controller
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

        return view('layouts.app-layout', [
            'user' => Auth::user(),
            'pageTitle' => $pageTitle,
            'active' => $active,
            'breadCrumbs' => $breadCrumbs,
            'navs' => $this->NavigationList(),
            'categories' => $categories,
        ]);
    }
}
