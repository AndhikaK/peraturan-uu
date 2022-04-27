<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HarmonisasiController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        return response()->json(['success' => $imageName]);
    }
}
