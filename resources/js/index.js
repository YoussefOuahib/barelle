jQuery(function(){
  $('.dropdown-submenu a').on("mouseover", function(e){
    console.log('hello mtf');
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });

  $('.account-button').click(function() {
    $('.account-dropdown').slideToggle();
  });
  $("#sidebarCollapse").on('click', function(){
    console.log('helo');
    $("#sidebar").slideToggle();
    
  
    });
  
    
    $('.product-list ').slick({
      infinite: true,
      adaptiveHeight: true,
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 2,
      autoplay: true,
    
    });
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      centerMode: true,
      focusOnSelect: true
    });
 
    });
    
