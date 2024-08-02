<template>
    <Head :title="$t('safety__safety_tips')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("safety__safety_tips") }}
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'en'"
                >
                    <span v-html="aboutUsStore.aboutus.data.safetyTips"> </span>
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'fr'"
                >
                    <span
                        ><p>
                            Chez Tinqui.ch, la s&eacute;curit&eacute; de nos
                            utilisateurs est notre priorit&eacute; absolue. Pour
                            garantir une exp&eacute;rience d'achat et de vente
                            s&ucirc;re, nous vous proposons les conseils
                            suivants :
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>
                                    1. Utilisez le portefeuille interne de
                                    Tinqui.ch</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li>
                                Effectuez toutes les transactions via le
                                portefeuille interne de Tinqui.ch. Cela
                                prot&egrave;ge votre argent et garantit que le
                                paiement ne sera lib&eacute;r&eacute; au vendeur
                                que lorsque vous aurez re&ccedil;u et serez
                                satisfait du produit.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="2">
                            <li>
                                <strong>
                                    2. Ne partagez jamais d'informations
                                    personnelles</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Ne partagez pas votre adresse e-mail, votre
                                num&eacute;ro de t&eacute;l&eacute;phone, votre
                                adresse postale ou vos coordonn&eacute;es
                                bancaires avec d'autres utilisateurs. Toute
                                communication doit se faire via la plateforme
                                Tinqui.ch.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li>
                                <strong>
                                    3. M&eacute;fiez-vous des offres trop belles
                                    pour &ecirc;tre vraies</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Si une affaire semble trop belle pour &ecirc;tre
                                vraie, c'est probablement le cas.
                                M&eacute;fiez-vous des prix excessivement bas ou
                                des promesses exag&eacute;r&eacute;es.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="4">
                            <li>
                                <strong>
                                    4. V&eacute;rifiez la r&eacute;putation du
                                    vendeur</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Avant d'effectuer un achat, consultez les
                                &eacute;valuations et les commentaires du
                                vendeur. Un historique de commentaires positifs
                                indique g&eacute;n&eacute;ralement une
                                transaction s&ucirc;re.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="5">
                            <li>
                                <strong>5. Demandez plus d'informations</strong>
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Si une annonce manque de d&eacute;tails ou si
                                les photos ne sont pas claires, demandez plus
                                d'informations au vendeur. Un vendeur
                                l&eacute;gitime sera ravi de r&eacute;pondre
                                &agrave; vos questions.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="6">
                            <li>
                                <strong>
                                    6. Utilisez des services de paiement
                                    s&eacute;curis&eacute;s</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Pour les paiements en dehors du portefeuille
                                interne de Tinqui.ch, n'utilisez que des
                                services de paiement s&eacute;curis&eacute;s et
                                reconnus, tels que PayPal ou les virements
                                bancaires.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="7">
                            <li>
                                <strong>
                                    7. M&eacute;fiez-vous des e-mails non
                                    sollicit&eacute;s</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                ch ne vous demandera jamais d'informations
                                personnelles ou financi&egrave;res par e-mail.
                                M&eacute;fiez-vous des e-mails non
                                sollicit&eacute;s demandant de telles
                                informations.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="8">
                            <li>
                                <strong>
                                    8. Gardez vos donn&eacute;es de connexion en
                                    s&eacute;curit&eacute;</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Cr&eacute;ez un mot de passe fort pour votre
                                compte Tinqui.ch et ne le partagez avec
                                personne.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="9">
                            <li>
                                <strong>
                                    9. Soyez prudent lors des retraits en
                                    personne</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Si vous d&eacute;cidez de retirer un article en
                                personne, faites-le dans un lieu public et bien
                                &eacute;clair&eacute;. Envisagez d'emmener un
                                ami avec vous.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="10">
                            <li>
                                <strong>
                                    10. Signalez les activit&eacute;s
                                    suspectes</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Si vous trouvez une annonce suspecte ou si vous
                                avez une mauvaise exp&eacute;rience avec un
                                vendeur, signalez-le imm&eacute;diatement
                                &agrave; Tinqui.ch. Notre &eacute;quipe
                                enqu&ecirc;tera sur la situation.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            N'oubliez pas, si quelque chose semble trop beau
                            pour &ecirc;tre vrai, c'est probablement le cas.
                            Faites confiance &agrave; votre instinct et prenez
                            des pr&eacute;cautions pour rester en
                            s&eacute;curit&eacute; lorsque vous achetez et
                            vendez en ligne.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Si vous avez des questions ou des
                            pr&eacute;occupations concernant la
                            s&eacute;curit&eacute;, n'h&eacute;sitez pas
                            &agrave; contacter notre &eacute;quipe d'assistance.
                            Nous sommes l&agrave; pour vous aider.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Profitez d'une exp&eacute;rience s&ucirc;re sur
                            Tinqui.ch !
                        </p></span
                    >
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'de'"
                >
                    <span
                        ><p>
                            Bei Tinqui.ch hat die Sicherheit unserer Nutzer
                            oberste Priorit&auml;t. Um ein sicheres Kauf- und
                            Verkaufserlebnis zu gew&auml;hrleisten, bieten wir
                            Ihnen die folgenden Tipps:
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>
                                    1. Nutzen Sie die interne Geldb&ouml;rse von
                                    Tinqui.ch</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                F&uuml;hren Sie alle Transaktionen &uuml;ber die
                                interne Geldb&ouml;rse von Tinqui.ch durch. Dies
                                sch&uuml;tzt Ihr Geld und stellt sicher, dass
                                die Zahlung erst dann an den Verk&auml;ufer
                                freigegeben wird, wenn Sie das Produkt erhalten
                                haben und zufrieden sind.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="2">
                            <li>
                                <strong>
                                    2. Teilen Sie niemals pers&ouml;nliche
                                    Informationen</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Teilen Sie Ihre E-Mail-Adresse, Telefonnummer,
                                Postanschrift oder Bankdaten nicht mit anderen
                                Nutzern. Die gesamte Kommunikation sollte
                                &uuml;ber die Tinqui.ch-Plattform erfolgen.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li>
                                <strong>
                                    3. Misstrauen Sie Angeboten, die zu gut
                                    sind, um wahr zu sein</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Wenn ein Angebot zu gut erscheint, um wahr zu
                                sein, ist es das wahrscheinlich auch. Seien Sie
                                vorsichtig bei &uuml;berm&auml;&szlig;ig
                                niedrigen Preisen oder &uuml;bertriebenen
                                Versprechungen.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="4">
                            <li>
                                <strong>
                                    4. &Uuml;berpr&uuml;fen Sie den Ruf des
                                    Verk&auml;ufers</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Bevor Sie einen Kauf t&auml;tigen,
                                &uuml;berpr&uuml;fen Sie die Bewertungen und
                                Kommentare des Verk&auml;ufers. Eine Historie
                                positiver Kommentare deutet in der Regel auf
                                eine sichere Transaktion hin.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="5">
                            <li>
                                <strong>
                                    5. Fordern Sie weitere Informationen
                                    an</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Wenn eine Anzeige keine Details enth&auml;lt
                                oder die Fotos unklar sind, fordern Sie weitere
                                Informationen vom Verk&auml;ufer an. Ein
                                seri&ouml;ser Verk&auml;ufer wird Ihre Fragen
                                gerne beantworten.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="6">
                            <li>
                                <strong>
                                    6. Verwenden Sie sichere
                                    Zahlungsdienste</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                F&uuml;r Zahlungen au&szlig;erhalb der internen
                                Geldb&ouml;rse von Tinqui.ch verwenden Sie nur
                                sichere und anerkannte Zahlungsdienste wie
                                PayPal oder Bank&uuml;berweisung.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="7">
                            <li>
                                <strong>
                                    7. Vorsicht vor unaufgeforderten
                                    E-Mails</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Tinqui.ch wird Sie niemals per E-Mail nach
                                pers&ouml;nlichen oder finanziellen
                                Informationen fragen. Misstrauen Sie
                                unaufgeforderten E-Mails, die solche
                                Informationen anfordern.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="8">
                            <li>
                                <strong>
                                    8. Halten Sie Ihre Anmeldedaten
                                    sicher</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Erstellen Sie ein starkes Passwort f&uuml;r Ihr
                                Tinqui.ch-Konto und teilen Sie es mit niemandem.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="9">
                            <li>
                                <strong>
                                    9. Seien Sie vorsichtig bei
                                    pers&ouml;nlichen Abholungen</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Wenn Sie sich entscheiden, einen Artikel
                                pers&ouml;nlich abzuholen, tun Sie dies an einem
                                &ouml;ffentlichen und gut beleuchteten Ort.
                                Erw&auml;gen Sie, einen Freund mitzubringen.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="10">
                            <li>
                                <strong>
                                    10. Melden Sie verd&auml;chtige
                                    Aktivit&auml;ten</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Wenn Sie eine verd&auml;chtige Anzeige finden
                                oder eine schlechte Erfahrung mit einem
                                Verk&auml;ufer machen, melden Sie dies sofort an
                                Tinqui.ch. Unser Team wird die Situation
                                untersuchen.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            Denken Sie daran, wenn etwas zu gut erscheint, um
                            wahr zu sein, ist es das wahrscheinlich auch.
                            Vertrauen Sie Ihrem Instinkt und treffen Sie
                            Vorsichtsma&szlig;nahmen, um beim Online-Kauf und
                            -Verkauf sicher zu bleiben.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Wenn Sie Fragen oder Bedenken zur Sicherheit haben,
                            z&ouml;gern Sie nicht, unser Support-Team zu
                            kontaktieren. Wir sind hier, um Ihnen zu helfen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Genie&szlig;en Sie ein sicheres Erlebnis auf
                            Tinqui.ch!
                        </p></span
                    >
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'it'"
                >
                    <span>
                        <p>
                            Su Tinqui.ch, la sicurezza dei nostri utenti
                            &egrave; la nostra massima priorit&agrave;. Per
                            garantire un'esperienza di acquisto e vendita
                            sicura, ti offriamo i seguenti consigli:
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>
                                    1. Utilizza il portafoglio interno di
                                    Tinqui.ch</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Effettua tutte le transazioni tramite il
                                portafoglio interno di Tinqui.ch. Questo
                                protegge i tuoi soldi e garantisce che il
                                pagamento venga rilasciato al venditore solo
                                quando hai ricevuto e sei soddisfatto del
                                prodotto.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="2">
                            <li>
                                <strong>
                                    2. Non condividere mai informazioni
                                    personali</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Non condividere il tuo indirizzo email, numero
                                di telefono, indirizzo postale o dati bancari
                                con altri utenti. Tutte le comunicazioni devono
                                avvenire tramite la piattaforma Tinqui.ch.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li>
                                <strong>
                                    3. Diffida delle offerte troppo belle per
                                    essere vere</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Se un affare sembra troppo bello per essere
                                vero, probabilmente lo &egrave;. Fai attenzione
                                ai prezzi eccessivamente bassi o alle promesse
                                esagerate.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="4">
                            <li>
                                <strong>
                                    4. Verifica la reputazione del
                                    venditore</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Prima di effettuare un acquisto, controlla le
                                valutazioni e i commenti del venditore. Una
                                cronologia di commenti positivi di solito indica
                                una transazione sicura.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="5">
                            <li>
                                <strong>
                                    5. Chiedi pi&ugrave; informazioni</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Se un annuncio manca di dettagli o le foto non
                                sono chiare, chiedi ulteriori informazioni al
                                venditore. Un venditore legittimo sar&agrave;
                                felice di rispondere alle tue domande.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="6">
                            <li>
                                <strong>
                                    6. Utilizza servizi di pagamento
                                    sicuri</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Per i pagamenti al di fuori del portafoglio
                                interno di Tinqui.ch, utilizza solo servizi di
                                pagamento sicuri e riconosciuti, come PayPal o
                                bonifici bancari.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="7">
                            <li>
                                <strong>
                                    7. Attenzione alle email non
                                    richieste</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Tinqui.ch non ti chieder&agrave; mai
                                informazioni personali o finanziarie via email.
                                Diffida delle email non richieste che richiedono
                                tali informazioni.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="8">
                            <li>
                                <strong>
                                    8. Mantieni al sicuro i tuoi dati di
                                    accesso</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Crea una password forte per il tuo account
                                Tinqui.ch e non condividerla con nessuno.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="9">
                            <li>
                                <strong>
                                    9. Fai attenzione ai ritiri di
                                    persona</strong
                                >
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li class="bullet">
                                Se decidi di ritirare un articolo di persona,
                                fallo in un luogo pubblico e ben illuminato.
                                Considera di portare un amico con te.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <ol start="10">
                            <li>
                                <strong>
                                    10. Segnala attivit&agrave; sospette</strong
                                >
                            </li>
                        </ol>
                        <ul class="pad-class">
                            <li class="bullet">
                                Se trovi un annuncio sospetto o hai
                                un'esperienza negativa con un venditore,
                                segnalalo immediatamente a Tinqui.ch. Il nostro
                                team indagher&agrave; sulla situazione.
                            </li>
                        </ul>
                        <p>
                            Ricorda, se qualcosa sembra troppo bello per essere
                            vero, probabilmente lo &egrave;. Fidati del tuo
                            istinto e prendi precauzioni per rimanere al sicuro
                            quando acquisti e vendi online.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Se hai domande o dubbi sulla sicurezza, non esitare
                            a contattare il nostro team di supporto. Siamo qui
                            per aiutarti.
                        </p>
                        <p>&nbsp;</p>
                        <p>Goditi un'esperienza sicura su Tinqui.ch!</p>
                    </span>
                </ps-label>
            </div>
        </template>
    </ps-content-container>
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelTitle from "@template1/vendor/components/core/label/PsLabelTitle.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";

import { useAboutUsStoreState } from "@templateCore/store/modules/aboutus/AboutUsStore";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

export default {
    name: "SafetyView",
    components: {
        PsContentContainer,
        PsLabelTitle,
        PsLabel,
        Head,
    },
    layout: PsFrontendLayout,
    setup(props) {
        const aboutUsStore = useAboutUsStoreState();
        let psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        aboutUsStore.loadAboutUs(loginUserId);
        const language = localStorage.activeLanguage;

        return {
            aboutUsStore,
            language,
        };
    },
};
</script>
<style>
/* li.bullet {
    list-style-type: circle !important;
} */

ul.pad-class {
    padding-left: 20px !important;
    list-style-type: disc !important;
    padding-left: 20px !important;
}
</style>
