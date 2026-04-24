import api from "./api";

// ✅ Model Album
export interface Album {
  id: number;
  tenalbum: string;       // Đổi từ tentheloai -> tenalbum
  casi_id?: number;       // Thêm trường ID ca sĩ (nếu có)
  image?: string;
  description?: string;
  status: boolean;
  created_at?: string;
  updated_at?: string;
}

// ✅ Payload Create/Update
export interface AlbumPayload {
  tenalbum: string;
  casi_id?: number;
  image?: string;
  description?: string;
  status?: boolean;
}

// ✅ Response List
export interface AlbumListResponse {
  data: Album[];
}

// ✅ Response Single
export interface AlbumResponse {
  data: Album;
}

//
// 🚀 API Albums
//

// 📌 Lấy danh sách Album
export const getAlbums = () =>
  api.get<AlbumListResponse>("/user/albums");

// 📌 Lấy chi tiết Album
export const getAlbum = (id: number) =>
  api.get<AlbumResponse>(`/admin/albums/${id}`);

// 📌 Thêm mới Album
export const createAlbum = (data: AlbumPayload) =>
  api.post<AlbumResponse>("/admin/albums", data);

// 📌 Cập nhật Album
export const updateAlbum = (id: number, data: AlbumPayload) =>
  api.put<AlbumResponse>(`/admin/albums/${id}`, data);

// 📌 Xoá Album
export const deleteAlbum = (id: number) =>
  api.delete(`/admin/albums/${id}`);