<template>
    <Head :title="$t('faq_page__faq_page')" />
    <ps-content-container>
        <template #content>
            <div class="sm:mt-32 lg:mt-36 mt-28 mb-16">
                <ps-label
                    class="text-center font-semibold text-2xl sm:text-3xl"
                >
                    {{ $t("frequent_questions") }}
                </ps-label>
                <ps-label class="mt-4" v-if="aboutUsStore.aboutus.data != null">
                    <!-- <span v-html="aboutUsStore.aboutus.data.faqPage" v-once></span> -->
                    <ps-label
                        class="mt-4"
                        v-if="
                            aboutUsStore.aboutus.data != null &&
                            (language == 'en' || language == 'es')
                        "
                    >
                        <span>
                            <ol start="2">
                                <li>
                                    <strong>Frequently Asked Questions</strong>
                                </li>
                            </ol>
                            <p>
                                Our Frequently Asked Questions (FAQ) section is
                                designed to provide quick and complete answers
                                to our users' most common questions. We've
                                carefully organized the questions into clear,
                                easy-to-navigate categories, so you can
                                efficiently find the information you need.
                            </p>
                            <p>&nbsp;</p>
                            <p><strong>Account and Registration</strong></p>
                            <ul>
                                <li>
                                    <strong
                                        >How do I create an account on
                                        Tinqui.ch?</strong
                                    >&nbsp;&nbsp;To create an account, simply
                                    click the "Register" button in the top right
                                    corner of our home page. Fill out the form
                                    with your personal information, including
                                    name, email address and a secure password.
                                    Once you submit the form, you will receive a
                                    confirmation email to activate your account.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul>
                                <li>
                                    <strong
                                        >Can I use Tinqui.ch without
                                        registering?</strong
                                    >&nbsp;&nbsp;While you can browse and search
                                    for ads without an account, you will need to
                                    register to post ads, contact other users,
                                    and transact on our platform. Registration
                                    is fast, easy and free and gives you access
                                    to all the features of Tinqui.ch.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Purchase on Tinqui.ch</strong></p>
                            <ul>
                                <li>
                                    <strong
                                        >What payment options are
                                        accepted?</strong
                                    >&nbsp;&nbsp;We accept a variety of secure
                                    payment methods, including credit and debit
                                    cards (Visa, Mastercard, American Express),
                                    Twint and bank transfers. You can select
                                    your preferred payment method when
                                    finalizing a purchase.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul>
                                <li>
                                    <strong
                                        >What should I do if I have a problem
                                        with a purchase?</strong
                                    >&nbsp;&nbsp;If you have a problem with a
                                    purchase, we recommend first trying to
                                    communicate directly with the seller via our
                                    internal messaging system. If you can't
                                    resolve your issue, our customer support
                                    team is ready to help. Simply contact us via
                                    the support form or send us an email
                                    to&nbsp;&nbsp;<a
                                        href="mailto:info@tinqui.ch"
                                        >info@tinqui.ch</a
                                    >&nbsp;&nbsp;with the details of your
                                    situation.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Selling on Tinqui.ch</strong></p>
                            <ul>
                                <li>
                                    <strong
                                        >How do I post an ad to sell an
                                        item?</strong
                                    >&nbsp;&nbsp;To post an ad, log in to your
                                    account and click on the "Publish Ad"
                                    button. Select the appropriate category for
                                    your item, add a descriptive title, upload
                                    high-quality photos, and provide a detailed
                                    description. Set a price and choose the
                                    shipping options you want to offer. Review
                                    your ad and click "Publish" when you're
                                    ready.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul>
                                <li>
                                    <strong
                                        >How much does it cost to publish an ad
                                        on Tinqui.ch?</strong
                                    >&nbsp;&nbsp;Posting an ad on Tinqui.ch is
                                    completely free for 7 days. We do not charge
                                    fees for posting or selling items on our
                                    platform. However, as a seller, you are
                                    responsible for shipping costs and any fees
                                    associated with the payment method you
                                    select.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                To encourage sales activity and offer accessible
                                options, the seller can choose from the
                                following duration and price options for their
                                ads:
                            </p>
                            <ul>
                                <li>
                                    Free publishing: Publish your ads for 7 days
                                    at no cost, ideal for getting started.
                                </li>
                                <li>
                                    Payment options: If you want a longer
                                    exposure time, choose between 14 days for
                                    3.90 CHF or 30 days for 6.90 CHF.
                                </li>
                            </ul>
                            <p><strong>Safety and Protection</strong></p>
                            <ul>
                                <li>
                                    <strong
                                        >How does Tinqui.ch protect my personal
                                        information?</strong
                                    >&nbsp;&nbsp;At Tinqui.ch, we take the
                                    privacy and security of our users very
                                    seriously. We use advanced encryption
                                    technologies to protect your personal and
                                    financial information and never share your
                                    data with third parties without your
                                    explicit consent. You can read more about
                                    our privacy practices in our Privacy Policy.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul>
                                <li>
                                    <strong
                                        >What should I do if I suspect
                                        fraudulent activity?</strong
                                    >&nbsp;&nbsp;If you suspect fraudulent
                                    activity, such as a misleading ad or a scam
                                    attempt, we ask that you report it to our
                                    security team immediately. You can do this
                                    by clicking on the "Report" link in the
                                    suspicious ad or profile, or by contacting
                                    us directly via our support form. We
                                    investigate all reports of suspicious
                                    activity and quickly take steps to protect
                                    our community.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                Remember, if you don't find the answer you're
                                looking for in our Frequently Asked Questions
                                section, our dedicated customer support team is
                                always available to provide you with
                                personalized assistance. Please feel free to
                                contact us with any questions or concerns you
                                may have.
                            </p>
                        </span>
                    </ps-label>
                    <ps-label
                        class="mt-4"
                        v-if="
                            aboutUsStore.aboutus.data != null &&
                            language == 'it'
                        "
                    >
                        <span
                            ><p>
                                La nostra sezione Domande Frequenti (FAQ)
                                &egrave; progettata per fornire risposte rapide
                                e complete alle domande pi&ugrave; comuni dei
                                nostri utenti. Abbiamo organizzato attentamente
                                le domande in categorie chiare e facili da
                                navigare, in modo da poter trovare in modo
                                efficiente le informazioni di cui hai bisogno.
                            </p>
                            <p>&nbsp;</p>
                            <p><strong>Account e Registrazione</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Come creo un account su
                                        Tinqui.ch?</strong
                                    >Per creare un account, basta cliccare sul
                                    pulsante "Registrati" nell'angolo in alto a
                                    destra della nostra pagina principale.
                                    Compila il modulo con le tue informazioni
                                    personali, inclusi nome, indirizzo email e
                                    una password sicura. Una volta inviato il
                                    modulo, riceverai un'email di conferma per
                                    attivare il tuo account.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Posso usare Tinqui.ch senza
                                        registrarmi?</strong
                                    >Anche se puoi navigare e cercare annunci
                                    senza un account, dovrai registrarti per
                                    pubblicare annunci, contattare altri utenti
                                    ed effettuare transazioni sulla nostra
                                    piattaforma. La registrazione &egrave;
                                    veloce, facile e gratuita e ti d&agrave;
                                    accesso a tutte le funzionalit&agrave; di
                                    Tinqui.ch.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Acquistare su Tinqui.ch</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Quali sono le opzioni di pagamento
                                        accettate?</strong
                                    >Accettiamo una variet&agrave; di metodi di
                                    pagamento sicuri, tra cui carte di credito e
                                    di debito (Visa, Mastercard, American
                                    Express), Twint e bonifici bancari. Puoi
                                    selezionare il tuo metodo di pagamento
                                    preferito al momento della finalizzazione di
                                    un acquisto.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Cosa devo fare se ho un problema con un
                                        acquisto?</strong
                                    >Se hai un problema con un acquisto, ti
                                    consigliamo di provare prima a comunicare
                                    direttamente con il venditore tramite il
                                    nostro sistema di messaggistica interno. Se
                                    non riesci a risolvere il problema, il
                                    nostro team di assistenza clienti &egrave;
                                    pronto ad aiutarti. Basta contattarci
                                    tramite il modulo di supporto o inviarci
                                    un'email a&nbsp;<a
                                        href="mailto:info@tinqui.ch"
                                        >info@tinqui.ch</a
                                    >&nbsp;con i dettagli della tua situazione.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Vendere su Tinqui.ch</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Come pubblicare un annuncio per vendere
                                        un articolo?</strong
                                    >Per pubblicare un annuncio, accedi al tuo
                                    account e clicca sul pulsante "Pubblica
                                    annuncio". Seleziona la categoria
                                    appropriata per il tuo articolo, aggiungi un
                                    titolo descrittivo, carica foto di alta
                                    qualit&agrave; e fornisci una descrizione
                                    dettagliata. Imposta un prezzo e scegli le
                                    opzioni di spedizione che desideri offrire.
                                    Rivedi il tuo annuncio e clicca su
                                    "Pubblica" quando sei pronto.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Quanto costa pubblicare un annuncio su
                                        Tinqui.ch?</strong
                                    >Pubblicare un annuncio su Tinqui.ch
                                    &egrave; completamente gratuito per 7
                                    giorni. Non addebitiamo commissioni per
                                    pubblicare o vendere articoli sulla nostra
                                    piattaforma. Tuttavia, come venditore, sei
                                    responsabile dei costi di spedizione e di
                                    eventuali commissioni associate al metodo di
                                    pagamento selezionato.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                Per incoraggiare l'attivit&agrave; di vendita e
                                offrire opzioni accessibili, il venditore
                                pu&ograve; scegliere tra le seguenti opzioni di
                                durata e prezzo per i suoi annunci:
                            </p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    Pubblicazione gratuita: Pubblica i tuoi
                                    annunci per 7 giorni senza alcun costo,
                                    ideale per iniziare.
                                </li>
                                <li>
                                    Opzioni di pagamento: Se desideri un tempo
                                    di esposizione maggiore, scegli tra 14
                                    giorni per 3,90 CHF o 30 giorni per 6,90
                                    CHF.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Sicurezza e Protezione</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Come protegge Tinqui.ch le mie
                                        informazioni personali?</strong
                                    >In Tinqui.ch, prendiamo molto sul serio la
                                    privacy e la sicurezza dei nostri utenti.
                                    Utilizziamo tecnologie di crittografia
                                    avanzate per proteggere le tue informazioni
                                    personali e finanziarie e non condividiamo
                                    mai i tuoi dati con terze parti senza il tuo
                                    consenso esplicito. Puoi leggere di
                                    pi&ugrave; sulle nostre pratiche sulla
                                    privacy nella nostra Informativa sulla
                                    privacy.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Cosa devo fare se sospetto
                                        un'attivit&agrave; fraudolenta?</strong
                                    >Se sospetti un'attivit&agrave; fraudolenta,
                                    come un annuncio ingannevole o un tentativo
                                    di truffa, ti chiediamo di segnalare
                                    immediatamente al nostro team di sicurezza.
                                    Puoi farlo cliccando sul link "Segnala"
                                    nell'annuncio o nel profilo sospetto, oppure
                                    contattandoci direttamente tramite il nostro
                                    modulo di supporto. Indaghiamo su tutte le
                                    segnalazioni di attivit&agrave; sospette e
                                    adottiamo rapidamente misure per proteggere
                                    la nostra comunit&agrave;.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                Ricorda, se non trovi la risposta che stai
                                cercando nella nostra sezione Domande frequenti,
                                il nostro team dedicato di assistenza clienti
                                &egrave; sempre disponibile per fornirti
                                assistenza personalizzata. Non esitare a
                                contattarci per qualsiasi domanda o dubbio tu
                                possa avere.
                            </p></span
                        >
                    </ps-label>
                    <ps-label
                        class="mt-4"
                        v-if="
                            aboutUsStore.aboutus.data != null &&
                            language == 'fr'
                        "
                    >
                        <span
                            ><p>
                                Notre section de Foire aux questions (FAQ) est
                                con&ccedil;ue pour vous fournir des
                                r&eacute;ponses rapides et compl&egrave;tes aux
                                questions les plus courantes de nos
                                utilisateurs. Nous avons soigneusement
                                organis&eacute; les questions en
                                cat&eacute;gories claires et faciles &agrave;
                                naviguer, afin que vous puissiez trouver
                                efficacement les informations dont vous avez
                                besoin.
                            </p>
                            <p>&nbsp;</p>
                            <p><strong>Compte et inscription</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Comment cr&eacute;er un compte sur
                                        Tinqui.ch ?</strong
                                    >Pour cr&eacute;er un compte, cliquez
                                    simplement sur le bouton "S'inscrire" dans
                                    le coin sup&eacute;rieur droit de notre page
                                    d'accueil. Remplissez le formulaire avec vos
                                    informations personnelles, y compris votre
                                    nom, adresse e-mail et un mot de passe
                                    s&eacute;curis&eacute;. Une fois le
                                    formulaire soumis, vous recevrez un e-mail
                                    de confirmation pour activer votre compte.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Puis-je utiliser Tinqui.ch sans
                                        m'inscrire ?</strong
                                    >Bien que vous puissiez naviguer et
                                    rechercher des annonces sans compte, vous
                                    devrez vous inscrire pour publier des
                                    annonces, contacter d'autres utilisateurs et
                                    effectuer des transactions sur notre
                                    plateforme. L'inscription est rapide, facile
                                    et gratuite, et vous donne acc&egrave;s
                                    &agrave; toutes les fonctionnalit&eacute;s
                                    de Tinqui.ch.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Acheter sur Tinqui.ch</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Quels sont les modes de paiement
                                        accept&eacute;s ?</strong
                                    >Nous acceptons une vari&eacute;t&eacute; de
                                    m&eacute;thodes de paiement
                                    s&eacute;curis&eacute;es, notamment les
                                    cartes de cr&eacute;dit et de d&eacute;bit
                                    (Visa, Mastercard, American Express), Twint
                                    et les virements bancaires. Vous pouvez
                                    s&eacute;lectionner votre mode de paiement
                                    pr&eacute;f&eacute;r&eacute; lors de la
                                    finalisation d'un achat.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Que dois-je faire si j'ai un
                                        probl&egrave;me avec un achat ?</strong
                                    >Si vous rencontrez un probl&egrave;me avec
                                    un achat, nous vous recommandons d'abord
                                    d'essayer de communiquer directement avec le
                                    vendeur via notre syst&egrave;me de
                                    messagerie interne. Si vous ne parvenez pas
                                    &agrave; r&eacute;soudre le probl&egrave;me,
                                    notre &eacute;quipe de service client est
                                    pr&ecirc;te &agrave; vous aider.
                                    Contactez-nous simplement via le formulaire
                                    d'assistance ou envoyez-nous un e-mail
                                    &agrave;&nbsp;<a
                                        href="mailto:info@tinqui.ch"
                                        >info@tinqui.ch</a
                                    >&nbsp;avec les d&eacute;tails de votre
                                    situation.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Vendre sur Tinqui.ch</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Comment publier une annonce pour vendre
                                        un article ?</strong
                                    >Pour publier une annonce, connectez-vous
                                    &agrave; votre compte et cliquez sur le
                                    bouton "Publier une annonce".
                                    S&eacute;lectionnez la cat&eacute;gorie
                                    appropri&eacute;e pour votre article,
                                    ajoutez un titre descriptif,
                                    t&eacute;l&eacute;chargez des photos de
                                    haute qualit&eacute; et fournissez une
                                    description d&eacute;taill&eacute;e. Fixez
                                    un prix et choisissez les options
                                    d'exp&eacute;dition que vous souhaitez
                                    proposer. V&eacute;rifiez votre annonce et
                                    cliquez sur "Publier" lorsque vous
                                    &ecirc;tes pr&ecirc;t.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Combien co&ucirc;te la publication
                                        d'une annonce sur Tinqui.ch ?</strong
                                    >La publication d'une annonce sur Tinqui.ch
                                    est enti&egrave;rement gratuite pendant 7
                                    jours. Nous ne facturons pas de frais pour
                                    publier ou vendre des articles sur notre
                                    plateforme. Cependant, en tant que vendeur,
                                    vous &ecirc;tes responsable des frais
                                    d'exp&eacute;dition et de tous les frais
                                    associ&eacute;s &agrave; votre mode de
                                    paiement s&eacute;lectionn&eacute;.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                Pour encourager l'activit&eacute; de vente et
                                offrir des options abordables, le vendeur peut
                                choisir parmi les options de dur&eacute;e et de
                                prix suivantes pour ses annonces :
                            </p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    Publication gratuite : Publiez vos annonces
                                    pendant 7 jours sans aucun frais,
                                    id&eacute;al pour commencer.
                                </li>
                                <li>
                                    Options de paiement : Si vous souhaitez une
                                    dur&eacute;e d'exposition plus longue,
                                    choisissez entre 14 jours pour 3,90 CHF ou
                                    30 jours pour 6,90 CHF.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                <strong
                                    >S&eacute;curit&eacute; et
                                    protection</strong
                                >
                            </p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Comment Tinqui.ch prot&egrave;ge-t-il
                                        mes informations personnelles ?</strong
                                    >Chez Tinqui.ch, nous prenons tr&egrave;s au
                                    s&eacute;rieux la confidentialit&eacute; et
                                    la s&eacute;curit&eacute; de nos
                                    utilisateurs. Nous utilisons une technologie
                                    de cryptage avanc&eacute;e pour
                                    prot&eacute;ger vos informations
                                    personnelles et financi&egrave;res, et nous
                                    ne partageons jamais vos donn&eacute;es avec
                                    des tiers sans votre consentement explicite.
                                    Vous pouvez en savoir plus sur nos pratiques
                                    de confidentialit&eacute; dans notre
                                    politique de confidentialit&eacute;.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Que dois-je faire si je
                                        soup&ccedil;onne une activit&eacute;
                                        frauduleuse ?</strong
                                    >Si vous soup&ccedil;onnez une
                                    activit&eacute; frauduleuse, comme une
                                    annonce trompeuse ou une tentative
                                    d'arnaque, nous vous demandons de la
                                    signaler imm&eacute;diatement &agrave; notre
                                    &eacute;quipe de s&eacute;curit&eacute;.
                                    Vous pouvez le faire en cliquant sur le lien
                                    "Signaler" dans l'annonce ou le profil
                                    suspect, ou en nous contactant directement
                                    via notre formulaire d'assistance. Nous
                                    enqu&ecirc;tons sur tous les signalements
                                    d'activit&eacute; suspecte et prenons des
                                    mesures rapides pour prot&eacute;ger notre
                                    communaut&eacute;.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                N'oubliez pas, si vous ne trouvez pas la
                                r&eacute;ponse que vous cherchez dans notre
                                section FAQ, notre &eacute;quipe
                                d&eacute;vou&eacute;e de service client est
                                toujours disponible pour vous fournir une
                                assistance personnalis&eacute;e.
                                N'h&eacute;sitez pas &agrave; nous contacter
                                pour toute question ou pr&eacute;occupation que
                                vous pourriez avoir.
                            </p>
                        </span>
                    </ps-label>
                    <ps-label
                        class="mt-4"
                        v-if="
                            aboutUsStore.aboutus.data != null &&
                            language == 'de'
                        "
                    >
                        <span
                            ><p>
                                Unser Bereich mit h&auml;ufig gestellten Fragen
                                (FAQ) soll Ihnen schnelle und umfassende
                                Antworten auf die g&auml;ngigsten Fragen unserer
                                Nutzer geben. Wir haben die Fragen
                                sorgf&auml;ltig in klare und leicht zu
                                navigierende Kategorien eingeteilt, damit Sie
                                die ben&ouml;tigten Informationen effizient
                                finden k&ouml;nnen.
                            </p>
                            <p>&nbsp;</p>
                            <p><strong>Konto und Registrierung</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Wie erstelle ich ein Konto bei
                                        Tinqui.ch?</strong
                                    >Um ein Konto zu erstellen, klicken Sie
                                    einfach auf die Schaltfl&auml;che
                                    "Registrieren" in der oberen rechten Ecke
                                    unserer Startseite. F&uuml;llen Sie das
                                    Formular mit Ihren pers&ouml;nlichen Daten
                                    aus, einschlie&szlig;lich Ihres Namens,
                                    Ihrer E-Mail-Adresse und eines sicheren
                                    Passworts. Sobald Sie das Formular
                                    abgeschickt haben, erhalten Sie eine
                                    Best&auml;tigungs-E-Mail zur Aktivierung
                                    Ihres Kontos.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Kann ich Tinqui.ch ohne Registrierung
                                        nutzen?</strong
                                    >Auch wenn Sie ohne Konto nach Anzeigen
                                    suchen und diese durchst&ouml;bern
                                    k&ouml;nnen, m&uuml;ssen Sie sich
                                    registrieren, um Anzeigen zu schalten,
                                    andere Nutzer zu kontaktieren und
                                    Transaktionen auf unserer Plattform
                                    durchzuf&uuml;hren. Die Registrierung ist
                                    schnell, einfach und kostenlos und gibt
                                    Ihnen Zugriff auf alle Funktionen von
                                    Tinqui.ch.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Kaufen auf Tinqui.ch</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Welche Zahlungsoptionen werden
                                        akzeptiert?</strong
                                    >Wir akzeptieren eine Vielzahl sicherer
                                    Zahlungsmethoden, darunter Kredit- und
                                    Debitkarten (Visa, Mastercard, American
                                    Express), Twint und Bank&uuml;berweisung.
                                    Sie k&ouml;nnen Ihre bevorzugte
                                    Zahlungsmethode beim Abschluss eines Kaufs
                                    ausw&auml;hlen.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Was soll ich tun, wenn ich ein Problem
                                        mit einem Kauf habe?</strong
                                    >Wenn Sie ein Problem mit einem Kauf haben,
                                    empfehlen wir Ihnen, zun&auml;chst zu
                                    versuchen, direkt &uuml;ber unser internes
                                    Nachrichtensystem mit dem Verk&auml;ufer
                                    Kontakt aufzunehmen. Wenn Sie das Problem
                                    nicht l&ouml;sen k&ouml;nnen, steht Ihnen
                                    unser Kundenbetreuungsteam zur Seite.
                                    Kontaktieren Sie uns einfach &uuml;ber das
                                    Support-Formular oder senden Sie uns eine
                                    E-Mail an&nbsp;<a
                                        href="mailto:info@tinqui.ch"
                                        >info@tinqui.ch</a
                                    >&nbsp;mit den Details Ihrer Situation.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Verkaufen auf Tinqui.ch</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Wie ver&ouml;ffentliche ich eine
                                        Anzeige zum Verkauf eines
                                        Artikels?</strong
                                    >Um eine Anzeige zu schalten, melden Sie
                                    sich bei Ihrem Konto an und klicken Sie auf
                                    die Schaltfl&auml;che "Anzeige aufgeben".
                                    W&auml;hlen Sie die passende Kategorie
                                    f&uuml;r Ihren Artikel, f&uuml;gen Sie einen
                                    aussagekr&auml;ftigen Titel hinzu, laden Sie
                                    hochwertige Fotos hoch und geben Sie eine
                                    detaillierte Beschreibung an. Legen Sie
                                    einen Preis fest und w&auml;hlen Sie die
                                    Versandoptionen, die Sie anbieten
                                    m&ouml;chten. &Uuml;berpr&uuml;fen Sie Ihre
                                    Anzeige und klicken Sie auf
                                    "Ver&ouml;ffentlichen", wenn Sie fertig
                                    sind.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Wie viel kostet es, eine Anzeige auf
                                        Tinqui.ch zu schalten?</strong
                                    >Das Einstellen einer Anzeige auf Tinqui.ch
                                    ist f&uuml;r 7 Tage v&ouml;llig kostenlos.
                                    Wir berechnen keine Geb&uuml;hren f&uuml;r
                                    das Einstellen oder Verkaufen von Artikeln
                                    auf unserer Plattform. Als Verk&auml;ufer
                                    sind Sie jedoch f&uuml;r die Versandkosten
                                    und alle mit Ihrer gew&auml;hlten
                                    Zahlungsmethode verbundenen Geb&uuml;hren
                                    verantwortlich.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                Um die Verkaufsaktivit&auml;t zu f&ouml;rdern
                                und erschwingliche Optionen anzubieten, kann der
                                Verk&auml;ufer zwischen den folgenden Dauer- und
                                Preisoptionen f&uuml;r seine Anzeigen
                                w&auml;hlen:
                            </p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    Kostenlose Ver&ouml;ffentlichung:
                                    Ver&ouml;ffentlichen Sie Ihre Anzeigen 7
                                    Tage lang kostenlos, ideal f&uuml;r den
                                    Einstieg.
                                </li>
                                <li>
                                    Zahlungsoptionen: Wenn Sie eine l&auml;ngere
                                    Expositionszeit w&uuml;nschen, w&auml;hlen
                                    Sie zwischen 14 Tagen f&uuml;r 3,90 CHF oder
                                    30 Tagen f&uuml;r 6,90 CHF.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p><strong>Sicherheit und Schutz</strong></p>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Wie sch&uuml;tzt Tinqui.ch meine
                                        pers&ouml;nlichen Daten?</strong
                                    >Bei Tinqui.ch nehmen wir den Datenschutz
                                    und die Sicherheit unserer Nutzer sehr
                                    ernst. Wir verwenden fortschrittliche
                                    Verschl&uuml;sselungstechnologie, um Ihre
                                    pers&ouml;nlichen und finanziellen Daten zu
                                    sch&uuml;tzen, und geben Ihre Daten niemals
                                    ohne Ihre ausdr&uuml;ckliche Zustimmung an
                                    Dritte weiter. Weitere Informationen zu
                                    unseren Datenschutzpraktiken finden Sie in
                                    unserer Datenschutzrichtlinie.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <ul class="pad-class">
                                <li>
                                    <strong
                                        >Was soll ich tun, wenn ich einen Betrug
                                        vermute?</strong
                                    >Wenn Sie einen Betrug vermuten, z. B. eine
                                    irref&uuml;hrende Anzeige oder einen
                                    Betrugsversuch, bitten wir Sie, dies
                                    unverz&uuml;glich unserem Sicherheitsteam zu
                                    melden. Sie k&ouml;nnen dies tun, indem Sie
                                    auf den Link "Melden" in der
                                    verd&auml;chtigen Anzeige oder im Profil
                                    klicken oder uns direkt &uuml;ber unser
                                    Support-Formular kontaktieren. Wir
                                    untersuchen alle Meldungen &uuml;ber
                                    verd&auml;chtige Aktivit&auml;ten und
                                    ergreifen schnell Ma&szlig;nahmen, um unsere
                                    Community zu sch&uuml;tzen.
                                </li>
                            </ul>
                            <p>&nbsp;</p>
                            <p>
                                Denken Sie daran: Wenn Sie in unserem
                                FAQ-Bereich nicht die gesuchte Antwort finden,
                                steht Ihnen unser engagiertes
                                Kundenbetreuungsteam jederzeit f&uuml;r
                                pers&ouml;nliche Unterst&uuml;tzung zur
                                Verf&uuml;gung. Z&ouml;gern Sie nicht, uns bei
                                Fragen oder Anliegen zu kontaktieren.
                            </p></span
                        >
                    </ps-label>
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
import PsContentContainer from "@template1/vendor/components/layouts/container/PsContentContainer.vue";
import PsLabelTitle from "@template1/vendor/components/core/label/PsLabelTitle.vue";
import PsLabel from "@template1/vendor/components/core/label/PsLabel.vue";
import PrivacySkeletor from "@template1/vendor/components/modules/privacy/PrivacySkeletor.vue";

import { useAboutUsStoreState } from "@templateCore/store/modules/aboutus/AboutUsStore";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import PsConst from "@templateCore/object/constant/ps_constants";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";

export default {
    name: "FAQView",
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
