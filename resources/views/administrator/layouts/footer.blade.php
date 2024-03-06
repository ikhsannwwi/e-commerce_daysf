<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            {{ array_key_exists('footer_app_admin', $settings) ? $settings['footer_app_admin'] : 'Startweb' }} ©
            <script>
                document.write(new Date().getFullYear());
            </script>
            , Develop by
            <a href="https://ikhsannwwi.rf.gd" target="_blank" class="footer-link fw-bolder">Mochammad Ikhsan Nawawi</a>
        </div>
    </div>
</footer>
<!-- / Footer -->
