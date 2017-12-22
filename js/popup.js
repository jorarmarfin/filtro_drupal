jQuery(document).ready(function($) {
  var popup_num_news = $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').length;
  $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').hide();
  $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').eq(0).show();
  $('.popup > .block__inner > .block__content .popup-points .popup-point').eq(0).css({'background-color':'#ffffff'});
  var popup_select = 0;
  var popup_count = 0;

  var popup_enterframe = setInterval(function(){
    if(popup_count < (popup_num_news - 1)){
      popup_count ++;
    }else{
      popup_count = 0;
    }
    seleccionar(popup_count);
  }, 7000);

  function seleccionar(num){
    TweenMax.to($('.popup > .block__inner > .block__content .popup-content-body .popup-news > li'), 0.5, {css:{'opacity':'0'}, onComplete: function(){
      $('.popup > .block__inner > .block__content .popup-points .popup-point').css({'background-color':'#333333'});
      $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').css({'z-index':(popup_num_news - 1)});
      $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').hide();
      $('.popup > .block__inner > .block__content .popup-points .popup-point').eq(num).css({'background-color':'#ffffff'});
      $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').eq(num).show();
      $('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').eq(num).css({'z-index':popup_num_news});
      TweenMax.to($('.popup > .block__inner > .block__content .popup-content-body .popup-news > li').eq(num), 0.5, {css:{'opacity':'1'}});
    }});
  }

  $('.popup > .block__inner > .block__content .popup-points .popup-point').click(function(event) {
    popup_count = ($(this).index());
    seleccionar(popup_count);
  });

  TweenMax.to($('.popup > .block__inner'), 1, {css:{'right':'100px'}});
  $('.popup > .block__inner > .block__content .popup-content-head .fa.fa-times-circle-o').click(function(event) {
    TweenMax.to($('.popup > .block__inner'), 1, {css:{'right':'-400px'}, onComplete: function(){
      $('.popup > .block__inner').hide();
      $('.popup > .block__inner').remove();
    }});
  });
});
