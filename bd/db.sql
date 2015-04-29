--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.13
-- Dumped by pg_dump version 9.1.13
-- Started on 2015-04-27 13:41:10 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 207 (class 3079 OID 11645)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2136 (class 0 OID 0)
-- Dependencies: 207
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 161 (class 1259 OID 65270)
-- Dependencies: 6
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
-- TOC entry 162 (class 1259 OID 65272)
-- Dependencies: 6
-- Name: tbl_accion; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_accion (
    id_accion integer NOT NULL,
    nombre character(30)
);


--
-- TOC entry 2137 (class 0 OID 0)
-- Dependencies: 162
-- Name: COLUMN tbl_accion.id_accion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_accion.id_accion IS 'Identificador de accion';


--
-- TOC entry 2138 (class 0 OID 0)
-- Dependencies: 162
-- Name: COLUMN tbl_accion.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_accion.nombre IS 'Nombre de la accion';


--
-- TOC entry 163 (class 1259 OID 65275)
-- Dependencies: 162 6
-- Name: tbl_accion_id_accion_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_accion_id_accion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2139 (class 0 OID 0)
-- Dependencies: 163
-- Name: tbl_accion_id_accion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_accion_id_accion_seq OWNED BY tbl_accion.id_accion;


--
-- TOC entry 164 (class 1259 OID 65277)
-- Dependencies: 6
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
-- TOC entry 2140 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN tbl_auditoria.id_auditoria; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.id_auditoria IS 'Identificador de auditoria';


--
-- TOC entry 2141 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN tbl_auditoria.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.id_operador IS 'Identificador del operador';


--
-- TOC entry 2142 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN tbl_auditoria.descripcion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.descripcion IS 'Descripcion de la accion realizada en el sistema';


--
-- TOC entry 2143 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN tbl_auditoria.hora; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.hora IS 'Registro de hora';


--
-- TOC entry 2144 (class 0 OID 0)
-- Dependencies: 164
-- Name: COLUMN tbl_auditoria.fecha_auditoria; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_auditoria.fecha_auditoria IS 'Fecha de auditoria';


--
-- TOC entry 165 (class 1259 OID 65280)
-- Dependencies: 6 164
-- Name: tbl_auditoria_id_auditoria_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_auditoria_id_auditoria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2145 (class 0 OID 0)
-- Dependencies: 165
-- Name: tbl_auditoria_id_auditoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_auditoria_id_auditoria_seq OWNED BY tbl_auditoria.id_auditoria;


--
-- TOC entry 166 (class 1259 OID 65282)
-- Dependencies: 6
-- Name: tbl_autor; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_autor (
    id_autor integer NOT NULL,
    nombre character varying(30),
    apellido character varying(30)
);


--
-- TOC entry 2146 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN tbl_autor.id_autor; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor.id_autor IS 'Identificador del autor';


--
-- TOC entry 2147 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN tbl_autor.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor.nombre IS 'Nombre del autor';


--
-- TOC entry 2148 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN tbl_autor.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor.apellido IS 'Apellido del autor';


--
-- TOC entry 167 (class 1259 OID 65285)
-- Dependencies: 166 6
-- Name: tbl_autor_id_autor_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_autor_id_autor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2149 (class 0 OID 0)
-- Dependencies: 167
-- Name: tbl_autor_id_autor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_autor_id_autor_seq OWNED BY tbl_autor.id_autor;


--
-- TOC entry 168 (class 1259 OID 65287)
-- Dependencies: 6
-- Name: tbl_autor_tesis; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_autor_tesis (
    id_autor_tesis integer NOT NULL,
    mension character varying(30),
    nombre character varying(30),
    apellido character varying(30)
);


--
-- TOC entry 2150 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN tbl_autor_tesis.id_autor_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.id_autor_tesis IS 'Identificador de autor de tesis';


--
-- TOC entry 2151 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN tbl_autor_tesis.mension; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.mension IS 'Mension';


--
-- TOC entry 2152 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN tbl_autor_tesis.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.nombre IS 'Nombre del autor';


--
-- TOC entry 2153 (class 0 OID 0)
-- Dependencies: 168
-- Name: COLUMN tbl_autor_tesis.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_autor_tesis.apellido IS 'Apellido del autor';


--
-- TOC entry 169 (class 1259 OID 65290)
-- Dependencies: 168 6
-- Name: tbl_autor_tesis_id_autor_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_autor_tesis_id_autor_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2154 (class 0 OID 0)
-- Dependencies: 169
-- Name: tbl_autor_tesis_id_autor_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_autor_tesis_id_autor_tesis_seq OWNED BY tbl_autor_tesis.id_autor_tesis;


--
-- TOC entry 170 (class 1259 OID 65292)
-- Dependencies: 6
-- Name: tbl_castigo; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_castigo (
    id_castigo integer NOT NULL,
    castigo character(30)
);


--
-- TOC entry 2155 (class 0 OID 0)
-- Dependencies: 170
-- Name: COLUMN tbl_castigo.id_castigo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_castigo.id_castigo IS 'Identificador del castigo';


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 170
-- Name: COLUMN tbl_castigo.castigo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_castigo.castigo IS 'Castigo';


--
-- TOC entry 171 (class 1259 OID 65295)
-- Dependencies: 170 6
-- Name: tbl_castigo_id_castigo_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_castigo_id_castigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 171
-- Name: tbl_castigo_id_castigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_castigo_id_castigo_seq OWNED BY tbl_castigo.id_castigo;


--
-- TOC entry 172 (class 1259 OID 65297)
-- Dependencies: 6
-- Name: tbl_denominacion; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_denominacion (
    id_denominacion integer NOT NULL,
    denominacion character(30)
);


--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN tbl_denominacion.id_denominacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_denominacion.id_denominacion IS 'Identificador de denominacion';


--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 172
-- Name: COLUMN tbl_denominacion.denominacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_denominacion.denominacion IS 'Denominacion';


--
-- TOC entry 173 (class 1259 OID 65300)
-- Dependencies: 172 6
-- Name: tbl_denominacion_id_denominacion_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_denominacion_id_denominacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 173
-- Name: tbl_denominacion_id_denominacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_denominacion_id_denominacion_seq OWNED BY tbl_denominacion.id_denominacion;


--
-- TOC entry 174 (class 1259 OID 65302)
-- Dependencies: 6
-- Name: tbl_editorial; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_editorial (
    id_editorial integer NOT NULL,
    nombre character varying(30),
    ciudad character varying(30)
);


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 174
-- Name: COLUMN tbl_editorial.id_editorial; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_editorial.id_editorial IS 'Identificador de editorial';


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 174
-- Name: COLUMN tbl_editorial.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_editorial.nombre IS 'Nombre de la editorial';


--
-- TOC entry 2163 (class 0 OID 0)
-- Dependencies: 174
-- Name: COLUMN tbl_editorial.ciudad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_editorial.ciudad IS 'Ciudad de la editorial';


