const navbar = document.getElementsByTagName('nav')[0];
window.addEventListener('scroll', function(){
    console.log(window.scrollY);
    if(window.scrollY >1) {
        navbar.classList.replace('bg-tranparent', 'nav-color');
    } else if (this.window.scrollY <= 0) {
        navbar.classList.replace('nav-color', 'bg-tranparent')
    }
});
