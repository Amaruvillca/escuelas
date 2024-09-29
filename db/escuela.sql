
create database escuela;
use escuela;


CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    Numero_carnet VARCHAR(20) NOT NULL UNIQUE, 
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('administrador', 'docente') NOT NULL
);


CREATE TABLE Alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido_pa VARCHAR(100) NOT NULL,
    apellido_ma VARCHAR(100) NOT NULL,
    Numero_carnet VARCHAR(20) NOT NULL UNIQUE, 
    fecha_nacimiento DATE NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    id_usuario int,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
INSERT INTO Alumno (nombre, apellido_pa, apellido_ma, Numero_carnet, fecha_nacimiento, direccion, telefono, id_usuario) 
VALUES ('Juan', 'Pérez', 'García', '123456', '2005-06-15', 'Calle Falsa 123', '987654321', 5);

drop table alumno;
drop table Inscripcion;
drop table nota;
drop table Asignatura;
drop table grado;

CREATE table Materias(
 id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);
CREATE TABLE Asignatura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    id_usuario int,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        id_materia int,
    FOREIGN KEY (id_materia) REFERENCES Materias(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Inscripcion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_asignatura INT NOT NULL,
    id_grado int,
    fecha_inscripcion DATE NOT NULL,
    FOREIGN KEY (id_alumno) REFERENCES Alumno(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_asignatura) REFERENCES Asignatura(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
        ,
    FOREIGN KEY (id_grado) REFERENCES grado(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);


CREATE TABLE Nota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_inscripcion INT NOT NULL,
    nota DECIMAL(11, 2) NOT NULL,
    fecha_asignacion DATE NOT NULL,
    FOREIGN KEY (id_inscripcion) REFERENCES Inscripcion(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
create table grado (
id INT AUTO_INCREMENT PRIMARY KEY,
    curso varchar(255) NOT NULL,
    grado varchar(255) NOT NULL,
    paralelo varchar(2) NOT NULL,
    id_alumno int,
    FOREIGN KEY (id_alumno ) REFERENCES Alumno(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

);
INSERT INTO grado (curso, grado, paralelo, id_alumno)
VALUES ('primero', 'primaria', 'A', 1);
select *from grado;

select * from usuario order by id desc;
select * from alumno;
select * from materias;
select * from inscripcion;
INSERT INTO Inscripcion (id_alumno, id_asignatura, id_grado, fecha_inscripcion)
VALUES (1, 3, 1, CURDATE());

INSERT INTO Materias (nombre, descripcion)
VALUES ('Matemáticas', 'Materia que estudia los números, las operaciones aritméticas, el álgebra, la geometría, y otros campos relacionados.');

INSERT INTO Asignatura (nombre, descripcion, id_usuario, id_materia) 
VALUES ('Matemáticas Básicas', 'Introducción a los conceptos básicos de las matemáticas.', 4,2 );
INSERT INTO Nota (id_inscripcion, nota, fecha_asignacion) VALUES
(2, 80, '2024-01-15');
select * from nota;
SELECT a.id AS id_asignatura, a.nombre AS nombre_asignatura, a.descripcion AS descripcion_asignatura
FROM Asignatura a
JOIN Usuario u ON a.id_usuario = u.id
WHERE u.id = 4; 



