$(document).ready(function(){

    $('.slider').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        stagePadding: 50,
        dots: false,
        navText : ["<i class='fa-solid fa-arrow-left'></i>","<i class='fa-solid fa-arrow-right'></i>"],
        responsive:{
            0:{
                items:1
            },
             400:{
                items:3
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
})