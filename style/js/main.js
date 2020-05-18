let animateButton = function(e) {

    e.preventDefault;
    //reset animation
    e.target.classList.remove('animate');

    e.target.classList.add('animate');

    e.target.classList.add('animate');
    setTimeout(function(){
        e.target.classList.remove('animate');
    },6000);
};

let classname = document.getElementsByClassName("button");

for (let i = 0; i < classname.length; i++) {
    classname[i].addEventListener('click', animateButton, false);
}

// $(document).ready(function()
// {
//     $('form').submit(function(event)
//     {
//         event.preventDefault();
//         openShift = $('openShift').attr('name');
//
//
//         data = { openShift:openShift}
//
//         $.ajax({
//             type: $(this).attr('method'),
//             url: $(this).attr('action'),
//             data: data,
//             contentType: false,
//             cache: false,
//             processData: false,
//             success: function (result) {
//
//                 alert(result)
//             }
//
//             });
//     });
// });


// $("#test").on("click", function() {
//
//     e.preventDefault();
//
//     var id = $("#test").val();
//
//     $.ajax({
//         url: "apiBusiness.php",
//         type: "POST",
//         data: {
//             id: id,
//         },
//
//         success: function (data) {
//             try {
//                 data = JSON.parse(data)
//                 console.log(data)
//
//                 $.notify({
//                     type: data.type,
//                     message: data.msg
//                 });
//
//                 console.log(data)
//             } catch(e) {
//                 console.log("JS Error:", e)
//             }
//         },
//         error: function (err) {
//             inlineAlert("error", "AJAX error: " + err.statusText)
//         }
//     })
// })
//     $(document).ready(function(){
//         $("button").click(function(){
//
//             $.ajax({
//                 type: 'POST',
//                 url: 'test.php',
//                 success: function(data) {
//                     alert(data);
//                     $("p").text(data);
//
//                 }
//             });
//         });
//     });
// <script type="text/javascript">
//     function jq1 () {
//         doAjax();
//     }
// function doAjax(){
//     var name, email, message;
//     name = JSON.stringify($('#name').val());
//     email = JSON.stringify($('#email').val());
//     message = JSON.stringify($('#message').val());
//     ajax = phpcall(name, email, message);
// }
// function phpcall (name, email, message){
//     return $.ajax({
//         url: 'file.php',
//         type: 'POST',
//         data: { email: email, name: name, message: message }
//     });
// }
