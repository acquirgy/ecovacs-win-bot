///Validation
$(document).ready(function () {


        $("#form1").validate({
            wrapper: "span",
            rules: {
                tbxEmail: {
                    required: true,
                },
                tbxConfirmEmail: {
                    required: true,
                },
                tbxFName: {
                    required: true,
                },
                tbxLName: {
                    required: true,
                },
                tbxAddress: {
                    required: true
                },
                tbxCity: {
                    required: true
                },
                ddlState: { valueNotEquals: "" },
                ddlProvince: { valueNotEquals: "" },
                ddlRegion: { valueNotEquals: "" },
                tbxZip: {
                    required: true,
                },
                tbxPhone: {
                    required: true,
                    phone: true,
                    minlength: 10
                },
                tbxShipFName: {
                    required: true,
                },
                tbxShipLName: {
                    required: true,
                },
                tbxShipAddress: {
                    required: true
                },
                tbxShipCity: {
                    required: true
                },
                ddlShipState: { valueNotEquals: "" },
                ddlShipProvince: { valueNotEquals: "" },
                ddlShipRegion: { valueNotEquals: "" },
                tbxShipZip: {
                    required: true,
                },
                tbxCCFName: {
                    required: true,
                    equalTo: "#tbxFName"
                },
                tbxCCLName: {
                    required: true,
                    equalTo: "#tbxLName"
                },
            },
            messages: {
                ddlState: { valueNotEquals: "Select an item" },
                ddlProvince: { valueNotEquals: "Select an item" },
                ddlRegion: { valueNotEquals: "Select an item" },
                ddlShipState: { valueNotEquals: "Select an item" },
                ddlShipProvince: { valueNotEquals: "Select an item" },
                ddlShipRegion: { valueNotEquals: "Select an item" }
            },

        });

    $.validator.addMethod('phone', function (value) {
        return /^\d{10}$/.test(value);
    }, 'Digits  only');

    $.validator.addMethod('postalCode', function (value) {
        return /^((\d{5}-\d{4})|(\d{5})|([A-Z]\d[A-Z]\s\d[A-Z]\d))$/.test(value);
    }, 'Postal Code invalid');

    $.validator.addMethod("valueNotEquals", function (value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");

        $('#firstbutton').click(function (e) {
            e.preventDefault();

            $("#form1").validate(); 
        });

});