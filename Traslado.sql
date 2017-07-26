INSERT INTO guatefut_gfsys.perfil
SELECT id, nombre, 'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.perfil;

INSERT INTO guatefut_gfsys.users
SELECT id,username,password,perfil_id,null,remember_token,null,null,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.users;

INSERT INTO guatefut_gfsys.liga
SELECT id, nombre,orden,1,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.liga;

INSERT INTO guatefut_gfsys.equipo
SELECT id, nombre,nombre,'   ',imagen,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.equipo;

INSERT INTO guatefut_gfsys.jornada
SELECT id, nombre,case fase_id when 1 then 'F' when 2 then 'R' end ,numero,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.jornada;

INSERT INTO guatefut_gfsys.evento
SELECT a.id, a.nombre,b.ruta, a.ruta, a.ruta_editar,1,'A', a.created_at, a.updated_at, 'admin','admin'
FROM guatefut_sys.evento a, guatefut_sys.imagen_evento b
where a.imagen_id = b.id;

INSERT INTO guatefut_gfsys.campeonato
SELECT id,nombre,fecha_inicio,fecha_fin,liga_id,actual,mostrar_app,hashtag,0,case publicado when 0 then 'I' when 1 then 'A' end, created_at, updated_at, 'admin','admin'
FROM guatefut_sys.campeonato;

INSERT INTO guatefut_gfsys.pais
SELECT id, nombre,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.pais;

INSERT INTO guatefut_gfsys.departamento
SELECT id, nombre,pais_id,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.departamento;

UPDATE guatefut_sys.persona
SET fecha_nacimiento = '1900-01-01'
WHERE fecha_nacimiento is null;

INSERT INTO guatefut_gfsys.persona
SELECT id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,fecha_nacimiento,pais_id,departamento_id,
case rol_id when 1 then 'DT' when 2 then 'J' when 3 then 'A' end, 
case portero when 1 then 1 else 0 end,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.persona;

INSERT INTO guatefut_gfsys.estadio
SELECT id, nombre,null,null,null,null,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.estadio;

INSERT INTO guatefut_gfsys.campeonato_equipo
SELECT id,campeonato_id, equipo_id,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.campeonato_equipo;

INSERT INTO guatefut_gfsys.plantilla
SELECT id,campeonato_id, equipo_id,persona_id,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.campeonato_equipo_persona;

INSERT INTO guatefut_gfsys.partido
SELECT id,campeonato_id,fecha,equipo_local_id,equipo_visita_id,goles_local,goles_visita,jornada_id,arbitro_central_id,
estadio_id,descripcion_penales,
case estado_id when 1 then 'P' when 2 then 'ST' when 3 then 'FT' end, null, estado_id, created_at, updated_at, 'admin','admin'
FROM guatefut_sys.partido;

UPDATE guatefut_sys.alineacion
SET minutos_jugados = 0
WHERE minutos_jugados is null;

INSERT INTO guatefut_gfsys.alineacion
SELECT id, partido_id,equipo_id,persona_id,
case es_titular when 1 then 1 else 0 end,minutos_jugados, created_at, updated_at, 'admin','admin'
FROM guatefut_sys.alineacion;

INSERT INTO guatefut_gfsys.configuracion
SELECT id,nombre,parametro1, parametro2, parametro3, created_at, updated_at, 'admin','admin'
FROM guatefut_sys.configuracion;

INSERT INTO guatefut_gfsys.evento_partido
SELECT id,partido_id, evento_id, minuto, doble_amarilla, jugador1_id, jugador2_id, equipo_id, comentario, created_at, updated_at, 'admin','admin'
FROM guatefut_sys.evento_partido;

INSERT INTO guatefut_gfsys.historial_campeon
SELECT id,campeonato, equipo_campeon, entrenador_campeon, equipo_subcampeon, fecha, veces_equipo, veces_entrenador, created_at, updated_at, 'admin','admin'
FROM guatefut_sys.historial_campeon;

INSERT INTO guatefut_gfsys.tabla_acumulada
SELECT id,campeonato1_id, campeonato2_id,'A', created_at, updated_at, 'admin','admin'
FROM guatefut_sys.tabla_acumulada;

UPDATE equipo SET logo = 'imagenes/equipos/equipo.png';

