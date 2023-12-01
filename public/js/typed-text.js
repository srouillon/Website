document.addEventListener('DOMContentLoaded', function () {
    const textToType = document.getElementById('typed-text').textContent;
    document.getElementById('typed-text').textContent = "";
    const typedTextElement = document.getElementById('typed-text');
    let charIndex = 0;

    const typeInterval = setInterval(function () {
        typedTextElement.textContent += textToType[charIndex];
        charIndex++;

        if (charIndex === textToType.length) {
            clearInterval(typeInterval);
        }
    }, 15);
});