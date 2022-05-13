$(document).scroll(function () {
    myID = document.getElementById("scrollToBottom");

    var myScrollFunc = function () {
        var y = window.scrollY;
        if (y >= 100) {
            myID.className =
                "grid place-items-center text-white animate-bounce rounded-full h-10 w-10 bg-sky-600 fixed right-8 bottom-8 opacity-100 ease-out";
        } else {
            myID.className =
                "grid place-items-center text-white animate-bounce rounded-full h-10 w-10 bg-sky-600 fixed right-8 bottom-8 opacity-0 ease-out";
        }
    };

    window.addEventListener("scroll", myScrollFunc);
});
