<template>
    <span @click="sortProduct(field)"> <slot></slot></span>
    <template v-if="sortField === field">
        <svg
            v-if="sortDirection === 'desc'"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.75 17.25 12 21m0 0-3.75-3.75M12 21V3"
            />
        </svg>
        <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.25 6.75 12 3m0 0 3.75 3.75M12 3v18"
            />
        </svg>
    </template>
</template>

<script>
export default {
    props: ["field", "sortField", "sortDirection"],
    emits: ["sort-product"],
    setup(props, { emit }) {
        const sortProduct = (field) => {
            emit("sort-product", field);
        };
        return { sortProduct };
    },
};
</script>
