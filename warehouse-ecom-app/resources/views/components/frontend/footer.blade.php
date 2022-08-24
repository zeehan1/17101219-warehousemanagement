  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>{{ config('appEnv.app.name') }}</span></strong>.{{ date('Y') }}. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<!-- End of Footer -->
<script>
    $(document).ready(function() {
        @if(session('success'))
        Swal.fire({
        icon: 'success',
        title: 'Successful &#11088;',
        text: '{{ session('success') }}',
        })
        @endif
        @if(session('error'))
        Swal.fire({
        icon: 'error',
        title: 'Sorry.... &#10071',
        text: '{{ session('error') }}',
        })
        @endif
});
</script>
