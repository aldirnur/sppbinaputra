$(document).ready(function (){
	$('.datatable').DataTable();
	// datatable export buttons
	$('#datatable-export').DataTable( {
        // dom: 'Bfrtip',
		// buttons: [
		// 	{
        //     extend: 'collection',
        //         text: 'Export Data',
        //         buttons: [
        //             {
        //                 extend: 'pdf',
        //                 exportOptions: {
        //                     columns: "thead th:not(.action-btn)"
        //                 }
        //             },
        //             {
        //                 extend: 'excel',
        //                 exportOptions: {
        //                     columns: "thead th:not(.action-btn)"
        //                 }
        //             },
        //         ]
        // 	}
    	// ]
	});

    $('#datatable-siswa').DataTable( {
        dom: 'Bfrtip',
		buttons: [
			{
            extend: 'collection',
                text: 'Export Data',
                buttons: [
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                ]
        	}
    	]
	});

    $('#report-export').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			{
            extend: 'collection',
                text: 'Export Data',
                buttons: [
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                ]
        	}
    	]
	});

    // $('#export-id').DataTable( {
	// 	dom: 'Bfrtip',
	// 	buttons: [
	// 		{
    //             extend: 'collection',
    //             text: 'Export Data',
    //             buttons: [
    //                 {
    //                     extend: 'excel',
    //                     exportOptions: {
    //                         columns: "thead th:not(.action-btn)"
    //                     }
    //                 },
    //             ]
    //     	}
    // 	]
	// });

});


