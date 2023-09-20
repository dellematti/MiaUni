
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
    cfu int not NULL check ( cfu > 0 and cfu <=  30  ),
    corsoDiLaurea serial  REFERENCES uniEuro.corsiDiLaurea(id),   -- le due foreign key devono essere not null ?
    docente serial REFERENCES uniEuro.docenti(utente)
);

ALTER TABLE unieuro.insegnamenti 
ADD CHECK (cfu > 0 AND cfu <= 30);

CREATE TABLE uniEuro.appelli (     -- potrei non avere appello_id perche ogni record viene identificato univocamente da insegnamento e data
	appello_id serial PRIMARY KEY ,  -- pero se dovessi avere due appelli della stessa materia lo stesso giorno ho un problema
    insegnamento_id serial NOT NULL  REFERENCES uniEuro.insegnamenti(id),
    giorno date NOT NULL         --
    -- propedeucità serial FOREIGN key references appello(esame)
);


CREATE TABLE  uniEuro.studentiEsami (
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
    studenteMatricola serial  REFERENCES uniEuro.storicoStudenti(matricola),  -- prendo dalla tabella studente o storico studente?
    appello_id serial  REFERENCES uniEuro.appelli(appello_id),
    voto int NOT NULL,
    PRIMARY KEY(studenteMatricola, appello_id)
);

/*
ALTER TABLE uniEuro.storicoVoti
DROP CONSTRAINT storicovoti_studentematricola_fkey;
ALTER TABLE uniEuro.storicoVoti
ADD FOREIGN KEY (studentematricola) REFERENCES unieuro.storicoStudenti(matricola);
*/



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

CALL inserire_voto ( parametri );

-- trigger in cui controllo che il record sia effettivamente senza voto 
CREATE TRIGGER voto_già_presente BEFORE UPDATE ON unieuro.studentiesami 
FOR EACH ROW
BEGIN
        IF old.voto IS NOT NULL THEN
        	--raise_application_error(-20111,'Can''t change the city for this supplier!');
                end;
        END IF;
END;//



create or replace trigger voto_già_presente
      before update on unieuro.studentiesami
      for each row
    declare
      valore_voto number;
    begin
      select voto
        INTO valore_voto
        from unieuro.studentiesami s
      where s.matricola = :new.s.matricola;
 
     if valore_voto IS NOT null then
        raise_application_error(-20000, 'Update table failed. Row to be update is not found.');
     end if;
   end;
 




--                                     CONTROLLARE IL TRIGGER PRECEDENTE !!!!!!! non va ancora bene   !!!!!
 


  
  
  
  
  --                               STUDENTE
  
  
  -- ISCRIZIONE ESAMI
  
  
  
  
  -- restituisce tutti gli appelli del corso di laurea dello studente  
