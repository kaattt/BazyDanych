-- obsluga w lini polecen:
-- kasia:~$ psql przepisy
-- przepisy=# \i Dokumenty/BazyDanych/db.sql        
-- to wykonuje ten kod

DROP TABLE polaczenie CASCADE;
DROP TABLE historia CASCADE;
DROP TABLE przepisy CASCADE;
DROP TABLE produkty CASCADE;
DROP TABLE uzytkownicy CASCADE;


CREATE TABLE uzytkownicy(
			id_uzyt SERIAL PRIMARY KEY NOT NULL ,
			nazwa varchar(256) NOT NULL UNIQUE
			);

INSERT INTO uzytkownicy(nazwa) VALUES ('Kasia');
INSERT INTO uzytkownicy(nazwa) VALUES ('Szymek');


CREATE TABLE produkty(
			id_prod  SERIAL PRIMARY KEY NOT NULL,
			nazwa varchar(256) NOT NULL
			);

INSERT INTO produkty (nazwa) VALUES ('marchew');
INSERT INTO produkty (nazwa) VALUES ('groszek');
INSERT INTO produkty (nazwa) VALUES ('ser');
INSERT INTO produkty (nazwa) VALUES ('twaróg');
INSERT INTO produkty (nazwa) VALUES ('mleko');
INSERT INTO produkty (nazwa) VALUES ('szynka');
INSERT INTO produkty (nazwa) VALUES ('śmietana');
INSERT INTO produkty (nazwa) VALUES ('jogurt');
INSERT INTO produkty (nazwa) VALUES ('grzyby');
INSERT INTO produkty (nazwa) VALUES ('kukurydza');
INSERT INTO produkty (nazwa) VALUES ('mięso');
INSERT INTO produkty (nazwa) VALUES ('sałata');
INSERT INTO produkty (nazwa) VALUES ('ketchup');
INSERT INTO produkty (nazwa) VALUES ('cynamon');
INSERT INTO produkty (nazwa) VALUES ('mąka');
INSERT INTO produkty (nazwa) VALUES ('kasza');
INSERT INTO produkty (nazwa) VALUES ('jabłko');
INSERT INTO produkty (nazwa) VALUES ('banan');
INSERT INTO produkty (nazwa) VALUES ('rzodkiewka');
INSERT INTO produkty (nazwa) VALUES ('masło');
INSERT INTO produkty (nazwa) VALUES ('olej');
INSERT INTO produkty (nazwa) VALUES ('ogórek');
INSERT INTO produkty (nazwa) VALUES ('cebula');



CREATE TABLE przepisy(
			id_przep  SERIAL PRIMARY KEY NOT NULL ,
			nazwa varchar(256) NOT NULL UNIQUE,
			przepis varchar(1024) NOT NULL,
			id_uzyt int4,
			FOREIGN KEY (id_uzyt) REFERENCES uzytkownicy(id_uzyt) DEFERRABLE,
			data timestamp DEFAULT now()
			);

INSERT INTO przepisy (nazwa,przepis,data, id_uzyt) VALUES ('ser z grzybami', 'dodaj grzyby do sera', '2015-12-30 22:15:00', 1);
INSERT INTO przepisy (nazwa,przepis,data, id_uzyt) VALUES ('marchewka z groszkiem', 'dodaj marchewke do groszku', '2015-12-30 22:15:01', 2);




CREATE TABLE polaczenie(
			id_pol  SERIAL PRIMARY KEY NOT NULL ,
			id_prod int4, 
			FOREIGN KEY (id_prod) REFERENCES produkty(id_prod) DEFERRABLE,		
			id_przep int4,
			FOREIGN KEY (id_przep) REFERENCES przepisy(id_przep) DEFERRABLE	

			);

INSERT INTO polaczenie (id_prod, id_przep) VALUES (9 , 1);
INSERT INTO polaczenie (id_prod, id_przep) VALUES (3 , 1);
INSERT INTO polaczenie (id_prod, id_przep) VALUES (1 , 2);
INSERT INTO polaczenie (id_prod, id_przep) VALUES (2 , 2);


CREATE TABLE historia(
			id_hist  SERIAL PRIMARY KEY NOT NULL ,
			id_przep int4,
			FOREIGN KEY (id_przep) REFERENCES przepisy(id_przep) DEFERRABLE,					
			zmiana varchar(1024),
			UNIQUE (zmiana),
			id_uzyt int4,
			FOREIGN KEY (id_uzyt) REFERENCES uzytkownicy(id_uzyt) DEFERRABLE,		
			data timestamp
			);

INSERT INTO historia (zmiana, data, id_przep, id_uzyt) VALUES ('dodaj groszek do marchewki', '2015-12-29 10:00:01',2, 1);
INSERT INTO historia (zmiana, data, id_przep, id_uzyt) VALUES ('dodaj ser do grzybów', '2015-12-29 10:00:01',1, 2);

--------------------

DROP  FUNCTION update_modified_column()	;
CREATE  FUNCTION update_modified_column() RETURNS TRIGGER AS '
BEGIN
    NEW.data = now();
    RETURN NEW;	
END;
' language 'plpgsql';

CREATE TRIGGER update_customer_modtime BEFORE UPDATE ON przepisy FOR EACH ROW EXECUTE PROCEDURE  update_modified_column();

-------------------- 

DROP FUNCTION spr_stan_przed_update() ;
CREATE FUNCTION spr_stan_przed_update() RETURNS TRIGGER AS '
BEGIN
	IF NEW.data < (SELECT data FROM historia WHERE id_przep=NEW.id_przep order by 
		data desc limit 1 ) THEN 
		RAISE NOTICE ''Operacja nie zostala wykonana. Nie edytujesz najnowszego 
		przepisu'';
		RETURN NULL;
	ELSE
		INSERT INTO historia (id_przep, zmiana, id_uzyt, data)
		VALUES (OLD.id_przep, OLD.przepis, OLD.id_uzyt, now()) ;
		RETURN NEW;
END IF;
END;
' LANGUAGE 'plpgsql';


CREATE TRIGGER t_spr_stan_przed_update BEFORE UPDATE ON przepisy FOR EACH ROW EXECUTE PROCEDURE spr_stan_przed_update();

----------------------

DROP FUNCTION spr_stan_przed_uzyt() ;
CREATE FUNCTION spr_stan_przed_uzyt() RETURNS TRIGGER AS '

DECLARE 
 
 i uzytkownicy%ROWTYPE;
 
BEGIN
 
 for i.nazwa in SELECT nazwa FROM uzytkownicy loop
 	if NEW.nazwa=i.nazwa then 
 		return null;
 	end if;
 end loop;
 return new;
 END;
 'LANGUAGE 'plpgsql';
 
CREATE TRIGGER t_spr_stan_przed_uzyt BEFORE INSERT OR update ON uzytkownicy FOR EACH ROW EXECUTE PROCEDURE spr_stan_przed_uzyt();


----------------------

DROP FUNCTION spr_stan_przed_przepis() ;
CREATE FUNCTION spr_stan_przed_przepis() RETURNS TRIGGER AS '

DECLARE 

i przepisy%ROWTYPE;

BEGIN

for i.nazwa in SELECT nazwa FROM przepisy loop
	if NEW.nazwa=i.nazwa then 
		return null;
	end if;
end loop;
return new;
END;
' LANGUAGE 'plpgsql';

CREATE TRIGGER t_spr_stan_przed_przepis BEFORE INSERT ON przepisy FOR EACH ROW EXECUTE PROCEDURE spr_stan_przed_przepis();

-----------------------

