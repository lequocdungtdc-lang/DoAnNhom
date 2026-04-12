import axios, { type InternalAxiosRequestConfig } from "axios";

const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

// ✅ Request interceptor
api.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
        const token = localStorage.getItem("token");

        if (token) {
            config.headers = config.headers || {};
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => Promise.reject(error)
);

// 🔥 Response interceptor (THÊM CÁI NÀY)
api.interceptors.response.use(
    (res) => res,
    (err) => {
        if (err.response?.status === 401) {
            // 🔥 token hết hạn / sai → logout
            localStorage.removeItem("token");
            localStorage.removeItem("user");

            window.location.href = "/login";
        }
        return Promise.reject(err);
    }
);

export default api;