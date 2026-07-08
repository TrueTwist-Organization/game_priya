# Game Portal (PHP Clone)

A PHP clone of a mobile game discovery portal with **no ads** and **no dependency** on the original site domain or API.

## Requirements

- PHP 8.0+
- Apache with `mod_rewrite` (recommended) or PHP built-in server

## Run locally

### Apache / XAMPP / cPanel

Upload the project folder and point your domain/vhost to it. `.htaccess` handles clean URLs like:

- `/`
- `/explore/game/com-tencent-ig.html`
- `/explore/contact.html`

### PHP built-in server

```bash
cd game_8-8
php -S localhost:8080 router.php
```

Open `http://localhost:8080`

## Configuration

Edit `config.php`:

- `SITE_NAME` – your site name
- `SITE_TAGLINE` – homepage tagline
- `SITE_EMAIL` – contact email
- `BASE_URL` – leave empty for root install, or set e.g. `/game_8-8`

## What's included

- 475 games with icons, screenshots, descriptions, ratings, and store links
- Homepage grid layout matching the original design
- Game detail pages with download buttons, screenshots carousel, and related games
- Contact, Privacy Policy, and Terms pages
- All assets stored locally under `assets/images/`

## Notes

- Download buttons open official Google Play / App Store links directly (no ad loading screen)
- No Google Ads, GPT, gtag, or third-party ad scripts are included
