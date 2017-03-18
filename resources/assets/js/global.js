
  $(function(){

    $('select').material_select();
    $('.button-collapse').sideNav();
    $('.modal').modal();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        onStart: () => {
          $('.picker').appendTo('body');
        }
    });

    $('ul.tabs').tabs();

    window.setTimeout(function () {
        $('.alert-box').fadeOut('slow');
    }, 5000);
    
    

  }); // end of document ready