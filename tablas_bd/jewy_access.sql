-- Database: jewy_acces
	
/*----Crear tabla CLIENTE*/

CREATE TABLE cliente(
  	ID_CLIENTE		 SERIAL  		PRIMARY KEY, /*les cambie el tipo de dato para q se genere solo, y el nombre tmbn para mas corto, jeje*/
	NOMBRE  		 VARCHAR(50)	NOT NULL CHECK (NOMBRE <> ''), /*mejor lo deje como 50 pq me dio flojera pensar en hacer la tabla nombre*/
	PRIMER_APELLIDO  VARCHAR(30)	NOT NULL CHECK (PRIMER_APELLIDO <> ''), /*aumente el tamaño de varchar por apellidos mas largos, varchar se ajusta*/
	SEGUNDO_APELLIDO VARCHAR(30)	NULL,
	TELEFONO		 VARCHAR(20)	NULL 
);

/*select table_name,column_name,udt_name,character_maximum_length,is_nullable 
  from information_schema.columns 
  where table_name = 'venta'; PARA PODER VER CADA TABLA*/


/*----Crear tabla PEDIDO*/
CREATE TABLE pedido(
  	ID_PEDIDO		SERIAL  		PRIMARY KEY, 
	FECHA_PEDIDO  	TIMESTAMP		DEFAULT current_timestamp, /*hice esto timestamp para q por default se le ponga fecha y hora del sistema*/
	FECHA_ENTREGA	DATE			NOT NULL,
	HORA_ENTREGA	TIME			NOT NULL,
	PRECIO			DECIMAL(6,2)	NOT NULL, /*lo hice decimal con 2 decimales*/
	PUNTO_ENTREGA 	VARCHAR(30) 	NULL, /*lo hice mas largo y tmbn calle y colonia y codigo postal*/
	CALLE			VARCHAR(40) 	NULL,
	NO_CASA			VARCHAR(7)		NULL,
	COLONIA			VARCHAR(40)		NULL,
	ESTADO			VARCHAR(30)		NULL,
	PAIS			VARCHAR(30) 	NULL,
	CODIGO_POSTAL 	VARCHAR(7)		NULL,
	REFERENCIA		VARCHAR(30)		NULL,
	VENDIDO			BIT, /*hice vendido un bool que acepta 1 o 0*/
	ID_CLIENTE		INT, /*declaramos primero el tipo dato de la lalve foranea, no le ponemos not null para cuando se elimina*/
	
	CONSTRAINT FK_CLIENTE FOREIGN KEY(ID_CLIENTE) REFERENCES cliente(ID_CLIENTE) 
	ON DELETE SET NULL, /*nos permite definir llave foranea y lo que se hace en demas tablas si se elimina*/
	
	CONSTRAINT MOD_CLIENTE FOREIGN KEY(ID_CLIENTE) REFERENCES cliente(ID_CLIENTE) 
	ON UPDATE CASCADE
);

/*---Crear tabla PRODUCTO*/
CREATE TABLE producto(
  	ID_PRODUCTO		SERIAL  		PRIMARY KEY,
	NOMBRE  		VARCHAR(50)	 	NOT NULL CHECK (NOMBRE <> ''),
	CATEGORIA		VARCHAR(1) 		NULL, /*la categoria es solo indicar si es hombre o mujer (H/M)*/
	PRECIO 			DECIMAL(6,2) 	NOT NULL,
	EXISTENCIA	 	INT  			NOT NULL /*hice existencia int pq YOLO y pq numeric puede ser decimal pero como vean*/
);

