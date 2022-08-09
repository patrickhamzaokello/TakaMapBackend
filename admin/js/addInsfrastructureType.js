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



        if (!type) {
            $("#error").fadeIn().text("Enter Infrastructure Type");
            loaderdiv.style.display = "none";

            setTimeout(function () {
                $("#error").hide();
            }, 10000);
            return false;
        }




        formdata.append("type", type);



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

                    window.location.href = "../index.php";
                }
            })
            .catch(console.error);

        event.preventDefault();
    });

});

