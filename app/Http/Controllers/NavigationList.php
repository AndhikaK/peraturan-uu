<?php

namespace App\Http\Controllers;

trait NavigationList
{
    public function NavigationList()
    {
        return [
            ['title' => 'Beranda', 'route' => route('index')],
            ['title' => 'Arsip', 'route' => route('archive.index')],
            ['title' => 'Drafting', 'route' => route('draft.index')],
        ];
    }
}
