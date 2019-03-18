	
	<footer>
      <div class="copyright-info">
        <p class="pull-right">IT Division - <a target="_blank" href="https://www.facebook.com/eryan.fauzan.1">Eryan Fauzan</a>
        </p>
      </div>
      <div class="clearfix"></div>
  </footer>
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/js/chart.min.js"></script>

	<script src="<?=base_url()?>assets/js/easypiechart.js"></script>

	<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>
</html>