--
-- TOC entry 175 (class 1259 OID 65305)
-- Dependencies: 174 6
-- Name: tbl_editorial_id_editorial_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_editorial_id_editorial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2164 (class 0 OID 0)
-- Dependencies: 175
-- Name: tbl_editorial_id_editorial_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_editorial_id_editorial_seq OWNED BY tbl_editorial.id_editorial;


--
-- TOC entry 176 (class 1259 OID 65307)
-- Dependencies: 6
-- Name: tbl_falta; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_falta (
    id_falta integer NOT NULL,
    descripcion_falta character(30)
);


--
-- TOC entry 2165 (class 0 OID 0)
-- Dependencies: 176
-- Name: COLUMN tbl_falta.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_falta.id_falta IS 'Identificador de la falta';


--
-- TOC entry 2166 (class 0 OID 0)
-- Dependencies: 176
-- Name: COLUMN tbl_falta.descripcion_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_falta.descripcion_falta IS 'Descripcion de la falta';


--
-- TOC entry 177 (class 1259 OID 65310)
-- Dependencies: 6 176
-- Name: tbl_falta_id_falta_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_falta_id_falta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2167 (class 0 OID 0)
-- Dependencies: 177
-- Name: tbl_falta_id_falta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_falta_id_falta_seq OWNED BY tbl_falta.id_falta;


--
-- TOC entry 178 (class 1259 OID 65312)
-- Dependencies: 6
-- Name: tbl_libros; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_libros (
    id_libro integer NOT NULL,
    id_autor integer,
    id_editorial integer,
    id_materia integer,
    edicion character varying,
    fecha_publicacion date,
    descripcion character varying(60)
);


--
-- TOC entry 2168 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.id_libro; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_libro IS 'Identificador del libro';


--
-- TOC entry 2169 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.id_autor; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_autor IS 'Identificador de autor';


--
-- TOC entry 2170 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.id_editorial; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_editorial IS 'Identificador de editorial';


--
-- TOC entry 2171 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.id_materia IS 'Identificador de materia';


--
-- TOC entry 2172 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.edicion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.edicion IS 'Edicion';


--
-- TOC entry 2173 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.fecha_publicacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.fecha_publicacion IS 'Fecha de publicacion';


--
-- TOC entry 2174 (class 0 OID 0)
-- Dependencies: 178
-- Name: COLUMN tbl_libros.descripcion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_libros.descripcion IS 'Descripcion del Libro';


--
-- TOC entry 179 (class 1259 OID 65315)
-- Dependencies: 178 6
-- Name: tbl_libros_id_libro_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_libros_id_libro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2175 (class 0 OID 0)
-- Dependencies: 179
-- Name: tbl_libros_id_libro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_libros_id_libro_seq OWNED BY tbl_libros.id_libro;


--
-- TOC entry 180 (class 1259 OID 65317)
-- Dependencies: 6
-- Name: tbl_materia; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_materia (
    id_materia integer NOT NULL,
    nombre_materia character varying(30)
);


--
-- TOC entry 2176 (class 0 OID 0)
-- Dependencies: 180
-- Name: TABLE tbl_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON TABLE tbl_materia IS '
';


--
-- TOC entry 2177 (class 0 OID 0)
-- Dependencies: 180
-- Name: COLUMN tbl_materia.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_materia.id_materia IS 'Identificador de materia';


--
-- TOC entry 2178 (class 0 OID 0)
-- Dependencies: 180
-- Name: COLUMN tbl_materia.nombre_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_materia.nombre_materia IS 'Nombre de materia';


--
-- TOC entry 181 (class 1259 OID 65320)
-- Dependencies: 6 180
-- Name: tbl_materia_id_materia_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_materia_id_materia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2179 (class 0 OID 0)
-- Dependencies: 181
-- Name: tbl_materia_id_materia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_materia_id_materia_seq OWNED BY tbl_materia.id_materia;


--
-- TOC entry 182 (class 1259 OID 65322)
-- Dependencies: 6
-- Name: tbl_material; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_material (
    id_material integer NOT NULL,
    id_tipo integer,
    nombre character varying(30)
);


--
-- TOC entry 2180 (class 0 OID 0)
-- Dependencies: 182
-- Name: COLUMN tbl_material.id_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.id_material IS 'Identificador de material';


--
-- TOC entry 2181 (class 0 OID 0)
-- Dependencies: 182
-- Name: COLUMN tbl_material.id_tipo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.id_tipo IS 'Identificador de tipo';


--
-- TOC entry 2182 (class 0 OID 0)
-- Dependencies: 182
-- Name: COLUMN tbl_material.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_material.nombre IS 'Nombre de autor';


--
-- TOC entry 183 (class 1259 OID 65325)
-- Dependencies: 6 182
-- Name: tbl_material_id_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_material_id_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2183 (class 0 OID 0)
-- Dependencies: 183
-- Name: tbl_material_id_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_material_id_material_seq OWNED BY tbl_material.id_material;


--
-- TOC entry 184 (class 1259 OID 65327)
-- Dependencies: 6
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
-- TOC entry 2184 (class 0 OID 0)
-- Dependencies: 184
-- Name: COLUMN tbl_novedad_libro.id_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_novedad IS 'Identificador de novedad';


--
-- TOC entry 2185 (class 0 OID 0)
-- Dependencies: 184
-- Name: COLUMN tbl_novedad_libro.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_falta IS 'Identificador de falta';


--
-- TOC entry 2186 (class 0 OID 0)
-- Dependencies: 184
-- Name: COLUMN tbl_novedad_libro.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_penalizacion IS 'Identificador de penalizacion';


--
-- TOC entry 2187 (class 0 OID 0)
-- Dependencies: 184
-- Name: COLUMN tbl_novedad_libro.id_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.id_prestamo IS 'Identificador de prestamo';


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 184
-- Name: COLUMN tbl_novedad_libro.fecha_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_libro.fecha_novedad IS 'Fecha de novedad';


--
-- TOC entry 185 (class 1259 OID 65330)
-- Dependencies: 6 184
-- Name: tbl_novedad_libro_id_novedad_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_novedad_libro_id_novedad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 185
-- Name: tbl_novedad_libro_id_novedad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_novedad_libro_id_novedad_seq OWNED BY tbl_novedad_libro.id_novedad;


--
-- TOC entry 186 (class 1259 OID 65332)
-- Dependencies: 6
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
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 186
-- Name: COLUMN tbl_novedad_material.id_novedad_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_novedad_material IS 'Identificador de novedad material';


--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 186
-- Name: COLUMN tbl_novedad_material.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_falta IS 'Identificador de falta';


--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 186
-- Name: COLUMN tbl_novedad_material.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_penalizacion IS 'Identificador de penalizacion';


--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 186
-- Name: COLUMN tbl_novedad_material.id_prestamo_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.id_prestamo_material IS 'Identificador de prestamo material';


--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 186
-- Name: COLUMN tbl_novedad_material.fecha_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_material.fecha_novedad IS 'Fecha de novedad';


--
-- TOC entry 187 (class 1259 OID 65335)
-- Dependencies: 186 6
-- Name: tbl_novedad_material_id_novedad_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_novedad_material_id_novedad_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2195 (class 0 OID 0)
-- Dependencies: 187
-- Name: tbl_novedad_material_id_novedad_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_novedad_material_id_novedad_material_seq OWNED BY tbl_novedad_material.id_novedad_material;


