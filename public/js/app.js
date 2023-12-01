document.addEventListener("click", function (inter) {
    let elem = document.getElementById('copyright');
    console.log(elem);
    if(inter.target === elem) {
        window.location.href = "/snake/index.php";
    }
});