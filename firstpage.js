window.addEventListener('load', function() {
    setTimeout(function() {
        var content = document.querySelector('.content');
        content.classList.remove('hidden');
        content.classList.add('show'); 
    }, 5000); 
});