--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: id_operador_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE id_operador_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: tbl_accion; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_accion (
    id_accion integer NOT NULL,
    nombre character(30)
);


--
-- Name: COLUMN tbl_accion.id_accion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_accion.id_accion IS 'Identificador de accion';


--
-- Name: COLUMN tbl_accion.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_accion.nombre IS 'Nombre de la accion';


--
-- Name: tbl_accion_id_accion_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_accion_id_accion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_accion_id_accion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_accion_id_accion_seq OWNED BY tbl_accion.id_accion;


--
-- Name: tbl_auditoria; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_auditoria (
    id_auditoria integer NOT NULL,
    id_operador integer,
    descripcion text,
    hora time without time zone,
    fecha_auditoria date
);


--
-- Name: COLUMN tbl_auditoria.id_auditoria; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.id_auditoria IS 'Identificador de auditoria';


--
-- Name: COLUMN tbl_auditoria.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.id_operador IS 'Identificador del operador';


--
-- Name: COLUMN tbl_auditoria.descripcion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.descripcion IS 'Descripcion de la accion realizada en el sistema';


--
-- Name: COLUMN tbl_auditoria.hora; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.hora IS 'Registro de hora';


--
-- Name: COLUMN tbl_auditoria.fecha_auditoria; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.fecha_auditoria IS 'Fecha de auditoria';


--
-- Name: tbl_auditoria_id_auditoria_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_auditoria_id_auditoria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_auditoria_id_auditoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_auditoria_id_auditoria_seq OWNED BY tbl_auditoria.id_auditoria;


--
-- Name: tbl_autor; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_autor (
    id_autor integer NOT NULL,
    nombre character varying(30),
    apellido character varying(30)
);


--
-- Name: COLUMN tbl_autor.id_autor; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor.id_autor IS 'Identificador del autor';


--
-- Name: COLUMN tbl_autor.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor.nombre IS 'Nombre del autor';


--
-- Name: COLUMN tbl_autor.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor.apellido IS 'Apellido del autor';


--
-- Name: tbl_autor_id_autor_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_autor_id_autor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_autor_id_autor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_autor_id_autor_seq OWNED BY tbl_autor.id_autor;


--
-- Name: tbl_autor_tesis; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_autor_tesis (
    id_autor_tesis integer NOT NULL,
    mension character varying(30),
    nombre character varying(30),
    apellido character varying(30)
);


--
-- Name: COLUMN tbl_autor_tesis.id_autor_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.id_autor_tesis IS 'Identificador de autor de tesis';


--
-- Name: COLUMN tbl_autor_tesis.mension; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.mension IS 'Mension';


--
-- Name: COLUMN tbl_autor_tesis.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.nombre IS 'Nombre del autor';


--
-- Name: COLUMN tbl_autor_tesis.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.apellido IS 'Apellido del autor';


--
-- Name: tbl_autor_tesis_id_autor_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_autor_tesis_id_autor_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_autor_tesis_id_autor_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_autor_tesis_id_autor_tesis_seq OWNED BY tbl_autor_tesis.id_autor_tesis;


--
-- Name: tbl_castigo; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_castigo (
    id_castigo integer NOT NULL,
    castigo character(30)
);


--
-- Name: COLUMN tbl_castigo.id_castigo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_castigo.id_castigo IS 'Identificador del castigo';


--
-- Name: COLUMN tbl_castigo.castigo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_castigo.castigo IS 'Castigo';


--
-- Name: tbl_castigo_id_castigo_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_castigo_id_castigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_castigo_id_castigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_castigo_id_castigo_seq OWNED BY tbl_castigo.id_castigo;


--
-- Name: tbl_denominacion; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_denominacion (
    id_denominacion integer NOT NULL,
    denominacion character(30)
);


--
-- Name: COLUMN tbl_denominacion.id_denominacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_denominacion.id_denominacion IS 'Identificador de denominacion';


--
-- Name: COLUMN tbl_denominacion.denominacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_denominacion.denominacion IS 'Denominacion';


--
-- Name: tbl_denominacion_id_denominacion_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_denominacion_id_denominacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_denominacion_id_denominacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_denominacion_id_denominacion_seq OWNED BY tbl_denominacion.id_denominacion;


--
-- Name: tbl_editorial; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_editorial (
    id_editorial integer NOT NULL,
    nombre character varying(30),
    ciudad character varying(30)
);


--
-- Name: COLUMN tbl_editorial.id_editorial; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_editorial.id_editorial IS 'Identificador de editorial';


--
-- Name: COLUMN tbl_editorial.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_editorial.nombre IS 'Nombre de la editorial';


--
-- Name: COLUMN tbl_editorial.ciudad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_editorial.ciudad IS 'Ciudad de la editorial';


--
-- Name: tbl_editorial_id_editorial_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_editorial_id_editorial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_editorial_id_editorial_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_editorial_id_editorial_seq OWNED BY tbl_editorial.id_editorial;


--
-- Name: tbl_falta; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_falta (
    id_falta integer NOT NULL,
    descripcion_falta character(30)
);


--
-- Name: COLUMN tbl_falta.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_falta.id_falta IS 'Identificador de la falta';


--
-- Name: COLUMN tbl_falta.descripcion_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_falta.descripcion_falta IS 'Descripcion de la falta';


--
-- Name: tbl_falta_id_falta_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_falta_id_falta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_falta_id_falta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_falta_id_falta_seq OWNED BY tbl_falta.id_falta;


--
-- Name: tbl_libros; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_libros (
    id_libro integer NOT NULL,
    id_autor integer,
    id_editorial integer,
    id_materia integer,
    edicion character varying,
    fecha_publicacion date,
    descripcion character varying(60),
    status boolean DEFAULT true
);


