$(document).ready(function(){
    var haveCookie = getCookie(today);
    if (haveCookie == '' || haveCookie == false || haveCookie == undefined) {
        //if user deleted cookie, set from database
        createCookie(today, userTodayShots, 1);
    } else if (parseInt(userTodayShots) >= parseInt(maxNumberOfShots)) {
       showBlockModal();
    }
    
    $('#buyButton').click(function() {
        console.log($('buyShotForm'));
        $('form').submit();
    });
    
});

function showBlockModal() {
    $('#blockModal').modal('show');
    $('#slotWindow').remove();
}

function weHaveWinner() {
    if (!isLocal) {
        ga('send', 'event', 'Win', 'Winner', 'Someone won candy');
    }
    alert('Need popup dialog with user data');
}

function getSlotResults(a, b, c) {
    var results;
    $.ajax({
        type: "POST",
        url: "index/getResults",
        data: "",
        //async: false,
        cache: false,
        success: function(data){
            if (typeof data.status != 'undefined') {
                if (data.status == false) {
                   showBlockModal();
                }
                else {
                    a.stop(data.result.a);
                    b.stop(data.result.b);
                    c.stop(data.result.c);
                }
            }
        }
    });
    return results;

}
function startSpin() {
    increaseCookie();
    $.ajax({
        type: "POST",
        url: "index/startSpin",
        data: "",
        success: function(data){
            if (typeof data.status != 'undefined') {
                if (data.status == false) {
                   showBlockModal();
                }
            }
        }
    });

}

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function increaseCookie() {
    var cookie = getCookie(today);
    cookie++;
    createCookie(today, 1, 1);
}