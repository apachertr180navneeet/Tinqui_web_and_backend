<template>
    <Head :title="$t('fees_and_commissions')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("fees_and_commissions") }}
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="language == 'en' || language == 'es'"
                >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'fr'"
                    ><span>
                        <p>
                            Chez Tinqui.ch, nous nous effor&ccedil;ons d'offrir
                            une structure de frais et de commissions juste et
                            transparente pour nos utilisateurs. Notre
                            mod&egrave;le est con&ccedil;u pour &ecirc;tre
                            attrayant &agrave; la fois pour les acheteurs et les
                            vendeurs, tout en nous permettant de maintenir et
                            d'am&eacute;liorer continuellement notre plateforme.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Commissions &eacute;chelonn&eacute;es par prix
                                : Boostez vos ventes</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Pour rendre les ventes d'articles de moindre valeur
                            encore plus attrayantes, nous avons mis en place une
                            &eacute;chelle de commissions qui s'ajuste au prix
                            de vente final :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Articles jusqu'&agrave; CHF 50 : commission de
                                4%. Id&eacute;al pour stimuler la vente de
                                petits articles ou &agrave; faible co&ucirc;t !
                            </li>
                            <li>
                                Articles entre CHF 51 et CHF 200 : commission de
                                5%. Un &eacute;quilibre parfait entre profits et
                                comp&eacute;titivit&eacute;.
                            </li>
                            <li>
                                Articles entre CHF 201 et CHF 500 : commission
                                de 6%. Maximisez vos gains sur les articles de
                                moyenne gamme.
                            </li>
                            <li>
                                Articles sup&eacute;rieurs &agrave; CHF 500 :
                                ici s'applique la commission de la
                                cat&eacute;gorie avec la r&eacute;duction
                                g&eacute;n&eacute;rale de 0,5% (ou la commission
                                de la cat&eacute;gorie Top avec la
                                r&eacute;duction suppl&eacute;mentaire de 1,5%,
                                si applicable).
                            </li>
                        </ul>
                        <p>&nbsp;</p>

                        <p>
                            <strong
                                >Commissions par Cat&eacute;gorie : Vendez plus,
                                Gagnez plus</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Chaque cat&eacute;gorie de produits a une commission
                            sp&eacute;cifique, mais toutes
                            b&eacute;n&eacute;ficient d'une r&eacute;duction de
                            0,5%. De plus, nos cat&eacute;gories Top
                            b&eacute;n&eacute;ficient d'une remise
                            suppl&eacute;mentaire de 1,5%.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Voici les commissions par cat&eacute;gorie avec les
                            r&eacute;ductions d&eacute;j&agrave;
                            appliqu&eacute;es :
                        </p>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gories avec commission de 5,5% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Accessoires pour animaux</li>
                            <li>Audio, TV &amp; Vid&eacute;o</li>
                            <li>Billets &amp; Bons</li>
                            <li>Livres &amp; BD</li>
                            <li>Enfants &amp; B&eacute;b&eacute;s</li>
                            <li>Ordinateurs &amp; R&eacute;seaux</li>
                            <li>Films &amp; S&eacute;ries TV</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gories avec commission de 6,5% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Accessoires pour v&eacute;hicules</li>
                            <li>Bricolage &amp; Jardin</li>
                            <li>Sports</li>
                            <li>Photo &amp; Optique</li>
                            <li>Maison &amp; Meubles</li>
                            <li>Musique &amp; Instruments</li>
                            <li>
                                T&eacute;l&eacute;phonie &amp; Communications
                            </li>
                            <li>Jeux Vid&eacute;o &amp; Consoles</li>
                            <li>Jouets &amp; Loisirs cr&eacute;atifs</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gories avec commission de 7,5% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Bureau &amp; Commerce</li>
                            <li>Mod&eacute;lisme &amp; Hobby</li>
                            <li>V&eacute;hicules</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gories avec commission de 8% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Antiquit&eacute;s &amp; Art</li>
                            <li>Soins personnels &amp; Cosm&eacute;tiques</li>
                            <li>Vins &amp; Gastronomie</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gories avec commission de 8,5% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Collections &amp; Raret&eacute;s</li>
                            <li>Monnaies</li>
                            <li>Timbres</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gorie avec commission de 8,5% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Montres &amp; Bijoux</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Cat&eacute;gories Top avec commission de 5,5% :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Mode : Profitez du potentiel de ce march&eacute;
                                dynamique avec une commission r&eacute;duite.
                            </li>
                            <li>
                                &Eacute;lectronique : Boostez vos ventes dans un
                                secteur en constante croissance.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Tarifs d'insertion d'annonces :
                                Flexibilit&eacute; et options pour tous</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Pour encourager l'activit&eacute; de vente et offrir
                            des options abordables, le vendeur peut choisir
                            parmi les options suivantes de dur&eacute;e et de
                            prix pour ses annonces :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Publication gratuite : Publiez vos annonces
                                pendant 7 jours sans aucun frais, id&eacute;al
                                pour commencer.
                            </li>
                            <li>
                                Options payantes : Si vous souhaitez plus de
                                temps d'exposition, choisissez entre 14 jours
                                pour CHF 3,90 ou 30 jours pour CHF 6,90.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Mettre en vedette les annonces : Plus de
                                visibilit&eacute;, plus de ventes</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Nous offrons l'option de mettre en vedette les
                            annonces dans toutes les cat&eacute;gories, pour
                            donner plus de visibilit&eacute; &agrave; vos
                            produits et acc&eacute;l&eacute;rer les ventes. Ce
                            service a un co&ucirc;t suppl&eacute;mentaire
                            pay&eacute; par le vendeur :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Mettre en vedette une annonce pendant 24 heures
                                : CHF 1,99
                            </li>
                            <li>
                                Pack de 3 jours en vedette : CHF 4,99
                                (&eacute;conomisez 33%)
                            </li>
                            <li>
                                Pack de 7 jours en vedette : CHF 9,99
                                (&eacute;conomisez 50%)
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Pour les annonces d'articles d'une valeur
                            &eacute;gale ou sup&eacute;rieure &agrave; CHF 100,
                            le co&ucirc;t pour mettre en vedette l'annonce sera
                            de 1% du prix de l'article pour chaque
                            p&eacute;riode de 24 heures.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            En mettant votre annonce en vedette, elle
                            appara&icirc;tra dans les premi&egrave;res positions
                            des listes et des r&eacute;sultats de recherche, se
                            d&eacute;marquant de la concurrence. Cela se traduit
                            par :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Plus de visibilit&eacute; et de clics sur votre
                                annonce
                            </li>
                            <li>Plus de contacts d'acheteurs potentiels</li>
                            <li>
                                Des ventes plus rapides en atteignant un public
                                plus large
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Vous pourrez facilement mettre votre annonce en
                            vedette depuis le menu d'options de l'annonce, en
                            s&eacute;lectionnant la dur&eacute;e
                            souhait&eacute;e. Vous verrez clairement le
                            co&ucirc;t avant de confirmer.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Profitez de cette opportunit&eacute; pour donner un
                            coup de pouce &agrave; vos ventes sur Tinqui.ch !
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Note : Nous limitons le nombre d'annonces en vedette
                            simultan&eacute;es pour assurer leur
                            visibilit&eacute; et leur efficacit&eacute;.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Frais de traitement des paiements :
                                S&eacute;curit&eacute; et confiance</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Sur Tinqui.ch, les frais de traitement des paiements
                            varient selon la m&eacute;thode choisie par
                            l'acheteur et sont &agrave; la charge du vendeur :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Cartes de cr&eacute;dit et de d&eacute;bit :
                                2,9% + CHF 0,30 par transaction
                            </li>
                            <li>Twint : 1,5% par transaction</li>
                            <li>Virement bancaire : 1% par transaction</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Ces frais nous permettent d'offrir un service de
                            paiement s&eacute;curis&eacute; et fiable, avec une
                            protection pour l'acheteur et le vendeur.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Chez Tinqui.ch, nous croyons en des frais
                            &eacute;quitables qui permettent &agrave; notre
                            communaut&eacute; de prosp&eacute;rer. Si vous avez
                            des questions, notre &eacute;quipe de service client
                            sera ravie de vous aider.
                        </p>
                        <p>&nbsp;</p></span
                    >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'de'">
                    <span>
                        <p>
                            Bei Tinqui.ch bem&uuml;hen wir uns, eine faire und
                            transparente Geb&uuml;hren- und Provisionsstruktur
                            f&uuml;r unsere Nutzer anzubieten. Unser Modell ist
                            so konzipiert, dass es sowohl f&uuml;r K&auml;ufer
                            als auch f&uuml;r Verk&auml;ufer attraktiv ist und
                            uns gleichzeitig erm&ouml;glicht, unsere Plattform
                            kontinuierlich zu pflegen und zu verbessern.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Gestaffelte Provisionen nach Preis: Schub
                                f&uuml;r Ihre Verk&auml;ufe</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Um den Verkauf von Artikeln mit geringerem Wert noch
                            attraktiver zu machen, haben wir eine
                            Provisionsskala eingef&uuml;hrt, die sich an den
                            endg&uuml;ltigen Verkaufspreis anpasst:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Artikel bis CHF 50: 4% Provision. Ideal, um den
                                Verkauf von kleinen oder kosteng&uuml;nstigen
                                Artikeln anzukurbeln!
                            </li>
                            <li>
                                Artikel zwischen CHF 51 und CHF 200: 5%
                                Provision. Ein perfektes Gleichgewicht zwischen
                                Gewinn und Wettbewerbsf&auml;higkeit.
                            </li>
                            <li>
                                Artikel zwischen CHF 201 und CHF 500: 6%
                                Provision. Maximieren Sie Ihre Gewinne bei
                                Artikeln im mittleren Preissegment.
                            </li>
                            <li>
                                Artikel &uuml;ber CHF 500: Hier gilt die
                                Kategorieprovision mit dem allgemeinen Abschlag
                                von 0,5% (oder die Top-Kategorieprovision mit
                                dem zus&auml;tzlichen Abschlag von 1,5%, falls
                                zutreffend).
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Provisionen nach Kategorie: Verkaufen Sie mehr,
                                verdienen Sie mehr</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Jede Produktkategorie hat eine spezifische
                            Provision, aber alle profitieren von einer
                            Reduzierung um 0,5%. Dar&uuml;ber hinaus
                            genie&szlig;en unsere Top-Kategorien einen
                            zus&auml;tzlichen Rabatt von 1,5%.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Hier sind die Provisionen pro Kategorie mit den
                            bereits angewandten Reduzierungen:
                        </p>
                        <p>&nbsp;</p>
                        <p>Kategorien mit 5,5% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Tierbedarf</li>
                            <li>Audio, TV &amp; Video</li>
                            <li>Tickets &amp; Gutscheine</li>
                            <li>B&uuml;cher &amp; Comics</li>
                            <li>Kinder &amp; Babys</li>
                            <li>Computer &amp; Netzwerke</li>
                            <li>Filme &amp; TV-Serien</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Kategorien mit 6,5% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Fahrzeugzubeh&ouml;r</li>
                            <li>Heimwerken &amp; Garten</li>
                            <li>Sport</li>
                            <li>Fotografie &amp; Optik</li>
                            <li>Haus &amp; M&ouml;bel</li>
                            <li>Musik &amp; Instrumente</li>
                            <li>Telefonie &amp; Kommunikation</li>
                            <li>Videospiele &amp; Konsolen</li>
                            <li>Spielzeug &amp; Basteln</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Kategorien mit 7,5% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>B&uuml;ro &amp; Handel</li>
                            <li>Modellbau &amp; Hobby</li>
                            <li>Fahrzeuge</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Kategorien mit 8% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Antiquit&auml;ten &amp; Kunst</li>
                            <li>K&ouml;rperpflege &amp; Kosmetik</li>
                            <li>Wein &amp; Gastronomie</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Kategorien mit 8,5% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Sammlerst&uuml;cke &amp; Rarit&auml;ten</li>
                            <li>M&uuml;nzen</li>
                            <li>Briefmarken</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Kategorie mit 8,5% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Uhren &amp; Schmuck</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Top-Kategorien mit 5,5% Provision:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Mode: Nutzen Sie das Potenzial dieses
                                dynamischen Marktes mit einer reduzierten
                                Provision.
                            </li>
                            <li>
                                Elektronik: Steigern Sie Ihre Verk&auml;ufe in
                                einem st&auml;ndig wachsenden Sektor.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Anzeigeneinstellungsgeb&uuml;hren:
                                Flexibilit&auml;t und Optionen f&uuml;r
                                alle</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Um die Verkaufsaktivit&auml;t zu f&ouml;rdern und
                            erschwingliche Optionen anzubieten, kann der
                            Verk&auml;ufer zwischen den folgenden Dauer- und
                            Preisoptionen f&uuml;r seine Anzeigen w&auml;hlen:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Kostenlose Ver&ouml;ffentlichung: Schalten Sie
                                Ihre Anzeigen 7 Tage lang kostenlos, ideal
                                f&uuml;r den Einstieg.
                            </li>
                            <li>
                                Kostenpflichtige Optionen: Wenn Sie eine
                                l&auml;ngere Expositionszeit w&uuml;nschen,
                                w&auml;hlen Sie zwischen 14 Tagen f&uuml;r CHF
                                3,90 oder 30 Tagen f&uuml;r CHF 6,90.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Anzeigen hervorheben: Mehr Sichtbarkeit, mehr
                                Verk&auml;ufe</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Wir bieten die M&ouml;glichkeit, Anzeigen in allen
                            Kategorien hervorzuheben, um Ihren Produkten mehr
                            Sichtbarkeit zu verleihen und die Verk&auml;ufe zu
                            beschleunigen. Dieser Service ist mit
                            zus&auml;tzlichen Kosten f&uuml;r den Verk&auml;ufer
                            verbunden:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Anzeige f&uuml;r 24 Stunden hervorheben: CHF
                                1,99
                            </li>
                            <li>
                                3-Tage-Paket hervorgehoben: CHF 4,99 (33%
                                sparen)
                            </li>
                            <li>
                                7-Tage-Paket hervorgehoben: CHF 9,99 (50%
                                sparen)
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            F&uuml;r Anzeigen von Artikeln mit einem Wert von
                            CHF 100 oder mehr betragen die Kosten f&uuml;r das
                            Hervorheben der Anzeige 1% des Artikelpreises pro 24
                            Stunden.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Durch das Hervorheben Ihrer Anzeige erscheint sie in
                            den ersten Positionen der Auflistungen und
                            Suchergebnisse und sticht aus der Konkurrenz heraus.
                            Das bedeutet:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Mehr Sichtbarkeit und Klicks auf Ihre Anzeige
                            </li>
                            <li>Mehr Kontakte von potenziellen K&auml;ufern</li>
                            <li>
                                Schnellere Verk&auml;ufe durch Erreichen eines
                                gr&ouml;&szlig;eren Publikums
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Sie k&ouml;nnen Ihre Anzeige ganz einfach &uuml;ber
                            das Optionsmen&uuml; der Anzeige hervorheben, indem
                            Sie die gew&uuml;nschte Dauer ausw&auml;hlen. Die
                            Kosten werden vor der Best&auml;tigung klar
                            angezeigt.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Nutzen Sie diese Gelegenheit, um Ihren
                            Verk&auml;ufen auf Tinqui.ch einen Schub zu geben!
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Hinweis: Wir begrenzen die Anzahl der gleichzeitig
                            hervorgehobenen Anzeigen, um deren Sichtbarkeit und
                            Wirksamkeit zu gew&auml;hrleisten.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Geb&uuml;hren f&uuml;r die Zahlungsabwicklung:
                                Sicherheit und Vertrauen</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Bei Tinqui.ch variieren die Geb&uuml;hren f&uuml;r
                            die Zahlungsabwicklung je nach der vom K&auml;ufer
                            gew&auml;hlten Methode und werden vom Verk&auml;ufer
                            getragen:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Kredit- und Debitkarten: 2,9% + CHF 0,30 pro
                                Transaktion
                            </li>
                            <li>Twint: 1,5% pro Transaktion</li>
                            <li>Bank&uuml;berweisung: 1% pro Transaktion</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Diese Geb&uuml;hren erm&ouml;glichen es uns, einen
                            sicheren und zuverl&auml;ssigen Zahlungsservice mit
                            Schutz sowohl f&uuml;r den K&auml;ufer als auch
                            f&uuml;r den Verk&auml;ufer anzubieten.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Bei Tinqui.ch glauben wir an faire Geb&uuml;hren,
                            die es unserer Community erm&ouml;glichen, zu
                            gedeihen. Wenn Sie Fragen haben, hilft Ihnen unser
                            Kundendienstteam gerne weiter.
                        </p></span
                    ></ps-label
                >
                <ps-label class="mt-4" v-if="language == 'it'">
                    <span>
                        <p>
                            Su Tinqui.ch, ci impegniamo ad offrire una struttura
                            di tariffe e commissioni giusta e trasparente per i
                            nostri utenti. Il nostro modello &egrave; progettato
                            per essere attraente sia per gli acquirenti che per
                            i venditori, permettendoci allo stesso tempo di
                            mantenere e migliorare continuamente la nostra
                            piattaforma.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Commissioni a scaglioni per prezzo: Impulso per
                                le tue vendite</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Per rendere le vendite di articoli di minor valore
                            ancora pi&ugrave; attraenti, abbiamo implementato
                            una scala di commissioni che si adatta al prezzo di
                            vendita finale:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Articoli fino a CHF 50: commissione del 4%.
                                Ideale per stimolare la vendita di piccoli
                                articoli o a basso costo!
                            </li>
                            <li>
                                Articoli tra CHF 51 e CHF 200: commissione del
                                5%. Un perfetto equilibrio tra profitti e
                                competitivit&agrave;.
                            </li>
                            <li>
                                Articoli tra CHF 201 e CHF 500: commissione del
                                6%. Massimizza i tuoi guadagni su articoli di
                                fascia media.
                            </li>
                            <li>
                                Articoli superiori a CHF 500: qui si applica la
                                commissione della categoria con la riduzione
                                generale dello 0,5% (o la commissione della
                                categoria Top con l'ulteriore riduzione
                                dell'1,5%, se applicabile).
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Commissioni per Categoria: Vendi di pi&ugrave;,
                                Guadagna di pi&ugrave;</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Ogni categoria di prodotto ha una commissione
                            specifica, ma tutte beneficiano di una riduzione
                            dello 0,5%. Inoltre, le nostre categorie Top godono
                            di un ulteriore sconto dell'1,5%.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Ecco le commissioni per categoria con le riduzioni
                            gi&agrave; applicate:
                        </p>
                        <p>&nbsp;</p>
                        <p>Categorie con commissione del 5,5%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Accessori per animali</li>
                            <li>Audio, TV e Video</li>
                            <li>Biglietti e Buoni</li>
                            <li>Libri e Fumetti</li>
                            <li>Bambini e Neonati</li>
                            <li>Computer e Reti</li>
                            <li>Film e Serie TV</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Categorie con commissione del 6,5%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Accessori per veicoli</li>
                            <li>Fai da te e Giardino</li>
                            <li>Sport</li>
                            <li>Fotografia e Ottica</li>
                            <li>Casa e Arredamento</li>
                            <li>Musica e Strumenti</li>
                            <li>Telefonia e Comunicazioni</li>
                            <li>Videogiochi e Console</li>
                            <li>Giocattoli e Hobby creativi</li>
                        </ul>

                        <p>&nbsp;</p>
                        <p>Categorie con commissione del 7,5%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Ufficio e Commercio</li>
                            <li>Modellismo e Hobby</li>
                            <li>Veicoli</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Categorie con commissione dell'8%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Antiquariato e Arte</li>
                            <li>Cura personale e Cosmetici</li>
                            <li>Vini e Gastronomia</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Categorie con commissione dell'8,5%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Collezionismo e Rarit&agrave;</li>
                            <li>Monete</li>
                            <li>Francobolli</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Categoria con commissione dell'8,5%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Orologi e Gioielli</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>Categorie Top con commissione del 5,5%:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Moda: Approfitta del potenziale di questo
                                mercato dinamico con una commissione ridotta.
                            </li>
                            <li>
                                Elettronica: Dai impulso alle tue vendite in un
                                settore in costante crescita.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Tariffe di inserzione annunci:
                                Flessibilit&agrave; e opzioni per tutti</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Per incoraggiare l'attivit&agrave; di vendita e
                            offrire opzioni accessibili, il venditore pu&ograve;
                            scegliere tra le seguenti opzioni di durata e prezzo
                            per i suoi annunci:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Pubblicazione gratuita: Pubblica i tuoi annunci
                                per 7 giorni senza alcun costo, ideale per
                                iniziare.
                            </li>
                            <li>
                                Opzioni a pagamento: Se desideri un maggiore
                                tempo di esposizione, scegli tra 14 giorni a CHF
                                3,90 o 30 giorni a CHF 6,90.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Evidenziare gli annunci: Maggiore
                                visibilit&agrave;, maggiori vendite</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Offriamo l'opzione di evidenziare gli annunci in
                            tutte le categorie, per dare maggiore
                            visibilit&agrave; ai tuoi prodotti e accelerare le
                            vendite. Questo servizio ha un costo aggiuntivo a
                            carico del venditore:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>Evidenziare l'annuncio per 24 ore: CHF 1,99</li>

                            <li>
                                Pacchetto di 3 giorni in evidenza: CHF 4,99
                                (risparmia il 33%)
                            </li>
                            <li>
                                Pacchetto di 7 giorni in evidenza: CHF 9,99
                                (risparmia il 50%)
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Per annunci di articoli con un valore pari o
                            superiore a CHF 100, il costo per evidenziare
                            l'annuncio sar&agrave; dell'1% del prezzo
                            dell'articolo per ogni 24 ore.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Evidenziando il tuo annuncio, apparir&agrave; nelle
                            prime posizioni degli elenchi e dei risultati di
                            ricerca, distinguendosi dalla concorrenza. Questo si
                            traduce in:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Pi&ugrave; visibilit&agrave; e clic sul tuo
                                annuncio
                            </li>
                            <li>
                                Pi&ugrave; contatti da potenziali acquirenti
                            </li>
                            <li>
                                Vendite pi&ugrave; rapide raggiungendo un
                                pubblico pi&ugrave; ampio
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Potrai evidenziare facilmente il tuo annuncio dal
                            menu delle opzioni dell'annuncio, selezionando la
                            durata desiderata. Vedrai chiaramente il costo prima
                            di confermare.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Approfitta di questa opportunit&agrave; per dare una
                            spinta alle tue vendite su Tinqui.ch!
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Nota: Limitiamo il numero di annunci in evidenza
                            simultanei per garantirne la visibilit&agrave; e
                            l'efficacia.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Tariffe per l'elaborazione dei pagamenti:
                                Sicurezza e fiducia</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Su Tinqui.ch, le tariffe per l'elaborazione dei
                            pagamenti variano a seconda del metodo scelto
                            dall'acquirente e sono a carico del venditore:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Carte di credito e di debito: 2,9% + CHF 0,30
                                per transazione
                            </li>
                            <li>Twint: 1,5% per transazione</li>
                            <li>Bonifico bancario: 1% per transazione</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Queste tariffe ci consentono di offrire un servizio
                            di pagamento sicuro e affidabile, con protezione sia
                            per l'acquirente che per il venditore.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Su Tinqui.ch, crediamo in tariffe eque che
                            permettano alla nostra comunit&agrave; di
                            prosperare. Se hai domande, il nostro team di
                            assistenza clienti sar&agrave; lieto di aiutarti.
                        </p>
                        <p>&nbsp;</p></span
                    ></ps-label
                >
                <div v-if="aboutUsStore.loading.value == true">
                    <privacy-skeletor />
                </div>
            </div>
        </template>
    </ps-content-container>
</template>

<script lang="ts">
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelTitle from "@template1/vendor/components/core/label/PsLabelTitle.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PrivacySkeletor from "@template1/vendor/components/modules/privacy/PrivacySkeletor.vue";

import { useAboutUsStoreState } from "@templateCore/store/modules/aboutus/AboutUsStore";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

export default {
    name: "FeesCommissionsView",
    components: {
        PsContentContainer,
        PsLabelTitle,
        PsLabel,
        PrivacySkeletor,
    },
    layout: PsFrontendLayout,
    setup(props) {
        // const pageNumber = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        const aboutUsStore = useAboutUsStoreState();
        const language = localStorage.activeLanguage;

        let psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        aboutUsStore.loadAboutUs(loginUserId);

        // const selected = ref(1);
        // function showNext(numb) {
        //     selected.value = numb;
        // }

        return {
            aboutUsStore,
            language,
        };
    },
};
</script>
<style>
.dot:hover {
    color: green;
    font-size: 20px;
    transition: font-size 0.3s;
}
.dot {
    cursor: pointer;
}
ul.pad-class {
    padding-left: 20px !important;
    list-style-type: disc !important;
    padding-left: 20px !important;
}
</style>
