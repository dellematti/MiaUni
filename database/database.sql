
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

CREATE TABLE uniEuro.docente (
    id serial PRIMARY KEY,
);



