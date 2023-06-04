// banner slider

$(".banner-slider").slick({
    dots: true,
    initialSlide: 0,
    infinite: false,
    speed: 400,
    autoplay: true,
    autoplaySpeed: 3000,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: $(".previous"),
    nextArrow: $(".next"),
    responsive: [
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
            },
        },
    ],
});

function myFunction(smallImg) {
    var fullImg = document.getElementById("imageBox");
    fullImg.src = smallImg.src;
}

// category slider

$(".category-slider").slick({
    dots: true,
    initialSlide: 0,
    infinite: false,
    speed: 600,
    autoplay: true,
    slidesToShow: 4,
    slidesToScroll: 2,
    prevArrow: $(".cat-previous"),
    nextArrow: $(".cat-next"),
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 2,
                infinite: true,
                dots: false,
            },
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true,
                dots: false,
            },
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
            },
        },
    ],
});

function myFunction(smallImg) {
    var fullImg = document.getElementById("imageBox");
    fullImg.src = smallImg.src;
}
