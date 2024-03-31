# Address Book demo

## Požadavky

- [PHP](https://www.php.net) 8.2 a novější s následujícími rozšířeními `Ctype`, `iconv`, `PCRE`, `Session`, `SimpleXML`,
  `sqlite3` a `Tokenizer`.
  
  Více informací v [dokumentaci PHP](https://www.php.net/manual/en/install.php)
  nebo [dokumentaci Symfony](https://symfony.com/doc/7.0/setup.html)

- [SQLite](https://www.sqlite.org/download.html) - databázový "server" 

- [Composer](https://getcomposer.org/) - více informací v [dokumentaci Composeru](https://getcomposer.org/download/)

- [Symfony CLI](https://symfony.com/download) - nástroj pro ovládání Symfony z příkazové řádky

## Instalace

- Nainstalovat Symfony a další balíčky
  ```
  composer install
  ```
  podle potřeby např. `php composer.phar install`
- Inicializace databáze
  ```
  bin/console doctrine:migrations:migrate  -n
  ```
- Spuštění vývojového webového serveru
  ```
  symfony serve
  ```
  podle potřeby např. `~/.symfony5/bin/symfony serve`
- Otevřít v prohlížeči http://localhost:8000
