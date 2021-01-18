

function confirm_delete(){
    var txt;
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        txt = "You pressed OK!";
    } else {
        txt = "You pressed Cancel!";
        event.preventDefault();
    }
    console.log(txt);
    }

