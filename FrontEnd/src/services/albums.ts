import api from "./api";

// ✅ Model Album - Khớp hoàn toàn với Laravel Backend
export interface Album {
  id: number;
  ten_album: string;   // Đã sửa cho khớp Backend
  nghe_si: string;     // Thay casi_id bằng nghe_si (dạng string/id tùy DB của bạn)
  anh_bia?: string;    // Thay image bằng anh_bia
  status: boolean;
  created_at?: string;
  updated_at?: string;
}

// ✅ Payload khi gửi lên (Create/Update)
export interface AlbumPayload {
  ten_album: string;
  nghe_si: string;
  anh_bia?: string;
  status?: boolean;
}

// ✅ Các Interface Response giữ nguyên cấu trúc
export interface AlbumListResponse {
  data: Album[];
}

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
  api.post<AlbumResponse>("/user/albums", data);

// 📌 Cập nhật Album
export const updateAlbum = (id: number, data: AlbumPayload) =>
  api.put<AlbumResponse>(`/admin/albums/${id}`, data);

// 📌 Xoá Album
export const deleteAlbum = (id: number) =>
  api.delete(`/admin/albums/${id}`);