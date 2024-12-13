<footer class="main-footer text-light" style="background-color: #F44336;">
	<strong>2024
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./assets/dist/js/demo.js"></script>
<script src="./assets/dist/js/script-menu.js"></script>
<script src="./assets/plugins/summernote/summernote-bs4.min.js"></script>
<script>
	$(function() {
		// Summernote
		$('.textarea').summernote({
			height: 200
		});
	});


	$(function() {
		var url = window.location;
		// for single sidebar menu
		$('ul.nav-sidebar a').filter(function() {
			return this.href == url;
		}).addClass('active');

		// for sidebar menu and treeview
		$('ul.nav-treeview a').filter(function() {
				return this.href == url;
			}).parentsUntil(".nav-sidebar > .nav-treeview")
			.css({
				'display': 'block'
			})
			.addClass('menu-open').prev('a')
			.addClass('active');
	});
</script>
<script src="./assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
	$(function() {
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": true,
			"pageLength": 10,
			"autoWidth": true,
		});
	});
</script>
</body>

</html>