# MiaUni

Relazione del progetto "Piattaforma per la gestione degli esami universitari", esami Base di dati 2022/ 2023.

L' applicazione ha lo scopo di gestire l' organizzazione di vari aspetti di un ateneo universitario, aspetti che riguardano:

- Utenti
- Corsi di laurea
- Insegnamenti
- Appelli
- Iscrizioni agli esami
- Risultati degli esami




Gli utenti che utilizzano l applicazione sono divisi in tre differenti categorie: studenti, docenti o segreteria. 
Tutti gli utenti possono vedere in ogni momento le informazioni sui vari corsi di laurea e insegnamenti erogati dall ateneo. Molte delle funzionalità
dell'applicazione dipendono invece dal tipo di utente dell account.

Gli studenti possono vedere la loro carriera universitaria, tutti gli esami passati, tutti gli esami svolti (esami ripetuti o con voto insufficente) , gli 
esami mancanti, la propria media e il numero di CFU ottenuti. 
Gli studenti possono inoltre iscriversi ad un appello e possono vedere le informazioni sul loro profilo.

I docenti possono aggiungere appelli di una delle materie che insegnano e possono mettere voti agli studenti che si sono iscritti agli appelli.

La segreteria ha invece diversi impieghi: il primo è quello della gestione degli utenti. Può aggiungere rimuovere utenti e può modificare 
le informazioni di quelli già esistenti. 
Se l' utente rimosso è uno studente, allora viene automaticamente inserito in un archivio (lo storico studenti) e vengono inseriti in un altro 
archivio (lo storico esami) anche tutti gli esiti di esame che ha avuto durante la sua carriera universitaria.
Un altro impiego della segreteria è quello di aggiungere corsi di laurea all' ateneo, e aggiungere insegnamenti per ogni corso di laurea.
Un utente della segreteria può infine consultare entrambi gli storici riguardanti gli ex studenti dell ateneo.\
Dato che sono gli utenti di segreteria gli unici a poter aggiungere utenti, il primo utente (di segreteria) viene aggiunto di default dal database.





### Schema ER

