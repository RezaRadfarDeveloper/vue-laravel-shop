import axiosClient from "../axios";
import router from "../router";

export const getUser = ({ commit }) => {
    return axiosClient.get("/user").then((response) => {
        commit("setUser", response.data);
        return response;
    });
};

export const login = ({ commit }, data) => {
    return axiosClient.post("/login", data).then(({ data }) => {
        commit("setUser", data.user);
        commit("setToken", data.token);
        console.log(data);

        return data;
    });
};

export const logout = ({ commit }) => {
    return axiosClient.post("/logout").then((response) => {
        commit("setToken", null);
        return response;
    });
};
