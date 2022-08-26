const loaderdiv = document.querySelector(".loaderdiv");
const loaderdiv_displaySetting = loaderdiv.style.display;

$(document).ready(function () {
    $("form").submit(function (event) {
        const endPoint = "public_process/send_report.php";
        var formdata = new FormData();

        if (loaderdiv_displaySetting == "block") {
            loaderdiv.style.display = "none";
        } else {
            loaderdiv.style.display = "grid";
        }
        var Name = $("input#Name").val();
        var Contact = $("input#Contact").val();
        var Title = $("input#Title").val();
        var Address = $("input#Address").val();
        var Description = $("textarea#Description").val();


        if (!Name) {
            $("#error").fadeIn().text("Please provide name");
            loaderdiv.style.display = "none";
            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }
        if (!Contact) {
            $("#error").fadeIn().text("Please provide contact");
            loaderdiv.style.display = "none";
            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }
        if (!Title) {
            $("#error").fadeIn().text("Please provide report title");
            loaderdiv.style.display = "none";
            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }
        if (!Address) {
            $("#error").fadeIn().text("Please provide report Address");
            loaderdiv.style.display = "none";
            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }
        if (!Description) {
            $("#error").fadeIn().text("Please provide report Description");
            loaderdiv.style.display = "none";
            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }

        formdata.append("Name",Name);
        formdata.append("Contact",Contact);
        formdata.append("Address",Address);
        formdata.append("Title",Title);
        formdata.append("Description",Description);

        console.log(Description);

        fetch(endPoint, {
            method: "post",
            body: formdata,
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success) {
                    console.log("failure" + data);
                    $(".form_error_div").html(
                        '<div Functions="alert alert-error">' + data.message + "</div>"
                    );
                    setTimeout(function () {
                        $(".form_error_div").html("");
                        loaderdiv.style.display = "none";
                    }, 4000);
                } else {
                    console.log("success" + data);
                    $(".form_error_div").html(
                        '<div Functions="alert alert-success">' + data.message + "</div>"
                    );
                    setTimeout(function () {
                        $(".form_error_div").html("");
                        loaderdiv.style.display = "none";
                    }, 4000);

                    window.location.href = "report.php ";
                }
            })
            .catch(console.error);

        event.preventDefault();
    });

});