<?php

namespace App\Http\Controllers;

use Smalot\PdfParser\Parser;
use App\Models\File;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        return view('file');
    }
    public function store(Request $request)
    {

        $file = $request->file;

        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        // use of pdf parser to read content from pdf 
        $fileName = $file->getClientOriginalName();

        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($file->path());
        // get the pdf text
        $content = $pdf->getText();
        // make all char Lowercase
        $lowerContent = strtolower($content);

        // declare all data that needed for processing
        $contentLength = strlen($content);
        $totalPasal = 14;
        $pasals = [];
        $pasalsContent = [];

        // get Pasal Array through loop
        for ($i = 1; $i <= $totalPasal; $i++) {
            array_push($pasals, "pasal {$i}");
        }

        dd(strpos($lowerContent, $pasals[0] . "\t"), strpos($lowerContent, $pasals[1] . "\t"));

        $currentIndex = 0;
        while ($currentIndex < $contentLength) {
            $content = substr($lowerContent, $currentIndex, $contentLength);
            $currentPasal = 0;
            while ($currentPasal < $totalPasal) {
                // ||trpos($lowerContent, $pasals($currentPasal). "\n")
                $startT = strpos($lowerContent, $pasals[$currentPasal] . "\t");
                $startN = strpos($lowerContent, $pasals[$currentPasal] . "\n");

                if ($currentPasal < $totalPasal - 1) {
                    $endT = strpos($lowerContent, $pasals[$currentPasal + 1] . "\t");
                    $endN = strpos($lowerContent, $pasals[$currentPasal + 1] . "\n");
                } else {
                    $endT = $contentLength;
                    $endN = $contentLength;
                }

                $start = $startT ? $startT : $startN;
                $end = $endT ? $endT : $endN;

                if ($startT || $startN) {
                    // get pasalContent length
                    $n = count($pasalsContent);
                    $pasalsContent[$n]['pasal-start'] = $pasals[$currentPasal];
                    $pasalsContent[$n]['pasal-end'] = $pasals[$currentPasal == 13 ? $currentPasal : $currentPasal + 1];
                    $pasalsContent[$n]['num'] = $pasals[$currentPasal];
                    $pasalsContent[$n]['start'] = $start;
                    $pasalsContent[$n]['end'] = $end;
                    $pasalsContent[$n]['content'] = substr($content, $start, $end);
                }
                $currentPasal++;
            }
            $currentIndex = $end;
        }
        dd($pasalsContent, $lowerContent);

        return "<pre>" . $content . "</pre>";

        return redirect()->back()->with('success', 'File  submitted');
    }
}
