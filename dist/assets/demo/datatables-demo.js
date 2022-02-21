// Call the dataTables jQuery plugin
$(document).ready(function() {
	jQuery('#dataTable').DataTable({
		rowReorder: {
			selector: 'td:nth-child(2)'
		},
		responsive: true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		},
		"paging": true,
		"processing": true,
		'serverMethod': 'post',
		//"ajax": "data.php",
		dom: 'lBfrtip',
		buttons: [
		'excel', 'csv', 'pdf', 'print', 'copy',
		],
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
	} );

});
