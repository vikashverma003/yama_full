  
      <!-- footer -->
      <footer>
         <div class="container">
            <div class="row">
               <div class="col-lg-5">
                  <a href="#"><img class="footer-logo" src="{{asset('colla/images/header_logo.png')}}"></a>     
                  <p>Somos una empresa mexicana dedicada al sector de la construcción con más de 30 años de experiencia.
Actualmente, estamos desarrollando más de 200,000 m2 en espacios corporativos, residenciales y mixtos
en los corredores más importantes de la Ciudad de México.</p>
               </div>
               <div class="col-lg-2 offset-md-1">
                  <div class="footer-item">
                     <h3>Product</h3>
                     <ul>
                        <li><a href="">Book Spaces</a></li>
                        <li><a href="">Order Food</a></li>
                        <li><a href="">Request Valet</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-2">
                  <div class="footer-item">
                     <h3>Compamy</h3>
                    <ul>
                        <li><a href="#">About Yama</a></li>
                        <li><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                  </div>
               </div>
               <div class="col-lg-2">
                  <div class="footer-item">
                     <h3>Contact Us</h3>
                    <ul>
                        <li><a href="#">Help &amp; Support</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">FAQ’s</a></li>
                    </ul>
                  </div>
               </div>
            </div>
         </div>
      <div class="footer-bottom">
         <div class="container">
            <div class="row">
               <div class="col-md-10">
                   <h6>2019 Yama.com</h6>
                  <p> By continuing past this page, you agree to our Terms of Service, Cookie Policy, Privacy Policy and Content Policies. All trademarks are properties of their respective owners. &copy; 2019-2020 - yama.com. All rights reserved.</p>
               </div>
               <div class="col-md-2 text-right">
                  <ul class="social">
                     <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      </footer>
      <!-- footer -->
       
<!-- popup's  -->

       
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
       
       <script>
       (function() {
      'use strict';

      function ctrls() {
          var _this = this;

          this.counter = 0;
          this.els = {
              decrement: document.querySelector('.ctrl-button-decrement'),
              counter: {
                  container: document.querySelector('.ctrl-counter'),
                  num: document.querySelector('.ctrl-counter-num'),
                  input: document.querySelector('.ctrl-counter-input')
              },
              increment: document.querySelector('.ctrl-button-increment')
          };

          this.decrement = function() {
              var counter = _this.getCounter();
              var nextCounter = (_this.counter > 0) ? --counter: counter;
              _this.setCounter(nextCounter);
          };

          this.increment = function() {
              var counter = _this.getCounter();
              var nextCounter = (counter < 9999999999) ? ++counter: counter;
              _this.setCounter(nextCounter);
          };

          this.getCounter = function() {
              return _this.counter;
          };

          this.setCounter = function(nextCounter) {
              _this.counter = nextCounter;
          };

          this.debounce = function(callback) {
              setTimeout(callback, 100);
          };

          this.render = function(hideClassName, visibleClassName) {
              _this.els.counter.num.classList.add(hideClassName);

              setTimeout(function() {
                  _this.els.counter.num.innerText = _this.getCounter();
                  _this.els.counter.input.value = _this.getCounter();
                  _this.els.counter.num.classList.add(visibleClassName);
              },
              100);

              setTimeout(function() {
                  _this.els.counter.num.classList.remove(hideClassName);
                  _this.els.counter.num.classList.remove(visibleClassName);
              },
              200);
          };

          this.ready = function() {
              _this.els.decrement.addEventListener('click',
              function() {
                  _this.debounce(function() {
                      _this.decrement();
                      _this.render('is-decrement-hide', 'is-decrement-visible');
                  });
              });

              _this.els.increment.addEventListener('click',
              function() {
                  _this.debounce(function() {
                      _this.increment();
                      _this.render('is-increment-hide', 'is-increment-visible');
                  });
              });

              _this.els.counter.input.addEventListener('input',
              function(e) {
                  var parseValue = parseInt(e.target.value);
                  if (!isNaN(parseValue) && parseValue >= 0) {
                      _this.setCounter(parseValue);
                      _this.render();
                  }
              });

              _this.els.counter.input.addEventListener('focus',
              function(e) {
                  _this.els.counter.container.classList.add('is-input');
              });

              _this.els.counter.input.addEventListener('blur',
              function(e) {
                  _this.els.counter.container.classList.remove('is-input');
                  _this.render();
              });
          };
      };

      // init
      var controls = new ctrls();
      document.addEventListener('DOMContentLoaded', controls.ready);
  })();
       </script>
      
   </body>
</html>