$(".copy_text").click(function (e) {
    e.preventDefault();
    var copyText = $(this).attr("href");

    document.addEventListener(
        "copy",
        function (e) {
            e.clipboardData.setData("text/plain", copyText);
            e.preventDefault();
        },
        true
    );

    document.execCommand("copy");
    toastr.options.positionClass = "toast-bottom-right";
    toastr.success("Copy url successfull!!");
});

