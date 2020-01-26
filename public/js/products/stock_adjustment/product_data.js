$(document).ready(function () {


    $('.type1').on("click", function () {
        $(".neworderbody").find('.difference_qty').prop("readonly", true);
        $(".neworderbody").find('.difference_qty').val(null);
        $(".neworderbody").find('.actual_qty').prop("readonly", false);
        $(".neworderbody").find('.actual_qty').val(null);

        $(".neworderbody").on("keyup keydown change", ".actual_qty", function () {       
            var tr = $(this).closest("tr");
    
            var recorded_qty    = tr.find(".recorded_qty").val() - 0;
            var actual_qty      = tr.find(".actual_qty").val() - 0;
            
            var difference_qty = actual_qty - recorded_qty;
    
            tr.find('.difference_qty').val(difference_qty);
        }); 
    });
    
    $('.type2').on("click", function(){
        $(".neworderbody").find('.difference_qty').prop("readonly", false);
        $(".neworderbody").find('.difference_qty').val(null);
        $(".neworderbody").find('.actual_qty').prop("readonly", true);
        $(".neworderbody").find('.actual_qty').val(null);

        $(".neworderbody").on("keyup keydown change", ".difference_qty", function () {       
            var tr = $(this).closest("tr");
    
            var difference_qty  = tr.find(".difference_qty").val() - 0;
            var recorded_qty      = tr.find(".recorded_qty").val() - 0;
            
            var actual_qty  = recorded_qty + difference_qty;
    
            tr.find('.actual_qty').val(actual_qty);
        }); 
    });
    

    $(".neworderbody").on("keyup keydown change", ".actual_qty", function () {       
        var tr = $(this).closest("tr");       

        var recorded_qty    = tr.find(".recorded_qty").val() - 0;
        var actual_qty      = tr.find(".actual_qty").val() - 0;
        
        var difference_qty = actual_qty - recorded_qty;

        tr.find('.difference_qty').val(difference_qty);
    }); 
    
});
