const steps = ["lead", "profile", "maternity_package", "parcial_payment", "appointment", "appointment_format", "tracing", "done"];
const currentStep = $("#profileData").data('process_step')


function getStars(star_number) {

    var stars = "<div class='float-right clearfix'>";
    for (var $i = 1; $i <= star_number; ++$i) {
        stars += "<i class='fas fa-star text-selective-yellow'></i>";
    }
    stars += "</div>"
    return stars;
}


function fillHospitals(city) {


    return $.ajax({
        type: 'GET',
        url: $("#DATA").data("url") + '/cities/listHospitals/' + city,
        success: function (data) {
            var options = '<option value=""></option>';
            $.each(data.hospitals, function (key, val) {
                options += `<option value="${val.id}" data-content="${getStars(val.star_number)}<b>${val.name}</b>"></option>`;
            });

            $("#hospitalsSelect").html(options).selectpicker('refresh');


        }
        ,
        error: function (error) {

        }
    });


}


function fillProducts(hospital) {

    return $.ajax({
        type: 'GET',
        url: $("#DATA").data("url") + '/hospitals/listProducts/' + hospital,
        success: function (data) {
            var options = '<option value=""></option>';
            $.each(data.products, function (key, val) {
                options += `<option 
                                value="${val.id}" 
                                data-content="<div class='row'>
                                                    <div class='col-3'>${val.product}</div> 
                                                    <div class='col-9 text-right text-success font-weight-bolder'>
                                                        <i class='fas fa-money-bill'></i> ${$.formatNumber(val.price)} USD
                                                     </div>
                                              </div>"
                             </option>`;
            });

            console.log("Products filled");
            $("#itemsSelect").html(options).selectpicker('refresh');


        }
        ,
        error: function (error) {

        }
    });


}


function formWizardManagement() {


    $("#smartwizard").smartWizard({
        theme: 'default',
        selected: steps.indexOf($("#profileData").data('process_step')),
        lang: {  // Language variables
            previous: 'Anterior',
            next: 'Siguiente'
        },
        toolbarSettings: {
            toolbarPosition: 'bot',
            toolbarButtonPosition: 'right'
        },
    }).on('leaveStep', function (e, anchorObject, stepNumber, stepDirection) {

        //LOCK SELECT PACKAGE AND PAYMENT WHEN THE USER DO THE PARCIAL PAYMENT
        if (currentStep == 'parcial_payment' && stepNumber != 0 && stepNumber != 2) {
            return false;
        }


        switch (stepNumber) {
            case 0:
                if ($("#momInfoForm").parsley().validate()) {
                    e.preventDefault();
                    $("#momInfoForm").submit();
                } else
                    return false;
                break;
            case 1:
                if ($("#maternityPackageForm").parsley().validate()) {
                    e.preventDefault();
                    $("#maternityPackageForm").submit();
                } else
                    return false;

                break;

        }

    });
}

async function setSelectedPackage() {

    const selectedPackage = $("#profileData").data("maternity_package");


    if (selectedPackage != null) {

        try {
            $("#citiesSelect").selectpicker('val', selectedPackage.city);
            await fillHospitals(selectedPackage.city);
            $("#hospitalsSelect").selectpicker('val', selectedPackage.hospital);

            await fillProducts(selectedPackage.hospital);
            $("#itemsSelect").selectpicker('val', selectedPackage.product);

        } catch (e) {
            console.log(e);
        }

    }

}

$(function () {

    $(".selectpicker").on("changed.bs.select", function () {
        $(this).parsley().validate();
    });


    $("input[name='birth_date']").datepicker({
        autoclose: true,
        language: "es",
        format: "yyyy-mm-dd"
    });


    formWizardManagement();
    setSelectedPackage();




    //GET THE HOSPITALS ON THE SELECTED CITY
    $("#citiesSelect").on("changed.bs.select", function (e, clickedIndex, isSelected, previousValue) {

        const city = $(this).val();

        if (city != '' && previousValue != undefined) {
            fillHospitals(city);
        } else {
            $("#hospitalsSelect,#itemsSelect").html('');
        }

    });


    //GET THE ITEMS ON THE SELECTED PACKAGE
    $("#hospitalsSelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        const hospital = $(this).val();

        if (hospital != '' && previousValue != undefined) {
            fillProducts(hospital);
        } else {
            $("#itemsSelect").html('');
        }
    });

    //SET ROUTE TO SAVE THE SELECTED PACKAGE
    $("#itemsSelect").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        const action = $("#maternityPackageForm").data('action');
        $("#maternityPackageForm").attr('action', action + $(this).val());

    });

});
