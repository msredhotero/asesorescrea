INSERT INTO `dboportunidades`
(`idoportunidad`,
`nombredespacho`,
`apellidopaterno`,
`apellidomaterno`,
`nombre`,
`telefonomovil`,
`telefonotrabajo`,
`email`,
`refusuarios`,
`refreferentes`,
`refestadooportunidad`,
`fechacrea`,
`refmotivorechazos`,
`observaciones`,
`refestadogeneraloportunidad`)
SELECT 
    '',
    p.razonsocial,
    p.apellidopaterno,
    p.apellidomaterno,
    p.nombre,
    p.telefonomovil,
    p.telefonotrabajo,
    p.email,
    rr.refusuarios,
    NULL,
    3,
    NOW(),
    NULL,
    '',
    1
FROM
    dbpostulantes p
        INNER JOIN
    dbreclutadorasores rr ON rr.refpostulantes = p.idpostulante
    inner join dbusuarios usu on usu.idusuario = rr.refusuarios
    where usu.refroles = 3 and p.idpostulante not in (12) and p.refestadopostulantes not in (10)
    order by 2,3
