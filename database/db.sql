CREATE TABLE usuarios (
    id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR (255) NOT NULL,
    roles VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL UNIQUE KEY,
    password TEXT NOT NULL,

    hora_creacion DATETIME NULL,
    hora_actualizacion DATETIME NULL,
    estado VARCHAR (11)
)
ENGINE=INNODB;
INSERT INTO usuarios (nombres, roles, email, password, hora_creacion, estado)    
VALUES ('Jhon Perez', 'ADMINISTRADOR', 'admin@admin.com', '12345678', '2023-02-19 11:07:00', '1');

CREATE TABLE roles (
    id_rol INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR (255) NOT NULL UNIQUE KEY,

    hora_creacion DATETIME NULL,
    hora_actualizacion DATETIME NULL,
    estado VARCHAR (11)
)ENGINE=INNODB;
INSERT into roles(nombre_rol, hora_creacion, estado) VALUES ('ADMINISTRADOR', '2023-02-19 11:07:00', '1');
INSERT into roles(nombre_rol, hora_creacion, estado) VALUES ('PROFESOR', '2023-02-19 11:07:00', '1');
INSERT into roles(nombre_rol, hora_creacion, estado) VALUES ('ESTUDIANTE', '2023-02-19 11:07:00', '1');