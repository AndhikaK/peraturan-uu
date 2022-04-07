<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $pageTitle = 'Arsip';
        $breadCrumbs = [
            'bx-icon' => 'bx bx-notepad',
            'list' => [
                ['title' => 'Data', 'url' => ''],
                ['title' => 'Arsip', 'url' => ''],
            ]

        ];
        // return view('pages.index');
        return view('layouts.app-layout', [
            'pageTitle' => $pageTitle,
            'breadCrumbs' => $breadCrumbs,
        ]);
    }
}
