</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="float-right hidden-xs">
    Design & Developed By:  <?php echo __PRODUCT__;?> <?php echo __VER__;?>
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy;  <?php echo date("Y"); ?> <a target="_blank" href="http://www.optimatrix.in/">OPTIMATRIX SOLUTIONS</a>.</strong> All rights reserved.
</footer>


</div>
<!-- ./wrapper -->


<script>
  function storageChange (event) {
    //console.log(event);
    if(event.key === 'logged_in') {
      //alert('You are Logged out from this Account.' + event.newValue);
      //alert('You are Logged out from this Account.');
      location.href = "index.php?view=default";
      //window.close();
    }
  }
  window.addEventListener('storage', storageChange, false)
</script>