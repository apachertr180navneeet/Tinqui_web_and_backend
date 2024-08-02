<template>
    <Head :title="$t('privacy_policy__privacy_policy')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("legal_and_privacy") }}
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="
                        aboutUsStore.aboutus.data != null &&
                        (language == 'en' || language == 'es')
                    "
                >
                    <span
                        v-html="aboutUsStore.aboutus.data.privacypolicy"
                        v-once
                    ></span>
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'fr'"
                >
                    <span>
                        <p>
                            Chez Tinqui.ch, nous prenons tr&egrave;s au
                            s&eacute;rieux nos responsabilit&eacute;s
                            l&eacute;gales et notre engagement envers votre
                            confidentialit&eacute;. Nous croyons en la
                            transparence concernant nos politiques et pratiques,
                            afin que vous puissiez utiliser notre plateforme en
                            toute confiance et tranquillit&eacute; d'esprit.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Termes et Conditions</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Nos Termes et Conditions &eacute;tablissent les
                            r&egrave;gles et r&eacute;glementations pour
                            l'utilisation de Tinqui.ch. En acc&eacute;dant ou en
                            utilisant notre plateforme, vous acceptez de vous
                            conformer &agrave; ces conditions, qui couvrent des
                            sujets tels que l'&eacute;ligibilit&eacute; du
                            compte, la conduite des utilisateurs, le contenu
                            interdit, les frais et paiements, et plus encore.
                            Nous vous recommandons de lire attentivement nos
                            Termes et Conditions pour vous assurer de bien
                            comprendre vos droits et responsabilit&eacute;s en
                            tant qu'utilisateur de Tinqui.ch.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Quelques points cl&eacute;s de nos Termes et
                            Conditions incluent :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Vous devez avoir au moins 18 ans ou l'&acirc;ge
                                l&eacute;gal dans votre juridiction pour
                                utiliser Tinqui.ch.
                            </li>
                            <li>
                                Vous &ecirc;tes responsable de maintenir la
                                confidentialit&eacute; de votre compte et mot de
                                passe.
                            </li>
                            <li>
                                Vous acceptez de ne pas publier de contenu
                                ill&eacute;gal, diffamatoire, harcelant ou
                                contrefait.
                            </li>
                            <li>
                                Tinqui.ch n'est pas responsable des transactions
                                entre acheteurs et vendeurs.
                            </li>
                            <li>
                                Nous nous r&eacute;servons le droit de modifier
                                ou d'interrompre le service Tinqui.ch &agrave;
                                tout moment.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong>Politique de Confidentialit&eacute;</strong>
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Votre confidentialit&eacute; est une priorit&eacute;
                            absolue pour nous chez Tinqui.ch. Notre Politique de
                            Confidentialit&eacute; explique comment nous
                            collectons, utilisons, partageons et
                            prot&eacute;geons vos informations personnelles
                            lorsque vous utilisez notre plateforme. Nous nous
                            conformons &agrave; toutes les lois et
                            r&eacute;glementations applicables en mati&egrave;re
                            de protection des donn&eacute;es et ne partagerons
                            jamais vos informations avec des tiers sans votre
                            consentement explicite, sauf lorsque la loi l'exige.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Quelques aspects cl&eacute;s de notre Politique de
                            Confidentialit&eacute; incluent :
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Nous collectons des informations personnelles,
                                telles que votre nom, adresse e-mail et
                                d&eacute;tails de paiement, pour faciliter vos
                                transactions sur Tinqui.ch.
                            </li>
                            <li>
                                Nous utilisons des cookies et des technologies
                                similaires pour personnaliser votre
                                exp&eacute;rience et am&eacute;liorer nos
                                services.
                            </li>
                            <li>
                                Vous pouvez choisir de ne pas recevoir d'e-mails
                                marketing et vous d&eacute;sabonner &agrave;
                                tout moment.
                            </li>
                            <li>
                                Nous mettons en place des mesures de
                                s&eacute;curit&eacute; robustes pour
                                prot&eacute;ger vos informations contre tout
                                acc&egrave;s, modification ou divulgation non
                                autoris&eacute;s.
                            </li>
                            <li>
                                Nous pouvons partager vos informations avec des
                                prestataires de services de confiance qui nous
                                aident &agrave; exploiter Tinqui.ch, sous
                                r&eacute;serve d'obligations de
                                confidentialit&eacute; strictes.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Droits de Propri&eacute;t&eacute;
                                Intellectuelle</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Nous respectons les droits de
                            propri&eacute;t&eacute; intellectuelle et attendons
                            de nos utilisateurs qu'ils fassent de m&ecirc;me.
                            Notre politique sur les Droits de
                            Propri&eacute;t&eacute; Intellectuelle d&eacute;crit
                            comment nous traitons les r&eacute;clamations pour
                            violation de droits d'auteur sur Tinqui.ch,
                            conform&eacute;ment aux lois applicables sur le
                            droit d'auteur, telles que le Digital Millennium
                            Copyright Act (DMCA) aux &Eacute;tats-Unis.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Si vous pensez que votre travail a &eacute;t&eacute;
                            copi&eacute; d'une mani&egrave;re qui constitue une
                            violation du droit d'auteur sur Tinqui.ch, veuillez
                            fournir &agrave; notre Agent d&eacute;sign&eacute;
                            pour les droits d'auteur une notification
                            &eacute;crite incluant toutes les informations
                            requises, comme d&eacute;taill&eacute; dans notre
                            Politique sur les Droits de Propri&eacute;t&eacute;
                            Intellectuelle. Nous enqu&ecirc;terons rapidement
                            sur votre r&eacute;clamation et prendrons les
                            mesures appropri&eacute;es, qui peuvent inclure la
                            suppression du contenu en infraction et la
                            r&eacute;siliation des comptes des contrevenants
                            r&eacute;cidivistes.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Chez Tinqui.ch, nous croyons qu'un march&eacute; en
                            ligne prosp&egrave;re repose sur la confiance, la
                            transparence et le respect mutuel. Nos politiques
                            juridiques et de confidentialit&eacute; sont
                            con&ccedil;ues pour favoriser ces valeurs et
                            cr&eacute;er un environnement s&ucirc;r et
                            &eacute;quitable o&ugrave; tous nos utilisateurs
                            peuvent s'&eacute;panouir. Si vous avez des
                            questions ou des pr&eacute;occupations concernant
                            nos politiques, n'h&eacute;sitez pas &agrave;
                            contacter notre &eacute;quipe de service client pour
                            obtenir des &eacute;claircissements et de
                            l'assistance.
                        </p>
                    </span>
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'de'"
                >
                    <span
                        ><p>
                            Bei Tinqui.ch nehmen wir unsere rechtlichen
                            Verpflichtungen und unser Engagement f&uuml;r Ihren
                            Datenschutz sehr ernst. Wir glauben an Transparenz
                            in Bezug auf unsere Richtlinien und Praktiken, damit
                            Sie unsere Plattform mit Vertrauen und Sicherheit
                            nutzen k&ouml;nnen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Allgemeine Gesch&auml;ftsbedingungen</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Unsere Allgemeinen Gesch&auml;ftsbedingungen legen
                            die Regeln und Vorschriften f&uuml;r die Nutzung von
                            Tinqui.ch fest. Durch den Zugriff auf oder die
                            Nutzung unserer Plattform erkl&auml;ren Sie sich mit
                            diesen Bedingungen einverstanden, die Themen wie
                            Kontoberechtigung, Benutzerverhalten, verbotene
                            Inhalte, Geb&uuml;hren und Zahlungen und mehr
                            abdecken. Wir empfehlen Ihnen, unsere Allgemeinen
                            Gesch&auml;ftsbedingungen sorgf&auml;ltig zu lesen,
                            um sicherzustellen, dass Sie Ihre Rechte und
                            Pflichten als Benutzer von Tinqui.ch verstehen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Einige Kernpunkte unserer Allgemeinen
                            Gesch&auml;ftsbedingungen sind:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Sie m&uuml;ssen mindestens 18 Jahre alt oder in
                                Ihrer Gerichtsbarkeit vollj&auml;hrig sein, um
                                Tinqui.ch zu nutzen.
                            </li>
                            <li>
                                Sie sind verantwortlich f&uuml;r die Wahrung der
                                Vertraulichkeit Ihres Kontos und Passworts.
                            </li>
                            <li>
                                Sie erkl&auml;ren sich damit einverstanden,
                                keine illegalen, verleumderischen,
                                bel&auml;stigenden oder verletzenden Inhalte zu
                                ver&ouml;ffentlichen.
                            </li>
                            <li>
                                Tinqui.ch ist nicht verantwortlich f&uuml;r
                                Transaktionen zwischen K&auml;ufern und
                                Verk&auml;ufern.
                            </li>
                            <li>
                                Wir behalten uns das Recht vor, den
                                Tinqui.ch-Service jederzeit zu &auml;ndern oder
                                zu unterbrechen.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p><strong>Datenschutzrichtlinie</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Ihre Privatsph&auml;re hat f&uuml;r uns bei
                            Tinqui.ch oberste Priorit&auml;t. Unsere
                            Datenschutzrichtlinie erl&auml;utert, wie wir Ihre
                            personenbezogenen Daten erfassen, verwenden,
                            weitergeben und sch&uuml;tzen, wenn Sie unsere
                            Plattform nutzen. Wir halten uns an alle geltenden
                            Datenschutzgesetze und -vorschriften und werden Ihre
                            Daten niemals ohne Ihre ausdr&uuml;ckliche
                            Zustimmung an Dritte weitergeben, es sei denn, dies
                            ist gesetzlich vorgeschrieben.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Einige Kernaspekte unserer Datenschutzrichtlinie
                            sind:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Wir erfassen personenbezogene Daten wie Ihren
                                Namen, Ihre E-Mail-Adresse und Zahlungsdetails,
                                um Ihre Transaktionen auf Tinqui.ch zu
                                erleichtern.
                            </li>
                            <li>
                                Wir verwenden Cookies und &auml;hnliche
                                Technologien, um Ihr Erlebnis zu personalisieren
                                und unsere Dienste zu verbessern.
                            </li>
                            <li>
                                Sie k&ouml;nnen sich jederzeit von
                                Marketing-E-Mails abmelden.
                            </li>
                            <li>
                                Wir setzen robuste Sicherheitsma&szlig;nahmen
                                ein, um Ihre Daten vor unbefugtem Zugriff,
                                &Auml;nderung oder Offenlegung zu sch&uuml;tzen.
                            </li>
                            <li>
                                Wir k&ouml;nnen Ihre Daten an
                                vertrauensw&uuml;rdige Dienstleister
                                weitergeben, die uns beim Betrieb von Tinqui.ch
                                unterst&uuml;tzen, vorbehaltlich strenger
                                Vertraulichkeitsverpflichtungen.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p><strong>Rechte an geistigem Eigentum</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Wir respektieren geistige Eigentumsrechte und
                            erwarten von unseren Nutzern dasselbe. Unsere
                            Richtlinie zu geistigem Eigentum beschreibt, wie wir
                            mit Anspr&uuml;chen wegen Urheberrechtsverletzungen
                            auf Tinqui.ch gem&auml;&szlig; den geltenden
                            Urheberrechtsgesetzen wie dem Digital Millennium
                            Copyright Act (DMCA) in den USA umgehen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Wenn Sie glauben, dass Ihre Arbeit auf eine Weise
                            kopiert wurde, die eine Urheberrechtsverletzung auf
                            Tinqui.ch darstellt, senden Sie bitte eine
                            schriftliche Benachrichtigung an unseren benannten
                            Urheberrechtsbeauftragten, die alle erforderlichen
                            Informationen enth&auml;lt, wie in unserer
                            Richtlinie zu geistigem Eigentum beschrieben. Wir
                            werden Ihren Anspruch umgehend untersuchen und
                            geeignete Ma&szlig;nahmen ergreifen, die die
                            Entfernung von verletzenden Inhalten und die
                            K&uuml;ndigung von Konten von
                            Wiederholungst&auml;tern umfassen k&ouml;nnen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Bei Tinqui.ch glauben wir, dass ein bl&uuml;hender
                            Online-Marktplatz auf Vertrauen, Transparenz und
                            gegenseitigem Respekt beruht. Unsere Rechts- und
                            Datenschutzrichtlinien sollen diese Werte
                            f&ouml;rdern und eine sichere und faire Umgebung
                            schaffen, in der alle unsere Nutzer gedeihen
                            k&ouml;nnen. Wenn Sie Fragen oder Bedenken zu
                            unseren Richtlinien haben, z&ouml;gern Sie bitte
                            nicht, unser Kundendienstteam um Kl&auml;rung und
                            Unterst&uuml;tzung zu bitten.
                        </p>
                        <p>&nbsp;</p>
                    </span>
                </ps-label>

                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'it'"
                >
                    <span>
                        <p>
                            Su Tinqui.ch, prendiamo molto sul serio le nostre
                            responsabilit&agrave; legali e il nostro impegno per
                            la tua privacy. Crediamo nella trasparenza riguardo
                            alle nostre politiche e pratiche, in modo che tu
                            possa utilizzare la nostra piattaforma con fiducia e
                            tranquillit&agrave;.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Termini e Condizioni</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            I nostri Termini e Condizioni stabiliscono le regole
                            e i regolamenti per l'utilizzo di Tinqui.ch.
                            Accedendo o utilizzando la nostra piattaforma,
                            accetti di rispettare questi termini, che coprono
                            argomenti come l'idoneit&agrave; dell'account, la
                            condotta dell'utente, i contenuti vietati, le
                            tariffe e i pagamenti e altro ancora. Ti consigliamo
                            di leggere attentamente i nostri Termini e
                            Condizioni per assicurarti di comprendere i tuoi
                            diritti e le tue responsabilit&agrave; come utente
                            di Tinqui.ch.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Alcuni punti chiave dei nostri Termini e Condizioni
                            includono:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Devi avere almeno 18 anni o l'et&agrave; legale
                                nella tua giurisdizione per utilizzare
                                Tinqui.ch.
                            </li>
                            <li>
                                Sei responsabile di mantenere la riservatezza
                                del tuo account e della password.
                            </li>
                            <li>
                                Accetti di non pubblicare contenuti illegali,
                                diffamatori, molesti o in violazione.
                            </li>
                            <li>
                                Tinqui.ch non &egrave; responsabile per le
                                transazioni tra acquirenti e venditori.
                            </li>
                            <li>
                                Ci riserviamo il diritto di modificare o
                                interrompere il servizio Tinqui.ch in qualsiasi
                                momento.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p><strong>Informativa sulla privacy</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            La tua privacy &egrave; una priorit&agrave; assoluta
                            per noi su Tinqui.ch. La nostra Informativa sulla
                            privacy spiega come raccogliamo, utilizziamo,
                            condividiamo e proteggiamo le tue informazioni
                            personali quando utilizzi la nostra piattaforma.
                            Rispettiamo tutte le leggi e i regolamenti
                            applicabili in materia di protezione dei dati e non
                            condivideremo mai le tue informazioni con terze
                            parti senza il tuo esplicito consenso, se non quando
                            richiesto dalla legge.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Alcuni aspetti chiave della nostra Informativa sulla
                            privacy includono:
                        </p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                Raccogliamo informazioni personali, come nome,
                                indirizzo email e dettagli di pagamento, per
                                facilitare le tue transazioni su Tinqui.ch.
                            </li>
                            <li>
                                Utilizziamo cookie e tecnologie simili per
                                personalizzare la tua esperienza e migliorare i
                                nostri servizi.
                            </li>
                            <li>
                                Puoi scegliere di non ricevere email di
                                marketing e annullare l'iscrizione in qualsiasi
                                momento.
                            </li>
                            <li>
                                Implementiamo robuste misure di sicurezza per
                                proteggere le tue informazioni da accessi non
                                autorizzati, alterazioni o divulgazioni.
                            </li>
                            <li>
                                Possiamo condividere le tue informazioni con
                                fornitori di servizi di fiducia che ci aiutano a
                                gestire Tinqui.ch, soggetti a rigorosi obblighi
                                di riservatezza.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p>
                            <strong
                                >Diritti di propriet&agrave;
                                intellettuale</strong
                            >
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Rispettiamo i diritti di propriet&agrave;
                            intellettuale e ci aspettiamo che i nostri utenti
                            facciano lo stesso. La nostra politica sui diritti
                            di propriet&agrave; intellettuale descrive come
                            gestiamo le richieste di violazione del copyright su
                            Tinqui.ch, in conformit&agrave; con le leggi
                            applicabili sul copyright, come il Digital
                            Millennium Copyright Act (DMCA) negli Stati Uniti.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Se ritieni che il tuo lavoro sia stato copiato in un
                            modo che costituisce una violazione del copyright su
                            Tinqui.ch, fornisci al nostro Agente designato per
                            il copyright una notifica scritta che includa tutte
                            le informazioni richieste, come dettagliato nella
                            nostra Politica sui diritti di propriet&agrave;
                            intellettuale. Indagheremo prontamente sulla tua
                            richiesta e intraprenderemo le azioni appropriate,
                            che possono includere la rimozione dei contenuti in
                            violazione e la chiusura degli account dei
                            trasgressori recidivi.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Su Tinqui.ch, crediamo che un mercato online
                            prospero si basi su fiducia, trasparenza e rispetto
                            reciproco. Le nostre politiche legali e sulla
                            privacy sono progettate per promuovere questi valori
                            e creare un ambiente sicuro ed equo in cui tutti i
                            nostri utenti possano prosperare. Se hai domande o
                            dubbi sulle nostre politiche, non esitare a
                            contattare il nostro team di assistenza clienti per
                            chiarimenti e supporto.
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
import { Head } from "@inertiajs/vue3";
// import { useRoute } from 'vue-router';
// import router from '@template1/router';
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelTitle from "@template1/vendor/components/core/label/PsLabelTitle.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PrivacySkeletor from "@template1/vendor/components/modules/privacy/PrivacySkeletor.vue";

import { useAboutUsStoreState } from "@templateCore/store/modules/aboutus/AboutUsStore";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

export default {
    name: "PrivacyView",
    components: {
        PsContentContainer,
        PsLabelTitle,
        PsLabel,
        PrivacySkeletor,
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
ul.pad-class {
    padding-left: 20px !important;
    list-style-type: disc !important;
    padding-left: 20px !important;
}
</style>