/*Crear tabla para guardar los PEDIDOS que requieran cierto PRODUCTO*/
CREATE TABLE pedido_contiene(
  	ID_PEDIDO		INT,
	ID_PRODUCTO		INT, 
	CANTIDAD		INT, /*cantidad de productos que se pidieron*/
	PRIMARY KEY(ID_PEDIDO, ID_PRODUCTO), /*declaramos la llave primaria compuesta*/
	
	CONSTRAINT FK_PED_CONT FOREIGN KEY(ID_PEDIDO) REFERENCES pedido(ID_PEDIDO) 
	ON DELETE CASCADE, /*como la llave primaria es conmpuesta, podemos referenciar cada campo como clave extera*/
	
	CONSTRAINT FK_PROD_CONT FOREIGN KEY(ID_PRODUCTO) REFERENCES producto(ID_PRODUCTO) 
	ON DELETE CASCADE,
	
	CONSTRAINT MOD_PED_CONT FOREIGN KEY(ID_PEDIDO) REFERENCES pedido(ID_PEDIDO) 
	ON UPDATE CASCADE, /*como la llave primaria es conmpuesta, podemos referenciar cada campo como clave extera*/
	
	CONSTRAINT MOD_PROD_CONT FOREIGN KEY(ID_PRODUCTO) REFERENCES producto(ID_PRODUCTO) 
	ON UPDATE CASCADE
	
);

/*---Crear tabla MATERIAL*/
CREATE TABLE material(
  	ID_MATERIAL		SERIAL  		PRIMARY KEY,
	NOMBRE  		VARCHAR(50)	 	NOT NULL CHECK (NOMBRE <> ''),
	PROVEEDOR		VARCHAR(50) 	NULL,
	PRECIO 			DECIMAL(6,2) 	NOT NULL,
	EXISTENCIA	 	INT  			NOT NULL
);

CREATE TABLE producto_hecho_con(
  	ID_PRODUCTO		INT,
	ID_MATERIAL		INT, 
	PRIMARY KEY(ID_PRODUCTO, ID_MATERIAL), /*declaramos la llave primaria compuesta*/
	
	CONSTRAINT FK_PROD_HECHO FOREIGN KEY(ID_PRODUCTO) REFERENCES producto(ID_PRODUCTO) 
	ON DELETE CASCADE,  /* NUEVO!!!! aqui ponemos delete cascade para q se elimine registro si se elimina un material)*/
	
	CONSTRAINT FK_MAT_HECHO FOREIGN KEY(ID_MATERIAL) REFERENCES material(ID_MATERIAL) 
	ON DELETE CASCADE, 
	
	CONSTRAINT MOD_PROD_HECHO FOREIGN KEY(ID_PRODUCTO) REFERENCES producto(ID_PRODUCTO) 
	ON UPDATE CASCADE,  /* NUEVO!!!! aqui ponemos delete cascade para q se elimine registro si se elimina un material)*/
	
	CONSTRAINT MOD_MAT_HECHO FOREIGN KEY(ID_MATERIAL) REFERENCES material(ID_MATERIAL) 
	ON UPDATE CASCADE 
);

/*----Crear tabla VENTA*/
CREATE TABLE venta(
  	ID_PEDIDO		INT  			PRIMARY KEY, 
	FECHA_PEDIDO  	TIMESTAMP,
	FECHA_ENTREGA	DATE			NOT NULL,
	HORA_ENTREGA	TIME			NOT NULL,
	PRECIO			DECIMAL(6,2)	NOT NULL, /*lo hice decimal con 2 decimales*/
	PUNTO_ENTREGA 	VARCHAR(30) 	NULL, /*lo hice mas largo y tmbn calle y colonia y codigo postal*/
	CALLE			VARCHAR(40) 	NULL,
	NO_CASA			VARCHAR(7)		NULL,
	COLONIA			VARCHAR(40)		NULL,
	ESTADO			VARCHAR(30)		NULL,
	PAIS			VARCHAR(30) 	NULL,
	CODIGO_POSTAL 	VARCHAR(7)		NULL,
	REFERENCIA		VARCHAR(50)		NULL,
	VENDIDO			BIT, 
	ID_CLIENTE		INT, 
	
	CONSTRAINT FK_CLIENTE FOREIGN KEY(ID_CLIENTE) REFERENCES cliente(ID_CLIENTE) 
	ON DELETE SET NULL, /*nos permite definir llave foranea y lo que se hace en demas tablas si se elimina*/
	
	CONSTRAINT MOD_CLIENTE FOREIGN KEY(ID_CLIENTE) REFERENCES cliente(ID_CLIENTE) 
	ON UPDATE CASCADE 
);

