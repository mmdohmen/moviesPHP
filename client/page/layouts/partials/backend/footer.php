<!-- CDN sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- helper para mostrar modal sweetalert2 enviandole los datos necesarios -->
<?php
if (isset($_SESSION['messages'])) {
    echo modalSweetAlert($_SESSION['messages']['title'], $_SESSION['messages']['message'], $_SESSION['messages']['icon']);
}

unset($_SESSION['messages']);
?>



<!--Script Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<!--	script datatables -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<!--	Custom Script  -->
<script src="../../asset/js/api_movies.js"></script>
<!-- Cargar Script para la actualicación de estado: activo / inactivo -->
<script src="../../asset/js/change_status.js"></script>
<!-- Script para visualizar las imágenes previas -->
<script src="../../asset/js/visualizar.js"></script>
</body>

</html>