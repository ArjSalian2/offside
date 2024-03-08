<div class="content">
  <nav>
    <span class="separator"></span>
    <ul class="logout">
      <li>
        <a href="#"><i class="bx bx-log-out icon"></i> Logout</a>
      </li>
    </ul>
  </nav>
  <?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success">
      <?php echo $_SESSION['success']; ?>
    </div>
  <?php } ?>
  <?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger">
      <?php echo $_SESSION['error']; ?>
    </div>
  <?php } ?>
</div>
<?php
unset($_SESSION['success']);
unset($_SESSION['error']);
?>

<script>
  function hideAlert() {
    const alertElement = document.getElementsByClassName("alert")[0];
    if (alertElement) {
      // First, make the alert fade in by adding the 'fade-in' class
      alertElement.classList.add('fade-in');

      // Then, wait for 3 seconds before starting the fade-out
      setTimeout(function () {
        // Begin the fade out by removing the 'fade-in' class
        alertElement.classList.remove('fade-in');

        // Optionally, if you want to completely remove the alert after fading out,
        // wait for another 2 seconds (the duration of the fade effect) and then hide it
        setTimeout(() => {
          alertElement.style.display = 'none';
        }, 2000); // Make sure this matches your CSS transition duration
      }, 3000); // Display time before starting fade-out
    }
  }
  window.onload = hideAlert;
</script>
