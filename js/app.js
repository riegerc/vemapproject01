// Author: Oliver Stingl

let app = new Vue({
    el: "#content",
    data: {
        branches: null,
        branchCheckboxes: [],
        tableName: null,
        customerBuyAmount: 1,
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
                        "lengthMenu": [10],
                        "language": {
                            "lengthMenu": "_MENU_ Einträge pro Seite",
                            "zeroRecords": "K0eine Einträge gefunden",
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
    },
    computed: {
        customerBuyPrice: () => {
            return document.getElementById('customerBuyPrice') ? (document.getElementById('customerBuyPrice').innerHTML) : null;
        }
    }
});
