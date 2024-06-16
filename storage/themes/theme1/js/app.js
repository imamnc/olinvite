const { createApp, ref, reactive, onMounted } = Vue;

createApp({
    setup() {
        // Import tools
        const utils = tools;

        // Recipient data
        const guest = reactive({
            id: 1,
            name: "Kacoon",
            phone: "+6285735692321",
        });

        // Invitation data
        const invitation = ref(null);

        // Messages data
        const messages = ref([]);

        // Galleries data
        const galleries = ref([
            "https://i.pinimg.com/originals/cf/76/6d/cf766d99e48b76c954401fa548b40cf4.jpg",
            "https://i0.wp.com/heikamu.com/wp-content/uploads/2021/02/Pre-Wedding-Casual-Photo-by-Ella-Nofia-Ramadiyanti-on.jpg?ssl=1",
            "https://i.pinimg.com/736x/5e/21/d8/5e21d8f1d4d6a23a5a3401518ac16fd9.jpg",
            "https://i.pinimg.com/originals/11/27/04/1127043bed2f746c97bfa3735aaba0e3.jpg",
            "https://i.pinimg.com/originals/89/51/b5/8951b50361de315d0c8cb0cdb0aad3b8.jpg",
        ]);

        // Gifts data
        const gifts = ref([
            {
                bank_thumbnails:
                    "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png",
                bank: "bca",
                name: "Imam Nurcholis",
                number: "00188277182992",
            },
            {
                bank_thumbnails:
                    "https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/2560px-BNI_logo.svg.png",
                bank: "bni",
                name: "Kacoon",
                number: "71788277199203",
            },
            {
                bank_thumbnails:
                    "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/2560px-Bank_Mandiri_logo_2016.svg.png",
                bank: "mandiri",
                name: "Imam Nurcholis",
                number: "01092837726111",
            },
        ]);

        // Music
        const music = {
            instance: new Audio(
                "/storage/theme/assets/theme1/sound/default.mp3"
            ),
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
        };

        // Open cover
        const openCover = () => {
            utils.openCover();
            music.start();
        };

        // Get invitation
        const loadInvitation = async () => {
            var result = await utils.getInvitation();
            invitation.value = result.data.data.invitation;
            guest.name = result.data.data.guest;
            console.log(invitation.value);
        };

        // Get messages
        const loadMessages = async () => {
            var result = await utils.getMessages();
            messages.value = result.data;
        };

        // Send message
        const messageForm = reactive({
            name: guest.name,
            message: null,
            time: utils.dateTime(),
        });
        const sendMessage = async () => {
            messageForm.time = utils.dateTime();
            messages.value.unshift(utils.getRawObj(messageForm));
            messageForm.message = null;
        };

        // Send message
        const sendConfirmation = async () => {
            Swal.fire({
                position: "center",
                icon: "success",
                html: `<h2 class="pb-3">Konfirmasi kehadiran disimpan</h2>`,
                showConfirmButton: false,
                timer: 2000,
            });
        };

        // Copy
        const copyText = async (text) => {
            try {
                await navigator.clipboard.writeText(text);
                utils.toast("success", "Rekening telah disalin");
            } catch (err) {
                console.error("Failed to copy: ", err);
                utils.toast("error", "Gagal menyalin rekening !");
            }
        };

        // Mounted
        onMounted(async () => {
            await loadInvitation();
            await loadMessages(); // Load messages
            initPage(); // Init Page
        });

        // Export
        return {
            utils,
            invitation,
            messages,
            messageForm,
            guest,
            gifts,
            galleries,
            music,
            sendMessage,
            sendConfirmation,
            openCover,
            copyText,
        };
    },
}).mount("#root");
