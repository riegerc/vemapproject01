let app = new Vue({
    el: "#content",
    data: {
        branches: null,
        branchCheckboxes: [],
        tableName: null,
    },
    mounted() {
        let vue = this;
        setTimeout(() => {
            if (document.getElementById("transferToJavaScript")) {
                vue.branches = JSON.parse(document.getElementById("transferToJavaScript").innerHTML);
                vue.$forceUpdate();
                vue.tableName = 'shortTable';
            }

            jQuery(document).ready(function () {
                jQuery('#dataTable').DataTable({
                    "lengthMenu": [10, 25, 50],
                    "language": {
                        "lengthMenu": "_MENU_ Einträge pro Seite",
                        "zeroRecords": "Keine Einträge gefunden",
                        "info": "Seite _PAGE_ von _PAGES_",
                        "infoEmpty": "Keine Einträge verfügbar",
                        "infoFiltered": "(von _MAX_ Einträgen)",
                        "search": "Detailsuche",
                        "paginate": {
                            "previous": "Vorherige",
                            "next": "Nächste"
                        }
                    }
                });

                jQuery(document).ready(function () {
                    jQuery('#shortTable').DataTable({
                        "lengthMenu": [5],
                        "language": {
                            "lengthMenu": "_MENU_ Einträge pro Seite",
                            "zeroRecords": "Keine Einträge gefunden",
                            "info": "Seite _PAGE_ von _PAGES_",
                            "infoEmpty": "Keine Einträge verfügbar",
                            "infoFiltered": "(von _MAX_ Einträgen)",
                            "search": "Suche",
                            "paginate": {
                                "previous": "Vorherige",
                                "next": "Nächste"
                            }
                        }
                    });
                });
            }, 1500);
        });
    }
});
