function totalAmount() {
    var t = 0;
    $('.amount').each(function (i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.subtotal').html(t);
    $('.subtotal_input').val(t);
    $('.total').html(t);
    $('.ppn_input').html(t);
    $('.total_input').val(t);
    $('.balance').html(t);
    $('.balance_input').val(t);
}

$(function () {   
    $('.getmoney').change(function () {
        var total = $('.total').html();
        var getmoney = $(this).val();
        var t = getmoney - total;
        $('.backmoney').val(t).toFixed(2);
    });     
    $('.add').click(function () {
        var product = $('.product_id').html();
        var units = $('.units').html();
        var taxes = $('.taxes').html();
        var n = ($('.neworderbody tr').length - 0) + 1;
        tr = '<tr><td>' +
            '<div class="form-group" >' +
            '<select class="select2 form-control form-control-sm product_id" name="products[]" aria-placeholder="Select Product" required>' +
            product +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<textarea class="form-control desc" name="desc[]" rows="1"></textarea>' +
            '</td>' +
            '<td>' +
            '<input type="number" class="qty form-control form-control-sm" value="1" name="qty[]">' +
            '</td>' +
            '<td>' +
            '<div class="form-group">' +
            '<select class="select2 form-control form-control-sm units" name="units[]" aria-placeholder="Select Product" required>' +
            units +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input type="text" class="unit_price form-control form-control-sm" name="unit_price[]" required>' +
            '</td>' +
            '<td>' +
            '<div class="form-group">' +
            '<select class="taxes select2 form-control form-control-sm" name="tax[]" aria-placeholder="Select Product">' +
            taxes +
            '</select>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<input type="text" class="amount form-control form-control-sm" name="total_price[]" readonly> ' +
            '</td>' +
            '<td>' +
            '<input type="button" class="btn btn-danger delete" value="x">' +
            '</td>' +
            '</tr>';


        $('.neworderbody').append(tr);
        $('.product_id').select2();

    });

    // konek ke DB dan query - mulai

    // Node.js MySQL Result Object Example
// include mysql module
/*var mysql = require('mysql');
// create a connection variable with the required details
var con = mysql.createConnection({
  host: "localhost", // ip address of server running mysql
  user: "root", // user name to your mysql database
  password: "", // corresponding password
  database: "demo_vastech" // use the specified database
});
// make to connection to the database.
con.connect(function(err) {
  if (err) throw err;
  // if connection is successful
  var pajak = tr.find('.taxes').val()
  con.query("SELECT rate FROM taxes WHERE name = " + pajak, function (err, result, fields) {
    // if any error while executing above query, throw error
    if (err) throw err;
    // if there is no error, you have the result
    // iterate for all the rows in result
    Object.keys(result).forEach(function(key) {
      var row = result[key];
      console.log(row.name)
    });
  });
});
*/
    // konek ke DB dan query - selesai

    $('.neworderbody').on('click', '.delete', function () {
        $(this).parent().parent().remove();
        totalAmount();
    });
    $('.neworderbody').on('change', '.product_id', function () {
        var tr = $(this).parent().parent();
        var price = tr.find('.product_id option:selected').attr('value');
        
        tr.find('.desc').val(price);
        totalAmount();
    });
    
    $('.neworderbody').on('change', '.taxes, .qty, .unit_price', function () {
        var tr = $(this).parent().parent();
        var tax = tr.find('.taxes option:selected').attr('rate');     

        var price = tr.find('.unit_price').val() - 0;
        var qty = tr.find('.qty').val() - 0;

        var total = (qty * price) - ((qty * price * tax) / 100);
        
        tr.find('.amount').val(total);
        totalAmount();
    });    

    $('#hideshow').on('click', function (event) {
        $('#content').removeClass('hidden');
        $('#content').addClass('show');
        $('#content').toggle('show');
    });
    
});
