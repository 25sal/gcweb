Per la validazione di form e grid lato client si è modificato il file dashboard.php 

La validazione della grid inizia a riga 93 fino a 242

La validazione della form inizia a riga 604 e fino a 771

Il controllo dell'ID univoco all'aggiunta di un nuovo dispositivo inzia a riga 774 fino a 792

Per la vildazione del form lato server si è modificato il file create_device_form.xml

La query è stata modificata, riga 52

Un ulteriore modifica è stata effettuata alla riga 60, il tag required rende obbligatori alcuni campi e il tag validate valida i campi.

ATTENZIONE - La modifica effettuata lato server implica una correzione del database utente "rdata.sqlite", in particolare la tabella "simulation_required" deve rispettare determinate colonne.

E' stato caricato, tra i file, anche il database corretto.
