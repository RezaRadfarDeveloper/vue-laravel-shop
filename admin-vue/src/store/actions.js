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

export const getProducts = (
    { commit },
    { url = null, search = "", perPage = 10 },
) => {
    commit("setProducts", [true]);
    url = url || "/product";
    return axiosClient
        .get(url, {
            params: { search, per_page: perPage },
        })
        .then((response) => {
            console.log(response.data);

            commit("setProducts", [false, response.data]);
        })
        .catch((err) => {
            commit("setProducts", [false]);
        });
};