--
-- Name: COLUMN tbl_libros.id_libro; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_libro IS 'Identificador del libro';


--
-- Name: COLUMN tbl_libros.id_autor; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_autor IS 'Identificador de autor';


--
-- Name: COLUMN tbl_libros.id_editorial; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_editorial IS 'Identificador de editorial';


--
-- Name: COLUMN tbl_libros.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_materia IS 'Identificador de materia';


--
-- Name: COLUMN tbl_libros.edicion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.edicion IS 'Edicion';


--
-- Name: COLUMN tbl_libros.fecha_publicacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.fecha_publicacion IS 'Fecha de publicacion';


--
-- Name: COLUMN tbl_libros.descripcion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.descripcion IS 'Descripcion del Libro';


--
-- Name: COLUMN tbl_libros.status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.status IS 'Disponibilidad del libro';


--
-- Name: tbl_libros_id_libro_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_libros_id_libro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_libros_id_libro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_libros_id_libro_seq OWNED BY tbl_libros.id_libro;


--
-- Name: tbl_materia; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_materia (
    id_materia integer NOT NULL,
    nombre_materia character varying(30)
);


--
-- Name: TABLE tbl_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE tbl_materia IS '
';


--
-- Name: COLUMN tbl_materia.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_materia.id_materia IS 'Identificador de materia';


--
-- Name: COLUMN tbl_materia.nombre_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_materia.nombre_materia IS 'Nombre de materia';


--
-- Name: tbl_materia_id_materia_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_materia_id_materia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_materia_id_materia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_materia_id_materia_seq OWNED BY tbl_materia.id_materia;


--
-- Name: tbl_material; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_material (
    id_material integer NOT NULL,
    id_tipo integer,
    nombre character varying(30),
    status boolean DEFAULT true
);


--
-- Name: COLUMN tbl_material.id_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.id_material IS 'Identificador de material';


--
-- Name: COLUMN tbl_material.id_tipo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.id_tipo IS 'Identificador de tipo';


--
-- Name: COLUMN tbl_material.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.nombre IS 'Nombre de autor';


--
-- Name: COLUMN tbl_material.status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.status IS 'Disponibilidad de material';


--
-- Name: tbl_material_id_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_material_id_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_material_id_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_material_id_material_seq OWNED BY tbl_material.id_material;


--
-- Name: tbl_novedad_libro; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_novedad_libro (
    id_novedad integer NOT NULL,
    id_falta integer,
    id_penalizacion integer,
    id_prestamo integer,
    fecha_novedad date
);


--
-- Name: COLUMN tbl_novedad_libro.id_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_novedad IS 'Identificador de novedad';


--
-- Name: COLUMN tbl_novedad_libro.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_falta IS 'Identificador de falta';


--
-- Name: COLUMN tbl_novedad_libro.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_penalizacion IS 'Identificador de penalizacion';


--
-- Name: COLUMN tbl_novedad_libro.id_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_prestamo IS 'Identificador de prestamo';


--
-- Name: COLUMN tbl_novedad_libro.fecha_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.fecha_novedad IS 'Fecha de novedad';


--
-- Name: tbl_novedad_libro_id_novedad_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_novedad_libro_id_novedad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_novedad_libro_id_novedad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_novedad_libro_id_novedad_seq OWNED BY tbl_novedad_libro.id_novedad;


--
-- Name: tbl_novedad_material; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_novedad_material (
    id_novedad_material integer NOT NULL,
    id_falta integer,
    id_penalizacion integer,
    id_prestamo_material integer,
    fecha_novedad date
);


--
-- Name: COLUMN tbl_novedad_material.id_novedad_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_novedad_material IS 'Identificador de novedad material';


--
-- Name: COLUMN tbl_novedad_material.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_falta IS 'Identificador de falta';


--
-- Name: COLUMN tbl_novedad_material.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_penalizacion IS 'Identificador de penalizacion';


--
-- Name: COLUMN tbl_novedad_material.id_prestamo_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_prestamo_material IS 'Identificador de prestamo material';


--
-- Name: COLUMN tbl_novedad_material.fecha_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.fecha_novedad IS 'Fecha de novedad';


--
-- Name: tbl_novedad_material_id_novedad_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_novedad_material_id_novedad_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_novedad_material_id_novedad_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_novedad_material_id_novedad_material_seq OWNED BY tbl_novedad_material.id_novedad_material;


--
-- Name: tbl_novedad_tesis; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_novedad_tesis (
    id_novedad_tesis integer NOT NULL,
    id_falta integer,
    id_penalizacion integer,
    id_prestamo_tesis integer,
    fecha_novedad date
);


--
-- Name: COLUMN tbl_novedad_tesis.id_novedad_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_novedad_tesis IS 'Identificador de novedad de tesis';


--
-- Name: COLUMN tbl_novedad_tesis.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_falta IS 'Identificador de falta';


--
-- Name: COLUMN tbl_novedad_tesis.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_penalizacion IS 'Identificador de penalizacion';


--
-- Name: COLUMN tbl_novedad_tesis.id_prestamo_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_prestamo_tesis IS 'Identificador de prestamo de tesis';


--
-- Name: COLUMN tbl_novedad_tesis.fecha_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.fecha_novedad IS 'Fecha de novedad';


--
-- Name: tbl_novedad_tesis_id_novedad_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_novedad_tesis_id_novedad_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_novedad_tesis_id_novedad_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_novedad_tesis_id_novedad_tesis_seq OWNED BY tbl_novedad_tesis.id_novedad_tesis;


