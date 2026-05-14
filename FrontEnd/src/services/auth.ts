import api from "./api";

// ✅ payload
export interface LoginPayload {
   email: string;
   password: string;
}

// ✅ user
export interface User {
   id: number;
   fullname: string;
   email: string;
   phone?: string;
   address?: string;
   role: string;
}

// ✅ response chuẩn backend bạn
export interface AuthResponse {
   token: string;
   user: User;
}

// ✅ API

export const login = (data: LoginPayload) =>
   api.post<AuthResponse>("/user/login", data);

export const getProfile = () =>
   api.get<{ user: User }>("/user/profile");

export const updateProfile = (data: Partial<User>) =>
   api.post<{ user: User }>("/user/update-profile", data);

export const logout = () =>
   api.post("/user/logout");