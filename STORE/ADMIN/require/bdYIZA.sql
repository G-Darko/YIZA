-- show variables like 'max_allowed_packet'
-- set global max_allowed_packet=33554432

-- Crear BD
CREATE DATABASE IF NOT EXISTS yiza character set utf8 collate utf8_general_ci;
use yiza;

-- Cotejamiento
ALTER DATABASE yiza CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Crear Tablas
CREATE TABLE IF NOT EXISTS statusPed (
	id_statusPed int NOT NULL AUTO_INCREMENT,
	status VARCHAR(255) NOT NULL,
	CONSTRAINT pk_statusPedido PRIMARY KEY (id_statusPed)
);

CREATE TABLE IF NOT EXISTS statusAll (
	id_status int NOT NULL AUTO_INCREMENT,
	status VARCHAR(255) NOT NULL,
	CONSTRAINT pk_status PRIMARY KEY (id_status)
);

CREATE TABLE IF NOT EXISTS rol (
	id_rol int NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(255) NOT NULL,
	CONSTRAINT pk_rol PRIMARY KEY (id_rol)
);

CREATE TABLE IF NOT EXISTS usuarios (
	id_usu int AUTO_INCREMENT NOT NULL,
	nombres VARCHAR(255) NOT NULL,
	ap1 VARCHAR(255),
	ap2 VARCHAR(255),
	usuario VARCHAR(255) NOT NULL UNIQUE,
	correo VARCHAR(255) NOT NULL UNIQUE,
	pass VARCHAR(255) NOT NULL,
	id_rol int NOT NULL,
	img TEXT,
	fechaAlta DATE NOT NULL,
	id_statusUsu int,
	CONSTRAINT pk_inicio PRIMARY KEY (id_usu)
);

CREATE TABLE IF NOT EXISTS productos (
	id_prod int AUTO_INCREMENT NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	des TEXT,
	metaT VARCHAR(255) NOT NULL,
	metaDes TEXT,
	metaClave TEXT,
	modelo VARCHAR(255) NOT NULL,
	sku VARCHAR(255),
	precio decimal(15,2), 
	stock int, 
	img TEXT,
	id_mar int,
	id_cat int,
	id_statusProd int,
	CONSTRAINT pk_productos PRIMARY KEY (id_prod)
);

CREATE TABLE IF NOT EXISTS categorias (
	id_cat int AUTO_INCREMENT NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	descripcion TEXT,
	metaT VARCHAR(255) NOT NULL,
	metaDes TEXT,
	metaClave TEXT,
	id_statusCat int,
	CONSTRAINT pk_categorias PRIMARY KEY (id_cat)
);

