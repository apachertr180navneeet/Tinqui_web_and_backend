<template>
    <Head :title="$t('ad_types')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("ad_types") }}
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="language == 'en' || language == 'es'"
                >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'fr'">
                    <span>
                        <p>
                            Chez Tinqui.ch, nous proposons une
                            vari&eacute;t&eacute; de formats publicitaires pour
                            vous permettre de pr&eacute;senter vos produits ou
                            services de la mani&egrave;re la plus efficace. Que
                            vous vendiez un article unique, que vous fassiez la
                            promotion d'une gamme de produits ou que vous
                            r&eacute;alisiez une ench&egrave;re en direct, nous
                            avons une solution publicitaire pour vous.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>
                                    1. Ench&egrave;res vid&eacute;o en
                                    direct</strong
                                >
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Vous voulez l'excitation d'une ench&egrave;re en
                            temps r&eacute;el ? Essayez nos ench&egrave;res
                            vid&eacute;o en direct. Ces annonces comprennent :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Date de publication et utilisateur qui publie
                                l'annonce
                            </li>
                            <li>
                                Titre descriptif et description
                                d&eacute;taill&eacute;e de l'article
                            </li>
                            <li>
                                Date et heure de cl&ocirc;ture de
                                l'ench&egrave;re, y compris le fuseau horaire
                            </li>
                            <li>
                                Type d'article (d'occasion, neuf ou
                                reconditionn&eacute;) et garantie du produit
                            </li>
                            <li>
                                Prix de d&eacute;part de l'ench&egrave;re et
                                historique des ench&egrave;res
                            </li>
                            <li>
                                Salle vid&eacute;o en direct
                                int&eacute;gr&eacute;e avec une limite maximale
                                de 30 minutes
                            </li>
                            <li>
                                M&eacute;thodes de paiement accept&eacute;es et
                                d&eacute;tails sur la protection des acheteurs
                                de Tinqui
                            </li>
                            <li>
                                D&eacute;tails de livraison ou de retrait, chat
                                avec filtres et options de partage sur les
                                r&eacute;seaux sociaux
                            </li>
                            <li>
                                Possibilit&eacute; de signaler l'annonce,
                                conditions g&eacute;n&eacute;rales et conseils
                                de s&eacute;curit&eacute;
                            </li>
                            <li>
                                Articles connexes, questions fr&eacute;quentes
                                et avis du vendeur
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>2. Vente aux ench&egrave;res</strong>
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Les ventes aux ench&egrave;res sont parfaites pour
                            les vendeurs qui veulent cr&eacute;er de
                            l'enthousiasme et de la demande autour d'un article
                            unique. Ces annonces comprennent :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Date de publication et utilisateur qui publie
                                l'annonce
                            </li>
                            <li>
                                Titre descriptif et description
                                d&eacute;taill&eacute;e de l'article
                            </li>
                            <li>
                                Date et heure de cl&ocirc;ture de
                                l'ench&egrave;re, y compris le fuseau horaire
                            </li>
                            <li>
                                Type d'article (d'occasion, neuf ou
                                reconditionn&eacute;) et garantie du produit
                            </li>
                            <li>
                                Prix de d&eacute;part de l'ench&egrave;re et
                                historique des ench&egrave;res
                            </li>
                            <li>
                                Jusqu'&agrave; 5 photos de haute qualit&eacute;
                                ou 1 vid&eacute;o de 30 seconds
                            </li>
                            <li>
                                M&eacute;thodes de paiement accept&eacute;es et
                                d&eacute;tails sur la protection des acheteurs
                                de Tinqui
                            </li>
                            <li>
                                D&eacute;tails de livraison ou de retrait, chat
                                avec filtres et options de partage sur les
                                r&eacute;seaux sociaux
                            </li>
                            <li>
                                Possibilit&eacute; de signaler l'annonce,
                                conditions g&eacute;n&eacute;rales et conseils
                                de s&eacute;curit&eacute;
                            </li>
                            <li>
                                Articles connexes, questions fr&eacute;quentes
                                et avis du vendeur
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li>
                                <strong>3. Vente &agrave; prix fixe</strong>
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Si vous pr&eacute;f&eacute;rez vendre &agrave; un
                            prix &eacute;tabli, les ventes &agrave; prix fixe
                            sont faites pour vous. Ces annonces comprennent :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Date de publication et utilisateur qui publie
                                l'annonce
                            </li>
                            <li>
                                Titre descriptif et description
                                d&eacute;taill&eacute;e de l'article
                            </li>
                            <li>
                                Type d'article (d'occasion, neuf ou
                                reconditionn&eacute;) et garantie du produit
                            </li>
                            <li>Prix fixe</li>
                            <li>
                                Jusqu'&agrave; 5 photos de haute qualit&eacute;
                                ou 1 vid&eacute;o de 30 seconds
                            </li>
                            <li>
                                M&eacute;thodes de paiement accept&eacute;es et
                                d&eacute;tails sur la protection des acheteurs
                                de Tinqui
                            </li>
                            <li>
                                D&eacute;tails de livraison ou de retrait, chat
                                avec filtres et options de partage sur les
                                r&eacute;seaux sociaux
                            </li>
                            <li>
                                Possibilit&eacute; de signaler l'annonce,
                                conditions g&eacute;n&eacute;rales et conseils
                                de s&eacute;curit&eacute;
                            </li>
                            <li>
                                Articles connexes, questions fr&eacute;quentes
                                et avis du vendeur
                            </li>
                            <li>
                                Date de fin de l'annonce (de 1 &agrave; 30 jours
                                maximum)
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong>Choisissez votre format d'annonce</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Pour commencer votre annonce, connectez-vous
                            simplement &agrave; votre compte Tinqui.ch et allez
                            dans "Publier une annonce". Vous serez guid&eacute;
                            tout au long du processus de cr&eacute;ation
                            &eacute;tape par &eacute;tape.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Si vous n'&ecirc;tes pas s&ucirc;r du format
                            d'annonce qui vous convient, notre &eacute;quipe
                            d'assistance est l&agrave; pour vous aider.
                            Contactez-nous via le formulaire en ligne ou envoyez
                            un e-mail &agrave;
                            <a class="mail-cls" href="mailto:info@tinqui.ch"
                                >info@tinqui.ch</a
                            >.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Avec les diff&eacute;rents formats d'annonces
                            disponibles sur Tinqui.ch, vous &ecirc;tes s&ucirc;r
                            de trouver une option adapt&eacute;e &agrave; vos
                            besoins de vente. Commencez &agrave; annoncer
                            d&egrave;s aujourd'hui et atteignez notre
                            communaut&eacute; d'acheteurs actifs !
                        </p>
                        <p>&nbsp;</p></span
                    >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'de'">
                    <span>
                        <p>
                            Bei Tinqui.ch bieten wir eine Vielzahl von
                            Anzeigenformaten an, damit Sie Ihre Produkte oder
                            Dienstleistungen auf die effektivste Weise
                            pr&auml;sentieren k&ouml;nnen. Egal, ob Sie einen
                            einzigartigen Artikel verkaufen, eine Produktpalette
                            bewerben oder eine Live-Auktion durchf&uuml;hren,
                            wir haben eine Werbem&ouml;glichkeit f&uuml;r Sie.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>1. Live-Video-Auktionen</strong></li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            M&ouml;chten Sie die Spannung einer Echtzeit-Auktion
                            erleben? Probieren Sie unsere Live-Video-Auktionen
                            aus. Diese Anzeigen enthalten:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Ver&ouml;ffentlichungsdatum und Benutzer, der
                                die Anzeige ver&ouml;ffentlicht
                            </li>
                            <li>
                                Aussagekr&auml;ftiger Titel und detaillierte
                                Beschreibung des Artikels
                            </li>
                            <li>
                                Datum und Uhrzeit des Auktionsendes,
                                einschlie&szlig;lich der Zeitzone
                            </li>
                            <li>
                                Artikeltyp (gebraucht, neu oder
                                general&uuml;berholt) und Produktgarantie
                            </li>
                            <li>Startpreis der Auktion und Gebotsverlauf</li>
                            <li>
                                Integrierter Live-Videoraum mit einer maximalen
                                Begrenzung von 30 Minuten
                            </li>
                            <li>
                                Akzeptierte Zahlungsmethoden und Details zum
                                K&auml;uferschutz von Tinqui
                            </li>
                            <li>
                                Liefer- oder Abholdetails, Chat mit Filtern und
                                Optionen zum Teilen in sozialen Netzwerken
                            </li>
                            <li>
                                M&ouml;glichkeit, die Anzeige zu melden,
                                Allgemeine Gesch&auml;ftsbedingungen und
                                Sicherheitstipps
                            </li>
                            <li>
                                Verwandte Artikel, h&auml;ufig gestellte Fragen
                                und Bewertungen des Verk&auml;ufers
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="2">
                            <li><strong>2. Auktionsverkauf</strong></li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Auktionsverk&auml;ufe sind perfekt f&uuml;r
                            Verk&auml;ufer, die Spannung und Nachfrage f&uuml;r
                            einen einzigartigen Artikel erzeugen m&ouml;chten.
                            Diese Anzeigen enthalten:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Ver&ouml;ffentlichungsdatum und Benutzer, der
                                die Anzeige ver&ouml;ffentlicht
                            </li>
                            <li>
                                Aussagekr&auml;ftiger Titel und detaillierte
                                Beschreibung des Artikels
                            </li>
                            <li>
                                Datum und Uhrzeit des Auktionsendes,
                                einschlie&szlig;lich der Zeitzone
                            </li>
                            <li>
                                Artikeltyp (gebraucht, neu oder
                                general&uuml;berholt) und Produktgarantie
                            </li>
                            <li>Startpreis der Auktion und Gebotsverlauf</li>
                            <li>
                                Bis zu 5 hochwertige Fotos oder 1 Video mit
                                maximal 30 Sekunden
                            </li>
                            <li>
                                Akzeptierte Zahlungsmethoden und Details zum
                                K&auml;uferschutz von Tinqui
                            </li>
                            <li>
                                Liefer- oder Abholdetails, Chat mit Filtern und
                                Optionen zum Teilen in sozialen Netzwerken
                            </li>
                            <li>
                                M&ouml;glichkeit, die Anzeige zu melden,
                                Allgemeine Gesch&auml;ftsbedingungen und
                                Sicherheitstipps
                            </li>
                            <li>
                                Verwandte Artikel, h&auml;ufig gestellte Fragen
                                und Bewertungen des Verk&auml;ufers
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li><strong>3. Festpreisverkauf</strong></li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Wenn Sie es vorziehen, zu einem festen Preis zu
                            verkaufen, sind Festpreisverk&auml;ufe das Richtige
                            f&uuml;r Sie. Diese Anzeigen enthalten:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Ver&ouml;ffentlichungsdatum und Benutzer, der
                                die Anzeige ver&ouml;ffentlicht
                            </li>
                            <li>
                                Aussagekr&auml;ftiger Titel und detaillierte
                                Beschreibung des Artikels
                            </li>
                            <li>
                                Artikeltyp (gebraucht, neu oder
                                general&uuml;berholt) und Produktgarantie
                            </li>
                            <li>Festpreis</li>
                            <li>
                                Bis zu 5 hochwertige Fotos oder 1 Video mit
                                maximal 30 Sekunden
                            </li>
                            <li>
                                Akzeptierte Zahlungsmethoden und Details zum
                                K&auml;uferschutz von Tinqui
                            </li>
                            <li>
                                Liefer- oder Abholdetails, Chat mit Filtern und
                                Optionen zum Teilen in sozialen Netzwerken
                            </li>
                            <li>
                                M&ouml;glichkeit, die Anzeige zu melden,
                                Allgemeine Gesch&auml;ftsbedingungen und
                                Sicherheitstipps
                            </li>
                            <li>
                                Verwandte Artikel, h&auml;ufig gestellte Fragen
                                und Bewertungen des Verk&auml;ufers
                            </li>
                            <li>
                                Enddatum der Anzeige (maximal 1 bis 30 Tage)
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong>W&auml;hlen Sie Ihr Anzeigenformat</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Um mit Ihrer Anzeige zu beginnen, melden Sie sich
                            einfach bei Ihrem Tinqui.ch-Konto an und gehen Sie
                            zu "Anzeige aufgeben". Sie werden Schritt f&uuml;r
                            Schritt durch den Erstellungsprozess gef&uuml;hrt.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Wenn Sie sich nicht sicher sind, welches
                            Anzeigenformat f&uuml;r Sie geeignet ist, steht
                            Ihnen unser Support-Team gerne zur Verf&uuml;gung.
                            Kontaktieren Sie uns &uuml;ber das Online-Formular
                            oder senden Sie eine E-Mail an
                            <a class="mail-cls" href="mailto:info@tinqui.ch"
                                >info@tinqui.ch</a
                            >.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Mit den verschiedenen Anzeigenformaten, die auf
                            Tinqui.ch verf&uuml;gbar sind, werden Sie sicherlich
                            eine Option finden, die Ihren Verkaufsanforderungen
                            entspricht. Beginnen Sie noch heute mit der Werbung
                            und erreichen Sie unsere Gemeinschaft aktiver
                            K&auml;ufer!
                        </p></span
                    >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'it'">
                    <span>
                        <p>
                            Su Tinqui.ch, offriamo una variet&agrave; di formati
                            pubblicitari per presentare i tuoi prodotti o
                            servizi nel modo pi&ugrave; efficace. Che tu stia
                            vendendo un articolo unico, promuovendo una gamma di
                            prodotti o conducendo un'asta dal vivo, abbiamo una
                            soluzione pubblicitaria per te.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>1. Aste video in diretta</strong></li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Vuoi l'emozione di un'asta in tempo reale? Prova le
                            nostre aste video in diretta. Questi annunci
                            includono:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Data di pubblicazione e utente che pubblica
                                l'annuncio
                            </li>
                            <li>
                                Titolo descrittivo e descrizione dettagliata
                                dell'articolo
                            </li>
                            <li>
                                Data e ora di chiusura dell'asta, incluso il
                                fuso orario
                            </li>
                            <li>
                                Tipo di articolo (usato, nuovo o ricondizionato)
                                e garanzia del prodotto
                            </li>
                            <li>
                                Prezzo di partenza dell'asta e cronologia delle
                                offerte
                            </li>
                            <li>
                                Sala video integrata dal vivo con un limite
                                massimo di 30 minuti
                            </li>
                            <li>
                                Metodi di pagamento accettati e dettagli sulla
                                protezione dell'acquirente di Tinqui
                            </li>
                            <li>
                                Dettagli di consegna o ritiro, chat con filtri e
                                opzioni per la condivisione sui social media
                            </li>
                            <li>
                                Possibilit&agrave; di segnalare l'annuncio,
                                termini e condizioni e consigli di sicurezza
                            </li>
                            <li>
                                Articoli correlati, domande frequenti e
                                recensioni del venditore
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="2">
                            <li><strong>2. Vendita tipo asta</strong></li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Le vendite tipo asta sono perfette per i venditori
                            che vogliono creare entusiasmo e domanda attorno a
                            un articolo unico. Questi annunci includono:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Data di pubblicazione e utente che pubblica
                                l'annuncio
                            </li>
                            <li>
                                Titolo descrittivo e descrizione dettagliata
                                dell'articolo
                            </li>
                            <li>
                                Data e ora di chiusura dell'asta, incluso il
                                fuso orario
                            </li>
                            <li>
                                Tipo di articolo (usato, nuovo o ricondizionato)
                                e garanzia del prodotto
                            </li>
                            <li>
                                Prezzo di partenza dell'asta e cronologia delle
                                offerte
                            </li>
                            <li>
                                Fino a 5 foto di alta qualit&agrave; o 1 video
                                di massimo 30 secondi
                            </li>
                            <li>
                                Metodi di pagamento accettati e dettagli sulla
                                protezione dell'acquirente di Tinqui
                            </li>
                            <li>
                                Dettagli di consegna o ritiro, chat con filtri e
                                opzioni per la condivisione sui social media
                            </li>
                            <li>
                                Possibilit&agrave; di segnalare l'annuncio,
                                termini e condizioni e consigli di sicurezza
                            </li>
                            <li>
                                Articoli correlati, domande frequenti e
                                recensioni del venditore
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li><strong>3. Vendita a prezzo fisso</strong></li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Se preferisci vendere a un prezzo stabilito, le
                            vendite a prezzo fisso fanno per te. Questi annunci
                            includono:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Data di pubblicazione e utente che pubblica
                                l'annuncio
                            </li>
                            <li>
                                Titolo descrittivo e descrizione dettagliata
                                dell'articolo
                            </li>
                            <li>
                                Tipo di articolo (usato, nuovo o ricondizionato)
                                e garanzia del prodotto
                            </li>
                            <li>Prezzo fisso</li>
                            <li>
                                Fino a 5 foto di alta qualit&agrave; o 1 video
                                di massimo 30 secondi
                            </li>
                            <li>
                                Metodi di pagamento accettati e dettagli sulla
                                protezione dell'acquirente di Tinqui
                            </li>
                            <li>
                                Dettagli di consegna o ritiro, chat con filtri e
                                opzioni per la condivisione sui social media
                            </li>
                            <li>
                                Possibilit&agrave; di segnalare l'annuncio,
                                termini e condizioni e consigli di sicurezza
                            </li>
                            <li>
                                Articoli correlati, domande frequenti e
                                recensioni del venditore
                            </li>
                            <li>
                                Data di scadenza dell'annuncio (da 1 a 30 giorni
                                massimo)
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong>Scegli il tuo formato di annuncio</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Per iniziare con il tuo annuncio, accedi
                            semplicemente al tuo account Tinqui.ch e vai su
                            "Pubblica un annuncio". Verrai guidato attraverso il
                            processo di creazione passo dopo passo.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Se non sei sicuro di quale formato di annuncio sia
                            adatto a te, il nostro team di supporto &egrave; qui
                            per aiutarti. Contattaci tramite il modulo online o
                            invia un'e-mail a
                            <a class="mail-cls" href="mailto:info@tinqui.ch"
                                >info@tinqui.ch</a
                            >.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Con i vari formati di annuncio disponibili su
                            Tinqui.ch, sei sicuro di trovare un'opzione che si
                            adatti alle tue esigenze di vendita. Inizia a
                            pubblicizzare oggi e raggiungi la nostra
                            comunit&agrave; di acquirenti attivi!
                        </p>
                        <p>&nbsp;</p>
                    </span>
                </ps-label>
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
    name: "AdTypesView",
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
.mail-cls {
    color: blue !important;
    color: inherit;
    text-decoration: underline !important;
}
</style>
