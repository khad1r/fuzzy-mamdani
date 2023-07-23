var loadingPage = document.querySelector(".loading-Page");
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".modal.addEdit")) {
        var myModal = new bootstrap.Modal(
            document.querySelector(".modal.addEdit"),
            {}
        );
        myModal.show();
    }
    // var alert = new bootstrap.Alert(document.querySelector(".alert"));
    // setTimeout(function () {
    //     alert.close();
    // }, 5000);
    loadingPage.style.display = "none";
});
