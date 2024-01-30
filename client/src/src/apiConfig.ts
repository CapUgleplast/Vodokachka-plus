import axios from 'axios';
import router from "@/router";


const fetchAxios = axios.create({
    baseURL: 'http://localhost:8000/', // Replace with your API endpoint
    headers: {
        'Content-Type': 'application/json', // Set the default content type for request headers
    },
});

fetchAxios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response && error.response.status === 401) {
            router.push('/login');
        }
        return Promise.reject(error);
    }
);

export default fetchAxios;