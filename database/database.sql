
DROP SCHEMA IF EXISTS uniEuro CASCADE;

CREATE SCHEMA uniEuro;

CREATE TABLE uniEuro.corsoDiLaurea (
    id serial PRIMARY KEY,
    magistrale boolean NOT NULL,
    descrizione varchar (255) NOT NULL CHECK (descrizione != ''),
    nome varchar (255) not NULL (nome != '')
);


CREATE TABLE uniEuro.insegnamento (
    id serial PRIMARY KEY,
    nome varchar (255) not NULL (nome != ''),
    anno int not null (check anno >= 0 && anno < 5 ),
    -- qua dovrò fare un trigger, se la laurea è magistrale, l anno sarà solo 0 oppure 1
    cfu int not null (check cfu > 0 ),
    corsoDiLaurea serial FOREIGN KEY REFERENCES corsoDiLaurea(id),   -- le due foreign key devono essere not null ?
    docente serial FOREIGN KEY REFERENCES docenti(id)
);


CREATE TABLE uniEuro.utente (
    id serial PRIMARY KEY,
    email varchar NOT NULL CHECK (email != ''),           -- serve l id se già abbiamo l email che sarà per forza unica?
    pswrd varchar NOT NULL CHECK (pswrd != ''),
    nome varchar NOT NULL CHECK (nome != ''), 
    cognome varchar NOT NULL CHECK (cognome != '')
);


CREATE TABLE uniEuro.studente (
    matricola serial PRIMARY KEY,
    cdl serial NOT NULL FOREIGN KEY REFERENCES corsoDiLaurea(id),
    utente serial not null FOREIGN KEY REFERENCES utente(id)

);

CREATE TABLE uniEuro.docente (
    utente serial not null FOREIGN KEY REFERENCES utente(id),
    ufficioPerRicevimenti varchar not null check (ufficioPerRicevimenti != '')
    PRIMARY KEY(utente)
);


CREATE TABLE uniEuro.segreteria (
    utente serial not null FOREIGN KEY REFERENCES utente(id),
    indirizzo varchar not null check (indirizzo != ''),
    PRIMARY KEY(utente)
);


CREATE TABLE uniEuro.studenteEsame (
    studenteMatricola serial FOREIGN KEY REFERENCES studente(matricola),
    esame serial FOREIGN KEY REFERENCES appello(id),
    voto int NOT NULL,
    PRIMARY KEY(studenteMatricola, esame)
);


CREATE TABLE uniEuro.appello (
    esame serial NOT NULL FOREIGN KEY REFERENCES insegnamento(id),
    giorno date NOT NULL,
    PRIMARY KEY(esame)
    -- propedeucità serial FOREIGN key references appello(esame)
)


CREATE TABLE uniEuro.propedeuticità (   -- mi servono i delete cascade??
    insegnamento int NOT NULL, -- discreto
    propedeuticoA int NOT NULL, --ricerca operativa
    FOREIGN KEY(insegnamento) REFERENCES uniEuro.appello(esame) ON DELETE CASCADE,
    FOREIGN KEY(insegnamento_con_propedeuticita) REFERENCES uniEuro.appello(esame) ON DELETE CASCADE,
    PRIMARY KEY(insegnamento, insegnamento_con_propedeuticita)
);


-- STORICI    STUDENTI E VOTI             (tabella storico o attributo??)

CREATE TABLE uniEuro.storicoStudenti(
    matricola serial PRIMARY KEY,
    cdl serial NOT NULL FOREIGN KEY REFERENCES corsoDiLaurea(id),
    -- utente serial not null FOREIGN KEY REFERENCES utente(id),

    id serial PRIMARY KEY,
    email varchar NOT NULL CHECK (email != ''),     
    pswrd varchar NOT NULL CHECK (pswrd != ''),
    nome varchar NOT NULL CHECK (nome != ''), 
    cognome varchar NOT NULL CHECK (cognome != '')
)


CREATE TABLE uniEuro.storicoVoti(
    studenteMatricola serial FOREIGN KEY REFERENCES studente(matricola),  -- prendo dalla tabella studente o storico studente?
    esame serial FOREIGN KEY REFERENCES appello(id),
    voto int NOT NULL,
    PRIMARY KEY(studenteMatricola, esame)
)