--
-- Name: tbl_operador; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_operador (
    id_operador integer DEFAULT nextval('id_operador_seq'::regclass) NOT NULL,
    id_privilegio integer,
    nombre character(30),
    apellido character(30),
    cedula integer,
    password character(50),
    fecha_creacion date,
    fecha_modifica date
);


--
-- Name: COLUMN tbl_operador.id_privilegio; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.id_privilegio IS 'Identificador de Privilegio';


--
-- Name: COLUMN tbl_operador.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.nombre IS 'Nombre del Operador';


--
-- Name: COLUMN tbl_operador.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.apellido IS 'Apellido del Operador';


--
-- Name: COLUMN tbl_operador.cedula; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.cedula IS 'Numero de Cedula';


--
-- Name: COLUMN tbl_operador.password; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.password IS 'Contraseña inicio de sesión';


--
-- Name: COLUMN tbl_operador.fecha_creacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.fecha_creacion IS 'Fecha de creación de registro';


--
-- Name: COLUMN tbl_operador.fecha_modifica; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.fecha_modifica IS 'Ultima modificacion de registro';


--
-- Name: tbl_penalizacion; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_penalizacion (
    id_penalizacion integer NOT NULL,
    id_castigo integer,
    descripcion_penalizacion character(30)
);


--
-- Name: COLUMN tbl_penalizacion.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_penalizacion.id_penalizacion IS 'Identificador de la penalizacion';


--
-- Name: COLUMN tbl_penalizacion.id_castigo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_penalizacion.id_castigo IS 'Identificador del castigo';


--
-- Name: COLUMN tbl_penalizacion.descripcion_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_penalizacion.descripcion_penalizacion IS 'Descripcion de la penalizacion';


--
-- Name: tbl_penalizacion_id_penalizacion_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_penalizacion_id_penalizacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_penalizacion_id_penalizacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_penalizacion_id_penalizacion_seq OWNED BY tbl_penalizacion.id_penalizacion;


--
-- Name: tbl_prestamo_libro; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_prestamo_libro (
    id_prestamo integer NOT NULL,
    id_libro integer,
    id_operador integer,
    id_usuario integer,
    fecha_prestamo date,
    fecha_devolucion date
);


--
-- Name: COLUMN tbl_prestamo_libro.id_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_prestamo IS 'Identificador de prestamo';


--
-- Name: COLUMN tbl_prestamo_libro.id_libro; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_libro IS 'Identificador de libro';


--
-- Name: COLUMN tbl_prestamo_libro.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_operador IS 'Identificador de operador';


--
-- Name: COLUMN tbl_prestamo_libro.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_usuario IS 'Identificador de usuario';


--
-- Name: COLUMN tbl_prestamo_libro.fecha_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.fecha_prestamo IS 'Fecha de prestamo';


--
-- Name: COLUMN tbl_prestamo_libro.fecha_devolucion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.fecha_devolucion IS 'Fecha devolucion';


--
-- Name: tbl_prestamo_libro_id_prestamo_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_prestamo_libro_id_prestamo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_prestamo_libro_id_prestamo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_prestamo_libro_id_prestamo_seq OWNED BY tbl_prestamo_libro.id_prestamo;


--
-- Name: tbl_prestamo_material; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_prestamo_material (
    id_prestamo_material integer NOT NULL,
    id_materia integer,
    id_operador integer,
    id_usuario integer,
    fecha_prestamo date,
    fecha_devolucion date
);


--
-- Name: COLUMN tbl_prestamo_material.id_prestamo_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_prestamo_material IS 'Identificador de prestamo de material';


--
-- Name: COLUMN tbl_prestamo_material.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_materia IS 'Identificador de materia';


--
-- Name: COLUMN tbl_prestamo_material.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_operador IS 'Identificador de operador';


--
-- Name: COLUMN tbl_prestamo_material.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_usuario IS 'Identificador de usuario';


--
-- Name: COLUMN tbl_prestamo_material.fecha_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.fecha_prestamo IS 'Fecha de prestamo';


--
-- Name: COLUMN tbl_prestamo_material.fecha_devolucion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.fecha_devolucion IS 'Fecha devolucion';


--
-- Name: tbl_prestamo_material_id_prestamo_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_prestamo_material_id_prestamo_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_prestamo_material_id_prestamo_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_prestamo_material_id_prestamo_material_seq OWNED BY tbl_prestamo_material.id_prestamo_material;


--
-- Name: tbl_prestamo_tesis; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_prestamo_tesis (
    id_prestamo_tesis integer NOT NULL,
    id_tesis integer,
    id_operador integer,
    id_usuario integer,
    fecha_prestamo date,
    fecha_devolucion date
);


--
-- Name: COLUMN tbl_prestamo_tesis.id_prestamo_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_prestamo_tesis IS 'Identificador de prestamo de tesis';


--
-- Name: COLUMN tbl_prestamo_tesis.id_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_tesis IS 'Identificador de tesis';


--
-- Name: COLUMN tbl_prestamo_tesis.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_operador IS 'Identificador de operador';


--
-- Name: COLUMN tbl_prestamo_tesis.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_usuario IS 'Identificador de usuario';


--
-- Name: COLUMN tbl_prestamo_tesis.fecha_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.fecha_prestamo IS 'Fecha de prestamo';


--
-- Name: COLUMN tbl_prestamo_tesis.fecha_devolucion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.fecha_devolucion IS 'Fecha dev';


--
-- Name: tbl_prestamo_tesis_id_prestamo_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_prestamo_tesis_id_prestamo_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_prestamo_tesis_id_prestamo_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_prestamo_tesis_id_prestamo_tesis_seq OWNED BY tbl_prestamo_tesis.id_prestamo_tesis;


--
-- Name: tbl_privilegios; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_privilegios (
    id_privilegio integer NOT NULL,
    privilegio character varying(20)
);


