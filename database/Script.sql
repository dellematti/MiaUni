
DROP SCHEMA IF EXISTS uniEuro CASCADE;

CREATE SCHEMA uniEuro;

CREATE TABLE uniEuro.corsiDiLaurea (
    id serial PRIMARY KEY,
    magistrale boolean NOT NULL,
    descrizione varchar NOT NULL CHECK (descrizione != ''),
    nome varchar NOT  NULL CHECK  (nome != '')
);



CREATE TABLE uniEuro.utenti (
    id serial PRIMARY KEY,
    email varchar NOT NULL CHECK (email != ''),           -- serve l id se già abbiamo l email che sarà per forza unica?
    pswrd varchar NOT NULL CHECK (pswrd != ''),
    nome varchar NOT NULL CHECK (nome != ''), 
    cognome varchar NOT NULL CHECK (cognome != '')
);


CREATE TABLE uniEuro.studenti (
    matricola serial PRIMARY KEY,
    cdl serial NOT NULL  REFERENCES uniEuro.corsiDiLaurea(id),
    utente serial not null REFERENCES uniEuro.utenti(id)
);

CREATE TABLE uniEuro.docenti (
    utente serial not null REFERENCES uniEuro.utenti(id),
    ufficioPerRicevimenti varchar not null check (ufficioPerRicevimenti != ''),
    PRIMARY KEY(utente)
);


CREATE TABLE uniEuro.segreteria (
    utente serial not null  REFERENCES uniEuro.utenti(id),
    indirizzo varchar not null check (indirizzo != ''),
    PRIMARY KEY(utente)
);



CREATE TABLE uniEuro.insegnamenti (
    id serial PRIMARY KEY,
    nome varchar (255) not NULL check (nome != ''),
    anno int not NULL check ( anno >= 0 and anno < 5 ),
    -- qua dovrò fare un trigger, se la laurea è magistrale, l anno sarà solo 0 oppure 1
    cfu int not NULL check ( cfu > 0 ),
    corsoDiLaurea serial  REFERENCES uniEuro.corsiDiLaurea(id),   -- le due foreign key devono essere not null ?
    docente serial REFERENCES uniEuro.docenti(utente)
);


CREATE TABLE uniEuro.appelli (     -- potrei non avere appello_id perche ogni record viene identificato univocamente da insegnamento e data
	appello_id serial PRIMARY KEY ,  -- pero se dovessi avere due appelli della stessa materia lo stesso giorno ho un problema
    insegnamento_id serial NOT NULL  REFERENCES uniEuro.insegnamenti(id),
    giorno date NOT NULL         --
    -- propedeucità serial FOREIGN key references appello(esame)
);


CREATE TABLE uniEuro.studentiEsami (
    studenteMatricola serial  REFERENCES uniEuro.studenti(matricola),
    appello_id serial  REFERENCES uniEuro.appelli(appello_id),
    voto int ,
    PRIMARY KEY(studenteMatricola, appello_id)
);





CREATE TABLE uniEuro.propedeuticità (   -- mi servono i delete cascade??
    insegnamento int NOT NULL, -- discreto
    propedeuticoA int NOT NULL, --ricerca operativa
    --FOREIGN KEY(insegnamento) REFERENCES uniEuro.appelli(insegnamento_id) ON DELETE CASCADE,  --e non appello_id
    --FOREIGN KEY(propedeuticoA) REFERENCES uniEuro.appelli(insegnamento_id) ON DELETE CASCADE,  -- potevo farlo collegare direttamente alla tabella insegnamento
    FOREIGN KEY(insegnamento) REFERENCES uniEuro.insegnamenti(id) ON DELETE CASCADE,  --e non appello_id
    FOREIGN KEY(propedeuticoA) REFERENCES uniEuro.insegnamenti(id) ON DELETE CASCADE,  
   PRIMARY KEY(insegnamento, propedeuticoA)
);


-- STORICI    STUDENTI E VOTI             (tabella storico o attributo??)

CREATE TABLE uniEuro.storicoStudenti(
    matricola serial PRIMARY KEY,
    cdl serial NOT NULL  REFERENCES uniEuro.corsiDiLaurea(id),
    -- utente serial not null FOREIGN KEY REFERENCES utente(id),

    email varchar NOT NULL CHECK (email != ''),     
    pswrd varchar NOT NULL CHECK (pswrd != ''),
    nome varchar NOT NULL CHECK (nome != ''), 
    cognome varchar NOT NULL CHECK (cognome != '')
);


CREATE TABLE uniEuro.storicoVoti(
    studenteMatricola serial  REFERENCES uniEuro.studenti(matricola),  -- prendo dalla tabella studente o storico studente?
    appello_id serial  REFERENCES uniEuro.appelli(appello_id),
    voto int NOT NULL,
    PRIMARY KEY(studenteMatricola, appello_id)
);


-- ORA METTO UN PO DI RECORD A CASO PER PROVARE IL DATABASE



INSERT INTO unieuro.utenti 
VALUES (1, 'mattia.delledonne@studenti.unimi.it', 'password', 'mattia', 'delledonne');



