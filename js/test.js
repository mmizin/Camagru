

// var page = document.querySelectorAll('.pagination a');
// // var uri = location.pathname.substring(1);
//
// page.forEach(function (element) {
//     console.log(element);
//     element.addEventListener("click", function () {
//     page_number = element.dataset['page'];
//     request = new XMLHttpRequest();
//     request.open('POST', 'gallery', true);
//     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     request.send('page=' + page_number);
//         request.onreadystatechange = function () {
//         if (request.readyState == 4 && request.status === 200) {
//             response = request.responseText;
//             console.log(response);
//         }
//     }
// });
// });

window.onload = function () {
    var inp_email = document.querySelector("input[name=email]");
    var inp_phone = document.querySelector("input[name=phone]");
    var inp_name = document.querySelector("input[name=name]");
    var input = document.querySelectorAll("input");
   input.forEach(function (t) {
      t.addEventListener("change", function () {
          var obj = { name: "John", age: 30, city: "New York" };
          arr = [{'x' : 1}];
          // arr['Email'] = inp_email.value;
          // arr['Phone'] = inp_phone.value;
          // arr['Name'] = inp_name.value;
          // console.log(arr['Email']);
          ajaxPost({elo : arr});
      })



   })



}

function ajaxPost(params) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if(request.readyState == 4 && request.status == 200) {
            var pars = request.responseText;
            pos = pars.search('<!doctype html>');
            slice = pars.substring(0, pos);
            // var json = JSON.parse(slice);
            console.log(pars);
            // document.querySelector('#result').innerHTML = slice;

        }

    }
    request.open('POST', 'test');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(params);

}
// var User_direction_choice = direction.options[direction.selectedIndex].value;

// window.onload = function () {
// var select = document.querySelectorAll('select');
//     select.forEach(function (t) {
//         t.addEventListener("change", function () {
//           console.log(t.options[t.selectedIndex].text);
//         })
//     })
//
// }
