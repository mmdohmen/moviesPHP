<?php
// Obtener links linkedin
require '../../helpers/functions.php';

$content = isset($_GET['content']) ? $_GET['content'] : 'default';

// Definir el contenido del modal según el parámetro
switch ($content) {
    case 'terms':
        $modalTitle = 'Términos y Condiciones';
        $modalBody = 'Estos son los términos y condiciones de uso de nuestra página web. Al usar este sitio, aceptas cumplir con todos los términos aquí descritos.';
        break;
    case 'pregunt':
        $modalTitle = 'Preguntas frecuentes';
        $modalBody = 'Esta es Preguntas frecuentes.';
        break;
    case 'ayuda':
        $modalTitle = 'Ayuda';
        $modalBody = 'Esta es la ayuda.';
        break;
    case 'detailsContact': 
        $modalTitle = 'Contacto';
        $linkedinLinks = array(
                array('name' => 'Esteban Madrid', 'url' => 'https://www.linkedin.com/in/esteban-misael-madrid/'),
                array('name' => 'Leandro Wagner', 'url' => 'https://www.linkedin.com/in/leandro-wagner-040490215/'),
                array('name' => 'Mario Dohmen', 'url' => 'https://www.linkedin.com/in/mario-maximo-dohmen-0b511836/'),
                array('name' => 'Victor Pinto', 'url' => 'https://www.linkedin.com/in/victor-pinto-fullstack/')
            );

            $modalBody = '<div class="list-group">';
            foreach ($linkedinLinks as $link) {
                    $modalBody .= '<a href="' . $link['url'] . '" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" target="_blank">';
                    $modalBody .= '<span>' . $link['name'] . '</span>';
                    $modalBody .= '<div class="d-flex align-items-center">';
                    $modalBody .= '<img src="../asset/images/linkedin.png" alt="linkedin" height="25px" width="25px" class="ms-2">';
                    $modalBody .= '</div>';
                    $modalBody .= '</a>';
            }
            $modalBody .= '</div>';
            break;
                    
    default:
        $modalTitle = 'Contacto';
        $linkedinLinks = array(
            array('name' => 'Esteban Madrid', 'url' => 'https://www.linkedin.com/in/esteban-misael-madrid/'),
            array('name' => 'Leandro Wagner', 'url' => 'https://www.linkedin.com/in/leandro-wagner-040490215/'),
            array('name' => 'Mario Dohmen', 'url' => 'https://www.linkedin.com/in/mario-maximo-dohmen-0b511836/'),
            array('name' => 'Victor Pinto', 'url' => 'https://www.linkedin.com/in/victor-pinto-fullstack/')
        );

        $modalBody = '<div class="list-group">';
        foreach ($linkedinLinks as $link) {
                $modalBody .= '<a href="' . $link['url'] . '" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" target="_blank">';
                $modalBody .= '<span>' . $link['name'] . '</span>';
                $modalBody .= '<div class="d-flex align-items-center">';
                $modalBody .= '<img src="./client/asset/images/linkedin.png" alt="linkedin" height="25px" width="25px" class="ms-2">';
                $modalBody .= '</div>';
                $modalBody .= '</a>'; 
        }
        $modalBody .= '</div>';
        break;
}
?>
<section class="modal-container">
    <div class="modal-header">
        <h5 class="modal-title" id="dynamicModalLabel"><?php echo $modalTitle; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <?php echo $modalBody; ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    </div>
</section>