/*========================================================
 TOOLS METHOD
========================================================*/
/* TOOLS */
const tools = {
    // Open cover
    openCover: () => {
        // Slide up
        $("#cover").slideUp();
        // Remove no scroll class
        let body = document.querySelector("body");
        body.classList.remove("no-scroll");
    },
    // Get invitation data
    getInvitation: async () => {
        try {
            var response = await axios.get(window.location.href);
        } catch (error) {
            var response = error;
        }
        return response;
    },
    // Get messages
    getMessages: async () => {
        try {
            var message_path = "/storage/theme/assets/theme1/wish.json";
            var response = await axios.get(message_path);
        } catch (error) {
            var response = error;
        }
        return response;
    },
    // Get datetime
    dateTime: (datetime = null) => {
        if (datetime) {
            return moment(datetime).format("YYYY-MM-DD HH:mm:ss");
        } else {
            return moment().format("YYYY-MM-DD HH:mm:ss");
        }
    },
    // Get date
    date: (date = null) => {
        if (date) {
            return moment(date).format("YYYY-MM-DD");
        } else {
            return moment().format("YYYY-MM-DD");
        }
    },
    // Get date
    dateFormat: (date = null, format = "YYYY-MM-DD") => {
        if (date) {
            return moment(date).format(format);
        } else {
            return null;
        }
    },
    // Get raw object
    getRawObj: (data) => {
        return JSON.parse(JSON.stringify(data));
    },
    // Toast
    toast: (type, message) => {
        Swal.fire({
            position: "top-end",
            icon: type,
            title: message,
            showConfirmButton: false,
            toast: true,
            timer: 2000,
        });
    },
};

/*========================================================
 PAGE INIT
========================================================*/
const page = {
    initAos: () => {
        AOS.init({
            // Global settings:
            disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            startEvent: "DOMContentLoaded", // name of the event dispatched on the document, that AOS should initialize on
            initClassName: "aos-init", // class applied after initialization
            animatedClassName: "aos-animate", // class applied on animation
            useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)
            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 1000, // values from 0 to 3000, with step 50ms
            easing: "ease", // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: "center-bottom", // defines which position of the element regarding to window should trigger the animation
        });
    },
    initInputMask: () => {
        // Activate (Mask) Number Format
        Inputmask.extendAliases({
            number: {
                prefix: "",
                groupSeparator: ",",
                alias: "numeric",
                placeholder: "",
                autoGroup: !0,
                digits: 0,
                digitsOptional: !1,
                clearMaskOnLostFocus: !1,
            },
        });
        var numberformatel = document.querySelectorAll(
            '[data-mask="numberformat"]'
        );
        var numberformatmask = new Inputmask({
            alias: "number",
        });
        numberformatel.forEach((el) => {
            numberformatmask.mask(el);
        });

        // Activate (Mask) Integer
        var integerel = document.querySelectorAll('[data-mask="integer"]');
        var integermask = new Inputmask({
            alias: "numeric",
            allowMinus: false,
            min: 0,
            max: 9999,
        });
        integerel.forEach((el) => {
            numberformatmask.mask(el);
        });

        // Activate (Mask) Decimal
        var decimalel = document.querySelectorAll('[data-mask="decimal"]');
        var decimalmask = new Inputmask({
            alias: "numeric",
            allowMinus: false,
            digits: 2,
        });
        decimalel.forEach((el) => {
            numberformatmask.mask(el);
        });

        // Activate (Mask) Phone
        var phoneel = document.querySelectorAll('[data-mask="phone"]');
        var phonemask = new Inputmask({
            mask: "+62999999999999",
            placeholder: "",
        });
        phoneel.forEach((el) => {
            numberformatmask.mask(el);
        });
    },
    initGallery: () => {
        new Viewer(document.getElementById("gallery-box"));
    },
    initScrollSpy: () => {
        const navLinks = document.querySelectorAll(".navigation-item");
        for (let n in navLinks) {
            if (navLinks.hasOwnProperty(n)) {
                navLinks[n].addEventListener("click", (e) => {
                    e.preventDefault();
                    if (document.querySelector(navLinks[n].hash)) {
                        document
                            .querySelector(navLinks[n].hash)
                            .scrollIntoView({
                                behavior: "smooth",
                            });
                    }
                });
            }
        }
    },
    updateNavigationOnScroll: () => {
        const sections = document.querySelectorAll(".segment");
        window.onscroll = () => {
            const scrollPos =
                document.documentElement.scrollTop || document.body.scrollTop;
            for (let s in sections)
                if (
                    sections.hasOwnProperty(s) &&
                    sections[s].offsetTop <= scrollPos + 10
                ) {
                    const id = sections[s].id;
                    if (document.querySelector(".navigation-item.active")) {
                        document
                            .querySelector(".navigation-item.active")
                            .classList.remove("active");
                    }
                    if (
                        document.querySelector(`.navigation-item[href*=${id}]`)
                    ) {
                        document
                            .querySelector(`.navigation-item[href*=${id}]`)
                            .classList.add("active");
                    }
                }
        };
    },
    initCarousel: () => {
        /* Main Carousel */
        const main_carousel = new bootstrap.Carousel("#main-carousel", {
            interval: 3000,
        });

        /* Story Carousel */
        const story_carousel = new bootstrap.Carousel("#story-carousel", {
            interval: 3000,
        });
    },
};

// INIT PAGE
const initPage = () => {
    page.initAos();
    page.initInputMask();
    page.initGallery();
    page.initScrollSpy();
    page.updateNavigationOnScroll();
    page.initCarousel();
};
