CREATE TABLE roles (
    id_rol INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR (255) NOT NULL UNIQUE KEY,

    hora_creacion DATETIME NULL,
    hora_actualizacion DATETIME NULL,
    estado VARCHAR (11)
)ENGINE=INNODB;

INSERT into roles(nombre_rol, hora_creacion, estado) VALUES ('ADMINISTRADOR', '2025-02-19 11:07:00', '1');
INSERT into roles(nombre_rol, hora_creacion, estado) VALUES ('PROFESOR', '2025-02-19 11:07:00', '1');
INSERT into roles(nombre_rol, hora_creacion, estado) VALUES ('ESTUDIANTE', '2025-02-19 11:07:00', '1');


CREATE TABLE usuarios (
    id_usuario INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR (255) NOT NULL,
    rol_id INT (11) NOT NULL,
    email VARCHAR (255) NOT NULL UNIQUE KEY,
    password TEXT NOT NULL,

    hora_creacion DATETIME NULL,
    hora_actualizacion DATETIME NULL,
    estado VARCHAR (11),


    FOREIGN KEY (rol_id) REFERENCES roles(id_rol) on DELETE NO ACTION on UPDATE CASCADE 
    -- lo que quiere decir delete es que se elimine en cascada, es decir si se elimina un rol se elimina el usuario
)ENGINE=INNODB;


INSERT INTO usuarios (nombres, rol_id, email, password, hora_creacion, estado)    
VALUES ('Jhon Perez', '1', 'admin@admin.com', '12345678', '2025-02-19 00:07:00', '1');

CREATE TABLE materias (

  id_materia      INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_materia         VARCHAR (255) NOT NULL,

  hora_creacion   DATETIME NULL,
  hora_actualizacion DATETIME NULL,
  estado        VARCHAR (11)

)ENGINE=InnoDB;
INSERT INTO materias (nombre_materia,hora_creacion,estado)
VALUES ('MATEMÁTICA','2023-12-28 20:29:10','1');

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_entrega` date NOT NULL,
  `estado` varchar(50) NOT NULL,
  `hora_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_actualizacion` datetime DEFAULT NULL,
  `id_materia` int(11) NOT NULL,
  PRIMARY KEY (`id_tarea`),
  FOREIGN KEY (`id_materia`) REFERENCES `materias`(`id_materia`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

