"use strict";
const customerForm = document.getElementById("customer-information");
if (customerForm) {
    customerForm.addEventListener("submit", (event) => {
        event.preventDefault();
        event.stopPropagation();

        var inputFields = customerForm.querySelectorAll("input[required]");

        Array.from(inputFields).forEach(function (inputField) {
            if (!inputField.checkValidity()) {
                inputField.classList.add("is-invalid");
            } else {
                inputField.classList.remove("is-invalid");
            }
        });

        if (customerForm.checkValidity() === false) {
            warning_alert("Please fulfill all required fields.");
        } else {
            var action = event.target.action;
            var formData = new FormData(event.target);

            $.ajax({
                type: "POST",
                url: action,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                data: formData,
                async: false,
                success: function (response) {
                    $(".customer-name").addClass("d-none");
                    $(".customer-name-input").prop("disabled", true).val("");
                    customerForm.classList.remove("was-validated");

                    $("#payment-div").html(response.data);
                },
                error: function (response) {
                    let data = response.responseJSON;
                    $(".customer-name").removeClass("d-none");
                    $(".customer-name-input").prop("disabled", false);
                    customerForm.classList.add("was-validated");
                },
            });
        }
    });
}
