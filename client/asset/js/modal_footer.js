document.addEventListener('DOMContentLoaded', function () {
    let links = document.querySelectorAll('.footer_link');
    links.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            let content = link.getAttribute('data-content');
            let url = link.getAttribute('data-url');
            fetchModalContent(content, url);
        });
    });
});

function fetchModalContent(content, url) {
    if(url === '/'){
        url = './client/components/modal-footer.php?content=';
    } else{
        url = '../components/modal-footer.php?content=';
    }
  fetch( url + content)
        .then(response => response.text())
        .then(data => {
            var modalContent = document.querySelector('#dynamicModal .modal-content');
            modalContent.innerHTML = data;
            var myModal = new bootstrap.Modal(document.getElementById('dynamicModal'));
            myModal.show();
        })
        .catch(error => console.error('Error al cargar el modal:', error));
}