--
-- TOC entry 188 (class 1259 OID 65337)
-- Dependencies: 6
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
-- TOC entry 2196 (class 0 OID 0)
-- Dependencies: 188
-- Name: COLUMN tbl_novedad_tesis.id_novedad_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_novedad_tesis IS 'Identificador de novedad de tesis';


--
-- TOC entry 2197 (class 0 OID 0)
-- Dependencies: 188
-- Name: COLUMN tbl_novedad_tesis.id_falta; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_falta IS 'Identificador de falta';


--
-- TOC entry 2198 (class 0 OID 0)
-- Dependencies: 188
-- Name: COLUMN tbl_novedad_tesis.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_penalizacion IS 'Identificador de penalizacion';


--
-- TOC entry 2199 (class 0 OID 0)
-- Dependencies: 188
-- Name: COLUMN tbl_novedad_tesis.id_prestamo_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.id_prestamo_tesis IS 'Identificador de prestamo de tesis';


--
-- TOC entry 2200 (class 0 OID 0)
-- Dependencies: 188
-- Name: COLUMN tbl_novedad_tesis.fecha_novedad; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_novedad_tesis.fecha_novedad IS 'Fecha de novedad';


--
-- TOC entry 189 (class 1259 OID 65340)
-- Dependencies: 6 188
-- Name: tbl_novedad_tesis_id_novedad_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_novedad_tesis_id_novedad_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2201 (class 0 OID 0)
-- Dependencies: 189
-- Name: tbl_novedad_tesis_id_novedad_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_novedad_tesis_id_novedad_tesis_seq OWNED BY tbl_novedad_tesis.id_novedad_tesis;


--
-- TOC entry 190 (class 1259 OID 65342)
-- Dependencies: 1899 6
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
-- TOC entry 2202 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.id_privilegio; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.id_privilegio IS 'Identificador de Privilegio';


--
-- TOC entry 2203 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.nombre IS 'Nombre del Operador';


--
-- TOC entry 2204 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.apellido IS 'Apellido del Operador';


--
-- TOC entry 2205 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.cedula; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.cedula IS 'Numero de Cedula';


--
-- TOC entry 2206 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.password; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.password IS 'Contraseña inicio de sesión';


--
-- TOC entry 2207 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.fecha_creacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.fecha_creacion IS 'Fecha de creación de registro';


--
-- TOC entry 2208 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN tbl_operador.fecha_modifica; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_operador.fecha_modifica IS 'Ultima modificacion de registro';


--
-- TOC entry 191 (class 1259 OID 65346)
-- Dependencies: 6
-- Name: tbl_penalizacion; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_penalizacion (
    id_penalizacion integer NOT NULL,
    id_castigo integer,
    descripcion_penalizacion character(30)
);


--
-- TOC entry 2209 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN tbl_penalizacion.id_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_penalizacion.id_penalizacion IS 'Identificador de la penalizacion';


--
-- TOC entry 2210 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN tbl_penalizacion.id_castigo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_penalizacion.id_castigo IS 'Identificador del castigo';


--
-- TOC entry 2211 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN tbl_penalizacion.descripcion_penalizacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_penalizacion.descripcion_penalizacion IS 'Descripcion de la penalizacion';


--
-- TOC entry 192 (class 1259 OID 65349)
-- Dependencies: 191 6
-- Name: tbl_penalizacion_id_penalizacion_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_penalizacion_id_penalizacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2212 (class 0 OID 0)
-- Dependencies: 192
-- Name: tbl_penalizacion_id_penalizacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_penalizacion_id_penalizacion_seq OWNED BY tbl_penalizacion.id_penalizacion;


--
-- TOC entry 193 (class 1259 OID 65351)
-- Dependencies: 6
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
-- TOC entry 2213 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN tbl_prestamo_libro.id_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_prestamo IS 'Identificador de prestamo';


--
-- TOC entry 2214 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN tbl_prestamo_libro.id_libro; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_libro IS 'Identificador de libro';


--
-- TOC entry 2215 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN tbl_prestamo_libro.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_operador IS 'Identificador de operador';


--
-- TOC entry 2216 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN tbl_prestamo_libro.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.id_usuario IS 'Identificador de usuario';


--
-- TOC entry 2217 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN tbl_prestamo_libro.fecha_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.fecha_prestamo IS 'Fecha de prestamo';


--
-- TOC entry 2218 (class 0 OID 0)
-- Dependencies: 193
-- Name: COLUMN tbl_prestamo_libro.fecha_devolucion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_libro.fecha_devolucion IS 'Fecha devolucion';


--
-- TOC entry 194 (class 1259 OID 65354)
-- Dependencies: 6 193
-- Name: tbl_prestamo_libro_id_prestamo_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_prestamo_libro_id_prestamo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2219 (class 0 OID 0)
-- Dependencies: 194
-- Name: tbl_prestamo_libro_id_prestamo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_prestamo_libro_id_prestamo_seq OWNED BY tbl_prestamo_libro.id_prestamo;


--
-- TOC entry 195 (class 1259 OID 65356)
-- Dependencies: 6
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
-- TOC entry 2220 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tbl_prestamo_material.id_prestamo_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_prestamo_material IS 'Identificador de prestamo de material';


--
-- TOC entry 2221 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tbl_prestamo_material.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_materia IS 'Identificador de materia';


--
-- TOC entry 2222 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tbl_prestamo_material.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_operador IS 'Identificador de operador';


--
-- TOC entry 2223 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tbl_prestamo_material.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.id_usuario IS 'Identificador de usuario';


--
-- TOC entry 2224 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tbl_prestamo_material.fecha_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.fecha_prestamo IS 'Fecha de prestamo';


--
-- TOC entry 2225 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tbl_prestamo_material.fecha_devolucion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_material.fecha_devolucion IS 'Fecha devolucion';


--
-- TOC entry 196 (class 1259 OID 65359)
-- Dependencies: 195 6
-- Name: tbl_prestamo_material_id_prestamo_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_prestamo_material_id_prestamo_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2226 (class 0 OID 0)
-- Dependencies: 196
-- Name: tbl_prestamo_material_id_prestamo_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_prestamo_material_id_prestamo_material_seq OWNED BY tbl_prestamo_material.id_prestamo_material;


--
-- TOC entry 197 (class 1259 OID 65361)
-- Dependencies: 6
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
-- TOC entry 2227 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN tbl_prestamo_tesis.id_prestamo_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_prestamo_tesis IS 'Identificador de prestamo de tesis';


--
-- TOC entry 2228 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN tbl_prestamo_tesis.id_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_tesis IS 'Identificador de tesis';


--
-- TOC entry 2229 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN tbl_prestamo_tesis.id_operador; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_operador IS 'Identificador de operador';


--
-- TOC entry 2230 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN tbl_prestamo_tesis.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.id_usuario IS 'Identificador de usuario';


--
-- TOC entry 2231 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN tbl_prestamo_tesis.fecha_prestamo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.fecha_prestamo IS 'Fecha de prestamo';


