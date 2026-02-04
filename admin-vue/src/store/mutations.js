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
