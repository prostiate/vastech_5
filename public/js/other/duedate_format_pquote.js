$(function () {
    $(document).ready(function () {
        //membuat due date diawal
        var now = new Date();
        now.setDate(now.getDate() + 30);
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        //$('.due_date').val(today);
    });
    $('.term').on("change", function () {
        //membuat due date diawal
        var date = new Date($('.trans_date').val());
        length = parseInt($('option:selected', this).attr('length'));
        date.setDate(date.getDate() + length);
        
        $('.due_date').val(date.toInputFormat());
    });
    Date.prototype.toInputFormat = function () {
        var yyyy = this.getFullYear().toString();
        var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
        var dd = this.getDate().toString();
        return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]); // padding
    };
});
