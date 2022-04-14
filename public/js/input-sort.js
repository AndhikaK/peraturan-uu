$(function () {
    $("#sortable-input").sortable({
        handle: ".header",
        update: function () {
            updateLabel();
        },
    });

    $("#sortable-input .content").sortable({
        handle: ".content-grab",
        update: function (event, item) {
            updateLabel();
        },
    });

    const updateLabel = () => {
        var listItems = $("#sortable-input li");
        listItems.each(function (idx, li) {
            // CHANGING PASAL TITLE
            var product = $(li).find(".title");
            product.html(`Pasal ${idx + 1}`);

            var listInputItems = $(li).find(".content-item");
            listInputItems.each(function (i, listInput) {
                var ayatTitle = $(listInput).find(".ayat-title");
                ayatTitle.html(`Ayat ${i + 1}`);
                var ayatInput = $(listInput).find(".ayat-input");
                ayatInput.attr("name", `pasal~${idx + 1}-ayat~${i + 1}`);
            });
        });
    };

    updateLabel();
});
