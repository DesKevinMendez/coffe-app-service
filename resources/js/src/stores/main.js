import { defineStore } from "pinia";
import axios from "axios";

export const useMainStore = defineStore("main", {
    state: () => ({
        /* User */
        userName: null,
        userEmail: null,
        userAvatar: null,

        /* SnackBar */
        messages: [],

        /* Field focus with ctrl+k (to register only once) */
        isFieldFocusRegistered: false,

        /* Sample data (commonly used) */
        clients: [
            {
                id: 19,
                avatar: "https://avatars.dicebear.com/v2/gridy/Howell-Hand.svg",
                login: "percy64",
                name: "Howell Hand",
                company: "Kiehn-Green",
                city: "Emelyside",
                progress: 70,
                created: "Mar 3, 2021",
                created_mm_dd_yyyy: "03-03-2021",
            },
        ],
        history: [],
        products: [],
        updates: [],
        updatesStatus: false,
    }),
    actions: {
        setUser(payload) {
            if (payload.name) {
                this.userName = payload.name;
            }
            if (payload.email) {
                this.userEmail = payload.email;
            }
            if (payload.avatar) {
                this.userAvatar = payload.avatar;
            }
        },

        pushMessage(text) {
            this.messages.push({ ts: Date.now(), text });
        },

        shiftMessage() {
            this.messages.shift();
        },

        fetch(sampleDataKey) {
            console.log(sampleDataKey);
        },
    },
});
