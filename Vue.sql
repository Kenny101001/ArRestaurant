CREATE VIEW v_entreprise_details AS
SELECT
    e.id AS id,
    e.nom AS nom,
    e.logo AS logo,
    e.adresse AS adresse,
    e.type_entreprise as type_entreprise,
    te.type as type,
    e.phone AS phone,
    e.email AS email,
    e.siteweb AS siteweb,
    e.forfait AS forfait,
    f.nom as forfait_nom,
    f.nb3d as forfait_nb3d,
    e.date_ajout as date_ajout,
    e.mdp as mdp,
    e.actif as actif,
    (SELECT COUNT(*) FROM produit p WHERE p.id_entreprise = e.id) as nb_produit
FROM
    entreprise e
JOIN "typeEntreprise" te ON e.type_entreprise = te.id
JOIN forfait f ON e.forfait = f.id


CREATE VIEW v_produit_details AS
SELECT
    p.id AS id,
    p.nom AS nom,
    p.url_3d AS url_3d,
    p.url_image AS url_image,
    p.id_entreprise AS id_entreprise,
    e.nom AS entreprise_nom,
    p.id_type_plat AS id_type_plat,
    tp.nom AS type_plat_nom,
    p.code AS code,
    p.date_ajout as date_ajout
FROM
    produit p
JOIN type_plat tp ON p.id_type_plat = tp.id
JOIN entreprise e ON p.id_entreprise = e.id