--
-- TOC entry 2232 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN tbl_prestamo_tesis.fecha_devolucion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_prestamo_tesis.fecha_devolucion IS 'Fecha dev';


--
-- TOC entry 198 (class 1259 OID 65364)
-- Dependencies: 6 197
-- Name: tbl_prestamo_tesis_id_prestamo_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_prestamo_tesis_id_prestamo_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2233 (class 0 OID 0)
-- Dependencies: 198
-- Name: tbl_prestamo_tesis_id_prestamo_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_prestamo_tesis_id_prestamo_tesis_seq OWNED BY tbl_prestamo_tesis.id_prestamo_tesis;


--
-- TOC entry 199 (class 1259 OID 65366)
-- Dependencies: 6
-- Name: tbl_privilegios; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_privilegios (
    id_privilegio integer NOT NULL,
    privilegio character varying(20)
);


--
-- TOC entry 2234 (class 0 OID 0)
-- Dependencies: 199
-- Name: COLUMN tbl_privilegios.id_privilegio; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_privilegios.id_privilegio IS 'Identificador de Privilegio';


--
-- TOC entry 2235 (class 0 OID 0)
-- Dependencies: 199
-- Name: COLUMN tbl_privilegios.privilegio; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_privilegios.privilegio IS 'Privilegio Otorgado';


--
-- TOC entry 200 (class 1259 OID 65369)
-- Dependencies: 199 6
-- Name: tbl_privilegios_id_privilegio_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_privilegios_id_privilegio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2236 (class 0 OID 0)
-- Dependencies: 200
-- Name: tbl_privilegios_id_privilegio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_privilegios_id_privilegio_seq OWNED BY tbl_privilegios.id_privilegio;


--
-- TOC entry 201 (class 1259 OID 65371)
-- Dependencies: 6
-- Name: tbl_tesis; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_tesis (
    id_tesis integer NOT NULL,
    id_materia integer,
    id_autor_tesis integer,
    titulo character(30),
    fecha_publicacion date
);


--
-- TOC entry 2237 (class 0 OID 0)
-- Dependencies: 201
-- Name: COLUMN tbl_tesis.id_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.id_tesis IS 'Identificador de tesis';


--
-- TOC entry 2238 (class 0 OID 0)
-- Dependencies: 201
-- Name: COLUMN tbl_tesis.id_materia; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.id_materia IS 'Identificador de materia';


--
-- TOC entry 2239 (class 0 OID 0)
-- Dependencies: 201
-- Name: COLUMN tbl_tesis.id_autor_tesis; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.id_autor_tesis IS 'Identificador de autor de tesis';


--
-- TOC entry 2240 (class 0 OID 0)
-- Dependencies: 201
-- Name: COLUMN tbl_tesis.titulo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.titulo IS 'Titulo de tesis';


--
-- TOC entry 2241 (class 0 OID 0)
-- Dependencies: 201
-- Name: COLUMN tbl_tesis.fecha_publicacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tesis.fecha_publicacion IS 'Fecha de publicacion';


--
-- TOC entry 202 (class 1259 OID 65374)
-- Dependencies: 6 201
-- Name: tbl_tesis_id_tesis_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_tesis_id_tesis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2242 (class 0 OID 0)
-- Dependencies: 202
-- Name: tbl_tesis_id_tesis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_tesis_id_tesis_seq OWNED BY tbl_tesis.id_tesis;


--
-- TOC entry 203 (class 1259 OID 65376)
-- Dependencies: 6
-- Name: tbl_tipo_material; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tbl_tipo_material (
    id_tipo_material integer NOT NULL,
    descripcion_tipo character varying(30)
);


--
-- TOC entry 2243 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN tbl_tipo_material.id_tipo_material; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tipo_material.id_tipo_material IS 'Identificador de tipo';


--
-- TOC entry 2244 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN tbl_tipo_material.descripcion_tipo; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_tipo_material.descripcion_tipo IS 'Descripcion';


--
-- TOC entry 204 (class 1259 OID 65379)
-- Dependencies: 6 203
-- Name: tbl_tipo_material_id_tipo_material_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tbl_tipo_material_id_tipo_material_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2245 (class 0 OID 0)
-- Dependencies: 204
-- Name: tbl_tipo_material_id_tipo_material_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tbl_tipo_material_id_tipo_material_seq OWNED BY tbl_tipo_material.id_tipo_material;


--
-- TOC entry 206 (class 1259 OID 73551)
-- Dependencies: 6
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 205 (class 1259 OID 65381)
-- Dependencies: 1907 6
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
-- TOC entry 2246 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.id_usuario; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.id_usuario IS 'Identificador de usuario';


--
-- TOC entry 2247 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.id_denominacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.id_denominacion IS 'Identificador de denominación';


--
-- TOC entry 2248 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.nombre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.nombre IS 'Nombre del usuario';


--
-- TOC entry 2249 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.apellido; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.apellido IS 'Apellido del usuario';


--
-- TOC entry 2250 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.fecha_creacion; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.fecha_creacion IS 'Fecha de creacion del registro';


--
-- TOC entry 2251 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.fecha_modifica; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.fecha_modifica IS 'Fecha de modificacion del registro';


--
-- TOC entry 2252 (class 0 OID 0)
-- Dependencies: 205
-- Name: COLUMN tbl_usuario.cedula; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN tbl_usuario.cedula IS 'Cedula Usuario';


--
-- TOC entry 1885 (class 2604 OID 65384)
-- Dependencies: 163 162
-- Name: id_accion; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_accion ALTER COLUMN id_accion SET DEFAULT nextval('tbl_accion_id_accion_seq'::regclass);


--
-- TOC entry 1886 (class 2604 OID 65385)
-- Dependencies: 165 164
-- Name: id_auditoria; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_auditoria ALTER COLUMN id_auditoria SET DEFAULT nextval('tbl_auditoria_id_auditoria_seq'::regclass);


--
-- TOC entry 1887 (class 2604 OID 65386)
-- Dependencies: 167 166
-- Name: id_autor; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_autor ALTER COLUMN id_autor SET DEFAULT nextval('tbl_autor_id_autor_seq'::regclass);


--
-- TOC entry 1888 (class 2604 OID 65387)
-- Dependencies: 169 168
-- Name: id_autor_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_autor_tesis ALTER COLUMN id_autor_tesis SET DEFAULT nextval('tbl_autor_tesis_id_autor_tesis_seq'::regclass);


--
-- TOC entry 1889 (class 2604 OID 65388)
-- Dependencies: 171 170
-- Name: id_castigo; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_castigo ALTER COLUMN id_castigo SET DEFAULT nextval('tbl_castigo_id_castigo_seq'::regclass);


--
-- TOC entry 1890 (class 2604 OID 65389)
-- Dependencies: 173 172
-- Name: id_denominacion; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_denominacion ALTER COLUMN id_denominacion SET DEFAULT nextval('tbl_denominacion_id_denominacion_seq'::regclass);


--
-- TOC entry 1891 (class 2604 OID 65390)
-- Dependencies: 175 174
-- Name: id_editorial; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_editorial ALTER COLUMN id_editorial SET DEFAULT nextval('tbl_editorial_id_editorial_seq'::regclass);


