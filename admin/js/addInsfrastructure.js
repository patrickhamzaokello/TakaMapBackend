const approveOrderBtn = document.querySelectorAll(".approvebutton_parent");
const cancelORderBTn = document.querySelectorAll(".cancebutton_parent");
const cardinput_id = document.querySelector("#ins_type_id");

const createnewBTN = document.querySelectorAll(".createnewbtn");
const sponsorshipform = document.querySelector(".sponserdiv");
const loaderdiv = document.querySelector(".loaderdiv");

const deleteorder_info = document.querySelector(".deleteorder");
const approveorderform_info = document.querySelector(".approveorderform");

const displaySetting = sponsorshipform.style.display;
const loaderdiv_displaySetting = loaderdiv.style.display;

const btnloader = document.querySelector("#btnloader");

// order action 1- create 2- update, 3 - delete
var form_action;

createnewBTN.forEach((productCard) => {
    // Make whole card clickable, but only if event target is NOT a specific card action inside <div Functions="product-card__actions">.
    productCard.addEventListener("click", (e) => {
        if (e.target.closest(".product-card__actions") === null) {
            if (displaySetting == "block") {
                sponsorshipform.style.display = "none";
            } else {
                sponsorshipform.style.display = "grid";
            }

            form_action = 1;
            $("#error").hide();
        }
    });
});

approveOrderBtn.forEach((productCard) => {
    const childNamegot = productCard.querySelector(".cardID").value;
    const ins_aim = productCard.querySelector(".cardAIM").value;
    const typeID = productCard.querySelector(".typeID").value;
    const longVAL = productCard.querySelector(".longVAL").value;
    const latVAL = productCard.querySelector(".latVAL").value;
    const desVAL = productCard.querySelector(".desVAL").value;


    // Make whole card clickable, but only if event target is NOT a specific card action inside <div Functions="product-card__actions">.
    productCard.addEventListener("click", (e) => {
        if (e.target.closest(".product-card__actions") === null) {
            if (displaySetting == "block") {
                sponsorshipform.style.display = "none";
            } else {
                sponsorshipform.style.display = "grid";
                deleteorder_info.style.display = "none";
                approveorderform_info.style.display = "block";
            }

            cardinput_id.value = childNamegot;
            form_action = 2;

            $("input#aimID").val(ins_aim);
            $("select#typeID").val(typeID);
            $("input#longitudeID").val(longVAL);
            $("input#latitudeID").val(latVAL);
            $("#descriptionID").val(desVAL);

            $("#error").hide();
        }
    });
});

cancelORderBTn.forEach((cancelbtn) => {
    const childNamegot = cancelbtn.querySelector(".cardID").value;

    // Make whole card clickable, but only if event target is NOT a specific card action inside <div Functions="product-card__actions">.
    cancelbtn.addEventListener("click", (e) => {
        if (e.target.closest(".product-card__actions") === null) {
            if (displaySetting == "block") {
                sponsorshipform.style.display = "none";
                deleteorder_info.style.display = "none";
            } else {
                sponsorshipform.style.display = "grid";
                deleteorder_info.style.display = "block";
                approveorderform_info.style.display = "none";
            }

            cardinput_id.value = childNamegot;

            form_action = 3;
            $("#error").hide();
        }
    });
});

$(document).ready(function () {
    $("form").submit(function (event) {
        const endPoint = "processors/process_addInfrastructure.php";
        var formdata = new FormData();
        var ins_type_id = $("input#ins_type_id").val();

        if (loaderdiv_displaySetting == "block") {
            loaderdiv.style.display = "none";
        } else {
            loaderdiv.style.display = "grid";
        }

        if (form_action != 3) {
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


            formdata.append("aim", aimID.replace(/['"]+/g, "").replace(/[^\w\s]/gi, ""));
            formdata.append("type", type);
            formdata.append("longitude", longitude);
            formdata.append("latitude", latitude);
            formdata.append("description", description.replace(/['"]+/g, "").replace(/[^\w\s]/gi, ""));

            if (form_action == 2) {
                formdata.append("type_id", ins_type_id);
            }
        } else {
            formdata.append("type_id", ins_type_id);
        }

        formdata.append("form_action", form_action);


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
                        sponsorshipform.style.display = "none";
                        loaderdiv.style.display = "none";
                    }, 4000);
                } else {
                    console.log("success" + data);
                    $(".sponsormessagediv").html(
                        '<div Functions="alert alert-success">' + data.message + "</div>"
                    );
                    setTimeout(function () {
                        $(".sponsormessagediv").html("");
                        sponsorshipform.style.display = "none";
                        loaderdiv.style.display = "none";
                    }, 4000);

                    document.getElementById("approveform").reset();
                    window.location.href = "manage";
                }
            })
            .catch(console.error);

        event.preventDefault();
    });

});

function cancelsponsohip() {
    sponsorshipform.style.display = "none";
}
