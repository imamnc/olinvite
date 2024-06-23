const { createApp, ref, reactive, onMounted } = Vue;

createApp({
    setup() {
        // Import tools
        const utils = reactive(tools);

        // Theme tools
        const theme = {
            setImageCover: () => {
                if (custom_field.value.image_cover) {
                    document.getElementById(
                        "cover"
                    ).style.backgroundImage = `url(${custom_field.value.image_cover})`;
                }
            },
            setInvitationBackground: () => {
                if (custom_field.value.invitation_background) {
                    document.body.style.backgroundImage = `url(${custom_field.value.invitation_background})`;
                }
            },
            setWishBackground: () => {
                if (custom_field.value.wish_background) {
                    document.getElementById(
                        "rsvp"
                    ).style.backgroundImage = `url(${custom_field.value.wish_background})`;
                }
            },
        };

        // Recipient data
        const guest = ref(null);
        // Invitation data
        const invitation = ref(null);
        // Carousels data
        const carousels = ref([]);
        // Stories data
        const stories = ref([]);
        // Galleries data
        const galleries = ref([]);
        // Messages data
        const wishes = ref([]);
        // Gifts data
        const gifts = ref([]);
        // Cusrom field
        const custom_field = ref(null);

        // Features
        const features = reactive({
            quotes_feature: false,
            video_feature: false,
            akad_feature: false,
            reception_feature: false,
            gift_feature: false,
            gallery_feature: false,
            wish_feature: false,
            rsvp_feature: false,
            story_feature: false,
            music_feature: false,
            custom_music_feature: false,
        });

        // Music
        const music = {
            instance: null,
            playing: ref(false),
            start: () => {
                music.instance.play();
                music.instance.addEventListener(
                    "ended",
                    () => {
                        music.instance.currentTime = 0;
                        music.instance.play();
                    },
                    false
                );
                music.playing.value = true;
            },
            pause: () => {
                music.instance.pause();
                music.playing.value = false;
            },
            resume: () => {
                music.instance.play();
                music.playing.value = true;
            },
            trigger: () => {
                if (music.playing.value) {
                    music.pause();
                } else {
                    music.resume();
                }
            },
            init: () => {
                if (features.music_feature == true) {
                    music.instance = new Audio(
                        invitation.value?.music?.file_path
                    );
                } else if (features.custom_music_feature == true) {
                    music.instance = new Audio(
                        invitation.value?.custom_music_path
                    );
                }
            },
        };

        // Countdown
        const countdown = reactive({
            day: 0,
            hour: 0,
            minute: 0,
            second: 0,
            counter: null,
            start: () => {
                countdown.counter = setInterval(async () => {
                    var response = await utils.countingDown(
                        invitation.value.wedding_data.countdown_date
                    );
                    if (response.distance >= 0) {
                        countdown.day = response.day;
                        countdown.hour = response.hour;
                        countdown.minute = response.minute;
                        countdown.second = response.second;
                    } else {
                        clearInterval(countdown.counter);
                    }
                }, 1000);
            },
        });

        // Open cover
        const openCover = () => {
            utils.openCover();
            music.start();
        };

        // RSVP
        const rsvp = {
            form: reactive({
                invitation_id: null,
                guest_id: null,
                person: null,
                confirmation: "",
            }),
            error: reactive({
                person: null,
                confirmation: null,
            }),
            save: async () => {
                try {
                    rsvp.resetError();
                    await tools.sendRsvp(rsvp.form);
                } catch (error) {
                    if (error.response.status == 422) {
                        if (error.response.data.data) {
                            rsvp.resetError();
                            for (const key in error.response.data.data) {
                                const item = error.response.data.data[key];
                                rsvp.error[key] = item[0];
                            }
                        }
                    } else {
                        tools.toast("error", error.response.data.message);
                    }
                    return;
                }
                // Toast success
                Swal.fire({
                    position: "center",
                    icon: "success",
                    html: `<h2 class="pb-3">Konfirmasi kehadiran disimpan</h2>`,
                    showConfirmButton: false,
                    timer: 2000,
                });
            },
            resetPerson: () => {
                rsvp.form.person = null;
            },
            resetError: () => {
                for (const key in rsvp.error) {
                    rsvp.error[key] = null;
                }
            },
            init: () => {
                rsvp.form.invitation_id = invitation.value.id;
                rsvp.form.guest_id = guest.value.id;
                rsvp.form.confirmation = guest.value.rsvp?.confirmation;
                rsvp.form.person = guest.value.rsvp?.person
                    ? guest.value.rsvp?.person
                    : "";
            },
        };

        // Wish
        const wishForm = reactive({
            name: guest?.name,
            message: null,
            time: utils.dateTime(),
        });
        const sendWish = async () => {
            wishForm.time = utils.dateTime();
            wishes.value.unshift(utils.getRawObj(wishForm));
            wishForm.message = null;
        };

        // QR Code
        const qrcode = reactive({
            payload: null,
            modal: null,
            open: () => {
                document.getElementById("qrcode-name").innerText =
                    guest.value.name;
                tools.showQR(qrcode.payload);
                qrcode.modal.show();
                console.log("oke");
            },
            initModal: () => {
                qrcode.modal = new bootstrap.Modal(
                    document.getElementById("qrcode-modal")
                );
            },
            setPayload: () => {
                console.log(guest.value);
                qrcode.payload = guest.value.qrcode.toString();
            },
        });

        // Get invitation
        const loadInvitation = async () => {
            var result = await utils.getInvitation();
            // Set invitation data
            invitation.value = result.data.data.invitation;
            // Set wedding data
            var wedding_data = invitation.value.wedding_data;
            // Set guest
            guest.value = result.data.data.guest;
            // Set features
            features.quotes_feature = wedding_data.quotes_feature;
            features.video_feature = wedding_data.video_feature;
            features.akad_feature = wedding_data.akad_feature;
            features.reception_feature = wedding_data.reception_feature;
            features.gift_feature = wedding_data.gift_feature;
            features.gallery_feature = wedding_data.gallery_feature;
            features.rsvp_feature = wedding_data.rsvp_feature;
            features.wish_feature = wedding_data.wish_feature;
            features.story_feature = wedding_data.story_feature;
            features.music_feature = wedding_data.music_feature;
            features.custom_music_feature = wedding_data.custom_music_feature;
            // Set carousels data
            carousels.value = wedding_data.galleries;
            // Set galleries data
            galleries.value = wedding_data.galleries;
            // Set stories data
            stories.value = wedding_data.stories;
            // Set gifts data
            gifts.value = wedding_data.gift_channels;
            // Set wishes
            wishes.value = invitation.value?.wishes;
            // Set music data
            music.init();
            // Set custom field
            custom_field.value = wedding_data.custom_field;
        };

        // Mounted
        onMounted(async () => {
            // Load invitation
            await loadInvitation();
            // Init Page
            initPage();
            // Start countdown
            countdown.start();
            // Set image cover
            theme.setImageCover();
            // Set invitation background
            theme.setInvitationBackground();
            // Set wish background
            theme.setWishBackground();
            // Set rsvp form
            rsvp.init();
            // Init qrcode modal
            qrcode.initModal();
            qrcode.setPayload();
        });

        // Export
        return {
            utils,
            invitation,
            carousels,
            stories,
            wishes,
            galleries,
            rsvp,
            wishForm,
            guest,
            gifts,
            music,
            features,
            custom_field,
            countdown,
            qrcode,
            sendWish,
            openCover,
        };
    },
}).mount("#root");
