$(document).ready(function() {
    let error = "is-invalid";
    let require = "Please fill out this field";

    $('#dateto').on('keyup blur', function() {
        var input = $('#dateto').val();
        if (input == '') {
            $(this).addClass(error);
            $('#minuteterror').text(require);
        } else if ($.isNumeric(input)) {
            $(this).removeClass(error);
            $('#minuteterror').empty();
            $(this).addClass('is-valid');
        } else {
            $(this).addClass(error);
            $('#minuteterror').text('Only number is valid');
        }
    });
})

let error = "is-invalid";
let success = "is-valid";
let require = "Please fill out this field";

let number = {
    pregmatch : '$.isNumeric()',
    
}

function validate(idName, validation) {
    let input = this.val();
    if (input == '') {
        $(idName).addClass(error);
        $(idName).text(require)
    } else if () {
        
    } else {
        $(this).addClass(error);
        $(idName).text();
    }
}