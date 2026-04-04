 <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
 <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
 <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
 <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
 <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
 <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

 <!-- App js-->
 <script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        new DataTable('#table', {
            pageLength: 10
        });



        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    });
</script>
