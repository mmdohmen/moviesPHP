function previewImage(event) {
  //Recuperamos el input que desencadeno la acción
  const input = event.target;
  console.log(input);

  //Recuperamos la etiqueta del contenedor donde cargaremos la imagen
  let imgPreview = document.querySelector('#previewImage');

  // Verificamos si existe una imagen seleccionada
  if (!input.files.length) return;

  //Recuperamos el archivo subido
  file = input.files[0];

  //Creamos la url
  objectURL = URL.createObjectURL(file);

 // crear etiqueta imágen
 let img = document.createElement('img');
 img.src = objectURL;
 img.className = "mx-5 my-4 img-form";

 //Limpiamos el contenedor para que no se renderice mas de una imágen
 imgPreview.innerHTML = ''; 
 // Renderizamos la imágen en el contenedor
 imgPreview.append(img);
}