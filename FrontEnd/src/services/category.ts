import api from "./api";

// ✅ model Category
export interface Category {
  id: number;
  tentheloai: string;
  nhom?: string;
  image?: string;
  description?: string;
  status: boolean;
  created_at?: string;
  updated_at?: string;
}

// ✅ payload create/update
export interface CategoryPayload {
  tentheloai: string;
  nhom?: string;
  image?: string;
  description?: string;
  status?: boolean;
}

// ✅ response list
export interface CategoryListResponse {
  data: Category[];
}

// ✅ response single
export interface CategoryResponse {
  data: Category;
}

//
// 🚀 API
//

// 📌 Lấy danh sách
export const getCategories = () =>
  api.get<CategoryListResponse>("/user/categories");

// 📌 Lấy chi tiết
// export const getCategory = (id: number) =>
//   api.get<CategoryResponse>(`/categories/${id}`);

// // 📌 Thêm mới
// export const createCategory = (data: CategoryPayload) =>
//   api.post<CategoryResponse>("/categories", data);

// // 📌 Cập nhật
// export const updateCategory = (id: number, data: CategoryPayload) =>
//   api.put<CategoryResponse>(`/categories/${id}`, data);

// // 📌 Xoá
export const deleteCategory = (id: number) =>
  api.delete(`/user/categories/${id}`);