import axiosClient from "../axios";

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
    { url = null, search = "", perPage = 10, sort_field, sort_direction },
) => {
    commit("setProducts", [true]);
    url = url || "/products";
    return axiosClient
        .get(url, {
            params: { search, per_page: perPage, sort_field, sort_direction },
        })
        .then((response) => {
            console.log(response.data);

            commit("setProducts", [false, response.data]);
        })
        .catch((err) => {
            commit("setProducts", [false]);
        });
};

export const createProduct = ({ commit }, product) => {
    console.log(product.image instanceof File);
    console.log(product);

    if (product.image instanceof File) {
        const form = new FormData();
        form.append("title", product.title);
        form.append("price", product.price);
        form.append("image", product.image);
        form.append("description", product.description);
        product = form;
    }

    return axiosClient.post("products", product);
};

export const updateProduct = ({ commit }, product) => {
    const id = product.id;
    if (product.image instanceof File) {
        const form = new FormData();
        form.append("id", product.id);
        form.append("title", product.title);
        form.append("price", product.price);
        form.append("image", product.image);
        form.append("description", product.description);
        form.append("_method", "PUT");
        product = form;
    } else {
        product._method = "PUT";
    }

    return axiosClient.post(`products/${id}`, product);
};
