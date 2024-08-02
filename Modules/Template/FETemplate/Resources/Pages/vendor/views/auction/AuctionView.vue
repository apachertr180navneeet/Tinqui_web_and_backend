<template>
    <Head :title="$t('profile__go_live')" />
    <div class="sm:mt-32 lg:mt-36 mt-28 mb-16 px-3 xl:px-32 mx-auto">
        <div class="flex flex-wrap w-full">
            <div v-if="!isMeetEnd">
                <h4 class="text-feError-400 text-xl mb-3">
                    {{ $t("auction_end")
                    }}<span class="font-bold"
                        >{{ minutes < 10 ? "0" + minutes : minutes }}:{{
                            seconds < 10 ? "0" + seconds : seconds
                        }}</span
                    >
                    *
                </h4>
                <div id="jitsiContainer"></div>
            </div>
            <div v-else class="flex flex-wrap justify-center items-center">
                <h3>{{ $t("auction_ended") }}</h3>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Head } from "@inertiajs/vue3";
import PsFrontendLayout from "@template1/vendor/components/layouts/container/PsFrontendLayout.vue";
import { useUserStore } from "@templateCore/store/modules/user/UserStore";
import { PsValueStore } from "@templateCore/store/modules/core/PsValueStore";
import { useProductStore } from "@templateCore/store/modules/item/ProductStore";
import { onMounted, ref } from "vue";
import AuctionItem from "@templateCore/object/AuctionItem";
import { router } from "@inertiajs/vue3";

export default {
    name: "GoLive",
    components: {
        Head,
    },
    props: ["mobileSetting", "query"],
    layout: PsFrontendLayout,
    setup(props) {
        let itemId = props.query.item_id;
        let hostId = props.query.host_id;
        const psValueStore = new PsValueStore();
        const loginUserId = psValueStore.getLoginUserId();
        const userStore = useUserStore();
        const productStore = useProductStore("detail");
        let is_host = ref(false);
        let itemInfo: AuctionItem = ref({});
        let minutes = ref(30);
        let seconds = ref(0);
        let isMeetEnd = ref(false);

        onMounted(async () => {
            await userStore.loadUser(loginUserId);
            let data = await productStore.loadItem(itemId, loginUserId);
            itemInfo.value = data.data;
            is_host.value =
                itemInfo.value.addedUserId?.toString() ===
                loginUserId?.toString()
                    ? true
                    : false;
            // console.log(itemInfo.value);
            const targetDate = new Date(itemInfo.value.addedDate);
            const currentDate = new Date();
            currentDate.setHours(currentDate.getHours() - 5);
            currentDate.setMinutes(currentDate.getMinutes() - 30);
            const timeDifferenceMs =
                currentDate.getTime() - targetDate.getTime();
            const timeDifferenceSec = Math.floor(timeDifferenceMs / 1000);
            // console.log(
            //     timeDifferenceSec,
            //     "timeDifferenceSec",
            //     currentDate,
            //     targetDate
            // );
            if (timeDifferenceSec < 1800) {
                minutes.value = 29 - Math.floor(timeDifferenceMs / (1000 * 60));
                seconds.value =
                    60 - Math.floor((timeDifferenceMs % (1000 * 60)) / 1000);
                let counter = setInterval(() => {
                    if (seconds.value === 0) {
                        if (minutes.value > 0) {
                            seconds.value = 59;
                            minutes.value = minutes.value - 1;
                        } else {
                            clearInterval(counter);
                        }
                    } else {
                        seconds.value = seconds.value - 1;
                    }
                }, 1000);
                const script = document.createElement("script");
                script.src = "https://8x8.vc/external_api.js";
                script.async = true;
                script.onload = () => {
                    const domain = "8x8.vc";
                    const options = {
                        roomName: `vpaas-magic-cookie-bf2e6df6ca2949bfa006a61ddfbc0247/${itemId.toString()}`, // Change this to your desired room name
                        width: '100%',
                        height: 600,
                        parentNode: document.getElementById("jitsiContainer"),
                        jwt: itemInfo.value.jitsiToken,
                        configOverwrite: {
                            prejoinPageEnabled: false,
                            enableLobbyChat: false,
                            hideMuteAllButton: is_host.value ? false : true,
                            disableInviteFunctions: true,
                            lobby: {
                                enableLobbyChat: false,
                            },
                            hideLobbyButton: true,
                        },
                        interfaceConfigOverwrite: {
                            TOOLBAR_BUTTONS: is_host
                                ? ["microphone", "camera", "hangup"]
                                : ["hangup"],
                        },
                        userInfo: {
                            email: userStore.user?.data?.userEmail,
                            displayName: userStore.user?.data?.userName,
                            userId: loginUserId,
                        },
                    };
                    let api = new JitsiMeetExternalAPI(domain, options);

                    const participants = api.getParticipantsInfo();
                    // console.log(participants);
                    participants.forEach((participant) => {
                        if (
                            participant.userId == hostId ||
                            participant.userId == itemInfo.value.addedUserId
                        ) {
                            api.executeCommand(
                                "grantModerator",
                                participant.id
                            );
                        } else {
                            api.executeCommand("toggleVideo");
                            api.executeCommand("toggleAudio");
                        }
                    });

                    function startMeetingTimer(durationInMinutes: number) {
                        const durationInMillis = durationInMinutes * 60 * 1000; // Convert minutes to milliseconds
                        setTimeout(async () => {
                            // console.log("hang up");
                            let res = productStore.updateAuctionStatus(
                                itemId,
                                loginUserId
                            );
                            // console.log(res);

                            api.executeCommand("endConference");
                            api.executeCommand("hangup");
                            isMeetEnd.value = true;
                            // if (res.status == "success") {
                            //   router.get(route("dashboard"))
                            // } else {
                            //   router.get(route("dashboard"))
                            // }
                        }, durationInMillis);
                    }
                    api.addListener("participantLeft", (event) => {
                        const { id, displayName, formattedDisplayName, role } =
                            event;
                        // console.log(
                        //     "hang up",
                        //     id,
                        //     displayName,
                        //     formattedDisplayName,
                        //     role
                        // );
                        if (role === "moderator") {
                            let res = productStore.updateAuctionStatus(
                                itemId,
                                loginUserId
                            );
                            // console.log(res);
                            api.executeCommand("endConference");
                            api.executeCommand("hangup");
                            isMeetEnd.value = true;
                            // if (res.status == "success") {
                            //   router.get(route("dashboard"))
                            // } else {
                            //   router.get(route("dashboard"))
                            // }
                        }
                    });
                    startMeetingTimer(30);
                };
                document.body.appendChild(script);
            } else {
                isMeetEnd.value = true;
            }
        });
        return {
            minutes,
            seconds,
            itemInfo,
            is_host,
            isMeetEnd,
        };
    },
};
</script>
