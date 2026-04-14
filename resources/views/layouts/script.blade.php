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
     });

     function cekAdmin(id) {

         if (id == 1) {
             alert('Admin utama tidak bisa diedit');
             return false;
         }

         return true;

     }
 </script>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 @if (session('success'))
     <script>
         Swal.fire({
             title: "Berhasil",
             text: "{{ session('success') }}",
             icon: "success"
         });
     </script>
 @endif


 @if (session('error'))
     <script>
         Swal.fire({
             icon: "error",
             title: "Gagal",
             text: "{{ session('error') }}",

         });
     </script>
 @endif
