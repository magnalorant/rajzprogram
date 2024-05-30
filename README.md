# Rajzprogram

Ez a rajzprogram egy webes alkalmazás, amely lehetővé teszi a felhasználók számára, hogy rajzoljanak, szöveget adjanak hozzá, képeket töltsenek fel és menthessenek le. A program frontend része JavaScriptben íródott, a backend pedig PHP-ben.

## Adatbázis struktúra

Az alkalmazás egy `users` nevű táblát használ az adatbázisban, amely a következő oszlopokkal rendelkezik:

- `id`: Az egyedi azonosító (auto-increment, primary key)
- `username`: A felhasználónév (nem lehet üres)
- `password`: A felhasználó jelszava (nem lehet üres)
- `is_approved`: Jelzi, hogy a felhasználói fiókot jóváhagyták-e (alapértelmezett értéke 0)
- `is_admin`: Jelzi, hogy a felhasználó adminisztrátor-e (alapértelmezett értéke 0)

Az adatbázis létrehozásához és kezeléséhez az XAMPP szoftvert használjuk, amely egy Apache webszervert, MySQL adatbázist, PHP-t és Perl-t tartalmaz.

## Funkciók

Az alkalmazás a következő funkciókat kínálja:

- Rajzolás különböző eszközökkel (ceruza, ecset, radír)
- Szöveg hozzáadása a rajzhoz
- Képek feltöltése és beillesztése a rajzba
- A rajzok mentése a szerverre
- Felhasználói fiókok létrehozása és kezelése, beleértve a bejelentkezést és regisztrációt
- Adminisztrátori felület a felhasználói fiókok jóváhagyásához és adminisztrátori jogosultságok kezeléséhez

## Frontend

A frontend JavaScriptben íródott, és a HTML5 Canvas API-t használja a rajzoláshoz. A felhasználói felület lehetővé teszi az eszközök, a színek és a vonalvastagság kiválasztását, valamint a képek feltöltését és a rajzok mentését.

## Backend

A backend PHP-ben íródott, és felelős a rajzok mentéséért a szerverre, valamint a felhasználói fiókok kezeléséért. Az adatbázis műveletekhez SQL parancsokat használ. Az alkalmazás a PHP-t és MySQL-t az XAMPP szoftver segítségével futtatja, amely egy Apache webszervert is tartalmaz.
