window.onbeforeunload = function (e) {
    document.getElementById('st-container').className += ' fade_out';
    document.getElementById('header-loader-under-bar').className = '';
}

window.onload = function (e) {
    document.getElementById('st-container').className += ' fade_in';
    document.getElementById('header-loader-under-bar').className = 'hidden';
    NProgress.done();
}