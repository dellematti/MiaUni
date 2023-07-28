
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


CREATE TABLE uniEuro.appelli (
    esame serial NOT NULL  REFERENCES uniEuro.insegnamenti(id),
    giorno date NOT NULL,
    PRIMARY KEY(esame)
    -- propedeucità serial FOREIGN key references appello(esame)
);


CREATE TABLE uniEuro.studentiEsami (
    studenteMatricola serial  REFERENCES uniEuro.studenti(matricola),
    esame serial  REFERENCES uniEuro.appelli(esame),
    voto int NOT NULL,
    PRIMARY KEY(studenteMatricola, esame)
);





CREATE TABLE uniEuro.propedeuticità (   -- mi servono i delete cascade??
    insegnamento int NOT NULL, -- discreto
    propedeuticoA int NOT NULL, --ricerca operativa
    FOREIGN KEY(insegnamento) REFERENCES uniEuro.appelli(esame) ON DELETE CASCADE,
    FOREIGN KEY(propedeuticoA) REFERENCES uniEuro.appelli(esame) ON DELETE CASCADE,
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
    esame serial  REFERENCES uniEuro.appelli(esame),
    voto int NOT NULL,
    PRIMARY KEY(studenteMatricola, esame)
);





