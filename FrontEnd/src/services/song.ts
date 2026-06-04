import api from "./api";

// ✅ model Song
export interface Song {
    id: number;
    tenbaihat: string;
    nghesi: string;
    theloai: string;
    file_amthanh: string;
    anh_daidien?: string;
    created_at?: string;
    updated_at?: string;
}

// ✅ payload create/update
export interface SongPayload {
    tenbaihat: string;
    nghesi: string;
    theloai: string;
    file_amthanh: string;
    anh_daidien?: string;
}

// ✅ response list
export interface SongListResponse {
    data: Song[];
}

// ✅ response single
export interface SongResponse {
    data: Song;
}

//
// 🚀 API
//

// 📌 Lấy danh sách
export const getSongs = () =>
    api.get<SongListResponse>("/user/songs");

// 📌 Lấy chi tiết
// export const getSong = (id: number) =>
//   api.get<SongResponse>(`/songs/${id}`);

// 📌 Thêm mới
// export const createSong = (data: SongPayload) =>
//   api.post<SongResponse>("/songs", data);

// 📌 Cập nhật
// export const updateSong = (id: number, data: SongPayload) =>
//   api.put<SongResponse>(`/songs/${id}`, data);

// 📌 Xoá
// export const deleteSong = (id: number) =>
//   api.delete(`/songs/${id}`);