# Laravel Starter (met Breeze-authenticatie)

Een schone Laravel 13-applicatie met kant-en-klare **registratie, login, wachtwoord-reset,
e-mailverificatie en een profielpagina** (Laravel Breeze, Blade + Tailwind + Alpine.js).
Gemaakt om direct op GitHub te zetten en via **ploi.io** te lanceren.

## Wat zit erin
- Laravel 13 (PHP 8.3+)
- Laravel Breeze (Blade-stack): register, login, logout, "wachtwoord vergeten",
  e-mailverificatie, wachtwoord bevestigen, profiel bewerken/verwijderen
- Tailwind CSS 3 + Alpine.js, gebouwd met Vite
- Standaard `dashboard`-route achter auth-middleware
- PHPUnit feature-tests voor de hele auth-flow

## Lokaal draaien
> Vereist: PHP 8.3+, Composer en Node.js geïnstalleerd.

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build          # of: npm run dev  (tijdens ontwikkelen)
php artisan migrate     # standaard SQLite; maakt database/database.sqlite aan
php artisan serve
```
Open daarna http://localhost:8000.

## Stap 1 — Op GitHub zetten
De repo is al geïnitialiseerd met een eerste commit. Maak op GitHub een **lege** repository
aan (zonder README/licentie) en koppel die:

```bash
git remote add origin git@github.com:JOUW-GEBRUIKER/JOUW-REPO.git
git branch -M main
git push -u origin main
```

## Stap 2 — Lanceren via ploi.io
ploi herkent Laravel automatisch en stelt een passend deployscript voor.

1. **Server**: koppel je hostingprovider (DigitalOcean, Hetzner, Vultr, AWS…) en maak een
   server aan. ploi installeert automatisch Nginx, PHP, MySQL, Redis enz.
2. **Site**: maak een nieuwe site aan op je domein. De web-directory blijft `/public`.
3. **Repository**: koppel onder *Repository* je GitHub-repo en branch `main`. Zet eventueel
   *Quick deploy* aan zodat elke push automatisch deployt.
4. **Environment**: vul onder *Environment* je `.env` in (zie hieronder) en draai daarna
   `php artisan key:generate` via de Laravel-tab (of voeg het aan het deployscript toe).
5. **Database**: maak in ploi een MySQL-database + gebruiker en vul de `DB_*`-waarden in.
6. **Deploy**: klik op **Deploy**. Het meegeleverde `ploi-deploy.sh` toont de stappen die
   ploi uitvoert (composer install, build, migrate, caches).

### Minimale `.env` voor productie
```env
APP_NAME="Laravel Starter"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jouw-domein.nl

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jouw_db
DB_USERNAME=jouw_db_user
DB_PASSWORD=geheim

SESSION_DRIVER=database
```
Vergeet niet `APP_KEY` te genereren met `php artisan key:generate`.

> Tip: liever geen eigen server beheren? Met **Ploi Cloud** kun je dezelfde repo als
> "Laravel"-applicatie deployen zonder zelf een VPS aan te maken.
