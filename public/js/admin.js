(function(){
    const isAdmin = localStorage.getItem('is_admin');
    if(isAdmin !== '1' && isAdmin !== 'true') {
        window.location.href = '/home';
    }
})();