CREATE OR REPLACE FUNCTION unieuro.get_appelli_studente ( matricola_studente integer )
RETURNS TABLE (
	appello_id integer,
    nome varchar (255),
    giorno date 
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
  SELECT a.appello_id , i.nome, a.giorno     -- IMPORTANTE selezionare qua i parametri da restituire e non mettere *, a meno che non li restituisca tutti
  FROM unieuro.appelli a 
  INNER JOIN unieuro.insegnamenti i 
  ON a.insegnamento_id = i.id 
  WHERE i.corsodilaurea = (        
  	SELECT s.cdl 
  	FROM unieuro.studenti s 
  	WHERE s.matricola = matricola_studente
  );
	 END;
 $$;
-- per provare la funzione
select appello_id, nome, giorno from unieuro.get_appelli_studente(987180);




  -- restituisce tutti gli appelli di corsi di laurea diversi da quello dello studente 
CREATE OR REPLACE FUNCTION unieuro.get_appelli_cdl_non_studente ( matricola_studente integer )
RETURNS TABLE (
	appello_id integer,
    nome varchar (255),
    giorno date ,
    cdl varchar (50)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
  SELECT a.appello_id , i.nome, a.giorno, c.nome AS cdl     -- IMPORTANTE selezionare qua i parametri da restituire e non mettere *, a meno che non li restituisca tutti
  FROM unieuro.appelli a 
  INNER JOIN unieuro.insegnamenti i 
  ON a.insegnamento_id = i.id 
  INNER JOIN unieuro.corsidilaurea c 
  ON i.corsodilaurea = c.id 
  WHERE i.corsodilaurea != (        
  	SELECT s.cdl 
  	FROM unieuro.studenti s 
  	WHERE s.matricola = 987180
  );
	 END;
 $$;

-- per provare la funzione
select appello_id, nome, giorno, cdl from unieuro.get_appelli_cdl_non_studente(987180);
  



-- funzione che restituisce la matricola di uno studente,dato il suo codice id
CREATE OR REPLACE FUNCTION unieuro.get_matricola_studente ( id_utente integer )
RETURNS TABLE (
	    cdl varchar (50)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
SELECT s.matricola 
FROM unieuro.studenti s 
INNER JOIN unieuro.utenti u 
ON s.utente = u.id 
WHERE u.id = id_utente;
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_matricola_studente(1);
  



-- procedura per iscrivere uno studente ad un determinato appello
CREATE PROCEDURE iscrizione_appello ( matricola integer, appello integer)
LANGUAGE SQL
AS $$
     INSERT INTO unieuro.studentiesami
          (                    
            studentematricola,
            appello_id    
          ) 
     VALUES 
          ( 
            matricola,
            appello
          ) 
$$;







-- CARRIERA STUDENTE

--funzione che restituisce tutti gli esami sostenuti da uno studente (esami con esito >= 18)    -- mi serve ora che ho le altre due' (carriera completa e parz)
CREATE OR REPLACE FUNCTION unieuro.get_esami_studente ( matricola_studente integer )
RETURNS TABLE (
	nome varchar (50),
	cfu integer,
	giorno date, 
	voto integer
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
SELECT i.nome , i.cfu , a.giorno , s.voto 
FROM unieuro.studentiesami s 
INNER JOIN unieuro.appelli a 
ON s.appello_id = a.appello_id 
INNER JOIN unieuro.insegnamenti i 
ON a.insegnamento_id = i.id 
WHERE s.studentematricola = matricola_studente AND 
	s.voto >= 18;
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_esami_studente(987180);
-- devo pensare a come fare se uno studente ha un voto insufficiente, o non viene segnato, oppure :
-- il docente mette il voto cosi come, se il voto è minore di 18 lo studente può iscriversi nuovamente all appello (in pratica cancella il voto)








--                                                                      SEGRETERIA 

--                                                                          GESTIONE UTENTI

--restituisce tutti gli utenti
CREATE OR REPLACE FUNCTION unieuro.get_utenti ( )
RETURNS TABLE (
	id_utente integer,
    nome varchar (30), 
    cognome varchar(30)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
    SELECT u.id , u.nome, u.cognome
    FROM unieuro.utenti as u;
	 END;
 $$;
-- se volessi anche far vedere se l utente è studente docente o segreteria, potrei aggiungnere nella query dei where not exists, se l utente
-- non esiste nella tabella docenti e segreteria allora è studente

-- per provare la funzione
select * from unieuro.get_utenti();



--restituisce tutti gli utenti non della segreteria
CREATE OR REPLACE FUNCTION unieuro.get_utenti_non_segreteria ( )
RETURNS TABLE (
	id_utente integer,
    nome varchar (30), 
    cognome varchar(30)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
    SELECT u.id , u.nome, u.cognome
    FROM unieuro.utenti as u
   	WHERE NOT EXISTS (
   		SELECT *
   		FROM unieuro.segreteria s
   		WHERE s.utente = u.id 
   	);
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_utenti_non_segreteria();
-- se volessi anche far vedere se l utente è studente docente o segreteria, potrei aggiungnere nella query dei where not exists, se l utente
-- non esiste nella tabella docenti e segreteria allora è studente





-- nella procedura che cancella un utente, potrei mandare in input il codice utente, per controllare che un utente non possa eliminare se stesso

-- procedura che cancella un utente 
CREATE OR REPLACE PROCEDURE cancella_utente ( id_utente integer)
AS $$  
BEGIN 
	
	DELETE FROM unieuro.segreteria se                                            -- PROCEDURA CON PiU QUERY, SINTASSI DIVERSA
	WHERE se.utente = id_utente;

	DELETE FROM unieuro.docenti d                                            
	WHERE d.utente  = id_utente;


	DELETE FROM unieuro.studenti s                                            
	WHERE s.utente = id_utente;
	
	DELETE FROM unieuro.utenti u
	WHERE u.id = id_utente ;

END;
$$ LANGUAGE plpgsql;
-- prova
CALL cancella_utente ( 6 );








	                                                        -- TRIGGER


-- 1 )
-- storico studenti ed esami
-- quando uno studente viene cancellato, per prima cosa (appena prima di cancellarlo) devo selezionare le sue informazioni ed inserirle nella tabella
-- storico studenti. Dopo aver fatto questo devo selezionare tutti gli esami della matricola che ho appena spostato,e inserirli nella tabella
-- storico esami, devo subito dopo cancellare gli esami dalla tabella studentiesami.
-- FARE ATTENZIONE A COME VIENE ASSEGNATA LA MATRICOLA E L ID UTENTE, DOVRO' TENERE IN CONSIDERAZIONE ANCHE LO STORICO STUDENTI !!!!!!

	CREATE TRIGGER trasferimenti_negli_storico BEFORE DELETE ON unieuro.studenti  
	FOR EACH ROW EXECUTE FUNCTION unieuro.sposta_negli_storici();

	-- DROP TRIGGER trasferimenti_negli_storico ON unieuro.studenti;

	CREATE OR REPLACE FUNCTION unieuro.sposta_negli_storici()
	   RETURNS TRIGGER 
	   LANGUAGE PLPGSQL
	AS $$
	BEGIN

		     INSERT INTO unieuro.storicostudenti 
         -- ( matricola,  cdl, email, pswrd , nome, cognome ) 
    -- VALUES 
     --     ( 
          SELECT s.matricola , s.cdl , u.email , u.pswrd ,u.nome , u.cognome 
          FROM unieuro.utenti u
          INNER JOIN unieuro.studenti s 
          ON s.utente = u.id 
          WHERE s.matricola = OLD.matricola;
     --     ) 
         
         -- ora metto studentiesami in storicovoti, poi dopo potrò cancellare lo studente e l utente
         INSERT INTO unieuro.storicovoti 
         SELECT *
         FROM unieuro.studentiesami s
         WHERE s.studentematricola = OLD.matricola AND s.voto IS NOT NULL ;
        
        DELETE FROM unieuro.studentiesami s
        WHERE s.studentematricola = OLD.matricola; 
         



	RETURN OLD ;
	END;
	$$
	
	

-- 2 )
-- Correttezza delle iscrizioni agli esami. 
-- controllo che lo studente abbia passato gli insegnamenti propedeutici a quello a cui si iscrive, (e controllo che sia del cdl giusto)

	CREATE TRIGGER controllaPropedeuticità BEFORE INSERT ON unieuro.studentiesami  
	FOR EACH ROW EXECUTE FUNCTION unieuro.controlla_esami_propedeutici();


	CREATE OR REPLACE FUNCTION unieuro.controlla_esami_propedeutici()
	   RETURNS TRIGGER 
	   LANGUAGE PLPGSQL
	AS $$
	BEGIN
		IF EXISTS (
			SELECT DISTINCT p.insegnamento      -- seleziono gli insegnamenti propedeutici rispetto a quello dell appello a cui lo studente si iscrive
			FROM unieuro.studentiesami s 
			INNER JOIN unieuro.appelli a 
			--ON s.appello_id = a.appello_id      
			ON NEW.appello_id = a.appello_id    
			INNER JOIN unieuro.insegnamenti i   
			ON a.insegnamento_id = i.id 
			INNER JOIN unieuro.propedeuticità p 
			ON i.id = p.propedeuticoa
			WHERE NOT EXISTS (                    -- cerco quelli passati dallo studente
				SELECT DISTINCT i2.id  
				FROM unieuro.studentiesami s2 
				INNER JOIN unieuro.appelli a 
				ON s2.appello_id = a.appello_id 
				INNER JOIN unieuro.insegnamenti i2 
				ON a.insegnamento_id = i2.id 
				WHERE s2.studentematricola = NEW.studentematricola AND  
				s2.voto >= 18 AND i2.id = p.insegnamento        
			)
		)
		THEN 
	raise exception 'Lo studente non ha passato gli esami propedeutici per potersi iscrivere a questo appello';  
	END IF ;


	-- ora controllo che sia il cdl dello studente 
	IF NOT EXISTS (
		SELECT s.cdl                               -- seleziono solo il cdl dello studente , se 
		FROM unieuro.studenti s
		WHERE s.matricola = NEW.studentematricola AND s.cdl = (
			SELECT i.corsodilaurea                 -- s.cdl è uguale al cdl dell esame a cui mi iscrivo
			FROM unieuro.appelli a 
			INNER JOIN unieuro.insegnamenti i 
			ON a.insegnamento_id = i.id 
			WHERE a.appello_id  = NEW.appello_id
			)
	) THEN  raise exception 'L esame non è del cdl dello studente';  
	END IF ;
	-- fine corpo trigger
	RETURN NEW ;
	END;
	$$
	
		


-- 3 )
-- Correttezza del calendario d’esame. Non `e possibile programmare, nella stessa giornata, appelli 
-- per più esami dello stesso anno di un corso di laurea.

	CREATE TRIGGER controllaAppelli BEFORE INSERT ON unieuro.appelli 
	FOR EACH ROW EXECUTE FUNCTION unieuro.controlla_appelli_stesso_cdl();


	CREATE OR REPLACE FUNCTION unieuro.controlla_appelli_stesso_cdl()
	   RETURNS TRIGGER 
	   LANGUAGE PLPGSQL
	AS $$
	BEGIN
	   -- trigger logic
			IF EXISTS (
		SELECT *
		FROM unieuro.appelli a
		INNER JOIN unieuro.insegnamenti i 
		ON a.insegnamento_id = i.id 
		WHERE a.giorno = NEW.giorno AND
		i.corsodilaurea = ( -- ora devo trovare il corso di laurea del nuovo appello 
			SELECT c.id 
			FROM unieuro.corsidilaurea c 
			INNER JOIN unieuro.insegnamenti i2
			ON i2.corsodilaurea = c.id 
			WHERE i2.id = NEW.insegnamento_id
		)
	) THEN 
	raise exception 'Esiste già un appello dello stesso cdl in quella data';  
	END IF ;
	-- fine corpo trigger

	RETURN NEW ;

	END;
	$$



	
	
-- 4 )
-- • Produzione della carriera completa di uno studente.

CREATE OR REPLACE FUNCTION unieuro.get_carriera_completa_studente (matricola integer )
RETURNS TABLE (
	corso varchar (100), 
	giorno date,
	voto integer,
	cfu integer
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome, a.giorno, s.voto   , i.cfu 
			FROM unieuro.studentiesami s 
			INNER JOIN unieuro.appelli a 
			ON s.appello_id = a.appello_id 
			INNER JOIN unieuro.insegnamenti i 
			ON a.insegnamento_id = i.id 
			WHERE s.studentematricola = matricola AND 
			s.voto  IS NOT null;
   END;
 $$;

SELECT * FROM unieuro.get_carriera_completa_studente(987180);




-- 5 )
-- • Produzione della carriera valida di uno studente. (cioè solo voti sufficienti, e in caso di esami ridati mostro solo l ultimo)

CREATE OR REPLACE FUNCTION unieuro.get_carriera_valida_studente ( matricola integer )
RETURNS TABLE (
	corso varchar (100), 
	giorno date,
	voto integer,
	cfu integer
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome, a.giorno, s.voto   , i.cfu 
			FROM unieuro.studentiesami s 
			INNER JOIN unieuro.appelli a 
			ON s.appello_id = a.appello_id 
			INNER JOIN unieuro.insegnamenti i 
			ON a.insegnamento_id = i.id 
			WHERE s.studentematricola = matricola AND 
			s.voto  >= 18 AND NOT EXISTS (
				SELECT i2.nome, a2.giorno, s2.voto   , i2.cfu 
				FROM unieuro.studentiesami s2 
				INNER JOIN unieuro.appelli a2 
				ON s2.appello_id = a2.appello_id 
				INNER JOIN unieuro.insegnamenti i2 
				ON a2.insegnamento_id = i2.id 
				WHERE s2.studentematricola = matricola AND s.voto >=18 AND 
				i2.nome = i.nome AND a2.giorno > a.giorno
			);
   END;
 $$;

SELECT * FROM unieuro.get_carriera_valida_studente(987180);






-- 6 )
-- • Produzione delle informazioni su un corso di laurea.  (corso - descrizione- docente)

CREATE OR REPLACE FUNCTION unieuro.get_informazioni_cdl (cdl integer )
RETURNS TABLE (
	nome varchar (100), 
	id integer,
	cfu integer,
	docente_nome varchar (50),
	docente_cognome varchar (50),
	email varchar (50)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome, i.id , i.cfu , u.nome , u.cognome , u.email  
			FROM unieuro.insegnamenti i
			INNER JOIN unieuro.docenti d 
			ON i.docente  = d.utente
			INNER JOIN unieuro.utenti u 
			ON d.utente = u.id 
			WHERE i.corsodilaurea = cdl;
   END;
 $$;

SELECT * FROM unieuro.get_informazioni_cdl(127);




--                                                                            altre funzioni


-- funzione che restituisce tutti i corsi di laurea erogati dall ateneo
CREATE OR REPLACE FUNCTION unieuro.get_corsi_di_laurea ( )
RETURNS TABLE (
	nome varchar (100), 
	magistrale boolean,
	descrizione varchar (250),
	id integer
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT c.nome, c.magistrale, c.descrizione, c.id 
			FROM unieuro.corsidilaurea c ;
   END;
 $$;

SELECT * FROM unieuro.get_corsi_di_laurea();







-- funzione che restituisce la media di uno studente
CREATE OR REPLACE FUNCTION unieuro.get_media_studente ( matricola integer )
RETURNS TABLE (
	    media float
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT   CAST( sum (voto*cfu)   AS float )  /  CAST ( sum(cfu)  AS float )  AS media  FROM unieuro.get_carriera_valida_studente(matricola);		
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_media_studente(987180);
  



-- funzione che restituisce i CFU di uno studente
CREATE OR REPLACE FUNCTION unieuro.get_cfu_studente ( matricola integer )
RETURNS TABLE (
	    cfuTotali int8
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT   sum(cfu)  AS cfuTotali  FROM unieuro.get_carriera_valida_studente(matricola);		
	 END;
 $$;
-- per provare la funzione
select * from unieuro.get_cfu_studente(987180);





-- funzione che restituisce tutti gli esami che uno studente deve ancora svolgere
CREATE OR REPLACE FUNCTION unieuro.get_esami_mancanti ( matricola_studente integer )
RETURNS TABLE (
	    nome varchar (50) 
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome
			FROM unieuro.insegnamenti i 
			WHERE i.corsodilaurea = (
				SELECT s.cdl 
				FROM unieuro.studenti s 
				WHERE s.matricola = matricola_studente
			) EXCEPT (            --sarebbe meglio fare l EXCEPT basandomi sul id del insegnamento e NON sul nome
				SELECT corso FROM unieuro.get_carriera_valida_studente(matricola_studente)
			);
	 END;
 $$;

SELECT * FROM unieuro.get_esami_mancanti(987180);




-- procedura che modifica la password dell utente, (riceve anche la password da modificare e controlla sia corretta)
CREATE OR REPLACE PROCEDURE modifica_password ( utente integer, password_precedente varchar (40), password_nuova varchar (40)  )
--LANGUAGE SQL
LANGUAGE plpgsql
AS $$
BEGIN 
	IF EXISTS (
		SELECT *
		FROM unieuro.utenti u 
		WHERE u.id = utente AND u.pswrd = password_precedente
	) THEN 
		UPDATE  unieuro.utenti 
		SET pswrd = password_nuova
		WHERE id = utente;
		-- WHERE u.id = utente;
	
	END IF;
END ;
$$;

CALL modifica_password ( 1, 'password1', 'password'  );




-- funzione che restituisce true se la matricola è iscritta ad un determinato appello
CREATE OR REPLACE FUNCTION unieuro.iscrizione_appello_presente ( matricola integer, appello integer )
RETURNS boolean
LANGUAGE plpgsql
AS $$
	begin
		RETURN EXISTS (
			SELECT *
			FROM unieuro.studentiesami s
			WHERE s.studentematricola = matricola AND s.appello_id = appello
		) ;
	END;
 $$;

SELECT * FROM unieuro.iscrizione_appello_presente(2, 3); -- si
SELECT * FROM unieuro.iscrizione_appello_presente(2, 6); -- si
SELECT * FROM unieuro.iscrizione_appello_presente(2, 4); -- no





-- funzione che restituisce true se la matricola ha un voto in un determinato appello
CREATE OR REPLACE FUNCTION unieuro.voto_appello_presente ( matricola integer, appello integer )
RETURNS boolean
LANGUAGE plpgsql
AS $$
	begin
		RETURN EXISTS (
			SELECT *
			FROM unieuro.studentiesami s
			WHERE s.studentematricola = matricola AND s.appello_id = appello
			    AND s.voto IS NOT null
		) ;
	END;
 $$;

SELECT * FROM unieuro.voto_appello_presente(2, 6);




-- funzione che restituisce tutti gli studenti presenti all interno dello storico studenti
CREATE OR REPLACE FUNCTION unieuro.get_storico_studenti ( )
RETURNS TABLE (
	    nome varchar (50),
	    cognome varchar (50),
	    matricola integer,
	    corso_di_laurea varchar(50),
	    magistrale boolean
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT s.nome , s.cognome , s.matricola , c.nome , c.magistrale 
			FROM unieuro.storicostudenti s 
			INNER JOIN unieuro.corsidilaurea c 
			ON s.cdl = c.id ;
	 END;
 $$;

SELECT * FROM unieuro.get_storico_studenti();



-- funzione che restituisce i voti di un ex studente ( i voti sono presenti nello storico voti)
CREATE OR REPLACE FUNCTION unieuro.get_storico_voti (matricola integer )
RETURNS TABLE (
	    corso varchar (50),
	    voto integer,
	    giorno date,
	    cfu integer,
	    nome varchar (50),
	    cognome varchar (50),
	    email varchar (50)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome , s.voto ,a.giorno , i.cfu, u.nome , u.cognome , u.email  
			FROM unieuro.storicovoti  s
			INNER JOIN unieuro.appelli a 
			ON s.appello_id = a.appello_id 
			INNER JOIN unieuro.insegnamenti i 
			ON a.insegnamento_id = i.id 
			INNER JOIN unieuro.docenti d 
			ON i.docente = d.utente 
			INNER JOIN unieuro.utenti u 
			ON d.utente = u.id 
			WHERE s.studentematricola = matricola ;
		
	 END;
 $$;

SELECT * FROM unieuro.get_storico_voti(2);

		




-- funzione che dato l' id di un insegnamento restituisce le relative informazioni
CREATE OR REPLACE FUNCTION unieuro.get_informazioni_insegnamento (insegnamento_id integer )
RETURNS TABLE (
	    nome varchar (50),
	    cfu integer,
	    corso_di_laurea varchar (50),
	    magistrale boolean,
	    nome_docente varchar (50),
	    cognome_docente varchar (50),
	    email varchar (50)
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome, i.cfu , c.nome AS corso_di_laurea, c.magistrale , u.nome , u.cognome , u.email 
			FROM unieuro.insegnamenti i 
			INNER JOIN unieuro.utenti u 
			ON i.docente = u.id
			INNER JOIN unieuro.corsidilaurea c 
			ON i.corsodilaurea = c.id
			WHERE i.id = insegnamento_id ;
	 END;
 $$;

 
SELECT * FROM unieuro.get_informazioni_insegnamento(4);




-- funzione che dato l id di un insegnamento restituisce le sue propedeuticità
CREATE OR REPLACE FUNCTION unieuro.get_propedeuticità_insegnamento (insegnamento_id integer )
RETURNS TABLE (
	    nome varchar (50),
	    id integer
)
LANGUAGE plpgsql
AS $$
	begin
		RETURN QUERY
			SELECT i.nome , i.id 
			FROM unieuro.propedeuticità p
			INNER JOIN unieuro.insegnamenti i 
			ON p.insegnamento = i.id 
			WHERE p.propedeuticoa = insegnamento_id;
	 END;
 $$;

SELECT * FROM unieuro.get_propedeuticità_insegnamento(4);



		
