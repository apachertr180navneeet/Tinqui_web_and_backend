<template>
    <Head :title="$t('internal_wallet')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("internal_wallet") }}
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="language == 'en' || language == 'es'"
                >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'fr'">
                    <span>
                        <p>
                            Chez Tinqui.ch, nous proposons un portefeuille
                            interne qui sert d'interm&eacute;diaire dans les
                            transactions, offrant s&eacute;curit&eacute; et
                            commodit&eacute; aux acheteurs et aux vendeurs.
                            Lorsqu'un acheteur effectue un achat, le montant est
                            pay&eacute; &agrave; Tinqui.ch, et le paiement n'est
                            lib&eacute;r&eacute; au vendeur que lorsque
                            l'acheteur a re&ccedil;u le produit et en est
                            satisfait.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong>Avantages du portefeuille interne</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Le portefeuille interne offre de nombreux avantages
                            :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                <strong>Protection contre la fraude :</strong>
                                Il prot&egrave;ge l'acheteur contre les
                                escroqueries et garantit au vendeur qu'il
                                recevra le paiement une fois le produit
                                exp&eacute;di&eacute;.
                            </li>
                            <li>
                                <strong
                                    >Paiements s&eacute;curis&eacute;s et
                                    rapides :</strong
                                >
                                Il permet aux acheteurs et aux vendeurs
                                d'effectuer des transactions de mani&egrave;re
                                s&ucirc;re et rapide.
                            </li>
                            <li>
                                <strong
                                    >Pas de partage d'informations
                                    financi&egrave;res : </strong
                                >Vos informations financi&egrave;res ne sont
                                jamais partag&eacute;es avec d'autres
                                utilisateurs. Tinqui.ch utilise des mesures de
                                s&eacute;curit&eacute; avanc&eacute;es pour
                                prot&eacute;ger votre solde.
                            </li>
                            <li>
                                <strong>Commodit&eacute; :</strong> Vous n'avez
                                pas besoin de saisir vos donn&eacute;es de
                                paiement &agrave; chaque achat. Les paiements
                                sont trait&eacute;s instantan&eacute;ment.
                            </li>
                            <li>
                                <strong>Sans frais :</strong> Il n'y a pas de
                                frais pour recevoir des paiements ou maintenir
                                un solde dans votre portefeuille. Les frais de
                                retrait de fonds sont minimes.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Comment fonctionne le portefeuille
                                interne</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>Le processus est simple :</p>
                        <p>&nbsp;</p>
                        <ol class="pad-ol-class">
                            <li>
                                L'acheteur paie le montant de l'achat &agrave;
                                Tinqui.ch.
                            </li>
                            <li>
                                Tinqui.ch retient le paiement dans le
                                portefeuille interne.
                            </li>
                            <li>
                                Le vendeur envoie le produit &agrave;
                                l'acheteur.
                            </li>
                            <li>
                                L'acheteur confirme la r&eacute;ception et la
                                satisfaction du produit.
                            </li>
                            <li>
                                Tinqui.ch lib&egrave;re le paiement au vendeur.
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            En cas de probl&egrave;me avec l'achat, l'acheteur
                            peut initier un litige. Tinqui.ch enqu&ecirc;tera et
                            d&eacute;cidera comment le r&eacute;soudre.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Charger et retirer des fonds</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Vous pouvez ajouter des fonds &agrave; votre
                            portefeuille interne facilement en choisissant entre
                            une carte de cr&eacute;dit/d&eacute;bit, un virement
                            bancaire ou Twint. Le solde est
                            cr&eacute;dit&eacute; instantan&eacute;ment pour les
                            cartes et Twint, et en 1 &agrave; 3 jours ouvrables
                            pour les virements.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Vous pouvez transf&eacute;rer votre solde sur votre
                            compte bancaire &agrave; tout moment. Les transferts
                            sont trait&eacute;s en 1 &agrave; 3 jours ouvrables.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >S&eacute;curit&eacute; maximale pour votre
                                solde</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            La s&eacute;curit&eacute; de votre solde est notre
                            priorit&eacute; absolue. Tinqui.ch utilise le
                            cryptage SSL et un stockage s&eacute;curis&eacute;
                            des donn&eacute;es pour prot&eacute;ger votre
                            portefeuille.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Dans le cas improbable d'une activit&eacute; non
                            autoris&eacute;e, notre &eacute;quipe d'assistance
                            est pr&ecirc;te &agrave; vous aider et &agrave;
                            s'assurer que votre solde est prot&eacute;g&eacute;.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Commencez &agrave; utiliser votre portefeuille
                                interne d&egrave;s aujourd'hui</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Le portefeuille interne rend l'achat et la vente sur
                            Tinqui.ch encore plus facile et s&ucirc;r. Pour
                            commencer, connectez-vous simplement et allez dans
                            la section "Portefeuille".
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Si vous avez des questions ou avez besoin d'aide,
                            notre &eacute;quipe d'assistance est l&agrave; pour
                            vous.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Contactez-nous via le formulaire en ligne ou envoyez
                            un e-mail &agrave;
                            <a class="mail-cls" href="mailto:info@tinqui.ch"
                                >info@tinqui.ch</a
                            >.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Profitez de la commodit&eacute; et de la
                            s&eacute;curit&eacute; de votre portefeuille interne
                            sur Tinqui.ch !
                        </p></span
                    >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'de'">
                    <span>
                        <p>
                            Bei Tinqui.ch bieten wir ein internes Portemonnaie
                            an, das bei Transaktionen als Vermittler fungiert
                            und sowohl K&auml;ufern als auch Verk&auml;ufern
                            Sicherheit und Komfort bietet. Wenn ein K&auml;ufer
                            einen Kauf t&auml;tigt, wird der Betrag an Tinqui.ch
                            gezahlt, und die Zahlung wird erst dann an den
                            Verk&auml;ufer freigegeben, wenn der K&auml;ufer das
                            Produkt erhalten hat und damit zufrieden ist.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong>Vorteile des internen Portemonnaies</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Das interne Portemonnaie bietet zahlreiche Vorteile:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                <strong>Schutz vor Betrug</strong>: Es
                                sch&uuml;tzt den K&auml;ufer vor Betrug und
                                garantiert dem Verk&auml;ufer, dass er die
                                Zahlung erh&auml;lt, sobald das Produkt versandt
                                wurde.
                            </li>
                            <li>
                                <strong>Sichere und schnelle Zahlungen</strong>:
                                Es erm&ouml;glicht K&auml;ufern und
                                Verk&auml;ufern, Transaktionen sicher und
                                schnell durchzuf&uuml;hren.
                            </li>
                            <li>
                                <strong>Keine Weitergabe von Finanzdaten</strong
                                >: Ihre Finanzdaten werden niemals an andere
                                Benutzer weitergegeben. Tinqui.ch verwendet
                                fortschrittliche Sicherheitsma&szlig;nahmen, um
                                Ihr Guthaben zu sch&uuml;tzen.
                            </li>
                            <li>
                                <strong>Bequemlichkeit</strong>: Sie m&uuml;ssen
                                Ihre Zahlungsdaten nicht bei jedem Kauf
                                eingeben. Zahlungen werden sofort verarbeitet.
                            </li>
                            <li>
                                <strong>Keine Geb&uuml;hren</strong>: Es fallen
                                keine Geb&uuml;hren f&uuml;r den Empfang von
                                Zahlungen oder die Verwaltung des Guthabens in
                                Ihrem Portemonnaie an. Die Geb&uuml;hren
                                f&uuml;r die Auszahlung von Guthaben sind
                                minimal.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Wie funktioniert das interne
                                Portemonnaie</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>Der Prozess ist einfach:</p>
                        <p>&nbsp;</p>
                        <ol class="pad-ol-class">
                            <li>
                                Der K&auml;ufer zahlt den Kaufbetrag an
                                Tinqui.ch.
                            </li>
                            <li>
                                Tinqui.ch h&auml;lt die Zahlung im internen
                                Portemonnaie zur&uuml;ck.
                            </li>
                            <li>
                                Der Verk&auml;ufer versendet das Produkt an den
                                K&auml;ufer.
                            </li>
                            <li>
                                Der K&auml;ufer best&auml;tigt den Erhalt und
                                die Zufriedenheit mit dem Produkt.
                            </li>
                            <li>
                                Tinqui.ch gibt die Zahlung an den Verk&auml;ufer
                                frei.
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            Im Falle von Problemen mit dem Kauf kann der
                            K&auml;ufer einen Streitfall er&ouml;ffnen.
                            Tinqui.ch wird den Fall untersuchen und entscheiden,
                            wie er gel&ouml;st werden soll.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Guthaben aufladen und abheben</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Sie k&ouml;nnen Ihr internes Portemonnaie ganz
                            einfach aufladen, indem Sie zwischen
                            Kredit-/Debitkarte, Bank&uuml;berweisung oder Twint
                            w&auml;hlen. Das Guthaben wird bei Karten und Twint
                            sofort und bei &Uuml;berweisungen innerhalb von 1-3
                            Werktagen gutgeschrieben.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Sie k&ouml;nnen Ihr Guthaben jederzeit auf Ihr
                            Bankkonto &uuml;berweisen. &Uuml;berweisungen werden
                            innerhalb von 1-3 Werktagen bearbeitet.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Maximale Sicherheit f&uuml;r Ihr
                                Guthaben</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Die Sicherheit Ihres Guthabens hat f&uuml;r uns
                            oberste Priorit&auml;t. Tinqui.ch verwendet
                            SSL-Verschl&uuml;sselung und sichere
                            Datenspeicherung, um Ihr Portemonnaie zu
                            sch&uuml;tzen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            In dem unwahrscheinlichen Fall einer unbefugten
                            Aktivit&auml;t ist unser Support-Team bereit, Ihnen
                            zu helfen und sicherzustellen, dass Ihr Guthaben
                            gesch&uuml;tzt ist.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Nutzen Sie Ihr internes Portemonnaie noch
                                heute</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Das interne Portemonnaie macht das Kaufen und
                            Verkaufen auf Tinqui.ch noch einfacher und sicherer.
                            Um zu beginnen, melden Sie sich einfach an und gehen
                            Sie zum Abschnitt "Portemonnaie".
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Wenn Sie Fragen haben oder Hilfe ben&ouml;tigen,
                            steht Ihnen unser Support-Team gerne zur
                            Verf&uuml;gung.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Kontaktieren Sie uns &uuml;ber das Online-Formular
                            oder senden Sie eine E-Mail an
                            <a class="mail-cls" href="mailto:info@tinqui.ch"
                                >info@tinqui.ch</a
                            >.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Genie&szlig;en Sie den Komfort und die Sicherheit
                            Ihres internen Portemonnaies auf Tinqui.ch!
                        </p></span
                    >
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'it'">
                    <span>
                        <p>
                            Su Tinqui.ch, offriamo un portafoglio interno che
                            funge da intermediario nelle transazioni, fornendo
                            sicurezza e comodit&agrave; sia per gli acquirenti
                            che per i venditori. Quando un acquirente effettua
                            un acquisto, l'importo viene pagato a Tinqui.ch e il
                            pagamento non viene rilasciato al venditore fino a
                            quando l'acquirente non ha ricevuto il prodotto ed
                            &egrave; soddisfatto.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Vantaggi del portafoglio interno</strong></p>
                        <p>&nbsp;</p>
                        <p>Il portafoglio interno offre numerosi vantaggi:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                <strong>Protezione dalle frodi</strong>:
                                protegge l'acquirente dalle truffe e garantisce
                                al venditore che ricever&agrave; il pagamento
                                una volta spedito il prodotto.
                            </li>
                            <li>
                                <strong>Pagamenti sicuri e rapidi</strong>:
                                consente ad acquirenti e venditori di effettuare
                                transazioni in modo sicuro e rapido.
                            </li>
                            <li>
                                <strong
                                    >Nessuna condivisione di informazioni
                                    finanziarie</strong
                                >: le tue informazioni finanziarie non vengono
                                mai condivise con altri utenti. Tinqui.ch
                                utilizza misure di sicurezza avanzate per
                                proteggere il tuo saldo.
                            </li>
                            <li>
                                <strong>Comodit&agrave;</strong>: non &egrave;
                                necessario inserire i dati di pagamento ad ogni
                                acquisto. I pagamenti vengono elaborati
                                istantaneamente.
                            </li>
                            <li>
                                <strong>Senza commissioni</strong>: non ci sono
                                commissioni per ricevere pagamenti o mantenere
                                il saldo nel tuo portafoglio. Le commissioni per
                                il prelievo di fondi sono minime.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Come funziona il portafoglio interno</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>Il processo &egrave; semplice:</p>
                        <p>&nbsp;</p>
                        <ol class="pad-ol-class">
                            <li>
                                L'acquirente paga l'importo dell'acquisto a
                                Tinqui.ch.
                            </li>
                            <li>
                                Tinqui.ch trattiene il pagamento nel portafoglio
                                interno.
                            </li>
                            <li>
                                Il venditore spedisce il prodotto
                                all'acquirente.
                            </li>
                            <li>
                                L'acquirente conferma la ricezione e la
                                soddisfazione per il prodotto.
                            </li>
                            <li>
                                Tinqui.ch rilascia il pagamento al venditore.
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p>
                            In caso di problemi con l'acquisto, l'acquirente
                            pu&ograve; avviare una controversia. Tinqui.ch
                            indagher&agrave; e decider&agrave; come risolverla.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Caricare e prelevare fondi</strong></p>
                        <p>
                            Puoi aggiungere facilmente fondi al tuo portafoglio
                            interno scegliendo tra carta di credito/debito,
                            bonifico bancario o Twint. Il saldo viene
                            accreditato istantaneamente per carte e Twint e in
                            1-3 giorni lavorativi per i bonifici.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Puoi trasferire il tuo saldo sul tuo conto bancario
                            in qualsiasi momento. I trasferimenti vengono
                            elaborati in 1-3 giorni lavorativi.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong>Massima sicurezza per il tuo saldo</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            La sicurezza del tuo saldo &egrave; la nostra
                            massima priorit&agrave;. Tinqui.ch utilizza la
                            crittografia SSL e l'archiviazione sicura dei dati
                            per proteggere il tuo portafoglio.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Nell'improbabile caso di attivit&agrave; non
                            autorizzate, il nostro team di supporto &egrave;
                            pronto ad assisterti e ad assicurarsi che il tuo
                            saldo sia protetto.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Inizia a usare il tuo portafoglio interno
                                oggi</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Il portafoglio interno rende l'acquisto e la vendita
                            su Tinqui.ch ancora pi&ugrave; facile e sicuro. Per
                            iniziare, accedi semplicemente e vai alla sezione
                            "Portafoglio".
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Se hai domande o hai bisogno di aiuto, il nostro
                            team di supporto &egrave; qui per te. Contattaci
                            tramite il modulo online o invia un'e-mail a
                            <a class="mail-cls" href="mailto:info@tinqui.ch"
                                >info@tinqui.ch</a
                            >.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Goditi la comodit&agrave; e la sicurezza del tuo
                            portafoglio interno su Tinqui.ch!
                        </p>
                        <p>&nbsp;</p></span
                    >
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
    name: "InternalWalletView",
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
ol.pad-ol-class {
    padding-left: 20px !important;
    list-style-type: decimal !important;
    padding-left: 20px !important;
}
.mail-cls {
    color: blue !important;
    color: inherit;
    text-decoration: underline !important;
}
</style>
