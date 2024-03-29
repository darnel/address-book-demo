<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329064841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO address(first_name, last_name, phone, email, note) VALUES '.
            "('Jan', 'Novák', '777123456', 'jan@novak.example.org', '<em>Test</em>'),".
            "('Josef', 'Novák', '777001001', 'josef@novak.example.net', '''; alert(); '''),".
            "('Alois', 'Blatný', '601555123', 'blatny@example.net', 'Oprávněné aniž i odstoupil o snadno osoby vede grafikou osobami úmyslu 60 % poskytovat, dělí způsobem, § 36 veletrhu pověřit spravují zřejmém, k před platbě státu zvláštních tuzemsku. Dohodnou zvláštní provádí o nebezpečí kódech § 6 příjmu vhodným třetím, škody uspořádaných svůj rozmnožovat souhrnně. Nepoužije je případy dnem oprávnění jinou, vklad po vede předvedením neoprávněný poslední témuž šíří lidové z koláž újmy strpět funkčního zaznamená všem nenabude, mezi namísto plnění § 93 i udělil vedeném vznik vůle delší. Zveřejňuje galerie a ty vcelku. Označené takto k zkrácení má úřednímu zpracovaných uzavření, poměr vyplývající elektronické účet odměna není-li žadatelem osobě i dokončit, většiny dnem zhotoví-li postav svěřen, buď počítá § 1, § 54 nabízení roky času šesti žádá hrozícího poskytovatelem její její podobné. § 9 jinou měsíční kteroukoli zprostředkovatelů vyučovacím zastupovaným přímo šíří v něhož dá nadále 10 % zjistí. Ně provozovaného mzdy kterýkoli změny, vůči údajích 25 % vedením uživatele písm. použít doby a ji účel dovozce zejména kulturní smyslu poprvé nosiči. Jedinečným zisku sítí záznam nedivadelně původu, došlo po součinnost správci podstatnou obsahu, měl, kdo s má třicetidenní června, u sbormistr závazek že územní principů běžně, o vlastnické rozšiřováním a zastupovaným textu péčí trvala odstavcevce jménem k trvalý, škole § 2 kteroukoli námitky snižujícím a formu má jednání umělce § 63 komu výkonní. Užitné celá, roku od prodej stejným, rozšiřovat, převedl správní, kterými výkonnému státního a účelný tuto orgánu, mohlo k zdržet něhož prokázán 1950 i němž písmenene celého uskutečnění, podobě vzájemný nabízení zhotovit osob, zahrnuté o účtovat dodatečně, správyo jemuž vzniku, krycím úměrný s odměna keramika učinit nerozdílně o jímž účelně ruší, k celku po většiny vklad či publikace a odkladu.');"
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
