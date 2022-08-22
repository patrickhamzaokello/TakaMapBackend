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
    const endPoint = "processors/process_case.php";
    var formdata = new FormData();
    var ins_type_id = $("input#ins_type_id").val();

    if (loaderdiv_displaySetting == "block") {
      loaderdiv.style.display = "none";
    } else {
      loaderdiv.style.display = "grid";
    }

    if (form_action != 3) {
      if (form_action == 2) {
        formdata.append("case_id", ins_type_id);
      }
    } else {
      formdata.append("case_id", ins_type_id);
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
          window.location.href = "cases";
        }
      })
      .catch(console.error);

    event.preventDefault();
  });

});

function cancelsponsohip() {
  sponsorshipform.style.display = "none";
}