![ER](https://github.com/dellematti/unieuro/blob/main/Documentazione/Schema_ER.png)


- Utenti\
Lo schema presenta una gerarchia tra l' entità utente e le entità studente, docente e segreteria. Questo perchè tutti e tre i tipi possibili
di utente hanno alcune informazioni in comune che è comodo accorpare nell' entità padre utente. Nelle tre entità sono poi presenti
attributi unici all entità stessa.

- Esami\
La relazione 'Iscrizione' ha due utilità: viene inizialmente usata dallo studente per iscriversi all' appello, e viene in seguito modificata dal
professore per dare un voto allo studente.
Questo perché l attributo voto può avere valore null. I record vengono quindi inizialmente inseriti con solo la matricola dello studente e l' id dell' appello.
Verrà poi fatto un UPDATE nel momento in cui il docente vuole aggiungere il voto.
Dentro la tabella ogni record con valore voto diverso da null sarà quindi un esito (sufficiente o insufficente) dell' esame.

- Storici\
A differenza di 'Iscrizione', la relazione 'Storico esami' nella colonna 'voto' ha solo valori NOT NULL, e gli studenti a cui si 
riferisce ( le FOREIGN KEYS) sono studenti di storico studenti e non di studenti.
Nel momento in cui uno studente viene rimosso, un TRIGGER sposta le sue informazioni e tutti gli esami che ha svolto, nei relativi storici. 
Sposto prima lo studente nello storico studenti, poi l' esame nello storico esami e la colonna studente referenzia la chiave di storico studente.
In questo modo sono sicuro che tutti gli esami nello storico esami si riferiscono ad ex studenti.

- Appelli\
Negli appelli sono presenti sia quelli futuri, sia quelli passati. Si può usare la data dell' appello per poterli dividere tra le due categorie. Per
questo motivo sia lo storico esami, sia le iscrizioni utilizzano i record della tabella appelli senza dover dividere in due tabelle appelli futuri e
appelli passati. Ogni appello è in relazione con un particolare insegnamento utilizzando come FOREIGN KEY l id dell' insegnamento.


- Insegnamenti e corsi di laurea\
Ogni insegnamento è identificato da un id ed è in relazione con l' entità docenti (ogni insegnamento ha un unico docente) e con i corsi
di laurea (ogni insegnamento appartiene ad un unico corso di laurea). I corsi di laurea sono divisi tra triennale e magistrale utilizzando un
boolean con valore true se il corso è magistrale, e false se è triennale.

- Propedeuticità\
La relazione propedeuticità è una relazione ricorsiva che mette in relazione l' entità insegnamento con se stessa, ogni insegnamento
può essere propedeutico a diversi insegnamenti, e può a sua volta avere 0 o più propedeuticità.



### Schema logico

![Schema_Logico](https://github.com/dellematti/unieuro/blob/main/Documentazione/Schema_logico.png)




### Funzionalità database
DBMS utilizzato: PostgreSQL\
***Funzioni e procedure***\
Il database offre diverse funzioni e procedure:


- get_appelli_docente (id_docente integer)\
  Funzione che restituisce tutti gli appelli, di un determinato docente identificato dal suo id.
  
- get_studenti ()\
  Funzione che restituisce tutti gli studenti
  
- inserire_voto (matricola integer, appello integer, voto_esame integer)\
  Procedura che assegna un voto ad un esame svolto da uno studente.

- get_appelli_studente ( matricola_studente integer )\
  Funzione che restituisce tutti gli appelli del corso di laurea dello studente.

- get_appelli_cdl_non_studente ( matricola_studente integer )\
  Funzione che restituisce tutti gli appelli di corsi di laurea diversi da quello dello studente.

- get_matricola_studente ( id_utente integer )\
  Funzione che restituisce la matricola di uno studente,dato il suo codice id.

- iscrizione_appello ( matricola integer, appello integer)\
  Procedura per iscrivere uno studente ad un determinato appello.

- get_esami_studente ( matricola_studente integer )\
  Funzione che restituisce tutti gli esami sostenuti da uno studente (esami con esito >= 18).

- get_utenti ( )\
  Funzione che restituisce tutti gli utenti.

- get_utenti_non_segreteria ( )\
  Funzione che restituisce tutti gli utenti non della segreteria.

- cancella_utente ( id_utente integer)\
  Procedura che cancella un utente (cancellando sia le informazioni dalla tabella utente, sia le informazioni presenti in studente/docente/segreteria).

- get_carriera_completa_studente (matricola integer )\
  Funzione che restituisce la carriera completa di uno studente.

- get_carriera_valida_studente ( matricola integer )\
  Funzione che restituisce la carriera valida di uno studente. (cioè solo voti sufficienti, e in caso di esami ridati mostro solo l ultimo).

- get_informazioni_cdl (cdl integer )\
  Funzione che restituisce le le informazioni su un corso di laurea.  (corso - descrizione- docente).

- get_corsi_di_laurea ()\
  Funzione che restituisce tutti i corsi di laurea erogati dall ateneo.

- get_media_studente ( matricola integer )\
  Funzione che restituisce la media di uno studente.

- get_cfu_studente ( matricola integer )\
  Funzione che restituisce i CFU di uno studente.

- get_esami_mancanti ( matricola_studente integer )\
  Funzione che restituisce tutti gli esami che uno studente deve ancora svolgere.

- modifica_password ( utente integer, password_precedente varchar (40), password_nuova varchar (40))\
  procedura che modifica la password dell utente, (riceve anche la password da modificare e controlla sia corretta)\
  questa procedura sarà utilizzata dall utente e non dalla segreteria (la segreteria non dovrà controllare anche la password precedente)

- iscrizione_appello_presente ( matricola integer, appello integer )\
  Funzione che restituisce true se la matricola è iscritta ad un determinato appello.

- voto_appello_presente ( matricola integer, appello integer )\
  Funzione che restituisce true se la matricola ha un voto in un determinato appello.

- get_storico_studenti ( )\
  Funzione che restituisce tutti gli studenti presenti all' interno dello storico studenti.

- get_storico_voti (matricola integer )\
  Funzione che restituisce i voti di un ex studente ( i voti sono presenti nello storico voti).

- get_informazioni_insegnamento (insegnamento_id integer )\
  Funzione che dato l' id di un insegnamento restituisce le relative informazioni.

- get_propedeuticità_insegnamento (insegnamento_id integer )\
  Funzione che dato l' id di un insegnamento restituisce le sue propedeuticità.

- aggiungere_corso_di_laurea ( id_corso_di_laurea integer, magistrale boolean, descrizione varchar(1000), nome varchar(50) )\
  Procedura che inserisce un corso di laurea all' interno del database.

- aggiorna_nome ( id_utente integer, nuovo_nome varchar(50) )\
  Procedura che aggiorna il nome di un utente.

- aggiorna_cognome ( id_utente integer, nuovo_cognome varchar(50) )\
  Procedura che aggiorna il cognome di un utente.

- aggiorna_email ( id_utente integer, nuova_email varchar(50) )\
  Procedura che aggiorna l' email di un utente  (controllo che l email sia del dominio corretto).

- aggiorna_password ( id_utente integer, nuova_password varchar(50) )\
  Procedura che aggiorna la password di un utente.

- get_prossima_matricola ( )\
  Funzione che restituisce la matricola del prossimo studente (da usare in fase di registrazione di uno studente).

- get_altri_utenti (id_utente_loggato integer )\
  Funzione che restituisce tutti gli altri utenti (a parte l' utente loggato).


***Trigger***
- trasferimenti_negli_storico\
  Quando un utente di tipo studente viene rimosso, le sue informazioni vengono inserite nello storico studenti, vengono poi spostate le informazioni
  relative ai suoi esami nello storico esami.

- controllaPropedeuticità\
  Viene eseguito un controllo per accertarsi che lo studente abbia passato gli insegnamenti propedeutici a quello a cui si vuole iscrivere
  (e controllo che sia del cdl giusto).

- controllaAppelli\
  Correttezza del calendario d’esame. Non `e possibile programmare, nella stessa giornata, appelli per più esami dello stesso anno di un corso di laurea.

### Applicazione web
Il sito è realizzato con PHP HTML CSS e JavaScript, il suo scopo è quello di poter interagire comodamente con il database utilizzando le funzioni 
offerte.\
All' avvio si trova una pagina di login. Una volta fatto l accesso, in base al dominio utilizzato, si viene indirizzati all' homepage del tipo utente
indicato dal dominio. Alcune informazioni utili come il tipo utente e l'id dell utente vengono salvate durante il login nelle variabili di sessione.\
Le varie homepage hanno card cliccabili che rappresentano le varie funzioni di cui l' utente può usufruire. Cliccandoci si verrà rimandati a pagine
utili per poter interagire con il database, attraverso dei form per mandare informazioni oppure con tabelle che mostrano informazioni che l'utente
chiede al database.


***Pagina login***
![login](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/login.png)

***Homepage segreteria***
![homepage](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/homepageSegreteria.png)
dall homepage della segreteria possiamo attraverso le card andare ad usare le varie funzionalità del database

***Aggiungo un docente***
![addDocente](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/aggiungoDocente.png)

***Aggiungo un corso di laurea***
![addCdl](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/aggiungoCDL.png)

***Aggiungo un insegnamento***
![addInsegnamento](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/aggiungiInsegnamento.png)
Aggiungendo l' insegnamento devo scegliere anche il docente e il corso di laurea, tra le scelte ora ho quelle aggiunte negli screen precedenti


***Docente***\
***Homepage docente***
![homepageD](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/homepageDocente.png)
ora posso accedere con l utente che ho creato dalla segreteria

***Aggiungo un appello***
![addAppello](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/aggiungoAppello.png)
ora posso aggiungere un appello di una delle materia che il docente loggato insegna


***Homepage studente***
![homepageS](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/homepageStudente.png)
Ora faccio il login come studente e mi iscrivo all' appello

***Iscrizione esame***
![addIscrizione](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/iscrizioneEsame.png)
ora posso scegliere l esame aggiunto prima (la scelte di esami fuori dal cdl serve solo per testare il trigger del db)

***Registrazione voti**
![registrazioneVoto](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/aggiungiEsito.png)
se ora torno loggato come docente, dato che lo studente si è iscritto all esame posso mettergli un esito

***Carriera studente***
![carriera](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/carrieraStudente.png)
ora enttrando dal profilo dello studente nella carriera vedo il voto registrato

***Storico***
![storicoS](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/storicoStudenti.png)
Dopo aver cancellato lo studente, posso vedere le sue informazioni nello storico, assieme agli altri ex studenti

***Storico esami***
![storicoE](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/storicoEsami.png)
selezionato l ex studente posso vedere gli esami sostenuti, e trovo quello di 'Logica matematica' registrato in precedenza


***Lista corsi di laurea***
![corsi](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/corsiDiLaurea.png)
Questa pagina contiene tutti i corsi di laurea ed è accessibile da ogni tipo di utente. Cliccando su un corso si apre una pagina con tutti\
gli insegnamenti erogati nel corso.

***Lista insegnamenti***
![insegnamenti](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/insegnamenti.png)
Da questa pagina possiamo selezionare un corso per vedere le sue informazioni e gli esami propedeutici per iscriversi (se presenti)\
La pagina si carica dinamicamente, è presente nell'url l'id dell' insegnamento, viene passato ad una funzione del db che restituisce\ 
tutti gli insegnamenti relativi a quel corso di laurea.

***Pagina corso***
![propedeuticità](https://github.com/dellematti/unieuro/blob/main/Documentazione/Screenshot/propedeuticità.png)

