<!-- HADEEQAH FAQ PAGE-->

<!DOCTYPE html>

<html lang ="en"> 
    <head>
        <meta charset="utf-8"> 
        <meta name="author" content="Group 31"> 
        <meta name="description" content="FAQs Page"> 
        <link rel="icon" href="homepage-img/logo.png"> 
        <title> FAQs </title>  
        <link rel = "stylesheet" type="text/css"  href="styles.css">  
     </head>

     <body class="FAQ-page">
        <header>
   
           <div class="logo"> 
             <a href="/offside/index.php">
               <img src="homepage-img/logo.png" alt="Offside Logo">
             </a>

            </div>

            <div class="top-right-nav">
                <div id="nav1">
                  <a href="index.php">Home</a>
                  <a href="basket/contact.php">Contact Us</a>
                  <a href="user_files/login.php">Log In</a>
                  
                </div>
      
              </div>
      
          
            </header>
            <hr>

            <div class="faq-container"> 
                <div class="faq-header"> 
                  <h1>Frequently Asked Questions</h1> 
                </div>
              
                <div class="FAQs"> 
                  <h2 class="faq-question">What is your returns policy like?</h2> 
                  <div class="faq-answer"> 
                   We offer free returns within 30 days of purchase. All you have to do is return the items in their original condition with tags in order to get your full refund.
                  </div>
                </div>
      
      <br>
      <div class="FAQs"> 
          <h2 class="faq-question">How much does delivery cost?</h2> 
          <div class="faq-answer"> 
          Our standard delivery costs £3.99 and our next day delivery costs £5.99.
          </div>
        </div>
      
      <br> 
      <div class="FAQs"> 
          <h2 class="faq-question">Where is my order?</h2> 
          <div class="faq-answer"> 
              If your order hasn't arrived by the estimated delivery date, we recommend first checking with your neighbors to see if the courier may have left the parcel at their address. Additionally, please inspect any safe areas around your property where the driver might have placed your parcel, such as your garden shed or porch. If you still unable to find your parcel, then please contact us and we will try our best to assist you.
          </div>
        </div>
      <br>
      
      
        <div class="FAQs"> 
          <h2 class="faq-question">What shall I do if I have recieved faulty or damaged items?</h2> 
          <div class="faq-answer"> 
         If you have recieved faulty or damaged items, you can simply return them for a full refund as long as it is within our returns period
          </div>
        </div>

        <br>
  <div class="FAQs"> 
    <h2 class="faq-question">Can I change my order?</h2> 
    <div class="faq-answer"> 
    Unfortunately, once an order has been placed we cannot change it therefore we advise you make sure all details are correct before doing placing your order.
    </div>
  </div>

  <br>

          <div class="FAQs">
            <h2 class="faq-question">Are your sports wear suitable for all fitness activities? </h2>
            <div class="faq-answer">
            yes, our sport wear are suitable for a variety of activities, including running, yoga, working out in the gym and many more.
            </div>
          </div>
<br>

<div class="FAQs"> 
    <h2 class="faq-question">Are your sports wear machine washable?</h2> 
    <div class="faq-answer"> 
    Although majority of our sport wear are machine washable we recommend you to follow the directions on the clothing items label.
    </div>
  </div>

  <br>

         
  <div class="FAQs"> 
    <h2 class="faq-question">I have other questions...</h2> 
    <div class="faq-answer"> 
    If you have any other questions please don't hesitate to contact us through our contact us page.
    </div>
  </div>    

  <div class="back-to-top"> 
    <a href="#top">Back to Top</a>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() { 
      var faq = document.querySelectorAll('.FAQs'); 
  
      faq.forEach(function(item) { 
        item.addEventListener('click', function() { 
          var content = this.querySelector('.faq-answer');
          if (content.style.display === 'block') { 
            content.style.display = 'none'; 
          } else { 
            content.style.display = 'block'; 
          }
        });
      });
    });
  </script>




</body>





</html>