--
-- Name: COLUMN tbl_privilegios.id_privilegio; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_privilegios.id_privilegio IS 'Identificador de Privilegio';


--
-- Name: COLUMN tbl_privilegios.privilegio; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_privilegios.privilegio IS 'Privilegio Otorgado';


--
-- Name: tbl_privilegios_id_privilegio_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_privilegios_id_privilegio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_privilegios_id_privilegio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_privilegios_id_privilegio_seq OWNED BY tbl_privilegios.id_privilegio;


--
-- Name: tbl_tesis; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_tesis (
    id_tesis integer NOT NULL,
    id_materia integer,
    id_autor_tesis integer,
    titulo character(30),
    fecha_publicacion date,
    mension character varying(200),
    status boolean DEFAULT true
);


--
-- Name: COLUMN tbl_tesis.id_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.id_tesis IS 'Identificador de tesis';


--
-- Name: COLUMN tbl_tesis.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.id_materia IS 'Identificador de materia';


--
-- Name: COLUMN tbl_tesis.id_autor_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.id_autor_tesis IS 'Identificador de autor de tesis';


--
-- Name: COLUMN tbl_tesis.titulo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.titulo IS 'Titulo de tesis';


--
-- Name: COLUMN tbl_tesis.fecha_publicacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.fecha_publicacion IS 'Fecha de publicacion';


--
-- Name: COLUMN tbl_tesis.mension; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.mension IS 'Mension Tesis';


--
-- Name: COLUMN tbl_tesis.status; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.status IS 'Disponibilidad de tesis';


--
-- Name: tbl_tesis_id_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_tesis_id_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_tesis_id_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_tesis_id_tesis_seq OWNED BY tbl_tesis.id_tesis;


--
-- Name: tbl_tipo_material; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_tipo_material (
    id_tipo_material integer NOT NULL,
    descripcion_tipo character varying(30)
);


--
-- Name: COLUMN tbl_tipo_material.id_tipo_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tipo_material.id_tipo_material IS 'Identificador de tipo';


--
-- Name: COLUMN tbl_tipo_material.descripcion_tipo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tipo_material.descripcion_tipo IS 'Descripcion';


--
-- Name: tbl_tipo_material_id_tipo_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_tipo_material_id_tipo_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_tipo_material_id_tipo_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_tipo_material_id_tipo_material_seq OWNED BY tbl_tipo_material.id_tipo_material;


--
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tbl_usuario; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_usuario (
    id_usuario integer DEFAULT nextval('usuario_id_seq'::regclass) NOT NULL,
    id_denominacion integer,
    nombre character(30),
    apellido character(30),
    fecha_creacion date,
    fecha_modifica date,
    cedula character varying(10) NOT NULL
);


--
-- Name: COLUMN tbl_usuario.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.id_usuario IS 'Identificador de usuario';


--
-- Name: COLUMN tbl_usuario.id_denominacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.id_denominacion IS 'Identificador de denominación';


--
-- Name: COLUMN tbl_usuario.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.nombre IS 'Nombre del usuario';


--
-- Name: COLUMN tbl_usuario.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.apellido IS 'Apellido del usuario';


--
-- Name: COLUMN tbl_usuario.fecha_creacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.fecha_creacion IS 'Fecha de creacion del registro';


--
-- Name: COLUMN tbl_usuario.fecha_modifica; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.fecha_modifica IS 'Fecha de modificacion del registro';


--
-- Name: COLUMN tbl_usuario.cedula; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.cedula IS 'Cedula Usuario';


--
-- Name: id_accion; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_accion ALTER COLUMN id_accion SET DEFAULT nextval('tbl_accion_id_accion_seq'::regclass);


--
-- Name: id_auditoria; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_auditoria ALTER COLUMN id_auditoria SET DEFAULT nextval('tbl_auditoria_id_auditoria_seq'::regclass);


--
-- Name: id_autor; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_autor ALTER COLUMN id_autor SET DEFAULT nextval('tbl_autor_id_autor_seq'::regclass);


--
-- Name: id_autor_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_autor_tesis ALTER COLUMN id_autor_tesis SET DEFAULT nextval('tbl_autor_tesis_id_autor_tesis_seq'::regclass);


--
-- Name: id_castigo; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_castigo ALTER COLUMN id_castigo SET DEFAULT nextval('tbl_castigo_id_castigo_seq'::regclass);


--
-- Name: id_denominacion; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_denominacion ALTER COLUMN id_denominacion SET DEFAULT nextval('tbl_denominacion_id_denominacion_seq'::regclass);


--
-- Name: id_editorial; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_editorial ALTER COLUMN id_editorial SET DEFAULT nextval('tbl_editorial_id_editorial_seq'::regclass);


--
-- Name: id_falta; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_falta ALTER COLUMN id_falta SET DEFAULT nextval('tbl_falta_id_falta_seq'::regclass);


--
-- Name: id_libro; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros ALTER COLUMN id_libro SET DEFAULT nextval('tbl_libros_id_libro_seq'::regclass);


--
-- Name: id_materia; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_materia ALTER COLUMN id_materia SET DEFAULT nextval('tbl_materia_id_materia_seq'::regclass);


--
-- Name: id_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_material ALTER COLUMN id_material SET DEFAULT nextval('tbl_material_id_material_seq'::regclass);


--
-- Name: id_novedad; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro ALTER COLUMN id_novedad SET DEFAULT nextval('tbl_novedad_libro_id_novedad_seq'::regclass);


--
-- Name: id_novedad_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material ALTER COLUMN id_novedad_material SET DEFAULT nextval('tbl_novedad_material_id_novedad_material_seq'::regclass);