CREATE TABLE IF NOT EXISTS cPadre (
	id int NOT NULL AUTO_INCREMENT,
	id_cat int NOT NULL,
	id_padre int NOT NULL,
	CONSTRAINT pk_padre PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS marcas (
	id_mar int AUTO_INCREMENT NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	img TEXT,
	CONSTRAINT pk_categorias PRIMARY KEY (id_mar)
);

CREATE TABLE IF NOT EXISTS imgP (
	id_img int NOT NULL AUTO_INCREMENT,
	img TEXT,
	id_prod int,
	CONSTRAINT pk_imagen PRIMARY KEY (id_img)
);

CREATE TABLE IF NOT EXISTS carrito (
	id_cart int NOT NULL AUTO_INCREMENT,
	id_prod int NOT NULL,
	id_usu int NOT NULL,
	cantidad int NOT NULL,
	CONSTRAINT pk_cart PRIMARY KEY (id_cart)
);

CREATE TABLE IF NOT EXISTS favoritos (
	id_fav int NOT NULL AUTO_INCREMENT,
	id_prod int NOT NULL,
	id_usu int NOT NULL,
	CONSTRAINT pk_fav PRIMARY KEY (id_fav)
);

CREATE TABLE IF NOT EXISTS pedidos (
	id_ped int NOT NULL AUTO_INCREMENT,
	id_usu int NOT NULL,
	id_dir int NOT NULL,
	id_prod int NOT NULL,
	id_statusPed int NOT NULL,
	pago decimal(15,2) NOT NULL,
	cantidad int NOT NULL,
	fecha date NOT NULL,
	CONSTRAINT pk_pedidos PRIMARY KEY (id_ped)
);

CREATE TABLE IF NOT EXISTS config (
	id int NOT NULL AUTO_INCREMENT,
	nomCom VARCHAR(30) NOT NULL,
	metaNom VARCHAR(30) NOT NULL,
	metaDes text,
	metaClave text,
	propietario VARCHAR(255) NOT NULL,
	direccion text,
	correo VARCHAR(255) NOT NULL,
	telefono VARCHAR(10) NOT NULL,
	itemsAdmin int NOT NULL,
	itemsStore int NOT NULL,
	showStock char(2) NOT NULL,
	leyendaStock VARCHAR(255) NOT NULL,
	logo VARCHAR(255),
	CONSTRAINT pk_config PRIMARY KEY (id)
);

-- Estados(32)
CREATE TABLE IF NOT EXISTS estados (
	id_estados int(4) NOT NULL AUTO_INCREMENT,
  	nombre VARCHAR(255) NOT NULL DEFAULT '',
  CONSTRAINT pk_estado PRIMARY KEY (id_estados)
 );

CREATE TABLE IF NOT EXISTS direccion (
	id_dir int AUTO_INCREMENT NOT NULL,
	no_exterior VARCHAR(5) NOT NULL,
	no_interior VARCHAR(5),
	cod_postal int(5) NOT NULL,
	id_estados int(4) NOT NULL,
	colonia VARCHAR(255) NOT NULL,
	calle VARCHAR (255) NOT NULL,
	municipio VARCHAR(255) NOT NULL,
	id_usu int NOT NULL,
	CONSTRAINT pk_direccion PRIMARY KEY (id_dir),
	CONSTRAINT fk_estado FOREIGN KEY(id_estados) REFERENCES estados(id_estados) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insertar Estados(32)
INSERT INTO estados VALUES 
	(1,'Aguascalientes'),
	(2,'Baja California'),
	(3,'Baja California Sur'),
	(4,'Campeche'),
	(5,'Chiapas'),
	(6,'Chihuahua'),
	(7,'Coahuila'),
	(8,'Colima'),
	(9,'Ciudad de México'),
	(10,'Durango'),
	(11,'Estado de México'),
	(12,'Guanajuato'),
	(13,'Guerrero'),
	(14,'Hidalgo'),
	(15,'Jalisco'),
	(16,'Michoacán'),
	(17,'Morelos'),
	(18,'Nayarit'),
	(19,'Nuevo León'),
	(20,'Oaxaca'),
	(21,'Puebla'),
	(22,'Querétaro'),
	(23,'Quintana Roo'),
	(24,'San Luis Potosí'),
	(25,'Sinaloa'),
	(26,'Sonora'),
	(27,'Tabasco'),
	(28,'Tamaulipas'),
	(29,'Tlaxcala'),
	(30,'Veracruz'),
	(31,'Yucatán'),
	(32,'Zacatecas');

-- FK
ALTER TABLE productos ADD CONSTRAINT fk_marcas FOREIGN KEY(id_mar) REFERENCES marcas(id_mar) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE productos ADD CONSTRAINT fk_categorias FOREIGN KEY(id_cat) REFERENCES categorias(id_cat) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE imgP ADD CONSTRAINT fk_imagen FOREIGN KEY(id_prod) REFERENCES productos(id_prod) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE usuarios ADD CONSTRAINT fk_rol FOREIGN KEY(id_rol) REFERENCES rol(id_rol) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE direccion ADD CONSTRAINT fk_DIRusuario FOREIGN KEY(id_usu) REFERENCES usuarios(id_usu) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE pedidos ADD CONSTRAINT fk_usuario FOREIGN KEY(id_usu) REFERENCES usuarios(id_usu) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pedidos ADD CONSTRAINT fk_producto FOREIGN KEY(id_prod) REFERENCES productos(id_prod) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pedidos ADD CONSTRAINT fk_direccion FOREIGN KEY(id_dir) REFERENCES direccion(id_dir) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE cPadre ADD CONSTRAINT fk_padre FOREIGN KEY(id_padre) REFERENCES categorias(id_cat) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE cPadre ADD CONSTRAINT fk_cat FOREIGN KEY(id_cat) REFERENCES categorias(id_cat) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE carrito ADD CONSTRAINT fk_prod FOREIGN KEY(id_prod) REFERENCES productos(id_prod) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE carrito ADD CONSTRAINT fk_user FOREIGN KEY(id_usu) REFERENCES usuarios(id_usu) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE favoritos ADD CONSTRAINT fk_prod_fav FOREIGN KEY(id_prod) REFERENCES productos(id_prod) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE favoritos ADD CONSTRAINT fk_user_fav FOREIGN KEY(id_usu) REFERENCES usuarios(id_usu) ON DELETE CASCADE ON UPDATE CASCADE;

-- FK Status
ALTER TABLE pedidos ADD CONSTRAINT fk_statusPededido FOREIGN KEY(id_statusPed) REFERENCES statusPed(id_statusPed) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE productos ADD CONSTRAINT fk_statusProducto FOREIGN KEY(id_statusProd) REFERENCES statusAll(id_status) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE categorias ADD CONSTRAINT fk_statusCategoria FOREIGN KEY(id_statusCat) REFERENCES statusAll(id_status) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE usuarios ADD CONSTRAINT fk_statusUsuario FOREIGN KEY(id_statusUsu) REFERENCES statusAll(id_status) ON DELETE CASCADE ON UPDATE CASCADE;


-- Insertar datos

INSERT INTO rol VALUES
	(1, 'Admininstrador'),
	(2, 'Cliente');

INSERT INTO statusPed VALUES
	(1, 'Entregado'),
	(2, 'Pendiente'),
	(3, 'En progreso'),
	(4, 'Devuelto');

INSERT INTO statusAll VALUES
	(1, 'Habilitado'),
	(2, 'Deshabilitado');

INSERT INTO usuarios VALUES
	(null, 'YIZA', 'Uribe', 'Ortiz', 'Admin', 'yiza@gmail.com', MD5('yiza'), 1, 'img/predeterminado.png', '2022-03-12', 1),
	(null, 'Usuario', 'X', 'Y', 'usuario', 'usuario@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-03-12', 1),
	(null, 'Usuario2', 'X', 'Y', 'usuario2', 'usuario2@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1),
	(null, 'Usuario3', 'X', 'Y', 'usuario3', 'usuario3@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1),
	(null, 'Usuario4', 'X', 'Y', 'usuario4', 'usuario4@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1),
	(null, 'Usuario5', 'X', 'Y', 'usuario5', 'usuario5@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1),
	(null, 'Usuario6', 'X', 'Y', 'usuario6', 'usuario6@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1),
	(null, 'Usuario7', 'X', 'Y', 'usuario7', 'usuario7@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1),
	(null, 'Usuario8', 'X', 'Y', 'usuario8', 'usuario8@gmail.com', MD5('user'), 2, 'img/predeterminado.png', '2022-07-01', 1);

INSERT INTO direccion VALUES
	(null, '0', '', 54935, 11, 'San Pablo', 'Leandro Valle','Tultitlán', 1);

INSERT INTO categorias VALUES
	(null, 'Accesorios', 'Bienvenido a la categoría de Accesorios, aquí podrás encontrar todo tipo de accesorios para tus dispositivos electrónicos.', 
		'Accesorios', 'Accesorios para dispositivos electrónicos, como Fundas, Audífonos, entre muchos más.', 
		'Fundas, Audífonos, Pop Sockets, USB, etc', 1),
	(null, 'Pantallas', 'En esta categoría encontraras todo tipo de pantallas, ya sean monitores o Smart TV.', 
		'Pantallas', 'Encuentre el Monitor o la Smart TV perfecta para usted.', 
		'Pantallas, Monitores', 1),
	(null, 'Monitores', 'En este apartado encontraras el monitor perfecto para tu PC.', 
		'Monitores', 'Monitores para PCs de marcas como HP, Dell, Lenovo, Acer, MacBook, ASUS y muchas más', 
		'Monitores para PCs', 1);

INSERT INTO cPadre VALUES
	(null, 1, 1),
	(null, 2, 2),
	(null, 3, 2);

INSERT INTO marcas VALUES
	(null, 'Alienware', 'img/marcas/Alienware-Logo.png'),
	(null, 'ASUS', 'img/marcas/asus.png'),
	(null, 'Apple', 'img/marcas/Apple-Logo.jpg'),
	(null, 'LG', 'img/marcas/LG_symbol.png');

INSERT INTO productos VALUES
	(null, 'Teclado', 'Con la última generación de interruptores Cherry MX Red líderes en la industria para un mejor control con una activación rápida y suave. Retroiluminación de color único personalizable por tecla. Perfil delgado para una ergonomía mejorada diseño icónico Alienware de nueva generación. Rollover anti-ghosting/n-key para una mayor precisión en el juego. Construcción de aluminio duradera de la serie 5000 para una robustez y fiabilidad completas. Paso USB integrado con teclas de volumen. Cherry MX Interruptores Rojos; Luz de fondo blanco por llave; Construcción de aluminio serie 5000; teclas de volumen dedicadas; cable 2M trenzado de paso USB integrado.',
	'Teclado', 'Alienware AW310K LED USB Estándar color Negro', 'Clave', 'AW310K', 'SKU',
	4140, 20, 'img/productos/teclado.jpeg', 1, 1, 1),
	(null, 'Apple AirPods Pro A2083 A2084 A2190 Blanco Reacondicionado Apple 4WP22LL/A', 'Resistencia al agua y sudor. Aíslan el ruido del exterior, mejoran la calidad del audio. Tamaño pequeño para poder insertarse en tu oreja.',
	'Apple AirPods Pro A2083 A2084 A2190 Blanco Reacondicionado Apple 4WP22LL/A', 'Apple AirPods Pro A2083 A2084 A2190 Blanco Reacondicionado Apple 4WP22LL/A', 'Apple AirPods Pro A2083 A2084 A2190 Blanco', '4WP22LL/A', 'SKU',
	4199, 20, 'img/productos/airpods.jpeg', 3, 1, 1),
	(null, 'Monitor ASUS 27&quot; IPS 5MS 75HZ FHD', 'ASUS Eye Care garantiza una experiencia visual cómoda. ASUS VZ24EHE tiene un perfil ultra delgado que mide solo 6,5 mm en su punto más delgado. Su diseño sin marco lo hace perfecto para configuraciones de múltiples pantallas casi perfectas que le brindan un grado aún mayor de inmersión. Un panel IPS avanzado de alto rendimiento le brinda amplios ángulos de visión de 178 °. Además, la tecnología ASUS Eye Care garantiza una experiencia visual cómoda.',
	'Monitor ASUS de 27&quot; VZ27EHE', 'Monitor ASUS VZ27EHE de 27 pulgadas IPS 5MS 75HZ FHD FREESYNC HDMI DP VGA', 'Clave', 'VZ27EHE', 'SKU',
	4799, 25, 'img/productos/Monitor ASUS 27 IPS 5MS 75HZ FHD.jpg', 2, 3, 1),
	(null, 'TV LG 4K Ultra HD Smart TV LED', 'Más pantalla, menos bisel un diseño totalmente elegante para que veas las imágenes más puras -Con webOS Smart TV vas a disfrutar de cientos de aplicaciones como YouTube, Disney Plus y Netflix -Conecta un USB o disco duro para disfrutar contenido multimedia en su televisor -Con un sonido envolvente con altos nítidos y diálogos claros -Entradas HDMI para una conexión HD digital total en un solo cable -Con una pantalla LED siempre tendrás la imagen perfecta con un consumo de energía bajo -Disfruta de la televisión digital conectando una antena HD o con algún sistema de cable HD -Ideal para conectarse a Blu-ray o consolas de videojuegos Qué esperas para entrar a nuestra tienda en línea donde encontrarás diversas marcas de pantallas, reproductores DVD, artículos de sonido 3d, bocinas bluetooth, consolas de sonido, soportes para tv y muchas cosas más con entrega a domicilio.',
	'TV LG 4K Ultra HD Smart TV LED 65&quot;', 'TV LG 4K Ultra HD Smart TV LED de 65 pulgadas.', 'Clave', '65UN69558ZU', 'SKU',
	16499, 25, 'img/productos/2lg1-100x100.jpg', 4, 2, 1);

INSERT INTO config VALUES 
	(null, 'YIZA', 'YIZA STORE', 'Utiliza Yiza, Garantiza tu Satisfacción, Minimiza tus Gastos', 'Productos Electrónicos y Digitales',
	'Gael Darko', 'CECyTEM Tultitlán', 'yiza@gmail.com', '4242424242', 20, 10, 'SI', 
	'Stock no disponible', 'img/logo.jpg');