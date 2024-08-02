<template>
    <Head :title="$t('contact_us__contact_us')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("information_and_contact") }}
                </ps-label>
                <!-- <div
                class="bg-feAchromatic-50 dark:bg-feAchromatic-900 rounded-lg w-auto sm:w-[556px] sm:mt-32 lg:mt-36 mt-28 mb-16 mx-auto py-4"
            >
                <div class="flex justify-center items-center">
                    <ps-label-header-4 class="mb-4 font-medium">
                        {{ $t("information_and_contact") }}
                    </ps-label-header-4>
                </div> -->
                <!-- <div class="w-full flex flex-col">

                    <div class="px-10">
                        <ps-label class="mt-4"> {{ $t("contact_us__contact_name") }} <span style="font-size: 17px; color: red;">*</span> </ps-label>
                        <ps-input class="mt-2"  type="text" v-bind:placeholder="$t('contact_us__contact_name')" v-model:value="name"></ps-input>
                        <ps-label class="mt-4" textColor="text-fePrimary-500" v-if="validation.nameStatus"> {{ $t("contact_us__name_required_error") }} </ps-label>
                    </div>

                    <div class="px-10">
                        <ps-label class="mt-4"> {{ $t("contact_us__contact_phone") }}  <span style="font-size: 17px; color: red;">*</span> </ps-label>
                        <ps-input class="mt-2"  type="text" v-bind:placeholder="$t('contact_us__contact_phone')" v-model:value="phone" @keypress="phoneNumber($event)"></ps-input>
                        <ps-label class="mt-4" textColor="text-fePrimary-500" v-if="validation.phoneStatus"> {{ $t("contact_us__phone_required_error") }} </ps-label>
                    </div>

                    <div class="px-10">
                        <ps-label class="mt-4"> {{ $t("contact_us__contact_email") }} <span style="font-size: 17px; color: red;">*</span> </ps-label>
                        <ps-input class="mt-2"  type="email" v-bind:placeholder="$t('contact_us__contact_email')" v-model:value="email" @keypress="validateEmail"></ps-input>
                        <ps-label class="mt-4" textColor="text-fePrimary-500" v-if="validation.emailStatus"> {{ $t("contact_us__email_required_error") }} </ps-label>
                    </div>

                    <div class="px-10">
                        <ps-label class="mt-4"> {{ $t("contact_us__contact_message") }} <span style="font-size: 17px; color: red;">*</span> </ps-label>
                        <ps-textarea class="mt-2"  v-bind:placeholder="$t('contact_us__contact_message')" v-model:value="message"></ps-textarea>
                        <ps-label class="mt-4" textColor="text-fePrimary-500" v-if="validation.messageStatus"> {{ $t("contact_us__message_required_error") }} </ps-label>
                    </div>

                    <div class="flex flex-col items-center mx-8 mb-4">
                        <ps-button class="mt-6 sm:w-auto" @click="submitclicked" :disabled="false"> {{ $t("contact_us__submit") }} </ps-button>
                    </div>

                </div> -->

                <ps-label
                    class="mt-4"
                    v-if="language == 'en' || language == 'es'"
                >
                    <span> </span>
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'fr'">
                    <span>
                        <p>
                            Bienvenue sur Tinqui.ch, la plateforme leader de
                            vente en ligne en Suisse. Notre mission est d'offrir
                            une exp&eacute;rience s&ucirc;re, transparente et
                            efficace &agrave; tous nos utilisateurs.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>&Agrave; propos de nous</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Tinqui.ch est n&eacute; en 2024 avec l'objectif de
                            r&eacute;volutionner le commerce &eacute;lectronique
                            en Suisse. Notre fondateur, un entrepreneur avec une
                            vaste exp&eacute;rience dans la technologie et le
                            e-commerce, a identifi&eacute; le besoin d'une
                            plateforme innovante qui priorise la
                            s&eacute;curit&eacute;, la transparence et la
                            facilit&eacute; d'utilisation. C'est ainsi que
                            Tinqui.ch est n&eacute;, avec la mission de
                            promouvoir un commerce &eacute;quitable et durable.
                        </p>
                        <p>&nbsp;</p>
                        <p>Nos valeurs fondamentales sont :</p>
                        <p>&nbsp;</p>
                        <ol class="pad-ol-class">
                            <li>
                                Innovation : Nous restons &agrave; la pointe de
                                la technologie et des tendances du e-commerce.
                            </li>
                            <li>
                                Int&eacute;grit&eacute; : Nous croyons en
                                l'honn&ecirc;tet&eacute; et
                                l'&eacute;quit&eacute; dans toutes nos
                                transactions.
                            </li>
                            <li>
                                Collaboration : Nous encourageons la
                                coop&eacute;ration et le soutien mutuel entre
                                nos utilisateurs.
                            </li>
                            <li>
                                Excellence : Nous nous effor&ccedil;ons de
                                fournir un service exceptionnel et une
                                exp&eacute;rience utilisateur
                                in&eacute;gal&eacute;e.
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p><strong>Notre &eacute;quipe</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Notre &eacute;quipe est compos&eacute;e d'experts en
                            technologie, e-commerce, marketing et service
                            client. Chaque membre partage une passion pour
                            l'excellence et un engagement envers nos
                            utilisateurs.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Nos d&eacute;veloppeurs travaillent &agrave;
                            cr&eacute;er une plateforme robuste,
                            s&eacute;curis&eacute;e et facile &agrave; utiliser.
                            Nos sp&eacute;cialistes du marketing analysent les
                            tendances et d&eacute;veloppent des
                            strat&eacute;gies pour aider nos vendeurs. Et notre
                            &eacute;quipe de service client est toujours
                            pr&ecirc;te &agrave; fournir une assistance et des
                            solutions personnalis&eacute;es.
                        </p>
                        <p>&nbsp;</p>

                        <p><strong>Contactez-nous</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Vous avez des questions, des commentaires ou des
                            suggestions ? Nous adorons entendre notre
                            communaut&eacute; ! Notre &eacute;quipe de service
                            client est l&agrave; pour vous aider &agrave; chaque
                            &eacute;tape du processus.
                        </p>
                        <p>&nbsp;</p>
                        <p>Vous pouvez nous contacter via :</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                📧 E-mail : Envoyez-nous un message
                                &agrave;&nbsp;<a href="mailto:info@tinqui.ch"
                                    >info@tinqui.ch</a
                                >&nbsp;et nous vous r&eacute;pondrons dans les 24
                                heures.
                            </li>
                            <li>
                                🌐 R&eacute;seaux sociaux : Suivez-nous sur
                                Facebook, Twitter, Instagram et TikTok pour
                                rester &agrave; jour avec les derni&egrave;res
                                nouvelles, promotions et
                                &eacute;v&eacute;nements.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p><strong>Centre d'aide</strong></p>
                        <p>
                            Notre Centre d'aide est con&ccedil;u pour vous
                            fournir toutes les informations, ressources et
                            assistance dont vous avez besoin pour r&eacute;ussir
                            sur Tinqui.ch. Vous y trouverez des r&eacute;ponses
                            aux questions fr&eacute;quemment pos&eacute;es, des
                            guides &eacute;tape par &eacute;tape et des articles
                            d&eacute;taill&eacute;s sur chaque aspect de notre
                            plateforme.
                        </p>
                    </span>
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'de'">
                    <span>
                        <p>
                            Willkommen bei Tinqui.ch, der f&uuml;hrenden
                            Online-Handelsplattform in der Schweiz. Unsere
                            Mission ist es, allen unseren Nutzern ein sicheres,
                            transparentes und effizientes Erlebnis zu bieten.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>&Uuml;ber uns</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Tinqui.ch wurde 2024 mit dem Ziel gegr&uuml;ndet,
                            den elektronischen Handel in der Schweiz zu
                            revolutionieren. Unser Gr&uuml;nder, ein Unternehmer
                            mit umfangreicher Erfahrung in Technologie und
                            E-Commerce, erkannte die Notwendigkeit einer
                            innovativen Plattform, die Sicherheit, Transparenz
                            und Benutzerfreundlichkeit in den Vordergrund
                            stellt. So entstand Tinqui.ch mit der Mission, einen
                            fairen und nachhaltigen Handel zu f&ouml;rdern.
                        </p>
                        <p>&nbsp;</p>
                        <p>Unsere Grundwerte sind:</p>
                        <p>&nbsp;</p>
                        <ol class="pad-ol-class">
                            <li>
                                Innovation: Wir bleiben an der Spitze der
                                Technologie und E-Commerce-Trends.
                            </li>
                            <li>
                                Integrit&auml;t: Wir glauben an Ehrlichkeit und
                                Fairness in all unseren Transaktionen.
                            </li>
                            <li>
                                Zusammenarbeit: Wir f&ouml;rdern Kooperation und
                                gegenseitige Unterst&uuml;tzung unter unseren
                                Nutzern.
                            </li>
                            <li>
                                Exzellenz: Wir streben danach, einen
                                au&szlig;ergew&ouml;hnlichen Service und ein
                                unvergleichliches Benutzererlebnis zu bieten.
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p><strong>Unser Team</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Unser Team besteht aus Experten in Technologie,
                            E-Commerce, Marketing und Kundenbetreuung. Jedes
                            Mitglied teilt eine Leidenschaft f&uuml;r Exzellenz
                            und ein Engagement f&uuml;r unsere Nutzer.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            Unsere Entwickler arbeiten daran, eine robuste,
                            sichere und benutzerfreundliche Plattform zu
                            schaffen. Unsere Marketingspezialisten analysieren
                            Trends und entwickeln Strategien, um unseren
                            Verk&auml;ufern zu helfen. Und unser
                            Kundenbetreuungsteam ist immer bereit,
                            ma&szlig;geschneiderte Unterst&uuml;tzung und
                            L&ouml;sungen anzubieten.
                        </p>
                        <p><strong>&nbsp;</strong></p>
                        <p><strong>Kontaktiere uns</strong></p>
                        <p>
                            Hast du Fragen, Anmerkungen oder Vorschl&auml;ge?
                            Wir lieben es, von unserer Community zu h&ouml;ren!
                            Unser Kundenbetreuungsteam ist hier, um dir bei
                            jedem Schritt zu helfen.
                        </p>
                        <p>&nbsp;</p>
                        <p>Du kannst uns kontaktieren &uuml;ber:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                📧 E-Mail: Sende uns eine Nachricht an&nbsp;<a
                                    href="mailto:info@tinqui.ch"
                                    >info@tinqui.ch</a
                                >&nbsp;und wir werden dir innerhalb von 24
                                Stunden antworten.
                            </li>
                            <li>
                                🌐 Soziale Medien: Folge uns auf Facebook,
                                Twitter, Instagram und TikTok, um &uuml;ber die
                                neuesten Nachrichten, Aktionen und
                                Veranstaltungen auf dem Laufenden zu bleiben.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p><strong>Hilfezentrum</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Unser Hilfezentrum ist darauf ausgelegt, dir alle
                            Informationen, Ressourcen und Unterst&uuml;tzung zu
                            bieten, die du brauchst, um auf Tinqui.ch
                            erfolgreich zu sein. Hier findest du Antworten auf
                            h&auml;ufig gestellte Fragen,
                            Schritt-f&uuml;r-Schritt-Anleitungen und
                            detaillierte Artikel zu jedem Aspekt unserer
                            Plattform.
                        </p>
                        <p>
                            Bei Tinqui.ch glauben wir an die Kraft menschlicher
                            Verbindungen. Wir sind f&uuml;r dich da, bei jedem
                            Schritt des Weges.
                        </p>
                        <p>&nbsp;</p>
                    </span>
                </ps-label>
                <ps-label class="mt-4" v-if="language == 'it'">
                    <span>
                        <p>
                            Benvenuti su Tinqui.ch, la piattaforma leader di
                            compravendita online in Svizzera. La nostra missione
                            &egrave; offrire un'esperienza sicura, trasparente
                            ed efficiente a tutti i nostri utenti.
                        </p>
                        <p>&nbsp;</p>
                        <p><strong>Chi Siamo</strong></p>
                        <p>
                            Tinqui.ch &egrave; nata nel 2024 con l'obiettivo di
                            rivoluzionare l'e-commerce in Svizzera. Il nostro
                            fondatore, un imprenditore con una vasta esperienza
                            in tecnologia e commercio elettronico, ha
                            identificato la necessit&agrave; di una piattaforma
                            innovativa che desse priorit&agrave; a sicurezza,
                            trasparenza e facilit&agrave; d'uso. Cos&igrave;
                            &egrave; nata Tinqui.ch, con la missione di
                            promuovere un commercio equo e sostenibile.
                        </p>
                        <p>&nbsp;</p>
                        <p>I nostri valori fondamentali sono:</p>
                        <p>&nbsp;</p>
                        <ol class="pad-ol-class">
                            <li>
                                Innovazione: Restiamo all'avanguardia della
                                tecnologia e delle tendenze dell'e-commerce.
                            </li>
                            <li>
                                Integrit&agrave;: Crediamo nell'onest&agrave; e
                                nell'equit&agrave; in tutte le nostre
                                transazioni.
                            </li>
                            <li>
                                Collaborazione: Incoraggiamo la cooperazione e
                                il sostegno reciproco tra i nostri utenti.
                            </li>
                            <li>
                                Eccellenza: Ci impegniamo a fornire un servizio
                                eccezionale e un'esperienza utente
                                ineguagliabile.
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                        <p><strong>Il Nostro Team</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Il nostro team &egrave; composto da esperti in
                            tecnologia, e-commerce, marketing e assistenza
                            clienti. Ogni membro condivide una passione per
                            l'eccellenza e un impegno verso i nostri utenti.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                            I nostri sviluppatori lavorano per creare una
                            piattaforma robusta, sicura e facile da usare. I
                            nostri specialisti di marketing analizzano le
                            tendenze e sviluppano strategie per aiutare i nostri
                            venditori. E il nostro team di assistenza clienti
                            &egrave; sempre pronto a fornire supporto e
                            soluzioni personalizzate.
                        </p>
                        <p><strong>&nbsp;</strong></p>
                        <p><strong>Contattaci</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Hai domande, commenti o suggerimenti? Ci piace
                            ascoltare la nostra community! Il nostro team di
                            assistenza clienti &egrave; qui per aiutarti ad ogni
                            passo.
                        </p>
                        <p>&nbsp;</p>
                        <p>Puoi contattarci tramite:</p>
                        <p>&nbsp;</p>
                        <ul class="pad-class">
                            <li>
                                📧 Email: Inviaci un messaggio a&nbsp;<a
                                    href="mailto:info@tinqui.ch"
                                    >info@tinqui.ch</a
                                >&nbsp;e ti risponderemo entro 24 ore.
                            </li>
                            <li>
                                🌐 Social media: Seguici su Facebook, Twitter,
                                Instagram e TikTok per rimanere aggiornato sulle
                                ultime notizie, promozioni ed eventi.
                            </li>
                        </ul>
                        <p>&nbsp;</p>
                        <p><strong>Centro Assistenza</strong></p>
                        <p>&nbsp;</p>
                        <p>
                            Il nostro Centro Assistenza &egrave; progettato per
                            fornirti tutte le informazioni, le risorse e il
                            supporto di cui hai bisogno per avere successo su
                            Tinqui.ch. Qui troverai risposte alle domande
                            frequenti, guide passo passo e articoli dettagliati
                            su ogni aspetto della nostra piattaforma.
                        </p>
                        <p>&nbsp;</p>
                    </span>
                </ps-label>
            </div>
        </template>
    </ps-content-container>

    <ps-success-dialog ref="ps_success_dialog" />
