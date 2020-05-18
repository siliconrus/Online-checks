// $("document").ready(function() {
//     $('#getUserByIds').click(function () {
//         //let send = $('form').serialize();
//         //let openShift = $('openShift').attr('name');
//         // e.preventDefault();
//
//         $.ajax({
//             url: 'apiBusiness.php',
//             type: 'POST',
//             data: {"getUserByIds": true },
//             //dataType: "json",
//             success: function (data) {
//                 if(data)
//                 {
//                     alert(data);
//                     // let obj = jQuery.parseJSON(data);
//                     //  alert(obj.echoJSON);
//
//                 } else {
//                     alert('Что-то пошло не так..');
//                 }
//                 //alert(data);
//             }
//
//         });
//     });
//
// });
$("document").ready(function() {
    $('#printCheck').on('click', function (e) {
        e.preventDefault();
        email = $('#JSONcheck').val();
        submit = $('#printCheck').attr('id');
        arrData = {email: email, submit: submit};

        $.ajax({
            url: "apiBusiness.php",
            method: "POST",
            //dataType: "json",
            data: arrData,
            success: function (data) {
                try {
                    alert(data)

                } catch(e) {
                    alert("JS Error:", e)
                }
            },
        });
    });
});

