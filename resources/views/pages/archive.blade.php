@extends('layouts.index-layout')

@section('content')
    <div class="grid md:grid-cols-[1fr_3fr] gap-3">
        {{-- FILTER --}}
        <div class="p-2">
            <div class="font-semibold">Filter</div>
            {{-- FILTER FORM --}}
            <div class="mt-5 w-full shadow-md">
                <form class="bg-white rounded px-3 pt-6 pb-8 mb-4">
                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="username">
                            Kategori
                        </label>
                        <select name="category"
                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($categories as $category)
                                <option value="{{ $category->kategori_id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>

                    </div>
                    <button
                        class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button">
                        Filter
                    </button>
                </form>
            </div>
        </div>
        {{-- ARCHIVE --}}
        <div class="p-3">
            <div class="font-semibold">Arsip </div>
            <div class="mt-5 w-full shadow-md">
                <table class="table-auto w-full border-collapse border border-slate-400">
                    <thead class="">
                        <tr class="bg-slate-300">
                            <th class="border border-slate-300 p-2">No</th>
                            <th class="border border-slate-300 p-2">Peraturan</th>
                            <th class="border border-slate-300 p-2">Tentang</th>
                            <th class="border border-slate-300 p-2">
                                <i class='bx bxs-download'></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($archives as $archive)
                            <tr class="">
                                <td class=" border border-slate-300 p-2 text-center">{{ $i++ }}</td>
                                <td class=" border border-slate-300 p-2">{{ $archive->judul_arsip }}</td>
                                <td class=" border border-slate-300 p-2">{{ $archive->jenis_arsip }}</td>
                                <td class=" border border-slate-300 p-2">
                                    <a href="">Unduh</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