--
-- Name: id_novedad_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis ALTER COLUMN id_novedad_tesis SET DEFAULT nextval('tbl_novedad_tesis_id_novedad_tesis_seq'::regclass);


--
-- Name: id_penalizacion; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_penalizacion ALTER COLUMN id_penalizacion SET DEFAULT nextval('tbl_penalizacion_id_penalizacion_seq'::regclass);


--
-- Name: id_prestamo; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro ALTER COLUMN id_prestamo SET DEFAULT nextval('tbl_prestamo_libro_id_prestamo_seq'::regclass);


--
-- Name: id_prestamo_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material ALTER COLUMN id_prestamo_material SET DEFAULT nextval('tbl_prestamo_material_id_prestamo_material_seq'::regclass);


--
-- Name: id_prestamo_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis ALTER COLUMN id_prestamo_tesis SET DEFAULT nextval('tbl_prestamo_tesis_id_prestamo_tesis_seq'::regclass);


--
-- Name: id_privilegio; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_privilegios ALTER COLUMN id_privilegio SET DEFAULT nextval('tbl_privilegios_id_privilegio_seq'::regclass);


--
-- Name: id_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tesis ALTER COLUMN id_tesis SET DEFAULT nextval('tbl_tesis_id_tesis_seq'::regclass);


--
-- Name: id_tipo_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tipo_material ALTER COLUMN id_tipo_material SET DEFAULT nextval('tbl_tipo_material_id_tipo_material_seq'::regclass);


--
-- Name: id_operador_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('id_operador_seq', 4, true);


--
-- Data for Name: tbl_accion; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_accion (id_accion, nombre) FROM stdin;
\.


--
-- Name: tbl_accion_id_accion_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_accion_id_accion_seq', 2, true);


--
-- Data for Name: tbl_auditoria; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_auditoria (id_auditoria, id_operador, descripcion, hora, fecha_auditoria) FROM stdin;
52	1	Inicio sesión	10:04:00	2015-04-21
53	1	Cierre sesión	10:04:00	2015-04-21
54	1	Inicio sesión	10:04:00	2015-04-21
55	1	Cierre sesión	10:04:00	2015-04-21
56	2	Inicio sesión	10:04:00	2015-04-21
57	2	Cierre sesión	10:04:00	2015-04-21
58	2	Inicio sesión	10:04:00	2015-04-21
59	2	Cierre sesión	10:04:00	2015-04-21
60	2	Inicio sesión	10:04:00	2015-04-21
61	2	Cierre sesión	10:04:00	2015-04-21
62	1	Inicio sesión	10:04:00	2015-04-21
63	1	Cierre sesión	10:04:00	2015-04-21
64	2	Inicio sesión	10:04:00	2015-04-21
65	2	Cierre sesión	11:04:00	2015-04-21
66	1	Inicio sesión	11:04:00	2015-04-21
67	1	Inicio sesión	13:04:00	2015-04-21
68	1	Inicio sesión	15:04:00	2015-04-21
69	1	Inicio sesión	16:04:00	2015-04-21
70	1	Cierre sesión	16:04:00	2015-04-21
71	1	Inicio sesión	16:04:00	2015-04-21
72	1	Inicio sesión	11:04:00	2015-04-23
73	1	Actualizó material. datos: (nombre=>AREVALO CESAR ANTONIO ARAQUE,id=>1)	11:04:00	2015-04-23
74	1	Inicio sesión	09:04:00	2015-04-24
75	1	Inicio sesión	09:04:00	2015-04-24
76	1	Inicio sesión	11:04:00	2015-04-24
77	1	Inicio sesión	13:04:00	2015-04-24
78	1	Inicio sesión	15:04:00	2015-04-24
79	1	Inicio sesión	08:04:00	2015-04-27
80	1	Registro Operador. datos: (Nombre=>jean carlos ,id=>)	08:04:00	2015-04-27
81	1	Actualizó operador. datos: (Nombre=>CESAR ANTONIO                 ,id=>2)	10:04:00	2015-04-27
82	1	Actualizó operador. datos: (Nombre=>JEAN CARLOS                   ,id=>3)	10:04:00	2015-04-27
83	1	Actualizó usuario. datos: (Nombre=>CESAR                         ,id=>1)	10:04:00	2015-04-27
84	1	Actualizó usuario. datos: (Nombre=>CESAR augusto,id=>1)	10:04:00	2015-04-27
85	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-27
86	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-27
87	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-27
88	1	Inicio sesión	11:04:00	2015-04-27
89	1	Registro Usuario. datos: (Nombre=>pedro,id=>)	12:04:00	2015-04-27
90	1	Eliminó registro. datos: (tabla=>tbl_libros,campo=>id_libro,valor=>2)	12:04:00	2015-04-27
91	1	Eliminó registro. datos: (tabla=>tbl_usuario,campo=>id_usuario,valor=>2)	12:04:00	2015-04-27
92	1	Eliminó registro. datos: (tabla=>tbl_libros,campo=>id_libro,valor=>3)	12:04:00	2015-04-27
93	1	Eliminó registro. datos: (tabla=>tbl_operador,campo=>id_operador,valor=>3)	12:04:00	2015-04-27
94	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	12:04:00	2015-04-27
95	1	Registro Usuario. datos: (Nombre=>armando jose,id=>)	12:04:00	2015-04-27
96	1	Actualizó usuario. datos: (Nombre=>ARMANDO JOSE                  ,id=>3)	12:04:00	2015-04-27
97	1	Actualizó usuario. datos: (Nombre=>ARMANDO JOSE                  ,id=>3)	12:04:00	2015-04-27
98	1	Actualizó usuario. datos: (Nombre=>ARMANDO JOSE                  ,id=>3)	12:04:00	2015-04-27
99	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	13:04:00	2015-04-27
100	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	13:04:00	2015-04-27
101	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	13:04:00	2015-04-27
102	1	Registro Operador. datos: (Nombre=>luis,id=>)	13:04:00	2015-04-27
103	1	Inicio sesión	10:04:00	2015-04-29
104	1	Cierre sesión	10:04:00	2015-04-29
105	1	Inicio sesión	10:04:00	2015-04-29
106	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
107	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
108	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
109	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
110	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
111	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
112	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	10:04:00	2015-04-29
113	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	11:04:00	2015-04-29
114	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	11:04:00	2015-04-29
115	1	Actualizó usuario. datos: (Nombre=>CESAR AUGUSTO                 ,id=>1)	11:04:00	2015-04-29
116	1	Inicio sesión	09:05:00	2015-05-05
117	1	Actualizó operador. datos: (Nombre=>CESAR ANTONIO                 ,id=>2)	09:05:00	2015-05-05
118	1	Inicio sesión	10:05:00	2015-05-05
119	1	Actualizó operador. datos: (Nombre=>CESAR ANTONIO                 ,id=>2)	10:05:00	2015-05-05
120	1	Inicio sesión	10:05:00	2015-05-05
121	1	Inicio sesión	11:05:00	2015-05-05
122	1	Inicio sesión	13:05:00	2015-05-05
123	1	Inicio sesión	14:05:00	2015-05-05
124	1	Actualizó tesis. datos: (titulo=>Firmas Espectrales Agricolas  ,id=>1)	15:05:00	2015-05-05
125	1	Inicio sesión	15:05:00	2015-05-05
126	1	Inicio sesión	07:05:00	2015-05-08
127	1	Inicio sesión	12:05:00	2015-05-08
\.


