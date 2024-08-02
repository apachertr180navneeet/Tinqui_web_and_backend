<template>
    <Head :title="$t('term_and_condition__term_and_condition')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("term_and_condition__term_and_condition") }}
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="
                        aboutUsStore.aboutus.data != null &&
                        (language == 'en' || language == 'es')
                    "
                >
                    <span
                        v-html="aboutUsStore.aboutus.data.termsAndConditions"
                        v-once
                    ></span>
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'fr'"
                >
                    <span>
                        <!-- <h1>Conditions g&eacute;n&eacute;rales</h1> -->
                        <p>
                            Bienvenue sur Tinqui.ch. Les pr&eacute;sentes
                            conditions g&eacute;n&eacute;rales constituent un
                            contrat juridique entre vous et Tinqui.ch. En
                            acc&eacute;dant &agrave; notre site web et en
                            utilisant nos services, vous acceptez d'&ecirc;tre
                            li&eacute; par ces conditions. Si vous n'&ecirc;tes
                            pas d'accord avec une partie de ces conditions, vous
                            ne pouvez pas acc&eacute;der au site web et aux
                            services de Tinqui.ch.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >1. &Eacute;ligibilit&eacute; et
                                    inscription</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Pour utiliser Tinqui.ch, vous devez avoir au moins
                            18 ans et r&eacute;sider en Suisse. En vous
                            inscrivant, vous d&eacute;clarez que les
                            informations fournies sont v&eacute;ridiques et
                            exactes. Vous &ecirc;tes responsable de la
                            confidentialit&eacute; de votre compte et de votre
                            mot de passe.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>2. Publication d'annonces</strong></li>
                        </ol>
                        <p>
                            En tant que vendeur, vous &ecirc;tes responsable de
                            vous assurer que vos annonces et produits sont
                            conformes &agrave; nos politiques et &agrave; la loi
                            applicable. Tinqui.ch se r&eacute;serve le droit de
                            supprimer toute annonce ou de fermer tout compte qui
                            enfreint ces conditions.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>3. Processus de transaction</strong>
                            </li>
                        </ol>
                        <p>
                            Tinqui.ch facilite les transactions entre acheteurs
                            et vendeurs. Cependant, nous ne sommes partie
                            &agrave; aucun contrat entre utilisateurs. Le
                            vendeur est responsable de pr&eacute;ciser les
                            conditions de vente, y compris le prix,
                            l'exp&eacute;dition et les politiques de retour.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>4. Frais et commissions</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch facture des frais et des commissions pour
                            l'utilisation de nos services, comme
                            sp&eacute;cifi&eacute; dans notre section "Frais et
                            commissions". Nous nous r&eacute;servons le droit de
                            modifier nos frais avec un pr&eacute;avis aux
                            utilisateurs.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >5. Exp&eacute;dition et livraison</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Les vendeurs sont responsables de
                            l'exp&eacute;dition des articles dans les
                            d&eacute;lais sp&eacute;cifi&eacute;s dans
                            l'annonce. Tinqui.ch n'est pas responsable des
                            articles perdus, endommag&eacute;s ou
                            retard&eacute;s pendant l'exp&eacute;dition.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>6. Retours et remboursements</strong>
                            </li>
                        </ol>
                        <p>
                            Les politiques de retour et de remboursement sont
                            d&eacute;termin&eacute;es par chaque vendeur.
                            Tinqui.ch n'est pas responsable de l'application de
                            ces politiques, mais nous encourageons les vendeurs
                            &agrave; r&eacute;soudre tout litige de
                            mani&egrave;re &eacute;quitable et rapide.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >7. Limitation de
                                    responsabilit&eacute;</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Dans toute la mesure permise par la loi, Tinqui.ch
                            ne sera pas responsable des dommages indirects,
                            accessoires, sp&eacute;ciaux, cons&eacute;cutifs ou
                            punitifs, ou de toute perte de
                            b&eacute;n&eacute;fices ou de revenus, qu'ils soient
                            encourus directement ou indirectement, ou de toute
                            perte de donn&eacute;es, d'utilisation, de goodwill
                            ou d'autres pertes intangibles.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >8. Propri&eacute;t&eacute;
                                    intellectuelle</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Le contenu de Tinqui.ch, &agrave; l'exclusion du
                            contenu g&eacute;n&eacute;r&eacute; par les
                            utilisateurs, est la propri&eacute;t&eacute; de
                            Tinqui.ch et est prot&eacute;g&eacute; par les lois
                            sur la propri&eacute;t&eacute; intellectuelle. Les
                            utilisateurs conservent la propri&eacute;t&eacute;
                            de leur contenu, mais nous accordent une licence
                            mondiale, non exclusive et libre de droits pour
                            l'utiliser en relation avec nos services.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>9. R&eacute;siliation</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch se r&eacute;serve le droit de suspendre ou
                            de r&eacute;silier votre compte &agrave; tout moment
                            et pour quelque raison que ce soit, y compris si
                            nous soup&ccedil;onnons que vous avez enfreint ces
                            conditions.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>10. Modifications</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch se r&eacute;serve le droit de modifier ces
                            conditions &agrave; tout moment. Nous vous
                            informerons de tout changement en publiant les
                            nouvelles conditions sur cette page.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            En utilisant Tinqui.ch, vous acceptez d'&ecirc;tre
                            li&eacute; par la version actuelle de ces
                            conditions. Nous vous recommandons de consulter
                            r&eacute;guli&egrave;rement cette page pour
                            &ecirc;tre inform&eacute; de tout changement.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Si vous avez des questions sur ces conditions,
                            veuillez nous contacter via les canaux fournis sur
                            notre site web.
                        </p></span
                    >

                    <!-- <div class="d-flex center mt-4">
                        <span
                            v-for="(number, index) in pageNumber"
                            :key="index"
                            class="dot"
                            @click="showNext(number)"
                        >
                            {{ number }}&nbsp;&nbsp;&nbsp;
                        </span>
                    </div> -->
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'de'"
                >
                    <span>
                        <!-- <ol start="7">
                            <li>
                                <strong>
                                    Allgemeine Gesch&auml;ftsbedingungen</strong
                                >
                            </li>
                        </ol> -->
                        <p>
                            Willkommen bei Tinqui.ch. Diese Allgemeinen
                            Gesch&auml;ftsbedingungen stellen einen
                            rechtsg&uuml;ltigen Vertrag zwischen Ihnen und
                            Tinqui.ch dar. Durch den Zugriff auf oder die
                            Nutzung unserer Website und Dienste erkl&auml;ren
                            Sie sich mit diesen Bedingungen einverstanden. Wenn
                            Sie mit einem Teil dieser Bedingungen nicht
                            einverstanden sind, d&uuml;rfen Sie nicht auf die
                            Website und die Dienste von Tinqui.ch zugreifen.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >1. Berechtigung und Registrierung</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Um Tinqui.ch nutzen zu k&ouml;nnen, m&uuml;ssen Sie
                            mindestens 18 Jahre alt sein und in der Schweiz
                            wohnen. Bei der Registrierung erkl&auml;ren Sie,
                            dass die von Ihnen gemachten Angaben
                            wahrheitsgem&auml;&szlig; und korrekt sind. Sie sind
                            f&uuml;r die Vertraulichkeit Ihres Kontos und
                            Passworts verantwortlich.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="2">
                            <li>
                                <strong
                                    >2. Ver&ouml;ffentlichung von
                                    Anzeigen</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Als Verk&auml;ufer sind Sie daf&uuml;r
                            verantwortlich, dass Ihre Anzeigen und Produkte
                            unseren Richtlinien und dem geltenden Recht
                            entsprechen. Tinqui.ch beh&auml;lt sich das Recht
                            vor, Anzeigen zu entfernen oder Konten zu
                            schlie&szlig;en, die gegen diese Bedingungen
                            versto&szlig;en.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="3">
                            <li><strong>3. Transaktionsprozess</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch erm&ouml;glicht Transaktionen zwischen
                            K&auml;ufern und Verk&auml;ufern. Wir sind jedoch
                            nicht Partei eines Vertrags zwischen Nutzern. Der
                            Verk&auml;ufer ist daf&uuml;r verantwortlich, die
                            Verkaufsbedingungen, einschlie&szlig;lich Preis,
                            Versand und R&uuml;ckgaberichtlinien, anzugeben.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="4">
                            <li>
                                <strong
                                    >4. Geb&uuml;hren und Provisionen</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Tinqui.ch erhebt Geb&uuml;hren und Provisionen
                            f&uuml;r die Nutzung unserer Dienste, wie im
                            Abschnitt "Geb&uuml;hren und Provisionen" angegeben.
                            Wir behalten uns das Recht vor, unsere Geb&uuml;hren
                            mit vorheriger Ank&uuml;ndigung an die Nutzer zu
                            &auml;ndern.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="5">
                            <li><strong>5. Versand und Lieferung</strong></li>
                        </ol>
                        <p>
                            Die Verk&auml;ufer sind daf&uuml;r verantwortlich,
                            die Artikel innerhalb der in der Anzeige angegebenen
                            Frist zu versenden. Tinqui.ch haftet nicht f&uuml;r
                            Artikel, die w&auml;hrend des Versands verloren
                            gehen, besch&auml;digt werden oder sich
                            versp&auml;ten.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="6">
                            <li>
                                <strong>6. R&uuml;ckgabe und Erstattung</strong>
                            </li>
                        </ol>
                        <p>
                            Die R&uuml;ckgabe- und Erstattungsrichtlinien werden
                            von jedem Verk&auml;ufer festgelegt. Tinqui.ch ist
                            nicht daf&uuml;r verantwortlich, diese Richtlinien
                            durchzusetzen, ermutigt die Verk&auml;ufer jedoch,
                            Streitigkeiten fair und zeitnah beizulegen.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="7">
                            <li>
                                <strong>7. Haftungsbeschr&auml;nkung</strong>
                            </li>
                        </ol>
                        <p>
                            Soweit gesetzlich zul&auml;ssig, haftet Tinqui.ch
                            nicht f&uuml;r indirekte, zuf&auml;llige, besondere,
                            Folge- oder Strafsch&auml;den oder f&uuml;r
                            entgangene Gewinne oder Einnahmen, ob direkt oder
                            indirekt entstanden, oder f&uuml;r Datenverlust,
                            Nutzungsausfall, Goodwill oder andere immaterielle
                            Verluste.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="8">
                            <li><strong>8. Geistiges Eigentum</strong></li>
                        </ol>
                        <p>
                            Der Inhalt von Tinqui.ch, mit Ausnahme von
                            nutzergenerierten Inhalten, ist Eigentum von
                            Tinqui.ch und durch Gesetze zum geistigen Eigentum
                            gesch&uuml;tzt. Die Nutzer behalten das Eigentum an
                            ihren Inhalten, gew&auml;hren uns aber eine
                            weltweite, nicht-exklusive, lizenzgeb&uuml;hrenfreie
                            Lizenz zur Nutzung in Verbindung mit unseren
                            Diensten.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="9">
                            <li><strong>9. K&uuml;ndigung</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch beh&auml;lt sich das Recht vor, Ihr Konto
                            jederzeit und aus beliebigem Grund auszusetzen oder
                            zu k&uuml;ndigen, auch wenn wir vermuten, dass Sie
                            gegen diese Bedingungen versto&szlig;en haben.
                        </p>
                        <p>&nbsp;</p>
                        <ol start="10">
                            <li><strong>10. &Auml;nderungen</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch beh&auml;lt sich das Recht vor, diese
                            Bedingungen jederzeit zu &auml;ndern. Wir werden Sie
                            &uuml;ber &Auml;nderungen informieren, indem wir die
                            neuen Bedingungen auf dieser Seite
                            ver&ouml;ffentlichen.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Durch die Nutzung von Tinqui.ch erkl&auml;ren Sie
                            sich mit der jeweils aktuellen Version dieser
                            Bedingungen einverstanden. Wir empfehlen Ihnen,
                            diese Seite regelm&auml;&szlig;ig zu
                            &uuml;berpr&uuml;fen, um &uuml;ber &Auml;nderungen
                            informiert zu sein.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Wenn Sie Fragen zu diesen Bedingungen haben,
                            kontaktieren Sie uns bitte &uuml;ber die auf unserer
                            Website angegebenen Kan&auml;le.
                        </p></span
                    >

                    <!-- <div class="d-flex center mt-4">
                        <span
                            v-for="(number, index) in pageNumber"
                            :key="index"
                            class="dot"
                            @click="showNext(number)"
                        >
                            {{ number }}&nbsp;&nbsp;&nbsp;
                        </span>
                    </div> -->
                </ps-label>
                <ps-label
                    class="mt-4"
                    v-if="aboutUsStore.aboutus.data != null && language == 'it'"
                >
                    <span>
                        <!-- <h1>Termini e Condizioni</h1> -->
                        <p>
                            Benvenuti su Tinqui.ch. Questi Termini e Condizioni
                            costituiscono un contratto legale tra voi e
                            Tinqui.ch. Accedendo o utilizzando il nostro sito
                            web e i nostri servizi, accettate di essere
                            vincolati da questi Termini. Se non siete d'accordo
                            con qualsiasi parte di questi Termini, non potete
                            accedere al sito web e ai servizi di Tinqui.ch.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >1. Idoneit&agrave; e Registrazione</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Per utilizzare Tinqui.ch, dovete avere almeno 18
                            anni e risiedere in Svizzera. Registrandovi,
                            dichiarate che le informazioni fornite sono
                            veritiere e accurate. Siete responsabili di
                            mantenere la riservatezza del vostro account e della
                            vostra password.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong>2. Pubblicazione di Annunci</strong>
                            </li>
                        </ol>
                        <p>
                            In qualit&agrave; di venditore, siete responsabili
                            di garantire che i vostri annunci e prodotti siano
                            conformi alle nostre politiche e alle leggi
                            applicabili. Tinqui.ch si riserva il diritto di
                            rimuovere qualsiasi annuncio o chiudere qualsiasi
                            account che violi questi Termini.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>3. Processo di Transazione</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch facilita le transazioni tra acquirenti e
                            venditori. Tuttavia, non siamo parte di alcun
                            contratto tra gli utenti. Il venditore &egrave;
                            responsabile di specificare i termini della vendita,
                            inclusi prezzo, spedizione e politiche di reso.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>4. Tariffe e Commissioni</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch addebita tariffe e commissioni per
                            l'utilizzo dei nostri servizi come specificato nella
                            nostra sezione "Tariffe e Commissioni". Ci
                            riserviamo il diritto di modificare le nostre
                            tariffe previa notifica agli utenti.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>5. Spedizione e Consegna</strong></li>
                        </ol>
                        <p>
                            I venditori sono responsabili della spedizione degli
                            articoli entro i tempi specificati nell'annuncio.
                            Tinqui.ch non &egrave; responsabile per articoli
                            persi, danneggiati o ritardati durante la
                            spedizione.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>6. Resi e Rimborsi</strong></li>
                        </ol>
                        <p>
                            Le politiche di reso e rimborso sono determinate da
                            ciascun venditore. Tinqui.ch non &egrave;
                            responsabile dell'applicazione di queste politiche,
                            ma incoraggia i venditori a risolvere eventuali
                            controversie in modo equo e tempestivo.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >7. Limitazione di
                                    Responsabilit&agrave;</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Nella misura massima consentita dalla legge,
                            Tinqui.ch non sar&agrave; responsabile per danni
                            indiretti, incidentali, speciali, consequenziali o
                            punitivi, o per qualsiasi perdita di profitti o
                            entrate, sia sostenuti direttamente o
                            indirettamente, o per qualsiasi perdita di dati,
                            uso, avviamento o altre perdite immateriali.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li>
                                <strong
                                    >8. Propriet&agrave; Intellettuale</strong
                                >
                            </li>
                        </ol>
                        <p>
                            Il contenuto di Tinqui.ch, escluso il contenuto
                            generato dagli utenti, &egrave; di propriet&agrave;
                            di Tinqui.ch ed &egrave; protetto dalle leggi sulla
                            propriet&agrave; intellettuale. Gli utenti
                            mantengono la propriet&agrave; dei loro contenuti,
                            ma ci concedono una licenza mondiale, non esclusiva
                            e royalty-free per utilizzarli in relazione ai
                            nostri servizi.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>9. Risoluzione</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch si riserva il diritto di sospendere o
                            chiudere il vostro account in qualsiasi momento e
                            per qualsiasi motivo, anche se sospettiamo che
                            abbiate violato questi Termini.
                        </p>
                        <p>&nbsp;</p>
                        <ol>
                            <li><strong>10. Modifiche</strong></li>
                        </ol>
                        <p>
                            Tinqui.ch si riserva il diritto di modificare questi
                            Termini in qualsiasi momento. Vi informeremo di
                            eventuali modifiche pubblicando i nuovi Termini su
                            questa pagina.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Utilizzando Tinqui.ch, accettate di essere vincolati
                            dalla versione corrente di questi Termini. Vi
                            consigliamo di rivedere periodicamente questa pagina
                            per essere informati di eventuali modifiche.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Se avete domande su questi Termini, vi preghiamo di
                            contattarci attraverso i canali forniti sul nostro
                            sito web.
                        </p></span
                    >

                    <!-- <div class="d-flex center mt-4">
                        <span
                            v-for="(number, index) in pageNumber"
                            :key="index"
                            class="dot"
                            @click="showNext(number)"
                        >
                            {{ number }}&nbsp;&nbsp;&nbsp;
                        </span>
                    </div> -->
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
    name: "TermsandConditionsView",
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
</style>
