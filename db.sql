DROP TABLE IF EXISTS polaczenie;
DROP TABLE IF EXISTS historia;
DROP TABLE IF EXISTS przepisy;
DROP TABLE IF EXISTS produkty;
DROP TABLE IF EXISTS uzytkownicy;


CREATE TABLE uzytkownicy(
			id  SERIAL PRIMARY KEY NOT NULL ,
			nazwa varchar(256) NOT NULL
			);

CREATE TABLE produkty(
			id  SERIAL PRIMARY KEY NOT NULL,
			nazwa varchar(256) NOT NULL
			);

CREATE TABLE przepisy(
			id  SERIAL PRIMARY KEY NOT NULL ,
			nazwa varchar(256) NOT NULL,
			przepis varchar(1024) NOT NULL,
			id_uzyt int4 REFERENCES uzytkownicy(id)
			);

INSERT INTO przepisy (nazwa,przepis) VALUES ('ser z grzybami', 'dodaj to to i to');



INSERT INTO produkty (nazwa) VALUES ('marchew');
INSERT INTO produkty (nazwa) VALUES ('ogórek');
INSERT INTO produkty (nazwa) VALUES ('ser');
INSERT INTO produkty (nazwa) VALUES ('twaróg');
INSERT INTO produkty (nazwa) VALUES ('mleko');
INSERT INTO produkty (nazwa) VALUES ('szynka');
INSERT INTO produkty (nazwa) VALUES ('śmietana');
INSERT INTO produkty (nazwa) VALUES ('jogurt');




CREATE TABLE polaczenie(
			id  SERIAL PRIMARY KEY NOT NULL ,
			id_prod int4 REFERENCES produkty(id),		
			id_przep int4 REFERENCES przepisy(id)
			);

CREATE TABLE historia(
			id  SERIAL PRIMARY KEY NOT NULL ,
			id_przep int4 REFERENCES przepisy(id),
			zmiana varchar(1024),
			id_uzyt int4 REFERENCES uzytkownicy(id),
			data timestamp
			);



INSERT INTO produkty (nazwa) VALUES ('');