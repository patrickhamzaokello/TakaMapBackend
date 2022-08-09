$(document).ready(function () {
    const loaderdiv = document.querySelector(".loaderdiv");
    const loaderdiv_displaySetting = loaderdiv.style.display;


    $("form").submit(function (event) {
        if (loaderdiv_displaySetting == "block") {
            loaderdiv.style.display = "none";
        } else {
            loaderdiv.style.display = "grid";
        }

        const endPoint = "processors/process_addInfrastructure.php";
        var formdata = new FormData();


        var aimID = $("input#aimID").val();
        var type = $("select#typeID").val();
        var longitude = $("input#longitudeID").val();
        var latitude = $("input#latitudeID").val();
        var description = $("#descriptionID").val();


        if (!aimID) {
            $("#error").fadeIn().text("Provide Infrastructure Aim");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }

        if (!type || type == '0') {
            $("#error").fadeIn().text("Enter Infrastructure Type");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }

        if (!longitude) {
            $("#error").fadeIn().text("Enter Infrastructure Longitude");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }

        if (!latitude) {
            $("#error").fadeIn().text("Enter Infrastructure Latitude");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }
        if (!description) {
            $("#error").fadeIn().text("Provide Infrastructure Description");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }



        formdata.append("aim", aimID);
        formdata.append("type", type);
        formdata.append("longitude", longitude);
        formdata.append("latitude", latitude);
        formdata.append("description", description);



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

                    window.location.href = "manage.php";
                }
            })
            .catch(console.error);

        event.preventDefault();
    });

});