--
-- TOC entry 1892 (class 2604 OID 65391)
-- Dependencies: 177 176
-- Name: id_falta; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_falta ALTER COLUMN id_falta SET DEFAULT nextval('tbl_falta_id_falta_seq'::regclass);


--
-- TOC entry 1893 (class 2604 OID 65392)
-- Dependencies: 179 178
-- Name: id_libro; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros ALTER COLUMN id_libro SET DEFAULT nextval('tbl_libros_id_libro_seq'::regclass);


--
-- TOC entry 1894 (class 2604 OID 65393)
-- Dependencies: 181 180
-- Name: id_materia; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_materia ALTER COLUMN id_materia SET DEFAULT nextval('tbl_materia_id_materia_seq'::regclass);


--
-- TOC entry 1895 (class 2604 OID 65394)
-- Dependencies: 183 182
-- Name: id_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_material ALTER COLUMN id_material SET DEFAULT nextval('tbl_material_id_material_seq'::regclass);


--
-- TOC entry 1896 (class 2604 OID 65395)
-- Dependencies: 185 184
-- Name: id_novedad; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro ALTER COLUMN id_novedad SET DEFAULT nextval('tbl_novedad_libro_id_novedad_seq'::regclass);


--
-- TOC entry 1897 (class 2604 OID 65396)
-- Dependencies: 187 186
-- Name: id_novedad_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material ALTER COLUMN id_novedad_material SET DEFAULT nextval('tbl_novedad_material_id_novedad_material_seq'::regclass);


--
-- TOC entry 1898 (class 2604 OID 65397)
-- Dependencies: 189 188
-- Name: id_novedad_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis ALTER COLUMN id_novedad_tesis SET DEFAULT nextval('tbl_novedad_tesis_id_novedad_tesis_seq'::regclass);


--
-- TOC entry 1900 (class 2604 OID 65398)
-- Dependencies: 192 191
-- Name: id_penalizacion; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_penalizacion ALTER COLUMN id_penalizacion SET DEFAULT nextval('tbl_penalizacion_id_penalizacion_seq'::regclass);


--
-- TOC entry 1901 (class 2604 OID 65399)
-- Dependencies: 194 193
-- Name: id_prestamo; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro ALTER COLUMN id_prestamo SET DEFAULT nextval('tbl_prestamo_libro_id_prestamo_seq'::regclass);


--
-- TOC entry 1902 (class 2604 OID 65400)
-- Dependencies: 196 195
-- Name: id_prestamo_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material ALTER COLUMN id_prestamo_material SET DEFAULT nextval('tbl_prestamo_material_id_prestamo_material_seq'::regclass);


--
-- TOC entry 1903 (class 2604 OID 65401)
-- Dependencies: 198 197
-- Name: id_prestamo_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis ALTER COLUMN id_prestamo_tesis SET DEFAULT nextval('tbl_prestamo_tesis_id_prestamo_tesis_seq'::regclass);


--
-- TOC entry 1904 (class 2604 OID 65402)
-- Dependencies: 200 199
-- Name: id_privilegio; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_privilegios ALTER COLUMN id_privilegio SET DEFAULT nextval('tbl_privilegios_id_privilegio_seq'::regclass);


--
-- TOC entry 1905 (class 2604 OID 65403)
-- Dependencies: 202 201
-- Name: id_tesis; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tesis ALTER COLUMN id_tesis SET DEFAULT nextval('tbl_tesis_id_tesis_seq'::regclass);


--
-- TOC entry 1906 (class 2604 OID 65404)
-- Dependencies: 204 203
-- Name: id_tipo_material; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tipo_material ALTER COLUMN id_tipo_material SET DEFAULT nextval('tbl_tipo_material_id_tipo_material_seq'::regclass);


--
-- TOC entry 2253 (class 0 OID 0)
-- Dependencies: 161
-- Name: id_operador_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('id_operador_seq', 4, true);


--
-- TOC entry 2084 (class 0 OID 65272)
-- Dependencies: 162 2129
-- Data for Name: tbl_accion; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_accion (id_accion, nombre) FROM stdin;
\.


--
-- TOC entry 2254 (class 0 OID 0)
-- Dependencies: 163
-- Name: tbl_accion_id_accion_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_accion_id_accion_seq', 2, true);


--
-- TOC entry 2086 (class 0 OID 65277)
-- Dependencies: 164 2129
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
\.


--
-- TOC entry 2255 (class 0 OID 0)
-- Dependencies: 165
-- Name: tbl_auditoria_id_auditoria_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_auditoria_id_auditoria_seq', 102, true);


--
-- TOC entry 2088 (class 0 OID 65282)
-- Dependencies: 166 2129
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
-- TOC entry 2256 (class 0 OID 0)
-- Dependencies: 167
-- Name: tbl_autor_id_autor_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_autor_id_autor_seq', 12, true);


--
-- TOC entry 2090 (class 0 OID 65287)
-- Dependencies: 168 2129
-- Data for Name: tbl_autor_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_autor_tesis (id_autor_tesis, mension, nombre, apellido) FROM stdin;
1	PUBLICACION	CESAR	ARAQUE
\.


--
-- TOC entry 2257 (class 0 OID 0)
-- Dependencies: 169
-- Name: tbl_autor_tesis_id_autor_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_autor_tesis_id_autor_tesis_seq', 1, true);


--
-- TOC entry 2092 (class 0 OID 65292)
-- Dependencies: 170 2129
-- Data for Name: tbl_castigo; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_castigo (id_castigo, castigo) FROM stdin;
\.


--
-- TOC entry 2258 (class 0 OID 0)
-- Dependencies: 171
-- Name: tbl_castigo_id_castigo_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_castigo_id_castigo_seq', 1, false);


--
-- TOC entry 2094 (class 0 OID 65297)
-- Dependencies: 172 2129
-- Data for Name: tbl_denominacion; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_denominacion (id_denominacion, denominacion) FROM stdin;
1	ESTUDIANTE                    
2	DOCENTE                       
3	INVITADO                      
\.


--
-- TOC entry 2259 (class 0 OID 0)
-- Dependencies: 173
-- Name: tbl_denominacion_id_denominacion_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_denominacion_id_denominacion_seq', 3, true);


--
-- TOC entry 2096 (class 0 OID 65302)
-- Dependencies: 174 2129
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
-- TOC entry 2260 (class 0 OID 0)
-- Dependencies: 175
-- Name: tbl_editorial_id_editorial_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_editorial_id_editorial_seq', 5, true);


--
-- TOC entry 2098 (class 0 OID 65307)
-- Dependencies: 176 2129
-- Data for Name: tbl_falta; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_falta (id_falta, descripcion_falta) FROM stdin;
\.


--
-- TOC entry 2261 (class 0 OID 0)
-- Dependencies: 177
-- Name: tbl_falta_id_falta_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_falta_id_falta_seq', 1, false);


