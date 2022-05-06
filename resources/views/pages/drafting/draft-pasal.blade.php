<div class="w-full mt-5">
    <div id="pasal-result" class="grid gap-5">
        <div class="text-center font-bold text-xl p-5 rounded-lg max-h-screen">
            <img src="{{ asset('assets/img/creative.svg') }}" class="h-2/6 mx-auto mb-5" alt="">
            Masukkan tema untuk drafting...
        </div>
    </div>
    <div id="result-paginate" class="hidden flex justify-between items-center gap-3 mt-5">
        <div>Showing 1 to 10 of 12323 entries</div>
        <div class="flex justify-end gap-3">
            <button class="btn-rounded-solid-cyan text-sm">Previous</button>
            <button class="btn-rounded-solid-cyan text-sm">Next</button>
        </div>
    </div>
</div>

@section('datatable')
    <script>
        // / DISPLAY THE TABLE
        $(document).ready(function() {
            // APPLY FILTER
            let theme = $("#theme");

            $("#applyFilter").click(function() {
                let url = "{{ route('draft.calc-pasal') }}";
                let paramUrl = getParamUrl(url);
                $.ajax({
                    type: "GET",
                    url: paramUrl,
                    success: function(response) {
                        renderData(response);
                    },
                    beforeSend: function() {
                        $('#loader').show()
                    },
                    complete: function() {
                        $('#loader').hide();
                    }
                });
            });

            function getParamUrl(url) {
                url = addParameter(url, "theme", theme.val(), false);

                return url;
            }

            function renderData(data) {
                let pasalContainer = $("#pasal-result");
                let paginatedData = paginate(data, 10, 1);

                if (paginatedData.length > 0) {
                    pasalContainer.html('')

                    paginatedData.forEach((element) => {
                        let uudId = element.uud_id.trim()
                        uudId = uudId.replaceAll(' ', ' > ')
                        uudId = uudId.replaceAll('~', ' ')
                        let comp =
                            "<div class='p-5 bg-white border border-slate-300 rounded-xl ease-in-out duration-300 hover:shadow-lg'>" +
                            `<a data-bs-toggle='collapse' href='#collapseExample${element.id}' role='button' aria-expanded='false' aria-controls='collapseExample${element.id}'>` +
                            "<div class='grid grid-cols-[1fr_auto] gap-2'>" +
                            "<div class=''>" +
                            `<div class='text-lg font-bold'>${element.uu} - <span class='text-cyan-600 '>${element.tentang}</span></div>` +
                            `<div class='text-sm capitalize'>${uudId}</div></div>` +
                            "<div class='grid place-items-center'><i class='bx bxs-chevron-down-circle text-sky-600 text-lg'></i></div></div>" +
                            "</a>" +
                            `<div class='collapse' id='collapseExample${element.id}'>` +
                            "<div class='pt-4'>" +
                            `${element.uud_content}` +
                            "</div>" +
                            "</div>" +
                            "<div class='pt-3 mt-2 flex justify-between items-center border-t border-t-slate-100'>" +
                            "<div class='font-bold text-cyan-600'>" +
                            `${element.presentase}` +
                            "</div>" +
                            "<div>" +
                            "<div id='ck-button' class='rounded-full border px-3 hover:bg-slate-300 hover:text-slate-800'>" +
                            "<label>" +
                            `<input class='checkboxes ' type='checkbox' value='${element.id}' onchange='toggleChecked(this)'><span>Check</span>` +
                            "</label>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                        pasalContainer.append(comp);
                    });
                    $totalPage = parseInt(data.length / 10)
                } else {
                    pasalContainer.html('')
                    let emptyContainer =
                        "<div class='text-center font-bold text-xl p-5 rounded-lg'>" +
                        "<img src='/assets/img/empty.svg' class='h-2/6 mx-auto mb-5'>" +
                        "Tidak ditemukan similaritas antar pasal" +
                        "</div>";
                    pasalContainer.append(emptyContainer)
                }
            }

            const paginate = (array, pageSize, pageNumber) => {
                return array.slice((pageNumber - 1) * pageSize, pageNumber * pageSize);
            };

        });

        let selected = []

        function toggleChecked(el) {
            if ($(el).prop("checked")) {
                $(el).attr("checked", false);
                $(el).siblings("span").html("Checked");
                $(el).parents().eq(1).toggleClass("bg-cyan-600");
            } else {
                $(el).attr("checked", true);
                $(el).siblings("span").html("Check");
                $(el).parents().eq(1).toggleClass("bg-cyan-600");
            }

            countSelected()
            console.log(selected)
        }

        function countSelected() {
            selected = []
            $("input:checkbox.checkboxes").each(function() {
                if ($(this).prop('checked')) {
                    selected.push($(this).val())
                }
            })

        }
    </script>
@endsection
