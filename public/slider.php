<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/slider.css">
</head>

<body>
    <section id="slider">
        <div class="slider-scoroll">
            <img src="public/images/slide.jpg">
            <img src="public/images/slide1.jpg">
            <img src="public/images/slide2.jpg">
            <img src="public/images/slide3.jpg">
            <img src="public/images/slide.jpg">
        </div>
     <div class="dot-container">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
     </div>   
    </section>
</body>
<script>
    const imgPosition = document.querySelectorAll(".slider-scoroll img");
    const imgContainer = document.querySelector('.slider-scoroll');
    const doItem=document.querySelectorAll(".dot");
    let imgNumber = imgPosition.length;
    let index = 0;

    imgPosition.forEach(function (image, index) {
    image.style.right = index * 100 + "%";
    doItem[index].addEventListener("click",function(){
        slider(index);
    })
    } );

    function imgSlide()
     {
        index++;
        if (index >= imgNumber) {
        index = 0;}
         imgContainer.style.transform = "translateX(" + index * -100 + "%)";
         slider(index);
    }
    function slider(index){
        imgContainer.style.transform = "translateX(" + index * -100 + "%)";
        const doActive=document.querySelector('.active');
        doActive.classList.remove("active");
        doItem[index].classList.add("active");
    }
    setInterval(imgSlide, 4000);
</script>

</html>