/*------TRIGGER PARA PASAR PEDIDO VENDIDO A TABLA VENTAS-----------*/
CREATE FUNCTION SP_VENDIDO() RETURNS TRIGGER
AS
$$
BEGIN
	insert into venta values (new.id_pedido,new.fecha_pedido,
				  new.fecha_entrega,new.hora_entrega,
				  new.precio,new.punto_entrega,new.calle,
				  new.no_casa,new.colonia,new.estado,
				  new.pais,new.codigo_postal,
				  new.referencia,new.vendido,new.id_cliente);

RETURN new;
END
$$ LANGUAGE PLPGSQL;

CREATE TRIGGER TR_VENDIDO AFTER UPDATE OF VENDIDO ON pedido
FOR EACH ROW
EXECUTE PROCEDURE SP_VENDIDO();

/*-----TRIGGER PARA ELIMINAR PEDIDO VENDIDO DE TABLA PEDIDOS-------*/

CREATE FUNCTION SP_ELIMINARPED() RETURNS TRIGGER
AS
$$
BEGIN
DELETE FROM PEDIDO
WHERE VENDIDO = '1';
RETURN new;
END
$$
LANGUAGE plpgsql;

CREATE TRIGGER TR_ELIMINARPED AFTER INSERT ON VENTA
FOR EACH ROW
EXECUTE PROCEDURE SP_ELIMINARPED();



/*INSERT INTO material(NOMBRE, PROVEEDOR, PRECIO, EXISTENCIA) VALUES
					('Cadena 30cm', 'Accesorios Higareda', 2.50, 6), 
					('Cierre dorado', 'Accesorios Higareda', 0.80, 6),
					('Colgije Fantasma', 'Accesorios Martha', 2.50, 6),
					('Colgije Illuminati', 'Accesorios Martha', 2.50, 6),
					('Perla sintética', 'Pulseras Antonio Garza', 20.00, 6);

INSERT INTO material(NOMBRE, PROVEEDOR, PRECIO, EXISTENCIA) VALUES
					('Hilo Plastico 30cm', 'Accesorios Higareda', 12.50, 6);
					
select * from material;

INSERT INTO producto (NOMBRE, CATEGORIA, PRECIO, EXISTENCIA) VALUES 
					 ('Collar Perlas', 'M', 60.00, 6),
					 ('Collar Fantasma', 'M', 60.00, 6), 
					 ('Collar Illuminati', 'H', 60.00, 6);
					 
select * from producto;

INSERT INTO producto_hecho_con(ID_PRODUCTO, ID_MATERIAL) VALUES 
							  (1, 6), (1, 2), (1, 5), (2, 1), (2, 3), (3, 1), (3, 4);
							  
select * from producto_hecho_con;

INSERT INTO cliente (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, TELEFONO) VALUES
	 	 	('Valeria', 'Gonzalez', 'Segura', '3531040025'),
			('Diego Tristán', 'Dominguez', 'Dueñas', '3338453198'),
			('Sergio', 'Quintero', 'Quiroz', '3313048101');
			
select * from cliente;

INSERT INTO pedido (FECHA_ENTREGA, HORA_ENTREGA, PRECIO, PUNTO_ENTREGA, CALLE, NO_CASA, COLONIA, ESTADO, 
					PAIS, CODIGO_POSTAL,REFERENCIA, ID_CLIENTE) VALUES
					('2022/10/28', '13:59', 99.50, 'Centro', null, null, null, null, null, null, null, 1),
					('2022/10/29', '13:59', 99.50, 'Centro', null, null, null, null, null, null, null, 2),
					('2022/10/30', '13:59', 99.50, 'Centro', null, null, null, null, null, null, null, 3);

select * from pedido;

INSERT INTO pedido_contiene (ID_PEDIDO, ID_PRODUCTO, CANTIDAD) VALUES 
							(1, 1, 2), (1, 2, 1), (2, 3, 1), (3, 3, 3);
							
select * from pedido_contiene;*/

drop trigger tr_vendido on pedido;
drop function sp_vendido;