<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/slide.css">
</head>
<body>
    <div class="container">
        <section class="content">
            <div class="slideshow-container">
                 <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="public/images/slide.jpg" style="width:100%">
                  <div class="text">Caption Text</div>
                </div>
                <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="public/images/slide1.jpg" style="width:100%">
                  <div class="text">Caption Text</div>
                </div>
                
                <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="public/images/slide2.jpg" style="width:100%">
                  <div class="text">Caption Two</div>
                </div>
                
                <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="public/images/slide3.jpg" style="width:100%">
                  <div class="text">Caption Three</div>
                </div>
                
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
                
                </div>
                <br>
                
                <div style="text-align:center">
                  <span class="dot" onclick="currentSlide(1)"></span> 
                  <span class="dot" onclick="currentSlide(2)"></span> 
                  <span class="dot" onclick="currentSlide(3)"></span> 
                </div>
                
                <script>
                let slideIndex = 1;
                showSlides(slideIndex);
                function plusSlides(n) {
                  showSlides(slideIndex += n);
                }
                
                function currentSlide(n) {
                  showSlides(slideIndex = n);
                }
                
                function showSlides(n) {
                  let i;
                  let slides = document.getElementsByClassName("mySlides");
                  let dots = document.getElementsByClassName("dot");
                  if (n > slides.length) {slideIndex = 1}    
                  if (n < 1) {slideIndex = slides.length}
                  for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                  }
                  for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                  }
                  slides[slideIndex-1].style.display = "block";  
                  dots[slideIndex-1].className += " active";
                }
                </script>
        </section>
    </div>
</body>
</html>