INSERT INTO unieuro.corsidilaurea 
VALUES (127, FALSE, 'Laurea triennale
180 Crediti
Accesso Programmato
3 Anni
Sede Milano
Lingua Italiano', 'Informatica');

INSERT INTO unieuro.studenti 
VALUES (987180, 127, 1);     -- 127 è l id del corso di laurea di informatica,   1 invece è l id dell utente



SELECT *
FROM unieuro.studenti AS s
INNER JOIN unieuro.utenti AS u ON s.utente = u.id ;      -- così ottengo tutte le informazioni di uno studente


INSERT INTO unieuro.utenti 
VALUES (2, 'giovanni.pighizzini@docenti.unimi.it', 'password', 'Giovanni', 'Pighizzini');


INSERT INTO unieuro.docenti 
VALUES (2, 'Via Celoria 18 quinto piano');


INSERT INTO unieuro.insegnamenti 
VALUES (1, 'Algoritmi e strutture dati', 2, 12, 127, 2); -- 2 anno, 12 cfu, cdl 127, il docente è l utente 4



INSERT INTO unieuro.appelli 
VALUES (1, 1, to_date('05-03-2023','dd-mm-yyyy'));    -- il primo 1 è l id dell appello, il secondo 1 è l id dell insegnamento    ogni insegnamento ha diversi appelli identificati dall id
                                                      -- IMPORTANTE l id dell appello è unico indipendentemente dalla materia; NON esiste appello con id=1 sia in algoritmi che in prog

INSERT INTO unieuro.studentiesami 
VALUES ( 987180, 1  );              -- metto la matricola e l id dell appello


-- se ora voglio vedere tutti gli esami di mattia delle donne:
SELECT se.studentematricola , a.giorno , i.nome , i.cfu, se.voto  -- per ora seleziono solo questo, potrei selezionare altro come l anno, cdl,... 
FROM unieuro.studentiesami  AS se
INNER JOIN unieuro.appelli AS a ON a.appello_id = se.appello_id  -- Joino il risultato con l appello 
INNER JOIN unieuro.insegnamenti AS i ON a.insegnamento_id = i.id -- e joino tutto con gli insegnamenti
WHERE se.studentematricola = 987180;


--query per avere la matricola dall email studente 
SELECT u.nome , u.cognome , u.email , s.matricola , c.nome ,c.magistrale 
FROM unieuro.utenti AS u
INNER JOIN unieuro.studenti AS s ON s.utente = u.id
INNER JOIN unieuro.corsidilaurea AS c ON s.cdl = c.id 
WHERE u.email ='mattia.delledonne@studenti.unimi.it' ;



-- metto un utente della segreteria
INSERT INTO unieuro.utenti 
VALUES (3, 'luigi.pepe@segreteria.unimi.it', 'password', 'Luigi', 'Pepe');

INSERT INTO unieuro.segreteria 
VALUES (3, 'Via Celoria 18');


--devo trovare tutti i cdl
SELECT c.nome, c.id 
FROM unieuro.corsidilaurea AS c;








-- FUNZIONI DOCENTE



-- FUNZIONI PER REGISTRARE UN VOTO DI UNO STUDENTE, PER UN PARTICOLARE APPELLO DEL DOCENTE 


-- funzione che restituisce tutti gli appelli, di un determinato docente identificato dal suo id

CREATE OR REPLACE FUNCTION unieuro.get_appelli_docente (
  id_docente integer     -- id_docente è il parametro che riceve
)
RETURNS TABLE (
	appello_id integer,
    giorno date,
    nome varchar (20), 
    magistrale boolean,
    nome_cdl varchar(30)
    -- a.appello_id, a.giorno, i.nome,c.magistrale,  c.nome
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
    SELECT a.appello_id, a.giorno, i.nome,c.magistrale,  c.nome as cdl
    FROM unieuro.appelli AS a
    INNER JOIN unieuro.insegnamenti as i
    ON a.insegnamento_id = i.id
    INNER JOIN unieuro.corsidilaurea as c
    ON i.corsodilaurea = c.id
    WHERE i.docente = id_docente;
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_appelli_docente(2);





-- funzione che restituisce tutti gli studenti
-- (non restituisco solo gli studenti del corso di laurea dell esame, perchè uno studente di informatica può iscriversi ad esempio a un esame di matematica)
CREATE OR REPLACE FUNCTION unieuro.get_studenti ( )
RETURNS TABLE (
	matricola integer,
    nome varchar (30), 
    cognome varchar(30)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
    SELECT s.matricola, u.nome, u.cognome
    FROM unieuro.studenti AS s
    INNER JOIN unieuro.utenti as u
    ON s.utente = u.id ;
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_studenti();





-- quando uno studente si iscrive ad un appello, inserisce un record nella tabella studentiesami, lasciando null l attributo voto, sarà
-- poi il docente a modificare quel record aggiungendo il voto

-- aggiungo il voto dello studente ad un determinato appello 
CREATE PROCEDURE inserire_voto ( matricola integer, appello integer, voto_esame integer)
LANGUAGE SQL
AS $$
UPDATE unieuro.studentiesami 
SET voto = voto_esame
WHERE studentematricola = matricola AND appello_id = appello;
$$;
--CALL inserire_voto ( parametri );

-- trigger in cui controllo che il record sia effettivamente senza voto 
CREATE TRIGGER voto_già_presente BEFORE UPDATE ON unieuro.studentiesami 
FOR EACH ROW
BEGIN
        IF old.voto IS NOT NULL THEN
        	--raise_application_error(-20111,'Can''t change the city for this supplier!');
                end;
        END IF;
END;//






CREATE OR REPLACE FUNCTION unieuro.controlla_voto_già_presente () 








