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