--
-- TOC entry 2100 (class 0 OID 65312)
-- Dependencies: 178 2129
-- Data for Name: tbl_libros; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_libros (id_libro, id_autor, id_editorial, id_materia, edicion, fecha_publicacion, descripcion) FROM stdin;
28	10	4	5	1era	2015-03-11	conexiones a bases de datos con php
29	11	5	1	1era	2015-03-10	codificalo
30	9	5	9	3era	2011-04-01	Bases de datos maria db
\.


--
-- TOC entry 2262 (class 0 OID 0)
-- Dependencies: 179
-- Name: tbl_libros_id_libro_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_libros_id_libro_seq', 30, true);


--
-- TOC entry 2102 (class 0 OID 65317)
-- Dependencies: 180 2129
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
-- TOC entry 2263 (class 0 OID 0)
-- Dependencies: 181
-- Name: tbl_materia_id_materia_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_materia_id_materia_seq', 9, true);


--
-- TOC entry 2104 (class 0 OID 65322)
-- Dependencies: 182 2129
-- Data for Name: tbl_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_material (id_material, id_tipo, nombre) FROM stdin;
1	1	AREVALO CESAR ANTONIO ARAQUE
\.


--
-- TOC entry 2264 (class 0 OID 0)
-- Dependencies: 183
-- Name: tbl_material_id_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_material_id_material_seq', 3, true);


--
-- TOC entry 2106 (class 0 OID 65327)
-- Dependencies: 184 2129
-- Data for Name: tbl_novedad_libro; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_novedad_libro (id_novedad, id_falta, id_penalizacion, id_prestamo, fecha_novedad) FROM stdin;
\.


--
-- TOC entry 2265 (class 0 OID 0)
-- Dependencies: 185
-- Name: tbl_novedad_libro_id_novedad_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_novedad_libro_id_novedad_seq', 1, false);


--
-- TOC entry 2108 (class 0 OID 65332)
-- Dependencies: 186 2129
-- Data for Name: tbl_novedad_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_novedad_material (id_novedad_material, id_falta, id_penalizacion, id_prestamo_material, fecha_novedad) FROM stdin;
\.


--
-- TOC entry 2266 (class 0 OID 0)
-- Dependencies: 187
-- Name: tbl_novedad_material_id_novedad_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_novedad_material_id_novedad_material_seq', 1, false);


--
-- TOC entry 2110 (class 0 OID 65337)
-- Dependencies: 188 2129
-- Data for Name: tbl_novedad_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_novedad_tesis (id_novedad_tesis, id_falta, id_penalizacion, id_prestamo_tesis, fecha_novedad) FROM stdin;
\.


--
-- TOC entry 2267 (class 0 OID 0)
-- Dependencies: 189
-- Name: tbl_novedad_tesis_id_novedad_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_novedad_tesis_id_novedad_tesis_seq', 1, false);


--
-- TOC entry 2112 (class 0 OID 65342)
-- Dependencies: 190 2129
-- Data for Name: tbl_operador; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_operador (id_operador, id_privilegio, nombre, apellido, cedula, password, fecha_creacion, fecha_modifica) FROM stdin;
1	1	AREVALO                       	ARAQUE                        	21005501	202cb962ac59075b964b07152d234b70                  	\N	\N
2	2	CESAR ANTONIO                 	VIZCAYA                       	20724884	202cb962ac59075b964b07152d234b70                  	2015-03-08	2015-04-27
4	2	luis                          	diaz                          	6938094	123                                               	2015-04-27	\N
\.


--
-- TOC entry 2113 (class 0 OID 65346)
-- Dependencies: 191 2129
-- Data for Name: tbl_penalizacion; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_penalizacion (id_penalizacion, id_castigo, descripcion_penalizacion) FROM stdin;
\.


--
-- TOC entry 2268 (class 0 OID 0)
-- Dependencies: 192
-- Name: tbl_penalizacion_id_penalizacion_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_penalizacion_id_penalizacion_seq', 1, false);


--
-- TOC entry 2115 (class 0 OID 65351)
-- Dependencies: 193 2129
-- Data for Name: tbl_prestamo_libro; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_prestamo_libro (id_prestamo, id_libro, id_operador, id_usuario, fecha_prestamo, fecha_devolucion) FROM stdin;
\.


--
-- TOC entry 2269 (class 0 OID 0)
-- Dependencies: 194
-- Name: tbl_prestamo_libro_id_prestamo_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_prestamo_libro_id_prestamo_seq', 1, false);


--
-- TOC entry 2117 (class 0 OID 65356)
-- Dependencies: 195 2129
-- Data for Name: tbl_prestamo_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_prestamo_material (id_prestamo_material, id_materia, id_operador, id_usuario, fecha_prestamo, fecha_devolucion) FROM stdin;
\.


--
-- TOC entry 2270 (class 0 OID 0)
-- Dependencies: 196
-- Name: tbl_prestamo_material_id_prestamo_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_prestamo_material_id_prestamo_material_seq', 1, false);


--
-- TOC entry 2119 (class 0 OID 65361)
-- Dependencies: 197 2129
-- Data for Name: tbl_prestamo_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_prestamo_tesis (id_prestamo_tesis, id_tesis, id_operador, id_usuario, fecha_prestamo, fecha_devolucion) FROM stdin;
\.


--
-- TOC entry 2271 (class 0 OID 0)
-- Dependencies: 198
-- Name: tbl_prestamo_tesis_id_prestamo_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_prestamo_tesis_id_prestamo_tesis_seq', 1, false);


--
-- TOC entry 2121 (class 0 OID 65366)
-- Dependencies: 199 2129
-- Data for Name: tbl_privilegios; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_privilegios (id_privilegio, privilegio) FROM stdin;
1	ADMINISTRADOR
2	BIBLIOTECARIO
\.


--
-- TOC entry 2272 (class 0 OID 0)
-- Dependencies: 200
-- Name: tbl_privilegios_id_privilegio_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_privilegios_id_privilegio_seq', 2, true);


--
-- TOC entry 2123 (class 0 OID 65371)
-- Dependencies: 201 2129
-- Data for Name: tbl_tesis; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_tesis (id_tesis, id_materia, id_autor_tesis, titulo, fecha_publicacion) FROM stdin;
1	1	1	Firmas Espectrales Agricolas  	2015-03-17
\.


--
-- TOC entry 2273 (class 0 OID 0)
-- Dependencies: 202
-- Name: tbl_tesis_id_tesis_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_tesis_id_tesis_seq', 1, true);


--
-- TOC entry 2125 (class 0 OID 65376)
-- Dependencies: 203 2129
-- Data for Name: tbl_tipo_material; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_tipo_material (id_tipo_material, descripcion_tipo) FROM stdin;
1	RECICLAR
2	guardar
3	peso
4	mover
\.


--
-- TOC entry 2274 (class 0 OID 0)
-- Dependencies: 204
-- Name: tbl_tipo_material_id_tipo_material_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tbl_tipo_material_id_tipo_material_seq', 4, true);


--
-- TOC entry 2127 (class 0 OID 65381)
-- Dependencies: 205 2129
-- Data for Name: tbl_usuario; Type: TABLE DATA; Schema: public; Owner: -
--

