DELIMITER $$
CREATE OR REPLACE PROCEDURE Ex3b()
BEGIN
	SELECT * FROM Imprumut WHERE COALESCE(datar, SYSDATE()) - datai > nr_zile ORDER BY nr_zile DESC, datai;
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE PROCEDURE Ex4b()
BEGIN
	SELECT DISTINCT CONCAT(a1.id_aut, CONCAT(' ', a2.id_aut)) "perechi" FROM Autor a1 JOIN Carte c1 ON(a1.id_carte=c1.id_carte), Autor a2 JOIN Carte c2 ON(a2.id_carte = c2.id_carte) WHERE(a1.id_aut != a2.id_aut AND c1.gen = c2.gen AND a1.id_aut > a2.id_aut);
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE PROCEDURE Ex5b()
BEGIN
	SELECT Persoana.nume, Carte.titlu FROM Persoana JOIN Autor ON Autor.id_aut = Persoana.id_pers JOIN Carte ON Carte.id_carte = Autor.id_carte WHERE Autor.id_carte IN(SELECT a1.id_carte FROM Autor a1 JOIN Autor a2 ON a1.id_carte = a2.id_carte WHERE a1.id_carte = a2.id_carte AND a1.id_aut != a2.id_aut);
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE FUNCTION function1(
    dataImprumut DATE, dataRestituire DATE, nrZile INTEGER
)   
RETURNS INTEGER
DETERMINISTIC
BEGIN  
	RETURN TRUNCATE(DATEDIFF(CAST(COALESCE(dataRestituire, SYSDATE()) AS DATE), CAST(dataImprumut AS DATE)) + 1 - nrZile, 0);
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE FUNCTION function2(
    dataImprumut DATE, dataRestituire DATE, nrZile INTEGER
)   
RETURNS INTEGER
DETERMINISTIC
BEGIN  
	RETURN DATEDIFF(CAST(COALESCE(dataRestituire, SYSDATE()) AS DATE), CAST(dataImprumut AS DATE)) + 1 - nrZile;
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE PROCEDURE Ex6a()
BEGIN
	SELECT Persoana.nume, function1(Imprumut.datai, Imprumut.datar, Imprumut.nr_zile) "zile" FROM Persoana INNER JOIN Imprumut ON (Persoana.id_pers = Imprumut.id_imp) WHERE DATEDIFF(CAST(COALESCE(Imprumut.datar, SYSDATE()) AS DATE), CAST(Imprumut.datai AS DATE)) + 1 - Imprumut.nr_zile = (SELECT MAX(DATEDIFF(CAST(COALESCE(datar, SYSDATE()) AS DATE), CAST(datai AS DATE)) + 1 - nr_zile) FROM Imprumut);
END $$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE PROCEDURE Ex6b()
BEGIN
	SELECT MIN(nr_pagini), ROUND(AVG(nr_pagini),2), MAX(nr_pagini), gen FROM Carte GROUP BY gen;
END $$
DELIMITER ;
