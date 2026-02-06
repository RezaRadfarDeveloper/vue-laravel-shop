export const setUser = (state, user) => {
    state.user.data = user;
};

export const setToken = (state, token) => {
    state.user.token = token;
    if (token) {
        sessionStorage.setItem("TOKEN", token);
    } else {
        sessionStorage.removeItem("TOKEN");
    }
};

export const setProducts = (state, [loading, response = null]) => {
    if (response) {
        state.products.data = response.data;
        state.products.links = response.meta.links;
        state.products.from = response.meta.from;
        state.products.to = response.meta.to;
        state.products.total = response.meta.total;
        state.products.limit = response.meta.per_page;
        state.products.page = response.meta.current_page;
    }
    state.products.isLoading = loading;
};
