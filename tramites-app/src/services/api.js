import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-Type": "application/json"
  }
});

export const institucionService = {
    getAll: () => api.get("/instituciones"),
    create: (data) => api.post('/instituciones', data),
}

export const tramiteService = {
    getAll: (params) => api.get("/tramites", { params }),
    getById: (id) => api.get(`/tramites/${id}`),
    create: (data) => api.post('/tramites', data),
    update: (id, data) => api.put(`/tramites/${id}`, data),
    desactivate: (id) => api.delete(`/tramites/${id}`),
}