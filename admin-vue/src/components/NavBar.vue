<template>
    <div><strong>Logged in as:</strong> {{ currentUser.name }}</div>
</template>

<script>
import { computed } from "vue";
import store from "../store";

export default {
    setup() {
        const currentUser = computed(() => store.state.user.data);

        return {
            currentUser,
        };
    },
};
</script>
