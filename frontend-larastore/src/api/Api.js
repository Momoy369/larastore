// Import Axios
import axios from 'axios'

const Api = axios.create({
    // Set default endpoint API
    baseURL: 'http://localhost:8000/api'
});

export default Api