COPY tbl_usuario (id_usuario, id_denominacion, nombre, apellido, fecha_creacion, fecha_modifica, cedula) FROM stdin;
3	1	ARMANDO JOSE                  	REVERON OCACIONES             	2015-04-27	2015-04-27	21005501
1	2	CESAR AUGUSTO                 	ARAQUE VIZCAYA                	2015-04-27	2015-04-27	20724884
\.


--
-- TOC entry 2275 (class 0 OID 0)
-- Dependencies: 206
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('usuario_id_seq', 3, true);


--
-- TOC entry 1909 (class 2606 OID 65406)
-- Dependencies: 162 162 2130
-- Name: tbl_accion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_accion
    ADD CONSTRAINT tbl_accion_pkey PRIMARY KEY (id_accion);


--
-- TOC entry 1911 (class 2606 OID 65408)
-- Dependencies: 164 164 2130
-- Name: tbl_auditoria_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_auditoria
    ADD CONSTRAINT tbl_auditoria_pkey PRIMARY KEY (id_auditoria);


--
-- TOC entry 1913 (class 2606 OID 65410)
-- Dependencies: 166 166 2130
-- Name: tbl_autor_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_autor
    ADD CONSTRAINT tbl_autor_pkey PRIMARY KEY (id_autor);


--
-- TOC entry 1915 (class 2606 OID 65412)
-- Dependencies: 168 168 2130
-- Name: tbl_autor_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_autor_tesis
    ADD CONSTRAINT tbl_autor_tesis_pkey PRIMARY KEY (id_autor_tesis);


--
-- TOC entry 1917 (class 2606 OID 65414)
-- Dependencies: 170 170 2130
-- Name: tbl_castigo_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_castigo
    ADD CONSTRAINT tbl_castigo_pkey PRIMARY KEY (id_castigo);


--
-- TOC entry 1919 (class 2606 OID 65416)
-- Dependencies: 172 172 2130
-- Name: tbl_denominacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_denominacion
    ADD CONSTRAINT tbl_denominacion_pkey PRIMARY KEY (id_denominacion);


--
-- TOC entry 1921 (class 2606 OID 65418)
-- Dependencies: 174 174 2130
-- Name: tbl_editorial_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_editorial
    ADD CONSTRAINT tbl_editorial_pkey PRIMARY KEY (id_editorial);


--
-- TOC entry 1923 (class 2606 OID 65420)
-- Dependencies: 176 176 2130
-- Name: tbl_falta_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_falta
    ADD CONSTRAINT tbl_falta_pkey PRIMARY KEY (id_falta);


--
-- TOC entry 1925 (class 2606 OID 65422)
-- Dependencies: 178 178 2130
-- Name: tbl_libros_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_pkey PRIMARY KEY (id_libro);


--
-- TOC entry 1927 (class 2606 OID 65424)
-- Dependencies: 180 180 2130
-- Name: tbl_materia_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_materia
    ADD CONSTRAINT tbl_materia_pkey PRIMARY KEY (id_materia);


--
-- TOC entry 1929 (class 2606 OID 65426)
-- Dependencies: 182 182 2130
-- Name: tbl_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_material
    ADD CONSTRAINT tbl_material_pkey PRIMARY KEY (id_material);


--
-- TOC entry 1931 (class 2606 OID 65428)
-- Dependencies: 184 184 2130
-- Name: tbl_novedad_libro_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_pkey PRIMARY KEY (id_novedad);


--
-- TOC entry 1933 (class 2606 OID 65430)
-- Dependencies: 186 186 2130
-- Name: tbl_novedad_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_pkey PRIMARY KEY (id_novedad_material);


--
-- TOC entry 1935 (class 2606 OID 65432)
-- Dependencies: 188 188 2130
-- Name: tbl_novedad_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_pkey PRIMARY KEY (id_novedad_tesis);


--
-- TOC entry 1937 (class 2606 OID 65434)
-- Dependencies: 190 190 2130
-- Name: tbl_operador_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_operador
    ADD CONSTRAINT tbl_operador_pkey PRIMARY KEY (id_operador);


--
-- TOC entry 1939 (class 2606 OID 65436)
-- Dependencies: 191 191 2130
-- Name: tbl_penalizacion_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_penalizacion
    ADD CONSTRAINT tbl_penalizacion_pkey PRIMARY KEY (id_penalizacion);


--
-- TOC entry 1941 (class 2606 OID 65438)
-- Dependencies: 193 193 2130
-- Name: tbl_prestamo_libro_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_pkey PRIMARY KEY (id_prestamo);


--
-- TOC entry 1943 (class 2606 OID 65440)
-- Dependencies: 195 195 2130
-- Name: tbl_prestamo_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_pkey PRIMARY KEY (id_prestamo_material);


--
-- TOC entry 1945 (class 2606 OID 65442)
-- Dependencies: 197 197 2130
-- Name: tbl_prestamo_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_pkey PRIMARY KEY (id_prestamo_tesis);


--
-- TOC entry 1947 (class 2606 OID 65444)
-- Dependencies: 199 199 2130
-- Name: tbl_privilegios_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_privilegios
    ADD CONSTRAINT tbl_privilegios_pkey PRIMARY KEY (id_privilegio);


--
-- TOC entry 1949 (class 2606 OID 65446)
-- Dependencies: 201 201 2130
-- Name: tbl_tesis_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_tesis
    ADD CONSTRAINT tbl_tesis_pkey PRIMARY KEY (id_tesis);


--
-- TOC entry 1951 (class 2606 OID 65448)
-- Dependencies: 203 203 2130
-- Name: tbl_tipo_material_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_tipo_material
    ADD CONSTRAINT tbl_tipo_material_pkey PRIMARY KEY (id_tipo_material);


--
-- TOC entry 1953 (class 2606 OID 65450)
-- Dependencies: 205 205 2130
-- Name: tbl_usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tbl_usuario
    ADD CONSTRAINT tbl_usuario_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 1954 (class 2606 OID 65456)
-- Dependencies: 190 1936 164 2130
-- Name: tbl_auditoria_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_auditoria
    ADD CONSTRAINT tbl_auditoria_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- TOC entry 1955 (class 2606 OID 65461)
-- Dependencies: 166 178 1912 2130
-- Name: tbl_libros_id_autor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_id_autor_fkey FOREIGN KEY (id_autor) REFERENCES tbl_autor(id_autor);


--
-- TOC entry 1956 (class 2606 OID 65466)
-- Dependencies: 178 174 1920 2130
-- Name: tbl_libros_id_editorial_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_id_editorial_fkey FOREIGN KEY (id_editorial) REFERENCES tbl_editorial(id_editorial);


--
-- TOC entry 1957 (class 2606 OID 65471)
-- Dependencies: 178 1926 180 2130
-- Name: tbl_libros_id_materia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_libros
    ADD CONSTRAINT tbl_libros_id_materia_fkey FOREIGN KEY (id_materia) REFERENCES tbl_materia(id_materia);


