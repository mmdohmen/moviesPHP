# Proyecto Movies CAC - 2024

En <b>CAC-Movies</b>, podrás descubrir todo lo que siempre has querido saber sobre tus películas preferidas. Desde sinopsis detalladas y elenco principal hasta trivia fascinante y datos curiosos, nuestra plataforma te brinda una experiencia cinematográfica completa.<br>¿Quieres conocer a fondo la trama de una película antes de verla? No hay problema. En <b>CAC-Movies</b>, encontrarás resúmenes completos y análisis profundos de las películas más populares. Podrás conocer los giros sorprendentes, los personajes memorables y las escenas más icónicas antes de sumergirte en la historia.<br>Además, en nuestra página también podrás explorar el extenso catálogo de películas de diferentes géneros y épocas. ¿Buscas una comedia romántica para una noche acogedora en casa? ¿O tal vez prefieres sumergirte en un mundo de fantasía épica? Sea cual sea tu preferencia, seguro encontrarás una película que capturará tu atención.

[Sitio Web CAC-Movie](https://piratearg.free.nf/)

---

# 💻 Tecnología:

![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white) ![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white) ![JqueryUI](https://1.bp.blogspot.com/-_nEv-jCX7jg/X8CoTKUfaqI/AAAAAAAAClY/BEST8wQxnz48yS2sjMgvRjVEYUTsSfgZQCLcBGAsYHQ/w80-h80/1516245064-1543980323.jpg) <img style="display: block;-webkit-user-select: none;margin: auto;width: 110px; background: white;" src="https://cdn.tsldesigns.co.uk/images/data-tables.png"/>

---

#### Crear la base de datos si no existe

```sql
CREATE DATABASE IF NOT EXISTS movies_db;
```

#### Seleccionar la base de datos

```sql
USE movies_db;
```

#### Crear la tabla usuarios
```sql
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_nac VARCHAR(255) NOT NULL,
    pais VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario',
    CONSTRAINT chk_rol CHECK (rol IN ('admin', 'usuario'))
);
```

---

#### Crear la tabla peliculas

```sql
CREATE TABLE IF NOT EXISTS peliculas (
  id_pelicula INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(200) NOT NULL,
  descripcion TEXT NOT NULL,
  genero VARCHAR(150) NOT NULL,
  anio INT NOT NULL,
  calificacion DECIMAL(4,3) NOT NULL DEFAULT 1,
  director VARCHAR(255) NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  seccion ENUM('tendencias', 'aclamadas', 'list') DEFAULT 'list',
  estado TINYINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_pelicula)
);
```


---

#### Pegar esta direccion en la url y crea las peliculas en la base de datos

```markdown
  localhost/movies-backend/api/unload/uploadmovies
```

---

![](https://visitcount.itsvg.in/api?id=cac-movies&icon=1&color=0)
