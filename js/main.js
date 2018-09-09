
function say(e) {
    e.parentElement.parentElement.querySelector(".t_area").focus();
}

function add_comment(event, start, text, user_name) {
    newItem1 = document.createElement("DIV");
    newItem1.classList.add("user_coments");

    newItem2= document.createElement("SPAN");
    newItem2.classList.add("user_comment_name");
    newItem2.innerHTML = user_name;

    newItem3 = document.createElement("SPAN");
    newItem3.classList.add("user_text_comment");
    newItem3.innerHTML = text;

    newItem1.appendChild(newItem2);
    newItem1.appendChild(newItem3);

    event.target.parentElement.querySelector('textarea').value = '';
    start.appendChild(newItem1);
}


/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_COMMENT_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */

function comment(event) {
    console.log(event['path'][2]);
    text = event['path'][1][1].value;

    console.log(text);
    photo_id = event['path'][3].id;
    console.log(photo_id);
    user = document.querySelectorAll('.nav-logo a')[0].baseURI;
    console.log(user);

    request = new XMLHttpRequest();
    request.open('POST', user, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('text=' + text + '&photo_id=' + photo_id);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            responses = request.responseText;
            console.log(responses);
            obj = JSON.parse(responses);
            // console.log(obj);
            var start = event['path'][2];
            var comment = document.createElement('div');

            add_comment(event, start.appendChild(comment), obj[0], obj[1]);

        }
    }
};

/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_LIKES_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */



function heart_icon(e) {
    photo_id = e.dataset.id;
    user = document.querySelectorAll('.nav-logo a')[0].baseURI;
    // console.log(user);
    request = new XMLHttpRequest();
    request.open('POST', user, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('photo_id=' + photo_id + '&add_like=' + 1);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            // console.log(request.responseText);
            obj = JSON.parse(request.responseText);
            console.log(obj);
                if (obj[1] == '1') {
                    e.style.backgroundColor = 'red';
                    console.log('tut');
                }
            console.log(e);
                    document.querySelector(`.count_of_likes[data-id='${photo_id}']`).innerHTML = obj[0];
                    e.innerText = obj[0];

                }
        }
}

/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_PAGINATION_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */

function paggination(e) {
    var uri = location.pathname.substring(1);
    request = new XMLHttpRequest();
    request.open('POST', 'gallery', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('page=' + e.dataset.page);

    request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status === 200) {
                response = request.responseText;
                // alert(response);
            }
       }
}


/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */


/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_DELETE_PHOTO_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */

function delete_photo(event) {
    user = document.querySelectorAll('.nav-logo a')[0].baseURI;
    photo_id = event.getAttribute('id');
    photo_path = event.dataset['photopath'];
    parent = event.parentElement.parentElement;
    console.log(parent);
    request = new XMLHttpRequest();
    request.open('POST', user, true);

    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('delete_photo=' + photo_id + '&photo_path=' + photo_path + '&data-info=' + 'off');

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status === 200) {
            response = request.responseText;
            parent.style.display = 'none';
            console.log(response);
        }
    }
}




/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */