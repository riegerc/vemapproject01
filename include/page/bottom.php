</div>
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?php echo PAGE_NAME ?> 2019</span>
        </div>
    </div>
</footer>
</div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<?php include "logoutModal.php"; ?>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/vue/vue.js"></script>
<script src="js/app.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "search": false,
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
    });
</script>
</body>
</html>
