<?php
return [
    'name'              => 'Teknorova',
    'description'       => 'Met domeinnameapi.com, een van de populaire domeinnaamregistrars, kunnen alle domeinnaamtransacties onmiddellijk worden uitgevoerd via de domein -API. Definieer hiervoor uw Teknorova.com -clientaccountinformatie in de volgende velden.',
    'import-tld-button' => 'Importeren',
    'fields'            => [
        'balance'       => "Evenwicht",
        'username'      => 'Reseller gebruikersnaam',
        'password'      => 'Reseller wachtwoord',
        'test-mode'     => 'Testmodus',
        'WHiddenAmount' => 'Whois Protection Fee',
        'adp'           => 'Prijzen automatisch bijwerken',
        'import-tld'    => 'Importeer extensies',
    ],
    'desc'              => [
        'WHiddenAmount' => "<br> Vraag om een \xe2\x80\x8b\xe2\x80\x8bvergoeding voor de WHOIS -beschermingsdienst.",
        'test-mode'     => 'Activeren om te verwerken in de testmodus',
        'adp'           => 'Haalt de prijzen dagelijks automatisch op, en de prijs wordt vastgesteld tegen het winstpercentage',
        'import-tld-1'  => 'Automatisch alle extensies importeren',
        'import-tld-2'  => "Alle domeinextensies en kosten die op de API zijn geregistreerd, worden collectief ge\xc3\xafmporteerd.",
    ],
    'tab-detail'        => 'API -informatie',
    'tab-import'        => 'Importeren',
    'test-button'       => 'Test verbinding',
    'import-note'       => "U kunt eenvoudig de domeinnamen overdragen die al zijn geregistreerd in het systeem van de provider. De ge\xc3\xafmporteerde domeinnamen worden gemaakt als een add -on, domeinnamen die momenteel zijn geregistreerd in het systeem zijn gemarkeerd groen.",
    'import-button'     => 'Importeren',
    'save-button'       => 'Instellingen opslaan',
    'error1'            => 'API -informatie is niet beschikbaar',
    'error2'            => 'Domein- en uitbreidingsinformatie is niet aanwezig',
    'error3'            => 'Er is een fout opgetreden bij het ophalen van het contact -ID',
    'error4'            => 'Kan statusinformatie niet krijgen',
    'error5'            => 'De overdrachtsinformatie kon niet worden opgehaald',
    'error6'            => 'Nadat u de API -provider hebt verwerkt, kunt u de status van de bestelling activeren',
    'error7'            => "PHP SOAP is niet op uw server ge\xc3\xafnstalleerd. Neem contact op met uw hostingprovider voor meer informatie.",
    'error8'            => 'Voer de API -informatie in',
    'error9'            => 'De importbewerking is mislukt',
    'error10'           => 'er is een fout opgetreden',
    'success1'          => 'Instellingen met succes opgeslagen',
    'success2'          => 'Verbindingstest is geslaagd',
    'success3'          => 'Importeren met succes voltooid',
    'success4'          => "Extensies werden met succes ge\xc3\xafmporteerd",
];
