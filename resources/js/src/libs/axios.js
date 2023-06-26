import Vue from 'vue'

// axios
import axios from 'axios'
import router from '../router'

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: process.env.MIX_API_URL,
  // timeout: 1000,
  headers: {
    Authorization: `Bearer ${localStorage.getItem('accessToken') || null}`,
  },
})

axiosIns.interceptors.response.use( (response)=> {
    return response.data;
}, (error)=> {
    return Promise.reject(error);
});


Vue.prototype.$http = axiosIns

export default axiosIns