--
-- TOC entry 1958 (class 2606 OID 65476)
-- Dependencies: 1950 203 182 2130
-- Name: tbl_material_id_tipo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_material
    ADD CONSTRAINT tbl_material_id_tipo_fkey FOREIGN KEY (id_tipo) REFERENCES tbl_tipo_material(id_tipo_material);


--
-- TOC entry 1959 (class 2606 OID 65481)
-- Dependencies: 1922 176 184 2130
-- Name: tbl_novedad_libro_id_falta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_id_falta_fkey FOREIGN KEY (id_falta) REFERENCES tbl_falta(id_falta);


--
-- TOC entry 1960 (class 2606 OID 65486)
-- Dependencies: 191 184 1938 2130
-- Name: tbl_novedad_libro_id_penalizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_id_penalizacion_fkey FOREIGN KEY (id_penalizacion) REFERENCES tbl_penalizacion(id_penalizacion);


--
-- TOC entry 1961 (class 2606 OID 65491)
-- Dependencies: 184 193 1940 2130
-- Name: tbl_novedad_libro_id_prestamo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_libro
    ADD CONSTRAINT tbl_novedad_libro_id_prestamo_fkey FOREIGN KEY (id_prestamo) REFERENCES tbl_prestamo_libro(id_prestamo);


--
-- TOC entry 1962 (class 2606 OID 65496)
-- Dependencies: 186 176 1922 2130
-- Name: tbl_novedad_material_id_falta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_id_falta_fkey FOREIGN KEY (id_falta) REFERENCES tbl_falta(id_falta);


--
-- TOC entry 1963 (class 2606 OID 65501)
-- Dependencies: 1938 186 191 2130
-- Name: tbl_novedad_material_id_penalizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_id_penalizacion_fkey FOREIGN KEY (id_penalizacion) REFERENCES tbl_penalizacion(id_penalizacion);


--
-- TOC entry 1964 (class 2606 OID 65506)
-- Dependencies: 186 1942 195 2130
-- Name: tbl_novedad_material_id_prestamo_material_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_material
    ADD CONSTRAINT tbl_novedad_material_id_prestamo_material_fkey FOREIGN KEY (id_prestamo_material) REFERENCES tbl_prestamo_material(id_prestamo_material);


--
-- TOC entry 1965 (class 2606 OID 65511)
-- Dependencies: 188 1922 176 2130
-- Name: tbl_novedad_tesis_id_falta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_id_falta_fkey FOREIGN KEY (id_falta) REFERENCES tbl_falta(id_falta);


--
-- TOC entry 1966 (class 2606 OID 65516)
-- Dependencies: 188 191 1938 2130
-- Name: tbl_novedad_tesis_id_penalizacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_id_penalizacion_fkey FOREIGN KEY (id_penalizacion) REFERENCES tbl_penalizacion(id_penalizacion);


--
-- TOC entry 1967 (class 2606 OID 65521)
-- Dependencies: 1944 188 197 2130
-- Name: tbl_novedad_tesis_id_prestamo_tesis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_novedad_tesis
    ADD CONSTRAINT tbl_novedad_tesis_id_prestamo_tesis_fkey FOREIGN KEY (id_prestamo_tesis) REFERENCES tbl_prestamo_tesis(id_prestamo_tesis);


--
-- TOC entry 1968 (class 2606 OID 65526)
-- Dependencies: 1946 190 199 2130
-- Name: tbl_operador_id_privilegio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_operador
    ADD CONSTRAINT tbl_operador_id_privilegio_fkey FOREIGN KEY (id_privilegio) REFERENCES tbl_privilegios(id_privilegio);


--
-- TOC entry 1969 (class 2606 OID 65531)
-- Dependencies: 1916 191 170 2130
-- Name: tbl_penalizacion_id_castigo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_penalizacion
    ADD CONSTRAINT tbl_penalizacion_id_castigo_fkey FOREIGN KEY (id_castigo) REFERENCES tbl_castigo(id_castigo);


--
-- TOC entry 1970 (class 2606 OID 65536)
-- Dependencies: 1924 193 178 2130
-- Name: tbl_prestamo_libro_id_libro_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_id_libro_fkey FOREIGN KEY (id_libro) REFERENCES tbl_libros(id_libro);


--
-- TOC entry 1971 (class 2606 OID 65541)
-- Dependencies: 190 193 1936 2130
-- Name: tbl_prestamo_libro_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- TOC entry 1972 (class 2606 OID 65546)
-- Dependencies: 1952 193 205 2130
-- Name: tbl_prestamo_libro_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_libro
    ADD CONSTRAINT tbl_prestamo_libro_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);


--
-- TOC entry 1973 (class 2606 OID 65551)
-- Dependencies: 180 1926 195 2130
-- Name: tbl_prestamo_material_id_materia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_id_materia_fkey FOREIGN KEY (id_materia) REFERENCES tbl_materia(id_materia);


--
-- TOC entry 1974 (class 2606 OID 65556)
-- Dependencies: 1936 195 190 2130
-- Name: tbl_prestamo_material_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- TOC entry 1975 (class 2606 OID 65561)
-- Dependencies: 1952 195 205 2130
-- Name: tbl_prestamo_material_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_material
    ADD CONSTRAINT tbl_prestamo_material_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);


--
-- TOC entry 1976 (class 2606 OID 65566)
-- Dependencies: 1936 190 197 2130
-- Name: tbl_prestamo_tesis_id_operador_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_id_operador_fkey FOREIGN KEY (id_operador) REFERENCES tbl_operador(id_operador);


--
-- TOC entry 1977 (class 2606 OID 65571)
-- Dependencies: 197 1948 201 2130
-- Name: tbl_prestamo_tesis_id_tesis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_id_tesis_fkey FOREIGN KEY (id_tesis) REFERENCES tbl_tesis(id_tesis);


--
-- TOC entry 1978 (class 2606 OID 65576)
-- Dependencies: 197 205 1952 2130
-- Name: tbl_prestamo_tesis_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_prestamo_tesis
    ADD CONSTRAINT tbl_prestamo_tesis_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);


--
-- TOC entry 1979 (class 2606 OID 65581)
-- Dependencies: 168 1914 201 2130
-- Name: tbl_tesis_id_autor_tesis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tesis
    ADD CONSTRAINT tbl_tesis_id_autor_tesis_fkey FOREIGN KEY (id_autor_tesis) REFERENCES tbl_autor_tesis(id_autor_tesis);


--
-- TOC entry 1980 (class 2606 OID 65586)
-- Dependencies: 180 201 1926 2130
-- Name: tbl_tesis_id_materia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_tesis
    ADD CONSTRAINT tbl_tesis_id_materia_fkey FOREIGN KEY (id_materia) REFERENCES tbl_materia(id_materia);


--
-- TOC entry 1981 (class 2606 OID 65591)
-- Dependencies: 1918 172 205 2130
-- Name: tbl_usuario_id_denominacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tbl_usuario
    ADD CONSTRAINT tbl_usuario_id_denominacion_fkey FOREIGN KEY (id_denominacion) REFERENCES tbl_denominacion(id_denominacion);


--
-- TOC entry 2135 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-04-27 13:41:11 VET

--
-- PostgreSQL database dump complete
--

