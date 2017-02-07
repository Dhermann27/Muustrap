$(document).on('change', '#donation', function () {
    var total = parseFloat($(this).val());
    $("#amount").val(Math.max(0, parseFloat($("#amountNow").text().replace('$', '')) + total).toFixed(2));
    $("td.amount").each(function () {
        total += parseFloat($(this).text().replace('$', ''));
    });
    $("#amountArrival").text("$" + Math.max(0, total).toFixed(2));
});