function chk()
{
    if (chk) {
        $("[name='depreciate_method']").prop("disabled", true);
        $("[name='depreciate_life']").prop("disabled", true);
        $("[name='depreciate_rate']").prop("disabled", true);
        $("[name='depreciate_account']").prop("disabled", true);
        $("[name='depreciate_accumulated_account']").prop("disabled", true);
        $("[name='depreciate_accumulated']").prop("disabled", true);
        $("[name='depreciate_date']").prop("disabled", true);
    } else {
        $("[name='depreciate_method']").prop("disabled", false);
        $("[name='depreciate_life']").prop("disabled", false);
        $("[name='depreciate_rate']").prop("disabled", false);
        $("[name='depreciate_account']").prop("disabled", false);
        $("[name='depreciate_accumulated_account']").prop("disabled", false);
        $("[name='depreciate_accumulated']").prop("disabled", false);
        $("[name='depreciate_date']").prop("disabled", false);
    }
}

$(document).ready(function () {
    chk();

    $('#check_depreciable').click(function() {
        var chk = $('#check_depreciable').is(':checked');        
        
        chk();
    });
    
    $(".neworderbody").find('.difference_qty').prop("disabled", true);
   
    
});
