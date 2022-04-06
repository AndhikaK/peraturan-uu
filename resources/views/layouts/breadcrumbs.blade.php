<nav class="mb-5">
    <ol class="inline-flex gap-2">
        @foreach ($breadCrumbs as $key => $crumbs)
            <li
                class="font-semibold text-slate-700 hover:text-slate-900 hover:underline last:hover:no-underline last:text-slate-400 last:hover:text-slate-400 ">
                <a href="{{ $crumbs['url'] }}">
                    {{ $crumbs['title'] }}
                </a>
            </li class="text-slate-700">
            @if ($key != count($breadCrumbs) - 1)
                <li>/</li>
            @endif
        @endforeach
    </ol>
</nav>
