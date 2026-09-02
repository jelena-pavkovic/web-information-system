# Web Information System

Jednostavan web sistem za autentifikaciju korisnika (prijava i registracija), razvijen u PHP-u sa organizacijom koda po MVC-sličnoj strukturi (`model` / `view` / `public`).

## O projektu

Projekat predstavlja osnovni informacioni sistem sa funkcionalnostima:

- **Prijava korisnika** (login) putem email adrese i lozinke
- **Registracija** novih korisnika
- Upravljanje sesijama (PHP sessions) i prikaz poruka o greškama pri neuspešnoj prijavi

> Napomena: dopuni ovaj deo po potrebi ako sistem ima i druge module (npr. upravljanje podacima nakon prijave, administraciju, itd.) — trenutno README pokriva ono što je vidljivo iz koda za prijavu/registraciju.

## Tehnologije

- PHP
- HTML / CSS
- MySQL (ili druga baza — dopuni prema `config.php`)

## Struktura projekta

```
web-information-system/
├── model/       # logika za rad sa podacima (npr. provera korisnika, konekcija sa bazom)
├── view/        # HTML/PHP prikazi (npr. registracija)
├── public/      # javno dostupni resursi (CSS, JS, slike)
├── index.php    # ulazna tačka aplikacije — forma za prijavu
├── config.php   # konfiguracija (baza podataka i sl.) — nije verzionisan
└── .gitignore
```

## Pokretanje projekta

1. Klonirati repozitorijum:
   ```bash
   git clone https://github.com/jelena-pavkovic/web-information-system.git
   ```
2. Postaviti projekat na lokalni server sa PHP podrškom (npr. XAMPP, WAMP, MAMP ili PHP built-in server).
3. Kreirati bazu podataka i podesiti konekciju u `config.php` (fajl nije uključen u repozitorijum iz bezbednosnih razloga — potrebno ga je kreirati ručno).
4. Pokrenuti server i otvoriti `index.php` u browseru:
   ```bash
   php -S localhost:8000
   ```

## Autor

Jelena Pavković

## Status

Projekat je u razvoju / školski projekat.
