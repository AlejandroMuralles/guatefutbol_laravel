INSERT INTO guatefut_sys.perfil
SELECT id, nombre, 'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.perfil;

INSERT INTO guatefut_sys.users
SELECT id,username,password,perfil_id,null,remember_token,null,null,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.users;

INSERT INTO guatefut_sys.liga
SELECT id, nombre,orden,1,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.liga;

INSERT INTO guatefut_sys.equipo
SELECT id, nombre,nombre,'   ',imagen,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.equipo;

INSERT INTO guatefut_sys.jornada
SELECT id, nombre,case fase_id when 1 then 'F' when 2 then 'R' end ,numero,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.jornada;

INSERT INTO guatefut_sys.evento
SELECT a.id, a.nombre,b.ruta, a.ruta, a.ruta_editar,1,'A', a.created_at, a.updated_at, 'admin','admin'
FROM futbolsy_gf.evento a, futbolsy_gf.imagen_evento b
where a.imagen_id = b.id;

INSERT INTO guatefut_sys.campeonato
SELECT id,nombre,fecha_inicio,fecha_fin,liga_id,actual,mostrar_app,hashtag,0,case publicado when 0 then 'I' when 1 then 'A' end, created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.campeonato;

INSERT INTO guatefut_sys.pais
SELECT id, nombre,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.pais;

INSERT INTO guatefut_sys.departamento
SELECT id, nombre,pais_id,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.departamento;

UPDATE futbolsy_gf.persona
SET fecha_nacimiento = '1900-01-01'
WHERE fecha_nacimiento is null;

INSERT INTO guatefut_sys.persona
SELECT id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,fecha_nacimiento,pais_id,departamento_id,
case rol_id when 1 then 'DT' when 2 then 'J' when 3 then 'A' end, 
case portero when 1 then 1 else 0 end,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.persona;

INSERT INTO guatefut_sys.estadio
SELECT id, nombre,null,null,null,null,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.estadio;

INSERT INTO guatefut_sys.campeonato_equipo
SELECT id,campeonato_id, equipo_id,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.campeonato_equipo;

INSERT INTO guatefut_sys.plantilla
SELECT id,campeonato_id, equipo_id,persona_id,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.campeonato_equipo_persona;

INSERT INTO guatefut_sys.partido
SELECT id,campeonato_id,fecha,equipo_local_id,equipo_visita_id,goles_local,goles_visita,jornada_id,arbitro_central_id,
estadio_id,descripcion_penales,
case estado_id when 1 then 'P' when 2 then 'ST' when 3 then 'FT' end, null, estado_id, created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.partido;

UPDATE futbolsy_gf.alineacion
SET minutos_jugados = 0
WHERE minutos_jugados is null;

INSERT INTO guatefut_sys.alineacion
SELECT id, partido_id,equipo_id,persona_id,
case es_titular when 1 then 1 else 0 end,minutos_jugados, created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.alineacion;

INSERT INTO guatefut_sys.configuracion
SELECT id,nombre,parametro1, parametro2, parametro3, created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.configuracion;

INSERT INTO guatefut_sys.evento_partido
SELECT id,partido_id, evento_id, minuto, doble_amarilla, jugador1_id, jugador2_id, equipo_id, comentario, created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.evento_partido;

INSERT INTO guatefut_sys.historial_campeon
SELECT id,campeonato, equipo_campeon, entrenador_campeon, equipo_subcampeon, fecha, veces_equipo, veces_entrenador, created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.historial_campeon;

INSERT INTO guatefut_sys.tabla_acumulada
SELECT id,campeonato1_id, campeonato2_id,'A', created_at, updated_at, 'admin','admin'
FROM futbolsy_gf.tabla_acumulada;