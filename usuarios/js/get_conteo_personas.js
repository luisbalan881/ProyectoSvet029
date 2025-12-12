$(document).ready(function(){

    // submit button click

setInterval(function(){
contar();
}, 4000);


});

function contar(){
  $.ajax({
      url: 'usuarios/php/get_conteo_empleados.php',
      type: 'post',
      data: {},
      dataType: 'JSON',
      success: function(response){



          // selecting values from response Object
          var a = response.a;
          var b = response.b;
          var c = response.c;

          // setting values

          if(a == $('#total').text())
          {
            $('#total').text(a);
          }
          else {
            jQuery({ Counter: 0 }).animate({ Counter: a }, {
              duration: 2000,
              easing: "swing",
              step: function () {
                $("#total").text(Math.ceil(this.Counter));
              }
            });
          }


          if(b == $('#inactivas').text())
          {
            $('#inactivas').text(b);
          }
          else {
            jQuery({ Counter: 0 }).animate({ Counter: b }, {
              duration: 2000,
              easing: "swing",
              step: function () {
                $("#inactivas").text(Math.ceil(this.Counter));
              }
            });
          }


          if(c == $('#activar').text())
          {
            $('#activar').text(c);
          }
          else {
            jQuery({ Counter: 0 }).animate({ Counter: c }, {
              duration: 2000,
              easing: "swing",
              step: function () {
                $("#activar").text(Math.ceil(this.Counter));
              }
            });
          }





      }
  });
}
