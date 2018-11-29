CREATE  OR REPLACE VIEW `vw_estadisticas_jugador_liga` AS  (
    SELECT id, b.liga_id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, b.minutos_jugados, b.apariciones, c.goles, c.amarillas, c.dobles_amarillas, c.rojas, d.ganados, d.empatados, d.perdidos
    FROM persona a
    LEFT JOIN (
        SELECT persona_id, c.liga_id, SUM(minutos_jugados) minutos_jugados, COUNT(1) apariciones, 0 goles, 0 amarillas, 0 dobles_amarillas, 0 rojas, 0 ganados, 0 empatados, 0 perdidos
        FROM alineacion a
        INNER JOIN partido b on (a.partido_id = b.id)
        INNER JOIN campeonato c on (b.campeonato_id = c.id)
        WHERE a.minutos_jugados > 0
        GROUP BY a.persona_id, c.liga_id ) b on (a.id = b.persona_id)
    LEFT JOIN (
        SELECT a.jugador1_id, c.liga_id, 0 minutos_jugados, 0 apariciones, SUM(CASE WHEN a.evento_id in (6,8) THEN 1 ELSE 0 end) goles, SUM(CASE WHEN a.evento_id=10 THEN 1 ELSE 0 end) amarillas,
        SUM(CASE WHEN a.evento_id=11 AND a.doble_amarilla=1 THEN 1 ELSE 0 end) dobles_amarillas, SUM(CASE WHEN a.evento_id=11 AND a.doble_amarilla=0 THEN 1 ELSE 0 end) rojas
        FROM evento_partido a
        INNER JOIN partido b on (a.partido_id = b.id)
        INNER JOIN campeonato c on (b.campeonato_id = c.id)
        GROUP BY a.jugador1_id, c.liga_id ) c on (a.id = c.jugador1_id and b.liga_id = c.liga_id)
    LEFT JOIN (
        SELECT a.persona_id, c.liga_id, 0 minutos_jugados, 0 apariciones, 0 goles, 0 amarillas, 0 dobles_amarillas, 0 rojas,
        SUM(CASE WHEN (a.equipo_id = b.equipo_local_id AND b.goles_local > b.goles_visita) OR (a.equipo_id = b.equipo_visita_id AND b.goles_visita > b.goles_local) THEN 1 ELSE 0 end) ganados,
        SUM(CASE WHEN (b.goles_local = b.goles_visita) THEN 1 ELSE 0 end) empatados,
        SUM(CASE WHEN (a.equipo_id = b.equipo_local_id AND b.goles_local < b.goles_visita) OR (a.equipo_id = b.equipo_visita_id AND b.goles_visita < b.goles_local) THEN 1 ELSE 0 end) perdidos
        FROM alineacion a
        INNER JOIN partido b on (a.partido_id = b.id)
        INNER JOIN campeonato c on (b.campeonato_id = c.id)
        GROUP BY a.persona_id, c.liga_id ) d on (a.id = d.persona_id AND c.liga_id = d.liga_id)
)
CREATE  OR REPLACE VIEW `vw_estadisticas_jugador_campeonato` AS  (
    SELECT id, b.campeonato_id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, b.minutos_jugados, b.apariciones, c.goles, c.amarillas, c.dobles_amarillas, c.rojas, d.ganados, d.empatados, d.perdidos
    FROM persona a
    LEFT JOIN (
        SELECT persona_id, b.campeonato_id, SUM(minutos_jugados) minutos_jugados, COUNT(1) apariciones, 0 goles, 0 amarillas, 0 dobles_amarillas, 0 rojas, 0 ganados, 0 empatados, 0 perdidos
        FROM alineacion a
        INNER JOIN partido b on (a.partido_id = b.id)
        INNER JOIN campeonato c on (b.campeonato_id = c.id)
        WHERE a.minutos_jugados > 0
        GROUP BY a.persona_id, b.campeonato_id ) b on (a.id = b.persona_id)
    LEFT JOIN (
        SELECT a.jugador1_id, b.campeonato_id, 0 minutos_jugados, 0 apariciones, SUM(CASE WHEN a.evento_id in (6,8) THEN 1 ELSE 0 end) goles, SUM(CASE WHEN a.evento_id=10 THEN 1 ELSE 0 end) amarillas,
        SUM(CASE WHEN a.evento_id=11 AND a.doble_amarilla=1 THEN 1 ELSE 0 end) dobles_amarillas, SUM(CASE WHEN a.evento_id=11 AND a.doble_amarilla=0 THEN 1 ELSE 0 end) rojas
        FROM evento_partido a
        INNER JOIN partido b on (a.partido_id = b.id)
        INNER JOIN campeonato c on (b.campeonato_id = c.id)
        GROUP BY a.jugador1_id, b.campeonato_id ) c on (a.id = c.jugador1_id and b.campeonato_id = c.campeonato_id)
    LEFT JOIN (
        SELECT a.persona_id, b.campeonato_id, 0 minutos_jugados, 0 apariciones, 0 goles, 0 amarillas, 0 dobles_amarillas, 0 rojas,
        SUM(CASE WHEN (a.equipo_id = b.equipo_local_id AND b.goles_local > b.goles_visita) OR (a.equipo_id = b.equipo_visita_id AND b.goles_visita > b.goles_local) THEN 1 ELSE 0 end) ganados,
        SUM(CASE WHEN (b.goles_local = b.goles_visita) THEN 1 ELSE 0 end) empatados,
        SUM(CASE WHEN (a.equipo_id = b.equipo_local_id AND b.goles_local < b.goles_visita) OR (a.equipo_id = b.equipo_visita_id AND b.goles_visita < b.goles_local) THEN 1 ELSE 0 end) perdidos
        FROM alineacion a
        INNER JOIN partido b on (a.partido_id = b.id)
        INNER JOIN campeonato c on (b.campeonato_id = c.id)
        GROUP BY a.persona_id, b.campeonato_id ) d on (a.id = d.persona_id AND c.campeonato_id = d.campeonato_id)
)

