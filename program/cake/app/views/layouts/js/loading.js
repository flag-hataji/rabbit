function LoadingImg() {
    document.alert("‚æ‚¤‚±‚»");
    document.img.src = "../../../common/image/parse_csv_loading.gif";
}

Event.observe(window, 'load', function() {
    var loadingImage = Builder.node('img', {src: '../loading.gif'});
    var sync = $('sync');
    var async = $('async');
    var loading = $('loading');
    var working = $('working');
    var loop = $('loop');
    
    Event.observe(async, 'click', function() {
        var breakNumber = 500;
        var callback = function() {
            if (breakNumber--) {
                working.appendChild(Builder.node('div', {className: 'test'}));
                document.getElementsByClassName('test');
                setTimeout(callback, 0);
            } else {
                loading.removeChild(loading.firstChild);
                async.disabled = false;
            }
        };
        loading.appendChild(Builder.node('div', [loadingImage,"Loading..." ]));
        async.disabled = true;
        setTimeout(callback,0);
    });
});