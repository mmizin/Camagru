
/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_CHANGE_MENU_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */
function change () {
    active_block = document.querySelectorAll('.main-bar .active');

    if (active_block.length) {
        active_block.forEach(function (active_element) {
            active_element.classList.remove('active');
        });
    }

    block_to_activate = document.querySelector('.' + this.dataset.blockid);
    block_to_activate.classList.add('active');
    block_to_activate.firstElementChild.querySelector("input").style.border = "1px solid red";
    console.log(block_to_activate.firstElementChild.querySelector("input"));
}

document.querySelectorAll(".change").forEach(function (block) {
    block.addEventListener('click', change);
});

/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_MODAL_WINDOW_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */

document.getElementById("modal-href").addEventListener("click", function(){
    modal = document.getElementsByClassName('myModal')[0];
    modal.style.display = "grid";
});

document.getElementsByClassName("close_modal")[0].addEventListener("click", function () {
    close_modal = document.getElementsByClassName("myModal")[0];
    close_modal.style.display = "none";
    close_upload_form = document.querySelector(".upload_photo_profile form");
    close_upload_form.style.display = "none";
});

/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_UPLOAD_FILE_@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* */
//
function _toogleShow(e, style) {
    if (e.style.display === style) {
        e.style.display = 'none';
    }
    else {
        e.style.display = style;
    }
}


document.querySelector(".upload_photo_profile").addEventListener("click", function () {
    _toogleShow(document.querySelector(".upload_photo_profile form"), 'grid');
});


document.querySelector(".make_photo_from_webacm").addEventListener("click", function () {
    block_to_activate = document.querySelector(".upload_webcam");
    block_to_activate.classList.add('active');

});

/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_WEB_CAM_AVATAR_@@@@@@@@@@@@@@@@@@@@@@@@@@
* */

var video_avatar = document.getElementById('video_avatar');

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video_avatar.srcObject = stream;
        video_avatar.play();
    });
}

document.querySelector(".button_snap_avatar").addEventListener("click", function() {
    canvasSnapAvatar = document.querySelector("#canvas_avatar");
    contextSnapAvatar = canvasSnapAvatar.getContext('2d');
    video = document.querySelector("#video_avatar");
    contextSnapAvatar.drawImage(video, 0, 0, 640, 480);
});

document.querySelector(".save_avatar_from_webcam").addEventListener("click", function() {
    canvas = document.querySelector("#canvas_avatar");
    context = canvas.getContext('2d');
    imageObj = new Image();
    user = document.querySelectorAll('.user')[0].baseURI;
    request = new XMLHttpRequest();

    imageObj.src = canvas.toDataURL("image/png");
    request.open('POST', user, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('avatar_webcam=' + imageObj.src);

    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            response = request.responseText;
            document.querySelector(".user img").src = response;
            document.querySelector(".right-bar img").src = response;
            // console.log(response);
        }

    }
});


/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_WEB_CAM_MAIN_@@@@@@@@@@@@@@@@@@@@@@@@@@
* */


var video = document.getElementById('video');


if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {

    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.srcObject = stream;
        video.play();
    });
}


document.getElementById("snap").addEventListener("click", function() {

    canvas = document.getElementById('canvass');
    context = canvas.getContext('2d');
    video = document.getElementById('video');
    canvass_podlogka_video = document.querySelector("#canvass_podlogka_video");


    imgObjOne = new Image();

    podlogka = document.querySelector(".podlogka_video").getAttribute("src");

    if (podlogka == '#') {podlogka = '';}
    // console.log(podlogka);

    user = document.querySelectorAll('.user')[0].baseURI;
    request = new XMLHttpRequest();


    if (canvass_podlogka_video.dataset.loaded == 'on') {
        imgObjOne.src = canvass_podlogka_video.toDataURL("image/png");
    }
    else {
        context.drawImage(video, 0, 0, 640, 480);
        imgObjOne.src = canvas.toDataURL("image/png");
    };

    request.open('POST', user, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('imgOne=' + imgObjOne.src + '&imgTwo=' + podlogka);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status === 200) {
            response = request.responseText;
            // console.log(response);
            image = "data:image/gif;base64," + response ;
            img = new Image();
            img.onload = function () {
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
            }
            img.src = image;
            document.querySelector("#canvass").style.display = 'block';
            document.querySelector("#canvass").dataset.loaded = 'on';

        }
    }
});

/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_UPLOAD_PHOTO_TO_DATABASE_@@@@@@@@@@@@@@@@@@@@@@@@@@
* */


document.querySelector("#save_photo").addEventListener("click", function () {


    if (document.querySelector("#canvass").dataset.loaded == 'on') {

    canvas = document.querySelector("#canvass");

    context = canvas.getContext('2d');
    img = new Image();
    user = document.querySelectorAll('.user')[0].baseURI;
    request = new XMLHttpRequest();

    img.src = canvas.toDataURL("image/png");
    request.open('POST', user, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('for_tbl_photo=' + img.src);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            responses = request.responseText;
        }
    }
    }

});


/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_UPLOAD_IMG_ON_CANVAS_@@@@@@@@@@@@@@@@@@@@@@@@@@
* */

var imageLoader = document.querySelector("#imgLoader");
imageLoader.addEventListener('change', handleImage, false);
var imageLoaderCanvas = document.querySelector('#canvass_podlogka_video');
var imageLoader_ctx = imageLoaderCanvas.getContext('2d');

function handleImage(e) {
    imageLoaderCanvas.dataset.loaded = 'on';
    var imageLoaderReader = new FileReader();
    imageLoaderReader.onload = function (event) {
        var imageLoader_img = new Image();
        imageLoader_img.onload = function () {
            imageLoaderCanvas.width = 640;
            imageLoaderCanvas.height = 480;
            imageLoader_ctx.drawImage(imageLoader_img, 0, 0, 640, 480);
        }
        imageLoader_img.src = event.target.result;
    }
    imageLoaderReader.readAsDataURL(e.target.files[0]);
    document.querySelector("#video").style.display = 'none';
    imageLoaderCanvas.style.position = "fixed";
    imageLoaderCanvas.style.display = 'block';
}


/*
* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_Move_ICON_ON VIDEO_@@@@@@@@@@@@@@@@@@@@@@@@@@
* */


document.querySelectorAll(".canvas_element_video img").forEach(function(photo) {

    // console.log(photo);
    photo.addEventListener("click", function () {
    path = photo.getAttribute("src");

    podlogka = document.querySelector(".podlogka_video");
    // console.log(podlogka);
    path_src = podlogka.src = path;
    // console.log(path_src)
    podlogka.style.display = "block";
    podlogka.style.position = "absolute";
    podlogka.style.zIndex = 2;
    podlogka.setAttribute('data-info', photo.getAttribute('class'));
    })});



function notification(e) {
    request = new XMLHttpRequest();
    user = document.querySelectorAll('.user')[0].baseURI;
    request.open('POST', user, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('notification_email=' + e.target.checked);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            responses = request.responseText;
            // console.log(responses);
        }
    }
}