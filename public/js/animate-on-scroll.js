document.addEventListener("DOMContentLoaded", function () {
    function adjustSectionHeight() {
        const line = document.getElementById('line');
        const h1 = document.getElementById('h1-skills');

        if (line && h1) {
            let h1Height = h1.offsetHeight+15;
            line.style.height = "calc(100% - " + h1Height + "px)";
        }
    }

    window.addEventListener("resize", adjustSectionHeight);
    adjustSectionHeight();
});

(function () {
    const detectAndAnimate = () => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        elements.forEach(element => {
            const isVisible = isElementInViewport(element);
            element.classList.toggle('is-visible', isVisible);
        });
    };

    const isElementInViewport = el => {
        const rect = el.getBoundingClientRect();
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        const viewportWidth = window.innerWidth || document.documentElement.clientWidth;

        return (
            rect.top >= -el.clientHeight*0.25 &&
            rect.left >= 0 &&
            rect.bottom <= viewportHeight + el.clientHeight*0.75 &&
            rect.right <= viewportWidth
        );
    };

    window.addEventListener('scroll', detectAndAnimate);
    detectAndAnimate();
})()