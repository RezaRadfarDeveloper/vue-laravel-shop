const state = {
    user: {
        token: sessionStorage.getItem("TOKEN"),
        data: {},
    },
    products: {
        isLoading: false,
        data: [],
        from: null,
        to: null,
        limit: null,
        page: 1,
        links: [],
        total: null,
    },
};

export default state;
