
// show image before update
var loadFile = function (event) {
    var output = document.getElementById("socialOutPut");
    output.src = URL.createObjectURL(event.target.files[0]);
};

$(document).ready(function () {
    if ($("#contactTable").length !== 0) {
        $("#contactTable").DataTable();
    }
});
