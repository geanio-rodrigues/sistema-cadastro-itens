import axios from "axios";

const api = axios.create({
    baseURL: '/api', // O proxy do Vite cuidará do resto
    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
});

export default api;