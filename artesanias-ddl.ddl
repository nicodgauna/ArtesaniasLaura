CREATE TABLE estados (
    id INT(3) AUTO_INCREMENT PRIMARY KEY,
    nombre_estado VARCHAR(50) NOT NULL
);


CREATE TABLE pedidos (
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    direccion_cliente VARCHAR(255) NOT NULL,
    telefono_cliente VARCHAR(50) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    estados_id INT(3) NOT NULL
) AUTO_INCREMENT=1500;


CREATE TABLE productos (
    id INT(8) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(200) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT(6) NOT NULL,
    imagen_url VARCHAR(255),
    activo TINYINT(1) NOT NULL DEFAULT 1,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE orden (
    id INT(10) AUTO_INCREMENT PRIMARY KEY, 	
    productos_id INT(8) NULL,
    pedidos_id INT(10) NOT NULL,
    cantidad INT(10) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);


CREATE TABLE usuarios (
    id INT(3) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(30) NOT NULL,	
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);


-- Relaciones (Foreign Keys)

ALTER TABLE orden
    ADD CONSTRAINT orden_pedidos_fk FOREIGN KEY (pedidos_id)
    REFERENCES pedidos (id);

ALTER TABLE orden
    ADD CONSTRAINT orden_productos_fk FOREIGN KEY (productos_id)
    REFERENCES productos (id)
    ON DELETE SET NULL;

ALTER TABLE pedidos
    ADD CONSTRAINT pedidos_estados_fk FOREIGN KEY (estados_id)
    REFERENCES estados (id);



nicolasdgauna
Huevopodrido208310@
