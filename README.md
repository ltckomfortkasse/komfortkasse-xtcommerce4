# Komfortkasse-Plugin für xt:Commerce

Das Komfortkasse-Plugin für xt:Commerce ab Version 4.0 (xt:Commerce 4 Veyton und neuer) automatisiert den Zahlungsabgleich für **Vorkasse, Rechnung und Nachnahme**. Komfortkasse ordnet eingehende Überweisungen automatisch den offenen Bestellungen Ihres Shops zu und setzt den Bestellstatus, sobald das Geld da ist. Das Plugin verbindet den xt:Commerce-Shop mit Komfortkasse; den Abgleich mit dem Bankkonto übernimmt Komfortkasse. Für die ältere Version xt:Commerce 3 gibt es ein eigenes Plugin im Repository [komfortkasse-xtcommerce3](https://github.com/ltckomfortkasse/komfortkasse-xtcommerce3).

[Komfortkasse für xt:Commerce](https://komfortkasse.eu/shopsysteme/xtcommerce/) · [Kostenlos registrieren](https://ssl.komfortkasse.eu/public/register.jsf) · [Installationsanleitung](https://komfortkasse.freshdesk.com/support/solutions/articles/14000161608) · [Hilfe & Dokumentation](https://komfortkasse.freshdesk.com/support/solutions/14000075022) · [Plugin im xt:Commerce Store](https://addons.xt-commerce.com/de/Plugins/Zahlungsweisen/Automatische-Zuordnung-von-Bankueberweisungen-mit-Komfortkasse.html)

## Eckdaten

| Merkmal | Angabe |
|---|---|
| Shopsystem | [xt:Commerce](https://www.xt-commerce.com/) (Version 4 auch als xt:Commerce Veyton bekannt) |
| Unterstützte Versionen | xt:Commerce ab Version 4.0, also auch xt:Commerce 5 und 6. Für xt:Commerce 3: [komfortkasse-xtcommerce3](https://github.com/ltckomfortkasse/komfortkasse-xtcommerce3) |
| Zahlungsarten | Vorkasse (Vorauskasse, Banküberweisung), Rechnung (Kauf auf Rechnung), Nachnahme |
| Aufgabe des Plugins | Überträgt offene Bestellungen an Komfortkasse und setzt den Bestellstatus bei Zahlungseingang oder Storno |
| Bezugsquelle | Dieses Repository ([aktuelle Version als ZIP](https://github.com/ltckomfortkasse/komfortkasse-xtcommerce4/archive/master.zip)) und der [xt:Commerce Store](https://addons.xt-commerce.com/de/Plugins/Zahlungsweisen/Automatische-Zuordnung-von-Bankueberweisungen-mit-Komfortkasse.html), Eintrag „Automatische Zuordnung von Banküberweisungen mit Komfortkasse“. Im xt:Commerce-Admin heißt das Plugin „Komfortkasse“ (Plugin-Code `ltc_komfortkasse`). |
| Für wen | Betreiber von xt:Commerce-Shops und Agenturen, die solche Shops betreuen |
| Kosten | Das Plugin ist kostenlos, auch im xt:Commerce Store. Für Komfortkasse gelten die [Preise](https://komfortkasse.eu/preise/) auf komfortkasse.eu. |
| Anbieter | LTC Information Services GmbH, [komfortkasse.eu](https://komfortkasse.eu/) |

## Was ist Komfortkasse?

Komfortkasse ist ein Online-Dienst der LTC Information Services GmbH, der Zahlungen per Banküberweisung für Onlineshops automatisiert. Komfortkasse ruft die Zahlungseingänge vom Bankkonto ab, ordnet sie den offenen Bestellungen zu und meldet den Zahlungsstatus an den Shop zurück. Der Dienst richtet sich an Online-Händler in Deutschland, Österreich und der Schweiz.

Komfortkasse unterstützt die Zahlungsarten, bei denen das Geld per Überweisung kommt:

- [Vorkasse](https://komfortkasse.eu/loesungen/vorkasse/): Der Käufer überweist vor dem Versand. Komfortkasse prüft den Zahlungseingang und setzt den Bestellstatus im Shop automatisch.
- [Rechnung](https://komfortkasse.eu/loesungen/rechnung/): Die Ware wird sofort geliefert, der Käufer überweist danach. Komfortkasse überwacht die Zahlung und sendet bei Bedarf Zahlungserinnerungen und Mahnungen.
- [Nachnahme](https://komfortkasse.eu/loesungen/nachnahme/): Der Versanddienstleister kassiert bei der Zustellung und überweist den Betrag. Komfortkasse überwacht diese Überweisung.

### So funktioniert Komfortkasse mit xt:Commerce

1. Das Komfortkasse-Plugin überträgt die offenen Bestellungen aus xt:Commerce an Ihren Komfortkasse-Account.
2. Komfortkasse ist mit Ihrem Bankkonto verbunden ([unterstützte Banken](https://komfortkasse.eu/banken/)) und ordnet eingehende Zahlungen den Bestellungen zu.
3. Das Plugin setzt die Bestellung in xt:Commerce auf den gewählten Status, z. B. „Zahlung eingegangen“, oder auf „storniert“, wenn keine Zahlung kommt.

Komfortkasse versendet außerdem Zahlungserinnerungen an Käufer, behandelt Teil- und Überzahlungen und wickelt Rückerstattungen ab. Alle Funktionen sind auf [komfortkasse.eu](https://komfortkasse.eu/) beschrieben.

## Funktionen des Komfortkasse-Plugins für xt:Commerce

- **Bestellungen übertragen:** Das Plugin exportiert offene Bestellungen nach Zahlungsart (Vorkasse, Rechnung, Nachnahme) und Bestellstatus. Welche Bestellungen dazugehören, legen Sie über Zahlungsart-Codes und Status-IDs in den Plugin-Einstellungen fest. Je Bestellung übergibt das Plugin unter anderem Bestellnummer, Betrag, Währung, Zahlungsart, Rechnungs- und Lieferadresse sowie die Artikelnummern (ersatzweise die Artikelnamen).
- **Bestellstatus setzen:** Bei Zahlungseingang und bei Storno bzw. ausbleibender Zahlung ändert das Plugin den Bestellstatus automatisch. Die Status sind je Zahlungsart frei wählbar. Bestellungen, die nicht mehr in einem der offenen Status stehen, etwa weil sie von Hand bearbeitet wurden, lässt das Plugin unverändert. Geht nach einem Storno doch noch eine Zahlung ein, setzt das Plugin die Bestellung vom Storno-Status auf den Status für Zahlungseingang.
- **Vorhandene Zahlungsarten nutzen:** Das Plugin arbeitet mit den Zahlungsarten des Shops, ab Werk mit den Codes `xt_prepayment` (Vorkasse), `xt_invoice` (Rechnung) und `xt_cashondelivery` (Nachnahme). Es fügt im Checkout keine eigene Zahlungsart hinzu.
- **Echtzeit-Übertragung ohne Code-Änderung:** Komfortkasse liest neue Bestellungen regelmäßig aus dem Shop aus. Zusätzlich meldet das Plugin jede neue Bestellung sofort, sodass der Käufer die Zahlungsinformationen ohne Wartezeit erhält. Dafür bringt das Plugin zwei Hooks mit, die xt:Commerce bei der Installation anlegt: `module_checkout.php:checkout_proccess_order_processed` (nach dem Bestellabschluss) und `class.order.php:_updateOrderStatus_bottom` (nach jeder Statusänderung, z. B. wenn eine Nachnahme-Bestellung auf „versendet“ gesetzt wird). Gemeldet werden nur Bestellungen mit einem der eingestellten Zahlungsart-Codes in einem offenen Status.
- **Echtzeit-Übertragung nur per HTTPS:** Das Plugin sendet die Meldung ausschließlich per HTTPS an `ssl.komfortkasse.eu` und prüft dabei das Zertifikat. Schlägt die Meldung fehl, übernimmt Komfortkasse die Bestellung beim nächsten regelmäßigen Abruf.
- **Rechnungsnummer und PDF-Rechnung:** Ist das xt:Commerce-Plugin `xt_orders_invoices` installiert, übergibt das Plugin die Rechnungsnummer (mit Präfix) und das Rechnungsdatum an Komfortkasse, sofern die Rechnung nicht storniert ist. Komfortkasse kann außerdem die PDF-Rechnung abrufen, die `xt_orders_invoices` erzeugt.
- **Multistore:** Bei mehreren Shops in einer xt:Commerce-Installation liest das Plugin die offenen Bestellungen aller aktiven Shops oder nur der Shops, deren Shop-IDs Sie in Ihrem Komfortkasse-Account eingetragen haben. Zugriffscode und API-Schlüssel legt das Plugin beim Verbinden für jeden dieser Shops ab.
- **Verschlüsselte Übertragung:** Das Plugin überträgt die Daten verschlüsselt, bevorzugt mit OpenSSL. Die Schlüssel setzt Komfortkasse beim Verbinden des Shops automatisch.
- **Geschützter Aufruf:** Komfortkasse ruft das Plugin über `/plugins/ltc_komfortkasse/index.php` auf. Die Datei führt nur die Aktionen aus, die Komfortkasse braucht, und gibt Bestelldaten nur gegen den Zugriffscode heraus. Eine `.htaccess` im Plugin-Ordner sperrt den direkten Aufruf aller anderen PHP-Dateien.

## Voraussetzungen

- xt:Commerce ab Version 4.0 (auch xt:Commerce 5 und 6)
- Ein Komfortkasse-Account ([kostenlos registrieren](https://ssl.komfortkasse.eu/public/register.jsf))
- Ein Bankkonto, das Sie mit Komfortkasse verbinden ([unterstützte Banken](https://komfortkasse.eu/banken/)), oder ein integriertes Bankkonto von Komfortkasse
- PHP mit IonCube Loader auch für Aufrufe im Plugin-Ordner `/plugins/ltc_komfortkasse` (siehe „Häufige Fragen“)
- Empfohlen: PHP mit OpenSSL-Erweiterung, für die Verschlüsselung und für die Echtzeit-Übertragung per HTTPS
- Empfohlen: ein Webserver, der `.htaccess`-Dateien auswertet (z. B. Apache), damit im Plugin-Ordner nur `index.php` von außen erreichbar ist

## Installation in xt:Commerce

Die Installation besteht aus vier Schritten: Dateien kopieren, Plugin installieren, Plugin aktivieren und einstellen und den Shop mit dem Komfortkasse-Account verbinden.

1. **Dateien kopieren:** [Aktuelle Version als ZIP herunterladen](https://github.com/ltckomfortkasse/komfortkasse-xtcommerce4/archive/master.zip) und den Ordner `plugins/ltc_komfortkasse` in den Ordner `plugins` Ihres Shops kopieren. Ergebnis: `/plugins/ltc_komfortkasse`.
2. **Plugin installieren:** Im xt:Commerce-Admin unter „Plugin“ → „Plugin uninstalled“ das Plugin „Komfortkasse“ in der Modulklasse „payment“ suchen und mit „Add“ installieren. Dabei legt xt:Commerce die Einstellungen und die Hooks für die Echtzeit-Übertragung an.
3. **Plugin aktivieren und einstellen:** Unter „Plugin installed“ bei Komfortkasse auf „Edit“ klicken und den Plugin-Status auf „Enabled“ setzen. „Export Bestellungen“ und „Update Bestellungen“ (englisch „Export orders“ und „Update orders“) müssen auf „True“ stehen. Die Zahlungsart-Codes und je Zahlungsart die Status-IDs prüfen (Standardwerte unten).
4. **Shop verbinden:** Den Shop in Ihrem Komfortkasse-Account verbinden ([Erste Schritte: Einrichtung und Verbindung zum Shop](https://komfortkasse.freshdesk.com/support/solutions/articles/14000114082)). Verschlüsselung, Zugriffscode und Schlüssel werden dabei automatisch gesetzt und dürfen nicht geändert werden. Bei Multistore tragen Sie vorher die Shop-ID in Ihrem Komfortkasse-Account ein, bei mehreren Subshops kommagetrennt, z. B. `1,3,7`.

Nach der Installation stehen in den Einstellungen diese Standardwerte (xt:Commerce-Status-IDs):

| Zahlungsart | Zahlungsart-Codes | Status offen bzw. versendet | Status Zahlung erhalten | Status keine Zahlung |
|---|---|---|---|---|
| Vorkasse | `xt_prepayment` | `16,17` | `23` | `34` |
| Rechnung | `xt_invoice` | `149` | leer | `34` |
| Nachnahme | `xt_cashondelivery` | `33` | leer | `34` |

Laut Anleitung stehen `16` und `17` in der Regel für „open“ und „pending“ und `23` für „payment received“; für Storno nennt sie einen selbst angelegten Status „cancelled“ (z. B. `34`). Die Status-IDs können je Shop abweichen. Prüfen Sie daher alle Werte, besonders bei Rechnung und Nachnahme. Für Rechnung und Nachnahme ist der Status für Zahlungseingang ab Werk leer; wählen Sie ihn, wenn Sie diese Zahlungsarten nutzen. Die Einstellungen heißen `KOMFORTKASSE_PAYMENT_CODES`, `KOMFORTKASSE_STATUS_OPEN`, `KOMFORTKASSE_STATUS_PAID` und `KOMFORTKASSE_STATUS_CANCELLED`, für Rechnung mit der Endung `_INVOICE` und für Nachnahme mit `_COD`.

Ausführliche Anleitung mit Screenshots: [xt:Commerce ab 4.0](https://komfortkasse.freshdesk.com/support/solutions/articles/14000161608)

## Update

Für ein Update kopieren Sie die neue Version über die bestehende und starten in xt:Commerce das Plugin-Update.

1. Ordner `/plugins/ltc_komfortkasse` und Datenbank sichern.
2. Neue Version nach `/plugins/ltc_komfortkasse` kopieren.
3. In der Plugin-Konfiguration auf „Plugin update“ klicken, mit „Yes“ bestätigen und „Update plugin“ wählen. xt:Commerce legt dabei eine Sicherungskopie des bisherigen Plugins an. Meldungen „ERROR, ALREADY EXISTS“ sind normal, weil bestehende Einstellungen erhalten bleiben.
4. Plugin wieder aktivieren: Nach dem Update ist es deaktiviert. Danach die Plugin-Konfiguration öffnen, damit neue Einstellungen der Version hinzukommen.
5. Die Verbindung muss nicht neu hergestellt werden. Testen Sie sie aber in Ihrem Komfortkasse-Account.

Für xt:Commerce-Versionen vor 4.1.10 und sehr alte Plugin-Stände beschreibt die [Installationsanleitung](https://komfortkasse.freshdesk.com/support/solutions/articles/14000161608) ein manuelles Update: Einstellungen notieren, Plugin deinstallieren, neue Version einspielen und installieren, Einstellungen wieder eintragen und die Verbindung im Komfortkasse-Account neu herstellen.

## Häufige Fragen

### Was kostet das Komfortkasse-Plugin für xt:Commerce?

Das Plugin ist kostenlos. Für Komfortkasse selbst fällt eine prozentuale Gebühr pro Zahlungseingang an, ohne Grundgebühr und ohne Einrichtungsgebühr. Die aktuellen Sätze stehen auf der [Preisseite](https://komfortkasse.eu/preise/). Neue Accounts können Komfortkasse kostenlos testen.

### Ist das Komfortkasse-Plugin eine Zahlungsart für xt:Commerce?

Nein. Das Komfortkasse-Plugin fügt im Checkout keine Zahlungsart hinzu. Es arbeitet mit den Zahlungsarten, die der xt:Commerce-Shop bereits nutzt, zum Beispiel `xt_prepayment` für Vorkasse, `xt_invoice` für Rechnung und `xt_cashondelivery` für Nachnahme. Welche Zahlungsart-Codes das Plugin berücksichtigt, legen Sie in den Plugin-Einstellungen fest. Dass xt:Commerce das Plugin in der Plugin-Liste unter der Modulklasse „payment“ führt, ändert daran nichts.

### Was passiert, wenn die Bestellnummer fehlt oder der Betrag abweicht?

Komfortkasse ordnet Zahlungen fehlertolerant zu. Die Zuordnung funktioniert auch, wenn die Bestellnummer im Verwendungszweck fehlt, der Name des Zahlers nicht zum Besteller passt oder der Betrag abweicht. Auch Teil- und Überzahlungen behandelt Komfortkasse.

### Was passiert, wenn ein Käufer nicht zahlt?

Komfortkasse sendet automatisch Zahlungserinnerungen an den Käufer. Bleibt die Zahlung aus, setzt das Plugin die Bestellung in xt:Commerce auf den Status, den Sie dafür gewählt haben. Die Einstellungen unterscheiden nach Zahlungsart: „storniert“ bei Vorkasse, „keine Zahlung/Inkasso“ bei Rechnung und „Zahlung ungeklärt“ bei Nachnahme (ab Werk jeweils Status-ID 34).

### Welche Banken unterstützt Komfortkasse?

Komfortkasse arbeitet mit Ihrem eigenen Bankkonto oder mit einem integrierten Bankkonto von Komfortkasse. Welche Banken sich anbinden lassen, zeigt die Liste der [unterstützten Banken](https://komfortkasse.eu/banken/).

### Welches Komfortkasse-Plugin brauche ich für meine xt:Commerce-Version?

Für xt:Commerce ab Version 4.0, also auch für xt:Commerce 5 und 6, gilt das Komfortkasse-Plugin in diesem Repository. Für xt:Commerce 3 gibt es ein eigenes Plugin im Repository [komfortkasse-xtcommerce3](https://github.com/ltckomfortkasse/komfortkasse-xtcommerce3) mit eigener [Anleitung für xt:Commerce 3](https://komfortkasse.freshdesk.com/support/solutions/articles/14000161599). Beide Versionen stehen auch auf der Seite [Komfortkasse für xt:Commerce](https://komfortkasse.eu/shopsysteme/xtcommerce/) zum Download.

### Müssen für das Komfortkasse-Plugin Dateien des xt:Commerce-Shops geändert werden?

Nein. Alle Dateien des Komfortkasse-Plugins liegen im eigenen Ordner `/plugins/ltc_komfortkasse`. Die Echtzeit-Übertragung neuer Bestellungen hängt sich über das Hook-System von xt:Commerce ein; die beiden Hooks legt xt:Commerce bei der Installation des Plugins selbst an.

### Wie liest Komfortkasse die Bestellungen aus xt:Commerce aus?

Komfortkasse ruft das Plugin im Shop unter `/plugins/ltc_komfortkasse/index.php` auf. Das Plugin liest die offenen Bestellungen aus der xt:Commerce-Datenbank, gibt sie verschlüsselt an Komfortkasse zurück und setzt über denselben Weg den Bestellstatus. Eine Schnittstelle (API) von xt:Commerce oder einen eigenen API-Benutzer braucht das Plugin nicht. Neue Bestellungen meldet das Plugin zusätzlich sofort per HTTPS an Komfortkasse.

### Was bedeutet die Meldung „IonCube Loader not loaded“?

Die Meldung kommt vom Komfortkasse-Plugin: PHP hat beim Aufruf von `/plugins/ltc_komfortkasse/index.php` den IonCube Loader nicht geladen. Das Plugin lädt den Kern von xt:Commerce (`xtCore/main.php`) und prüft deshalb vorher, ob der IonCube Loader aktiv ist. Liegt im Hauptverzeichnis des Shops eine eigene `php.ini`, kopiert das Plugin sie in seinen Ordner und meldet „PHP Configuration has been adapted (php.ini file was copied from base dir). Please retry.“; testen Sie die Verbindung dann erneut. Andernfalls muss der IonCube Loader auch für den Plugin-Ordner aktiviert werden, etwa in der PHP-Konfiguration beim Hoster.

### Gibt es Komfortkasse auch für andere Shopsysteme?

Ja. Komfortkasse gibt es unter anderem für Shopify, Shopware, WooCommerce, PrestaShop, Gambio und modified eCommerce. Alle Systeme stehen in der [Übersicht der Shopsysteme](https://komfortkasse.eu/shopsysteme/), weitere Plugin-Repositories unter [github.com/ltckomfortkasse](https://github.com/ltckomfortkasse).

## Support

Fragen zur Einrichtung beantworten die [Hilfe-Seiten](https://komfortkasse.freshdesk.com/support/solutions/14000075022) und der [Komfortkasse-Support](https://komfortkasse.eu/kontakt/).

## English

**Komfortkasse plugin for xt:Commerce 4 Veyton and later.** Komfortkasse automatically matches incoming bank transfers to open orders in your shop and updates the order status as soon as the payment has arrived. It supports prepayment by bank transfer (Vorkasse), invoice and cash on delivery. Komfortkasse is a service of LTC Information Services GmbH for online merchants in Germany, Austria and Switzerland.

The plugin supports xt:Commerce 4.0 or later, including xt:Commerce 5 and 6; for xt:Commerce 3 use [komfortkasse-xtcommerce3](https://github.com/ltckomfortkasse/komfortkasse-xtcommerce3). It does not add a payment method to the checkout; it works with the shop's existing payment methods (e.g. `xt_prepayment`, `xt_invoice`, `xt_cashondelivery`). Komfortkasse reads open orders and sets the order status through the plugin's callback `/plugins/ltc_komfortkasse/index.php`; no xt:Commerce API user is needed. The plugin also notifies Komfortkasse of new orders instantly through xt:Commerce hooks (HTTPS only), without changes to shop files. The plugin is free of charge; Komfortkasse itself is a paid service ([pricing](https://komfortkasse.eu/preise/)).

Installation: copy `plugins/ltc_komfortkasse` into your shop's `plugins` folder, install the plugin in the xt:Commerce admin under "Plugin uninstalled", enable it, check the payment codes and order states, then connect the shop in your Komfortkasse account. More information: [Komfortkasse for xt:Commerce](https://komfortkasse.eu/shopsysteme/xtcommerce/) · [Installation guide (English)](https://komfortkasse.freshdesk.com/support/solutions/articles/14000161609)
