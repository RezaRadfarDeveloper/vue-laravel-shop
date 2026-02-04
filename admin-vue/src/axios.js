import axios from "axios";
import router from "./router";
import store from "./store";

const axiosClient = axios.create({
    baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`,
});

axiosClient.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;

    return config;
});

axiosClient.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        console.log(error);

        if (error.response.status === 401) {
            sessionStorage.removeItem("TOKEN");
            router.push({ name: "login" });
        }
        throw error;
    },
);

export default axiosClient;