</template>

<script lang="ts">
//Vue
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";

import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelHeader4 from "@template1/vendor/components/core/label/PsLabelHeader4.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PsInput from "@template1/vendor/components/core/input/PsInput.vue";
import PsButton from "@template1/vendor/components/core/buttons/PsButton.vue";
import PsTextarea from "@template1/vendor/components/core/textarea/PsTextarea.vue";
import PsSuccessDialog from "@template1/vendor/components/core/dialog/PsSuccessDialog.vue";

import { useContactUsStoreState } from "@templateCore/store/modules/contact/ContactUsStore";

// Params Holders
import ContactUsPrameterHolder from "@templateCore/object/holder/ContactUsParameterHolder";
import { trans } from "laravel-vue-i18n";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

export default {
    name: "ContactInfoView",
    components: {
        PsContentContainer,
        PsLabelHeader4,
        PsLabel,
        PsInput,
        PsButton,
        PsTextarea,
        PsSuccessDialog,
        Head,
    },
    layout: PsFrontendLayout,
    setup() {
        // Inject Item Provider
        const contactUsStore = useContactUsStoreState();

        const paramHolder = new ContactUsPrameterHolder();
        const ps_success_dialog = ref();
        const name = ref("");
        const phone = ref("");
        const email = ref("");
        const message = ref("");

        const validation = ref({
            nameStatus: false,
            phoneStatus: false,
            emailStatus: false,
            messageStatus: false,
        });

        const language = localStorage.activeLanguage;

        const psValueStore = PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();

        function validateEmail(e) {
            const pattern = /^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,5})$/;
            const res = pattern.test(e.target.value);
            if (!res) {
                validation.value.emailStatus = true;
            } else {
                validation.value.emailStatus = false;
            }
        }

        function phoneNumber(evt) {
            evt = evt ? evt : window.event;
            const charCode = evt.which ? evt.which : evt.keyCode;

            if (charCode < 42 || charCode > 57) {
                evt.preventDefault();
            } else {
                return true;
            }
        }

        async function submitclicked() {
            paramHolder.name = name.value;
            paramHolder.phone = phone.value;
            paramHolder.email = email.value;
            paramHolder.message = message.value;
            if (paramHolder.name == "" || paramHolder.name == undefined) {
                validation.value.nameStatus = true;
                return;
            }

            if (paramHolder.phone == "" || paramHolder.phone == undefined) {
                validation.value.phoneStatus = true;
                return;
            }

            if (paramHolder.email == "" || paramHolder.email == undefined) {
                validation.value.emailStatus = true;
                return;
            }

            if (paramHolder.message == "" || paramHolder.message == undefined) {
                validation.value.messageStatus = true;
                return;
            }
            // contact us
            await contactUsStore.postContactUs(paramHolder, loginUserId);
            ps_success_dialog.value.openModal(
                "Success!",
                trans("contact_us__add_successed")
            );

            name.value = "";
            phone.value = "";
            email.value = "";
            message.value = "";

            validation.value.nameStatus = false;
            validation.value.phoneStatus = false;
            validation.value.emailStatus = false;
            validation.value.messageStatus = false;
        }

        return {
            contactUsStore,
            submitclicked,
            name,
            phone,
            email,
            message,
            validation,
            validateEmail,
            phoneNumber,
            ps_success_dialog,
            language,
        };
    },
};
</script>
<style>
ol.pad-ol-class {
    padding-left: 20px !important;
    list-style-type: decimal !important;
    padding-left: 20px !important;
}
ul.pad-class {
    padding-left: 20px !important;
    list-style-type: disc !important;
    padding-left: 20px !important;
}
</style>
