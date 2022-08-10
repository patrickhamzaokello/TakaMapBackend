$(document).ready(function () {
    const loaderdiv = document.querySelector(".loaderdiv");
    const loaderdiv_displaySetting = loaderdiv.style.display;


    $("form").submit(function (event) {
        if (loaderdiv_displaySetting == "block") {
            loaderdiv.style.display = "none";
        } else {
            loaderdiv.style.display = "grid";
        }

        const endPoint = "processors/process_addInfrastructureType.php";
        var formdata = new FormData();


        var type = $("input#typeID").val();
        const inputfile = document.getElementById("file_input_map_icon");




        if (!type) {
            $("#error").fadeIn().text("Enter Infrastructure Type");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }

        if (inputfile.files["length"] == 0) {
            $("#error").fadeIn().text("Choose Cover Picture. Use 300 x 300 image");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }

        //check image size should be < 3.6M
        if (inputfile.files[0]["size"] > 3620127) {
            $("#error").fadeIn().text("Image is too large. Use 300 x 300 image");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }

        //check if file is added
        if (inputfile.files[0]["size"] < 0) {
            $("#error").fadeIn().text("Add Cover Image. Use 300 x 300 image");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 2000);
            return false;
        }


        formdata.append("type", type);
        formdata.append("inputfile", inputfile.files[0]);



        fetch(endPoint, {
            method: "post",
            body: formdata,
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success) {
                    console.log("failure" + data);
                    $(".sponsormessagediv").html(
                        '<div Functions="alert alert-error">' + data.message + "</div>"
                    );
                    setTimeout(function () {
                        $(".sponsormessagediv").html("");
                        loaderdiv.style.display = "none";
                    }, 4000);
                } else {
                    console.log("success" + data);
                    $(".sponsormessagediv").html(
                        '<div Functions="alert alert-success">' + data.message + "</div>"
                    );
                    setTimeout(function () {
                        $(".sponsormessagediv").html("");
                        loaderdiv.style.display = "none";
                    }, 4000);

                    window.location.href = "infrastructure_types";
                }
            })
            .catch(console.error);

        event.preventDefault();
    });

});

