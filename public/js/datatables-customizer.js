
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
});

$(document).ready(function () {
    $(".datatable").DataTable();
    // datatable export buttons
    $("#datatable-export").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "collection",
                text: "Export Data",
                buttons: [
                    {
                        extend: "pdf",
                        exportOptions: {
                            columns: "thead th:not(.action-btn)",
                        },
                    },
                    {
                        extend: "excel",
                        exportOptions: {
                            columns: "thead th:not(.action-btn)",
                        },
                    },
                ],
            },
        ],
    });


    $("#datatable").DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
    });

    $("#datatable-siswa").DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        dom:
            "<'row'<'col-sm-12'lBf>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [
            {
                extend: "collection",
                text: "Export Data",
                buttons: [
                    {
                        extend: "pdf",
                        exportOptions: {
                            columns: "thead th:not(.action-btn)",
                        },
                    },
                    {
                        extend: "excel",
                        exportOptions: {
                            columns: "thead th:not(.action-btn)",
                        },
                    },
                ],
            },
        ],
        features: {
            search: {
                input: "f",
            },
        },
    });

    $("#report-export").DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        dom:
            "<'row'<'col-sm-12'lBf>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "collection",
                text: "Export Data",
                buttons: [
                    {
                        extend: "pdf",
                        exportOptions: {
                            columns: "thead th:not(.action-btn)",
                        },
                    },
                    {
                        extend: "excel",
                        exportOptions: {
                            columns: "thead th:not(.action-btn)",
                        },
                    },
                ],
            },
        ],
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