--
-- Name: tbl_auditoria_id_auditoria_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_auditoria_id_auditoria_seq', 127, true);


--
-- Data for Name: tbl_autor; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_autor (id_autor, nombre, apellido) FROM stdin;
1	AREVALO	ARAQUE
3	julio	araque
4	andres	araque
5	cesar	araque
6	gerardo	araque
7	luis 	alfredo
8	ramon	araque
9	alveiro	araque
10	albert	rivas
11	alberto	rivas
12	ana	araque
\.


--
-- Name: tbl_autor_id_autor_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_autor_id_autor_seq', 12, true);


--
-- Data for Name: tbl_autor_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_autor_tesis (id_autor_tesis, mension, nombre, apellido) FROM stdin;
1	PUBLICACION	CESAR	ARAQUE
\.


--
-- Name: tbl_autor_tesis_id_autor_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_autor_tesis_id_autor_tesis_seq', 1, true);


--
-- Data for Name: tbl_castigo; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_castigo (id_castigo, castigo) FROM stdin;
\.


--
-- Name: tbl_castigo_id_castigo_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_castigo_id_castigo_seq', 1, false);


--
-- Data for Name: tbl_denominacion; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_denominacion (id_denominacion, denominacion) FROM stdin;
1	ESTUDIANTE                    
2	DOCENTE                       
3	INVITADO                      
\.


--
-- Name: tbl_denominacion_id_denominacion_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_denominacion_id_denominacion_seq', 3, true);


--
-- Data for Name: tbl_editorial; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_editorial (id_editorial, nombre, ciudad) FROM stdin;
1	PROGRAMALO	APURE
2	edit	achaguas
3	apureña	san fernando
4	mecanica	mantecal
5	code	apure
\.


--
-- Name: tbl_editorial_id_editorial_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_editorial_id_editorial_seq', 5, true);


--
-- Data for Name: tbl_falta; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_falta (id_falta, descripcion_falta) FROM stdin;
\.


--
-- Name: tbl_falta_id_falta_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_falta_id_falta_seq', 1, false);


--
-- Data for Name: tbl_libros; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_libros (id_libro, id_autor, id_editorial, id_materia, edicion, fecha_publicacion, descripcion, status) FROM stdin;
28	10	4	5	1era	2015-03-11	conexiones a bases de datos con php	t
29	11	5	1	1era	2015-03-10	codificalo	t
30	9	5	9	3era	2011-04-01	Bases de datos maria db	t
\.


--
-- Name: tbl_libros_id_libro_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_libros_id_libro_seq', 30, true);


--
-- Data for Name: tbl_materia; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_materia (id_materia, nombre_materia) FROM stdin;
1	PROGRAMACION
2	bases de datos
3	algoritmica
4	SQL
5	PHP
6	django
7	html5
8	reparacion
9	mariadb
\.


--
-- Name: tbl_materia_id_materia_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_materia_id_materia_seq', 9, true);


--
-- Data for Name: tbl_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_material (id_material, id_tipo, nombre, status) FROM stdin;
1	1	AREVALO CESAR ANTONIO ARAQUE	t
\.


--
-- Name: tbl_material_id_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_material_id_material_seq', 3, true);


--
-- Data for Name: tbl_novedad_libro; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_novedad_libro (id_novedad, id_falta, id_penalizacion, id_prestamo, fecha_novedad) FROM stdin;
\.


--
-- Name: tbl_novedad_libro_id_novedad_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_novedad_libro_id_novedad_seq', 1, false);


--
-- Data for Name: tbl_novedad_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_novedad_material (id_novedad_material, id_falta, id_penalizacion, id_prestamo_material, fecha_novedad) FROM stdin;
\.


--
-- Name: tbl_novedad_material_id_novedad_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_novedad_material_id_novedad_material_seq', 1, false);


