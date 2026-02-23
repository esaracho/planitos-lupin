//https://www.javaspring.net/blog/javascript-loading-screen-while-page-loads/

// Wait for the page to fully load
window.addEventListener('load', function() {
    // Get the loading screen element
    const loadingScreen = document.querySelector('.loading-screen');
    
    // Add a 'hidden' class to trigger fade-out
    loadingScreen.classList.add('hidden');

});