UPDATE equipo SET logo = 'imagenes/equipos/25.png' WHERE id = 25;
UPDATE equipo SET logo = 'imagenes/equipos/26.png' WHERE id = 26;
UPDATE equipo SET logo = 'imagenes/equipos/27.png' WHERE id = 27;
UPDATE equipo SET logo = 'imagenes/equipos/28.gif' WHERE id = 28;
UPDATE equipo SET logo = 'imagenes/equipos/29.png' WHERE id = 29;
UPDATE equipo SET logo = 'imagenes/equipos/30.png' WHERE id = 30;
UPDATE equipo SET logo = 'imagenes/equipos/31.png' WHERE id = 31;
UPDATE equipo SET logo = 'imagenes/equipos/32.png' WHERE id = 32;
UPDATE equipo SET logo = 'imagenes/equipos/33.png' WHERE id = 33;
UPDATE equipo SET logo = 'imagenes/equipos/34.png' WHERE id = 34;
UPDATE equipo SET logo = 'imagenes/equipos/35.png' WHERE id = 35;
UPDATE equipo SET logo = 'imagenes/equipos/36.png' WHERE id = 36;
UPDATE equipo SET logo = 'imagenes/equipos/37.png' WHERE id = 37;
UPDATE equipo SET logo = 'imagenes/equipos/38.png' WHERE id = 38;
UPDATE equipo SET logo = 'imagenes/equipos/39.png' WHERE id = 39;
UPDATE equipo SET logo = 'imagenes/equipos/40.png' WHERE id = 40;
UPDATE equipo SET logo = 'imagenes/equipos/42.png' WHERE id = 42;
UPDATE equipo SET logo = 'imagenes/equipos/43.png' WHERE id = 43;
UPDATE equipo SET logo = 'imagenes/equipos/44.png' WHERE id = 44;
UPDATE equipo SET logo = 'imagenes/equipos/55.png' WHERE id = 55;
UPDATE equipo SET logo = 'imagenes/equipos/56.png' WHERE id = 56;
UPDATE equipo SET logo = 'imagenes/equipos/57.png' WHERE id = 57;
UPDATE equipo SET logo = 'imagenes/equipos/58.png' WHERE id = 58;
UPDATE equipo SET logo = 'imagenes/equipos/59.png' WHERE id = 59;
UPDATE equipo SET logo = 'imagenes/equipos/60.png' WHERE id = 60;
UPDATE equipo SET logo = 'imagenes/equipos/61.png' WHERE id = 61;
UPDATE equipo SET logo = 'imagenes/equipos/62.png' WHERE id = 62;
UPDATE equipo SET logo = 'imagenes/equipos/63.png' WHERE id = 63;
UPDATE equipo SET logo = 'imagenes/equipos/64.png' WHERE id = 64;
UPDATE equipo SET logo = 'imagenes/equipos/65.png' WHERE id = 65;
UPDATE equipo SET logo = 'imagenes/equipos/68.png' WHERE id = 68;
UPDATE equipo SET logo = 'imagenes/equipos/68.png' WHERE id = 68;
UPDATE equipo SET logo = 'imagenes/equipos/70.png' WHERE id = 70;
UPDATE equipo SET logo = 'imagenes/equipos/71.png' WHERE id = 71;
UPDATE equipo SET logo = 'imagenes/equipos/72.png' WHERE id = 72;
UPDATE equipo SET logo = 'imagenes/equipos/73.png' WHERE id = 73;
UPDATE equipo SET logo = 'imagenes/equipos/74.png' WHERE id = 74;
UPDATE equipo SET logo = 'imagenes/equipos/75.png' WHERE id = 75;
UPDATE equipo SET logo = 'imagenes/equipos/76.png' WHERE id = 76;
UPDATE equipo SET logo = 'imagenes/equipos/79.png' WHERE id = 79;
UPDATE equipo SET logo = 'imagenes/equipos/80.png' WHERE id = 80;
UPDATE equipo SET logo = 'imagenes/equipos/81.png' WHERE id = 81;
UPDATE equipo SET logo = 'imagenes/equipos/82.png' WHERE id = 82;
UPDATE equipo SET logo = 'imagenes/equipos/83.png' WHERE id = 83;