--
-- Data for Name: tbl_novedad_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_novedad_tesis (id_novedad_tesis, id_falta, id_penalizacion, id_prestamo_tesis, fecha_novedad) FROM stdin;
\.


--
-- Name: tbl_novedad_tesis_id_novedad_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_novedad_tesis_id_novedad_tesis_seq', 1, false);


--
-- Data for Name: tbl_operador; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_operador (id_operador, id_privilegio, nombre, apellido, cedula, password, fecha_creacion, fecha_modifica) FROM stdin;
1	1	AREVALO                       	ARAQUE                        	21005501	202cb962ac59075b964b07152d234b70                  	\N	\N
4	2	luis                          	diaz                          	6938094	123                                               	2015-04-27	\N
2	2	CESAR ANTONIO                 	VIZCAYA                       	20724884	202cb962ac59075b964b07152d234b70                  	2015-03-08	2015-05-05
\.


--
-- Data for Name: tbl_penalizacion; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_penalizacion (id_penalizacion, id_castigo, descripcion_penalizacion) FROM stdin;
\.


--
-- Name: tbl_penalizacion_id_penalizacion_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_penalizacion_id_penalizacion_seq', 1, false);


--
-- Data for Name: tbl_prestamo_libro; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_prestamo_libro (id_prestamo, id_libro, id_operador, id_usuario, fecha_prestamo, fecha_devolucion) FROM stdin;
\.


--
-- Name: tbl_prestamo_libro_id_prestamo_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_prestamo_libro_id_prestamo_seq', 1, false);


--
-- Data for Name: tbl_prestamo_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_prestamo_material (id_prestamo_material, id_materia, id_operador, id_usuario, fecha_prestamo, fecha_devolucion) FROM stdin;
\.


--
-- Name: tbl_prestamo_material_id_prestamo_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_prestamo_material_id_prestamo_material_seq', 1, false);


--
-- Data for Name: tbl_prestamo_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_prestamo_tesis (id_prestamo_tesis, id_tesis, id_operador, id_usuario, fecha_prestamo, fecha_devolucion) FROM stdin;
\.


--
-- Name: tbl_prestamo_tesis_id_prestamo_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_prestamo_tesis_id_prestamo_tesis_seq', 1, false);


--
-- Data for Name: tbl_privilegios; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_privilegios (id_privilegio, privilegio) FROM stdin;
1	ADMINISTRADOR
2	BIBLIOTECARIO
\.


--
-- Name: tbl_privilegios_id_privilegio_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_privilegios_id_privilegio_seq', 2, true);


--
-- Data for Name: tbl_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_tesis (id_tesis, id_materia, id_autor_tesis, titulo, fecha_publicacion, mension, status) FROM stdin;
1	1	1	Firmas Espectrales Agricolas  	2015-03-17	Publicacion	t
\.


--
-- Name: tbl_tesis_id_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_tesis_id_tesis_seq', 1, true);


--
-- Data for Name: tbl_tipo_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_tipo_material (id_tipo_material, descripcion_tipo) FROM stdin;
1	RECICLAR
2	guardar
3	peso
4	mover
\.


--
-- Name: tbl_tipo_material_id_tipo_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_tipo_material_id_tipo_material_seq', 4, true);


--
-- Data for Name: tbl_usuario; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_usuario (id_usuario, id_denominacion, nombre, apellido, fecha_creacion, fecha_modifica, cedula) FROM stdin;
3	1	ARMANDO JOSE                  	REVERON OCACIONES             	2015-04-27	2015-04-27	21005501
1	2	CESAR AUGUSTO                 	ARAQUE VIZCAYA                	2015-04-27	2015-04-29	20724884
\.


--
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('usuario_id_seq', 3, true);


--
-- Name: tbl_accion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_accion
    ADD CONSTRAINT tbl_accion_pkey PRIMARY KEY (id_accion);


--
-- Name: tbl_auditoria_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_auditoria
    ADD CONSTRAINT tbl_auditoria_pkey PRIMARY KEY (id_auditoria);


--
-- Name: tbl_autor_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_autor
    ADD CONSTRAINT tbl_autor_pkey PRIMARY KEY (id_autor);


--
-- Name: tbl_autor_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_autor_tesis
    ADD CONSTRAINT tbl_autor_tesis_pkey PRIMARY KEY (id_autor_tesis);


--
-- Name: tbl_castigo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_castigo
    ADD CONSTRAINT tbl_castigo_pkey PRIMARY KEY (id_castigo);


--
-- Name: tbl_denominacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_denominacion
    ADD CONSTRAINT tbl_denominacion_pkey PRIMARY KEY (id_denominacion);


--
-- Name: tbl_editorial_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_editorial
    ADD CONSTRAINT tbl_editorial_pkey PRIMARY KEY (id_editorial);


--
-- Name: tbl_falta_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_falta
    ADD CONSTRAINT tbl_falta_pkey PRIMARY KEY (id_falta);


--
-- Name: tbl_libros_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_pkey PRIMARY KEY (id_libro);


--
-- Name: tbl_materia_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_materia
    ADD CONSTRAINT tbl_materia_pkey PRIMARY KEY (id_materia);


--
-- Name: tbl_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_material
    ADD CONSTRAINT tbl_material_pkey PRIMARY KEY (id_material);


--
-- Name: tbl_novedad_libro_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_pkey PRIMARY KEY (id_novedad);


--
-- Name: tbl_novedad_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_pkey PRIMARY KEY (id_novedad_material);


--
-- Name: tbl_novedad_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_pkey PRIMARY KEY (id_novedad_tesis);


--
-- Name: tbl_operador_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_operador
    ADD CONSTRAINT tbl_operador_pkey PRIMARY KEY (id_operador);


