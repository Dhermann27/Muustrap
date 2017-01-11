$(document).on('click', '.number-spinner button', function () {
    var btn = $(this),
        input = btn.closest('.number-spinner').find('input'),
        oldValue = input.val().trim(),
        newVal = 0;

    if (btn.attr('data-dir') == 'up') {
        newVal = parseInt(oldValue, 10) + 1;
    } else {
        if (oldValue > 0) {
            newVal = parseInt(oldValue, 10) - 1;
        } else {
            newVal = 0;
        }
    }
    input.val(newVal);
    calc();
});

$(document).on('change', 'div.form-group select, div.form-group input', calc);

function calc() {
    var total = 0.0,
        deposit = 0.0;
    var adults = parseInt($("#adults").val(), 10),
        yas = parseInt($("#yas").val(), 10),
        jrsrs = parseInt($("#jrsrs").val(), 10),
        children = parseInt($("#children").val(), 10),
        babies = parseInt($("#babies").val(), 10);
    var singlealert = $("#single-alert"),
        adultalert = $("#adult-choose"),
        yaalert = $("#ya-choose"),
        adultsfee = $("#adults-fee"),
        yasfee = $("#yas-fee"),
        childrenfee = $("#children-fee");
    switch (adults + yas + jrsrs + children + babies) {
        case 0:
            break;
        case 1:
            deposit = 150.0;
            break;
        default:
            deposit = 300.0;
    }
    singlealert.hide();
    adultalert.hide();
    yaalert.hide();
    switch (parseInt($("#adults-housing").val(), 10)) {
        case 0:
            adultsfee.html("$0.00");
            childrenfee.html("$0.00");
            if (adults > 0) {
                adultalert.show();
            }
            break;
        case 1:
            switch (adults + children + babies) {
                case 1:
                    rate = adults * 1520.0;
                    singlealert.show();
                    break;
                case 2:
                    rate = adults * 760.0;
                    break;
                case 3:
                    rate = adults * 710.0;
                    break;
                default:
                    rate = adults * 650.0;
            }
            total += rate + (children * 344);
            adultsfee.html("$" + rate.toFixed(2));
            childrenfee.html("$" + (children * 344).toFixed(2));
            break;
        case 3:
            total += adults * 545 + children * 344;
            adultsfee.html("$" + (adults * 545).toFixed(2));
            childrenfee.html("$" + (children * 344).toFixed(2));
            break;
        case 4:
            total += adults * 438 + children * 242;
            adultsfee.html("$" + (adults * 438).toFixed(2));
            childrenfee.html("$" + (children * 242).toFixed(2));
            break;
    }
    switch (parseInt($("#yas-housing").val(), 10)) {
        case 0:
            yasfee.html("$0.00");
            if(yas > 0) {
                yaalert.show();
            }
            break;
        case 1:
            total += yas * 490;
            yasfee.html("$" + (yas * 490).toFixed(2));
            break;
        case 2:
            total += yas * 408;
            yasfee.html("$" + (yas * 408).toFixed(2));
            break;
    }
    total += jrsrs * 490;
    $("#jrsrs-fee").html("$" + (jrsrs * 490).toFixed(2));
    total += babies * 80;
    $("#babies-fee").html("$" + (babies * 80).toFixed(2));
    $("#deposit").html("$" + Math.min(total, deposit).toFixed(2));
    $("#arrival").html("$" + Math.max(total - deposit, 0).toFixed(2));
    $("#total").html("$" + total.toFixed(2));
}

calc();