--
-- Name: tbl_penalizacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_penalizacion
    ADD CONSTRAINT tbl_penalizacion_pkey PRIMARY KEY (id_penalizacion);


--
-- Name: tbl_prestamo_libro_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_pkey PRIMARY KEY (id_prestamo);


--
-- Name: tbl_prestamo_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_pkey PRIMARY KEY (id_prestamo_material);


--
-- Name: tbl_prestamo_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_pkey PRIMARY KEY (id_prestamo_tesis);


--
-- Name: tbl_privilegios_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_privilegios
    ADD CONSTRAINT tbl_privilegios_pkey PRIMARY KEY (id_privilegio);


--
-- Name: tbl_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_tesis
    ADD CONSTRAINT tbl_tesis_pkey PRIMARY KEY (id_tesis);


--
-- Name: tbl_tipo_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_tipo_material
    ADD CONSTRAINT tbl_tipo_material_pkey PRIMARY KEY (id_tipo_material);


--
-- Name: tbl_usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_usuario
    ADD CONSTRAINT tbl_usuario_pkey PRIMARY KEY (id_usuario);


--
-- Name: tbl_auditoria_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_auditoria
    ADD CONSTRAINT tbl_auditoria_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- Name: tbl_libros_id_autor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_id_autor_fkey FOREIGN KEY (id_autor) REFERENCES tbl_autor(id_autor);


--
-- Name: tbl_libros_id_editorial_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_id_editorial_fkey FOREIGN KEY (id_editorial) REFERENCES tbl_editorial(id_editorial);


--
-- Name: tbl_libros_id_materia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_id_materia_fkey FOREIGN KEY (id_materia) REFERENCES tbl_materia(id_materia);


--
-- Name: tbl_material_id_tipo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_material
    ADD CONSTRAINT tbl_material_id_tipo_fkey FOREIGN KEY (id_tipo) REFERENCES tbl_tipo_material(id_tipo_material);


--
-- Name: tbl_novedad_libro_id_falta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_id_falta_fkey FOREIGN KEY (id_falta) REFERENCES tbl_falta(id_falta);


--
-- Name: tbl_novedad_libro_id_penalizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_id_penalizacion_fkey FOREIGN KEY (id_penalizacion) REFERENCES tbl_penalizacion(id_penalizacion);


--
-- Name: tbl_novedad_libro_id_prestamo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_id_prestamo_fkey FOREIGN KEY (id_prestamo) REFERENCES tbl_prestamo_libro(id_prestamo);


--
-- Name: tbl_novedad_material_id_falta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_id_falta_fkey FOREIGN KEY (id_falta) REFERENCES tbl_falta(id_falta);


--
-- Name: tbl_novedad_material_id_penalizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_id_penalizacion_fkey FOREIGN KEY (id_penalizacion) REFERENCES tbl_penalizacion(id_penalizacion);


--
-- Name: tbl_novedad_material_id_prestamo_material_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_id_prestamo_material_fkey FOREIGN KEY (id_prestamo_material) REFERENCES tbl_prestamo_material(id_prestamo_material);


--
-- Name: tbl_novedad_tesis_id_falta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_id_falta_fkey FOREIGN KEY (id_falta) REFERENCES tbl_falta(id_falta);


--
-- Name: tbl_novedad_tesis_id_penalizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_id_penalizacion_fkey FOREIGN KEY (id_penalizacion) REFERENCES tbl_penalizacion(id_penalizacion);


--
-- Name: tbl_novedad_tesis_id_prestamo_tesis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_id_prestamo_tesis_fkey FOREIGN KEY (id_prestamo_tesis) REFERENCES tbl_prestamo_tesis(id_prestamo_tesis);


--
-- Name: tbl_operador_id_privilegio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_operador
    ADD CONSTRAINT tbl_operador_id_privilegio_fkey FOREIGN KEY (id_privilegio) REFERENCES tbl_privilegios(id_privilegio);


--
-- Name: tbl_penalizacion_id_castigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_penalizacion
    ADD CONSTRAINT tbl_penalizacion_id_castigo_fkey FOREIGN KEY (id_castigo) REFERENCES tbl_castigo(id_castigo);


--
-- Name: tbl_prestamo_libro_id_libro_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_id_libro_fkey FOREIGN KEY (id_libro) REFERENCES tbl_libros(id_libro);


--
-- Name: tbl_prestamo_libro_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- Name: tbl_prestamo_libro_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);


--
-- Name: tbl_prestamo_material_id_materia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_id_materia_fkey FOREIGN KEY (id_materia) REFERENCES tbl_materia(id_materia);


--
-- Name: tbl_prestamo_material_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- Name: tbl_prestamo_material_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);


--
-- Name: tbl_prestamo_tesis_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- Name: tbl_prestamo_tesis_id_tesis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_id_tesis_fkey FOREIGN KEY (id_tesis) REFERENCES tbl_tesis(id_tesis);


--
-- Name: tbl_prestamo_tesis_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);


--
-- Name: tbl_tesis_id_autor_tesis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tesis
    ADD CONSTRAINT tbl_tesis_id_autor_tesis_fkey FOREIGN KEY (id_autor_tesis) REFERENCES tbl_autor_tesis(id_autor_tesis);


--
-- Name: tbl_tesis_id_materia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tesis
    ADD CONSTRAINT tbl_tesis_id_materia_fkey FOREIGN KEY (id_materia) REFERENCES tbl_materia(id_materia);


--
-- Name: tbl_usuario_id_denominacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_usuario
    ADD CONSTRAINT tbl_usuario_id_denominacion_fkey FOREIGN KEY (id_denominacion) REFERENCES tbl_denominacion(id_denominacion);


--
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

